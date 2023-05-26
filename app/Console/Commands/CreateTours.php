<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateTours extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tours:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically creates the toures depending on the configurations ';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return Command::SUCCESS;
    }
}
