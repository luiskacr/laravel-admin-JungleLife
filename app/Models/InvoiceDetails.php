<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceDetails extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'invoice',
        'product',
        'tour',
        'quantity',
        'price',
        'total',
        'money',
        'exchange',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'invoice' => 'integer',
        'tour' => 'integer',
        'product' => 'integer',
        'quantity' => 'integer',
        'price' => 'decimal:2',
        'total' => 'decimal:2',
        'money' => 'integer',
        'exchange' => 'integer',
    ];

    /**
     * Return a Product Relation
     *
     * @return BelongsTo
     */
    public function getProduct():belongsTo
    {
        return $this->belongsTo(Product::class,'product','id')->withTrashed();
    }

    /**
     * Return a Money Type Relation
     *
     * @return BelongsTo
     */
    public function getMoney():belongsTo
    {
        return $this->belongsTo(MoneyType::class,'money','id');
    }

}
