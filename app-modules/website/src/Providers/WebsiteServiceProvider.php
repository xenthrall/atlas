<?php

namespace Tequia\Website\Providers;

use Filament\Panel;
use Illuminate\Support\ServiceProvider;
use Tequia\Website\WebsitePlugin;

class WebsiteServiceProvider extends ServiceProvider
{
    /**
     * Register the module's services and configure the Filament panel.
     */
    public function register(): void
    {
        Panel::configureUsing(function (Panel $panel): void {
            if ($panel->getId() === 'atlas') {
                $panel->plugin(WebsitePlugin::make());
            }
        });
    }

    /**
     * Bootstrap the module's services.
     */
    public function boot(): void
    {
		
    }
}