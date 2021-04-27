<?php

namespace App\Http\Requests\Api;


class LessonRequest extends FormRequest
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
                    'chapter_id' => 'required',
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
            'title' => '节的标题',
            'course_id' => '章的id',
        ];
    }
}
