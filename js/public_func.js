// JavaScript Document
var username = document.getElementById("username");
var c_empty = function(){this.value = "";this.style.color="black";EventUtil.removeHandler(this,"click",c_empty);};

if(username != null)
	EventUtil.addHandler(username,"click",c_empty);


for(var i = 1;i <= 6;i++){
	$("#picture"+i).mouseover(function(){
		src = $(this).attr("src");
		var arr = src.split(".",2);
		var kk = $(this).attr("src",arr[0]+"1."+arr[1]);
	});	
	$("#picture"+i).mouseleave(function(){

		src = $(this).attr("src");
		var arr = src.split(".",2);
		$(this).attr("src",arr[0].substr(0,arr[0].length-1)+"."+arr[1]);
	});
}
function myrefresh() 
{ 
sleep(500); 
//window.location.reload(); 
parent.location.reload();  
} 

function sleep(numberMillis) {    
var now = new Date();    
var exitTime = now.getTime() + numberMillis;   
while (true) { 
now = new Date();       
if (now.getTime() > exitTime) 
return;    
} 
}