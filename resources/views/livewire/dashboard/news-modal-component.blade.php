<dialog id="my_modal_5" class="modal modal-bottom sm:modal-middle" open>
    <div class="modal-box">
        <h3 class="text-2xl">Upcoming events</h3>
        <ul>
            @foreach ($events as $event)
            @endforeach
        </ul>


        <div class="modal-action">
            <form method="dialog">
                <button class="btn">Close</button>
            </form>
        </div>
    </div>
</dialog>
