<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'message', 'is_bot'];

    public $timestamps = false;

    protected $appends = ['sticker_url'];

    public function getStickerUrlAttribute()
    {
        $text = trim($this->message ?? '');
        if (preg_match('/^\[STICKER\]\s*(.+)$/i', $text, $m)) {
            $file = basename($m[1]);
            $allowed = ['webp', 'png', 'jpg', 'jpeg', 'gif'];
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (!in_array($ext, $allowed)) return null;

            $fullPath = public_path('stickers/' . $file);
            if (file_exists($fullPath)) {
                return asset('stickers/' . $file);
            }
        }
        return null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
