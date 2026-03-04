<div class="space-y-4">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item>{{ __('Target Groups') }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4">
        @foreach($this->targetGroups as $group)
            <flux:callout :heading="$group->display_name ?: $group->name" :variant="$group->getFluxVariant()">
                <ul class="space-y-2">
                    @foreach($group->targets as $target)
                        <li class="flex items-center space-x-2">
                            <flux:icon :name="$target->getIcon()" :color="$target->getColor()" />
                            <span>{{ $target->getInstanceName() }}</span>
                        </li>
                    @endforeach
                </ul>

                <!-- Controls -->
                <x-slot name="controls">
                    <flux:button variant="ghost" size="sm" :href="route('target-groups.edit', $group)" wire:navigate icon="pencil"/>
                </x-slot>
            </flux:callout>
        @endforeach
    </div>
</div>
