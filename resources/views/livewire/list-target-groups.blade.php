<div>
    <div class="grid grid-cols-4 gap-4">
        @foreach($this->targetGroups as $group)
            <flux:callout :heading="$group->name" :variant="$group->getFluxVariant()">
                <ul class="space-y-2">
                    @foreach($group->targets as $target)
                        <li class="flex items-center space-x-2">
                            <span>{{ $target->getInstanceName() }}</span>
                            <flux:icon :name="$target->getIcon()" :color="$target->getColor()" />
                        </li>
                    @endforeach
                </ul>
            </flux:callout>
        @endforeach
    </div>
</div>
