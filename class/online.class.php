<?php
/*-------修改人：沈卓亨-------------
  -------2012年10月29日-------------
  -------修改次数:3  ---------------
 */
class OnlineSQL{
	private  $All_deal = "Online";               //用于md5加密时的数据
	private  $database = "Online";		//数据库名称
	private $host = "localhost";		//主机地址
	private $mysql_user = "root";		//数据库连接时的用户名
	private $mysql_password = "86458043";	//数据库连接时的密码
	public $error_message,$success_message;
	public $DEFAULT_AUTHORITY = 1;      // 1 为默认权限
	public $MINISTER_AUTHORITY = 4;     // 部长权限；
	public $UNDERSECRETARY = 3;         // 副部长权限；
	public $SUPERSTAR_AUTHORITY = 9;    // 超级管理员权限
	public function error_display()
	{
		echo $this -> error_message;
		//throw new Exception($error_message."123");
	}
	public function success_display()
	{
		echo $this -> success_message;	
		//throw new Exception($error_message."");
	}
	private function disconnect(){  //假如未连接成功,返回Ture,否则返回false
			return 1;              // 未找到函数实现
	}
	protected function connect(){          // 数据库连接
		if($this -> disconnect())     //如果没有连接	
		{
			//echo $this -> host."!!!!".$this -> mysql_user."!!!!".$this -> mysql_password."!!!!";
			$link = mysql_connect($this -> host,$this -> mysql_user,$this -> mysql_password) or die("link to localhost failed:".mysql_error);
			
			//echo ".";
			//echo "abc".$link."abc";
			$conn = mysql_select_db($this -> database,$link);
			//echo "efg.".$conn.".efg";
			if($conn)
			{
				$this -> success_message = "link database successily";
				$this -> success_display();
			}
			else{
				$this -> error_message =  "link database unsuccessily";	
				$this -> error_display();
			}

		}
		else{         // 如果数据库已经连接上了
			
		}
	}
	protected function connect_close(){              // 强行断开数据库连接
			
	}
	private function all_deal_updata($all_deal){
		$this -> All_deal = $all_deal;
	}
	private function user_power($userID){       // 返回用户权限
		$sql = "select * from online_department where id = '{$userID}'";
		$ooo = mysql_query($sql);
		if($ooo && mysql_affected_rows() > 0){
			 $one_user = mysql_fetch_array($ooo);
			 $this -> $success_message = "find the user_power";
			 $this -> success_display();
			 return $one_user[authority];
		}
		else{
			$this -> error_message =  "用户ID不存在!";	
			$this -> error_display();
		}
	}
	protected function OnlineSQL(){        // 数据库预先执行命令
		
		$this -> connect();
	}	
}
//分类系统
class Classfy extends OnlineSQL{   //分类的数目  超级管理员权限
	function classfy_add($class_name,$userID)   //分类添加 ,  需要类的名字与修改人的姓名
	{
		     if($this -> user_power($userID) >= $this -> $SUPERSTAR_AUTHORITY) // 如果用户权限足够
			 {
				 	
			 }
	}
	function classfy_delete()   //分类删除
	{
			 if($this -> user_power($userID) >= $this -> $SUPERSTAR_AUTHORITY) // 如果用户权限足够
			 {
				 
			 }
	}
	function classfy_edit()   //分类编辑
	{
			 if($this -> user_power($userID) >= $this -> $SUPERSTAR_AUTHORITY) // 如果用户权限足够
			 {
				 
			 }
	}	
	function Classfy()		//初始化
	{
		$this -> OnlineSQL();
	}
}
//部门系统
class Department extends OnlineSQL{
	function department_add(){      //部门添加      超级管理员
		
	}
	function department_delete(){    //部门删除     超级管理员

	}
	function department_edit(){      //部门编辑	超级管理员，部门负责人

	}

	function department_list(){	//实现分页

	}
	
	function Department(){		//初始化
		$this -> OnlineSQL();
	}
}
class Department_infomation extends OnlineSQL{ 		//具体部门基础信息
	protected $Department_id;                 //   部门ID....估计会增加信息
	function school_number_updata(){               //    代表其中的信息修改 

	}
	function tel_updata(){               //    代表其中的信息修改 

	}
	function many_things_updata(){               //    代表其中的信息修改 
		
	}
	function Department_infomation(){   //  此类初始化
		$this -> OnlineSQL();

	}
}
class DepartmentTechnology extends Department_infomation{
	
}// 还有其他的像设计部，办公室之类的。。。特殊化设计

class DepartmentDesigner extends Department_infomation{

}//   ---- 省略掉一部分。。
//新闻系统
class News extends OnlineSQL{
	function news_add(){        // 新闻的增加

	}
	function news_delete(){     // 新闻的删除
	
	}
	function news_edit(){       // 新闻的编辑
	
	}
	function news_display(){	//新闻展示，会增加分页功能

	}
	function News(){
		$this -> OnlineSQL();
	}
}
class News_infomation extends OnlineSQL{
	protected $News_id;                    //  新闻ID....应该会增加信息
}

//用户系统的设计
class User extends OnlineSQL{ /*     中文查找有问题！！！！*/
	private $school_number,$username,$password,$sex,$tel,$qq,$birthday,$realname,$department;  // school_number 学号
	private function find_department_class_id($department){    //查找部门分类ID
		//mysql_query("set  gb2312");
		$sql = "select * from online_department_class where class_name = '$department'";        //需要解决中文查找问题
		echo "look it ".$sql." !ss";
		echo "department = ".$department;
		$ooo = mysql_query($sql);
		echo "ooo = ".$ooo." in find_department_class_id";
		
 			$oneid = mysql_fetch_array($ooo);
			//print_r($one_data_id);
			
			//echo "oneid  ".$oneid."  ";
			//echo "oneid[id] = ".$oneid[id]."       !!!!!!!";
			return $oneid[id];
		
	}
	private function getUserID()   //用SQL 于 语句写
	{
		//echo "000".$this -> username;
		$sql = "select * from online_user where school_number = '{$this -> school_number}'";
		//echo "abc! ".$sql;
		$ooo = mysql_query($sql);
		//echo "this = ".$ooo."111";
		if($ooo && mysql_affected_rows() > 0){
			$kkk = mysql_fetch_array($ooo);
			echo "and kkk = ".$kkk[id]."!!!";
			return $kkk[id];
		}//判断用户名已经存在。
		else{
			$this -> error_message = "不能在用户列表中找到此账号";
			$this -> error_display();
		}
	}
	public function add_to_user(){		//插入用户基本表
		$sql = "select * from online_user where username = '{$this -> username}'";
		$ooo = mysql_query($sql);
		if($ooo && mysql_affected_rows() > 0){
			$this -> error_message = "此用户已经存在";
			$this -> error_display();
		}//判断用户名已经存在。
		else{
					$sql = "insert into online_user (id,school_number,username,password,sex,tel,qq,birthday)"."values (null,'{$this->school_number}','{$this->username}','{$this->password}','{$this->sex}','{$this->tel}','{$this->qq}','{$this->birthday}')";
					//echo "123.".$sql.".123";  
					$ooo = mysql_query($sql);
					
				if($ooo && mysql_affected_rows() > 0){
					$this -> success_message = "插入用户成功";
					$this -> success_display();
				}else{
					$this -> error_message = "插入用户失败";
					$this -> error_display();	
				}
					
		}
	}
	private function add_to_department(){		//插入用户基本表
			 	$date = date('y-m-j');
				//echo "look at it: ".$this -> username."accc";
				$id = $this -> getUserID();
				$class_id = $this -> find_department_class_id($this -> department);
				//echo "'this -> department'  ".$this -> department;
				$authority = $this -> DEFAULT_AUTHORITY;              // 默认等级
				$sql = "insert into online_department (id,department_class_id,authority,enter_time)"."values ('{$id}','{$class_id}','{$authority}','{$date}')";
				//echo "depar.".$sql.".depar";  
				$ooo = mysql_query($sql);
				//echo "1.".$ooo.".1";	
				if($ooo && mysql_affected_rows() > 0){
					$this -> success_message = "插入用户至部门成功";
					$this -> success_display();
				}else{
					$this -> error_message = "插入用户至部门失败";
					$this -> error_display();	
				}
	}
	public function User($school_number,$username,$password,$sex,$tel,$qq,$birthday,$realname,$department)
	{
		$this -> OnlineSQL();
		echo "1";
		$this -> school_number = $school_number;
		$this -> username = $username;
		$this -> password = $password;
		$this -> sex = $sex;
		$this -> tel = $tel;
		$this -> qq = $qq;
		$this -> birthday = $birthday;
		$this -> realname = $realname;
		$this -> department = $department;
		$this -> add_to_user();
		$this -> add_to_department();
		$this -> connect_close();        //强行断开连接数据库，不过还未定义
	}
}
class Update_User extends User{
		
		protected function change_password($change_password){
			$this -> password = $change_password;
			$id = $this -> getUserID(); 
			//以下为update函数实现用户密码的更新
			
		}
		protected function change_birthday($change_birthday){
			$this -> birthday = $change_birthday;
			//以下为update函数实现
		}
		protected function change_tel($change_tel){
			$this -> tel = $change_tel;
			//以下为update函数实现
		}
		
		protected function change_qq($change_qq){
			$this -> qq = $change_qq;
			//以下为update函数实现
		}
		
		protected function change_department($change_department){
			$this -> department = $change_department;
			//以下为update函数实现
		}
		
		public function Update_User($school_number){
			$this -> school_number = $school_number;
		}
}
class User_Stat extends User{           //用户状态
	private function User_Stat(){
		$this -> OnlineSQL();    //此句可能有错。。。。。没试过，打个标记
	}
}
//  一下类库不怎么合理，被上面的一个取代
class User_Information_Edit extends User{
	private function User_Information_Edit($user_id,$editr_id,$which_property,$to_what_value){ // 分别为被修改者ID，修改者ID，什么属性，改成多少
		$this -> OnlineSQL();           	
		if($this -> user_power($this -> userID) >= $this -> UNDERSECRETARY || $this -> user_id == $this -> editr_id) //如果修改者权限>=副部长，或者为本人
		{
			$sql = "select * from online_user where id = '{$this -> user_id}'";
			$ooo = mysql_query($sql);
			if($ooo && mysql_affected_rows() > 0){
				$sql = "update online_user set '{$this -> which_property}' = '{$this -> to_what_value}' where id = '{$this -> user_id}'";
				$ooo = mysql_query($sql);
				if($ooo && mysql_affected_rows() > 0){
					//
				}
			}
			else{
				$rhis -> error_message = "此用户不存在";
				$this -> error_display();
			}	
		}
		else{
				$this -> error_message = "你无权限修改";
				$this -> error_display();	
		}
	}	
}
//原先设计的数据库还有 活动系统跟文章系统。。。后来发现多余，可能以后会用到吧。就不删除了
?>