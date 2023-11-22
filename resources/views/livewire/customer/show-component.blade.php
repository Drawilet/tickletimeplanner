<div class="overflow-x-auto">
    <br>
    <div class="max-w-7xl mx-auto sm:px6 lg:px-8">
        <div class="bg-base-100 overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            <div class="mockup-browser border border-base-300">
                <div class="mockup-browser-toolbar flex items-center">
                    <input class="input border border-base-300" wire:model="search" type="text" placeholder="Search">
                    <button
                        wire:click="OpenModal"class=" btn btn-ghost bg-base-100 hover:bg-base-300 text-black hover:text-blue-50 py-2 px-4 ml-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </button>
                </div>
            </div>

            <table class="table">
                <!-- head -->
                <thead>
                    <tr>
                        <th>Business name</th>
                        <th>Trade name</th>
                        <th>Operation</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Customer as $Customers)
                        <!-- row 1 -->
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar">
                                        <div class="mask mask-squircle w-12 h-12">

                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold">{{ $Customers->buisinessname }}</div>
                                        <img class="text-sm opacity-50">/>
                                    </div>
                                </div>
        </div>
        </td>
        <td>
            {{ $Customers->tradename }}
        </td>
        <th>
            <button class="btn btn-ghost  hover:text-blue-50 "wire:click="edit({{ $Customers->id }})">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.1"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                </svg>
            </button>
            <button class="btn btn-ghost  hover:text-blue-50" wire:click="delete({{ $Customers->id }})">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.1"
                    stroke="currentColor" class="w-6 h-6 center">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
            </button>
        </th>
        </tr>
        @endforeach
        </tbody>
        </table>
        <div class="mt-8">
            {{ $Customer->links() }}
        </div>
    </div>
</div>
<x-dialog-modal wire:model="modal">
    <x-slot name="title">Crear</x-slot>
    <x-slot name="content">
        <x-label>Photo</x-label>
        <x-input type="file" wire:model="photo" accept="image/png, image/gif, image/jpeg"></x-input>
        <x-label>busines sname</x-label>
        <x-input type="text" class="input" wire:model="buisinessname"></x-input>
        <x-label>trade name</x-label>
        <x-input type="text" class="input" wire:model="tradename"></x-input>
    </x-slot>
    <x-slot name="footer">
        <x-button wire:click="save">Save</x-button>
    </x-slot>
</x-dialog-modal>
</div>
