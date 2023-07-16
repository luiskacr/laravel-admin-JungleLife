<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


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

    /**
     * Return a Guides relation
     *
     * @return BelongsTo
     */
    public function getGuides():belongsTo
    {
        return $this->belongsTo(Guides::class,'guides','id');
    }

    /**
     * Return a Tour relation
     *
     * @return BelongsTo
     */
    public function getTour():belongsTo
    {
        return $this->belongsTo(Tour::class,'tour','id');
    }

}
