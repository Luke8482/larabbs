<?php

namespace App\Models;


class OrderItem extends Model
{

    protected $fillable = ['present_price', 'course_id'];
    public $timestamps = false;

    public function course()
    {
        return $this->belongsTo(Course::class);
    }


    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
