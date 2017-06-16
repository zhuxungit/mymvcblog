<?php
namespace Core;

// 定义系统常量
define("DS", DIRECTORY_SEPARATOR);                      //目录分隔符（Linux兼容处理）
define("ROOT_PATH", getcwd());                          //定义项目根目录
define("APP_PATH", ROOT_PATH . DS . 'Application');     //定义应用目录
define("CONFIGS_PATH", ROOT_PATH . DS . 'Config' . DS);       //定义配置文件目录
define("FRAMEWORK_PATH", ROOT_PATH . DS . 'Framework' . DS);  //定义框架目录
define("CORE_PATH", FRAMEWORK_PATH . DS . 'Core');            //定义框架核心文件目录
define("LIB_PATH", FRAMEWORK_PATH . DS . 'Libs' . DS);        //定义扩展类库目录

define("CONTROLLER_PATH", APP_PATH . DS . 'Controller' . DS);  //定义控制器目录
define("MODEL_PATH", APP_PATH . DS . 'Model' . DS);            //定义模型目录
define("VIEW_PATH", APP_PATH . DS . 'View' . DS);              //定义视图目录


//定义当前请求的系统常量
define('REQUEST_METHOD', $_SERVER['REQUEST_METHOD']);
define('IS_GET', REQUEST_METHOD == 'GET' ? true : false);
define('IS_POST', REQUEST_METHOD == 'POST' ? true : false);
/**
 * 封装框架核心代码（初始化框架）
 */
class Framework
{
    /**
     * 框架运行入口
     */
    public static function run()
    {
        self::initConfig(); //加载配置文件
        self::initRoute();  //路由初始化
        self::initSmarty(); //初始化Smarty模板引擎
        self::initXSS(); //初始化xss过滤器
        self::autoload(); //自动加载类
        self::dispatch(); //路由调度
        
    }

    /**
     * 初始化模板引擎
     */
    public static function initSmarty()
    {
        require LIB_PATH . 'Smarty' . DS . 'Smarty.class.php';
    }

    /**
     * 初始化xss过滤器
     */
    public static function initXSS()
    {
        require LIB_PATH . 'HTMLPurifier' . DS . 'HTMLPurifier.includes.php';
    }

    /**
     * 加载配置文件
     */
    public static function initConfig()
    {
        $GLOBALS['configs'] = require CONFIGS_PATH.'Config.php';
    }

    /**
     * 路由初始化
     */
    public static function initRoute()
    {
        //定义平台名称
        $platform = isset($_GET['p']) ? ucfirst(strtolower($_GET['p'])) : $GLOBALS['configs']['app']['default_platform'];
        define("PLATFORM_NAME", $platform);
            //定义当前控制器名
        $controllerName = isset($_GET['c']) ? ucfirst(strtolower($_GET['c'])) : $GLOBALS['configs']['app']['default_controller'];
        define("CONTROLLER_NAME", $controllerName);
        //定义当前方法名
        $actionName = isset($_GET['a']) ? strtolower($_GET['a']) : $GLOBALS['configs']['app']['default_action'];
        define("ACTION_NAME", $actionName);
    }

    /**
     * 调度路由
     */
    public static function dispatch()
    {
        //1.使用命名空间方式实例化类，语法：\空间名称\类名（）
        $controllerName = '\Controller\\'.PLATFORM_NAME.'\\'.CONTROLLER_NAME.'Controller';
        $controllerObj = new $controllerName;
        $actionName = ACTION_NAME.'Action';
        $controllerObj->$actionName();
        
       
        
    }

    /**
     * 激活自动加载
     */
    public static function autoload()
    {

        //将函数注册到SPL __autoload函数栈中。如果该栈中的函数尚未激活，则激活它们。
        spl_autoload_register('self::autoloadClass');
    }

    /**
     * 加载类
     * @param $className 类名
     */
    public static function autoloadClass($className)
    {
// echo $className;echo '</br>';
		$className=str_replace('\\','/',$className);
        $type = dirname($className);
        $className = basename($className);
//         echo $className;echo '</br>';
        
        if ($type == 'Model') {
            //引入模型目录下的文件
            //require "./Application/Model/$className.class.php";
        	
            require MODEL_PATH . "$className.class.php";
        } elseif ($type == 'Core' || $type == 'Libs') {
            //引入核心目录下的文件
            //require "./Framework/$type/$className.class.php";
            require FRAMEWORK_PATH . $type . DS . "$className.class.php";
        } else {
            //引入控制器目录下的文件
            //$platform = isset($_GET['p']) ? ucfirst(strtolower($_GET['p'])) : 'Admin';
            //require "./Application/Controller/$platform/".$className.'.class.php';
//             echo CONTROLLER_PATH . PLATFORM_NAME;echo '</br>';
//         	echo $className;echo '</br>';
//         	echo $className;echo '</br>';
//         	echo CONTROLLER_PATH . PLATFORM_NAME . DS . "$className.class.php";die;
        	
            require CONTROLLER_PATH . PLATFORM_NAME . DS . "$className.class.php";
        }
    }
}


