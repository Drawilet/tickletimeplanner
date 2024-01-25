@props(['hideName' => false])

<span class="flex justify-center items-center">
    <img src="/favicon-96x96.png" alt="Logo" class="h-12">
    <span class="{{ $hideName ? 'hidden md:block' : '' }}"> {{ config('app.name') }}</span>
</span>
