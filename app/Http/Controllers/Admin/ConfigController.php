<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class ConfigController extends MainAdminController
{

    public $laravel_config = [
        "APP_URL",
        "MAIL_DRIVER",
        "MAIL_HOST",
        "MAIL_PORT",
        "MAIL_USERNAME",
        "MAIL_PASSWORD",
        "MAIL_ENCRYPTION",
        "FILESYSTEM_DRIVER",
        "AWS_ACCESS_KEY_ID",
        "AWS_SECRET_ACCESS_KEY",
        "AWS_DEFAULT_REGION",
        "AWS_BUCKET",
    ];

    public function __construct()
    {
        $this->middleware('DemoAdmin', ['only' => ['setconfig']]);

        parent::__construct();
    }

    public function index()
    {
        return view('_admin.pages.config');
    }

    public function setconfig(Request $request)
    {
        $input = $request->all();

        $v = \Validator::make(
            $input,
            [
                'sitelogo' => 'mimes:png',
                'footerlogo' => 'mimes:png',
                'favicon' => 'mimes:png',
            ]
        );

        if ($v->fails()) {
            \Session::flash('error.message', $v->errors()->first());

            return redirect()->back()->withInput($input);
        }

        $sitelogo = $request->file('sitelogo');
        $footerlogo = $request->file('footerlogo');
        $favicon = $request->file('favicon');

        if ($footerlogo) {
            $footerlogo->move(public_path('assets/images'), 'flogo.png');
        }
        if ($sitelogo) {
            $sitelogo->move(public_path('assets/images'), 'logo.png');
        }
        if ($favicon) {
            $favicon->move(public_path('assets/images'), 'favicon.png');
        }

        if (isset($input['HomeColSec1Type1'])) {
            $input['HomeColSec1Type1'] = json_encode($input['HomeColSec1Type1']);
        }
        if (isset($input['HomeColSec2Type1'])) {
            $input['HomeColSec2Type1'] = json_encode($input['HomeColSec2Type1']);
        }
        if (isset($input['HomeColSec3Type1'])) {
            $input['HomeColSec3Type1'] = json_encode($input['HomeColSec3Type1']);
        }

        if (isset($input['headcode'])) {
            $input['headcode'] = rawurlencode($input['headcode']);
        }
        if (isset($input['footercode'])) {
            $input['footercode'] = rawurlencode($input['footercode']);
        }

        foreach ($input as $key => $value) {
            $prefix = !in_array($key, $this->laravel_config);

            if ($prefix) {
                $key = implode('_', ['CONF', $key]);
            }

            $file = \DotenvEditor::setKey($key, $value);
        }

        $file->save();

        \Session::flash('success.message', trans("admin.ChangesSaved"));

        return redirect()->back();
    }
}
