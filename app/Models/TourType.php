<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name' ,
        'money',
        'fee1' ,
        'fee2' ,
        'fee3' ,
        'fee4' ,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fee1' => 'decimal:2',
        'fee2' => 'decimal:2',
        'fee3' => 'decimal:2',
        'fee4' => 'decimal:2',
        'money' => 'integer',
    ];

    /**
     * Return a Money Type relation
     *
     * @return BelongsTo
     */
    public function moneyType():BelongsTo
    {
        return $this->belongsTo(MoneyType::class,'money','id');
    }
}
