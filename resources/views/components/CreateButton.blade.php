<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-accent ml-4 my-10 ']) }}>
    {{ $slot }}
</button>
