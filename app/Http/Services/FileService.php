<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Storage;

class FileService
{
    public function saveFile($file, $folder, $fileName = null)
    {
        $extension = $file->getClientOriginalExtension();
        $fileName = $fileName ?? uniqid() . '.' . $extension;

        // Store the file in the specified folder
        Storage::putFileAs('public/' . $folder, $file, $fileName);

        return $fileName;
    }
}