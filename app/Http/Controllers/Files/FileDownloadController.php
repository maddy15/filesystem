<?php

namespace App\Http\Controllers\Files;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\File;
use App\Sale;
use Chumper\Zipper\Zipper;

class FileDownloadController extends Controller
{
    public $zipper;

    public function __construct(Zipper $zipper)
    {
        $this->zipper = $zipper;
    }

    public function show(File $file,Sale $sale)
    {
        if(!$file->visible())
        {
            return abort(403);
        }

        if(!$file->matchesSale($sale))
        {
            return abort(404);
        }

        $this->createZipFileInPath($file,$path = $this->generateTemporaryPath($file));

        return response()
                ->download($path)
                ->deleteFileAfterSend(true);
    }

    protected function createZipFileInPath(File $file,$path)
    {
        $this->zipper->make($path)->add($file->getUploadList())->close();
    }

    protected function generateTemporaryPath(File $file)
    {
        return public_path('tmp\\' . str_slug($file->title) . '.zip');
    }
}
