<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\RoleInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Requests\StoreRoleRequest;

class RoleController extends Controller
{

    private RoleInterface $roleRepository;

    public function __construct(RoleInterface $roleRepository) 
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Roles/Index', [
            'roles' => $this->roleRepository->getAllRoles(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $role = $this->roleRepository->getRoleById($id);

        return Inertia::render('Roles/Role', [
            'role' => $role
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->roleRepository->deleteRole($id);

        return response()->back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $values = $request->validated();

        $role = $this->roleRepository->createRole($values);

        return response()->json($role);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, $id)
    {

        $values = $request->validated();

        $this->roleRepository->updateRole($id, $values);

        return redirect()->back();
    }

    public function addPermission($roleId, $permissionId){
        $this->roleRepository->addPermission($roleId, $permissionId);

        return redirect()->back();
    }

    public function removePermission($roleId, $permissionId){
        $this->roleRepository->removePermission($id, $permissionId);

        return redirect()->back();
    }

}
