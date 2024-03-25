<div>
    @if ($step)
        <dialog id="wizard" class="modal bg-[rgba(0,0,0,0.71)]" open>
            <div class="modal-box">
                <img src="/brand.svg" alt="Logo" class="w-96 h-24 mx-auto block">

                @include('livewire.wizard.' . ($currentRoute == $step['route'] ? '' : 'pre-') . $step['name'])

                <div class="modal-action">
                    @if ($currentRoute == $step['route'])
                        @if (isset($step['skippable']) && $step['skippable'])
                            <button class="btn btn-secondary" wire:click='skip()'>
                                Omitir
                            </button>
                        @endif


                        <form method="dialog">
                            <button class="btn btn-primary">Continuar</button>
                        </form>
                    @else
                        <a class="btn btn-primary" href="{{ route($step['route']) }}">
                            Siguiente
                        </a>
                    @endif


                </div>
            </div>
        </dialog>
    @endif
</div>
