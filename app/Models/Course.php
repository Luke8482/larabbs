<?php

namespace App\Models;


class Course extends Model
{
    protected $fillable = [
        'title', 'price', 'cover'
    ];

    //获取课程的章
    public function chapters() {
        return $this->hasMany('App\Models\Chapter');
    }

    //获取课程的节
    public function lessons() {
        return $this->hasManyThrough('App\Models\Lesson','App\Models\Chapter');
    }

    //连带删除节
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($course){
            $course->chapters()->delete();
        });
    }
}
