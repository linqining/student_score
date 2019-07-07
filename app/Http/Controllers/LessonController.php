<?php

namespace App\Http\Controllers;

use App\Lesson;
use App\Transformer\LessonsTransform as LessonsTransform;
use Illuminate\Http\Request;

class LessonController extends ApiController
{
    protected $lessonsTransform;
    public function __construct(LessonsTransform $lessonsTransform)
    {
        $this->lessonsTransform = $lessonsTransform;
    }

    public function index()
    {
        $lessons = Lesson::all();
        return $this->responseSuccess($this->lessonsTransform->transforms($lessons->toArray()));
    }

    public function show($id)
    {
        $lesson = Lesson::find($id);
        if (!$lesson) {
            return $this->setStatusCode(400)->responseErrors('错误的 id 请求');
        }

        return $this->responseSuccess($this->lessonsTransform->transform($lesson->toArray()));
    }

}