<?php
namespace Controller\Admin;

class BaseController extends \Core\Controller
{

    public function __construct()
    {
        //不加下面的代码，该构造函数会重写父类中的构造函数
        parent::__construct();

        /**
         *判断是否翻墙
         */

        if (empty($_SESSION['userinfo']) && (CONTROLLER_NAME !== 'Login' && CONTROLLER_NAME !== 'Register' ))    {

            $this->error('请先登录再操作','index.php?p=admin&c=login&a=login');
        }
    }

}