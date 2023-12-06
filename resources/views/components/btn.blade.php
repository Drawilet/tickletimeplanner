<button {{ $attributes->merge(['type' => 'submit', 'class' => "btn no-animation"]) }}>

    {{ $slot }}
</button>
