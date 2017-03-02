<?php

namespace App\Http\Controllers\Home;

//use App\Http\Model\Navs;
use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Model\Links;
use Illuminate\Http\Request;

use App\Http\Requests;
//use App\Http\Controllers\Controller;

class IndexController extends CommonController
{
    //  首页操作
    public function index()
    {
        // 点击量最高的6篇文章

        $pics = Article::orderBy('art_view','desc')->take(6)->get();

        // 点击排行的5篇文章

        $hot = Article::orderBy('art_view','desc')->take(5)->get();

        // 最新发布文章8篇文章

        $new = Article::orderBy('art_time','desc')->take(8)->get();

        // 图文列表(带分页)

        $data = Article::orderBy('art_time','desc')->paginate(5);

        // 友情链接

        $links = Links::orderBy('link_order','asc')->get();

        // 网站配置项

        return view('home.index',compact('pics','hot','new','data','links'));
    }

    /*
     * 分类操作
     */

    public function cate($cate_id)
    {
        //  图文列表的4篇文章(带分页)
        $data = Article::where('cate_id',$cate_id)->orderBy('art_time','desc')->paginate(4);
        Category::where('cate_id',$cate_id)->increment('cate_view');
        //  当前分类的子分类
        $submenu = Category::where('cate_pid',$cate_id)->get();

        $cate = Category::find($cate_id);
        return view('home.list',compact('cate','data','submenu'));
    }

    /*
     * 文章操作
     */

    public function art( $art_id)
    {
        $field = Article::Join('category','article.cate_id','=','category.cate_id')->where('art_id',$art_id)->first();

        //  查看次数的自增
        Article::where('art_id',$art_id)->increment('art_view');

        // 获取上一篇文章
        $article['pre'] = Article::where('art_id','<',$art_id)->orderBy('art_id','desc')->first();

        // 获取下一篇文章
        $article['next'] = Article::where('art_id','>',$art_id)->orderBy('art_id','asc')->first();

        // 获取相关文章,通过相同分类来获取
        $data = Article::where('cate_id',$field->cate_id)->orderBy('art_id','desc')->take(6)->get();

        return view('home.new',compact('field','article','data'));


    }

}
