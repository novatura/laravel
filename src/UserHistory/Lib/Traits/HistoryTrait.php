<?php

namespace Novatura\Laravel\UserHistory\Lib\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\History;

trait HistoryTrait
{
    public static function createWithHistory(array $data, string $description)
    {
        $model = parent::create($data);

        $user = Auth::user();
        $newData = self::prepareData($model->getAttributes(), $model->getHidden());

        History::create([
            'action' => 'Create',
            'model' => class_basename($model),
            'model_id' => $model->getKey(),
            'old_data' => null,
            'new_data' => $newData,
            'user_id' => optional($user)->id,
            'description' => $description,
        ]);
    }

    public function updateWithHistory(array $data, string $description)
    {

        $oldData = self::prepareData($this->getAttributes(), $model->getHidden());

        $this->update($data);

        $user = Auth::user();
        $newData = self::prepareData($this->getAttributes(), $model->getHidden());

        History::create([
            'action' => 'Update',
            'model' => class_basename($this),
            'model_id' => $this->getKey(),
            'old_data' => $oldData,
            'new_data' => $newData,
            'user_id' => optional($user)->id,
            'description' => $description,
        ]);
    }

    public function deleteWithHistory(string $description)
    {
        $this->delete();

        $user = Auth::user();

        $oldData = self::prepareData($model->getAttributes(), $model->getHidden());

        History::create([
            'action' => 'Delete',
            'model' => class_basename($model),
            'model_id' => $this->getKey(),
            'old_data' => $oldData,
            'new_data' => null,
            'user_id' => optional($user)->id,
            'description' => $description,
        ]);
    }

    private static function prepareData(array $data, array $hiddenAttributes): string
    {
        return json_encode(collect($data)->except($hiddenAttributes)->all());
    }
}
