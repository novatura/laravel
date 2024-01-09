<?php

namespace App\Repositories\Interfaces;

interface HistoryRepositoryInterface 
{
    public function getAllHistory();
    public function getHistoryById($historyId);
}