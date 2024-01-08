<?php

namespace Novatura\Laravel\Core\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

class ModelLoggingObserver
{

    public function created(Model $model)
    {
        $this->logHistory($model, 'created');
    }

    public function updated(Model $model)
    {
        $this->logHistory($model, 'updated');
    }

    public function deleted(Model $model)
    {
        $this->logHistory($model, 'deleted');
    }

    protected function logHistory(Model $model, string $action)
    {
        $user = Auth::user();

        $description = $user
            ? $user->name . ' ' . $action . ' a ' . class_basename($model)
            : 'An anonymous user ' . $action . ' a ' . class_basename($model);

        $oldData = null;
        if ($model->wasChanged()) {
            $oldData = $this->prepareData($model->getOriginal(), $model->getHidden());
        }
    
        $newData = $this->prepareData($model->getAttributes(), $model->getHidden());

        Log::build([
                'driver' => 'single',
                'path' => storage_path("logs/novatura/history/" . class_basename($model) . ".log"),
        ])->info([
            'action' => $action,
            'description' => $description,
            'old_data' => $oldData,
            'new_data' => $newData,
            'user_id' => $user ? $user->id : null,
            'hidden' => $model->getHidden()
        ]);


    }

    protected function prepareData(array $data, array $hiddenAttributes)
    {
        // Exclude hidden attributes
        $visibleData = collect($data)->except($hiddenAttributes)->all();
    
        // Optionally, encode to JSON if needed
        return json_encode($visibleData);
    }
}
