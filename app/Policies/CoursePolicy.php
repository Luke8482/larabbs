<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Course;

class CoursePolicy extends Policy
{
    public function update(User $user, Course $course)
    {
        return $user->isAuthorOf($course);
    }

    public function destroy(User $user, Course $course)
    {
        return $user->isAuthorOf($course);
    }
}
