<?php

namespace App\Http;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UploadManager
{
    /**
     * Akbilisim API URI.
     *
     * @todo change the api url
     *
     * @var stringvom
     */
    public $path = 'upload/tmp/';

    public $mimes = ['jpg', 'jpeg', 'gif', 'png'];

    public $mime;

    public $max = 2000;

    /**
     * Retrieve a file from the request.
     *
     * @var string
     */
    public $file_name = '';

    /**
     * Retrieve a file from the request.
     *
     * @var string
     */
    public $file_name_size = '';

    /**
     * Retrieve a file from the request.
     *
     * @var string
     */
    public $file_mime = '';

    /**
     * Saves encoded image in filesystem
     *
     * @var \Intervention\Image\Image
     */
    public $file;

    /**
     * Saves encoded image in filesystem
     *
     * @var \Intervention\Image\Image
     */
    public $image;

    /**
     * Saved Images
     *
     * @var array
     */
    public $images = [];

    public $request;

    public $full_path;

    public $date_path;

    public $gif = false;

    public $is_s3 = false;

    public function __construct()
    {
        $this->is_s3 = env('FILESYSTEM_DRIVER') === "s3";

        if ($this->is_s3) {
            $this->checkS3Conf();
        }

        $this->date_path = date('Y-m') . '/' . date('d') . '/';
    }

    public function path($path)
    {
        $path = '/' . ltrim($path, '/');
        $path = rtrim($path, '/') . '/';
        $this->path = $path;
    }

    public function date_path($date_path)
    {
        $date_path = ltrim($date_path, '/');
        $date_path = rtrim($date_path, '/') . '/';
        $this->date_path = $date_path;
    }

    public function name($file_name)
    {
        $file_name = ltrim($file_name, '/');
        $file_name = rtrim($file_name, '/');
        $this->file_name = $file_name;
    }

    public function mimes($mimes)
    {
        $this->mimes = $mimes;
    }

    public function mime($mime)
    {
        $this->mime = trim($mime);
    }

    public function file_mime($mime)
    {
        $this->file_mime = str_replace('image/', '', str_replace('.', '', trim($mime)));
    }

    public function acceptGif()
    {
        $this->gif = true;
    }

    public function file(Request $request, $file_input = 'file')
    {
        try {
            if (!$request->hasFile($file_input)) {
                throw new \Exception("No images");
            }

            $validator = $this->validator($request->all(), $file_input);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            $this->file = $request->file($file_input);

            $this->file_mime($this->file->getMimeType());

            if (!$this->checkMime() || !$this->checkUrlMime($this->file->getClientOriginalName())) {
                throw new \Exception("No valid images");
            }
        } catch (\Exception $e) {
            throw new \Exception(
                $e->getMessage()
            );
        }
    }

    public function setUrlFile($file)
    {
        if (!empty($file) && empty($this->file)) {
            // set url file
            $this->file = substr($file, 0, 4) === 'http' ? $file : $this->public_path($file);
        }
    }

    public function make()
    {
        try {
            if (empty($this->file)) {
                throw new \Exception("No valid image to make");
            }

            $this->image = Image::make($this->file);

            $this->file_mime($this->image->mime());

            if (!$this->checkMime()) {
                throw new \Exception("No valid images");
            }

            return $this->image;
        } catch (\Exception $e) {
            throw new \Exception(
                $e->getMessage()
            );
        }

        return false;
    }

    public function save($args = [])
    {
        try {
            if ($this->gif && $this->file_mime === 'gif') {
                $this->mime = 'gif';
                $this->saveGif();
                return;
            }

            if (isset($args['image_size'])) {
                $this->file_name_size = $args['image_size'];
            }

            $fit_width = isset($args['fit_width']) ? $args['fit_width'] : null;
            $fit_height = isset($args['fit_height']) ? $args['fit_height'] : null;
            $fit_call = isset($args['fit_call']) ? $args['fit_call'] : null;
            $fit_pos = isset($args['fit_pos']) ? $args['fit_pos'] : 'center';

            if ($fit_width !== null  || $fit_height !== null) {
                $this->image->fit($args['fit_width'], $fit_height, $fit_call, $fit_pos);
            }

            $resize_width = isset($args['resize_width']) ? $args['resize_width'] : null;
            $resize_height = isset($args['resize_height']) ? $args['resize_height'] : null;
            $resize_call = isset($args['resize_call']) ? $args['resize_call'] : function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            };

            if ($resize_width !== null || $resize_height !== null) {
                $this->image->resize($resize_width, $resize_height, $resize_call);
            }

            $full_path = $this->getSaveFullPath();

            if ($this->is_s3) {
                Storage::disk('s3')->put($full_path, $this->image->stream()->__toString());
            } else {
                $this->createFolder();
                $this->image->save($this->public_path($full_path));
                $this->checFileMime($this->public_path($full_path));
            }

            $this->images[] = array_merge($args, [
                'path' => $full_path
            ]);
        } catch (\Exception $e) {
            throw new \Exception(
                $e->getMessage()
            );
        }
    }

    public function saveGif()
    {
        try {
            $full_path = $this->getSaveFullPath();

            if ($this->is_s3) {
                Storage::disk('s3')->put($full_path, file_get_contents($this->file));
            } else {
                if ($this->file && method_exists($this->file, 'move')) {
                    $this->createFolder();
                    $this->file->move($this->public_path($this->getSavePath()), $this->getSaveName());
                } elseif (is_string($this->file)) { // url file
                    $this->createFolder();
                    copy($this->file, $this->public_path($full_path));
                    $this->checFileMime($this->public_path($full_path));
                }
            }

            $this->images[] = [
                'path' => $full_path
            ];
        } catch (\Exception $e) {
            throw new \Exception(
                $e->getMessage()
            );
        }
    }

    public function move()
    {
        try {
            $full_path = $this->getSaveFullPath();

            if ($this->is_s3) {
                Storage::disk('s3')->put($full_path, $this->file);
            } else {
                $this->createFolder();
                if ($this->file && method_exists($this->file, 'move')) {
                    $this->file->move($this->public_path($this->getSavePath()), $this->getSaveName());
                } elseif (is_string($this->file)) { // url file
                    rename($this->file, $this->public_path($full_path));
                }
            }

            $this->checFileMime($this->public_path($full_path));

            $this->images[] = [
                'path' => $full_path
            ];
        } catch (\Exception $e) {
            throw new \Exception(
                $e->getMessage()
            );
        }
    }

    public function currentDelete($image)
    {
        $this->delete($image);
    }

    public function delete($image)
    {
        try {
            if ($this->is_s3) {
                // for old versions
                if (strpos($image, 'amazonaws.com/upload') > 0) {
                    $image_r = explode('/upload', $image);
                    $image = 'upload' . $image_r[1];
                }
                $image = ltrim($image);

                if (Storage::disk('s3')->exists($image)) {
                    Storage::disk('s3')->delete($image);
                }
            } else {
                $this->removeFile($this->public_path($image));
            }
        } catch (\Exception $e) {
            throw new \Exception(
                $e->getMessage()
            );
        }
    }

    /**
     * Validator of question posts
     *
     * @param $inputs
     * @return array|bool
     */
    protected function validator(array $inputs, $file_input)
    {
        $mimes = implode(',', $this->mimes);

        $rules = [
            $file_input => 'required|mimes:' . $mimes . '|max:' . $this->max,
        ];

        return \Validator::make($inputs, $rules);
    }

    public function getSavedImages()
    {
        return $this->images;
    }

    public function getSaveMime()
    {
        return $this->mime ? $this->mime : $this->file_mime;
    }

    public function getSaveName()
    {
        if ($this->file_name_size) {
            return $this->file_name . '-' . $this->file_name_size . '.' . $this->getSaveMime();
        }

        return $this->file_name . '.' . $this->getSaveMime();
    }

    public function getSavePath()
    {
        if ($this->date_path) {
            return $this->path . $this->date_path;
        }

        return $this->path;
    }

    public function getSaveFullPath()
    {
        $this->full_path = $this->getSavePath() . $this->getSaveName();

        return $this->full_path;
    }

    public function getPathforSave()
    {
        if ($this->date_path) {
            return $this->date_path .  $this->file_name;
        }

        return $this->file_name;
    }

    public function getPathforSaveWithMime()
    {
        return  $this->getPathforSave() . '.' . $this->getSaveMime();
    }

    public function getFullPath()
    {
        return $this->full_path;
    }

    public function getFullUrl()
    {
        if ($this->is_s3) {
            return awsurl(ltrim($this->full_path, '/'));
        }

        return $this->full_path;
    }

    public function checkMime($mime = '')
    {
        if (empty($mime)) {
            $mime = $this->file_mime;
        }

        return in_array($mime, $this->mimes);
    }

    public function checkUrlMime($url)
    {
        foreach ($this->mimes as $mime) {
            if (strpos($url, '.' . $mime) > 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * Extra Step
     *
     * @param string $public_path
     * @return void
     */
    public function checFileMime($public_path)
    {
        if (!$this->checkUrlMime($public_path)) {
            $this->removeFile($public_path);
            throw new \Exception("No valid images");
        }
    }

    public function createFolder()
    {
        File::makeDirectory($this->public_path($this->getSavePath()), 0755, true, true);
    }

    public function removeFile($public_path)
    {
        if (!File::exists($public_path)) {
            return;
        }

        File::delete($public_path);

        if (file_exists($public_path)) {
            @unlink($public_path);
        }
    }

    public function public_path($path)
    {
        $path = ltrim($path, '/');
        $path = rtrim($path, '/');
        return public_path($path);
    }

    public function checkS3Conf()
    {
        if (
            empty(env("AWS_DEFAULT_REGION"))
            || empty(env("AWS_BUCKET"))
            || empty(env("AWS_ACCESS_KEY_ID"))
            || empty(env("AWS_SECRET_ACCESS_KEY"))
        ) {
            throw new \Exception("AWS S3 configuration is not valid.");
        }
    }
}
