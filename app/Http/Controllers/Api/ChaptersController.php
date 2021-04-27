<?php

namespace App\Http\Controllers\Api;

use App\Models\Chapter;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Requests\Api\ChapterRequest;
use App\Http\Resources\ChapterResource;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class ChaptersController extends Controller
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


    public function courseIndex(Request $request, Course $course){
        $query = $course->chapters()->getQuery();

        $chapters = QueryBuilder::for($query)
            ->allowedIncludes('lessons')
            ->get();

        return ChapterResource::collection($chapters);
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
    public function store(ChapterRequest $request, Chapter $chapter)
    {
        $chapter->fill($request->all());
        $chapter->save();

        return new ChapterResource($chapter);
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
    public function update(ChapterRequest $request, Chapter $chapter)
    {
        $chapter->update($request->all());

        return new ChapterResource($chapter);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chapter $chapter)
    {
//        $this->authorize('destroy',$chapter);
        $chapter->delete();

        return response(null, 204);
    }
}
