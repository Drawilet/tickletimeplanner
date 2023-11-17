@props(['value'])

<label {{ $attributes->merge(['class' => 'label']) }}>
    <span class="label-text"> {{ $value ?? $slot }}</span>
</label>
