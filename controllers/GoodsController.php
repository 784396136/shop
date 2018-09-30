<?php
namespace controllers;
use models\Goods;

class GoodsController{

    // 获取子分类
    public function ajax_get_cat()
    {
        $id = (int)$_GET['id'];
        $model = new \models\Category;
        $data = $model->getCat($id);
        // 转成JSON
        echo json_encode($data);
    }

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
        $model = new \models\Category;
        $topCat = $model->getCat();
        // echo "<pre>";
        // var_dump($topCat);die; 
        view('goods/create',[
            'topCat' => $topCat,
        ]);
    }

    // 处理添加表单
    public function insert()
    {
        $model = new Goods;
        $model->fill($_POST);
        $model->insert();
        redirect('/goods/index');
    }

    // 显示修改的表单 
    public function edit()
    {
        $model = new Goods;
        $data = $model->getOne($_GET['id']); 
        view('goods/edit',[
                'data' => $data,
            ]);
    }

    // 修改表单的方法
    public function update()
    {
        $model = new Goods;
        $model->fill($_POST);
        $model->update($_GET['id']);
        redirect('/goods/index');
    }

    // 删除
    public function delete()
    {
        $model = new Goods;
        $model->delete($_GET['id']);
        redirect('/goods/index');
    }
}