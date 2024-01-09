<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Repositories\Interfaces\HistoryInterface;

class HistoryController extends Controller
{

    private HistoryInterface $historyRepository;

    public function __construct(HistoryInterface $historyRepository) 
    {
        $this->historyRepository = $historyRepository;
    }

    public function index(){

        \App\Models\User::createWithHistory([
            'first_name' => 'John',
            'last_name' => 'Baker',
            'email' => 'john@example.com',
            'password' => 'password',
        ], 'Creating a new User');

        return Inertia::render('History/History', [
            'history' => $this->historyRepository->getAllHistory(),
        ]);
    }
}
