<?php

namespace App\Models;

use App\Notifications\WelcomeEmailNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class NewUser extends Model
{
    use HasFactory,Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'name',
        'token',
    ];

    /**
     * Send the Welcome Message a Password create for a new User
     *
     * @return void
     */
    public function sendMail():void
    {
        $this->notify(new WelcomeEmailNotification($this));
    }
}
