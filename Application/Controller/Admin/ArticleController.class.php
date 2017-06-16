<?php
namespace Controller\Admin;
use Model\ArticleModel;

/**
 * 文章控制器
 * @package Controller\Admin
 */
class ArticleController extends \Controller\Admin\BaseController
{

    private $articlemodel;

    public function __construct()
    {
        parent::__construct();

        //实例化用户模型
        $articlemodel = new ArticleModel();
        $this->articlemodel =  $articlemodel;
    }

    /**
     * 更新文章
     */
    public function updateAction()
    {
        if (IS_POST) {
            //1.接受数据

            $id = (int)$_POST['id'];
            //根据文章id获取用户信息
            $info = $this->articlemodel->getRow($id);
            $uid = $_SESSION['userinfo']['id'];

            if(empty($info)||$info['uid']!=$uid){
                $this->error('更改别人数据数不对的','index.php?p=admin&c=article&a=list');
            }

            $cid = (int)$_POST['cid'];
            $title = $_POST['title'];
            $author = $_POST['author'];
            $keywords = $_POST['keywords'];
            $description = $_POST['description'];
            $content = $this->xssObj->purify($_POST['content']);
            $isTuijian = (int)$_POST['isTuijian'];
            $display = (int)$_POST['display'];

            $image='';
            if(!empty($_FILES['image']['name']))
            {
                //创建上传文件对象
                $imagemodel = new \Libs\UploadLibs($GLOBALS['configs']['app']['upload_path'],$GLOBALS['configs']['app']['upload_size'],$GLOBALS['configs']['app']['upload_type']);
                //调用上传文件方法
                $image=$imagemodel->upload($_FILES['image']);
            }

            $rs  = $this->articlemodel->update($id,$cid, $title, $author,$image, $keywords, $description, $content, $isTuijian,  $display);
            //判断状态并跳转
            if ($rs) {
                $this->success('修改成功', 'index.php?p=admin&c=article&a=articlelist', 1);
            } else {
                $this->error('修改失败', 'index.php?p=admin&c=article&a=update&id='.$id, 1);
            }

        }else{

            //将原始数据显示在页面
            $id=$_GET['id'];
            $rowdata = $this->articlemodel->getRow($id);

            $this->smarty->assign('rowdata',$rowdata);
            //显示树形分类
            $categorymodel= new \Model\CategoryModel();
            $listdata = $categorymodel->getAll();

            $listdata = $categorymodel->getTree($listdata);
            $this->smarty->assign('listdata',$listdata);
            $this->smarty->display('update.html');

        }
    }

    /**
     * 文章列表
     */
    public function articlelistAction()
    {

        $categoryList=$this->articlemodel->getCategoryAll();
        $categoryList=$this->articlemodel->getTree($categoryList);
        $this->smarty->assign('categoryList',$categoryList);
        //查询条件
        $condition['category'] = isset($_REQUEST['category'])?$_REQUEST['category']:'';
        $condition['keywords'] = isset($_REQUEST['keywords'])?$_REQUEST['keywords']:'';
        $condition['title'] = isset($_REQUEST['title'])?$_REQUEST['title']:'';
        $condition['isTuijian'] = isset($_REQUEST['isTuijian'])?$_REQUEST['isTuijian']:'';
        $condition['display'] = isset($_REQUEST['display'])?$_REQUEST['display']:'';
        $condition['uid'] = $_SESSION['userinfo']['id'];

        $recordcount=$this->articlemodel->getArticalCount($condition);

//       var_dump($_SESSION['userinfo']);
//       die;

        if ($recordcount>0){
            $page = new \Libs\PageLibs($recordcount,$GLOBALS['configs']['app']['pagesize']);
            $pege_str=$page->show($condition);
            $listdata=$this->articlemodel->getArticleByCondition($condition,$page->startno,$page->pagesize);
        }else{
            $listdata=array();
            $pege_str='';
        }

        $this->smarty->assign('listdata',$listdata);
        $this->smarty->assign('page_str',$pege_str);
        $this->smarty->display('articlelist.html');
    }

    /**
     * 添加文章
     */
    public function addarticleAction()
    {
        if (IS_POST) {
            //1.接受数据
            $cid = (int)$_POST['cid'];
            $title = $_POST['title'];
            $author = $_POST['author'];
            $keywords = $_POST['keywords'];
            $description = $_POST['description'];
            //$content = $this->xssObj->purify($_POST['content']);
            $content = $_POST['content'];
            $isTuijian = (int)$_POST['isTuijian'];
            $display = (int)$_POST['display'];

            $imagemodel = new \Libs\UploadLibs($GLOBALS['configs']['app']['upload_path'],$GLOBALS['configs']['app']['upload_size'],$GLOBALS['configs']['app']['upload_type']);
            $image=$imagemodel->upload($_FILES['image']);

            $uid = $_SESSION['userinfo']['id'];

            $rs  = $this->articlemodel->insert($uid,$cid, $title, $author,$image, $keywords, $description, $content, $isTuijian,  $display);
            //判断
            if ($rs) {
                $this->success('插入成功', 'index.php?p=admin&c=article&a=articlelist', 1);
            } else {
                $this->error('插入失败', 'index.php?p=admin&c=article&a=addartical', 1);
            }

        }else{
            $categoryModel = new \Model\CategoryModel();
            $listdata=$categoryModel->getAll();
            $listdata= $categoryModel->getTree($listdata);
            $this->smarty->assign('listdata',$listdata);
            $this->smarty->display('addarticle.html');
        }

    }
    /**
    删除文章
     */
    public function deleteAction()
    {

        $id=$_GET['id'];
        $categoryModel = new \Model\CategoryModel();
        if ($categoryModel->delete($id)) {
            $this->success('删除成功','index.php?p=admin&c=article&a=articlelist');
        }else{
            $this->error('删除失败','index.php?p=admin&c=article&a=articlelist');
        }

    }

}