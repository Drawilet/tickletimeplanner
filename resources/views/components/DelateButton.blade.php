<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary fa-regular fa-trash-can fa-xl']) }}>
    {{ $slot }}
   
</button>
