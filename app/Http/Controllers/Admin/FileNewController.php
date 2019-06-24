<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\File;
use Illuminate\Support\Facades\Mail;
use App\Mail\Files\FileApproved;
use App\Mail\Files\FileRejected;

class FileNewController extends Controller
{
    public function index()
    {
        $files = File::hasNotApproved()->finished()->oldest()->get();
        return view('admin.files.new.index',[
            'files' => $files
        ]);
    }

    public function update(File $file)
    {
        $file->approve();
        
        //send email 
        Mail::to($file->user)->send(new FileApproved($file));

        return back()->withSuccess("{$file->title} has been approved");
    }

    public function destroy(File $file)
    {
        // $file->delete();

        // $file->uploads->each->delete();

        Mail::to($file->user)->send(new FileRejected($file));

        return back()->withSuccess("{$file->title} has been rejected");
    }
}
