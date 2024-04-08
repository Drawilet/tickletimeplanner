 <div @if ($eventClickEnabled) wire:click.stop="onEventClick('{{ $event['id'] }}')" @endif
     class="bg-neutral rounded-md p-1  border shadow-md cursor-pointer text-black {{ $event['isDraft'] ? 'opacity-50' : '' }}"
     style="background-color: {{ $event['isDraft'] ? '#EFEFEF' : $event['color'] }}">

     <p class="text-xs ">
         {{ $event['title'] }}
     </p>

 </div>
