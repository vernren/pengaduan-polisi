<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatHistory extends Model
{
    protected $table = 'chat_history';

    public $timestamps = false;

    protected $fillable = [
        'user_id', 'session_id', 'pertanyaan', 'jawaban', 'faq_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function faq()
    {
        return $this->belongsTo(Faq::class);
    }
}
