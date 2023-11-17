<div class="flex flex-col items-center">
    <x-input id="search" name="search" wire:model="search" placeholder="Search" />
    <div class="overflow-x-hidden overflow-y-scroll h-96 w-full">
        @foreach ($products as $product)
            <div class="flex p-2 relative cursor-pointer shadow-sm">
                <img src="{{ $product['photo'] }}" alt="{{ $product['name'] }}" class="h-24 rounded">
                <div class="ml-5">
                    <h3 class="card-title">{{ $product['name'] }}</h3>
                    <p>{{ $product['description'] }}</p>
                    <p>${{ $product['price'] }}</p>
                </div>

                <div
                    class="absolute transition-opacity  z-10 w-full h-full opacity-0 hover:opacity-80 flex justify-center items-center text-lg bg-base-100">
                    <i class="fa-solid fa-plus mr-2"></i>
                    <span>Add</span>
                </div>
            </div>
        @endforeach
    </div>

    <div class="join mt-3">
        <button class="join-item btn">«</button>
        <button class="join-item btn btn-active">1</button>
        <button class="join-item btn">2</button>
        <button class="join-item btn">3</button>
        <button class="join-item btn">4</button>
        <button class="join-item btn">5</button>
        <button class="join-item btn">»</button>
    </div>
</div>
