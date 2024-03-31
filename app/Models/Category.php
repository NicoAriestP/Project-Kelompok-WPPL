<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task;
use App\Traits\Model\Blameable;

class Category extends Model
{
    use HasFactory, Blameable;

    protected $fillable = [
        'name'
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
