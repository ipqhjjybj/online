<?php
/**
 *
 * @author ipqhjjybj
 * @version 1.0
 */
class OnlineSqlNew{
	private  $All_deal = "Online";      //用于md5加密时的数据
	private  $database = "Online";		//数据库名称
	private $host = "localhost";		//主机地址
	private $mysql_user = "root";		//数据库连接时的用户名
	private $mysql_password = "86458043";	//数据库连接时的密码

	protected $Debug = '1';               //是否调试
	protected $pre = "online_";			  //表的前缀
	const pre = "online_";				  //表的前缀
	
	public $DEFAULT_AUTHORITY = 1;      // 1 为默认权限
	public $MINISTER_AUTHORITY = 4;     // 部长权限；
	public $UNDERSECRETARY = 3;         // 副部长权限；
	public $SUPERSTAR_AUTHORITY = 9;    // 超级管理员权限
	public $db;               // 所创建的db mysqli 类

	public function jiami($password){   // 加密密码
			return md5($password.$this->All_deal);
	}
    /**
     * Constructor: initialize plugin loader
     * 初始化数据库
     * @return void
     */
    public function __construct(){
       $this -> db = new mysqli($this -> host,$this -> mysql_user
									 ,$this -> mysql_password,$this -> database);
		if(mysqli_connect_errno()){
			echo "Error: Could not connect to database.Please try again later.<br/>";
			exit;
		}
		$this -> db -> query("Set names utf8");
		$this -> db -> query("SET CHARACTER_SET_CLIENT=utf8");
		$this -> db -> query("SET CHARACTER_SET_RESULTS=utf8");
    }
    /**
     * 关闭数据库
     */
    public function sql_close(){
    	$this -> db -> close();
    }
    /**
     * 范围数据库名字
     * @return string
     */
    public function getDatabase(){
    	return $this -> database;
    }
    /**
     * 获得数据库中表的前缀
     * @return string
     */
    public function get_pre(){
    	return $this -> pre;
    }
    /**
     * 返回SQL处理后的结果
     * @param string $sql
     * @return mixed
     */
    public function sql_deal($sql){
    	$result = $this -> db -> query($sql);
    	return $result;
    }
    /**
     * 实现select语句
     * @param string $table  表名
     * @param string $type   where中判断的属性名
     * @param string $to_date where中判断的属性值
     * @param string or int $where 默认为0，即不设置，若不为0，则是用户所赋值
     * @return mixed|boolean
     */
    public  function select($table,$type=1,$to_date=1,$where=0){
    	!$where && $sql = "select * from ".$this->pre.$table." where {$type} = '{$to_date}'";
    	$where && $sql = "select * from ".$this->pre.$table." ".$where;
    	$result = $this -> db -> query($sql);
    	if($result ){
    		return $result;
    	}else{
    		return false;
    	}
    }
    /**
     * 
     * @param string $table  表名
     * @param string $type   set中判断的属性名
     * @param string $to_date set中判断的属性值
     * @param string $accor  where中的属性名
     * @param string $acc_val where中的值属性
     * @param string $where   where 语句 当不设置时默认为0
     * @return boolean
     */
	public function update($table,$type,$to_date,$accor,$acc_val,$where=0){
		!$where && $sql = "update ".$this->pre.$table." set {$type} = '{$to_date}' where {$accor} = {$acc_val}";
		$where && $sql = "update ".$this->pre.$table." set {$type} = '{$to_date}' ".$where;
		
		$result = $this -> db -> query($sql);
		if($result > 0){
			return 	true;
		}else{
			return false;
		}
	}
	/**
	 * 
	 * @param string $table  表明
	 * @param string $type
	 * @param string $to_data
	 * @return 
	 */
	public function deleted($table,$type,$to_data){
		$sql = "delete from ".$this->pre.$table." where {$type} = '{$to_data}'";
		if($this -> Debug){
			echo "delete_in_".$type." 's sql : ".$sql."<br/>";	
		}
		$result = $this -> db -> query($sql);	
		
		if($result){
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 插入函数
	 * @param string $table			表名
	 * @param array $array_values   array型数据，需自己保证正确
	 * @return boolean
	 */
	public function insert($table,$array_values){
		if(!is_array($array_values))
			return false;
		$value = "('".pos($array_values);
		$t = count($array_values);
		for($i = 0;$i < $t-1;$i++){
			$value .= "','".next($array_values);
		}
		$value .= "')";
		$sql = "insert into ".$this->pre.$table." values".$value;	
		if($this -> Debug){
			echo "insert_in_".$table." 's sql : ".$sql."<br/>";	
		}
		$result = $this -> db -> query($sql);
		if($result){
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 通过用户的Id，返回他的名字;
	 * @param num $id
	 * @return string
	 */
	public function get_user_name_by_id($id){
		$result = $this -> select("user","id",$id);
		if($row = $result->fetch_object()){
			return $row -> username;
		}
		else return "can't find such person";
	}
	/**
	 * 通过用户的username，返回他的id;
	 * @param num $id
	 * @return string
	 */
	public function get_id_by_user_name($username){
		$result = $this -> select("user","username",$username);
		if($row = $result->fetch_object()){
			return $row -> id;
		}
		else return "can't find such person";
	}
	/**
	 * 通过Id属性，获得其所属类别的某一信息
	 * @param num $id
	 * @param string $father_table  父亲表名
	 * @param string $elemen  键值的名字
	 * @return string
	 */
	public function get_it_father_name_from_id($id,$father_table,$element){
		$result = $this -> select($father_table,"id",$id);
		if($row = $result->fetch_object()){
			return $row -> $element;
		}
		else return "can't find such table";
	}
	/**
	 *  独有的通过username得到school_number
	 */
	public function getSchoolNumber($username){
		$result = $this -> select("user","username",$username);
		if(!$result->num_rows){
			echo "no such user!<br/>";
			return false;	
		}else{
			return $result->fetch_object()->school_number;	
		}
	}
}
function user_power_check(){
	if(!isset($_SESSION['username'])){
		echo "please <a href='index.php'>login</a> first!<br/>";
		exit();	
	}
	$username = $_SESSION['username'];
	$mysql = new OnlineSqlNew();
	$u_id = $mysql->get_id_by_user_name($username);
	$dep_result = $mysql -> select("department","id",$u_id);
	if($dep_result->num_rows)
		$power = $dep_result->fetch_object()->authority;
	else{
		echo "No such username in databases!<br/>";
		exit();	
	}
	if($power > 1){
		
	}else{
		echo "your power is not enough to enter here ! <br/>";
		exit();	
	}
}
?>