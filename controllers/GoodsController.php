<?php
namespace controllers;
use models\Goods;

class GoodsController{
    // 列表页
    public function index()
    {
        $model = new Goods;
        $res = $model->findAll();
        view('goods/index',$res);
    }

    // 显示添加的表单
    public function create()
    {
        view('goods/create');
    }

    // 处理添加表单
    public function insert()
    {

    }

    // 显示修改的表单
    public function edit()
    {
        view('goods/edit');
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