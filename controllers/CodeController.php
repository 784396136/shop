<?php
namespace controllers;

class CodeController
{
    public function make()
    {
        $tableName = $_GET['name'];
        $mname = ucfirst($tableName);
        // 拼出控制器名称
        $cname = ucfirst($tableName)."Controller";

        // 取出表中的所有字段的名称 类型 注释
        // $sql = "select column_name name,column_comment comment,data_type type  from information_schema.columns where table_schema = 'shop'  and table_name = '$tableName'";
        $sql = "SHOW FULL FIELDS FROM $tableName";
        $db = \libs\Db::make();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll( \PDO::FETCH_ASSOC );
        // echo "<pre>";
        // var_dump($data);
        // die;
        $fillable = [];
        foreach($data as $v)
        {
            if($v['Field']=='id' || $v['Field']=='created_at')
                continue;
            $fillable[] = $v['Field'];
        }
        $fillable = implode("','", $fillable);

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