<?php

namespace App\Http\Controllers;

use App\Imports\AdvancedUserDataImport;
use App\Imports\NormalUserDataImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelFileController extends Controller
{
    public function advancedUserImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');

        if ($file->isValid()) {
            Excel::import(new AdvancedUserDataImport(), $file);

            return response()->json(['message' => 'File imported successfully'], 200);
        }
        else {
            return response()->json(['message' => 'Failed to upload file'], 500);
        }
    }

    public function normalUserImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');

        if ($file->isValid()) {
            Excel::import(new NormalUserDataImport(), $file);

            return response()->json(['message' => 'File imported successfully'], 200);
        }
        else {
            return response()->json(['message' => 'Failed to upload file'], 500);
        }
    }
}
