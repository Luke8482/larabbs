<?php

namespace App\Http\Queries;

use App\Models\Course;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class CourseQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Course::query());

        $this->allowedIncludes('user','user.roles', 'category')
            ->allowedFilters([
                'title',
                AllowedFilter::exact('category_id'),
//                AllowedFilter::scope('withOrder')->default('recentReplied'),
            ]);
    }
}