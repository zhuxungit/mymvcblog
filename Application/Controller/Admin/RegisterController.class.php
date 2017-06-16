<?php
namespace Controller\Admin;
use Model\UserModel;

/**
 * 注册控制器
 * @package Controller\Admin
 */
class RegisterController extends \Controller\Admin\BaseController
{
    //注册页面跳转
    public function registerAction()
    {

        if (IS_POST) {
            //判断用户名是否存在
            $data['name']=$_POST['username'];
            $usermodel = new UserModel();
            if ($usermodel->isExistsByName($data['name'])) {
                $this->error('该用户名已经存在','index.php?p=admin&c=register&a=register');
            }

            $data['pwd']=md5($_POST['password']);
            $upload = new \Libs\UploadLibs($GLOBALS['configs']['app']['upload_path'],$GLOBALS['configs']['app']['upload_size'],$GLOBALS['configs']['app']['upload_type']);

            //注册用户信息
            if ($path = $upload->upload($_FILES['avatar'])) {
                $data['avatar'] = $path;
                if($usermodel->insert($data))
                {
                        $this->success('恭喜你，注册成功','index.php?p=admin&c=login&a=login');
                }else{
                        $this->error('很遗憾，注册失败','index.php?p=admin&c=register&a=register');
                }
            }else{
                $this->error($upload->getError(),'index.php?p=admin&c=register&a=register');
            }
        }
        $this->smarty->display('register.html');
    }

}
