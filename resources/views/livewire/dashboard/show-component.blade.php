<div>
    <x-dialog-modal wire:model="modals.save">
        <x-slot name="title">
            <h3 class="text-2xl">
                @isset($eventData['date'])
                    {{ \Carbon\Carbon::parse($eventData['date'])->format('d F, Y') }}
                @endisset
            </h3>
        </x-slot>

        <x-slot name="content">
            @php
                $readonly = isset($eventData['id']);
            @endphp

            <div>
                {{-- INFORMATION --}}
                <section>
                    <x-form-control>
                        <x-label for="name" value="{{ __('calendar-lang.Eventname') }}" />
                        <x-input id="name" name="name" wire:model="eventData.name" :readonly="$readonly" />
                        <x-input-error for="eventData.name" class="mt-2" />
                    </x-form-control>

                    <x-form-control>
                        <x-label for="space_id" value="{{ __('calendar-lang.Space') }}" />
                        <select class="select select-bordered" wire:model="eventData.space_id" @readonly($readonly)>
                            <option value="{{ null }}">Pick one</option>
                            @foreach ($spaces as $space)
                                <option value="{{ $space->id }}">{{ $space->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error for="eventData.space_id" class="mt-2" />
                    </x-form-control>

                    <x-form-control>
                        <x-label for="customer_id" value="{{ __('calendar-lang.Customer') }}" />
                        <div class="flex items-center">
                            <select class="select select-bordered w-full" wire:model="eventData.customer_id"
                                @readonly($readonly)>
                                <option value="{{ null }}">Pick one</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->firstname }}
                                        {{ $customer->lastname }}
                                    </option>
                                @endforeach
                            </select>
                            <button class="btn btn-neutral ml-2" wire:click="newCustomer"
                                @if ($readonly) disabled @endif>
                                <x-icons.plus />
                            </button>
                        </div>
                        <x-input-error for="eventData.customer_id" class="mt-2" />
                    </x-form-control>

                    <div class="divider"></div>

                    <x-form-control>
                        <x-label for="date" value="{{ __('calendar-lang.Date') }}" />
                        <x-input id="date" name="date" type="date" wire:model="eventData.date"
                            :readonly="$readonly" />
                        <x-input-error for="eventData.date" class="mt-2" />
                    </x-form-control>

                    <x-form-control>
                        <x-label for="start_time" value="{{ __('calendar-lang.Starttime') }}" />
                        <x-input id="start_time" name="start_time" type="time" wire:model="eventData.start_time"
                            :readonly="$readonly" />
                        <x-input-error for="eventData.start_time" class="mt-2" />
                    </x-form-control>

                    <x-form-control>
                        <x-label for="end_time" value="{{ __('calendar-lang.Endtime') }}" />
                        <x-input id="end_time" name="end_time" type="time" wire:model="eventData.end_time"
                            :readonly="$readonly" />
                        <x-input-error for="eventData.end_time" class="mt-2" />
                    </x-form-control>

                    <x-form-control>
                        <x-label for="price" value="{{ __('calendar-lang.Price') }}" />
                        <x-input id="price" name="price" type="number" wire:model="eventData.price"
                            :readonly="$readonly" />
                        <x-input-error for="eventData.price" class="mt-2" />
                    </x-form-control>

                    <x-form-control>
                        <x-label for="notes" value="{{ __('calendar-lang.Notes') }}" />
                        <textarea id="notes" name="notes" class="textarea textarea-bordered" wire:model="eventData.notes"
                            :readonly="$readonly"></textarea>
                        <x-input-error for="eventData.notes" class="mt-2" />
                    </x-form-control>
                </section>

                {{-- PRODUCTS --}}
                <section class="mt-2">
                    <dialog id="product_modal" class="modal modal-bottom sm:modal-middle"
                        {{ $modals['addProduct'] ? 'open' : '' }}>
                        <div class="modal-box">
                            <h3 class="font-bold text-lg">{{ __('calendar-lang.Addproduct') }}</h3>

                            <input type="search" class="mt-2 input w-full"
                                placeholder="{{ __('calendar-lang.Searchproducts') }}"
                                wire:model="filters.product_name">
                            <table class="table w-full">

                                <tbody>
                                    @foreach ($filteredProducts as $product)
                                        <tr class="hover pointer"
                                            wire:click="productAction('{{ $product->id }}', 'add')">
                                            <td>{{ $product->name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="modal-action">
                                <form method="dialog">
                                    <button class="btn">{{ __('calendar-lang.close') }}</button>
                                </form>
                            </div>

                            <form method="dialog" class="modal-backdrop" wire:click="Modal('addProduct', false)">
                                <button>{{ __('calendar-lang.close') }}</button>
                            </form>
                        </div>
                    </dialog>
                    <h2 class="text-xl flex items-center">
                        @if (!$readonly)
                            <button class="btn" wire:click="Modal('addProduct', true)">
                                <x-icons.plus />
                            </button>
                        @endif
                        {{ __('calendar-lang.Products') }}
                    </h2>
                    <div class="overflow-x-auto">
                        <table class="table w-full table-zebra ">
                            <thead>
                                <tr>
                                    <th class="w-3/4">{{ __('calendar-lang.Name') }}</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    @if (!$readonly)
                                        <th></th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($eventData['products'] as $eventData)
                                    @php
                                        $product = $products->find($eventData['product_id']);
                                        $price = $product->price * $eventData['quantity'];
                                        $id = $product->id;
                                    @endphp
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td class="join">
                                            @if (!$readonly)
                                                <button class="btn"
                                                    wire:click="productAction('{{ $id }}', 'decrease')">-</button>
                                            @endif
                                            <span class="btn">{{ $eventData['quantity'] }}</span>
                                            @if (!$readonly)
                                                <button class="btn"
                                                    wire:click="productAction('{{ $id }}', 'add')">+</button>
                                            @endif
                                        </td>
                                        <td>x</td>
                                        <td>${{ $product->price }}</td>
                                        <td>=</td>
                                        <td>${{ $price }}</td>
                                        @if (!$readonly)
                                            <td>
                                                <button
                                                    class="btn "wire:click="productAction('{{ $id }}', 'remove')">
                                                    <x-icons.trash />
                                                </button>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </x-slot>

        <x-slot name="footer">
            <span class="text-xl mr-auto block">$ {{ $this->getTotal() }}</span>

            @if (!$readonly)
                <button class="btn btn-primary px-8" wire:click="saveEvent">
                    {{ __('calendar-lang.Save') }}
                </button>
            @endif
        </x-slot>
    </x-dialog-modal>

    @livewire('dashboard.calendar-component', [
        'events' => $events,
        'dragAndDropEnabled' => false,
        'beforeCalendarView' => '/livewire/dashboard/filter-component',
    ])

    @component('components.util.crud-socket-scripts', ['socketListeners' => $socketListeners])
    @endcomponent
</div>
