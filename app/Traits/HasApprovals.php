<?php

namespace App\Traits;

Trait HasApprovals
{
    public function scopeHasApproved($builder)
    {
        return $builder->where('approved',true)->get();
    }

    public function scopeHasNotApproved($builder)
    {
        return $builder->where('approved',false);
    }
}