<button {{ $attributes->merge(['type' => 'submit', 'class' => '']) }}>
    {{ $slot }}
</button>
