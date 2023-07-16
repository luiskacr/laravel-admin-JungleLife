<?php

namespace App\Notifications;

use App\Models\Approval;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendApprovalRequest extends Notification implements ShouldQueue
{
    use Queueable;

    protected User $user;

    protected Approval $approval;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($approval, $user)
    {
        $this->approval = $approval;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via(mixed $notifiable):array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting(__('app.Hello', ['object' => $this->user->name] ))
                    ->subject(__('app.approval_subject') . config('app.name'))
                    ->line(__('app.approval_mgs1') . $this->approval->getTour->title )
                    ->action(__('app.approval_btn'), url( route('approvals.edit', $this->approval->id ) ))
                    ->line(__('app.welcome_thanks'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
