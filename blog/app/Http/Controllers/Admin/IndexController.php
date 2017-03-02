<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
class IndexController extends CommonController
{
    public function index()
    {
        return view('admin.index');
    }

    public function info()
    {
        return view('admin.info');

    }

    public function quit()
    {
        session(['user'=>null]);
        return redirect('admin/login');
    }

    //  修改超级管理员的密码
    public function pass()
    {

        if ($input = Input::all()){
            //  密码的规则  必填 | 范围 | 不一致
            $rules = [
                'password'=>'required | between:4,20 | confirmed',
            ];
            //  将英文替换成中文
            $message = [
                'password.required'=>'新密码不能为空!',
                'password.between'=>'新密码必须在6~20位之间!',
                'password.confirmed'=>'新密码与确认密码不一致!',

            ];
            //  表单验证
            $validator = Validator::make($input,$rules,$message);
            if ($validator->passes()){

                //  解析原密码
                $user = User::first();
                $_password = Crypt::decrypt($user->user_pass);
                //  判断原密码是否输入正确
                if ($input['password_o'] == $_password){
                    //  给新密码加密
                    $user->user_pass = Crypt::encrypt($input['password']);
                    $user->update();
//                    echo $user->user_pass;
                    return back()->with('errors','密码修改成功!');

                }else{
                    return back()->with('errors','原密码错误!');
                }
            }else{
//                dd($validator->errors()->all());
                return back()->withErrors($validator);
            }
        }
        return view('admin.pass');
    }
}
