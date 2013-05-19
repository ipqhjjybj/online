// JavaScript Document

//请先包含jquery的那个
//这个函数是实现到session内查询 captcha = value这个值是否存在
//然后将  id = obj_id中的内容改掉 , context_fail是失败信息,context_success是成功信息
function ajax_get_captcha(value,url,obj_id,context_success,context_fail){
	$.post(
		url,
		{
			captcha:value
		},
		function (data){
			var myjson = '';
			eval("myjson="+data+";");

			if(myjson.answer){
				$("#"+obj_id).empty().html(context_success);
				return true;	
			}else{
				$("#"+obj_id).empty().html(context_fail);
				return false;
			}
		}	
	);
}
//这个函数是实现到数据库查询 table表内查询attribute = value这个值是否存在
//然后将  id = obj_id中的内容改掉
function ajax_search(table,attribute,value,url,obj_id,context){
	$.post(
      url,  //地址
      {
		table_name:table,
        attribute_name:attribute,
		value_name:value,
      },
      function (data) //回传函数
      {
		var myjson='';
        eval('myjson=' + data + ';');
		if(myjson.answer){
			$("#"+obj_id).empty().html(context);
			return true;	//表示已经存在了
		}else{
			return false;	//表示此数据还不存在	
		}
      }
    );		
}
function check_captcha(obj1,obj2_id,css_name_success,css_name_fail){
	var obj2 = document.getElementById(obj2_id);
	ajax_get_captcha(obj1.value,'function/captcha_get.php',obj2_id,"正确","验证码错误");
	if(obj2.innerHTML == "正确"){
		obj1.className = css_name_success;
		return true;
	}else{
		obj1.className = css_name_fail;
		return false;
	}
}
function check_username(username,obj_id,css_name_success,css_name_fail){
	
	var obj = document.getElementById(obj_id);
	if(username.value.length < 4){
		obj.innerHTML = "用户名位数少于4位";
		obj.className = css_name_fail;
		username.focus();
		return false;	
	}else if(username.value.length > 20){
		obj.innerHTML = "用户名位数大于20位";
		obj.className = css_name_fail;
		username.focus();
		return false;
	}
	else if(!is_legal(username.value)){
		obj.innerHTML = "包含非法字符";
		obj.className = css_name_fail;
		username.focus();
		return false;	
	}else{
		
		ajax_search("user","username",username.value,'function/sql_search.php',obj_id,"用户名已存在");
		if(obj.innerHTML != "用户名已存在"){
			obj.innerHTML = "正确";
			obj.className = css_name_success;
			return true;
		}
		else{
			obj.className = css_name_fail;
		}
	}
}

function check_password(password,obj_id,css_name_success,css_name_fail){
	var obj = document.getElementById(obj_id);
	if(password.value.length < 6){
		obj.innerHTML = "密码位数少于6位";
		obj.className = css_name_fail;
		password.focus();
		return false;	
	}else if(password.value.length > 20){
		obj.innerHTML = "密码位数大于20位";
		obj.className = css_name_fail;
		password.focus();
		return false;
	}
	else if(!is_legal(password.value)){
		obj.innerHTML = "密码包含非法字符";
		obj.className = css_name_fail;
		password.focus();
		return false;	
	}else{
		obj.innerHTML = "正确";
		obj.className = css_name_success;
		return true;
	}
}
function check_password_same(obj1,obj2_id,obj3_id,css_name_success,css_name_fail){
	var obj2 = document.getElementById(obj2_id);
	var obj3 = document.getElementById(obj3_id);
	if(is_same(obj1.value,obj2.value)){
			obj3.innerHTML = "正确";
			obj3.className = css_name_success;
			return true;
	}else{
			obj3.innerHTML = "密码不相同";
			obj3.className = css_name_fail;
			return false;	
	}
}

function check_school_number(obj1,obj2_id,css_name_success,css_name_fail){
	//还没有测试
	var reg = /^20(\d{6})$/;
	var obj2 = document.getElementById(obj2_id);
	if(!reg.test(obj1.value)|| obj1.value.length != 8){
		obj2.innerHTML = "未被授权";
		obj2.className = css_name_fail;	
		return false;	
	}else
	{
		ajax_search("user","school_number",obj1.value,'function/sql_search.php',obj2_id,"此学号已经存在");
		if( obj2.value != "此学号已经存在"){

			obj2.innerHTML = "正确";
			obj2.className = css_name_success;
			return true;
		}
		else{
			obj2.innerHTML = css_name_fail;
			return false;
		}
	}
}
function check_tel(obj1,obj2_id,css_name_success,css_name_fail){
	var obj2 = document.getElementById(obj2_id);
	if(is_tel(obj1.value)){
		obj2.innerHTML = "正确";
		obj2.className = css_name_success;
		return true;
	}else{
		obj2.innerHTML = "手机号码错误";
		obj2.className = css_name_fail;	
		return false;
	}	
}
function check_qq(qq){
	var reg = /^[0-9]{15}$/;
	if(!reg.test(password)){
		return false;	
	}else return true;
}
function check_real_name(name){
	return true;
}
function check_sex(sex){
	return true;	
}
function check_email(email){
	//还没有测试
	var reg = /^([a-zA-Z0-9_\.])+@([a-zA-Z0-9]+[\.]?)*[a-zA-Z0-9]+\.(?:com|cn)$/;
	if(!reg.test(email)){
		return false;	
	}else return true;
}
function check_birthday(birthday){
	//还没有测试
	var reg = /^(\d{4})-(\d{2})-(\d{2})$/;
	if(!reg.test(birthday)){
		return false;	
	}else return true;
	//还没有测试
}
function is_identitycard(id){	//身份证
	//还没有测试
	id = id.toUpperCase();
	var reg = /^(\d{15})|(\d{17}([0-9]|X|x))$/;
	if(!reg.test(id)){
		return false;	
	}else return true;
}
function isNumber(s){
	var regu = "^[0-9]+$";
	var re = new RegExp(regu);
	if(s.search(re) != -1) return true;
	else return false;	
}
//验证是否相同
function is_same(str1,str2){
	if(str1 == str2){
		return true;	
	}else return false;
}
//验证用户名是否合法
function is_legal(str){
	var reg = /^(\w){4,20}$/;	//检验有无包含不合法字符
	if(!reg.test(str)){
		return false;	
	}else return true;
}
//验证生日
function is_date(date,fmt){
	if(fmt == null)
		fmt = "yyyyMMdd";
	var yIndex = fmt.indexOf("yyyy");
	if(yIndex == -1)
		return false;
	var year = date.substring(yIndex,yIndex+4);
	var mIndex = fmt.indexOf("MM");
	if(mIndex == -1)
		return false;
	var month = date.substring(mIndex,mIndex+2);
	var dIndex = fmt.indexOf("dd");
	if(dIndex == -1)
		return false;
	var day = date.substring(dIndex,dIndex+2);
	if(!isNumber(year)||year > "2100" || year < "1900")
		return false;
	if(!isNumber(month)||month > "12"|| month < "01")
		return false;
	return true;
}

function is_num(NUM)     
{     
var i,j,strTemp;     
strTemp="0123456789";     
if ( NUM.length== 0)     
return false     
for (i=0;i<NUM.length;i++)     
{     
j=strTemp.indexOf(NUM.charAt(i));     
if (j==-1)     
{     
//说明有字符不是数字     
return false;     
}     
}     
//说明是数字     
return true;     
}     

//函数名：fucCheckTEL     
//功能介绍：检查是否为电话号码     
//参数说明：要检查的字符串     
//返回值：1为是合法，0为不合法     
function is_tel(TEL)     
{     
var i,j,strTemp;     
strTemp="0123456789-()# ";     
for (i=0;i<TEL.length;i++)     
{     
j=strTemp.indexOf(TEL.charAt(i));     
if (j==-1)     
{     
//说明有字符不合法     
return 0;     
}     
}     
//说明合法     
return 1;     
}    
//判断输入是否为中文的函数   
//---------------------------------------      
function is_chinese(s){   
var ret=true;   
for(var i=0;i<s.length;i++)   
ret=ret && (s.charCodeAt(i)>=10000);   
return ret;   
}    
//验证油箱格式
function is_email(strEmail) {
if (strEmail.search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/) != -1)
return true;
else
alert("oh");
}
  //英文值检测
function  is_English(name)
{  
if(name.length  ==  0)
return  false;
for(i  =  0;  i  <  name.length;  i++)  {  
if(name.charCodeAt(i)  >  128)
return  false;
}
return  true;
}
//控制位数
function is_smaller(m,n)  
{  
if ((m<n) && (m>0))  
  {  
  return(false);  
  }  
else  
{return(true);}  
}  
