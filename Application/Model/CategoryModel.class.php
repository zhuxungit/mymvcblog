<?php
namespace Model;

/**
 * 分类模型
 * @package Model
 */
class CategoryModel extends \Core\Model
{
    /**
     * 获取单条数据
     * @param $id
     * @return mixed
     */
    public function getRow($id)
    {
        $sql= "select * from category where id=$id";
        return $this->mypdo->fetchRow($sql);
    }

    /**
     * 更新分类
     */
    public function update($id,$pid,$name,$sort)
    {
        $sql = "update category set pid=$pid, name= '$name', sort= $sort where id=$id";

//        echo $sql;
//        die;
        return $this->mypdo->exec($sql);
    }

    /**
     * 查询列表数据
     * @return mixed
     */
    public function getAll()
    {
        $sql="select * from category";
        return $this->mypdo->fetchAll($sql);
    }

    /**
     * 添加分类
     * @param $pid
     * @param $name
     * @param $sort
     * @return mixed
     */
    public function insert($pid,$name,$sort)
    {
        $sql="insert into category (id,pid,name,sort)value(null,$pid,'$name',$sort)";
        return $this->mypdo->exec($sql);
    }

    /**
     * 递归实现无限极分类
     * @param $listdate
     * @param int $pid
     * @return mixed
     */
    public $arr=array();
    public function getTree($listdate , $pid=0 , $level=0)
    {
 //       static $arr;
        foreach ($listdate as $v){
            if ($v['pid']==$pid) {
                $v['level']=$level;
                $this->arr[] = $v;
                $this->getTree($listdate , $v['id'],$level+1);
            }
        }
        return $this->arr;
    }

    /**
     * 删除分类
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
         return $this->mypdo->exec("delete from article where id=$id");
    }

    /**
     * 判断当前分类是否有子分类
     */
    public function isSon($id)
    {
        $sql="select * from category where pid=$id";
        return $this->mypdo->fetchRow($sql);

    }


}