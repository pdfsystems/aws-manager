<div class="space-y-4">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item :href="route('instances.index')" wire:navigate>{{ __('Instances') }}</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>{{ $instance->getKey() }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <form class="space-y-4" wire:submit.prevent="save">
        <!-- Instance ID -->
        <flux:field>
            <flux:label>{{ __('Instance ID') }}</flux:label>
            <flux:text>{{ $instance->getKey() }}</flux:text>
        </flux:field>

        <!-- Name -->
        <flux:field>
            <flux:label>{{ __('Name') }}</flux:label>
            <flux:text>{{ $instance->name }}</flux:text>
        </flux:field>

        <!-- Display Name -->
        <flux:input wire:model="display_name" :label="__('Display Name')" />

        <!-- Submit Button -->
        <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
    </form>
</div>
