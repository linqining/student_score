<?php

namespace App\Transformer;

class LessonsTransform extends Transformer
{
    /**
     * [transform description]
     * @param  array  $lesson [description]
     * @return [type]         [description]
     */
    public function transform(array $lesson)
    {
        return [
            'title'   => $lesson['title'],
            'content' => $lesson['body'],
            'is_free' => (bool) $lesson['free'],
        ];
    }
}