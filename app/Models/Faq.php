<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $table = 'faq';

    protected $fillable = [
        'pertanyaan', 'jawaban', 'kategori', 'keywords', 'view_count', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function chatHistory()
    {
        return $this->hasMany(ChatHistory::class);
    }

    public static function search($query)
    {
        return self::where('is_active', true)
            ->where(function($q) use ($query) {
                $q->where('pertanyaan', 'like', "%{$query}%")
                  ->orWhere('jawaban', 'like', "%{$query}%")
                  ->orWhere('keywords', 'like', "%{$query}%");
            })
            ->orderBy('view_count', 'desc')
            ->get();
    }
}
