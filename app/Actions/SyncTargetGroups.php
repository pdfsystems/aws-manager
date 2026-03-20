<?php

namespace App\Actions;

use App\Models\TargetGroup;
use Aws\ElasticLoadBalancingV2\ElasticLoadBalancingV2Client;
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
            $client,
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

    private function processTargetGroups(ElasticLoadBalancingV2Client $client, Result $targetGroups): Collection
    {
        if (! $targetGroups->hasKey('TargetGroups')) {
            throw new InvalidArgumentException('No target groups found');
        }

        return collect($targetGroups->get('TargetGroups'))->map(
            fn (array $targetGroup) => $this->syncTargetGroup($client, $targetGroup)
        );
    }

    private function syncTargetGroup(ElasticLoadBalancingV2Client $client, array $targetGroup): TargetGroup
    {
        $result = TargetGroup::updateOrCreate([
            'arn' => $targetGroup['TargetGroupArn'],
        ], [
            'name' => $targetGroup['TargetGroupName'],
            'vpc' => $targetGroup['VpcId'],
            'protocol' => $targetGroup['Protocol'],
            'port' => $targetGroup['Port'],
        ]);

        $health = $client->describeTargetHealth(['TargetGroupArn' => $result->arn]);
        if ($health->hasKey('TargetHealthDescriptions')) {
            $this->updateTargets($result, $health->get('TargetHealthDescriptions'));
        }

        return $result;
    }

    private function updateTargets(TargetGroup $targetGroup, array $health): void
    {
        foreach ($health as $target) {
            $targetGroup->targets()->updateOrCreate([
                'instance_id' => $target['Target']['Id'],
            ], [
                'state' => $target['TargetHealth']['State'],
            ]);
        }

        $targetGroup->targets()->whereNotIn('instance_id', collect($health)->pluck('Target.Id'))->delete();
    }
}
