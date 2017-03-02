@extends('layouts.admin')
@section('content')
    <!--面包屑配置项 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{ url('admin/index') }}">首页</a> &raquo; 修改配置项
    </div>
    <!--面包屑配置项 结束-->

    <!--结果集标题与配置项组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>配置项管理</h3>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{ url('admin/config/create') }}"><i class="fa fa-plus"></i>新建配置项</a>
                <a href="{{ url('admin/config') }}"><i class="fa fa-recycle"></i>全部配置项</a>
            </div>
        </div>
    </div>
    <!--结果集标题与配置项组件 结束-->

    <div class="result_wrap">
        <form action="{{ url('admin/config/'.$filed->conf_id) }}" method="post">
            <input type="hidden" value="put" name="_method" >
            {{ csrf_field() }}
            <table class="add_tab">
                <tbody>

                <tr>
                    <th><i class="require">*</i>配置项名称：</th>

                    <td>
                        <input type="text" name="conf_title" value="{{ $filed->conf_title }}">
                        <span><i class="fa fa-exclamation-circle yellow"></i>配置项名称必须填写</span>
                        @if(count($errors) > 0)
                            @if(is_object($errors))
                                @foreach($errors->all() as $error)
                                    <div class="mark">
                                        <p style="color: red">{{ $error }}</p>
                                    </div>
                                @endforeach
                            @else
                                <div class="mark">
                                    <p style="color: red">{{ $errors }}</p>
                                </div>
                            @endif
                        @endif
                    </td>
                </tr>

                <tr>
                    <th><i class="require">*</i>配置项名称：</th>
                    <td>
                        <input type="text" class="lg" name="conf_name" value="{{ $filed->conf_name }}">
                        <span><i class="fa fa-exclamation-circle yellow"></i>配置项名称必须填写</span>
                    </td>
                </tr>

                <tr>
                    <th>配置项说明：</th>
                    <td>
                        <textarea name="conf_tips" id="" cols="30" rows="10">{{ $filed->conf_tips }}</textarea>
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>类型：</th>
                    <td>
                        <input type="text" class="lg" name="field_type" value="{{ $filed->field_type }}">
                        <span><i class="fa fa-exclamation-circle yellow"></i>类型:input testarea radio</span>
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>类型值：</th>
                    <td>
                        <input type="text" class="lg" name="field_value" value="{{ $filed->field_value }}">
                        <span><i class="fa fa-exclamation-circle yellow"></i></span>
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>配置项排序：</th>
                    <td>
                        <input type="text" class="sm" name="conf_order" value="0">
                    </td>
                </tr>
                <tr>
                    <th></th>
                    <td>
                        <input type="submit" value="提交">
                        <input type="button" class="back" onclick="history.go(-1)" value="返回">
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
@endsection