<?php
namespace Model;

/**
 * 文章模型
 * @package Model
 */
class ArticleModel  extends \Core\Model

{
    public function setZan($aid)
    {
        $sql = "update article set zan=zan+1 where id=$aid";
        return $this->mypdo->exec($sql);
    }
    public function setRead($aid)
    {
        $sql = "update article set click=click+1 where id=$aid";
        $this->mypdo->exec($sql);
    }

    public function getCategory($category)
    {
        $sql="select a.*,b.name as categoryName from article as a left join category as b on a.cid=b.id where a.id=$category";
        return $this->mypdo->fetchAll($sql);
    }
    /**
     * 获取分类数据
     */
    public function getCategoryAll()
    {
        $sql = "select * from category";
        return $this->mypdo->fetchAll($sql);

    }

    /**
     * 获取树形分类列表
     * @param $categoryList
     * @param int $pid
     * @param int $level
     * @return array
     */
    public function getTree($categoryList,$pid=0,$level=0)
    {
        static $arr;
        foreach ($categoryList as $v)
        {
            if ($v['pid'] ==$pid){
                $v['level'] = $level;
                $arr[] = $v;

                $this->getTree($categoryList,$v['id'],$level+1);
            }
        }
        return $arr;
    }



    /**更新文章数据
     * @param $id
     * @param $cid
     * @param $title
     * @param $author
     * @param $keywords
     * @param $description
     * @param $content
     * @param $isTuijian
     * @param $display
     * @return mixed
     */
    public function update($id, $cid, $title, $author,$image, $keywords, $description, $content, $isTuijian, $display)
    {
        $sql = "update article set cid=$cid, title='$title', author='$author',image='$image', keywords='$keywords', description='$description', content='$content', isTuijian=$isTuijian, display=$display where id=$id ;";

        echo $sql;

        return $this->mypdo->exec($sql);
    }
    /**
     * 添加文章数据
     * @param $cid
     * @param $title
     * @param $author
     * @param $keywords
     * @param $description
     * @param $content
     * @param $isTuijian
     * @param $display
     * @return mixed
     */
    public function insert($uid,$cid, $title, $author,$image, $keywords, $description, $content, $isTuijian, $display)
    {
        $sql = "insert into article (uid,cid, title, author,image, keywords, description, content, isTuijian, display) value ($uid, $cid, '$title', '$author','$image', '$keywords', '$description', '$content', $isTuijian, $display);";
        return $this->mypdo->exec($sql);
    }

    /**
     * 获取单条数据
     * @param $id
     * @return mixed
     */
    public function getRow($id)
    {
        $sql= "select article.*,category.name as categoryName from article left join category on article.cid=category.id where article.id=$id";

//        var_dump($sql);
//        die;

        return $this->mypdo->fetchRow($sql);
    }

    /**
     * @param $condition 条件
     * @param $is_result true返回查询结果SQL语句，false表示查询总记录的SQL语句
     * @return mixed
     */
    private function createSQLByCondition($condition=array(),$is_result)
    {
//        echo '<pre>';
//        var_dump($condition);
//        die;

        if ($is_result){
            $sql="select a.*,b.name as categoryName from article as a left join category as b on a.cid=b.id where 1";
        }else{
            $sql="select count(*) from article as a where 1";
        }
        //遍历条件数组，根据不同的字段拼接SQL语句

        foreach ($condition as $k=>$v) {
            if($v=='')
            continue;
            //如果是标题或者关键字用模糊查询
            if(in_array($k,array('title','keywords'))){
                $sql.=" and a.$k like '%$v%'";
            }
            //如果是类别编号，则获取当前类别和所有子类别下的所有文章
            elseif ($k=='category'){
                $cate_model = new \Model\CategoryModel();
                $catelist=$cate_model->getAll();
//                echo '<pre>';
//                var_dump($v);
//                die;

                $cate_list =$cate_model->getTree($catelist,$v);
                if(!$cate_list){
                    $cate_list=array();
                }
//                echo '<pre>';
//                var_dump($cate_list);
//                die;
                $id_array[]=$v;
                foreach ($cate_list as $v2){
                    $id_array[]=$v2['id'];
                }
                $id_str = implode(',',$id_array);
                $sql.=" and a.cid in ($id_str)";

//                echo '<pre>';
//                var_dump($sql);
//                die;
            }
            else{
                $sql.=" and a.$k = $v";
            }
        }
//        $sql.=" order by a.isTuijian desc,a.id desc";
        return $sql;
    }

    /**
     * 获得所有文章数据个数
     * @return mixed
     */
    public function getArticalCount($condition)
    {
        $sql=$this->createSQLByCondition($condition,false);


//        var_dump($sql);//select count(*) from article as a where 1 and a.cid in (4,1,2,17,4,13,9,5,7,15,10,8,14,13,9)
//        die;

        return $this->mypdo->fetchColumn($sql);
    }

    public function getArticleByCondition($condition,$startno,$pagesize)
    {
        $sql=$this->createSQLByCondition($condition,true);

//        var_dump($sql);//select count(*) from article as a where 1 and a.cid in (4,1,2,17,4,13,9,5,7,15,10,8,14,13,9)
//        die;


        $sql.=" order by a.isTuijian desc,a.id desc limit $startno,$pagesize";



        return $this->mypdo->fetchAll($sql);

    }

    /**
     * 删除文章
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->mypdo->exec("delete from artical where id=$id");
    }

}