<?php

namespace App\Http\Livewire;

use App\Models\Notification;
use Carbon\Carbon;
use Livewire\Component;

class NotificationBarComponent extends Component
{
    protected $listeners = ['addNotification'];

    public $user, $notifications;
    public $hasUnreadNotifications = false;

    public function mount()
    {
        $this->user = auth()->user();
        $this->notifications = $this->user->notifications()->orderBy('created_at', 'desc')->get() ?? [];
    }

    public function render()
    {
        $this->hasUnreadNotifications = $this->notifications->whereNull('read_at')->count() > 0;

        return view('livewire.notification-bar-component');
    }

    public function parseDate($date)
    {
        return Carbon::parse($date)->isoFormat('DD MMM YYYY [at] HH:mm');
    }

    public function addNotification($data)
    {
        $data['user_id'] = $this->user->id;
        $notification = new Notification($data);
        $notification->save();
        $this->notifications->prepend($notification);
    }

    public function markAsRead($id)
    {
    }

    public function click($id)
    {
        $notification = $this->notifications->where('id', $id)->first();
        $notification->read_at = Carbon::now();
        $notification->save();

        $this->redirect($notification->link);
    }
}
