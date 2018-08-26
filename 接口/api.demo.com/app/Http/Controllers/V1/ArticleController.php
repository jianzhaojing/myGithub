<?php

namespace App\Http\Controllers\V1;

use App\Article;
use App\Exceptions\Apiexception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    //查询
    public function article(Request $request)
    {
        $data = Article::getList($request->toArray());
        return response()->json($data,200);
    }
    //添加
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'title' => 'required',
            'author'=> 'required',
            'desc' => 'required'
        ]);
        if($validate->fails())
        {
            throw new Apiexception('用户名或密码错误6',1001);
        }
        $model = Article::create($request->all());
        return response()->json([
            'message' => '添加成功',
            'code'    => 1001,
            '文章ID'  => $model->id
        ],201);
    }
    //修改
//    public function update(Request $request,$id)
//    {
//        $model = Article::where('id',$id)->update($request->all());
//        return response()->json([
//            'message' => '修改成功',
//            'code'    => 1002,
//            '文章ID'  => $id,
//        ],202);
//    }
    public function update(Request $request,Article $article)
    {
        $article->update($request->all());
        return response()->json([
            'message' => '修改成功',
            'code'    => 1002,
            '文章ID'  => $article->id,
        ],202);
    }
    public function destroy(Article $article)
    {
        $article->delete();
        return response()->json([
            'message' => '删除成功',
            'code'    => 1004,
        ],202);
    }

}
