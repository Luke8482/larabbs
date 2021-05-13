<?php

namespace App\Models;


class Lesson extends Model
{
    protected $fillable = [
        'title', 'chapter_id'
    ];

    //获取节所属的章
    public function chapter(){
        return $this->belongsTo('App\Models\Chapter');
    }
    

    //获取节对应的section信息
    public function sections(){
        return $this->hasMany('App\Models\Section');
    }
}
