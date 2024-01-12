<?php

namespace App\Repositories;

use Novatura\Laravel\Core\Models\History;
use App\Repositories\Interfaces\HistoryInterface;

class HistoryRepository implements HistoryInterface
{

    protected History $history;

    public function __construct(History $history){
        $this->history = $history;
    }

    public function getAllHistory() 
    {
        return $this->history->all()->map(function ($history) {
            $history->new_data = json_decode($history->new_data);
            $history->old_data = json_decode($history->old_data);

            return $history;
        });
        
    }

    public function getHistoryById($historyId) 
    {
        return $this->history->findOrFail($historyId);
    }

}