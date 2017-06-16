<?php
namespace   Controller\Home;


class IndexController extends \Core\Controller
{
    /**
     * 博客首页
     */
    public function indexAction()
    {
        $articleModel = new \Model\ArticleModel();
        $recordcount =$articleModel->getArticalCount($condition=array());

//        var_dump($recordcount);
//        die;
        $page = new \Libs\PageLibs($recordcount,$GLOBALS['configs']['app']['pagesize']);
        $listdata=$articleModel->getArticleByCondition($condition=array(),$page->startno,$page->pagesize);
//        echo '<pre>';
//        var_dump($listdata);
//        die;
        $pageStr=$page->show($condition=array());

        $this->smarty->assign('listdata',$listdata);
        $this->smarty->assign('pageStr',$pageStr);


        $categoryModel = new \Model\CategoryModel();
        $categorylist  = $categoryModel->getAll();
        $categorylist  = $categoryModel->getTree($categorylist);
//        echo '<pre>';
//        var_dump($categorylist);
//        die;
        $this->smarty->assign('categorylist',$categorylist);


        $this->smarty->display('index.html');
    }
}