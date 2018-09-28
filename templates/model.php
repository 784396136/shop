namespace models;

class <?=ucfirst($tableName)?> extends Model
{
    // 设置这个模型对应的表
    protected $table = '<?=$tableName?>';
    // 设置允许接收的字段
    protected $fillable = ['<?=$fillable?>']; 
}