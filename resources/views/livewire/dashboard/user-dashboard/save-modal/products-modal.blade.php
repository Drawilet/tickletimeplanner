<dialog id="product_modal" class="modal modal-bottom md:modal-middle" {{ $modals['addProduct'] ? 'open' : '' }}>
    <div class="modal-box">
        <h3 class="font-bold text-lg">{{ __('calendar-lang.Addproduct') }}</h3>

        <input type="search" class="mt-2 input w-full" placeholder="{{ __('calendar-lang.Searchproducts') }}"
            wire:model="filters.product_name">
        <table class="table w-full">

            <tbody>
                @foreach ($filteredProducts as $product)
                    <tr class="hover cursor-pointer" wire:click="productAction('{{ $product->id }}', 'add')">
                        <td>{{ $product->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="modal-action">
            <button class="btn" wire:click="Modal('addProduct', false)">{{ __('calendar-lang.close') }}</button>
        </div>
    </div>
</dialog>
