<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use App\Http\Model\Links;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LinksController extends CommonController
{
    /**
     * Display a listing of the resource.
     * 友情链接列表
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = Links::orderBy('link_order','asc')->get();

        return view('admin.links.index',compact('data'));
    }

    public function changeOrder()
    {

        $input = Input::all();
        $link = Links::find($input['link_id']);
        $link->link_order = $input['link_order'];
        $re = $link->update();
        if ($re){
            $data = [
                'status' => 0,
                'msg' => '链接排序更新成功!'
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '链接排序更新失败,请稍后重试!'
            ];
        }

        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Links::all();
        return view('admin/links/add',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = Input::except('_token');

        $rules = [
            'link_name'=>'required',
            'link_title'=>'required',
            'link_url'=>'required',
        ];
        //  将英文替换成中文
        $message = [
            'link_name.required'=>'链接标题不能为空!',
            'link_title.required'=>'链接内容不能为空!',
            'link_url.required' => '链接路径不能为空!'

        ];
        //  表单验证
        $validator = Validator::make($input,$rules,$message);
        if ($validator->passes()){

            $re = Links::create($input);
            if ($re){
                return redirect('admin/links');
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
        $filed = Links::find($id);
        return view('admin.links.edit',compact('data','filed'));
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
        $re = Links::where('link_id',$id)->update($input);
        if ($re){
            return redirect('admin/links');
        }else{
            return back()->with('errors','友情链接修改错误,稍后再试!');
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
        $r = Links::where('link_id',$id)->delete();
        if ($r){
            $data = [
                'status'=>0,
                'msg'=>'友情链接删除成功!'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'友情链接删除失败,请稍后再试!'
            ];

        }
        return $data;

    }
}
