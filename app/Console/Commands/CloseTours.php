<?php

namespace App\Console\Commands;

use App\Models\Configuration;
use App\Models\Tour;
use App\Traits\TourTraits;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CloseTours extends Command
{
    use TourTraits;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tours:close';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Review all tours in process and close those that are open.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle():int
    {
        return $this->closeTours();
    }
}
