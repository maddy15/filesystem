<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\File;

class FileController extends Controller
{
    public function show(File $file)
    {
        $file = $this->replaceFilePropertiesWithUnapproveChanges($file);

        return view('files.show',[
            'file' => $file,
            'uploads' => $file->uploads
        ]);
    }

    public function replaceFilePropertiesWithUnapproveChanges(File $file)
    {
        if($file->approvals->count())
        {
            $file->fill($this->listChanges($file));
        }
        return $file;
    }


    protected function filterFileByApprovalProperties(File $file)
    {
        return array_only($file->toArray(),File::APPROVAL_PROPERTIES);
    }


    protected function listChanges(File $file)
    {
        $changes = array();

        $approvals = $file->approvals->first();

        $filtered_file = $this->filterFileByApprovalProperties($file);

        foreach($filtered_file as $key => $value)
        {
            if($value !== $approvals[$key])
            {
                $changes[$key] = $approvals[$key] . ' <small style="color:red">(Changed)</small>';
            }
        }

        return $changes;
    }
}
