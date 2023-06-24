<?php
		//配置时区
date_default_timezone_set('Asia/Shanghai');
//开启session的HttpOnly
//httpOnly用来防止xss攻击
session_set_cookie_params(0,null,null,null,true);
require './common/function.php';
require './common/library/Db.php';
session_start();
//为项目创建session，统一保存到fun
//$_SESSION利用Session变量存储信息：
if(!isset($_SESSION['fun'])){
  $_SESSION=['fun'=>[]];
}
//当用表单提交数据之后，可以用$_POST或$_GET来取得相应的提交数据
define('IS_POST',($_POST||$_FILES));
define('IS_LOGIN',isset($_SESSION['fun']['user']));
IS_LOGIN && user(null,$_SESSION['fun']['user']);
define('IS_ADMIN',IS_LOGIN&&user('group')=='admin');
?>