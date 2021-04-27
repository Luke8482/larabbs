<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChapterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);
//        $data['lesson'] = new LessonResource($this->whenLoaded('lesson'));

        return $data;

//        return [
//            'id' => $this->id,
//            'title' => $this->title,
//            'course_id' => (int)$this->course_id,
//            'created_at' => (string) $this->created_at,
//            'updated_at' => (string) $this->updated_at,
//        ];
    }
}
