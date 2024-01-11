<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddUsersToRoleRequest;
use App\Http\Requests\DestroyRoleRequest;
use App\Repositories\Interfaces\RoleInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRolePermissionRequest;
use App\Repositories\Interfaces\PermissionInterface;
use App\Repositories\Interfaces\UserInterface;

class RoleController extends Controller
{

    private RoleInterface $roleRepository;
    private PermissionInterface $permissionRepository;
    private UserInterface $userRepository;

    public function __construct(RoleInterface $roleRepository, PermissionInterface $permissionRepository, UserInterface $userRepository) 
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
        $this->userRepository = $userRepository;
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
            'role' => $role,
            'permissions' => $this->permissionRepository->getAllPermission(),
            'users' => $this->userRepository->getAllUsersWithRole($id),
            'users_without' => $this->userRepository->getAllUsersWithoutRole($id),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyRoleRequest $request, $id)
    {
        try {
            $request->validated();

            $this->roleRepository->deleteRole($id);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'error' => $e->getMessage()
            ]);
        }

        return redirect()->route('roles.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $values = $request->validated();

        try {
            $this->roleRepository->createRole($values);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'error' => $e->getMessage()
            ]);
        }

        return redirect()->back();
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

    public function updatePermission(UpdateRolePermissionRequest $request, $roleId){
        $values = $request->validated();
        
        $this->roleRepository->updatePermission($roleId, $values['permissions']);

        return redirect()->back();
    }

    public function addUsers(AddUsersToRoleRequest $request, $roleId){
        $values = $request->validated();

        $this->roleRepository->addUsers($roleId, $values['users']);

        return redirect()->back();
    }

}
