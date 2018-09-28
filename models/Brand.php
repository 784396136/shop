<?php
namespace models;

class Brand extends Model
{
    // 设置这个模型对应的表
    protected $table = 'brand';
    // 设置允许接收的字段
    protected $fillable = ['brand_name','logo']; 

    // 会在修改添加前自动调用
    public function _before_write()
    {
        $this->_del_logo();
        $uploader = \libs\Uploader::make();
        $path = '/uploads/' . $uploader->upload('logo','brand');
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
}