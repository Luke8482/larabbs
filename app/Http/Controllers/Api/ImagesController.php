<?php

namespace App\Http\Controllers\Api;

use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Handlers\ImageUploadHandler;
use App\Http\Resources\ImageResource;
use App\Http\Requests\Api\ImageRequest;
use App\Http\Requests\Api\ImageRequestTest;

class ImagesController extends Controller
{
    public function store(ImageRequest $request, ImageUploadHandler $uploader, Image $image){
//        dd($request);
        $user = $request->user();


        $size = $request->type == 'avatar' ? 416 : 1024;
        $result = $uploader->save($request->image,Str::plural($request->type),$user->id,$size);

        $image->path = $result['path'];
        $image->type = $request->type;
        $image->user_id = $user->id;
        $image->save();

        return new ImageResource($image);
    }

    // 图片上传测试接口
    public function storeTest(ImageRequestTest $request, ImageUploadHandler $uploader, Image $image){
//        dump('$request');

        $user = $request->user();



        $size = $request->type == 'avatar' ? 416 : 1024;
        $result = $uploader->save($request->file,Str::plural($request->type),$user->id,$size);

        $image->path = $result['path'];
        $image->type = $request->type;
        $image->user_id = $user->id;
        $image->save();

        return new ImageResource($image);

    }
}
