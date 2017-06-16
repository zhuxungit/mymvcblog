<?php
namespace Controller\Admin;
use Model\CategoryModel;
/**
 * 后台首页
 * @package Controller\Admin
 */
class CategoryController extends \Controller\Admin\BaseController
{
    private $categorymodel;

    public function __construct()
    {
        parent::__construct();

        //实例化用户模型
        $categorymodel = new CategoryModel();
        $this->categorymodel =  $categorymodel;
    }

    /**
     * 更新分类
     */
    public function updateAction()
    {
        if (IS_POST) {
            $pid=(int)$_POST['pid'];
            $name=$_POST['name'];
            $sort=(int)$_POST['sort'];
            $id=(int)$_POST['id'];

            //判断1 父级不能选择自己
            if($id == $pid){
                $this->error('插入失败，父级不能选择自己','index.php?p=admin&c=category&a=update&id='.$id);
            }

            //判断2 父级不能选择自己的子级
            $listdata = $this->categorymodel->getAll();

            $son = $this->categorymodel->getTree($listdata,$id);
//            var_dump($son);
//            die;
            if($son){
                foreach ($son as $v) {
                    if ($v['id']==$pid ) {
                        $this->error('插入失败，父级不能选择自己的子级','index.php?p=admin&c=category&a=update&id='.$id);
                    }
                }
            }

            $rs = $this->categorymodel->update($id, $pid,$name,$sort);
            //判断状态并跳转
            if ($rs) {
                $this->success('修改成功', 'index.php?p=admin&c=category&a=categorylist', 1);
            } else {
                $this->error('修改失败', 'index.php?p=admin&c=category&a=update&id='.$id, 1);
            }

        }else{

            //将原始数据显示在页面
            $id=$_GET['id'];
            $rowdata = $this->categorymodel->getRow($id);
            $this->smarty->assign('rowdata',$rowdata);

            //显示树形分类
            $listdata = $this->categorymodel->getAll();
            $listdata = $this->categorymodel->getTree($listdata);
            $this->smarty->assign('listdata',$listdata);
            $this->smarty->display('update.html');

        }
    }

    /**
     * 显示分类列表
     */
    public function categorylistAction()
    {
        $listdata = $this->categorymodel->getAll();
        $listdata=$this->categorymodel->getTree($listdata);
        $this->smarty->assign('listdata',$listdata);

        $this->smarty->display('categorylist.html');
    }

    /**
     * 添加分类
     */
    public function addcategoryAction()
    {
        if (IS_POST) {
//            var_dump($_POST);
//            die();
            $pid=$_POST['id'];
            $name=$_POST['name'];
            $sort=$_POST['sort'];
            if ($this->categorymodel->insert($pid,$name,$sort)) {
                $this->success('插入成功','index.php?p=admin&c=category&a=categorylist');
            } else {
                $this->error('插入失败','index.php?p=admin&c=category&a=addcategory');
            }

        }else{
            $listdata = $this->categorymodel->getAll();

            $listdata=$this->categorymodel->getTree($listdata);

            $this->smarty->assign('listdata',$listdata);
            $this->smarty->display('addcategory.html');
        }

    }

    /**
     删除分类
     */
    public function deleteAction()
    {

        $id=$_GET['id'];

        if ($this->categorymodel->isSon($id)) {
            $this->error('删除失败,请先删除子级','index.php?p=admin&c=category&a=categorylist');
        }

        if ($this->categorymodel->delete($id)) {
            $this->success('删除成功','index.php?p=admin&c=category&a=categorylist');
        }else{
            $this->error('删除失败','index.php?p=admin&c=category&a=categorylist');
        }

    }

}