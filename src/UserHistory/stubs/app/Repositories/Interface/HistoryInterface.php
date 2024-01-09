<?php

namespace App\Repositories\Interfaces;

interface HistoryInterface 
{
    public function getAllHistory();
    public function getHistoryById($historyId);
}