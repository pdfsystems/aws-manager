<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4">
    @foreach($this->instances as $instance)
        <flux:callout :heading="$instance->name" :variant="$instance->getFluxVariant()">
        </flux:callout>
    @endforeach
</div>
