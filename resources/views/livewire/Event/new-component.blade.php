<div class="flex gap-10">
    <div class="flex flex-col md:flex-row w-full gap-5">
        {{-- GENERAL INFORMATION --}}
        <section class=" w-full">
            <h2 class="text-xl text-center mb-2">General information</h2>
            <x-form-control>
                <x-label for="customer_id" value="{{ __('Customer') }}" />
                <select class="select select-bordered">
                    <option disabled>Pick one</option>
                </select>
            </x-form-control>

            <x-form-control>
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" name="name" wire:model="data.name" />
            </x-form-control>

            <x-form-control>
                <x-label for="location" value="{{ __('Location') }}" />
                <x-input id="location" name="location" wire:model="data.location" />
            </x-form-control>

            <div class="divider"></div>

            <x-form-control>
                <x-label for="date" value="{{ __('Date') }}" />
                <x-input id="date" name="date" wire:model="data.date" type="date" />
            </x-form-control>

            <x-form-control>
                <x-label for="startTime" value="{{ __('Start time') }}" />
                <x-input id="startTime" name="startTime" wire:model="data.startTime" type="time" />
            </x-form-control>

            <x-form-control>
                <x-label for="endTime" value="{{ __('End time') }}" />
                <x-input id="endTime" name="endTime" wire:model="data.endTime" type="time" />
            </x-form-control>

            <x-form-control>
                <x-label for="price" value="{{ __('Price') }}" />
                <x-input id="price" name="price" wire:model="data.price" type="number" />
            </x-form-control>

            <x-form-control>
                <x-label for="notes" value="{{ __('Notes') }}" />
                <textarea id="notes" name="notes" wire:model="data.notes" class="textarea textarea-bordered"></textarea>
            </x-form-control>
        </section>

        {{-- PRODUCTS MODAL --}}
        <label for="products_modal" class="md:hidden btn">Add product</label>
        <input type="checkbox" id="products_modal" class="modal-toggle"/>
        <div class="modal modal-bottom">
            <div class="modal-box">
                <h2 class="text-xl text-center mb-2">Add product</h2>
                @livewire('event.product', ['products' => $products])
            </div>
            <label class="modal-backdrop" for="products_modal">Close</label>
        </div>


        {{-- SUMMARY MODAL --}}
        <label for="summary_modal" class="md:hidden btn btn-primary">Show summary</label>
        <input type="checkbox" id="summary_modal" class="modal-toggle" />
        <div class="modal modal-bottom">
            <div class="modal-box">
                @livewire('event.summary')
            </div>
            <label class="modal-backdrop" for="summary_modal">Close</label>
        </div>

        <section class="hidden md:block w-full">
            <h2 class="text-xl text-center mb-2">Add products</h2>
            @livewire('event.product', ['products' => $products])
        </section>
    </div>

    <section class="hidden md:block w-full md:w-6/12 bg-base-200 rounded p-2">
        @livewire('event.summary')
    </section>
</div>
