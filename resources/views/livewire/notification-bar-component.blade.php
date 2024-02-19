<div class="dropdown">
    <div tabindex="0" role="button" class="flex items-center relative btn btn-circle">

        <x-icons.bell />

        @if ($hasUnreadNotifications)
            <span class="w-3 h-3 rounded-full bg-red-500 absolute top-0 right-0"></span>
        @endif
    </div>
    <ul tabindex="0"
        class="menu dropdown-content z-[1] shadow bg-base-100 rounded-box mt-4 flex flex-col p-2 max-h-96 overflow-y-scroll w-80 right-0 translate-x-1/4 md:translate-x-0">
        @if (count($notifications) > 0)
            @foreach ($notifications as $notification)
                <x-notification :id="$notification->id" :message="$notification->message" :link="$notification->link" :icon="$notification->icon"
                    :image="$notification->image" :color="$notification->color" :readAt="$notification->read_at" :date="$this->parseDate($notification->created_at)" />
            @endforeach
        @else
            <div class="flex flex-col items-center justify-center p-4 space-y-4">
                <x-icons.bell class="w-10 h-10" />
                <p>No new notifications</p>
            </div>
        @endif

    </ul>
</div>
