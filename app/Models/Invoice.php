<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client',
        'date',
        'total',
        'state',
        'type',
        'money',
        'exchange',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'client' => 'integer',
        'date' => 'date',
        'total' => 'integer',
        'state' => 'integer',
        'type' => 'integer',
        'money' => 'integer',
        'exchange' => 'integer',
    ];

    public function getClient()
    {
        return $this->belongsTo(Customer::class,'client','id');
    }

    public function getState()
    {
        return $this->belongsTo(InvoiceState::class,'state','id');
    }

    public function getType()
    {
        return $this->belongsTo(PaymentType::class,'type','id');
    }

    public function getMoney()
    {
        return $this->belongsTo(MoneyType::class,'money','id');
    }

    public function getExchange()
    {
        return $this->belongsTo(ExchangeRate::class,'exchange','id');
    }

    public function getProductsCount()
    {
        $invoiceDetails = InvoiceDetails::where('invoice','=', $this->id )->get();

        return count($invoiceDetails);
    }


}
