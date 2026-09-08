<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Export extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'format',
        'filename',
        'filepath',
        'description',
        'period',
        'file_size',
        'options',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDownloadUrlAttribute()
    {
        if ($this->filepath && \Storage::disk('public')->exists($this->filepath)) {
            return \Storage::disk('public')->url($this->filepath);
        }
        return '#';
    }

    public function getHumanSizeAttribute()
    {
        $path = \Storage::disk('public')->path($this->filepath);
        if (!\File::exists($path)) return $this->file_size ?? '—';

        $bytes = \File::size($path);
        if ($bytes >= 1073741824) return number_format($bytes / 1073741824, 2) . ' GB';
        if ($bytes >= 1048576) return number_format($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024) return number_format($bytes / 1024, 2) . ' KB';
        return $bytes . ' bytes';
    }

    public function deleteFile()
    {
        if ($this->filepath && \Storage::disk('public')->exists($this->filepath)) {
            \Storage::disk('public')->delete($this->filepath);
        }
        $this->delete();
    }
}
