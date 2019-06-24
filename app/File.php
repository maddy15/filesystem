<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\HasApprovals;

class File extends Model
{
    use SoftDeletes,HasApprovals;

    const APPROVAL_PROPERTIES = [
        'title',
        'overview_short',
        'overview'
    ];

    protected $fillable = [
        'title',
        'overview_short',
        'overview',
        'price',
        'approved',
        'live',
        'finished',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($file){
            $file->identifier = uniqid(true);
        });
    }

    public function getRouteKeyName()
    {
        return 'identifier';    
    }

    public function scopeFinished(Builder $builder)
    {
        return $builder->where('finished',true);
    }

    public function isFree()
    {
        return $this->price == 0;
    }


    //RELATIONS 

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approvals()
    {
        return $this->hasMany(FileApproval::class);
    }

    public function uploads()
    {
        return $this->hasMany(Upload::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    //Helper Functions


    public function createApproval(array $approvalProperties)
    {
        return $this->approvals()->create($approvalProperties);
    }

    public function needApproval(array $approvalProperties)
    {
        if($this->currentPropertiesDifferToGiven($approvalProperties))
        {
            return true;
        }

        if($this->uploads()->hasNotApproved()->count())
        {
            return true;
        }

        return false;
    }

    protected function currentPropertiesDifferToGiven(array $properties)
    {
        return array_only($this->toArray(),self::APPROVAL_PROPERTIES) != $properties;
    }

    public function approve()
    {
        $this->updateToVisible();
        $this->approveAllUploads();
    }

    public function approveAllUploads()
    {
        $this->uploads()->update([
            'approved' => true
        ]);
    }

    public function updateToVisible()
    {
        $this->update([
            'live' => true,
            'approved' => true,
        ]);
    }

    public function deleteAllApprovals()
    {
        $this->approvals()->delete();
    }

    public function deleteUnapprovedUploads()
    {
        $this->uploads()->hasNotApproved()->delete();
    }

    public function mergeApprovalProperties()
    {
        $this->update(array_only(
            $this->approvals->first()->toArray(),
            self::APPROVAL_PROPERTIES
        ));
    }

    public function visible()
    {
        if(auth()->user()->isAdmin())
        {
            return true;
        }

        if(auth()->user()->isTheSameAs($this->user))
        {
            return true;
        }

        return $this->live && $this->approved;
    }

    public function calculateCommission()
    {
        return (config('filemarket.sales.commission') / 100) * $this->price;
    }
    
    public function matchesSale(Sale $sale)
    {
        return $this->sales->contains($sale);
    }

    public function getUploadList()
    {
        return $this->uploads()->hasApproved()->pluck('path')->toArray();
    }
}
