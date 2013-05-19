<?php
class WDealMode{
	const MODE_NONE = 0;
	const MODE_GRAB = 1;
	const MODE_RESIZE = 2;
	const MODE_SAVE = 4;
	const MODE_All = 7;
	/**
	 * 保存的mode类型
	 * @var int
	 */
	private $mode;
	/**
	 * 用于执行此类的mode
	 * @param unknown_type $sm
	 * @return unknown
	 */
	function __construct($sm=self::MODE_NONE){
		$result = $this -> setMode($sm);
		return $result;	
	}
	/**
	 *  返回所用模式
	 */
	public function getMode(){
		return $this -> mode;
	}
	/**
	 * 设定所用的mode操作
	 * @param unknown_type $sm
	 */
	public function setMode($sm){
		if($sm){
			$this -> mode = $sm;
		}else{
			$this -> mode = self::getMode();
		}
	}
}
?>