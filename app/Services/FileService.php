<?php

namespace App\Services;

use App\Models\File;
use Illuminate\Http\Response;

class FileService
{
    public function download(File $file)
    {
        $filePath = storage_path('app/public/' . $file['filePath']);

        if (file_exists($filePath)) {

            return response()->download($filePath, $file['fileName']);
        }
        return response()->json('File not found', Response::HTTP_NOT_FOUND);
    }
}
