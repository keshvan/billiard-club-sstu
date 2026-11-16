@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'ui-alert-success text-sm font-medium']) }}>
        {{ $status }}
    </div>
@endif
