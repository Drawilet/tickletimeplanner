@php
    $readonly = isset($event['id']);
@endphp

<input type="checkbox" class="modal-toggle" @checked($modals['save']) />
<div class="modal" role="dialog">
    <div class="modal-box">
        <div class="px-6 py-4">
            <div class="text-lg font-medium">
                <h3 class="text-2xl">
                    @isset($event['date'])
                        {{ \Carbon\Carbon::parse($event['date'])->format('d F, Y') }}
                    @endisset

                </h3>

            </div>

            <div class="mt-4 text-sm ">
                {{-- INFORMATION --}}
                <section>
                    <x-form-control>
                        <x-label for="name" value="{{ __('calendar-lang.Eventname') }}" />
                        <x-input id="name" name="name" wire:model="event.name" :disabled="$readonly" />
                        <x-input-error for="event.name" class="mt-2" />
                    </x-form-control>

                    <x-form-control>
                        <x-label for="space_id" value="{{ __('calendar-lang.Space') }}" />
                        <select class="select select-bordered" wire:model="event.space_id" @disabled($readonly)>
                            <option value="{{ null }}">Pick one</option>
                            @foreach ($spaces as $space)
                                <option value="{{ $space->id }}">{{ $space->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error for="event.space_id" class="mt-2" />
                    </x-form-control>

                    <x-form-control>
                        <x-label for="customer_id" value="{{ __('calendar-lang.Customer') }}" />
                        <div class="flex items-center">
                            <select class="select select-bordered w-full" wire:model="event.customer_id"
                                @disabled($readonly)>
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
                        <x-input-error for="event.customer_id" class="mt-2" />
                    </x-form-control>

                    <div class="divider"></div>

                    <x-form-control>
                        <x-label for="date" value="{{ __('calendar-lang.Date') }}" />
                        <x-input id="date" name="date" type="date" wire:model="event.date"
                            :disabled="$readonly" />
                        <x-input-error for="event.date" class="mt-2" />
                    </x-form-control>

                    <x-form-control>
                        <x-label for="start_time" value="{{ __('calendar-lang.Starttime') }}" />
                        <x-input id="start_time" name="start_time" type="time" wire:model="event.start_time"
                            :disabled="$readonly" />
                        <x-input-error for="event.start_time" class="mt-2" />
                    </x-form-control>

                    <x-form-control>
                        <x-label for="end_time" value="{{ __('calendar-lang.Endtime') }}" />
                        <x-input id="end_time" name="end_time" type="time" wire:model="event.end_time"
                            :disabled="$readonly" />
                        <x-input-error for="event.end_time" class="mt-2" />
                    </x-form-control>

                    <x-form-control>
                        <x-label for="price" value="{{ __('calendar-lang.Price') }}" />
                        <x-input id="price" name="price" type="number" wire:model="event.price"
                            :disabled="$readonly" />
                        <x-input-error for="event.price" class="mt-2" />
                    </x-form-control>

                    <x-form-control>
                        <x-label for="notes" value="{{ __('calendar-lang.Notes') }}" />
                        <textarea id="notes" name="notes" class="textarea textarea-bordered" wire:model="event.notes"
                            @disabled($readonly)></textarea>
                        <x-input-error for="event.notes" class="mt-2" />
                    </x-form-control>
                </section>

                {{-- PRODUCTS --}}
                <section class="mt-2">
                    <h2 class="text-xl flex items-center">
                        @if (!$readonly)
                            <button class="btn mr-2" wire:click="Modal('addProduct', true)">
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
                                @foreach ($event['products'] as $event)
                                    @php
                                        $product = $products->find($event['product_id']);
                                        $price = $product->price * $event['quantity'];
                                        $id = $product->id;
                                    @endphp
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td class="join">
                                            @if (!$readonly)
                                                <button class="btn"
                                                    wire:click="productAction('{{ $id }}', 'decrease')">-</button>
                                            @endif
                                            <span class="btn">{{ $event['quantity'] }}</span>
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
        </div>

        <div class="flex flex-row items-center justify-end px-6 py-4">
            <span class="text-xl mr-auto block">$ {{ $this->getTotal() }}</span>

            @if (!$readonly)
                <button class="btn btn-primary px-8" wire:click="saveEvent">
                    {{ __('calendar-lang.Save') }}
                </button>
            @endif
        </div>
    </div>

    @include('livewire.dashboard.save-modal.products-modal')
    @include('livewire.dashboard.save-modal.payments-modal')

    <label class="modal-backdrop" wire:click="Modal('save', false)">Close</label>
</div>
