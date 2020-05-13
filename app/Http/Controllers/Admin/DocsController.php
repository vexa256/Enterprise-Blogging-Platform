<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DocsController extends Controller
{
    public function __construct()
    {
        if (!env('APP_DEMO')) {
            $this->middleware('Admin');
        }

        parent::__construct();
    }

    public function show()
    {
        return view('vendor.docs.index');
    }
}
