<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\SectionRequest;
use App\Http\Resources\SectionResource;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Models\Section;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function lessonIndex(Request $request, Lesson $lesson){
        $query = $lesson->sections()->getQuery();

        $sections = QueryBuilder::for($query)
            ->get();

        return SectionResource::collection($sections);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SectionRequest $request, Section $section)
    {
        $value=$request->all();

        $lesson_id = $value["lesson_id"];
        if (array_key_exists('sort', $value)){
            $backSort = $value['sort'];

            $beforeSort = DB::table('sections')->where('lesson_id', $lesson_id)->where('sort', '<', $backSort)->max('sort');

            if ($beforeSort){
//                如果前面有section，则取中值， 赋给新的section
                $avg = ($beforeSort+$backSort)/2;

                $tempBeforeSort = explode('.',$beforeSort);
                if (sizeof($tempBeforeSort)>1){
                    $decimal = end($tempBeforeSort);
                    $countBeforeSort = strlen($decimal);
                }else{
                    $countBeforeSort=0;
                }

                $tempBackSort = explode('.',$backSort);
                if (sizeof($tempBackSort)>1){
                    $decimal = end($tempBackSort);
                    $countBackSort = strlen($decimal);
                }else{
                    $countBackSort=0;
                }

                $size = $countBeforeSort> $countBackSort? $countBeforeSort: $countBackSort;

                $round = round($avg , $size);
                $sort = $round==$beforeSort||$round==$backSort? $avg: $round;



            }else{
//                如果前面无section， 则传入的sort值-1 赋值给新的section
                $sort = $value['sort']-1;
            }
            $value['sort']=$sort;
        }else{
            $sectionSort = DB::table('sections')->where('lesson_id', $lesson_id)->max('sort');

            if ($sectionSort){
                $sort = $sectionSort+1;
            }else{

                $sort = 1;
            }
            $value = Arr::add($value,'sort',$sort);
        }


        $section->fill($value);
        $section->save();

        return new SectionResource($section);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SectionRequest $request, Section $section)
    {
        $section->update($request->all());

        return new SectionResource($section);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        $section->delete();

        return response()->json(['status'=>204]);
    }
}
