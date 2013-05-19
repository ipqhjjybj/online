// JavaScript Document
// 
//up_input 指上传的input的名字,up_aft_dis表示上传结束后呈现结果的div结点
function upfile_js(up_input,up_aft_dis){
	var file = document.getElementById(up_input);
	var url = "function/upload_pictue.php";
	if(file.value.length < 1){
		alert("upload_text cannot be empty!");
		return false;	
	}
	return ajax_upload(up_input,up_aft_dis,url);
}
function ajax_upload(up_input_id,up_aft_dis,url){

	$.post(
      url,  //地址
      {
		up_input:up_input_id,
		tmp_name:"tmp_name",
      },
      function (data) //回传函数
      {
		 $("#"+up_aft_dis).empty().html(data);
		 return true;
		var myjson='';
        eval('myjson=' + data + ';');
		if(myjson.answer){
			$("#"+up_aft_dis).empty().html("ssss");
			return true;	//表示已经存在了
		}else{
			return false;	//表示此数据还不存在	
		}
      }
    );		
}