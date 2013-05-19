<?php
/**
 * 这是生成验证码的类
 * 另外，这个类单元测试在ImageMS.test.php
 * @author ipqhjjybj
 * @version 1.0
 */


class Captcha{
	/**
	 * 此为默认保存缩略图文件路径 
	 * @var string
	 */
    private $dirSave = 'captcha/';
    /**
     * 此为默认保存图片的名字
     * @var string
     */
    private $filename;
    /**
     * 对要操作图片的地址
     * @var string
     */
    private $url;
	/**
	 * 所用字体的位置
	 * @var string
	 */
    private $font = "c:/WINDOWS/Fonts/simsun.ttc";
    /**
     * 所存的答案
     * @var string
     */
    private $captcha;
    /**
     * 执行的操作
     * @var int
     */
    
    public $dealMode;
    /**
     * 
     * @param int $sm 将执行的操作模式
     */
    function __construct($sm=WDealMode::MODE_NONE){
    	$this -> showMode=new WDealMode($sm);
    }
    /**
     * 
     * @param string $string   生成验证码的内部东西
     * @param (int,etc) $sm    模式
     * @return string		   生成的名字	
     */
    public function createCaptcha($code = "",$sm=WDealMode::MODE_NONE,$num = 4, $angle = 5,$size = 20, $width = 0, $height = 0){
    	if($code == ""){
    		$str = "23456789abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVW";
    		for ($i = 0; $i < $num; $i++) {
    			$code .= $str[mt_rand(0, strlen($str)-1)];
    		}
    		$this->captcha = $code;
    	}else{
    		($num == 4) && $num = strlen($code);
    		$this -> captcha = $code;
    	}
    	//画布大小
    	!$width && $width = $num * $size * 4 / 5 + 5;
    	!$height && $height = $size + 10;
    	// 画图像
    	$im = imagecreatetruecolor($width, $height);
    	// 定义要用到的颜色
    	$back_color = imagecolorallocate($im, 235, 236, 237); 
    	$boer_color = imagecolorallocate($im, 118, 151, 199);
    	$text_color = imagecolorallocate($im, mt_rand(0, 200), mt_rand(0, 120), mt_rand(0, 120));
    	// 画背景
    	imagefilledrectangle($im, 0, 0, $width, $height, $back_color);
    	// 画边框
    	imagerectangle($im, 0, 0, $width-1, $height-1, $boer_color);
    	// 画干扰线
    	for($i = 0;$i < 5;$i++) {
    		$font_color = imagecolorallocate($im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
    		imagearc($im, mt_rand(- $width, $width), mt_rand(- $height, $height), mt_rand(30, $width * 2), mt_rand(20, $height * 2), mt_rand(0, 360), mt_rand(0, 360), $font_color);
    	}
    	// 画干扰点
    	for($i = 0;$i < 50;$i++) {
    		$font_color = imagecolorallocate($im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
    		imagesetpixel($im, mt_rand(0, $width), mt_rand(0, $height), $font_color);
    	}
		//画验证码。。
    	imagefttext($im, $size , 0, 5, $size + 3, $text_color, $this -> font, $code);
    	//output image;
		
    	if(($sm & WDealMode::MODE_SAVE) == WDealMode::MODE_SAVE)  //判断是否保存
    	{
    		imagepng($im,$this->dirSave.$this->filename);
    		imagedestroy($im);
    	}else{
    		header("Cache-Control: max-age=1, s-maxage=1, no-cache, must-revalidate");
    		header("Content-type: image/png");
    		header('Pragma: no-cache');
    		imagepng($im);
    		imagedestroy($im); 
    		return $code;
    	}
    }
    /**
     * 返回所存储的验证码答案
     * @return string
     */
    public function getCaptchaValue(){
    	return $this -> captcha;
    }
    /**
     * 存下文件名
     * @param unknown_type $filename
     */
    public function setFileName($filename){
    	$this->filename = $this -> nameNewRand($filename);
    }
    /**
     * 通过现有名字生成一个不会重复的随机名字
     * @param string $fileName
     * @return string $newName
     */
    public function nameNewRand($fileName){
    	list($name,$suffix) = explode(".",$fileName,2);
    	$newName = $name.date("Ymdgi").rand(10,99).".".$suffix;
    	return $newName;
    }
    /**
     * 返回图片的绝对路径
     * @return string
     */
    public function getFileURL(){
    	return $this->dirSave.$this->filename;
    }
} 
?>