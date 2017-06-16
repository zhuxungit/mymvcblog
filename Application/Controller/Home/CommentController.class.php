<?php
namespace Controller\Home;

class CommentController extends \Core\Controller
{

    public function addAction()
    {
        if (IS_POST){
            //var_dump($_POST);
            $aid = $_POST['aid'];
            if(!isset($_SESSION['userinfo']['id'])){
                $this->error('请先登录再评论','index.php?p=home&c=login&a=login');
            }
            $uid = $_SESSION['userinfo']['id'];
            $pid = $_POST['pid'];
            $content = $_POST['content'];
            $commentModel = new \Model\CommentModel();
            if($commentModel->insert($uid, $pid, $aid, $content)){
                $commentModel->setComment($aid);

                $this->success('评论成功',"index.php?p=home&c=article&a=detail&aid=$aid");
            }else{
                $this->error('评论失败','index.php?p=home&c=article&a=detail');
            }
        }else{

            $this->error('你想干啥','index.php?p=home&c=index&a=index');
        }
    }
}