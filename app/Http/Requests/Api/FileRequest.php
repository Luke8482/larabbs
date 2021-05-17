<?php

namespace App\Http\Requests\Api;


class FileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'file_type' => 'required|string|in:image,video,audio,graphic,downloadFile',
            'lesson_id' => 'required|string'
        ];
//
        if ($this->file_type == 'image'){
            $rules['file'] = 'required|mimes:jpeg,bmp,png,gif|dimensions:min_width=200,min_height=200';
        } elseif($this->file_type == 'video') {
            $rules['file'] = 'required|mimes:mp4,wmv,avi,swf';
        }elseif($this->file_type == 'radio') {
            $rules['file'] = 'required|mimes:mp3,wma';
        }elseif($this->file_type == 'graphic') {
            $rules['file'] = 'required|mimes:pdf';
        }elseif($this->file_type == 'downloadFile') {
            $rules['file'] = 'required|mimes:rar,zip';
        }

        return $rules;
    }

    public function messages(){
        return [
            'image.dimensions' => '图片的清晰度不够，宽和高需要 200px 以上',
        ];
    }
}
