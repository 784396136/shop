<?php
namespace controllers;

class CodeController
{
    public function make()
    {
        $tableName = $_GET['name'];
        // 拼出控制器名称
        $cname = ucfirst($tableName)."Controller";

        // 加载模板 创建控制器
        ob_start();
        include ROOT."templates/controller.php";
        $str = ob_get_clean();
        file_put_contents(ROOT.'controllers/'.$cname.".php","<?php\r\n".$str);

        // 创建模型
        ob_start();
        include ROOT."templates/model.php";
        $str = ob_get_clean();
        file_put_contents(ROOT.'models/'.ucfirst($tableName).".php","<?php\r\n".$str);

        // 生成视图文件
        @mkdir(ROOT."view/".$tableName,0777);
        // create.html
        ob_start();
        include ROOT."templates/create.html";
        $str = ob_get_clean();
        file_put_contents(ROOT.'view/'.$tableName.'/create.html',$str);

        // edit.html
        ob_start();
        include ROOT."templates/edit.html";
        $str = ob_get_clean();
        file_put_contents(ROOT.'view/'.$tableName.'/edit.html',$str);

        // index.html
        ob_start();
        include ROOT."templates/index.html";
        $str = ob_get_clean();
        file_put_contents(ROOT.'view/'.$tableName.'/index.html',$str);
    }
}