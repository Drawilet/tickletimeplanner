<x-dialog-modal wire:model="modal">
    <x-slot name="title"></x-slot>
    <x-slot name="content">
        <form>  
 <div class="mb-4 text-lg">
    <label>Code</label>
    <input id="code" name="code" type="text" wire:model="code" class="form-control input input-bordered w-full max-w-xs" tabindex="1">    
  </div>
  <div class="mb-4 text-lg">
    <label>Description</label>
    <input id="description" name="description" type="text" wire:model="description" class="form-control input input-bordered w-full max-w-xs" tabindex="2">
  </div>
  <div class="mb-4 text-lg">
    <label>Quantity</label>
    <input id="quantity" name="quantity" type="number" wire:model="quantity" class="form-control input input-bordered w-full max-w-xs" tabindex="3">
  </div>
  <div class="mb-4 text-lg">
    <label >Price</label>
    <input id="price" name="price" type="number" step="any" value="0.00" wire:model="price" class="form-control input input-bordered w-full max-w-xs" tabindex="3">
  </div>
  
 <a href="/products"  wire:click ="$set('modal', false)" class="btn btn-error" tabindex="5">Cancel</a>
 <button wire:click="save()" class="btn btn-success" tabindex="4"> Save </button>
        </form>
    </x-slot>
    <x-slot name="footer"></x-slot>
  </x-dialog-modal>
  
</div>