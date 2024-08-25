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

    public function downloadInApp(File $file)
    {
        return $this->fileService->downloadInApp($file);
    }

    public function show($fileName)
    {
        return $this->fileService->show($fileName);
    }
}
