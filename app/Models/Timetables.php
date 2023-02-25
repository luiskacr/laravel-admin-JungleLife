<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetables extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'start',
        'end',
        'auto',
        'type'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start' => 'datetime:H:i',
        'end' => 'datetime:H:i',
        'auto' => 'boolean',
        'type' => 'integer'
    ];

    public function tourType()
    {
        return $this->belongsTo(TourType::class,'type','id');
    }


}
