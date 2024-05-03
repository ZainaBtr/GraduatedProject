<?php

namespace App\Http\Controllers;

use App\Http\Requests\File\File1;
use App\Models\Announcement;
use App\Models\File;
use Illuminate\Http\Request;

class FileController extends Controller
{

    public function download(File $file)
    {
        //
    }

    // request في تابع ال add file من اجل تخزين الفايل من ال request السابق
    public function add(File1 $request, Announcement $announcement)
    {
        //
    }

    public function delete(File1 $request, File $file)
    {
        //
    }

}
