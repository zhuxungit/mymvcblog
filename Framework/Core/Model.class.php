<?php
namespace Core;

/**
 * 基础模型
 */
class Model
{
    protected $mypdo;  //用于保存pdo实例
    private $table;  //保存当前正在操作的表名
    public function __construct($table='')
    {
        $this->mypdo =  MyPDO::getInstance();
        $this->getTable($table);
    }

    /**
     * 获取表名
     * @param $table
     */
    private function getTable($table){
        $this->table =$table;
        if($table==''){
            $this->table = substr(basename(get_class($this)),0,-5);
        }
    }

    /**
     * 获取表的主键
     */
    private function getPrimaryKey(){
        $rs = $this->mypdo->fetchAll("desc `{$this->table}`" );
        foreach ($rs as $k=>$v){
            if ($v['Key']=='PRI'){
                return $v['Field'];
            }
        }
        return null;
    }

    /**
     * 封装insert语句
     * @param $data
     * @return null
     */
    public function inserttest($data)
    {
        $fields = array_keys($data);
//         $pk = $this->getPrimaryKey();
//         unset($data[$pk]);
        $fields = array_map(function ($field){return "`{$field}`";},$fields);
        $filed = implode(',',$fields);

        $values = array_values($data);
        $values = array_map(function ($value){return "'{$value}'";},$values);
        $value = implode(',',$values);

        $sql = "insert into `{$this->table}` ({$filed}) values ($value)";
        if($this->mypdo->exec($sql)){
            return $this->mypdo->lastInsertId();
        }
        return null;
    }

    /**
     * 封装update语句
     * @param $data
     */
    public function updatetest($data)
    {
        $fields = array_keys($data);
        $pk = $this->getPrimaryKey();
        $index = array_search($pk,$fields);
        unset($fields[$index]);
        $fields = array_map(function ($field) use($data){return "`{$field}`='{$data[$field]}'";},$fields);
        $field = implode(',',$fields);

        $sql = "update `{$this->table}` set {$field} where `{$pk}` = {$data[$pk]}";

//        echo $sql;
//        die;
        return $this->mypdo->exec($sql);
    }

    /**
     * 封装delete语句
     * $id 主键编号
     * delete from user where id = 1;
     */
    public function deletetest($id)
    {
        $pk = $this->getPrimaryKey();
        $sql = "delete from `{$this->table}` where `{$pk}`= {$id}";
        return $this->mypdo->exec($sql);
    }


    /**
     * 封装查询语句
     * @param string $field 查询数据排序字段
     * @param string $order
     * 返回二维数组
     */
    public function seletetest($field='',$order='asc')
    {
        if($field==''){
            $field = $this->getPrimaryKey();
        }
        $sql = "select * from `{$this->table}` order by '{$field}' $order";
        return $this->mypdo->fetchAll($sql);
    }

    /**
     * 封装查询语句
     * 返回一维数组
     * @param $id 主键id
     */
    public function findtest($id){
        $pk = $this->getPrimaryKey();
        $sql = "select * from `{$this->table}` where `{$pk}` = $id";
        return $this->mypdo->fetchRow($sql);
    }

}