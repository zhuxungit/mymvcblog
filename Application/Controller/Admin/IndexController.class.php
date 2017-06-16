<?php
namespace Controller\Admin;
use Model\UserModel;
/**
 * 后台首页
 * @package Controller\Admin
 */
class IndexController extends \Controller\Admin\BaseController
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
     * 加载后台首页
     */
    public function indexAction(){
        $this->smarty->display('index.html');
    }

    /**
     * 加载欢迎页
     */
    public function welcomeAction(){
        $this->smarty->display('welcome.html');
    }



}