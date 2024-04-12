<div class="flex flex-wrap gap-6">
    @foreach ($tenants as $tenant)
        <div class="card md:card-side shadow-xl p-4 flex-1 relative {{ $tenant->suspended ? 'scale-95 opacity-50 border border-primary' : '' }} w-full max-w-md max-h-56"
            @if ($tenant->background_image) style="background: linear-gradient(rgba(0, 0, 0, 0.562), rgba(255, 255, 255, 0.1)), url('{{ $tenant->background_image }}'); background-size: cover;" @endif>
            <figure class="mb-4">
                <img src="{{ $tenant->profile_image }}" alt="Foto"
                    class="w-32 h-32 object-cover rounded-full mx-auto" />
            </figure>
            <div class="card-body relative">
                <h2 class="card-title text-2xl -mb-2">{{ $tenant->name }}</h2>
                <p class="mb-4">{{ $tenant->email }}</p>
                <div class="card-actions justify-end">
                    <a class="btn btn-primary"
                        href="{{ route('app.tenants.show', [
                            'id' => $tenant->id,
                        ]) }}">
                        <x-icons.arrow-top-right-on-square />
                    </a>

                </div>
            </div>
        </div>
    @endforeach
</div>
