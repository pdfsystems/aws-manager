<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4">
    @foreach($this->instances as $instance)
        <flux:callout :heading="$instance->name" :variant="$instance->getFluxVariant()">
            <!-- CPU Info -->
            <div class="flex flex-row items-center space-x-1">
                <flux:icon name="cpu-chip" class="mr-2"></flux:icon>
                <flux:callout.text>{{ $instance->cpu_cores }}</flux:callout.text>
                <flux:callout.text>&times;</flux:callout.text>
                <flux:callout.text>{{ $instance->architecture }}</flux:callout.text>
            </div>

            <!-- Memory Info -->
            <div class="flex flex-row items-center space-x-1">
                <flux:icon name="memory-stick" class="mr-2"></flux:icon>
                <flux:callout.text>{{ \Illuminate\Support\Number::fileSize($instance->memory_bytes) }}</flux:callout.text>
            </div>
        </flux:callout>
    @endforeach
</div>
