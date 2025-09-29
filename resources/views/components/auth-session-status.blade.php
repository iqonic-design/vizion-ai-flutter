@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'alert bg-success-subtle text-success']) }}>
        {{ $status }}
    </div>
@endif
