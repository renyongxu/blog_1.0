<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use App\Http\Model\Config;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfigController extends CommonController
{
    /**
     * Display a listing of the resource.
     * 配置项列表
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = Config::orderBy('conf_order','asc')->get();
        foreach ($data as $k=>$v){
            switch ($v->field_type){
                case 'input':
                    $data[$k]->_html = '<input type="text" class="lg" name="conf_content" value="'.$v->conf_content.'">';
                    break;
                case 'textarea':
                    $data[$k]->_html = '<textarea type="text" name="conf_content">'.$v->conf_content.'</textarea>';
                    break;
                case 'radio':
//                    array:2 [▼
//                      0 => "1|开启",
//                      1 => "0|关闭",
//                    ]
                    $arr = explode(',',$v->field_value);
//                    dd($arr);
                    $str = '';

                    foreach ($arr as $m=>$n) {
                       $r = explode('|',$n);
//                       dd($r);
                        //print_r($r);
                       $c = $v->conf_content == $r[0] ? 'checked' : '';
                       $str .= '<input type="radio" name="conf_content" value="'. $r[0].'"'. $c .'>'.$r['1'].'　';
                    }
                    $data[$k]->_html = $str;
//                    echo $str;
                    break;

            }
        }


        return view('admin.config.index',compact('data'));
    }

    public function changeOrder()
    {

        $input = Input::all();
        $conf = Config::find($input['conf_id']);
        $conf->conf_order = $input['conf_order'];
        $re = $conf->update();
        if ($re){
            $data = [
                'status' => 0,
                'msg' => '配置项排序更新成功!'
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '配置项排序更新失败,请稍后重试!'
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
        $data = Config::all();
        return view('admin/config/add',compact('data'));
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
            'conf_name'=>'required',
            'conf_title'=>'required',

        ];
        //  将英文替换成中文
        $message = [
            'conf_name.required'=>'配置项名称不能为空!',
            'conf_title.required'=>'配置项标题不能为空!',


        ];
        //  表单验证
        $validator = Validator::make($input,$rules,$message);
        if ($validator->passes()){

            $re = Config::create($input);
            if ($re){
                return redirect('admin/config');
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
        $filed = Config::find($id);
        return view('admin.config.edit',compact('data','filed'));
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
        $re = Config::where('conf_id',$id)->update($input);
        if ($re){
            return redirect('admin/config');
        }else{
            return back()->with('errors','配置项修改错误,稍后再试!');
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
        $r = Config::where('conf_id',$id)->delete();
        if ($r){
            $data = [
                'status'=>0,
                'msg'=>'配置项删除成功!'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'配置项删除失败,请稍后再试!'
            ];

        }
        return $data;

    }
}
