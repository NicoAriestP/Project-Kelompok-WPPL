<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder; 
use Illuminate\Http\Request;
use App\Traits\Model\Blameable;
use App\Traits\HasTaskFile;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class Task extends Model
{
    use Blameable, HasFactory, HasTaskFile;

    protected $useTypeForTaskFileFolderName = false;

    protected $fillable = [
        'category_id',
        'pic_id',
        'title',
        'description',
        'due_at',
        'finished_at',
        'estimation',
        'priority',
        'effort',
        'status',
        'file'
    ];

    protected $appends = [
        'file_url',
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

    /**
     * Provide web accessible task file url.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function fileUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->file
                ? Storage::disk(config('filesystems.default', 'public'))->url($this->file)
                : null,
        );
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
