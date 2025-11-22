<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BotConfiguration extends Model
{
    protected $table = 'bot_configuration';
    protected $fillable = [
        'instructions',
    ];
}
