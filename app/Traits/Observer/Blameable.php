<?php

namespace App\Traits\Observer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait Blameable
{
    /**
     * Handle the Model "creating" event.
     *
     * @param  \App\Models\Model  $model
     * @return void
     */
    public function creating(Model $model)
    {
        $model->created_by = Auth::id();
    }

    /**
     * Handle the Model "updating" event.
     *
     * @param  \App\Models\Model  $model
     * @return void
     */
    public function updating(Model $model)
    {
        $model->updated_by = Auth::id();
    }
}
