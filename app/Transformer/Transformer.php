<?php

namespace App\Transformer;

abstract class Transformer
{
    /**
     * 转换多条数据
     * @param  {[type]} array $items        [description]
     * @return {[type]}       [description]
     */
    public function transforms(array $items)
    {
        return array_map([$this, 'transform'], $items);
    }

    abstract public function transform(array $item);
}