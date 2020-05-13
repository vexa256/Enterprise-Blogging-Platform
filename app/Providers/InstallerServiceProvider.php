<?php

namespace App\Providers;

use App\Installer\Installer;
use Illuminate\Support\ServiceProvider;

class InstallerServiceProvider extends ServiceProvider
{
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->registerIfNotInstalled();
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	private function registerIfNotInstalled()
	{
		$installed = file_exists(storage_path('installed'));
		$version = $installed ? @file_get_contents(storage_path('installed')) : false;
		$update = $version && version_compare($version, config('buzzy.version'), '<');

		if (!$installed || $update) {
			if (
				$this->app['request']->is('installer/*')
				|| $this->app['request']->is('*/installer/*')
				|| $this->app['request']->is('register_product')
				|| $this->app['request']->is('/admin/handle-download')
			) {
				// dd("dasdas");
			} else {
				if ($update && $installed) {
					return $this->redirectTo(url('installer/update'));
				}

				return $this->redirectTo(url('installer/welcome'));
			}
		}
	}

	/**
	 * Redirect to url.
	 *
	 * @return void
	 */
	private function redirectTo($url)
	{
		echo '<script type="text/javascript">';
		echo 'window.location.href="' . $url . '";';
		echo '</script>';
		echo '<noscript>';
		echo '<meta http-equiv="refresh" content="0;url=' . $url . '" />';
		echo '</noscript>';
		exit();
	}
}
