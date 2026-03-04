<div class="space-y-4">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item :href="route('target-groups.index')" wire:navigate>{{ __('Target Groups') }}</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>{{ $group->getKey() }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <form class="space-y-4" wire:submit.prevent="save">
        <!-- Name -->
        <flux:field>
            <flux:label>{{ __('Name') }}</flux:label>
            <flux:text>{{ $group->name }}</flux:text>
        </flux:field>

        <!-- Display Name -->
        <flux:input wire:model="display_name" :label="__('Display Name')" />

        <!-- Submit Button -->
        <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
    </form>
</div>
