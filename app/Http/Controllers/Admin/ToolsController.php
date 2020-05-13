<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ToolsController extends MainAdminController
{

    public $tmpFolder = 'upload/tmp/';
    public $filesystem = 'local';

    public $tmpFolderPath;

    public function __construct()
    {
        parent::__construct();

        $this->middleware('DemoAdmin', ['only' => ['removeTmpFolder']]);

        $this->file_system =  env('FILESYSTEM_DRIVER');
        $this->tmpFolderPath = public_path($this->tmpFolder);
    }

    public function index()
    {
        $tmp_files = [];
        $file_size = 0;
        $folder_size = 0;
        $file_count = 0;
        $file_system = $this->file_system;

        if ($this->file_system === "s3") {
            $tmp_files = Storage::disk('s3')->allFiles($this->tmpFolder);
            $file_count = count($tmp_files);

            $folder_size = array_sum(array_map(function ($file) {
                return (int) $file['size'];
            }, array_filter(Storage::disk('s3')->listContents($this->tmpFolder, true /*<- recursive*/), function ($file) {
                return $file['type'] == 'file';
            })));
        } else {
            if (File::exists($this->tmpFolderPath)) {
                $tmp_files = File::allFiles($this->tmpFolderPath);
                $file_count = count($tmp_files);
            }
            if ($tmp_files) {
                foreach ($tmp_files as $file) {
                    $file_size += $file->getSize();
                }
            }
        }

        $folder_size = number_format($file_size / 1048576, 2);

        return view('_admin.pages.tools', compact('file_system', 'file_count', 'folder_size'));
    }

    public function removeTmpFolder()
    {
        try {
            if ($this->file_system === "s3") {
                Storage::disk('s3')->deleteDirectory($this->tmpFolder);
            } else {
                if (File::exists($this->tmpFolderPath)) {
                    File::deleteDirectory($this->tmpFolderPath);
                }
            }

            \Session::flash('success.message', trans("admin.Deleted"));
        } catch (\Exception $e) {
            \Session::flash('error.message', $e->getMessage());
        }

        return redirect()->back();
    }
}
