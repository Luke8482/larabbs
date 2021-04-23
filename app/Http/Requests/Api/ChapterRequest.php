<?php

namespace App\Http\Requests\Api;


class ChapterRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()){
            case 'POST':
                return [
                    'title' => 'required|string',
                    'course_id' => 'required',
                ];
                break;
            case  'PATCH':
                return [
                    'title' => 'string',
                ];
                break;
        }

    }

    public function attributes()
    {
        return [
            'title' => '章的标题',
            'course_id' => '课程id',
        ];
    }
}
