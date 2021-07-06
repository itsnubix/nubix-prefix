<?php


namespace Nubix\Preset;

use Illuminate\Support\ServiceProvider;
use Laravel\Ui\UiCommand;

class PresetServiceProvider extends ServiceProvider
{
    public function boot()
    {
        UiCommand::macro('nubix', function ($command) {
            // Do the preset work
            Preset::install();

            // Let the user know what we've done
            $command->info('Your preset has been installed successfully.');

            $command->comment('Please run "composer install && npm install && npm run dev" to compile your new assets.');
        });
    }
}
