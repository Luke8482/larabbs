<?php

namespace App\Http\Controllers\Api;

use App\Handlers\FileUploadHandler;
use App\Http\Requests\Api\FileRequest;
use App\Http\Resources\FileResource;
use App\Models\File;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FilesController extends Controller
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
    public function store(FileRequest $request, FileUploadHandler $fileUploadHandler, File $file)
    {

        $lesson_id = $request->lesson_id;
        $lesson = Lesson::where('id',$lesson_id)->first();
        $course_id = $lesson->chapter->course->id;





//        $course_id = DB::table('lessons')->where('id',$lesson_id)->course->getQury()->id;

        $result = $fileUploadHandler->save($request->file, Str::plural($request->file_type), $course_id, $lesson_id );


        $file->path = $result['path'];
        $file->lesson_id = $lesson_id;
        $file->name = $request->file->getClientOriginalName();
        $file->file_type = $request->file_type;

        $file->save();

        return new FileResource($file);
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function downloadFile(Request $request, File $file){
        $lesson_id = $request->lesson_id;
        $download_file = $file->where('lesson_id', $lesson_id)->where('file_type', 'downloadfile')->first();
        $file_path = str_replace(env('APP_URL'), '.', $download_file->path);
        $file_name = $download_file->name;
        $file_contents = file_get_contents($file_path);
        $file_contents = base64_encode($file_contents);





//        dd($content);

        $headers = [
            'Content-Type: application/pdf',
        ];

        return response()->json(['content' => $file_contents]);
    }

//    public function downloadFile(Request $request, File $file){
//        $lesson_id = $request->lesson_id;
//        $download_file = $file->where('lesson_id', $lesson_id)->where('file_type', 'downloadfile')->get();
////        $file_path = str_replace(env('APP_URL'), '.', $download_file->path);
////        $file_name = $download_file->name;
////        $headers = [
////            'Content-Type: application/pdf',
////        ];
//
//        return response($download_file);
//    }
}
