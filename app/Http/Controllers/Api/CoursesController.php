<?php

namespace App\Http\Controllers\Api;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Requests\Api\CourseRequest;
use App\Http\Resources\CourseResource;

class CoursesController extends Controller
{
    //新增课程
    public function store(CourseRequest $request, Course $course){
        $course->fill($request->all());
        $course->user_id = $request->user()->id;
        $course->save();

        return new CourseResource($course);
    }

    // 修改课程
    public function update(CourseRequest $request, Course $course){
        $this->authorize('update', $course);

        $course->update($request->all());
        return new CourseResource($course);
    }
}
