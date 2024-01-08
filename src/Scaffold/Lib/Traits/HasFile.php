<?php

namespace Novatura\Laravel\Scaffold\Lib\Traits;

use Illuminate\Support\Facades\Storage;

trait HasFile
{
    public function uploadFiles(array $fileArray, string $email = null)
    {

        $email = $email ?? (request()->user() ? request()->user()->email : null);

        if ($email === null) {
            throw new \InvalidArgumentException('Email needs to be provided.');
        }

        $modelName = class_basename($this);
        $username = explode('@', $email)[0];

        foreach ($fileArray as $variableName => $file) {

            $oldFilePath = null;

            if ($this->$variableName !== null) {
                try {
                    $oldFilePath = $this->getStorageLocation($this->$variableName);
                } catch (\ErrorException $e) {
                    // It's fine :^)
                }
            }

            list(, $filetype) = explode("/", $file->getMimeType());
            $filename = $username . "_" . time() . '.' . $filetype;

            $file->storeAs('public/' . $modelName, $filename);

            $this->$variableName = asset('storage/' . $modelName . "/" . $filename);

            $this->save();

            if($oldFilePath != null && Storage::exists($oldFilePath)){
                Storage::delete($oldFilePath);
            }
        }
    }

    public function getFile(string $variableName)
    {
        if ($this->$variableName !== null) {

            $filePath = $this->getStorageLocation($this->$variableName);

            return Storage::get($filePath);
        }

        return null;
    }

    private function getStorageLocation(string $url){
        list(, $storage_location) = explode('/storage/', $url);
        return 'public/' . $storage_location;
    }

    public function deleteFile($variableName){
        $storage_location = $this->getStorageLocation($this->$variableName);

        if(Storage::exists($storage_location)){
            Storage::delete($storage_location);
        }
    }

    public function deleteWithFiles(array $variableNames){

        $storage_locations = [];

        foreach($variableNames as $variableName){
            $storage_locations[] = $this->getStorageLocation($this->$variableName);
        }

        $this->delete();

        foreach($storage_locations as $storage_location){
            if(Storage::exists($storage_location)){
                Storage::delete($storage_location);
            }
        }

    }
}