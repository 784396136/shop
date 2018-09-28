<?php
namespace models;

/**
 * 该模型是所有模型的父模型
 */
class model
{

    /**
     * 设置钩子函数
     */
    protected function _before_write(){}
    protected function _after_write(){}
    protected function _before_delete(){}
    protected function _after_delete(){}

    // 设置表名
    protected $table;
    // 将提交表单中接收到的数据设置到改属性上
    protected $data;

    protected $_db;
    public function __construct()
    {
        $this->_db = \libs\Db::make();
    }

    // 接收表单中的数据
    public function fill($data)
    {
        // echo "<pre>";
        // var_dump($data);die;
        $this->data = $data;
    }

    public function delete($id)
    {
        $this->_before_delete();
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->_db->prepare($sql);
        $stmt -> execute([$id]);
        $this->_after_delete();
    }

    // 更新数据
    public function update($id)
    {
        $this->_before_write();
        $set = [];
        $values = [];
        foreach($this->data as $k => $v)
        {
            $set[] = "$k=?";
            $values[] = $v;
        }
        $set = implode(',',$set);
        $values[] = $id;
        $sql = "UPDATE {$this->table} SET $set WHERE id = ?";
        // echo "<pre>";
        // var_dump($sql,$values);die;
        $stmt = $this->_db->prepare($sql);
        $stmt->execute($values);
        $this->_after_write();
    }

    public function insert()
    {
        $this->_before_write();

        $keys = [];
        $values = [];
        $token = [];
        // echo "<pre>";
        // var_dump($this->data);die;
        foreach($this->data as $k=>$v)
        {
            $keys[] = $k;
            $values[] = $v;
            $token[] = '?';
        }
        $keys = implode(',',$keys);
        $token = implode(',',$token);

        $sql = "INSERT INTO {$this->table}($keys) VALUES($token)";
        // var_dump($sql,$values);die;
        $stmt = $this->_db->prepare($sql);
        // var_dump($this->data);die;
        $stmt->execute($values); 

        $this->_after_write();
    }

    public function findAll( $options=[] )
    {
        $_option = [
            'fields' => '*',
            'where' => '1',
            'order_by' => 'id',
            'order_way' => 'desc',
            'pre_page' => 20,
        ];

        // 
        if($options)
        {
            $_option = array_merge($_option,$options);
        }

        // 翻页
        $page = isset($_GET['page']) ? max(1,(int)$_GET['page']) : 1;
        $offset = ($page-1)*$_option['pre_page'];

        $sql = "SELECT {$_option['fields']}
                    FROM {$this->table}
                    WHERE {$_option['where']}
                    ORDER BY {$_option['order_by']} {$_option['order_way']}
                    LIMIT {$offset} , {$_option['pre_page']}";
        $stmt = $this->_db->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll( \PDO::FETCH_ASSOC );

        // 获取总记录数
        $stmt = $this->_db->prepare("SELECT COUNT(*) FROM {$this->table} WHERE {$_option['where']}");
        $stmt->execute();
        $count = $stmt->fetch( \PDO::FETCH_COLUMN );
        $pageCount = ceil($count/$_option['pre_page']);
        $page_str = "";
        if($pageCount>1)
        {
            for($i=0;$i<$pageCount;$i++)
            {
                $page_str .= "<a href='?page='.$i>{$i}</a>"; 
            }
        }
        return [
            'data' => $data,
            'page' => $page_str
        ];
            
    }

    // 查询一条记录
    public function getOne($id)
    {
        $stmt = $this->_db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}