<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listt extends Model
{
    protected $table = 'lists';

    protected $fillable = [
        'name', 'user_id',
    ];

}
