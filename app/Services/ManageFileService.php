<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\File;

class ManageFileService
{

    function uploadFile($file, $foldarName, $path = null)
    {
        if ($file !== Null) {
            $newpath = $file->store($foldarName, 'public');
            return $newpath;
        } else {
            return $path;
        }
    }
    function deleteFile($path)
    {
        if (file_exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }

    function getFile($path)
    {
        try {
            return response()->file(public_path($path));
        } catch (Exception $e) {
            return $e;
        }
    }
}
