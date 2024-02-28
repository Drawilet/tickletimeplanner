<div class="overflow-x-auto">
    @include('livewire.util.crud-component.save-modal')

    @include('livewire.util.crud-component.delete-modal')

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-base-100 overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            <div class="mockup-browser border border-base-300">
                <div class="mockup-browser-toolbar flex items-center ">
                    <div class="dots">
                        <div class="dot animate-bounce-1" id="Myelement-1" wire:target="">&#9679;</div>
                        <div class="dot animate-bounce-2" id="Myelement-2" wire:target="">&#9679;</div>
                        <div class="dot animate-bounce-3" id="Myelement-3" wire:target="">&#9679;</div>
                    </div>
                    <input id="ItemDot" class="input py-5" wire:model.live.debounce.500ms="filter.search" wire:laoding
                        type="text" placeholder="{{ __($name . '-lang.' . 'search') }}">
                    <button wire:click="Modal('save', true)"
                        class=" btn btn-ghost bg-base-100 hover:bg-base-300 hover:text-blue-50 py-2 px-4 ml-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </button>
                </div>
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
</div>
