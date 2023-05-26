<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'total' => 'integer',
        'money' => 'integer',
        'exchange' => 'integer',
    ];

    public function getProduct()
    {
        return $this->belongsTo(Product::class,'product','id');
    }

    public function getMoney()
    {
        return $this->belongsTo(MoneyType::class,'money','id');
    }

}
