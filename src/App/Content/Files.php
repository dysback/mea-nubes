<?php

namespace Dysback\NubesMea\App\Content;

use Dysback\Ogo\View\GeneralView;
use Dysback\Ogo\View\IView;

class Files extends GeneralView implements IView
{
    public function upload(string $fileName, string $fileId)
    {
        echo "Upload file";
        return [
            'status' => 'success',
            'file_name' => $fileName,
            'file_id' => $fileId,
            'message' => 'File uploaded successfully',
        ];
    }
    public function render(): void
    {
        echo "Render files";
    }
}
