<?php

namespace App\Http\Controllers\Installer;

use Illuminate\Routing\Controller;

class InstallerController extends Controller
{
	public function __construct()
	{
		// todo move this into middleware
		if ($this->is_installed() && !$this->is_update_needed()) {
			abort(503);
		}
	}

	public function is_installed()
	{
		return file_exists(storage_path('installed'));
	}

	public function is_update_needed()
	{
		$version = @file_get_contents(storage_path('installed'));
		return $version && version_compare($version, config('buzzy.version'), '<');
	}
}
