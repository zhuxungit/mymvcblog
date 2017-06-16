<?php
namespace Controller\Home;

class LoginController extends \Core\Controller
{

    /**
     * 登录页面
     */
    public function loginAction()
    {
        if (IS_POST){
            $username = $_POST['username'];
            $password = $_POST['password'];

            $usermodel = new \Model\UserModel();
            $userinfo = $usermodel->getUserinfo($username, $password);

            if ($userinfo){
                unset($userinfo['password']);
                $_SESSION['userinfo'] = $userinfo;
                $this->success('欢迎登录','index.php?p=home&c=index&a=index',3);
            }else{
                $this->error('没有该用户信息，请先注册','index.php?p=admin&c=register&a=register',3);
            }
        }

        $this->smarty->display('login.html');
    }

    public function deleteAction()
    {
        session_destroy();
        $this->success('退出成功','index.php?p=home&c=login&a=login',3);
    }

}