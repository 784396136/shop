<?php
namespace controllers;
use models\Category;

class CategoryController{
    // 列表页
    public function index()
    {
        $model = new Category;
        $res = $model->findAll();
        view('category/index',$res);
    }

    // 显示添加的表单
    public function create()
    {
        view('category/create');
    }

    // 处理添加表单
    public function insert()
    {

    }

    // 显示修改的表单
    public function edit()
    {
        view('category/edit');
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