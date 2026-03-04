<div>
    <flux:table :paginate="$incidents">
        <flux:table.columns>
            <flux:table.column>{{ __('Source') }}</flux:table.column>
            <flux:table.column>{{ __('Started At') }}</flux:table.column>
            <flux:table.column>{{ __('Duration') }}</flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @foreach($incidents as $incident)
                <flux:table.row>
                    <flux:table.cell>{{ $incident->source_description }}</flux:table.cell>
                    <flux:table.cell>{{ $incident->created_at->format('F j, Y g:ia') }}</flux:table.cell>
                    <flux:table.cell>
                        @if($incident->trashed())
                            {{ $incident->duration }}
                        @else
                            <flux:badge size="sm" color="red">{{ __('Active') }}</flux:badge>
                        @endif
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>
