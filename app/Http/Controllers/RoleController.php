<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\Role1;
use App\Models\Role;
use App\Models\ServiceManager;
use Illuminate\Http\Response;

class RoleController extends Controller
{

    public function showAll()
    {
        $allRecords = Role::all();

        if (request()->is('api/*')) {
            return response()->json($allRecords, Response::HTTP_OK);
        }
        return view('pages.RolePageForServiceManager',compact('allRecords'));
    }

    public function add(Role1 $request)
    {
        $recordStored = Role::create($request->validated());

        if (request()->is('api/*')) {
            return response()->json($recordStored, Response::HTTP_OK);
        }
        return redirect()->back();
    }

    public function delete(Role $role)
    {
        $role->delete();

        if (request()->is('api/*')) {
            return response()->json(['message' => 'this record deleted successfully']);
        }
        return view('');
    }

    public function deleteAll()
    {
        if (ServiceManager::where('userID', auth()->id())->where('position', 'provost')->exists()) {

            Role::query()->delete();

            if (request()->is('api/*')) {
                return response()->json(['message' => 'all records deleted successfully']);
            }
            return view('');
        }
        if (request()->is('api/*')) {
            return response()->json(['message' => 'you dont have the permission to delete all records in this table']);
        }
        return view('');
    }

}
