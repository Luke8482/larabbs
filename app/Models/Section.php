<?php

namespace App\Models;


class Section extends Model
{
    protected $fillable = [
        'type', 'content', 'markdown', 'lesson_id',
    ];
}
