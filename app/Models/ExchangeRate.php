<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'buy',
        'sell',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date'=> 'date',
        'buy' => 'integer',
        'sel'=> 'integer'
    ];

    /**
     * Return an Exchange Rate format Text Name
     *
     * @return string
     */
    public function getTextName():string
    {
        return __('app.exchange_buy') . ': ' . $this->buy . " " . __('app.exchange_sell') . ': ' . $this->sell;
    }

}
