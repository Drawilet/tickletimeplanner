<button {{ $attributes->merge(['type' => 'submit', 'class' => 'ml-4 fa-regular fa-trash-can fa-xl']) }}>
    {{ $slot }}
   
</button>
