<?php

namespace App\Http\Requests\Api;


class CourseRequest extends FormRequest
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
                    'price' => 'required',
                    'cover' => 'required|string',
                ];
                break;
            case  'PATCH':
                return [
                    'title' => 'string',
                    'cover' => 'string',
                ];
                break;
        }

    }

    public function attributes()
    {
        return [
          'title' => '标题',
          'price' => '课程价格',
          'cover' => '课程封面',
        ];
    }
}
