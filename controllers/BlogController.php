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
        $model = new Blog;
        $model->fill($_POST);
        $model->insert();
        redirect('/blog/index');
    }

    // 显示修改的表单 
    public function edit()
    {
        $model = new Blog;
        $data = $model->getOne($_GET['id']); 
        view('blog/edit',[
                'data' => $data,
            ]);
    }

    // 修改表单的方法
    public function update()
    {
        $model = new Blog;
        $model->fill($_POST);
        $model->update($_GET['id']);
        redirect('/blog/index');
    }

    // 删除
    public function delete()
    {
        $model = new Blog;
        $model->delete($_GET['id']);
        redirect('/blog/index');
    }
}