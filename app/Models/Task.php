<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'description',
        'due_at',
        'priority',
        'effort',
        'status',
        'file'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }


    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
