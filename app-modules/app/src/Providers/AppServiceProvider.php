<?php

namespace Tequia\App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	public function register(): void
	{
		 $this->app->register(AppPanelProvider::class);
	}
	
	public function boot(): void
	{
	}
}
