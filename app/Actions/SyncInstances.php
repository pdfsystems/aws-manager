<?php

namespace App\Actions;

use App\Models\Instance;
use Aws\Laravel\AwsFacade;
use Aws\Result;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use InvalidArgumentException;
use Lorisleiva\Actions\Concerns\AsAction;
use RuntimeException;

class SyncInstances
{
    use AsAction;

    public string $commandSignature = 'instance:sync';

    public string $commandDescription = 'Syncs EC2 instances';

    public function handle(): Collection
    {
        $client = AwsFacade::createEc2();

        return $this->processInstances(
            $client->describeInstances()
        );
    }

    public function asController(Request $request): void
    {
        $this->handle();
    }

    public function asCommand(Command $command): void
    {
        $instances = $this->handle();

        $command->info("Synced {$instances->count()} instances");
    }

    public function asListener($event): void
    {
        $this->handle();
    }

    private function processInstances(Result $instances): Collection
    {
        if (! $instances->hasKey('Reservations')) {
            throw new InvalidArgumentException('No instances found');
        }

        $result = collect();
        foreach ($instances->get('Reservations') as $reservation) {
            $result = $result->merge($this->syncReservation($reservation));
        }

        return $result;
    }

    private function syncReservation(array $reservation): Collection
    {
        if (! array_key_exists('Instances', $reservation)) {
            return collect();
        }

        return collect($reservation['Instances'])->map(fn (array $instance) => $this->syncInstance($instance));
    }

    private function syncInstance(array $instance): Instance
    {
        return Instance::updateOrCreate([
            'id' => $instance['InstanceId'],
        ], [
            'name' => $this->extractTag($instance, 'Name', $instance['InstanceId']),
            'state' => $instance['State']['Name'],
            'architecture' => $instance['Architecture'],
            'type' => $instance['InstanceType'],
            'cpu_cores' => $instance['CpuOptions']['CoreCount'],
            'memory_bytes' => $this->getTotalMemoryForInstanceType($instance['InstanceType']),
        ]);
    }

    private function extractTag(array $instance, string $name, string $default): string
    {
        if (! isset($instance['Tags']) || ! is_array($instance['Tags'])) {
            return $default;
        }

        foreach ($instance['Tags'] as $tag) {
            if (isset($tag['Key'], $tag['Value']) && $tag['Key'] === $name) {
                return $tag['Value'];
            }
        }

        return $default;
    }

    private function getTotalMemoryForInstanceType(string $instanceType): int
    {
        try {
            return Cache::rememberForever("instance-type-$instanceType-memory", function () use ($instanceType) {
                $client = AwsFacade::createEc2();
                $result = $client->describeInstanceTypes(['InstanceTypes' => [$instanceType]]);

                if (! $result->hasKey('InstanceTypes')) {
                    throw new InvalidArgumentException("Unknown instance type: $instanceType");
                }

                return ($result['InstanceTypes'][0]['MemoryInfo']['SizeInMiB'] ?? 0) * pow(1024, 2);
            });
        } catch (RuntimeException) {
            return 0;
        }
    }
}
