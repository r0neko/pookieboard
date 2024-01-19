<?php

namespace App\Console;

use App\Console\Commands\ActivateModuleCommand;

use App\Console\Commands\DeactivateModuleCommand;
use App\Console\Commands\ServeCommand;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        ActivateModuleCommand::class,
        DeactivateModuleCommand::class,
        ServeCommand::class
    ];

    protected function schedule(Schedule $schedule)
    {
        //
    }
}
