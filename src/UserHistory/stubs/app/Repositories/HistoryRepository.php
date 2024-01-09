<?php

namespace App\Repositories;

use Novatura\Laravel\UserHistory\Lib\History;
use Interfaces\HistoryInterface;

class HistoryRepository implements HistoryInterface
{

    protected History $user;

    public function __construct(History $user){
        $this->user = $user;
    }

    public function getAllHistory() 
    {
        return $this->history->all()->map(function ($history) {
            $history->new_data = json_decode($history->new_data);
            $history->old_data = json_decode($history->old_data);

            return $history;
        });
        
    }

    public function getHistoryById($userId) 
    {
        return $this->user->findOrFail($userId);
    }

}