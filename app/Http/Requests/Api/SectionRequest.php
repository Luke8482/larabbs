<?php

namespace App\Http\Requests\Api;


class SectionRequest extends FormRequest
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
                    'type' => 'required|string',
                    'content' => 'required',
                    'markdown' => 'string',
                    'lesson_id' => 'required',
                ];
                break;
            case  'PATCH':
                return [
                    'type' => 'string',
//                    'content' => 'text',
                    'markdown' => 'string',
                ];
                break;
        }

    }

    public function attributes()
    {
        return [
            'type' => 'section类型',
            'content' => 'section内容',
            'markdown' => 'section的markdown内容',
            'lesson_id' => '节的id',
        ];
    }
}
