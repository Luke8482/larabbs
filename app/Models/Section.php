<?php

namespace App\Models;


class Section extends Model
{
    protected $fillable = [
        'type', 'content', 'markdown', 'lesson_id','sort',
    ];

    //获取section所属的节信息
    public function lesson(){
        return $this->belongsTo('App\Models\Lesson');
    }
}
