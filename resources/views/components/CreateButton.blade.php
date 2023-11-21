<button {{ $attributes->merge(['type' => 'submit', 'class' => 'ml-20 fa-solid fa-file-circle-plus fa-xl']) }}>
    {{ $slot }}
</button>
