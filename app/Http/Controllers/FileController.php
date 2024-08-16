<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Services\FileService;

class FileController extends Controller
{
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function download(File $file)
    {
        return $this->fileService->download($file);
    }
}
