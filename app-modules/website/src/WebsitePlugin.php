<?php

namespace Tequia\Website;

use Filament\Contracts\Plugin;
use Filament\Panel;

class WebsitePlugin implements Plugin
{
    public function getId(): string
    {
        return 'tequia-website';
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public function register(Panel $panel): void
    {
        $panel
            ->discoverResources(
                in: __DIR__ . '/Filament/Resources',
                for: 'Tequia\\Website\\Filament\\Resources',
            )
            ->discoverPages(
                in: __DIR__ . '/Filament/Pages',
                for: 'Tequia\\Website\\Filament\\Pages',
            )
            ->discoverWidgets(
                in: __DIR__ . '/Filament/Widgets',
                for: 'Tequia\\Website\\Filament\\Widgets',
            );
    }

    public function boot(Panel $panel): void
    {
        //
    }
}