<?php

namespace App\Models;


class Chapter extends Model
{
    protected $fillable = [
        'title', 'course_id'
    ];

    //获取章所属的课程
    public function course(){
        return $this->belongsTo('App\Models\Course');
    }

    //获取章对应的节信息
    public function lessons(){
        return $this->hasMany('App\Models\Lesson');
    }

    //连带删除节
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($chapter){
           $chapter->lessons()->delete();
        });
    }
}
