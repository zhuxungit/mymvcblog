<?php
namespace Controller\Admin;

use Libs\Captcha;
use Model\UserModel;

/**
 * 后台登录控制器
 * @package Controller\Admin
 */
class LoginController extends\Controller\Admin\BaseController
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
     * 登录
     */
    public function loginAction(){

        if (IS_POST) {
            /*
             * 获取用户名密码
             */
            $username = $_POST['username'];
            $password = $_POST['password'];
            /**
             * 登录判断
             */
            if (!\Libs\Captcha::checkVerify($_POST['code'])) {
                $this->error('验证码错误','index.php?p=admin&c=login&a=login');
            }

            if( $userinfoold = $this->usermodel->getUserinfo($username,$password)){

                //生成登录令牌
                unset($userinfoold['password']);

                //调用session处理函数(包含数据更新)
                $this->sesssionAction($userinfoold);

                //登录成功记住登录信息
                if (isset($_POST['remember'])) {
                    $time = time()+60*60*60*24*7;//保存7天
                    setcookie('id',$userinfoold['id'],$time,'/');
//                    $key = md5(md5($userinfoold['id'].$username.$userinfoold['password'].$GLOBALS['configs']['app']['key']));
                    $key = md5(md5($userinfoold['id'].$username.$GLOBALS['configs']['app']['key']));
                    setcookie('key',$key,$time,'/');

                }

                $this->success('登陆成功','index.php?p=admin&c=index&a=index');
            }else{
                $this->error('登录失败','index.php?p=admin&c=login&a=login');
            }

        }else{

            $info=$this->usermodel->getUserByCookie();
            if (isset($info)) {

                $userinfoold = $this->usermodel->getexceptpwd($info['id'],$info['username']);
                //调用session处理函数
                $this->sesssionAction($userinfoold);
//
//                    //生成登录令牌
//                    unset($userinfoold['password']);

                $this->success('免登陆跳转','index.php?p=admin&c=index&a=index');
            }
            $this->smarty->display('login.html');
        }
    }

    /**
     * session数据处理
     */
    private function sesssionAction($userinfoold)
    {
        //登录信息更新数据
        $logincount=$userinfoold['login_count']+1;
        $lastlogintime=time();
        $lastloginip=ip2long($_SERVER['REMOTE_ADDR']);

        //更新后覆盖原数据
        $userinfo = $this->usermodel->update($logincount,$lastlogintime,$lastloginip,$userinfoold['username']);
        $userinfo['last_login_ip']=long2ip($userinfoold['last_login_ip']);
        $userinfo['last_login_time']=date('Y-m-d H:i:s',$userinfoold['last_login_time']);

        //后台主页面显示登录ip与上传附件最大值
        $userinfo['upload_size'] = number_format($GLOBALS['configs']['app']['upload_size']/1024/1024,2).'M';

        $_SESSION['userinfo'] = $userinfo;


//        var_dump($userinfo);
//        die;

    }

    //验证码以及验证码验证
    public function captchaAction()
    {
        $captcha = new \Libs\Captcha(102,35);
        $captcha->generalVerify();
    }


    //安全退出
    public function logoutAction()
    {
        setcookie('id',1,time()-1);
        session_destroy();
        $this->success('安全退出，请重新登录','index.php?p=admin&c=login&a=login');
    }

}