<div>
    <div class="overflow-x-auto">
      
        <table id="product" class="table  mx-20 my-5" style="width:85%">
          <!-- head -->
          
          
          @if($modal)
              @include('livewire.create')            
          @endif
          
          <thead>
            <tr class="bg-base-200 text-lg">
              <th>ID</th>
              <th>Code</th>
              <th>Description</th>
              <th>quantity</th>
              <th>price</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <!-- row 1 --> 
             
            <div class="ml-auto mt-3" style="width: 30%;">
              <form wire:submit="search">
                  <button type="submit"></button>
                  <input type="text" placeholder="Search" class="input input-bordered input-warning w-full max-w-xs " wire:model="query">
              </form>
            </div> 
            <x-CreateButton wire:click="create()"></x-CreateButton>
            @foreach ( $products as $product)
            <tr >
                <td>{{$product->id}}</td>
                <td>{{$product->code}}</td>
                <td>{{$product->description}}</td>
                <td>{{$product->quantity}}</td>
                <td>{{$product->price}}</td>
                <td>
                  <x-EditButton wire:click="edit({{$product->id}})" class="fa-solid fa-pen-to-square fa-xl" ></x-EditButton>
                  <x-DelateButton wire:click="delete({{$product->id}})"></x-DelateButton>
                </td>
              </tr>
                @endforeach
            
          </tbody>  
        </table>
          @if ($products->hasPages())
             <div class="px-10 py-10 mx-10 my-10">  
             {{ $products->links() }}
            </div>
          @endif
   
      </div>