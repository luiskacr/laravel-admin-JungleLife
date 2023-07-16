<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourClient extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tour',
        'client',
        'guides',
        'bookings',
        'royalties',
        'present',
        'invoice',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tour' => 'integer',
        'client'=> 'integer',
        'guides'=> 'integer',
        'bookings'=> 'integer',
        'royalties'=> 'integer',
        'present' => 'boolean',
        'invoice' => 'integer',
    ];

    /**
     * Return a Customer Relation
     *
     * @return BelongsTo
     */
    public function getClient():belongsTo
    {
        return $this->belongsTo(Customer::class,'client','id')->withTrashed();
    }

    /**
     * Return a Tour Relation
     *
     * @return BelongsTo
     */
    public function getTour():belongsTo
    {
        return $this->belongsTo(Tour::class,'tour','id');
    }

    /**
     * Return an Invoice Relation
     *
     * @return BelongsTo
     */
    public function getInvoice():belongsTo
    {
        return $this->belongsTo(Invoice::class,'invoice','id')->withTrashed();
    }

    /**
     * Return a Guides Relation
     *
     * @return BelongsTo
     */
    public function getGuides():belongsTo
    {
        return $this->belongsTo(Guides::class,'guides','id');
    }

    /**
     * Get a Number of tour reservations
     *
     * @return int
     */
    public function getCount():int
    {
        return $this->invoice == 0
            ? 0
            :  $this->getInvoice->getProductsCount();
    }

    /**
     * Verified if booking reservation apply a pay
     *
     * @return bool
     */
    public function isApplyPay():bool
    {
        return $this->present == true and $this->guides != null;
    }

    /**
     * Returns the sum of reserves and royalties as the actual total reserves.
     *
     * @return int
     */
    public function realTotalBooking():int
    {
        return $this->bookings +  $this->royalties;
    }

}
