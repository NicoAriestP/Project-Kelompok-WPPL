<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasTaskFile
{
    public function getTaskFileSaveFolder()
    {
        if (! isset($this->useTypeForTaskFileFolderName)) {
            $useTypeForTaskFileFolderName = false;
        }

        if ($this->useTypeForTaskFileFolderName == true) {
            if (! isset($this->type)) {
                throw new Exception('Using type for folder name, but type is not defined in the model.');
            }

            $uploadDir = $this->type.'/task';
        } else {
            $uploadDir = $this->getTable();
        }

        if (config('filesystems.default') == 'do') {
            return sprintf(
                '%s/%s',
                config('filesystems.disks.do.folder', config('app.name').'-folder'),
                $uploadDir,
            );
        }

        return $uploadDir;
    }

    public function updateTaskFile(UploadedFile $file)
    {
        tap($this->file, function ($previousFile) use ($file) {
            $folder = $this->getTaskFileSaveFolder();
            $this->fill([
                'file' => $file->storePublicly(
                    $folder,
                    ['disk' => config('filesystems.default', 'public')]
                ),
            ])->save();

            if ($previousFile) {
                $previousFile = str_replace(Storage::url('/'), '', $previousFile);
                Storage::disk(config('filesystems.default', 'public'))->delete($previousFile);
            }
        });
    }

    public function deleteTaskFile()
    {
        if (is_null($this->file) || $this->file === 'null') {
            return;
        }

        $file = str_replace(Storage::url('/'), '', $this->file);
        Storage::disk(config('filesystems.default', 'public'))->delete($file);

        $this->fill(['file' => null])->save();
    }
}
