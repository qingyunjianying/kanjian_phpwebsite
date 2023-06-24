<?php
require'./common/init.php';
if (IS_POST){
	$name =input('post','name','s');
	$password= input('post','password','s');
	$email= input('post','email','s');
	if(!captcha_check(input('post','captcha','s'))){
		display('登录失败,验证码有误');
	}
	if(!input_check('user_name',$name,$error)){
	exit("注册失败，用户名格式有误，要求：$error");
	}
	if(!input_check('user_password',$password,$error)){
	exit("注册失败，密码格式有误，要求：$error");
	}
	if(!input_check('user_email',$email)){
	exit("注册失败，邮箱格式有误");
	}
	if(!register($name,$password,$email,$error)){
		display('注册失败，$error',$name,$email);
	}
	if (!login_form($name,$password,$error)){
		display("登录失败,$error");
	}
	
}

display();
function display($tips=null,$name='',$email=''){
	require'./view/register.html';
	exit;
}
function register($name,$password,$email,&$error=''){
//∥判断用户名是否已经存在
	$db =Db::getInstance();
	if ($db->value('__USER__','id','s',['name'=>$name])){
		$error='用户名已经存在。';
		return false;
	}
	$salt =substr(uniqid(),-6);
	$data =['group'=>'user','name'=>$name,'password'=>password($password,$salt),'salt'=>$salt,'email'=>$email,'time'=>time()];
	if (!$id =$db->insert('__USER__','sssssi',$data)){
		$error='数据库保存失败。';
		return false;
	}
		register_success($id,$name,'user');
}

//注册成功
function register_success($id,$name,$group){
	//∥记住登录状态
	$_SESSION['fun']['user'] = ['id'=>$id,'name'=>$name,'group'=>$group];
	//∥跳转言页
	redirect ('index.php');
}
	
?>