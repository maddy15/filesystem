<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileApproval extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'overview_short',
        'overview'
    ];

    protected $table = 'file_approvals';

    protected static function boot()
    {
        parent::boot();

        static::creating(function($approval){
            $approval->file->approvals->each->delete();
        });
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
