<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ArticleController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Article::orderBy('art_id','desc')->paginate(6);
//        dd($data->links());
        return view('admin.article.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = ( new Category())->tree();
//        dd($data);
        return view('admin.article.add',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 提交文章
     */
    public function store(Request $request)
    {
        $input = Input::except('token');
        $input['art_time'] = time();
       //    $re = Article::create($input);

        $rules = [
            'art_title'=>'required',
            'art_content'=>'required'
        ];
        //  将英文替换成中文
        $message = [
            'art_title.required'=>'文章标题不能为空!',
            'art_content.required'=>'文章内容不能为空!',

        ];
        //  表单验证
        $validator = Validator::make($input,$rules,$message);
        if ($validator->passes()){

            $re = Article::create($input);
            if ($re){
                return redirect('admin/article');
            }else{
                return back()->with('errors','数据添加失败,请稍后重试!');
            }
        }else{
            return back()->withErrors($validator);
        }


    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = ( new Category())->tree();
        $filed = Article::find($id);
        return view('admin.article.edit',compact('data','filed'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = Input::except('_token','_method');
        $re = Article::where('art_id',$id)->update($input);
        if ($re){
            return redirect('admin/article');
        }else{
            return back()->with('errors','文章修改错误,稍后再试!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $r = Article::where('art_id',$id)->delete();
        if ($r){
            $data = [
                'status'=>0,
                'msg'=>'文章删除成功!'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'文章删除失败,请稍后再试!'
            ];

        }
        return $data;

    }
}
