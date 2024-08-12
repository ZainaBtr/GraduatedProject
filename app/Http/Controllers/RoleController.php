<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\Role1;
use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Http\Response;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function showAll()
    {
        $allRecords = $this->roleService->getAllRoles();

        if (request()->is('api/*')) {

            return response()->json($allRecords, Response::HTTP_OK);
        }
        return view('pages.RolePageForServiceManager', compact('allRecords'));
    }

    public function add(Role1 $request)
    {
        $recordStored = $this->roleService->createRole($request->validated());

        if (request()->is('api/*')) {

            return response()->json($recordStored, Response::HTTP_OK);
        }
        return redirect()->back();
    }

    public function delete(Role $role)
    {
        $response = $this->roleService->deleteRole($role);

        if (request()->is('api/*')) {

            return response()->json($response);
        }
        return redirect()->back();
    }

    public function deleteAll()
    {
        $response = $this->roleService->deleteAllRoles();

        if (request()->is('api/*')) {

            return response()->json($response);
        }
        return redirect()->back();
    }
}
