<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use App\Http\Model\Navs;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class NavsController extends CommonController
{
    /**
     * Display a listing of the resource.
     * 导航栏列表
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = Navs::orderBy('nav_order','asc')->get();

        return view('admin.navs.index',compact('data'));
    }

    public function changeOrder()
    {

        $input = Input::all();
        $nav = Navs::find($input['nav_id']);
        $nav->nav_order = $input['nav_order'];
        $re = $nav->update();
        if ($re){
            $data = [
                'status' => 0,
                'msg' => '导航排序更新成功!'
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '导航排序更新失败,请稍后重试!'
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
        $data = Navs::all();
        return view('admin/navs/add',compact('data'));
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
            'nav_name'=>'required',
            'nav_url'=>'required',

        ];
        //  将英文替换成中文
        $message = [
            'nav_name.required'=>'导航标题不能为空!',
            'nav_url.required'=>'导航地址不能为空!',


        ];
        //  表单验证
        $validator = Validator::make($input,$rules,$message);
        if ($validator->passes()){

            $re = Navs::create($input);
            if ($re){
                return redirect('admin/navs');
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
        $filed = Navs::find($id);
        return view('admin.navs.edit',compact('data','filed'));
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
        $re = Navs::where('nav_id',$id)->update($input);
        if ($re){
            return redirect('admin/navs');
        }else{
            return back()->with('errors','导航栏修改错误,稍后再试!');
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
        $r = Navs::where('nav_id',$id)->delete();
        if ($r){
            $data = [
                'status'=>0,
                'msg'=>'导航栏删除成功!'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'导航栏删除失败,请稍后再试!'
            ];

        }
        return $data;

    }
}
