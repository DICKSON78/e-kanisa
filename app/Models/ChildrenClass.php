<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChildrenClass extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'age_min',
        'age_max',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function students()
    {
        return $this->belongsToMany(Member::class, 'children_students')
                    ->withPivot('status', 'enrollment_date', 'graduation_date', 'notes')
                    ->withTimestamps();
    }

    public function activeStudents()
    {
        return $this->belongsToMany(Member::class, 'children_students')
                    ->wherePivot('status', 'Active')
                    ->withPivot('enrollment_date', 'notes');
    }

    public function teachers()
    {
        return $this->belongsToMany(Member::class, 'children_teachers')
                    ->withPivot('role', 'start_date', 'end_date', 'is_active')
                    ->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getStudentCountAttribute()
    {
        return $this->students()->wherePivot('status', 'Active')->count();
    }

    public function getTeacherCountAttribute()
    {
        return $this->teachers()->wherePivot('is_active', true)->count();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($class) {
            if (empty($class->slug)) {
                $class->slug = \Str::slug($class->name);
            }
        });

        static::updating(function ($class) {
            if ($class->isDirty('name') && !$class->isDirty('slug')) {
                $class->slug = \Str::slug($class->name);
            }
        });
    }
}
