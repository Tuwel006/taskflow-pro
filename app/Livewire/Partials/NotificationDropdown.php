<?php

namespace App\Livewire\Partials;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationDropdown extends Component
{
    public function getNotificationsProperty()
    {
        return Auth::user()->unreadNotifications()->latest()->take(5)->get();
    }

    public function markAsRead($notificationId)
    {
        $notification = Auth::user()->notifications()->find($notificationId);
        if ($notification) {
            $notification->markAsRead();
        }
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
    }

    public function render()
    {
        return view('livewire.partials.notification-dropdown', [
            'notifications' => $this->notifications,
            'unreadCount' => Auth::user()->unreadNotifications()->count()
        ]);
    }
}
