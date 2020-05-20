<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\MasterNonPivotGen::class,
        Commands\HisaniMessage::class,
        Commands\SMSViewGen::class,
        Commands\SMSFieldGen::class,
        Commands\SMSSeederGen::class,
        Commands\SMSManupulator::class,
        Commands\RiversideGen::class,
        Commands\MasterGen::class,
        Commands\LyricalGenius::class,
        Commands\SetEnvVariable::class,
        Commands\RVSUserTokens::class,
        Commands\RVSGameCreateUpdate::class,
        Commands\RVSUserCreateUpdate::class,
        Commands\RVSPredictionCreateUpdate::class,
        Commands\ML4AfrikaMap::class,
        Commands\ML4AfrikaDemoRequest::class,
        Commands\ML4AfrikaDemoReport::class,
        Commands\ML4AfrikaSingularMap::class,
        Commands\ML4AfrikaSeed::class,
        Commands\ML4AfrikaCommunication::class,
        Commands\MedbookCommunication::class,
        Commands\SanitasCommunication::class,
        Commands\ChemistryOrder::class,
        Commands\SeedFromBLIS25::class,
        Commands\ML4AfrikaDriveByMap::class,
        Commands\TPAAccessGet::class,
        Commands\TPAAccessPost::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
