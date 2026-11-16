@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-[#526057]']) }}>
    {{ $value ?? $slot }}
</label>
