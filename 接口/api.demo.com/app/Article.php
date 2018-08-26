<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded = [];

    public static function getList(array $params)
    {
        $offset = $params['offset'] ?? '';
        $limit = $params['limit'] ?? '10';
        $limit = min($limit,100);
        $title = $params['title'] ?? '';

        $data = self::when($title,function($query)use($title){
            $query->where('title','like',"%$title%");
        })->offset($offset)->limit($limit)->get();
        return $data;

    }
}
