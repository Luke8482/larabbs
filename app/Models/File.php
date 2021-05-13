<?php

namespace App\Models;


class File extends Model
{
    protected $fillable = ['name','file_type', 'path', 'lesson_id'];
}
