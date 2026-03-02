<?php

namespace Dysback\NubesMea\App\Content;

use Dysback\Ogo\View\HtmlView;
use Dysback\Ogo\View\IView;

class Images extends HtmlView
{
    public function download(string $fileName, string $fileId)
    {
        echo "Download image: " . $fileName . " with id: " . $fileId;
    }
    public function render(): void
    {
        echo "Render images";
    }
}
