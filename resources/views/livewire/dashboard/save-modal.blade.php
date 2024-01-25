<input type="checkbox" class="modal-toggle" @checked($modals['save']) />
<div class="modal" role="dialog">


    <div class="modal-box">
        <div class="px-6 py-4">
            <div>
                <h2>
                    {{ !isset($event['id']) || count($event['payments']) == 0 ? __('calendar-lang.draft') : __('calendar-lang.sale') }}
                </h2>
            </div>

            <div class="flex justify-between items-center">
                <h3 class="text-2xl">
                    @isset($event['date'])
                        {{ \Carbon\Carbon::parse($event['date'])->format('d') }},
                        {{ __('month-lang.' . strtolower(\Carbon\Carbon::parse($event['date'])->format('F'))) }},
                        {{ \Carbon\Carbon::parse($event['date'])->format('Y') }}
                    @endisset

                </h3>

                @isset($event['id'])
                    <button class="btn btn-error" wire:click="Modal('delete', true)">
                        <x-icons.trash />
                    </button>
                @endisset

            </div>

            <div class="mt-4 text-sm ">
                {{-- INFORMATION --}}
                <section>
                    <x-form-control>
                        <x-label for="name" value="{{ __('calendar-lang.Eventname') }}" />
                        <x-input id="name" name="name" wire:model="event.name" wire:loading.attr="disabled"
                            wire:target="saveEvent" />
                        <x-input-error for="name" class="mt-2" />
                    </x-form-control>

                    <x-form-control>
                        <x-label for="space_id" value="{{ __('calendar-lang.Space') }}" />
                        <select class="select select-bordered" wire:model="event.space_id" wire:change='updateSpace'
                            wire:loading.attr="disabled" wire:target="saveEvent">
                            <option value="{{ null }}">{{ __('calendar-lang.Pickone') }}</option>
                            @foreach ($spaces as $space)
                                <option value="{{ $space->id }}">{{ $space->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error for="space_id" class="mt-2" />
                    </x-form-control>

                    <x-form-control>
                        <x-label for="customer_id" value="{{ __('calendar-lang.Customer') }}" />
                        <div class="flex items-center">
                            <select class="select select-bordered w-full" wire:model="event.customer_id"
                                wire:loading.attr="disabled" wire:target="saveEvent">
                                <option value="{{ null }}">{{ __('calendar-lang.Pickone') }}</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->firstname }}
                                        {{ $customer->lastname }}
                                    </option>
                                @endforeach
                            </select>
                            <button class="btn btn-neutral ml-2" wire:click="Modal('newCustomer', true)">
                                <x-icons.plus />
                            </button>
                        </div>
                        <x-input-error for="customer_id" class="mt-2" />
                    </x-form-control>

                    @php
                        $schedule = $this->getSchedule();
                    @endphp

                    <div class="divider"></div>

                    <x-form-control>
                        <x-label for="date" value="{{ __('calendar-lang.Date') }}" />
                        <x-input id="date" name="date" type="date" wire:model="event.date"
                            wire:loading.attr="disabled" wire:target="saveEvent" />
                        <x-input-error for="date" class="mt-2" />
                    </x-form-control>

                    <x-form-control>
                        <x-label for="start_time" value="{{ __('calendar-lang.Starttime') }}" />
                        <x-input id="start_time" name="start_time" type="time" wire:model="event.start_time"
                            wire:change='updateEndTime' min="{{ $schedule['opening'] }}"
                            max="{{ $schedule['closing'] }}" wire:loading.attr="disabled" wire:target="saveEvent" />
                        <x-input-error for="start_time" class="mt-2" />
                    </x-form-control>

                    <x-form-control>
                        <x-label for="end_time" value="{{ __('calendar-lang.Endtime') }}" />
                        <x-input id="end_time" name="end_time" type="time" wire:model="event.end_time"
                            wire:loading.attr="disabled" wire:target="saveEvent" />
                        <x-input-error for="end_time" class="mt-2" />
                    </x-form-control>

                    <x-form-control>
                        <x-label for="price" value="{{ __('calendar-lang.Price') }}" />
                        <x-input id="price" name="price" type="number" wire:model="event.price"
                            wire:loading.attr="disabled" wire:target="saveEvent" />
                        <x-input-error for="price" class="mt-2" />
                    </x-form-control>

                    <x-form-control>
                        <x-label for="notes" value="{{ __('calendar-lang.Notes') }}" />
                        <textarea id="notes" name="notes" class="textarea textarea-bordered" wire:model="event.notes"
                            wire:loading.attr="disabled" wire:target="saveEvent"></textarea>
                        <x-input-error for="notes" class="mt-2" />
                    </x-form-control>
                </section>

                {{-- PRODUCTS --}}
                <section class="mt-2">
                    <h2 class="text-xl flex items-center">
                        <button class="btn mr-2" wire:click="Modal('addProduct', true)">
                            <x-icons.plus />
                        </button>
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

                                    <th></th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($event['products'] as $event_product)
                                    @php
                                        $product = $products->find($event_product['product_id']);
                                        $price = $product->price * $event_product['quantity'];
                                        $id = $product->id;
                                    @endphp
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td class="join">
                                            <button class="btn"
                                                wire:click="productAction('{{ $id }}', 'decrease')">-</button>
                                            <span class="btn">{{ $event_product['quantity'] }}</span>
                                            <button class="btn"
                                                wire:click="productAction('{{ $id }}', 'add')">+</button>
                                        </td>
                                        <td>x</td>
                                        <td>${{ $product->price }}</td>
                                        <td>=</td>
                                        <td>${{ $price }}</td>
                                        <td>
                                            <button
                                                class="btn "wire:click="productAction('{{ $id }}', 'remove')">
                                                <x-icons.trash />
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>

        </div>


        <div class="flex flex-row items-center justify-end px-6 py-4">
            <span class="text-xl mr-auto block">{{ __('calendar-lang.total') }}: $ {{ $this->getTotal() }}</span>

            <button class="btn btn-primary px-8" wire:click="saveEvent" wire:loading.attr="disabled">
                <span wire:loading wire:target="saveEvent">
                    {{ __('auth.cargando') }}...
                </span>
                <span wire:loading.remove wire:target="saveEvent">
                    {{ __('calendar-lang.Save') }}
                </span>
            </button>


        </div>
    </div>



    @include('livewire.dashboard.save-modal.products-modal')
    @include('livewire.dashboard.save-modal.payments-modal')
    @include('livewire.dashboard.save-modal.new-customer-modal')

    <label class="modal-backdrop" wire:click="Modal('save', false)">Close</label>
</div>
