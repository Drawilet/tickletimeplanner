<div class="overflow-x-auto">
    @include('livewire.util.crud-component.save-modal')

    @include('livewire.util.crud-component.delete-modal')

    <div class="w-full mx-auto sm:px-6 lg:px-8">
        <div class="bg-base-100 overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            <div class="mockup-browser border border-base-300">
                <form autocomplete="off" class="mockup-browser-toolbar flex items-center ">
                    <div class="hidden lg:flex dots">
                        <div class="dot animate-bounce-1" id="Myelement-1" wire:target="">&#9679;</div>
                        <div class="dot animate-bounce-2" id="Myelement-2" wire:target="">&#9679;</div>
                        <div class="dot animate-bounce-3" id="Myelement-3" wire:target="">&#9679;</div>
                    </div>
                    <input id="crud-search" class="input py-5" wire:model.debounce.500ms="filter.search"
                        wire:keyup.debounce.500ms="filterUpdated" type="text"
                        placeholder="{{ __($name . '-lang.' . 'search') }}">
                    <button wire:click="Modal('save', true)" type="button"
                        class=" btn btn-ghost bg-base-100 hover:bg-base-300 hover:text-blue-50 py-2 px-4 ml-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </button>
                </form>
            </div>
            @include('livewire.util.crud-component.table')
        </div>
    </div>
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.hook('message.processed', (message, component) => {
                setTimeout(function() {
                    var dots = document.querySelectorAll('.dot');
                    dots.forEach(function(dot) {
                        dot.classList.remove('animate-bounce-1');
                        dot.classList.remove('animate-bounce-2');
                        dot.classList.remove('animate-bounce-3');
                    });
                }, 3280);
            });
        });
    </script>

    <script>
        const crudContainer = document.getElementById('crud-container');
        const searchInput = document.getElementById('crud-search');
        searchInput.addEventListener("keyup", () => {
            crudContainer.scrollTop = 0;
        })
    </script>
</div>
