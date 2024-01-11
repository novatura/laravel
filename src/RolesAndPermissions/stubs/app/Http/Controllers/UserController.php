<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Response;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Repositories\Interfaces\UserInterface;
use App\Repositories\Interfaces\RoleInterface;

class UserController extends Controller
{

    private UserInterface $userRepository;
    private RoleInterface $roleRepository;

    public function __construct(UserInterface $userRepository, RoleInterface $roleRepository, ) 
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    /*
        Fetches data for a table of users
    */
    public function index() 
    {
        return Inertia::render('Users/Index', [
            'users' => $this->userRepository->getAllUsersWithRoles(),
            'roles' => $this->roleRepository->getAllRoles(),
        ]);
    }

    /*
        Fetches data for a single user, by ID
    */
    public function show(Request $request, $id): Response
    {
        return Inertia::render('Users/User', [
            'user' => $this->userRepository->getUserById($id),
        ]);
    }

    public function addRole(Request $request, $user_id, $role_id){
        try {
            $this->userRepository->addRole($user_id, $role_id);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'error' => $e->getMessage()
            ]);
        }

        return redirect()->back();
    }

    public function removeRole(Request $request, $user_id, $role_id){
        try {
            $this->userRepository->removeRole($user_id, $role_id);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'error' => $e->getMessage()
            ]);
        }

        return redirect()->back();
    }

    public function updateRoles(Request $request, $user_id){
        try {
            $this->userRepository->updateRoles($user_id, $request->roles);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'error' => $e->getMessage()
            ]);
        }
        return redirect()->back();
    }

    public function destroy($user_id){
        try {
            $this->userRepository->deleteUser($user_id);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'error' => $e->getMessage()
            ]);
        }

        return redirect()->back();

    }

}
