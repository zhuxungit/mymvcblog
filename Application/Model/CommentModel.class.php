<?php
namespace Model;

class CommentModel extends \Core\Model
{
    public function setComment($aid)
    {
        $sql="update article set comment=comment+1 where id=$aid";
        $this->mypdo->exec($sql);
    }

    /**
     * 插入评论
     * @param $uid
     * @param $pid
     * @param $aid
     * @param $content
     * @return mixed
     */
    public function insert($uid, $pid, $aid, $content)
    {
        $time = time();
        $sql="insert into comment (uid, pid, aid, content, created_time, updated_time, display) value($uid, $pid, $aid, '$content', $time, $time, 1)";
//        echo $sql;
//        die;
        return $this->mypdo->exec($sql);
    }

    /**
     * 获得所有数据
     * @return mixed
     */
    public function getAll($aid)
    {
        $sql = "select comment.*,user.username,user.avatar from comment left join user on comment.uid=user.id where comment.aid=$aid";
        return $this->mypdo->fetchAll($sql);
    }

    /**
     * 评论树形排序
     * @param $commentdata
     */
    private $commentSrr=array();
    public function getTree($commentdata,$pid=0,$level=0)
    {
        foreach ($commentdata as $k=>$v){
            if ($v['pid']==$pid){
                $v['level'] = $level;
                $this->commentSrr[] = $v;
                $this->getTree($commentdata,$v['id'],$level+1);
            }
        }
        return $this->commentSrr;
    }


}