<?php
namespace Controller\Admin;
use Model\UserModel;
/**
 * 后台首页
 * @package Controller\Admin
 */
class UserController extends \Controller\Admin\BaseController
{
    private $usermodel;

    public function __construct()
    {
        parent::__construct();

        //实例化用户模型
        $usermodel = new UserModel();
        $this->usermodel =  $usermodel;
    }

    /**
     * 修改数据
     * @param $id
     *
     */
    public function updateuserAction()
    {
        $id = $_GET['id'];
        if(IS_POST) {
//array(3) { ["username"]=> string(6) "zxtest" ["password"]=> string(5) "admin" ["admin"]=> string(1) "0" }
//            var_dump($_POST);
//            die;
            $username = $_POST['username'];
            $password = $_POST['password'];
            $is_admin = $_POST['admin'];

            if($this->usermodel->isExistsByName($username)>=2){
                $this->error('更新失败，该用户名已经存在','index.php?p=admin&c=user&a=updateuser');
            }
            if(!empty($password)){
                if($this->usermodel->update_user($id, $username, $password,$is_admin)){
                    $this->success('更新成功','index.php?p=admin&c=user&a=userlist');
                }else{
                    $this->error('更新失败','index.php?p=admin&c=user&a=updateuser&id='.$id);
                }
            }else{
                $useeup= $this->usermodel->update_user_no_psw($id, $username,$is_admin);
//                var_dump($useeup);
//                die;
                if($useeup>=1){
                    $this->success('更新成功','index.php?p=admin&c=user&a=userlist');
                }elseif($useeup==0){
                    $this->error('没有变更','index.php?p=admin&c=user&a=userlist');
                }else{
                    $this->error('更新失败','index.php?p=admin&c=user&a=updateuser&id='.$id);
                }
            }

        }else{
            $userinfo = $this->usermodel->getRow($id);
            $this->smarty->assign('userinfo',$userinfo);
            $this->smarty->display('updateuser.html');
        }

    }

    /**
     * 用户列表显示
     */
    public function userlistAction()
    {

        //获取页数
        $pno = 1;
        if (!isset($_GET['pid'])){
            $pno = 1;
        }else{
            $pno=$_GET['pid'];
        }


        //每页显示数据条数
        $psize = 10;

        $pcount=$this->usermodel->getCountAll();
        $pcountpage = ceil($pcount[0]['num']/$psize);


        if($pno<1){
            $pno=1;
        }
        if($pno>$pcountpage){
            $pno=$pcountpage;
        }


        //起始数字
        $startpno = ($pno-1)*$psize;
        $listdata=$this->usermodel->getAll($startpno,$psize);

        $pinfo['pcount'] = $pcount[0]['num'];
        $pinfo['pcountpage'] = $pcountpage;
        $pinfo['pno'] = $pno;

        $this->smarty->assign('pinfo',$pinfo);



 //       $userlist=$this->usermodel->userlist();
        $this->smarty->assign('userlist',$listdata);
        $this->smarty->display('userlist.html');
    }
    /**
     * 添加用户
     */
    public function adduserAction()
    {
        if(IS_POST){
//            var_dump($_POST);
//            die;
            $username=$_POST['username'];
            $password=$_POST['password'];
            $is_admin = (int)$_POST['admin'];

            $result=$this->usermodel->add_user($username,$password,$is_admin);
            if ($result) {
                //用户列表显示
                $this->error('添加成功', 'index.php?p=admin&c=user&a=userlist');
            }else{
            	$this->error('添加失败', 'index.php?p=admin&c=user&a=adduser');
            }
        }else{
            $this->smarty->display('adduser.html');
        }
    }

    /**
     * 删除用户
     */
    public function deleteuserAction()
    {
        $id=$_GET['id'];
        if($this->usermodel->delete_user($id)){
            //用户列表显示
            $this->success('删除成功','index.php?p=admin&c=user&a=userlist');
        }else{
            //用户列表显示
            $this->error('删除失败','index.php?p=admin&c=user&a=userlist');
        }

    }


}
