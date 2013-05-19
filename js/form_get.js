// JavaScript Document
var jishu = 0;
/*
var form = document.getElementById("register");
alert("form"+form);
$(document).ready(function()
{
	alert("3");
	$('#infomation_submit').click(function (){
     var params=$('input').serialize(); //序列化表单的值
	 if(check_all(form)){
		 alert("ajax_now");
		 $.ajax({
		   url:'register.php', //后台处理程序
		   type:'post',         //数据发送方式
		   dataType:'json',     //接受数据格式
		   data:params,         //要传递的数据
		   success:update_page  //回传函数(这里是函数名)
		 });
	 }
   });
});

function update_page(){
	
}*/
function check_all(){
	var p_word = document.getElementById("password1");
	var check_word = document.getElementById("passwordCheck1");
	var tel = document.getElementById("tel1");
	var school_number = document.getElementById("school_number1");
	var username = document.getElementById("username1");
	var captcha = document.getElementById("captcha_id1");
	if(school_number.innerHTML != "正确"){
		alert("学生号不符合规范");
		document.getElementById("school_number").focus();
		return false;	
	}
	if(username.innerHTML != "正确"){
		alert("用户名不符合要求");
		document.getElementById("username").focus();
		return false;	
	}
	if(p_word.innerHTML != "正确"){
		alert("密码不符合要求");
		document.getElementById("password").focus();
		return false;
	}
	if(check_word.innerHTML != "正确"){
		alert("两次密码不一致");
		document.getElementById("passwordCheck").focus();
		return false;	
	}
	if(tel.innerHTML != "正确"){
		alert("tel不符合规范");
		document.getElementById("tel").focus();
		return false;	
	}
	if(captcha.innerHTML != "正确"){
		alert("验证码错误");
		document.getElementById("captcha_id").focus();
		return false;
	}
	return true;
}
function news_check(){
	var title = document.getElementById("title");
	editor.sync();	//相当重要的一步。将数据同步
	var editor = document.getElementById('editor_id');
	var news_summary = document.getElementById("news_summary");
	var news_time = document.getElementById("news_time");
	if(title.value=="")
	{
		alert("标题不能内空");
		title.focus();
		return false;	
	}
	if(editor.value==""){
		alert("内容不能内空");
		editor.focus();
		return false;	
	}
	if(news_summary.value == ""){
		alert("概括不能内空");
		news_summary.focus();
		return false;		
	}
	if(news_time.value == ""){
		alert("发生时间不能为空");
		news_time.focus();
		return false;	
	}
	return true;
}
function check_users_updates(){
	var p_word = document.getElementById("p_word");
	var c_p_word = document.getElementById("passwordCheck");
	if(p_word.value.length < 6 )
	{
		alert("password is too short!");
		return false;	
	}	
	if(p_word.value.length>20){
		alert("password is too long!");
		return false;	
	}
	if(p_word.value != c_p_word.value){
		alert(p_word.value);
		alert(c_p_word.value);
		alert("password is not the same!");
		return false;	
	}
	return true;
}