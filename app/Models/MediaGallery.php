<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MediaGallery extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'event_type',
        'media_date',
        'status',
        'event_id',
        'created_by',
    ];

    protected $casts = [
        'media_date' => 'date',
    ];

    public function items()
    {
        return $this->hasMany(MediaItem::class, 'gallery_id')->orderBy('sort_order');
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'Published');
    }

    public function scopeByMonth($query, $year, $month)
    {
        return $query->whereYear('media_date', $year)
                     ->whereMonth('media_date', $month);
    }

    public function getItemCountAttribute()
    {
        return $this->items()->count();
    }
}
