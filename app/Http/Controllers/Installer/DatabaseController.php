<?php

namespace App\Http\Controllers\Installer;

use PDO;
use App\Installer\Helpers\DatabaseManager;
use App\Installer\Requests\DatabaseRequest;

class DatabaseController extends InstallerController
{
	public function index()
	{
		return view('installer.install.database');
	}

	public function post(DatabaseRequest $request)
	{
		$config = [
			'db_host' => $request->get('host'),
			'db_database' => $request->get('database'),
			'db_port' => $request->get('port'),
			'db_username' => $request->get('username'),
			'db_password' => $request->get('password'),
			'db_prefix' => null
		];

		$dsn = 'mysql:host=' . $config['db_host'] . ';dbname=' . $config['db_database'];
		if ($config['db_port']) $dsn .= ";port=" . $config['db_port'];

		try {
			$db = new PDO($dsn, $config['db_username'], $config['db_password'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		} catch (\PDOException $e) {
			return redirect(url('installer/database'))
				->withErrors(['exception' => $e->getMessage()])
				->withInput();
		}

		set_buzzy_config('DB_HOST', $request->get('host'), false);
		set_buzzy_config('DB_PORT', $request->get('port'), false);
		set_buzzy_config('DB_DATABASE', $request->get('database'), false);
		set_buzzy_config('DB_USERNAME', $request->get('username'), false);
		set_buzzy_config('DB_PASSWORD', $request->get('password'), false);

		return redirect(url('installer/finish'));
	}

	public function finish(DatabaseManager $manager)
	{
		try {
			$response = $manager->migrateAndSeed();

			if ($response['status'] == 'error') {
				return redirect(url('installer/database'))
					->withErrors(['message' => $response['message']])
					->withInput();
			}

			set_buzzy_config('BUZZY_VERSION', config('buzzy.version'), false);
			@file_put_contents(storage_path('installed'), config('buzzy.version'));
		} catch (\Exception $e) {
			return redirect(url('installer/database'))
				->withErrors(['exception' => $e->getMessage()])
				->withInput();
		}

		\Session::flash('success.message', trans('installer.final.finished'));
		return redirect('/');
	}
}
