<?php

namespace App\Actions;

use App\Models\TargetGroup;
use Aws\Laravel\AwsFacade;
use Aws\Result;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use Lorisleiva\Actions\Concerns\AsAction;

class SyncTargetGroups
{
    use AsAction;

    public string $commandSignature = 'target-group:sync';

    public string $commandDescription = 'Syncs target groups';

    public function handle(): Collection
    {
        $client = AwsFacade::createElasticLoadBalancingV2();

        return $this->processTargetGroups(
            $client->describeTargetGroups()
        );
    }

    public function asController(Request $request): void
    {
        $this->handle();
    }

    public function asCommand(Command $command): void
    {
        $targetGroups = $this->handle();

        $command->info("Synced {$targetGroups->count()} target groups");
    }

    public function asListener($event): void
    {
        $this->handle();
    }

    private function processTargetGroups(Result $targetGroups): Collection
    {
        if (! $targetGroups->hasKey('TargetGroups')) {
            throw new InvalidArgumentException('No target groups found');
        }

        return collect($targetGroups->get('TargetGroups'))->map(
            fn (array $targetGroup) => $this->syncTargetGroup($targetGroup)
        );
    }

    private function syncTargetGroup(array $targetGroup): TargetGroup
    {
        return TargetGroup::firstOrCreate([
            'arn' => $targetGroup['TargetGroupArn'],
        ], [
            'name' => $targetGroup['TargetGroupName'],
            'vpc' => $targetGroup['VpcId'],
            'protocol' => $targetGroup['Protocol'],
            'port' => $targetGroup['Port'],
        ]);
    }
}
