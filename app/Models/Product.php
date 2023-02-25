<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

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
        'money' => 'integer',
    ];


    public function moneyType()
    {
        return $this->belongsTo(MoneyType::class,'money','id');
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class,'type','id');
    }
}
