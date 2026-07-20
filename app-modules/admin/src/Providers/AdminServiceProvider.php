<?php

namespace Tequia\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
	public function register(): void
	{
		$this->app->register(AdminPanelProvider::class);
	}

	public function boot(): void {}
}
