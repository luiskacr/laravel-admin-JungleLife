<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'bookings',
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
        'bookings'=> 'integer',
        'present' => 'boolean',
        'invoice' => 'integer',
    ];

    public function getClient()
    {
        return $this->belongsTo(Customer::class,'client','id');
    }

    public function getTour()
    {
        return $this->belongsTo(Tour::class,'tour','id');
    }

    public function getInvoice()
    {
        return $this->belongsTo(Invoice::class,'invoice','id');
    }

    public function getCount()
    {
        return $this->invoice == 0
            ? 0
            :  $this->getInvoice->getProductsCount();
    }

}
