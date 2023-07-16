<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'type',
        'tourType',
        'money',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'type' => 'integer',
        'tourType' => 'integer',
        'money' => 'integer',
    ];

    /**
     * Return a Money Type Relation
     *
     * @return BelongsTo
     */
    public function moneyType():belongsTo
    {
        return $this->belongsTo(MoneyType::class,'money','id');
    }

    /**
     * Return a Product Type Relation
     *
     * @return BelongsTo
     */
    public function productType():belongsTo
    {
        return $this->belongsTo(ProductType::class,'type','id');
    }

    /**
     * Return a Tour Type Relation
     *
     * @return BelongsTo
     */
    public function getTourType():belongsTo
    {
        return $this->belongsTo(TourType::class,'tourType','id');
    }
}
