<?php

namespace App\Services;

use App\Models\File;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

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

    public function downloadInApp(File $file)
    {
        $fileUrl = url('storage/' . $file['filePath']);

        if (file_exists(storage_path('app/public/' . $file['filePath']))) {

            return response()->json(['fileUrl' => $fileUrl], Response::HTTP_OK);
        }
        return response()->json('File not found', Response::HTTP_NOT_FOUND);
    }

    public function show($fileName)
    {
        $filePath = 'public/uploads/' . $fileName;

        if (Storage::exists($filePath)) {

            $file = Storage::get($filePath);

            $mimeType = Storage::mimeType($filePath);

            return response($file, 200)->header('Content-Type', $mimeType);
        }
        else {
            return response()->json(['error' => 'File not found.'], 404);
        }
    }
}
