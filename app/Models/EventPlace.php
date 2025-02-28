<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventPlace extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'city',
        'street',
        'house_number',
        'office',
        'user_id'
    ];


}
