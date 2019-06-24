<?php

namespace App\Http\Controllers\Upload;

use Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\File;
use Illuminate\Http\UploadedFile;
use App\Upload;

class UploadController extends Controller
{

    public function __constructor()
    {
        $this->middleware(['auth']);
    }

    public function store(Request $request,File $file)
    {

        $uploadedFile = $request->file('file');

        $upload = $this->storeUpload($file,$uploadedFile);
        
        Storage::disk('local')->putFileAs(
            'files//' . $file->indentifier,
            $uploadedFile,
            $upload->filename
        );

        // return $this->awsUpload($uploadedFile);

        return response()->json([
            'id' => $upload->id
        ]);
    }

    protected function storeUpload(File $file,UploadedFile $uploadedFile)
    {
        $this->authorize('touch',$file);

        $upload = new Upload();

        $upload->fill([
            'filename' => $this->generateFilename($uploadedFile),
            'size' => $uploadedFile->getSize(),
        ]);

        $upload->file()->associate($file);
        $upload->user()->associate(auth()->user());

        $upload->save();

        return $upload;
    }

    protected function generateFilename(UploadedFile $uploadedFile)
    {
        return $uploadedFile->getClientOriginalName();
    }

    protected function awsUpload(UploadedFile $uploadedFile)
    {
        $uploadedFile->move(storage_path() . '/uploads', $uploadedFile->getClientOriginalName());

        $path = storage_path() . '\\uploads\\' . $uploadedFile->getClientOriginalName();

        Storage::disk('s3images')->put('profile/'. $uploadedFile->getClientOriginalName(),fopen($path,'r+'));
    }

    public function destroy(File $file,Upload $upload)
    {
        
        $this->authorize('touch',$file);

        $this->authorize('touch',$upload);

        if($file->uploads()->count() === 1)
        {
            return response()->json(null,422);
        }

        $upload->delete();
    }
}
