<?php
namespace Controller\Home;

/**
 * 前台文章控制器
 * Class ArticleController
 * @package Controller\Home
 */
class ArticleController extends \Core\Controller
{
    public function zanAction()
    {
        $categoryModel = new \Model\CategoryModel();
        $categorylist  = $categoryModel->getAll();
        $categorylist  = $categoryModel->getTree($categorylist);
        $this->smarty->assign('categorylist',$categorylist);


        $aid=$_GET['aid'];
        $articleModel = new \Model\ArticleModel();
        $articleModel->setZan($aid);

        $rowdata = $articleModel->getRow($aid);
        $this->smarty->assign('rowdata',$rowdata);

        $commentModel = new \Model\CommentModel();
        $commentdata = $commentModel->getAll($aid);
        $commentdata = $commentModel->getTree($commentdata);
//        echo '<pre>';
//        var_dump($commentdata);
//        die;
        $this->smarty->assign('commentdata',$commentdata);
        $this->smarty->display('detail.html');
    }
    /**
     *文章详情
     */
    public function detailAction()
    {
        $categoryModel = new \Model\CategoryModel();
        $categorylist  = $categoryModel->getAll();
        $categorylist  = $categoryModel->getTree($categorylist);
        $this->smarty->assign('categorylist',$categorylist);

        $aid = (int)$_GET['aid'];

        $articleModel = new \Model\ArticleModel();

        //文章浏览一次，浏览量自增
        $articleModel->setRead($aid);

        $rowdata = $articleModel->getRow($aid);
        $this->smarty->assign('rowdata',$rowdata);

        $commentModel = new \Model\CommentModel();
        $commentdata = $commentModel->getAll($aid);
        $commentdata = $commentModel->getTree($commentdata);
//        echo '<pre>';
//        var_dump($commentdata);
//        die;
        $this->smarty->assign('commentdata',$commentdata);
        $this->smarty->display('detail.html');
    }

    /**
     * 文章列表
     */
    public function listAction()
    {

        $categoryModel = new \Model\CategoryModel();
        $categorylist  = $categoryModel->getAll();
        $categorylist  = $categoryModel->getTree($categorylist);
        $this->smarty->assign('categorylist',$categorylist);
//        echo '<pre>';
//        var_dump($categorylist);
//        die;
        $category = (int)$_GET['category'];

        $articleModel = new \Model\ArticleModel();
        $condition['category']=$category;
        $recordcount =$articleModel->getArticalCount($condition);
//        $condition['category']=$id;
//        echo '<pre>';
//        var_dump($condition);
//        die;

        $page = new \Libs\PageLibs($recordcount,$GLOBALS['configs']['app']['pagesize']);
        $listdata = $articleModel->getArticleByCondition($condition,$page->startno,$page->pagesize);

        $pageStr =$page->show($condition);
        $this->smarty->assign('listdata',$listdata);
        $this->smarty->assign('pageStr',$pageStr);
//        echo '<pre>';
//        var_dump($listdata);
//        die;

        $this->smarty->display('list.html');
    }
}