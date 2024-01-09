<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Response;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Repositories\Interfaces\UserInterface;

class UserController extends Controller
{

    private UserInterface $userRepository;

    public function __construct(UserInterface $userRepository) 
    {
        $this->userRepository = $userRepository;
    }

    /*
        Fetches data for a table of users
    */
    public function index() 
    {
        return Inertia::render('Users/Index', [
            'users' => $this->userRepository->getAllUsersWithRoles(),
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
        $this->userRepository->addRole($user_id, $role_id);

        return redirect()->back();
    }

    public function removeRole(Request $request, $user_id, $role_id){
        $this->userRepository->removeRole($user_id, $role_id);

        return redirect()->back();
    }

}
