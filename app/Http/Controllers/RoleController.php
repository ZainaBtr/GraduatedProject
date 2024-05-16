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

        //return view('pages.RolePageForServiceManager',compact('allRecords'));
        return response()->json($allRecords, Response::HTTP_OK);
    }

    public function add(Role1 $request)
    {
        $recordStored = Role::create($request->validated());

        return response()->json($recordStored, Response::HTTP_OK);
    }

    public function delete(Role $role)
    {
        $role->delete();

        return response()->json(['message' => 'this record deleted successfully']);
    }

    public function deleteAll()
    {
        if (ServiceManager::where('userID', auth()->id())->where('position', 'provost')->exists()) {

            Role::query()->delete();

            return response()->json(['message' => 'all records deleted successfully']);
        }
        return response()->json(['message' => 'you dont have the permission to delete all records in this table']);
    }

}
