<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-error']) }}>
    {{ $slot }}
</button>
