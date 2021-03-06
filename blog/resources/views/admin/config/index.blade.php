@extends('layouts.admin')
@section('content')
    <!--面包屑配置项 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{ url('admin/index') }}">首页</a> &raquo; 配置项管理
    </div>
    <!--面包屑配置项 结束-->

    <!--结果页快捷搜索框 开始-->
    {{--<div class="search_wrap">--}}
        {{--<form action="" method="post">--}}
            {{--<table class="search_tab">--}}
                {{--<tr>--}}
                    {{--<th width="120">选择分类:</th>--}}
                    {{--<td>--}}
                        {{--<select onchange="javascript:location.href=this.value;">--}}
                            {{--<option value="">全部</option>--}}
                            {{--<option value="http://www.baidu.com">百度</option>--}}
                            {{--<option value="http://www.sina.com">新浪</option>--}}
                        {{--</select>--}}
                    {{--</td>--}}
                    {{--<th width="70">关键字:</th>--}}
                    {{--<td><input type="text" name="keywords" placeholder="关键字"></td>--}}
                    {{--<td><input type="submit" name="sub" value="查询"></td>--}}
                {{--</tr>--}}
            {{--</table>--}}
        {{--</form>--}}
    {{--</div>--}}
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <!--快捷配置项 开始-->
            <div class="result_title">
                <h3>配置项列表</h3>
            </div>
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{ url('admin/config/create') }}"><i class="fa fa-plus"></i>新建配置项</a>
                    <a href="{{ url('admin/config') }}"><i class="fa fa-recycle"></i>全部配置项</a>
                </div>
            </div>

            <!--快捷配置项 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>

                        <th class="tc" width="5%">排序</th>
                        <th class="tc" width="5%">ID</th>
                        <th>配置项标题</th>
                        <th>配置项名称</th>
                        <th>配置项内容</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>

                        <td class="tc">
                            <input type="text" onchange="changeOrder(this,{{ $v->conf_id }})" name="ord[]" value="{{ $v->conf_order }}">
                        </td>
                        <td class="tc">{{ $v->conf_id }}</td>
                        <td>
                            <a href="#">{{ $v->conf_title }}</a>
                        </td>
                        <td>{{ $v->conf_name }}</td>
                        <td>{!! $v->_html !!}</td>

                        <td>
                            <a href="{{ url('admin/config/'.$v->conf_id.'/edit') }}">修改</a>
                            <a href="javascript:;" onclick="delCate({{ $v->conf_id }})">删除</a>
                        </td>
                    </tr>
                    @endforeach

                </table>



            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <script>
        function changeOrder(obj,conf_id) {
            var conf_order = $(obj).val();
            $.post('{{ url('admin/config/changeorder') }}',{'_token':'{{ csrf_token() }}','conf_id':conf_id,'conf_order':conf_order},function (data) {
                if (data.status == 0){
                    layer.msg(data.msg,{icon:6});
                }else {
                    layer.msg(data.msg,{icon:5});
                }
            });
        }

        //  删除分类
        
        function delCate(conf_id) {
            layer.confirm('您确定要删除这个配置项吗',
                {btn:['确定','取消']},
                function () {
//                    layer.msg('qqqq',{icon:1});
                    $.post('{{ url('admin/config/') }}'+'/'+conf_id,{'_method':'delete','_token':'{{ csrf_token() }}'},function (data) {
                        if (data.status == 0){
                            location.href = location.href;
                            layer.msg(data.msg,{icon:6});
                        }else {
                            layer.msg(data.msg,{icon:5});
                        }
                    });

                },function () {

                })
        }
        

    </script>
@endsection
