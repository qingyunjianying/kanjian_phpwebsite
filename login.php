<?php
require './common/init.php';


$action=input('get','action','s');
//unset()方法删除单个Session:变量。
if($action=='logout'){
	unset($_SESSION['fun']['user']);
	redirect('./');
}
if(IS_POST){
	$name = input('post','name','s');
	$password = input('post','password','s');
	
	if(!input_check('user_name',$name,$error)){
		exit("登陆失败，用户名格式有误，要求：$error");
	}
	if(!input_check('user_password',$password,$error)){
		exit("登陆失败，密码格式有误，要求：$error");
	}
	if(!captcha_check(input('post','captcha','s'))){
   	display('登录失败，验证码输入有误。', $name);
   }
   if (!login_form($name,$password,$error)){
		display("登录失败,$error");
	}
}
function display($tips = null, $name ='')
{
	require'./view/login.html';
	exit;
}

display();
function login_success($id, $name, $group)
{
	$_SESSION['fun']['user']=['id' => $id, 'name'=>$name, 'group'=> $group];
	redirect('index.php');
}
function login_form($name, $password, $error ='')
{
	$data = Db::getInstance()->find('__USER__','id,group,name,password,salt','s',['name' => $name]);
	if($data && (password($password, $data['salt'])== $data['password'])){
		login_success($data['id'], $data['name'], $data['group']);
	}
	$error = '用户名或密码错误';
}
?>