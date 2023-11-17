<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 btn btn-outline btn-accent  ']) }}>
    {{ $slot }}
</button>
