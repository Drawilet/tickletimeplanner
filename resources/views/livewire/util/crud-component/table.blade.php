<div class="overflow-scroll" style="max-height: calc(100vh - 200px)">
    @isset($mobileStyles)
        <style>
            @media screen and (max-width: 768px) {
                {{ $mobileStyles }} .notes {
                    width: 100%;
                    justify-content: center;
                    font-size: .8rem;
                }
            }
        </style>
    @endisset

    @if (count($items))
        <table class="mt-2 md:table w-full">
            <thead class="hidden md:table-header-group sticky top-0 bg-base-100">
                <tr>
                    <th></th>
                    @foreach ($keys as $key)
                        <th class="capitalize {{ $mainKey == $key ? '' : '' }}">
                            {{ __($name . '-lang.' . $key) }}</th>
                    @endforeach
                    <th></th>
                </tr>
            </thead>
            <tbody class="flex flex-wrap gap-5 md:table-row-group ">
                @foreach ($shownItems as $item)
                    <tr
                        class="hover w-full flex {{ isset($mobileStyles) ? '' : 'flex-col' }} flex-wrap p-4 border border-base-200 rounded-lg relative md:table-row md:border-0">
                        <td class="absolute right-0 top-0 mt-2 mr-4 md:static md:m-0 md:table-cell">{{ $item['id'] }}
                        </td>

                        @foreach ($types as $key => $type)
                            @isset($type['hidden'])
                                @continue
                            @endisset

                            <td class="{{ $key }} flex flex-wrap md:table-cell">
                                @if (!isset($mobileStyles))
                                    <span class="font-medium mr-10 opacity-80 md:hidden">
                                        {{ __($name . '-lang.' . $key) }}</span>
                                @endif

                                @if (isset($type['parser']))
                                    @php
                                        $value = $type['parser']($item[$key]);
                                    @endphp
                                    @if (gettype($value) == 'string')
                                        {{ $value }}
                                    @else
                                        @foreach ($value as $v)
                                            {{ $v }} <br>
                                        @endforeach
                                    @endif
                                @else
                                    @switch($type["type"])
                                        @case('file')
                                            @if (gettype($item[$key]) == 'string')
                                                <img src="{{ $item[$key] }}" alt="" class="w-10 h-10 rounded-full">
                                            @else
                                                <button class="btn btn-ghost"
                                                    onclick="{{ $key }}{{ $item['id'] }}Modal.showModal()">
                                                    @component('components.icons.arrows-pointing-out')
                                                    @endcomponent
                                                </button>
                                                <dialog id="{{ $key }}{{ $item['id'] }}Modal"
                                                    class="modal modal-bottom md:modal-middle">
                                                    <div class="modal-box md:w-11/12 md:max-w-5xl">
                                                        <h3 class="font-bold text-lg mb-2">{{ $Name }}
                                                            {{ $key }}</h3>
                                                        <div class="flex flex-wrap gap-2">
                                                            @foreach ($item[$key] as $file)
                                                                <img src="{{ $file['url'] }}" alt=""
                                                                    class="h-36  rounded border border-base-300">
                                                            @endforeach
                                                        </div>

                                                        <div class="modal-action">
                                                            <form method="dialog">
                                                                <button class="btn">Close</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <form method="dialog" class="modal-backdrop">
                                                        <button>close</button>
                                                    </form>
                                                </dialog>
                                            @endif
                                        @break

                                        @case('textarea')
                                            <span>{{ \Illuminate\Support\Str::limit($item[$key], 50) }}</span>
                                        @break

                                        @case('select')
                                            @foreach ($type['options'] as $option)
                                                @if ($option['value'] == $item[$key])
                                                    {{ $option['label'] }}
                                                @endif
                                            @endforeach
                                        @break

                                        @default
                                            @if ($type['type'] == 'color')
                                                <span
                                                    style="background-color: {{ $item[$key] }}; width: 20px; height: 20px; display: inline-block;"></span>
                                            @else
                                                {{ $item[$key] }}
                                            @endif
                                        @break
                                    @endswitch
                                @endif


                            </td>
                        @endforeach

                        @can('tenant.' . $name . 's' . '.manage')
                            <td class="w-full flex gap-2 mt-2 md:m-0 ">
                                <button
                                    class="w-full bg-yellow-300 px-4 py-2 flex justify-center items-center rounded-lg text-black lg:max-w-[52px] lg:bg-transparent lg:text-base-content  lg:hover:scale-125 transition-transform "
                                    wire:click="Modal('save', true, '{{ $item['id'] }}')">
                                    @component('components.icons.pencil-square')
                                    @endcomponent
                                </button>
                                <button
                                    class="w-full bg-red-500 px-4 py-2 flex justify-center items-center rounded-lg text-black lg:max-w-[52px] lg:bg-transparent lg:text-base-content  lg:hover:scale-125 transition-transform "
                                    wire:click="Modal('delete', true, '{{ $item['id'] }}')">
                                    @component('components.icons.trash')
                                    @endcomponent
                                </button>
                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if ($CAN_LOAD_MORE)
            <div x-data="{ shown: false }" x-intersect="shown = true; $wire.loadMore()">
                <div x-show="shown" class="flex justify-center items-center mt-5">
                    <p>Loading more...</p>
                </div>
            </div>
        @endif
    @else
        <div class="flex flex-col items-center justify-center mt-5">
            <h2 class="text-2xl opacity-90"> {{ __($name . '-lang.' . 'notfound') }}</h2>
            <button wire:click="Modal('save', true)" class=" btn btn-primary py-2 px-4 mt-4">
                @component('components.icons.plus')
                @endcomponent
                {{ __($name . '-lang.' . 'create') }}
            </button>
        </div>
    @endif
</div>
