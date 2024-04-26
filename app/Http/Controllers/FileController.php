<?php

namespace App\Http\Controllers;

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
    public function add( Announcement $announcement, Request $request)
    {
        //
    }

    public function delete(File $file , Request $request)
    {
        //
    }

}
