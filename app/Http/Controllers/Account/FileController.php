<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\File;
use App\Http\Requests\File\StoreFileRequest;
use App\Http\Requests\File\UpdateFileRequest;
use PHPUnit\Framework\Constraint\IsFalse;

class FileController extends Controller
{

    public function index()
    {
        $files = auth()->user()->files()->latest()->finished()->get();

        return view('account.files.index',[
            'files' => $files
        ]);
    }

    public function store(StoreFileRequest $request,File $file)
    {
        $this->authorize('touch',$file);

        $file->fill($request->only([
            'title',
            'overview_short',
            'overview',
            'price'
        ]));

        $file->finished = true;

        $file->save();

        return redirect()->route('account.files.index')
            ->withSuccess('Thanks, submitted for review');
    }

    public function create(File $file)
    {
        if(!$file->exists)
        {
            $file = $this->createAndReturnSkeletonFile();

            return redirect()->route('account.files.create',$file);
        }
        //render form 
        $this->authorize('touch',$file);

        return view('account.files.create',[
            'file' => $file
        ]);
    }

    public function createAndReturnSkeletonFile()
    {
        return auth()->user()->files()->create([
            'title' => 'Untitled',
            'overview' => 'None',
            'overview_short' => 'None',
            'price' => '0',
            'finished' => false,
        ]);
    }

    public function edit(File $file)
    {

        $this->authorize('touch',$file);

        return view('account.files.edit',[
            'file' => $file,
            'approval' => $file->approvals->first()
        ]);
    }

    public function update(UpdateFileRequest $request,File $file)
    {
        $this->authorize('touch',$file);
        
        $approvalProperties = $request->only(File::APPROVAL_PROPERTIES);

        if($file->needApproval($approvalProperties))
        {
            $file->createApproval($approvalProperties);

            return back()->withSuccess('Thanks,We will review your changes soon.');
        }

        $file->update($request->only(['live','price']));

        return back()->withSuccess('File Updated');
    }
}
