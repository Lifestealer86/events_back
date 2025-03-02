<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'city',
        'event_counter',
        'description',
        'img',
        'start_date',
        'end_date',
        'event_place_id',
        'user_id',
    ];
}
