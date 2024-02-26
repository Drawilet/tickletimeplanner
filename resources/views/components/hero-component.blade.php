@props(['title', 'description', 'cta', 'href', 'src', 'alt', 'align' => 'right', 'type' => 'other'])

<section class="hero lg:min-h-screen mb-6 lg:mb-0">
    <div
        class="hero-content flex-col {{ $align == 'right' ? 'lg:flex-row' : 'lg:flex-row-reverse' }} lg:justify-between w-full">
        <div class="max-w-lg">
            @if ($type == 'other')
                <h2 class="text-4xl font-bold mb-4 text-center">{{ $title }}</h2>
            @else
                <h1 class="text-5xl font-bold mb-4 text-center">{{ $title }}</h1>
            @endif
            <p class="mb-4 text-center">{{ $description }}</p>

            @if (isset($cta) && isset($href))
                <a href="{{ $href }}"
                    class="btn btn-primary flex justify-center items-center">{{ $cta }}</a>
            @endif
        </div>

        <x-browser-mockup-component src="{{ $src }}" alt="{{ $alt }}" />
    </div>
</section>
