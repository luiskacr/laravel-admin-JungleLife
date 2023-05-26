<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourGuides extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tour',
        'guides',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tour' => 'integer',
        'guides'=> 'integer',
    ];

    public function getGuides()
    {
        return $this->belongsTo(Guides::class,'guides','id');
    }

    public function getTour()
    {
        return $this->belongsTo(Tour::class,'tour','id');
    }

}
