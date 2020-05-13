<?php

namespace App\Http\Controllers\Installer;

use App\Installer\Helpers\DatabaseManager;

class UpdateController extends InstallerController
{
	public function update()
	{
		return view('installer.update.home');
	}

	public function update_init(DatabaseManager $manager)
	{
		$response = $manager->updateDatabaseAndSeedTables();

		// upgrade
		if ($response['status'] == 'error') {
			\Session::flash('error.message', $response['message']);
			return redirect(url('installer/update'));
		}

		set_buzzy_config('BUZZY_VERSION', config('buzzy.version'), false);
		@file_put_contents(storage_path('installed'), config('buzzy.version'));

		\Session::flash('success.message', trans('installer.upgrade.finished'));
		return redirect('/');
	}
}
