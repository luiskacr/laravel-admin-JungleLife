<?php

namespace App\Models;

use App\Notifications\SendApprovalRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;

class Approval extends Model
{
    use HasFactory,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'old',
        'new',
        'user',
        'reviewer',
        'tour',
        'state',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'old' => 'integer',
        'new' => 'integer',
        'user' => 'integer',
        'reviewer' => 'integer',
        'tour' => 'integer',
        'state' => 'integer',
    ];

    /**
     * Return a Tour relation
     *
     * @return BelongsTo
     */
    public function getTour():BelongsTo
    {
        return $this->belongsTo(Tour::class,'tour','id')->withTrashed();
    }

    /**
     *  Return a User relation
     *
     * @return BelongsTo
     */
    public function getUser():BelongsTo
    {
        return $this->belongsTo(User::class,'user','id')->withTrashed();
    }

    /**
     * Return a User/Approve relation
     *
     * @return BelongsTo
     */
    public function getApprover():BelongsTo
    {
        return $this->belongsTo(User::class,'reviewer','id')->withTrashed();
    }

    /**
     * Return a Approve State relation
     *
     * @return BelongsTo
     */
    public function getState():BelongsTo
    {
        return $this->belongsTo(ApprovalOption::class, 'state', 'id');
    }

    public function sendAdminNotification()
    {
        $admins = User::role('Administrador')->get();

        foreach ($admins as $admin){
            Notification::sendNow($admin, new SendApprovalRequest($this,$admin ));
        }
    }

}
