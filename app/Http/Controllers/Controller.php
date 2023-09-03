<?php

namespace App\Http\Controllers;

use App\Models\FileUpload;
use App\Traits\ResponseTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ResponseTrait;

    public function deleteFile($files)
    {
        if (is_array($files)) {
            foreach ($files as $fileItem) {
                if (!is_array($fileItem)) {
                    $fileId = $files['id'];
                    $this->deleteFromStorage($fileId);
                    break;
                }
                $fileId = $fileItem['id'];
                $this->deleteFromStorage($fileId);
            }
        }
    }

    public function deleteFromStorage($fileId)
    {
        $file = FileUpload::find($fileId);
        if ($file) {
            foreach ($file->getMedia() as $mediaItem) {
                $mediaItem->delete();
            }
            $file->delete();
        }
    }
}
