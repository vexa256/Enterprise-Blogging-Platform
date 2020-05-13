<?php

namespace App\Http\Controllers;

use App\Http\UploadManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UploadController extends Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function newUpload(Request $request)
    {
        $inputs = $request->all();

        $type = $request->query('type');

        $v = $this->validator($inputs);

        if ($v->fails()) {
            return array('status' => 'error', 'error' => $v->error()->first());
        }

        if ($request->hasFile('file')) {
            try {
                $image = new UploadManager();
                $image->file($request, 'file');
                $image->name(Auth::user()->id . '-' . md5(time()));
                $image->path('upload/tmp');
                $image->make();
                $image->mime('jpg');

                if ($type == 'entry') {
                    $image->acceptGif();
                    $image->save([
                        'resize_width' => config('buzzytheme_' . get_buzzy_config('CurrentTheme') . '.entry-image_big_width'),
                    ]);
                } elseif ($type == 'preview') {
                    $image->save([
                        'fit_width' => config('buzzytheme_' . get_buzzy_config('CurrentTheme') . '.preview-image_big_width'),
                        'fit_height' => config('buzzytheme_' . get_buzzy_config('CurrentTheme') . '.preview-image_big_height'),
                    ]);
                } elseif ($type == 'answer') {
                    $image->save([
                        'fit_width' => 250,
                        'fit_height' => 250,
                    ]);
                }

                return response()->json(array('status' => 'success', 'path' => $image->getFullUrl()), 200);
            } catch (\Exception $e) {
                return response()->json(array('status' => 'error', 'error' => $e->getMessage()),  200);
            }
        } else {
            return response()->json(array('status' => 'error', 'error' => 'Pick a image'),  200);
        }
    }

    /**
     * Validator of question posts
     *
     * @param $inputs
     * @return array|bool
     */
    protected function validator(array $inputs)
    {

        $rules = [
            'type' => 'required',
            'file' => 'required|mimes:jpg,jpeg,gif,png',
        ];

        return \Validator::make($inputs, $rules);
    }
}
