@props(['src', 'alt'])

<div class="w-full md:max-w-lg mockup-browser bg-base-300">
    <div class="mockup-browser-toolbar">
        <div class="input">https://tickletimeplanner.drawilet.me</div>
    </div>
    <div class="flex justify-center p-1 bg-base-200">
        <img class="hidden dark:block" src='{{ "/$locale/assets/dark/" . $src }}' alt="{{ $alt }}">
        <img class="dark:hidden" src='{{ "/$locale/assets/light/" . $src }}' alt="{{ $alt }}">
    </div>
</div>
