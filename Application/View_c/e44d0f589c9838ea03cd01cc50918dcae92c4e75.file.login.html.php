<?php /* Smarty version Smarty-3.1-DEV, created on 2017-06-14 15:25:25
         compiled from "G:\workstudy\studyblog\Application\View\Home\Login\login.html" */ ?>
<?php /*%%SmartyHeaderCode:12631594155652628d3-48353290%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e44d0f589c9838ea03cd01cc50918dcae92c4e75' => 
    array (
      0 => 'G:\\workstudy\\studyblog\\Application\\View\\Home\\Login\\login.html',
      1 => 1497450555,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12631594155652628d3-48353290',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1-DEV',
  'unifunc' => 'content_594155652b9086_46604876',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_594155652b9086_46604876')) {function content_594155652b9086_46604876($_smarty_tpl) {?><!doctype html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="/studyblog/Public/home/style/module.css">
	<script src="/studyblog/Public/home/script/common.js" type="text/javascript"></script>
	<script src="/studyblog/Public/home/script/md5.js" type="text/javascript"></script>
	<title>www.myblog.com - 登录 - Powered by myblog</title>
</head>
<body>

    <!-- top bar -->
    <div id="top">
        <div class="center">
        <div class="menu-left">
        <ul>
         <li><a href="../">返回首页</a></li>
        </ul>
        </div>
        <div class="menu-right">
        <ul>
            <li></li>
        </ul>
        </div>
       </div>
    </div>

    <div class="bg">
        <div id="wrapper">
              <div class="logo"><a href="../" title="www.myblog.com"></a></div>
              <div class="login">
                    <form method="post" action="#"><!--如果action没有数据，代表提交给当前请求的URL脚本：admin.php-->
                        <dl>
                          <dt></dt>
                          <dd class="username"><label for="edtUserName">用户名:</label><input type="text" id="edtUserName" name="username" size="20" value="" tabindex="1" /></dd>
                          <dd class="password"><label for="edtPassWord">密码:</label><input type="password" id="edtPassWord" name="password" size="20" tabindex="2" /></dd>
                        </dl>
                        <dl>
                          <dt></dt>
                          <dd class="checkbox"><input type="checkbox" name="chkRemember" id="chkRemember"  tabindex="3" /><label for="chkRemember">保持登录</label></dd>
                          <dd class="submit"><input id="btnPost" name="btnPost" type="submit" value="登录" class="button" tabindex="4"/></dd>
                        </dl>
                    </form>
              </div>
        </div>
    </div>

    <script type="text/javascript">

        //$("#btnPost").click(function(){
        //
        //	var strUserName=$("#edtUserName").val();
        //	var strPassWord=$("#edtPassWord").val();
        //
        //	if((strUserName=="")||(strPassWord=="")){
        //		alert("用户名和密码不能为空");
        //		return false;
        //	}
        //
        //	$("#edtUserName").remove();
        //	$("#edtPassWord").remove();
        //	//alert(MD5(strPassWord));
        //	strUserName=strUserName;
        //	strPassWord=MD5(strPassWord);
        //
        //	$("form").attr("action","index.php");
        //	$("#username").val(strUserName);
        //	$("#password").val(strPassWord);
        //
        //});
        //
        //$(document).ready(function(){
        //	if (!$.support.leadingWhitespace) {
        //		alert("骚年,你还在用IE6,7,8内核的浏览器么?请升级至支持html5的IE9吧!\r\n要不咱换个Chrome,Firefox试试(—.—||||");
        //	}
        //});

    </script>
</body>
</html>
<!--82.403ms--><?php }} ?>
