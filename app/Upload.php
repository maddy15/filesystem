<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasApprovals;

class Upload extends Model
{
    use SoftDeletes,HasApprovals;

    protected $fillable = [
        'filename',
        'size',
        'approved',
        'user_id',
        'file_id'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function getPathAttribute()
    {
        return storage_path('app\\files\\' . $this->filename);
    }
}
