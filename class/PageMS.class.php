<?php
/**
 *此类为一个引用类
 *配合SQL查询
 * @author ipqhjjybj
 * @version 1.0
 */

/**
 * 
 */
class PageMS {
    
    public $sql;//所使用的sql语句
    public $datanum;//查询所有的数据总记录数
    public $page_size;//每页显示记录的条数
	public $mysql; // mysqli类获得的数据库  ，可执行一系列操作
	public $result;  //执行操作后返回的结果集
	public $page_name;	//?后面所跟的名字  
	public $page_num;
    /**
     * Constructor: initialize plugin loader
     * 
     * @return void
     */
    public function __construct($sql,$page_size=2,$page_name="page_id="){
        // TODO Auto-generated Constructor
        $this -> mysql = new OnlineSqlNew();
        $this -> sql = $sql;
        $this -> page_size = $page_size;
        $this -> page_name = $page_name;
        $this -> result = $this -> mysql->sql_deal($sql);
        $this -> datanum = $this -> result -> num_rows;
        $this -> page_num = $this -> page_num();
    }
  	/**
  	 * 返回当前的页数
  	 * @return number
  	 */
    public function page_id(){
    	if($_SERVER['QUERY_STRING'] == ""){
    		return 1;		//第一页
    	}else if(substr_count($_SERVER['QUERY_STRING'],$this ->page_name)==0){
    		return 1;		//第一页
    	}else{
    		return intval(substr($_SERVER['QUERY_STRING'],8));
    	}
    }
    /**
     * 返回除$this ->page_name之外的$add部分
     * @return string
     */
    public function url(){         //page.php?page_id=3&ddd的&ddd部分  
    	if($_SERVER['QUERY_STRING'] == ""){
    		return "";
    	}else if(substr_count($_SERVER['QUERY_STRING'],$this ->page_name) == 0){
    		return "&".$_SERVER['QUERY_STRING'];
    	}else{
    		return str_replace($this ->page_name.$this->page_id(),"",$_SERVER['QUERY_STRING']);
    	}
    }
    /**
     * 返回页数的大小
     * @return number
     */
    public function page_num(){
    	if($this -> datanum == 0){
    		return 1;
    	}else{
    		return ceil($this->datanum/$this->page_size);
    	}
    }
    /**
     * 返回前面的条数
     * @return number
     */ 
    public function start(){
    	return ($this ->page_id()-1)*$this ->page_size;
    }
    /**
     * 产生一个新的SQL语句
     * @return string
     */
    public function sqlquery(){
    	return $this->sql." limit ".$this->start().",".$this->page_size;
    }
    /**
     * 返回文件的绝对路径
     * @return $_SERVER['PHP_SELF'];
     */
    private function php_self(){
    	return $_SERVER['PHP_SELF'];
    }
    /**
     * 制作上一页
     * @return string
     */
    private function pre_page(){
    	$page_id = $this -> page_id();
    	if($page_id == 1){//页数等于1
    		return $this -> link_decorate(1,"上一页");
    	}else{
    		return $this -> link_decorate($page_id-1,"上一页");
    		//return "<a href=".$this->php_self()."?".$this->page_name.($page_id-1).$this->url().">上一页</a> ";
    	}
    }
    /**
     * 展示最下面的页码
     * @return string
     */
    private function display_page(){
    	$display_page = "";
    	if($this -> page_num <= 10){	//页数少于10
    		for($i = 1;$i <= $this -> page_num;$i++){
    			$display_page .= $this -> link_decorate($i,$i);
    		}
    		return $display_page;
    	}else{
    		$page_id = $this->page_id();
    		if($page_id <= 6){
    			for($i = 1;$i <= 10;$i++){
    				$display_page .= $this -> link_decorate($i,$i);
    			}
    			return $display_page;
    		}
    		else if(($page_id > 6) && ($this->page_num-$page_id >= 4)){
    			for($i = $page_id-5;$i <= $page_id+4;$i++){
    				$display_page .= $this -> link_decorate($i,$i);
    			}
    			return $display_page;
    		}else if(($page_id > 6) && ($this->page_num-$page_id < 4)){
    			for ($i=$this->page_num-9;$i<=$this->page_num;$i++)
    				$display_page .= $this -> link_decorate($i,$i);
    			return $display_page;
    		}
    	}
    }
    /**
     * 返回下一页
     * @return string
     */
    private function next_page(){
    	$page_id = $this -> page_id();
    	if($page_id < $this -> page_num){
    		return $this -> link_decorate($page_id+1,"下一页");
    		//return "<a href=".$this->php_self().$this->page_name.($page_id+1).$this->url().">下一页</a> ";
    	}else{
    		return $this -> link_decorate($page_id+1,"下一页");
    		//return "<a href=".$this->php_self().$this->page_name.($page_id+1).$this->url().">下一页</a> ";
    	}
    }
    /**
     * 修饰超链接属性   序号部分
     * @param num $i
     * @return string
     */
    private function link_decorate($i,$string){
    	return "<a href=".$this->php_self()."?".$this->page_name.$i.$this->url().">".$string."</a> ";
    }
    /**
     * 返回一行的页面信息
     * @return string
     */
	public function set_page_info(){
		$page_info = "共".$this->datanum."条";
		$page_info .=$this -> link_decorate(1, "首页");
		$page_info .=$this -> pre_page();
		$page_info .=$this -> next_page();
		$page_info .=$this -> link_decorate($this->page_num,"尾页");
		$page_info .="第".$this->page_id().'/'.$this->page_num."页";
		return $page_info; 
	}
	
}
