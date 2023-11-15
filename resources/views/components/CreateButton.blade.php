<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-accent  my-10 mx-10 mb-5 fa-solid fa-file-circle-plus fa-xl']) }}>
    {{ $slot }}
</button>
