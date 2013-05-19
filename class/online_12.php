<?php
class OnlineSQL{
	private  $All_deal = "Online";               //用于md5加密时的数据
	private  $database = "Online";		//数据库名称
	private $host = "localhost";		//主机地址
	private $mysql_user = "root";		//数据库连接时的用户名
	private $mysql_password = "86458043";	//数据库连接时的密码

	protected $Debug = '1';               //是否调试
	protected $pre = "online_";			  //表的前缀

	public $DEFAULT_AUTHORITY = 1;      // 1 为默认权限
	public $MINISTER_AUTHORITY = 4;     // 部长权限；
	public $UNDERSECRETARY = 3;         // 副部长权限；
	public $SUPERSTAR_AUTHORITY = 9;    // 超级管理员权限
	public $db;               // 所创建的db mysqli 类
	

	public function jiami($password){   // 加密密码
			return md5($password.$this->All_deal);
	}
	protected function deleted($type,$id){
		$sql = "delete from ".$this->pre.$type." where id = '{$id}'";
		if($this -> Debug){
			echo "delete_in_".$type." 's sql : ".$sql."<br/>";	
		}
		$result = $this -> db > query($sql);	
		if($this -> Debug){
			echo "result : ".$result."<br/>";	
		}
		if($result){
			if($this -> Debug){
				echo "successily delete in ".$type."<br/>";	
				
			}
			return true;
		}else{
			return false;
		}
	}
	protected function update($table,$type,$to_date,$accor,$acc_val){
		$sql = "update ".$this->pre.$table." set {$type} = '{$to_date}' where {$accor} = {$acc_val}";
		if($this -> Debug){
			echo "update sql : ".$sql."<br/>";	
		}	
		$result = $this -> db -> query($sql);
		if($result > 0){
			return 	true;
		}else{
			echo "failed update in ".$table." to your ".$to_date."<br/>";
			exit;
		}
	}
	protected function select($table,$type,$to_date){
		$sql = "select * from ".$this->pre.$table." where {$type} = '{$to_date}'";
		if($this -> Debug){
			echo "select 's sql is : ".$sql."<br/>";	
		}	
		$result = $this -> db -> query($sql);
		if($result ){
			return $result;	
		}else{
			return false;	
		}
	}
	protected function select_like($table,$type,$to_date){
		$sql = "select * from ".$this->pre.$table." where {$type} like'%{$to_date}%' order by id desc";
		if($this -> Debug){
			echo "select 's sql is : ".$sql."<br/>";	
		}	
		$result = $this -> db -> query($sql);
		if($result){
			return $result;	
		}else{
			return false;	
		}
	}
	protected function insert($table,$type,$array_values){
		$val_now = 
		$sql = "insert into ".$this->pre.$table." values()";	
	}
	public function OnlineSQL(){
			
			$this -> db = new mysqli($this -> host,$this -> mysql_user
									 ,$this -> mysql_password,$this -> database);
			if(mysqli_connect_errno()){
				echo "Error: Could not connect to database.Please try again later.<br/>";
				exit;	
			}
			$this -> db -> query("Set names utf8");
			//$this -> db -> query("SET CHARACTER_SET_CLIENT=utf8");
			//$this -> db -> query("SET CHARACTER_SET_RESULTS=utf8");
			
	}
}
class User extends OnlineSQL{  //中文查找有点问题
	protected $school_number,$username,$password,$sex,$tel,$qq,$birthday,$realname,$department,$id;  // school_number 学号
	public function GetIP(){              //获得用户的IP
		if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) 
		$ip = getenv("HTTP_CLIENT_IP"); 
		else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) 
		$ip = getenv("HTTP_X_FORWARDED_FOR"); 
		else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) 
		$ip = getenv("REMOTE_ADDR"); 
		else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) 
		$ip = $_SERVER['REMOTE_ADDR']; 
		else 
		$ip = "unknown"; 
		return($ip); 
	} 
	public function getUserID(){
			$table = "user";
			$type = "username";
			$to_date = $this -> username;
			$result = $this -> select($table,$type,$to_date);
			if($result -> num_rows > 0){
				$row = $result -> fetch_object();
				return $row -> id; 
			}else{
				echo "there is no such userID ,its username is".$this -> username."<br/>";
				exit;	
			}
	}
	public function get_id(){
			return $this -> id;	
	}
	public function get_school_number(){
			return $this -> school_number;	
	}
	public function get_username(){
			return $this->username;
	}
	public function get_password(){
			return $this->password;	
	}
	public function get_sex(){
			return $this->sex;	
	}
	public function get_tel(){
			return $this->tel;	
	}
	public function get_qq(){
			return $this->qq;	
	}
	public function get_birthday(){
			return $this->birthday;	
	}
	public function get_realname(){
			return $this->realname;
	}
	public function get_department(){
			return $this->department;	
	}
	public function find_department_class_id($department){
			    //需要解决中文查找问题			
			
			$table = "department_class";
			$type = "department_name";
			$to_date = $department;
			$result = $this -> select($table,$type,$to_date);
			
			$result_nums = $result -> num_rows;
			if($result_nums  > 0){
				$row = $result -> fetch_object();
				return $row -> id;	
			}else{
				echo "there is no such department.<br/>";
				exit;	
			}
	}
	protected function call_from_sql_to_add_value($username){      //通过username联系数据库与类
		$sql = "select * from ".$this->pre."user where username = '{$username}'";
		$result = $this -> db -> query($sql);
		$result_nums = $result -> num_rows;
		if($result_nums > 0){
			$rows = $result -> fetch_object();
			$this -> id = $rows -> id;
			$this -> school_number = $rows -> school_number;
			$this -> username  = $rows -> username;
			$this -> password  = $rows -> password;
			$this -> sex = $rows -> sex;
			$this -> tel = $rows -> tel;
			$this -> qq = $rows -> qq;
			$this -> birthday = $rows -> birthday;
			$this -> realname = $rows -> realname;
			$this -> department = $rows -> department;
			return true;
		}else{
			echo "there is no such username to return object!<br/>";
			exit;	
		}	
	}
	public function User($username){
		$this -> OnlineSQL();
		$this -> call_from_sql_to_add_value($username);
		$this -> db -> close();	
	}
}
class User_Created extends User{
public function add_to_user(){
		$sql = "select * from ".$this->pre."user where username = '{$this -> username}'";
		$result = $this -> db -> query($sql);
		$num_results = $result -> num_rows;
		if($num_results > 0 ){
			echo "this user has been created,please try another!<br/>";
			exit;	
		}		
		$sql = "insert into ".$this->pre."user (id,school_number,username,password,sex,tel,qq,birthday,realname)"."values (null,'{$this->school_number}','{$this->username}','{$this->password}','{$this->sex}','{$this->tel}','{$this->qq}','{$this->birthday}','{$this->realname}')";
		$result = $this -> db -> query($sql);
		$num_results = $this -> db -> affected_rows;   //影响的行数
		if($num_results > 0){
			if($this -> Debug)
			{
				
				echo "add to user 's sql : ".$sql."<br/>";	
			}
			if($this -> Debug){
				echo "successily add to user<br/>";
			}
			return 0;
		}else{
			if($this -> Debug)
			{
				echo "add to user 's sql : ".$sql."<br/>";	
			}
			echo "failed to add to user<br/>";
			exit;	
		}
	}
public function add_to_department(){
		$date = date('Y-m-d');
		$id = $this -> getUserID();      // according to the username
		
		$class_id = $this -> find_department_class_id($this -> department); //according to the department's value
		$authority = $this -> DEFAULT_AUTHORITY;              // 默认等级
		
		$sql = "insert into ".$this->pre."department (id,department_class_id,authority,enter_time)"."values ('{$id}','{$class_id}','{$authority}','{$date}')";
		
		$result = $this -> db -> query($sql);
		$num_result = $this -> db -> affected_rows;

		if($this -> Debug){
			echo "department :<br/>";
			echo "sql :".$sql."<br/>";
			echo "num_result: ".$num_result."<br/>";
			echo "result: ".$result."<br/>";	
		}
		if($num_result > 0){
			if($this -> Debug){
				echo "successily add to department<br/>";
			}
			return 0;	
		}else{
			echo "failed to add to department<br/>";	
			exit;
		}
	}
public function add_to_user_stat(){
		$id = $this -> getUserID(); 
		$last_login_time = "just register!";
		$login_ip = $this -> GetIP();
		$login_count = 0;
		$summary = "a new person";
		$sql = "insert into ".$this->pre."user_stat (id,last_login_time,login_ip,login_count,summary)"."values('{$id}','{$last_login_time}','{$login_ip}','{$login_count}','{$summary}')";
		if($this -> Debug){
			echo "add_to_user_stat sql : ".$sql."<br/>";	
		}
		$result = $this -> db -> query($sql);
		$result_nums = $this -> db -> affected_rows;
		if($result_nums > 0){
			if($this -> Debug){
				echo "successily add to user_stat!<br/>";
			}
			return 0;	
		}else{
			echo "failed to add to user_stat!<br/>";
			exit;
		}
}
public function User_Created($school_number,$username,$password,$sex,$tel,$qq,$birthday,$realname,$department){
		$this -> OnlineSQL();
		$this -> school_number = $school_number;
		$this -> username = $username;
		$this -> password = $this -> jiami($password);
		$this -> sex = $sex;
		$this -> tel = $tel;
		$this -> qq = $qq;
		$this -> birthday = $birthday;
		$this -> realname = $realname;
		$this -> department = $department;
		$this -> add_to_user();
		$this -> add_to_department();
		$this -> add_to_user_stat();
		$this -> db -> close();
	}
}
class User_Deleted extends User{
	private function deleted_in_user_stat($id){
		$type = "user_stat";
		return $this -> deleted($type,$id);	
	}
	private function deleted_in_department($id){
		$type = "department";
		return $this -> deleted($type,$id);	
	}
	private function deleted_in_user($id){
		$type = "user";
		return $this -> deleted($type,$id);	
	}
	public function User_Deleted($username){
		$this -> OnlineSQL();
		$this -> username = $username;
		$id = $this -> getUserID();
		$re_user = $this -> deleted_in_user($id);
		$re_department = $this -> deleted_in_department($id);
		$re_user_stat = $this -> deleted_in_user_stat($id);
		$this -> db -> close();
		return;	
	}
}
class User_Information_Edit extends User{
	protected function change($type,$to_date){
		$sql = "update ".$this->pre."user set {$type} = '{$to_date}' where id = {$this -> id}";
		if($this -> Debug){
			echo " {$type} 's sql : ".$sql."<br/>";
		}
		$result_nums = $this-> db ->query($sql);
		if($this -> Debug){
			echo "result: ".$result."<br/>";
			echo "result_nums :".$result_nums."<br/>";	
		}
		if($result_nums > 0){
			if($this -> Debug){
				echo "your ".$type." is successily updated to ".$to_date."<br/>";
			}
			return $to_date;
		}else{
			echo "there is no such.".$type."<br/>";	
		}
	}
	public function school_number_update($school_number){
		$type = "school_number";
		$this -> school_number = $this -> change($type,$school_number);
		return $this -> school_number;
	}
	public function password_update($new_password,$old_password){
		$type = "password";
		$old_password = $this->jiami($old_password);
		$new_password = $this->jiami($new_password);
		
		$sql = "select * from ".$this->pre."user where password = '{$old_password}'";
		
		if($this -> Debug){
			echo "password sql : ".$sql."<br/>";
		}
		$result = $this -> db -> query($sql);
		$result_nums = $result -> num_rows;
		if($result_nums > 0){
			$this -> password = $this -> change($type,$new_password);
			return $this -> password;
		}else{
			echo "your old_password wrong!<br\>";
			exit;	
		}
	}
	public function sex_update($sex){
		$type = "sex";
		$this -> sex = $this -> change($type,$sex);
		return $this ->sex;
	}
	public function qq_update($qq){
		$type = "qq";
		$this -> qq= $this -> change($type,$qq);
		return $this -> qq;
	}
	public function tel_update($tel){
		$type = "tel";
		$this ->tel = $this -> change($type,$tel);
		return $this -> tel;	
	}
	public function realname_update($realname){
		$type = "realname";
		$this -> realname = $this -> change($type,$realname);
		return $this -> realname;	
	}
	public function birthday_update($birthday){
		$type = "birthday";
		$this -> birthday = $this -> change($type,$birthday);
		return $this -> birthday;
	}
	public function department_update($department){
		$type = "department";
		$department_id = $this -> find_department_class_id($department);
		$id = $this -> get_id();
		$sql = "update ".$this->pre."department set department_class_id = '{$department_id}' where id = '{$id}'";
		if($this ->Debug){
			echo "department sql: ".$sql."<br/>";	
		}
		$result_nums = $this -> db -> query($sql);
		if($result_nums > 0){
			if($this -> Debug){
				echo "successily update the department 's infomation!<br/>";
			}
			$this -> department = $department;
			return $this -> department;	
		}else{
			echo "falied to update the department 's infomation!<br/>";
		}
	}	
	public function User_Information_Edit($username){
		$this -> OnlineSQL();
		$this -> call_from_sql_to_add_value($username);
 
	}
	
}

class User_Stat extends User{
		private $lgoin_ip,$last_login_time,$login_count,$summary;
		public function get_login_ip(){
			return $this -> login_ip;	
		}
		public function get_login_time(){
			return $this -> last_login_time;	
		}
		public function get_login_count(){
			return $this -> login_count;	
		}
		public function get_summary(){
			return $this -> summary;	
		}
		private function stat_up_func($type,$value){
			$sql = "update ".$this->pre."user_stat set {$type} = '{$value}' where id = '{$this -> id}'";
			if($this -> Debug){
				echo "stat_up_func sql : ".$sql."<br/>";	
			}
			$result_nums = $this -> db -> query($sql);;
			if($this -> Debug){
				echo "result_nums is :".$result_nums."<br/>";	
			}
			if($result_nums > 0){
				if($this -> Debug){ 
					echo "sucessily update $type 's value is".$value."<br/>";
				}
				return true;
			}else{
				echo "failed to update $type 's value<br/>";
				exit;
			}
		}
		public function summary_update($summary){
			$value = $summary;
			$type = "summary";
			$this -> summary = $this -> stat_up_func($type,$value);
			return $this -> summary;
		}
		private function login_count_update(){
			$value = $this -> login_count + 1;
			$type = "login_count";
			$this -> login_count = $this -> stat_up_func($type,$value);
			return $this -> login_count;
		}
		private function login_ip_update(){
			$value = $this -> GetIP();
			$type = "login_ip";
			$this -> login_ip = $this -> stat_up_func($type,$value);
			return $this -> login_ip;	
		}
		private function login_time_update(){
			$value = date('Y-m-d');
			$type = "last_login_time";
			$this -> last_login_time = $this -> stat_up_func($type,$value);
			return $this -> last_login_time;	
		}
		private function update_stat(){
			$this -> login_time_update();
			$this -> login_ip_update();
			$this -> login_count_update();
			return true;		
		}
		protected function call_from_sql_to_get_stat($username){
			$this -> username = $username;
			$id = $this -> getUserID();
			$this -> id = $id;
			$sql = "select * from ".$this->pre."user_stat where id = '{$id}'";
			if($this -> Debug){
				echo "call_from_sql_to_get_stat 's sql :".$sql."<br/>";	
			}
			$result = $this -> db -> query($sql);
			$result_nums = $result -> num_rows;
			if($result_nums > 0){
				$row = $result -> fetch_object();
				$this -> id = $row -> id;
				$this -> last_login_time = $row -> last_login_time;
				$this -> login_ip = $row -> login_ip;
				$this -> login_count = $row -> login_count;
				$this -> summary = $row -> summary;
				return true;
			}else{
				echo "no such user in user_stat!<br/>";
				exit;	
			}
		}
		public function User_Stat($username){
			$this -> OnlineSQL();
			$this -> call_from_sql_to_get_stat($username);
			$this -> call_from_sql_to_add_value($username);
			return true;
		}
}
class Department_Class extends OnlineSQL{
		protected $id,$department_name,$set_time,$set_person_id,$principal_id,$summary;
		protected $dep_row;
		public function get_id(){
			return $this -> id;	
		}
		public function get_department_name(){
			return $this -> department_name;
		}
		public function get_set_time(){
			return $this -> set_time;	
		}
		public function get_set_person_name(){
			$row = $this -> get_inf($this -> set_person_id);
			return $row -> username;
		}
		public function get_principal_name(){
			$row = $this -> get_inf($this -> principal_id);
			return $row -> username;	
		}
		public function get_summary(){
			return $this -> summary;	
		}
		public function get_inf($id){
			$sql = "select * from ".$this->pre."user where id = '{$id}'";
			if($this -> Debug){
				echo "get_inf 's sql is : ".$sql."<br/>";	
			}
			$result = $this -> db -> query($sql);
			if($result -> num_rows > 0){
				return $result -> fetch_object();	
			}
			else{
				echo "there is no such person 's id,please check it! it's id is ".$id."<br/>";
				exit;		
			}
		}
		public function get_department_inf($department_name){
			$sql = "select * from ".$this->pre."department_class where department_name = '{$department_name}'";
			if($this -> Debug){
				echo "get_department_inf 's sql is : ".$sql."<br/>";	
			}	
			$result = $this -> db -> query($sql);
			if($result -> num_rows > 0){
				return $result -> fetch_object();	
			}else{
				echo "there is no such department name,its name is ".$department_name."<br/>";
				exit;	
			}
		}
		protected function add_to_class($department_name){
			$this -> dep_row = $this -> get_department_inf($department_name);
			$row = $this -> dep_row;
			$this -> id = $row -> id;
			$this -> department_name = $row -> department_name;
			$this -> set_time = $row -> set_time;
			$this -> set_person_id = $row -> set_person_id;
			$this -> principal_id = $row -> principal_id;
			$this -> summary = 	$row -> summary;
			return true;
		}
		public function Department_Class($department_name){
			$this -> OnlineSQL();	
			$this -> add_to_class($department_name);
			return true;		
		}	
}
class Department_Created extends Department_Class{
		private function check($username){
			$sql = "select * from ".$this->pre."user where username = '{$username}'";
			if($this -> Debug){
				echo "check 's sql is : ".$sql."<br/>";	
			}
			$result = $this -> db -> query($sql);
			if($result -> num_rows > 0){
				$row = $result -> fetch_object();
				return $row -> id;	
			}
			else{
				return false;		
			}	
		}
		public function Department_Created($dep_name,$dep_time,$dep_c_name,$dep_pri_name,$dep_summary){
			$this -> OnlineSQL();
			if(($dep_pri_id = $this -> check($dep_pri_name)) != true){
					echo "your principal's record is not in the datebase!<br/>";
					exit;
			}
			if(($dep_c_id = $this -> check($dep_c_name)) != true){
					echo "your creatre's record is not in the datebase!<br/>";
					exit;	
			}
			$sql = "insert into ".$this->pre."department_class (id,department_name,set_time,set_person_id,principal_id,summary)"
					."values (null,'{$dep_name}','{$dep_time}','{$dep_c_id}','{$dep_pri_id}','{$dep_summary}')";
			if($this -> Debug){
				echo "department_creat 's sql is :".$sql."<br/>";	
			}
			$result = $this -> db -> query($sql);
			if($this -> Debug ){
				echo "result 's value is ".$result."<br/>";	
			}
			if($result > 0){
				if($this -> Debug)
					echo "successily add to department_class!<br/>";
				return true;	
			}else{	
				echo "failed to add to department_class!<br/>";
				exit;	
			}
		}
}
class Department_Deleted extends Department_Class{
	private function dep_deleted($id){
		return $this -> deleted($type,$id);	
	}
	public function Department_Deleted($department){
		$this -> OnlineSQL();	
		$id = $this -> get_department_inf($department_name) -> id;
		$re_department = $this -> dep_deleted($id);
		$this -> db -> close();
	}		
}
class News extends OnlineSQL{
	protected $id,$news_class_id,$title,$content,$set_time,$set_person_id,$summary;
	public function get_id(){
		return $this -> id;
	}
	public function get_news_class_id(){
		return $this -> news_class_id;	
	}
	public function get_title(){
		return $this -> title;	
	}
	public function get_content(){
		return $this -> content;	
	}
	public function get_set_time(){
		return $this -> set_time;	
	}
	public function get_set_person_name(){
		$result = $this -> select("user","id",$this -> id);
		if($result -> num_rows > 0){
			$row = $result -> 	fetch_object();
			return $row -> username;
		}	
	}
	public function get_summary(){
		return $this -> summary;	
	}
	public function News($NewsName){
		$this -> OnlineSQL();
		return $this -> select_like("news","title",$NewsName);
	}
}
class News_Created extends News{
	public function News_Created($ceshi){
		if(is_array($ceshi)){
				
		}	
	}	
}

?>