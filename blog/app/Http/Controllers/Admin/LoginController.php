<?php

namespace App\Http\Controllers\Admin;
use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Symfony\Component\VarDumper\Dumper\DataDumperInterface;

require_once substr(dirname(__FILE__),0,5).'/org/code/Code.class.php';


class LoginController extends CommonController
{
    public function login()
    {
        if ($input = Input::all()){
            $code = new \Code();
            $_code = $code->get();
            if (strtoupper($input['code']) != $_code){
                return back()->with('msg','验证码错误');
            }
            $user = User::first();
            if ($user->user_name != $input['user_name'] || Crypt::decrypt($user->user_pass) != $input['user_pass']){
                return back()->with('msg','用户名或者密码错误');
            }
            session(['user'=>$user]);
//            dd(session('user'));
            return redirect('admin');
        }else {
//            session(['user'=>null]);
            return view('admin.login');
        }
    }

    public function code()
    {
//        $t = User::first();
//        dd($t);
        $c = new \Code();
        $c->make();

    }

    public function getcode()
    {
        $code = new \Code();
        echo $code->get();
    }

    public function crypt()
    {
        $str = 'cece';
        echo Crypt::encrypt($str);
    }
}
?>