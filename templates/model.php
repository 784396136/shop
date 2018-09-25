namespace models;

class <?=ucfirst($tableName)?> extends Db
{
    //取出所有数据
    public function getAll()
    {
        $stmt = self::$_pdo->query("SELECT * FROM <?=$tableName?>");
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    //插入数据
    public function insert()
    {

    }

    //更新数据
    public function update()
    {

    }

    //删除数据
    public function delete()
    {

    }

    //查询数据
    public function search()
    {
        
    }
}