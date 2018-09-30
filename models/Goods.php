<?php
namespace models;

class Goods extends Model
{
    // 设置这个模型对应的表
    protected $table = 'goods';
    // 设置允许接收的字段
    protected $fillable = ['goods_name','logo','is_on_sale','description','cat1_id','cat2_id','cat3_id','brand_id']; 

    // 会在修改添加前自动调用
    public function _before_write()
    {
        $this->_del_logo();
        $uploader = \libs\Uploader::make();
        $path = '/uploads/' . $uploader->upload('logo','goods');
        $this->data['logo'] = $path;
    }

    // 在删除前调用
    public function _before_delete()
    {
        $this->_del_logo();
    }

    protected function _del_logo()
    {
        // 如果是修改或删除就删除原图片
        if(isset($_GET['id']))
        {
            $old = $this->getOne($_GET['id']);
            @unlink( ROOT . 'public' . $old['logo']);
        }
    }

    public function _after_write()
    {
        // echo "<pre>";
        // var_dump($_FILES['image']);die;
        
        // 将数据保存到属性表
        $stmt = $this->_db->prepare("INSERT INTO goods_attribute(attr_name,attr_value,goods_id) VALUES(?,?,?)");
        foreach($_POST['attr_name'] as $k=>$v)
        {
            $stmt->execute([
                $v,
                $_POST['attr_value'],
                $this->data['id']
            ]);
        }

        // 将图片保存到图片表
        $uploader = \libs\Uploader::make();
        $stmt = $this->_db->prepare("INSERT INTO goods_image(goods_id,path) VALUES(?,?)");
        foreach($_FILES['image']['name'] as $k=>$v )
        {
            $_tmp = [];
            $_tmp['name'] = $v;
            $_tmp['type'] = $_FILES['image']['type'][$k];
            $_tmp['tmp_name'] = $_FILES['image']['tmp_name'][$k];
            $_tmp['error'] = $_FILES['image']['error'][$k];
            $_tmp['size'] = $_FILES['image']['size'][$k];
            $_FILES['tmp'] = $_tmp;
            $path = '/uploads/'.$uploader->upload('tmp','goods_img');
            $stmt->execute([
                $this->data['id'],
                $path
            ]);
        }

        // 把SKU添加到数据库
        $stmt = $this->_db->prepare("INSERT INTO goods_sku(goods_id,sku_name,stock,price) VALUES(?,?,?,?)");
        foreach($_POST['sku_name'] as $k=>$v)
        {
            $stmt->execute([
                $this->data['id'],
                $v,
                $_POST['stock'][$k],
                $_POST['price'][$k],
            ]);
            // echo "<pre>";
            // var_dump($stmt,$this->data['id'],
            // $v,
            // $_POST['stock'][$k],
            // $_POST['price'][$k]);die;
        }
    }
}