<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BotKnowledgeFile extends Model
{
    protected $table = 'bot_knowledge_files';

    protected $fillable = [
        'file_name',
        'file_path',
        'file_size',
    ];
}
