<div>
    <div class="overflow-x-auto">
        
        <table class="table  mx-20" style="width:85%">
          <!-- head -->
          <x-CreateButton wire:click="create()"></x-CreateButton>
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
            @foreach ( $allproducts as $product)
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
      </div>

