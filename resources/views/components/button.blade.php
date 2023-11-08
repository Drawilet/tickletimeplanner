<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-neutral']) }}>
    {{ $slot }}
</button>
