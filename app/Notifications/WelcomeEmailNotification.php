<?php

namespace App\Notifications;

use App\Models\NewUser;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeEmailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var NewUser
     */
    public NewUser $newUser;



    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(NewUser $newUser)
    {
        $this->newUser = $newUser;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
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
        $url = $this->createUrl();

        return (new MailMessage)
                    ->greeting(__('app.Hello', ['object' => $this->newUser->name ]))
                    ->subject(__('app.welcome_subject') . config('app.name'))
                    ->line(__('app.welcome_mgs1'))
                    ->action(__('app.welcome_btn'), $url)
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

    /**
     *  Create a URL for the given notification
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function createUrl()
    {
        return url( route('password.new-user',[
            'token' => $this->newUser->token,
            'email'=> $this->newUser->email,
        ]));
    }
}
