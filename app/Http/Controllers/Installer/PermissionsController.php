<?php

namespace App\Http\Controllers\Installer;

use App\Installer\Helpers\PermissionsChecker;

class PermissionsController extends InstallerController
{
    public function index(PermissionsChecker $checker)
    {
        $permissions = $checker->check(
            config('buzzy.permissions')
        );
        return view('installer.install.permissions', compact('permissions'));
    }
}
