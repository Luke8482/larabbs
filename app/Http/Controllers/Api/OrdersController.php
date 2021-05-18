<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\OrderRequest;
use App\Models\Course;
use App\Models\Order;

class OrdersController extends Controller
{
    public function store(OrderRequest $request)
    {
        $user  = $request->user();
        // 开启一个数据库事务
        $order = \DB::transaction(function () use ($user, $request) {
            // 创建一个订单
            $order = new Order([
                'total_amount' => 0,
            ]);
            // 订单关联到当前用户
            $order->user()->associate($user);
            // 写入数据库
            $order->save();

            $totalAmount = 0;

            $items = $request->all();
//            dd($items);
            // 遍历用户提交的 SKU
            foreach ($items['courses'] as $course_id) {
                $course  = Course::find($course_id);
                // 创建一个 OrderItem 并直接与当前订单关联
                $item = $order->items()->make([
//                    'amount' => $data['amount'],
                    //  TODO 将 course表需增加现价 present_price 字段
                    'course_id' => $course->id,
                    'present_price' => $course->price,

                ]);
                $item->save();
                $totalAmount += $course->price ;
            }

            // 更新订单总金额
            $order->update(['total_amount' => $totalAmount]);


            return $order;
        });

        return $order;
    }
}
