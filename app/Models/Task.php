<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder; 
use Illuminate\Http\Request;
use App\Traits\Model\Blameable;

class Task extends Model
{
    use Blameable, HasFactory;

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

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function pic()
    {
        return $this->belongsTo(User::class, 'pic_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Scope 
    |--------------------------------------------------------------------------
    */

    public function scopeTableFilter(Builder $query, Request $request)
    {
        $search = $request->input('search', '');
        $priority = $request->input('priority');
        $effort = $request->input('effort');
        $status = $request->input('status');

        $query->where(function ($query) use ($search) {
                    if ($search) {
                        $query->where('title', 'like', '%' . $search . '%');
                    }
                })
                ->where(function ($query) use ($priority) {
                    if ($priority) {
                        $query->where('priority', $priority);
                    }
                })
                ->where(function ($query) use ($effort) {
                    if ($effort) {
                        $query->where('effort', $effort);
                    }
                })
                ->where(function ($query) use ($status) {
                    if ($status) {
                        $query->where('status', $status);
                    }
                });
    }
}
