<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advisor extends Model
{
    protected $fillable = [
        'name',
        'contact',
        'id_depa',
        'id_prov',
        'id_dist',
    ];
}
