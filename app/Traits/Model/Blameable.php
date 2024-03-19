<?php

namespace App\Traits\Model;

use App\Models\User;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Database\Eloquent\Builder; 

trait Blameable
{
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
