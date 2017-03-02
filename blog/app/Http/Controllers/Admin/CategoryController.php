<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CategoryController extends CommonController
{
    //  get admin/category  全部分类列表
    public function index()
    {
        $data = ( new Category())->tree();
        return view('admin.category.index')->with('data',$data);
    }

    //  排序之后修改对应的值
    public function changeOrder()
    {

        $input = Input::all();
        $cate = Category::find($input['cate_id']);
        $cate->cate_order = $input['cate_order'];
        $re = $cate->update();
        if ($re){
            $data = [
                'status' => 0,
                'msg' => '分类排序更新成功!'
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '分类排序更新失败,请稍后重试!'
            ];
        }

        return $data;
    }
    
    //  get admin/category/create   添加分类
    public function create()
    {
        $data = Category::where('cate_pid',0)->get();

        return view('admin/category/add',compact('data'));
    }

    //POST admin/category       添加分类提交
    public function store()
    {
        $input = Input::except('_token');
        //$input = Input::except('token');
        //$input['cate_time'] = time();
        //    $re = Article::create($input);

        $rules = [
            'cate_name'=>'required',
            'cate_title'=>'required'
        ];
        //  将英文替换成中文
        $message = [
            'cate_name.required'=>'分类名称不能为空!',
            'cate_title.required'=>'分类标题不能为空!',

        ];
        //  表单验证
        $validator = Validator::make($input,$rules,$message);
        if ($validator->passes()){

            $re = Category::create($input);
            if ($re){
                return redirect('admin/category');
            }else{
                return back()->with('errors','数据添加失败,请稍后重试!');
            }
        }else{
            return back()->withErrors($validator);
        }
//
    }

    // get admin/category/{category}    显示单个分类信息
    public function show()
    {

    }


    // put.patch admin/category/{category}      更新单个分类
    public function update($cate_id)
    {
        $input = Input::except('_token','_method');
        $res = Category::where('cate_id',$cate_id)->update($input);
        if($res){
            return redirect('admin/category');
        }else{
            return back()->with('errors','分类信息更新失败,请稍后再试!');
        }
    }


    // get admin/category/{category}        编辑单个分类
    public function edit($request)
    {
        $res = Category::find($request);
        $data = Category::where('cate_pid',0)->get();

        return view('admin.category.edit',compact('res','data'));
    }



    // delete admin/category/{category}     删除单个分类
    public function destroy($request)
    {
        $r = Category::where('cate_id',$request)->delete();
        Category::where('cate_pid',$request)->update(['cate_pid'=>0]);
        if ($r){
            $data = [
                'status'=>0,
                'msg'=>'分类删除成功!'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'分类删除失败,请稍后再试!'
            ];

        }
        return $data;
    }
}
