@props(['value'])

<label {{ $attributes->merge(['class' => 'card-title']) }}>
    <span class="label-text"> {{ $value ?? $slot }}</span>
</label>
