<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CommonController extends Controller
{
    public function upload()
    {
        $file = Input::file('Filedata');
//        dd($file);
        if ($file->isValid()){
            $realPath = $file->getRealPath(); // 临时文件的绝对路径
            $entension = $file -> getClientOriginalExtension(); // 上传文件的后缀
            $newName = date('YmdHis').mt_rand(100,999).'.'.$entension;
            $path = $file -> move(base_path().'/public/uploads',$newName);

            $filepath = 'uploads/'.$newName;
            return $filepath;
        }
    }
}
