<?php

namespace App\Observers;

use App\Models\Tour;
use App\Traits\TourTraits;


class TourObserver
{
    use TourTraits;

    /**
     * Handle the Tour "updated" event.
     *
     * @param Tour $tour
     * @return void
     */
    public function updating(Tour $tour):void
    {
        $this->updatingObserver($tour);
    }

}
