<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'start',
        'end',
        'info',
        'state',
        'type',
        'user',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
        'state' => 'integer',
        'type' => 'integer',
        'user' => 'integer',
    ];

    public function tourState()
    {
        return $this->belongsTo(TourState::class,'state','id');
    }

    public function tourType()
    {
        return $this->belongsTo(TourType::class,'type','id');
    }

    public function getUser()
    {
        return $this->belongsTo(User::class,'user','id');
    }

    public function availableSpace()
    {
        $config = Configuration::select('data')->where('id', 1)->get();
        $clientTourMax = $config[0]->data["value"];
        $tourGuides = TourGuides::where('tour',"=",$this->id)->count();
        $tourClients = TourClient::where('tour',"=",$this->id)->count();
        $available = ($tourGuides==0) ? $clientTourMax : $tourGuides * $clientTourMax;
        return $available - $tourClients;
    }
}
