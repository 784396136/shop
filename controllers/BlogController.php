<?php
namespace controllers;
use models\Blog;

class BlogController{
    // 列表页
    public function index()
    {
        $model = new Blog;
        $res = $model->findAll();
        view('blog/index',$res);
    }

    // 显示添加的表单
    public function create()
    {
        view('blog/create');
    }

    // 处理添加表单
    public function insert()
    {

    }

    // 显示修改的表单
    public function edit()
    {
        view('blog/edit');
    }

    // 修改表单的方法
    public function update()
    {

    }

    // 删除
    public function delete()
    {

    }
}