<div>
    <div class="overflow-x-auto">
        
        <table class="table  mx-20" style="width:85%">
          <!-- head -->
          <x-CreateButton wire:click="$set('CreateModal', true)">Create</x-CreateButton>
        
          <thead>
            <tr class="bg-base-200 text-lg">
              <th>Code</th>
              <th>Description</th>
              <th>quantity</th>
              <th>price</th>
            </tr>
          </thead>
          <tbody>
            <!-- row 1 -->
            @foreach ( $allproducts as $product)
            <tr >
                <td>{{$product->code}}</td>
                <td>{{$product->description}}</td>
                <td>{{$product->quantity}}</td>
                <td>{{$product->price}}</td>
                @endforeach
            </tr>
          </tbody>
        </table>
      </div>
      <x-dialog-modal wire:model="CreateModal">
        <x-slot name="title"></x-slot>
        <x-slot name="content">
            <form>  
     <div class="mb-3">
        <label  >CODE</label>
        <input id="code" name="code" type="text" class="form-control" tabindex="1">    
      </div>
      <div class="mb-3">
        <label>Description</label>
        <input id="descripcion" name="descripcion" type="text" class="form-control" tabindex="2">
      </div>
      <div class="mb-3">
        <label >Quantity</label>
        <input id="quantity" name="quantity" type="number" class="form-control" tabindex="3">
      </div>
      <div class="mb-3">
        <label >Price</label>
        <input id="price" name="price" type="number" step="any" value="0.00" class="form-control" tabindex="3">
      </div>
     <a href="/products" class="btn btn-error " tabindex="5">Cancel</a>
     <button type="submit" class="btn btn-success" tabindex="4"> Save </button>
            </form>
        </x-slot>
        <x-slot name="footer"></x-slot>
      </x-dialog-modal>
      
</div>

