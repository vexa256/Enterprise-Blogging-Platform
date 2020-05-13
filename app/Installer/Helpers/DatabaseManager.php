<?php

namespace App\Installer\Helpers;

use Lang;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;

class DatabaseManager
{

    /**
     * Migrate and seed the database.
     *
     * @return array
     */
    public function migrateAndSeed()
    {
        Artisan::call('key:generate', ['--force' => true]);
        return $this->migrate();
    }

    /**
     * Execute migrations and seeders.
     *
     * @return array
     */
    public function updateDatabaseAndSeedTables()
    {
        return $this->updateDatabase();
    }

    /**
     * Run the migration and call the seeder.
     *
     * @return array
     */
    private function migrate()
    {
        try {
            Artisan::call('migrate', ['--force' => true]);
        } catch (Exception $e) {
            return $this->response($e->getMessage());
        }
        return $this->seed();
    }

    /**
     * Seed the database.
     *
     * @return array
     */
    private function seed()
    {
        try {
            Artisan::call('db:seed', ['--force' => true]);
        } catch (Exception $e) {
            return $this->response($e->getMessage());
        }
        return $this->finish();
    }

    /**
     * Update the database.
     *
     * @return array
     */
    private function updateDatabase()
    {
        $migrations = config('buzzy.upgrade.migrations');
        if (is_array($migrations)) {
            try {
                $database_path = database_path();

                foreach ($migrations as $key => $value) {
                    Artisan::call('migrate', ['--path' => $database_path . "/migrations/" . $value, '--force' => true]);
                }
            } catch (Exception $e) {
                return $this->response($e->getMessage(), 'error');
            }
        } else {
            Artisan::call('migrate', ['--force' => true]);
        }
        return $this->updateSeed();
    }

    /**
     * Seed the database.
     *
     * @return array
     */
    private function updateSeed()
    {
        $seeds = config('buzzy.upgrade.seeds');
        if (!empty(config('buzzy.upgrade.seeds'))) {
            try {
                foreach ($seeds as $key => $value) {
                    Artisan::call('db:seed', ['--class' => $value, '--force' => true]);
                }
            } catch (Exception $e) {
                return $this->response($e->getMessage(), 'error');
            }
        }
        return $this->finish();
    }

    /**
     * Return a formatted error messages.
     *
     * @param  $message
     * @param  string  $status
     * @return array
     */
    private function finish()
    {
        try {
            Cache::flush();

            set_buzzy_config('APP_ENV', 'production', false);
        } catch (Exception $e) {
           //
        }
    
        return $this->response(Lang::get('installer.final.finished'), 'success');
    }

    /**
     * Return a formatted error messages.
     *
     * @param  $message
     * @param  string  $status
     * @return array
     */
    private function response($message, $status = 'error')
    {
        return array(
            'status' => $status,
            'message' => $message
        );
    }
}
