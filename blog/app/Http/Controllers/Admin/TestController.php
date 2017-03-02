<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
//use Illuminate\Support\Facades\Redis;
use Redis;
require_once substr(dirname(__FILE__),0,5).'/cclib/org/Chptcha.class.php';
class TestController extends CommonController
{
    public function test()
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1',6379);
        echo '连接成功';
        echo 'Server is running:'.$redis->ping();
    }

    public function info()
    {
       //dd(Redis::connection());

       Redis::set('name','hello');
        $value = Redis::get('name');
        echo $value;
    }
}
