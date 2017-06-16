<?php
namespace Core;

/**
 * 基础控制器
 */
class Controller
{
    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->initSmarty();//初始化smarty
        $this->initSession();//初始化session
        $this->initXSS();//初始化XSS过滤器
    }

    /**
     * 打开session
     */
    public function initSession()
    {
        session_start();
    }

    /**
     * 存放smarty实例
     * @var object
     */
    protected $smarty;

    /**
     * 初始化smarty
     */
    public function initSmarty()
    {
        $this->smarty = new \Smarty();
        $this->smarty->setTemplateDir(VIEW_PATH.PLATFORM_NAME.DS.CONTROLLER_NAME.DS);
        $this->smarty->setCompileDir(APP_PATH . DS . 'View_c');
    }

    /**
     * 存放smarty实例
     * @var object
     */
    protected $xssObj;

    /**
     * 初始化smarty
     */
    public function initXSS()
    {
        $this->xssObj = new \HTMLPurifier();
    }

    /**
     * 操作成功跳转方法
     * @param string  $into    提示信息
     * @param string  $url     跳转地址
     * @param int    $time    等待时间
     */
    public function success($info, $url, $time = 3)
    {
        $this->jump($info, $url, 'success', $time);
    }

    /**
     * 操作失败跳转方法
     * @param string  $into    提示信息
     * @param string  $url     跳转地址
     * @param int    $time    等待时间
     */
    public function error($info, $url, $time = 3)
    {
        $this->jump($info, $url, 'error', $time);
    }

    /**
     * 跳转方法
     * @param string $into    提示信息
     * @param string $url     跳转地址
     * @param string $state   操作状态
     * @param int    $time    等待时间
     */
    public function jump($into, $url = '', $state = '', $time = 3)
    {
        if (!$url) {
            //如果没有输入调转地址则默认调转首页
            header('location: index.php');
        }
//         echo <<<STR
// <!doctype html>
// <html>
// <head>
// <meta charset="utf-8">

// <title>提示页面</title>
// <style type="text.xml/css">
// #img{text.xml-align:center;margin-top:50px;margin-bottom:20px;}
// .info{text.xml-align:center;font-size:24px;font-family:'微软雅黑';font-weight:bold;}
// #success{color:#060;}
// #error{color:#F00;}
// </style>

// </head> 
// <body>
//     <div id="img"><img src="./Public/common/image/{$state}.png" width="160" height="200" /></div>
//     <div id='{$state}' class="info">{$into}，<span id='mes'>{$time}</span>秒以后跳转<a id='url'  href={$url}>点击立即跳转</a></div>
// <script type='text.xml/javascript'>
//     var i=document.getElementById('mes').innerHTML;
//     var id='';
//     window.onload=function(){id=setInterval(function(){i--;document.getElementById('mes').innerHTML=i;
//     if(i<=0){
//     	clearInterval(id);
//         location.href=document.getElementById('url').href;      
//     }},1000)}
// </script>
// </body>
// </html>
// STR;
//         exit;
        
        echo <<<STR
<!doctype html>
<html>
<head>
<meta charset="utf-8">
        
<title>提示页面</title>
<style >
#img{text.xml-align:center;margin-top:50px;margin-bottom:20px;}
.info{text.xml-align:center;font-size:24px;font-family:'微软雅黑';font-weight:bold;}
#success{color:#060;}
#error{color:#F00;}
</style>
        
</head>
<body>
    <div id="img"><img src="/studyblog/Public/common/image/{$state}.png" width="160" height="200" /></div>
    <div id='{$state}' class="info">{$into}，<span id='mes'>{$time}</span>秒以后跳转<a id='url'  href={$url}>点击立即跳转</a></div>
<script>
    var i=document.getElementById('mes').innerHTML;
    var id='';
    window.onload=function(){
    		id=setInterval(function(){
    		i--;
    		document.getElementById('mes').innerHTML=i;
    		if(i<=0){
    		clearInterval(id);
        	location.href=document.getElementById('url').href;
    }},1000)}
</script>
</body>
</html>
STR;
        exit;
    }
}