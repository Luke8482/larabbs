<?php

namespace App\Http\Controllers\Api;

use App\Http\Queries\CourseQuery;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Requests\Api\CourseRequest;
use App\Http\Resources\CourseResource;

class CoursesController extends Controller
{

    //课程列表
    public function index(Request $request, CourseQuery $query){

        $course = $query->paginate();

        return CourseResource::collection($course);
    }

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

    // 删除课程
    public function destroy(Course $course){
        $this->authorize('destroy', $course);

        $course->delete();
    return response()->json(['status' => 204]);
    }

    // 获取单个课程的数据
    public function show ($courseId, CourseQuery $query){
        $course = $query->findOrFail($courseId);

        return new CourseResource($course);
    }
}
