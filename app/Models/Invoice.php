<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory,SoftDeletes;

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
        'info',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'client' => 'integer',
        'date' => 'date',
        'total' => 'decimal:2',
        'state' => 'integer',
        'type' => 'integer',
        'money' => 'integer',
        'exchange' => 'integer',
    ];

    /**
     * Return a Client Relation
     *
     * @return BelongsTo
     */
    public function getClient():belongsTo
    {
        return $this->belongsTo(Customer::class,'client','id')->withTrashed();
    }

    /**
     * Return an Invoice State Relation
     *
     * @return BelongsTo
     */
    public function getState():belongsTo
    {
        return $this->belongsTo(InvoiceState::class,'state','id');
    }

    /**
     * Return a Payment Type Relation
     *
     * @return BelongsTo
     */
    public function getType():belongsTo
    {
        return $this->belongsTo(PaymentType::class,'type','id');
    }

    /**
     * Return a Money type Relation
     *
     * @return BelongsTo
     */
    public function getMoney():belongsTo
    {
        return $this->belongsTo(MoneyType::class,'money','id');
    }

    /**
     * Return a Exchange Relation
     *
     * @return BelongsTo
     */
    public function getExchange():belongsTo
    {
        return $this->belongsTo(ExchangeRate::class,'exchange','id');
    }

    /**
     * Return a Count Invoice Products
     *
     * @return int
     */
    public function getProductsCount():int
    {
        return count(InvoiceDetails::where('invoice','=', $this->id )->get());
    }

    /**
     * Get el Tour Id from Invoice
     *
     * @return int
     */
    public function getTourId():int
    {
        $invoiceDetail = InvoiceDetails::where('invoice', '=', $this->id)->whereNotNull('tour')->limit(1)->get();

        return $invoiceDetail[0]->tour;
    }

    /**
     * Validate if Invoices is a soft delete Values
     *
     * @return bool
     */
    public function isDeleted():bool
    {
        return $this->delete_at == null ;
    }

}
