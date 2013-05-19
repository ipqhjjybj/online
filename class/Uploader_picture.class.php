<?php
/*
 [gmakj] (C)2001-2011 Gmakj Inc.
 $RCSfile: image_cls.php
 $Revision: 1.1 
 $Date: 2011/01/12 14:49:30
 $Edit_time: 2011/01/12 14:49:30
 $author: shun.long.guang...
 $description: 图片处理操作类（上传、缩略图、水印）
 
 包含的函数
 function __construct($bgcolor='') //设置图片背景颜色
 function cls_image($bgcolor='')  //设置图片背景颜色
 function upload_image($upload, $dir = '', $img_name = '') //图片上传的函数3个参数(图片信息数组、图片存放路径、图片名称)
 function make_thumb($img, $thumb_width = 0, $thumb_height = 0, $path = '', $bgcolor='')//创建图片的缩略图
 function add_watermark($filename, $target_file='', $watermark='', $watermark_place='', $watermark_alpha = 0.65)//为图片增加水印

 function validate_image($path) //检查水印图片是否合法
 function error_msg()	//返回错误信息
 function check_img_type($img_type) //此函数是检查图片的类型，参数一个，返回图片的类型

 function gmtime()	//返回标准的格林威志时间戳
 function random_filename()	//生成随机的数字串
 function unique_name($dir)	//生成指定目录不重名的文件名
 function get_filetype($path) //返回文件后缀名函数，有一个路径参数
 function move_file($upload, $target) //移动上传的图片到指定的路径函数（俩个参数一个是图片的信息数组，一个系目标路径）
 function check_file_type($filename, $realname = '', $limit_ext_types = '');	//检查文件类型
 function make_dir($folder) //检查目标文件夹是否存在，不存在则创建之
 function move_upload_file($file_name, $target_name = '') //将上传文件转移到指定位置
 function img_resource($img_file, $mime_type)  //返回图像的操作资源
 function gd_version() //获得服务器上的 GD 版本
 function check_img_function($img_type)  //检查图片处理能力
 function getImageName()   //返回保存文件的文件名
*/
/*
 $thumb = new cls_image();
 $thumb -> make_thumb("1.jpg","152","152","","#FFFFFF"); //缩略图
 $thumb -> add_watermark("source.jpg","target.jpg",1,0.6);//水印
 $thumb -> validate_image("source.jpg");
 $thumb -> upload_image("1.jpg");//上传图片
*/
 class cls_image
 {
  var $error_no    = 0; //错误报告等级 error_reporting(int[1,2,4,8,16,32..2047..])
  var $error_msg   = ''; //错误信息
  var $images_dir  = 'uploads'; //声明图片路径变量(exemple:/upload(ROOTPATH.$image_dir.201003))
  var $data_dir    = 'datedir'; //声明日期路径变量(exemple:/20101219(ROOTPATH.20101219.$dir))
  var $bgcolor     = ''; //初始化背景颜色
  var $img_name    = '';	//文件保存的文件名,初始为空
  var $dir = '';	//保存文件的目录
  var $type_maping = array(1 => 'image/gif', 2 => 'image/jpeg', 3 => 'image/png'); //用数组来存储图片类型
 
  function __construct($bgcolor='') //构造函数（参数为背景颜色）
  {
   $this->cls_image($bgcolor); //实例化类的时候执行构造函数，里面调用cls_image()函数
  }
 
  function cls_image($bgcolor='') //cls_image函数
  {
   if ($bgcolor)
   {
    $this->bgcolor = $bgcolor; //如果函数有参数，即背景颜色有设置，那么背景颜色就是传递过来的参数
   }
   else
   {
    $this->bgcolor = "#FFFFFF"; //如果没有参数传过来，那么默认的背景色为白色
   }
  }
  
  /**
   * 图片上传的处理函数
   *
   * @access      public
   * @param       array       upload       包含上传的图片文件信息的数组
   * @param       array       dir          文件要上传在$this->data_dir下的目录名。如果为空图片放在则在$this->images_dir下以当月命名的目录下（参数不为空则放在
   this->data_dir目录，否则放在images_dir目录下）
   * @param       array       img_name     上传图片名称，为空则随机生成
   * @return      mix         如果成功则返回文件名，否则返回false
   * @author      xiaoguang
   */
  function upload_image($upload, $dir = '', $img_name = '') //图片上传的函数3个参数(图片信息数组、图片存放路径、图片名称)
  {
   /* 没有指定目录默认为根目录images */
   if (empty($dir)) //如果参数$dir为空，则创建当月目录
   {
    /* 创建当月目录 */
    $dir = date('Ym');
    $dir = ROOT_PATH . $this->images_dir . '/' . $dir . '/';
   }
   else
   {
    /* 创建目录 */
    $dir = ROOT_PATH . $this->data_dir . '/' . $dir . '/';
    if ($img_name)
    {
     $img_name = $dir . $img_name; // 将图片定位到正确地址
    }
   }
 
   /* 如果目标目录不存在，则创建它 */
   if (!file_exists($dir)) //如果目标目录（即$dir）不存在，则尝试创建之，这里用到file_exists()函数判断目录是否存在，在用mkdir()创建目录
   {
    if (!$this->make_dir($dir))
    {
     /* 创建目录失败 */
     $this->error_msg = sprintf($GLOBALS['_LANG']['directory_readonly'], $dir); //格式化输出字符串sprintf('%s',123),不会直接输出（以%开始，以d,s,b,f。。。结束）将语言包$_LANG['directory_readonly']包含到全局数组中.....(以字符串的形式格式化输出错误信息)
     $this->error_no  = ERR_DIRECTORY_READONLY; //常量错误num赋值给error_no
     return false;
    }
   }
 
   if (empty($img_name)) //判断文件名是否为空，如果为空则执行以下俩个语句
   {
    $img_name = $this->unique_name($dir); //运用自身的unique_name（）方法生成一个独一无二的文件名
    $img_name = $dir . $img_name . $this->get_filetype($upload['name']); //返回文件的类型（后缀名）
   }
 
   if (!$this->check_img_type($upload['type'])) //判断上传文件的类型
   {
    $this->error_msg = $GLOBALS['_LANG']['invalid_upload_image_type']; //将语言包$_LANG['invalid_upload_image_type']包含到全局数组中.....(输出类型错误信息)
    $this->error_no  =  ERR_INVALID_IMAGE_TYPE; //常量错误num赋值给error_no
    return false;
   }
 
   /* 允许上传的文件类型 */
   $allow_file_types = '|GIF|JPG|JEPG|PNG|BMP|SWF|txt|doc|docx|ppt|xls|rar|zip'; //声明一个变量（上传的图片类型）
   if (!$this->check_file_type($upload['tmp_name'], $img_name, $allow_file_types)) //此类中不存这个函数
   {
    $this->error_msg = $GLOBALS['_LANG']['invalid_upload_image_type'];
    $this->error_no  =  ERR_INVALID_IMAGE_TYPE;
    return false;
   }
 
   if ($this->move_file($upload, $img_name)) //move_file()将图片上传到指定位置
   {
   	$this->img_name = $img_name;
    return str_replace(ROOT_PATH, '', $img_name); //将$img_name中的ROOT_PATH替换掉
   }
   else
   {
    $this->error_msg = sprintf($GLOBALS['_LANG']['upload_failure'], $upload['name']);
    $this->error_no  = ERR_UPLOAD_FAILURE;
    return false;
   }
  }
  
  /**
   * 创建图片的缩略图
   * GD库，是php处理图形的扩展库
   * @access  public
   * @param   string      $img    原始图片的路径
   * @param   int         $thumb_width  缩略图宽度
   * @param   int         $thumb_height 缩略图高度
   * @param   strint      $path         指定生成图片的目录名
   * @return  mix         如果成功返回缩略图的路径，失败则返回false
   * @author  xiaoguang
   */
  function make_thumb($img, $thumb_width = 100, $thumb_height = 100, $path = '', $bgcolor='')
  {
    $gd = $this->gd_version(); //获取 GD 版本。0 表示没有 GD 库，1 表示 GD 1.x，2 表示 GD 2.x
    //echo $img;
    if ($gd == 0)
    {
     $this->error_msg = $GLOBALS['_LANG']['missing_gd']; //报告错误信息，不存在GD库
     return false;
    }
 
   /* 检查缩略图宽度和高度是否合法 */
   if ($thumb_width == 0 && $thumb_height == 0) //缩略图的宽度、高度是否合法（前提高度、宽度不等于0）
   {
    return str_replace(ROOT_PATH, '', str_replace('\\', '/', realpath($img))); //运用realpath()函数返回原始图片的绝对路径，在用str_replace()函数将这个物理的绝对路径中ROOT_PATH部分去掉
   }
 
   /* 检查原始文件是否存在及获得原始文件的信息 */
   $org_info = @getimagesize($img); //运用getimagesize()函数取得图像大小,此函数返回的是图片信息的数组（$org_info[0]为width,$org_info[1]为高度，$org_info[2]为图片类型（其中1 = GIF，2 = JPG，3 = PNG，4 = SWF...），$org_info[3]为宽、高度的集合的字符串，$org_info[4]为图像的每种颜色的位数。。。）
   if (!$org_info) //若原文件不存在，则输出错误信息
   {
    $this->error_msg = sprintf($GLOBALS['_LANG']['missing_orgin_image'], $img);
    $this->error_no  = ERR_IMAGE_NOT_EXISTS;
    return false;
   }
 
   if (!$this->check_img_function($org_info[2])) //运用自定义函数check_img_function()检测图片的类型，若类型不是允许的，则输出错误信息
   {
    $this->error_msg = sprintf($GLOBALS['_LANG']['nonsupport_type'], $this->type_maping[$org_info[2]]);
    $this->error_no  =  ERR_NO_GD;
    return false;
   }
   
   //获取到一个图像操作的标识符然后赋值给$img_org
   $img_org = $this->img_resource($img, $org_info[2]);
 
   /* 原始图片以及缩略图的尺寸比例 */
   $scale_org      = $org_info[0] / $org_info[1]; //用原始图片宽度与高度比来得到缩略图的比例
   /* 处理只有缩略图宽和高有一个为0的情况，这时背景和缩略图一样大 */
   if ($thumb_width == 0)
   {
    $thumb_width = $thumb_height * $scale_org; //当缩略图的宽度为0的时候，此时的宽度等于缩略图的高度*比例值
   }
   if ($thumb_height == 0)
   {
    $thumb_height = $thumb_width / $scale_org; //当缩略图的高度为0的时候，此时的高度等于缩略图的宽度/比例值
   }
 
   /* 创建缩略图的标志符 */
   if ($gd == 2)
   {
    $img_thumb  = imagecreatetruecolor($thumb_width, $thumb_height); //运用imagecreatetruecolor（）新建一个真彩色图像,相当于ps新建一个空白图像
   }
   else
   {
    $img_thumb  = imagecreate($thumb_width, $thumb_height); //否则运用imagecreate（）函数创建一个基于调色板的图像
   }
 
   /* 背景颜色 */
   if (empty($bgcolor))
   {
    $bgcolor = $this->bgcolor; //若函数中传入背景颜色变量为空，则将背景颜色设置为类中bgcolor变量
   }
   $bgcolor = trim($bgcolor,"#");
   sscanf($bgcolor, "%2x%2x%2x", $red, $green, $blue); //运用sscanf()函数将$bgcolor 按某种格式输出，结果则是0-255，0-255，0-255三个int数字
   $clr = imagecolorallocate($img_thumb, $red, $green, $blue); //运用imagecolorallocate（）函数将缩略图填充上面获取到的R,G,B三种颜色组成的背景色,返回的是一个资源，相当于ps上将空白图像填充背景颜色
   imagefilledrectangle($img_thumb, 0, 0, $thumb_width, $thumb_height, $clr); //运用imagefilledrectangle函数（）在缩略图上画一个与缩略图一般大小的矩形区域
   if ($org_info[0] / $thumb_width > $org_info[1] / $thumb_height) //若宽度之比大于高度之比，那么就以缩略图的宽度为主，其高度就是宽度值比上比例值
   { 
    $lessen_width  = $thumb_width;
    $lessen_height  = $thumb_width / $scale_org;
   }
   else
   {
    /* 原始图片比较高，则以高度为准 */
    $lessen_width  = $thumb_height * $scale_org; //反之，若高度之比大于宽度之比，那么以缩略图的高度为主，其宽度就是高度值乘上比例值
    $lessen_height = $thumb_height;
   }
 
   $dst_x = ($thumb_width  - $lessen_width)  / 2;
   $dst_y = ($thumb_height - $lessen_height) / 2;
 
   /* 将原始图片进行缩放处理 */
   if ($gd == 2) //若gd库的版本是2的话，就运用imagecopyresampled()这个函数将原始图片的一块矩形区域copy到缩略图的一块矩形区域，并按照缩略图宽、高比例调整缩略图的大小,反之则运用imagecopyresized()函数进行相应的处理
   {
    imagecopyresampled($img_thumb, $img_org, $dst_x, $dst_y, 0, 0, $lessen_width, $lessen_height, $org_info[0], $org_info[1]);
    
   }
   else
   {
    imagecopyresized($img_thumb, $img_org, $dst_x, $dst_y, 0, 0, $lessen_width, $lessen_height, $org_info[0], $org_info[1]);
   }
 
   /* 创建当月目录 */
   if (empty($path))
   {
    $dir = ROOT_PATH . $this->images_dir . '/' . date('Ym').'/';
   }
   else
   {
    $dir = $path;
   }
 
 
   /* 如果目标目录不存在，则创建它 */
   if (!file_exists($dir))
   {
    if (!make_dir($dir))
    {
     /* 创建目录失败 */
     $this->error_msg  = sprintf($GLOBALS['_LANG']['directory_readonly'], $dir);
     $this->error_no   = ERR_DIRECTORY_READONLY;
     return false;
    }
   }
 
   /* 如果文件名为空，生成不重名随机文件名 */
   $filename = $this->unique_name($dir);
 
   /* 生成文件 */
   if (function_exists('imagejpeg')) //运用imagejgeg/gif/png（） 函数可以以 filename 为文件名创建一个 JPEG/gif/png图像，若不存在则报错咯！！
   {
    $filename .= '.jpg';
    imagejpeg($img_thumb, $dir . $filename);
   }
   elseif (function_exists('imagegif'))
   {
    $filename .= '.gif';
    imagegif($img_thumb, $dir . $filename);
   }
   elseif (function_exists('imagepng'))
   {
    $filename .= '.png';
    imagepng($img_thumb, $dir . $filename);
   }
   else
   {
    $this->error_msg = $GLOBALS['_LANG']['creating_failure'];
    $this->error_no  =  ERR_NO_GD;
 
    return false;
   }
 
   imagedestroy($img_thumb); //运用imagedestroy()函数销毁图像资源，释放内存空间
   imagedestroy($img_org);
 
   //确认文件是否生成
   if (file_exists($dir . $filename))
   {
    return str_replace(ROOT_PATH, '', $dir) . $filename;
   }
   else
   {
    $this->error_msg = $GLOBALS['_LANG']['writting_failure'];
    $this->error_no   = ERR_DIRECTORY_READONLY;
 
    return false;
   }
  }
  
 /**
     * 为图片增加水印
     * @author  xiaoguang
     * @access      public
     * @param       string      filename            原始图片文件名，包含完整路径
     * @param       string      target_file         需要加水印的图片文件名，包含完整路径。如果为空则覆盖源文件
     * @param       string      $watermark          水印完整路径
     * @param       int         $watermark_place    水印位置代码
     * @return      mix         如果成功则返回文件路径，否则返回false
     */
  function add_watermark($filename, $target_file='', $watermark='', $watermark_place='', $watermark_alpha = 0.65)
  {
   // 是否安装了GD
   $gd = $this->gd_version(); //调用类中gd_version()获取到当前gd库版本号
   //echo $gd;
   if ($gd == 0) //如果gd版本等于0,则报错（没有安装GD库）
   {
    $this->error_msg = $GLOBALS['_LANG']['missing_gd'];
    $this->error_no  = ERR_NO_GD;
 
    return false;
   }
 
   // 文件是否存在
   if ((!file_exists($filename)) || (!is_file($filename))) //若文件不存在或者不是个文件，则会执行报错警告
   {
    $this->error_msg  = sprintf($GLOBALS['_LANG']['missing_orgin_image'], $filename);
    $this->error_no   = ERR_IMAGE_NOT_EXISTS;
 
    return false;
   }
 
   /* 如果水印的位置为0，则返回原图 */
   if ($watermark_place == 0 || empty($watermark)) //若水印位置为空，或者不存在水印图片这时候，这时候则会返回原图
   {
    return str_replace(ROOT_PATH, '', str_replace('\\', '/', realpath($filename)));
   }
 
   if (!$this->validate_image($watermark)) //执行类中validata_image()函数判断水印是否合法
   {
    /* 已经记录了错误信息 */
    return false;
   }
 
   // 获得水印文件以及源文件的信息
   $watermark_info     = @getimagesize($watermark); //通过getimagesize()函数获得水印的信息数组
   
   /*echo '<pre>';
   print_r($watermark_info);
   echo '</pre>';*/
   
   $watermark_handle   = $this->img_resource($watermark, $watermark_info[2]); //再次应用本类中img_resouce函数，获取操作此图像的操作标识符
 
   if (!$watermark_handle) //若获取到的水印图片操作标识符资源为false，则会报出错误信息
   {
    $this->error_msg = sprintf($GLOBALS['_LANG']['create_watermark_res'], $this->type_maping[$watermark_info[2]]);
    $this->error_no  = ERR_INVALID_IMAGE;
    return false;
   }
 
   // 根据文件类型获得原始图片的操作句柄 
   $source_info    = @getimagesize($filename); //通过getimagesize()函数获得原图片的信息数组
   /*echo '<pre>';
   print_r($watermark_info);
   echo '</pre>';*/
   
   $source_handle  = $this->img_resource($filename, $source_info[2]); //再一次应用本类中img_resource函数，获取操作此图像的操作标识符
   if (!$source_handle) //若获取到的水印图片操作标识符资源为false，则会报出错误信息
   {
    $this->error_msg = sprintf($GLOBALS['_LANG']['create_origin_image_res'], $this->type_maping[$source_info[2]]);
    $this->error_no = ERR_INVALID_IMAGE;
 
    return false;
   }
 
   // 根据系统设置获得水印的位置
   switch ($watermark_place) //运用switch语句，根据函数中水印位置参数，获得水印的位置
   {
    case '1': //左上角
     $x = 0;
     $y = 0;
     break;
    case '2': //右上角
     $x = $source_info[0] - $watermark_info[0];
     $y = 0;
     break;
    case '4': //左下角
     $x = 0;
     $y = $source_info[1] - $watermark_info[1];
     break;
    case '5': //右下角
     $x = $source_info[0] - $watermark_info[0];
     $y = $source_info[1] - $watermark_info[1];
     break;
    default: //中间位置
     $x = $source_info[0]/2 - $watermark_info[0]/2;
     $y = $source_info[1]/2 - $watermark_info[1]/2;
   }
 
   if (strpos(strtolower($watermark_info['mime']), 'png') !== false) //先将水印图片文件路径名称小写化，然后运用strpos(),找到png在$watermark_info中第一次出现的位置 
   {
    imageAlphaBlending($watermark_handle, true); //通过imageAlphaBlending（）函数设定水印图像的混色模式，若第二个参数为true则启用混色模式
    imagecopy($source_handle, $watermark_handle, $x, $y, 0, 0,$watermark_info[0], $watermark_info[1]); //运用imagecopy（）函数将原始图像中坐标从 src_x ，src_y 开始，宽度为 src_w ，高度为 src_h 的一部分拷贝到目的图像中坐标为 dst_x 和 dst_y 的位置上（本实例中将水印图像的全部copy到原图中的指定系统位置(1,2,4,5,default)）
   }
   else
   {
    imagecopymerge($source_handle, $watermark_handle, $x, $y, 0, 0,$watermark_info[0], $watermark_info[1], $watermark_alpha); //运用imagecopymerge()函数将原始图像中坐标从 src_x ，src_y 开始，宽度为 src_w ，高度为 src_h 的一部分拷贝到目的图像中坐标为 dst_x 和 dst_y 的位置上。两图像将根据 pct 来决定合并程度，其值范围从 0 到 100。当 pct = 0 时，实际上什么也没做，当为 100 时对于调色板图像本函数和 imagecopy() 完全一样，它对真彩色图像实现了 alpha 透明。
   }
   $target = empty($target_file) ? $filename : $target_file; //结合三木运算符，若水印函数的传值中有目标图片地址路径存在，则是目标水印图像为$target_file，否则为原始图像
 
   switch ($source_info[2] ) //运用switch()语句，根据原图片的信息数组的图片类型来建立以目标水印图像为名的gif、jpg、png....
   {
    case 'image/gif':
    case 1:
     imagegif($source_handle,  $target);
     break;
 
    case 'image/pjpeg':
    case 'image/jpeg':
    case 2:
     imagejpeg($source_handle, $target);
     break;
 
    case 'image/x-png':
    case 'image/png':
    case 3:
     imagepng($source_handle,  $target);
     break;
 
    default:
     $this->error_msg = $GLOBALS['_LANG']['creating_failure'];
     $this->error_no = ERR_NO_GD;
 
     return false;
   }
 
   imagedestroy($source_handle); //imagedestroy()函数销毁原图片操作标识符，释放内存
 
   $path = realpath($target); //realpath()函数获取到目标水印图片的完整物理路径
   if ($path) //若存在，则去除前面的ROOT_PATH部分字符串，否则就报错咯！！
   {
    return str_replace(ROOT_PATH, '', str_replace('\\', '/', $path));
   }
   else
   {
    $this->error_msg = $GLOBALS['_LANG']['writting_failure'];
    $this->error_no  = ERR_DIRECTORY_READONLY;
 
    return false;
   }
  }
    /**
     *  检查水印图片是否合法
     * @author xiaoguang
     * @access  public
     * @param   string      $path       图片路径
     *
     * @return boolen
     */
    function validate_image($path) //检查水印图片是否合法
    {
        if (empty($path)) //若水印图片路径为空,则执行报错信息
        {
            $this->error_msg = $GLOBALS['_LANG']['empty_watermark'];
            $this->error_no  = ERR_INVALID_PARAM;
            return false;
        }
        /* 文件是否存在 */
        if (!file_exists($path)) //判断水印图片路径是否存在
        {
            $this->error_msg = sprintf($GLOBALS['_LANG']['missing_watermark'], $path);
            $this->error_no = ERR_IMAGE_NOT_EXISTS;
            return false;
        }
        // 获得文件以及源文件的信息
        $image_info     = @getimagesize($path); //利用getimagesize($path)函数获取水印图片的信息数组
        if (!$image_info) //若获得信息数组出错，则弹出报错信息
        {
            $this->error_msg = sprintf($GLOBALS['_LANG']['invalid_image_type'], $path);
            $this->error_no = ERR_INVALID_IMAGE;
            return false;
        }
        /* 检查处理函数是否存在 */
        if (!$this->check_img_function($image_info[2]))
        {
            $this->error_msg = sprintf($GLOBALS['_LANG']['nonsupport_type'], $this->type_maping[$image_info[2]]);
            $this->error_no  =  ERR_NO_GD;
            return false;
        }
        return true;
    }
    /**
     * 返回错误信息
     *
     * @return  string   错误信息
     */
    function error_msg()
    {
        return $this->error_msg;
    }
  
 /*------------------------------------------------------ */
    //-- 工具函数
    /*------------------------------------------------------ */
 
 /**
     * 检查图片类型
     * @param   string  $img_type   图片类型
     * @return  bool
     */
  function check_img_type($img_type) //此函数是检查图片的类型，参数一个，返回图片的类型
  {
   return $img_type == 'image/pjpeg' || //返回图片的类型给调用者，让其判断
       $img_type == 'image/x-png' ||
       $img_type == 'image/png'   ||
       $img_type == 'image/gif'   ||
       $img_type == 'image/jpeg';
  }
  
 /*
  * 返回标准的格林威志时间戳
  * @return int
  */
  function gmtime()
  {
   return (time() - date('Z'));
  }
 
 /**
  * 生成随机的数字串
  *
  * @author: xiaoguang
  * @return string
  */
    
  function random_filename()
  {
   $str = '';
   for($i = 0; $i < 9; $i++){
     $str .= mt_rand(0, 9); //mt_rand(0,9)函数生成(0,9)之间的任意一个随机数,mt_rand(min,max)..如果函数中没有参数则生成10个随机数组成的随机字符串
   }
    return $this->gmtime() . $str; //gmtime()返回的标准时间戳，time（）返回的是本地时间即我们是北京时间，即（time()-date('Z')）
  }
  
  /**
   *  生成指定目录不重名的文件名
   *
   * @access  public
   * @param   string      $dir        要检查是否有同名文件的目录
   * @author  xiaoguang
   * @return  string      文件名
   */
  function unique_name($dir)
  { //生成唯一图片文件名的函数
   $filename = ''; //将文件名初始化设为空，为了执行以下的函数
   while (empty($filename)){ //第一次$filename='',就会执行以下的语句,产生一个随机数 
    $filename = $this->random_filename(); //调用random_filename()产生随机生成数这个随机数是标准时间戳与9位随机数的组合
    if (file_exists($dir . $filename . '.jpg') || file_exists($dir . $filename . '.gif') || file_exists($dir . $filename . '.png')) //运用file_exists()函数判断随机产生的文件名是否有重名的，若有的话则将文件名设为空，继续循环
     {
      $filename = '';
     }
   }
  
    return $filename;
  }
  
  /**
   *  返回文件后缀名，如'.php'
   *
   * @access  public
   * @param
   * @author xiaoguang
   * @return  string      文件后缀名
   */
  function get_filetype($path) //返回文件后缀名函数，有一个路径参数
  {
   $pos = strrpos($path, '.'); //运用strrpos(string,find,start)函数，查找'.'在$path中最后一次出现的位置
   if ($pos !== false)
    {
     return substr($path, $pos); //运用substr函数从$pos开始截取余下的字符，返回余下的字符串
    }
    else
    {
     return ''; //如果$pos为False,则返回为空
    }
  }
  
  /**
   *
   * 将文件上传到指定的路径
   * @access  public
   * @param
   * @author  xiaoguang
   * @return void
   */
  function move_file($upload, $target) //移动上传的图片到指定的路径函数（俩个参数一个是图片的信息数组，一个系目标路径）
  {
   if (isset($upload['error']) && $upload['error'] > 0) //运用isset()函数判断检测变量是否被设置，如果没被设置或者$upload['error']>0的话就会返回false
    {
     return false; //
    }
  
    if (!$this->move_upload_file($upload['tmp_name'], $target)) //判断运用move_upload_file()函数将上传的文件移动到新位置是否成功，如果不成功则为false,否则为true
    {
     return false;
    }
  
    return true;
  }
  
  /**
   * 检查文件类型
   * @author  xiaoguang
   * @access      public
   * @param       string      filename            文件名
   * @param       string      realname            真实文件名
   * @param       string      limit_ext_types     允许的文件类型
   * @return      string
   */
  function check_file_type($filename, $realname = '', $limit_ext_types = '')
  {
   if ($realname)
    {
     $extname = strtolower(substr($realname, strrpos($realname, '.') + 1));
    }
    else
    {
     $extname = strtolower(substr($filename, strrpos($filename, '.') + 1));
    }
   
    if ($limit_ext_types && stristr($limit_ext_types, '|' . $extname . '|') === false)
    {
     return '';
    }
   
    $str = $format = '';
   
    $file = @fopen($filename, 'rb');
    if ($file)
    {
     $str = @fread($file, 0x400); // 读取前 1024 个字节
     @fclose($file);
    }
    else
    {
     if (stristr($filename, ROOT_PATH) === false)
     {
      if ($extname == 'jpg' || $extname == 'jpeg' || $extname == 'gif' || $extname == 'png' || $extname == 'doc' ||
       $extname == 'xls' || $extname == 'txt'  || $extname == 'zip' || $extname == 'rar' || $extname == 'ppt' ||
       $extname == 'pdf' || $extname == 'rm'   || $extname == 'mid' || $extname == 'wav' || $extname == 'bmp' ||
       $extname == 'swf' || $extname == 'chm'  || $extname == 'sql' || $extname == 'cert')
      {
       $format = $extname;
      }
     }
     else
     {
      return '';
     }
    }
   
    if ($format == '' && strlen($str) >= 2 )
    {
     if (substr($str, 0, 4) == 'MThd' && $extname != 'txt')
     {
      $format = 'mid';
     }
     elseif (substr($str, 0, 4) == 'RIFF' && $extname == 'wav')
     {
      $format = 'wav';
     }
     elseif (substr($str ,0, 3) == "\xFF\xD8\xFF")
     {
      $format = 'jpg';
     }
     elseif (substr($str ,0, 4) == 'GIF8' && $extname != 'txt')
     {
      $format = 'gif';
     }
     elseif (substr($str ,0, 8) == "\x89\x50\x4E\x47\x0D\x0A\x1A\x0A")
     {
      $format = 'png';
     }
     elseif (substr($str ,0, 2) == 'BM' && $extname != 'txt')
     {
      $format = 'bmp';
     }
     elseif ((substr($str ,0, 3) == 'CWS' || substr($str ,0, 3) == 'FWS') && $extname != 'txt')
     {
      $format = 'swf';
     }
     elseif (substr($str ,0, 4) == "\xD0\xCF\x11\xE0")
     {   // D0CF11E == DOCFILE == Microsoft Office Document
      if (substr($str,0x200,4) == "\xEC\xA5\xC1\x00" || $extname == 'doc')
      {
       $format = 'doc';
      }
      elseif (substr($str,0x200,2) == "\x09\x08" || $extname == 'xls')
      {
       $format = 'xls';
      } elseif (substr($str,0x200,4) == "\xFD\xFF\xFF\xFF" || $extname == 'ppt')
      {
       $format = 'ppt';
      }
     } elseif (substr($str ,0, 4) == "PK\x03\x04")
     {
      $format = 'zip';
     } elseif (substr($str ,0, 4) == 'Rar!' && $extname != 'txt')
     {
      $format = 'rar';
     } elseif (substr($str ,0, 4) == "\x25PDF")
     {
      $format = 'pdf';
     } elseif (substr($str ,0, 3) == "\x30\x82\x0A")
     {
      $format = 'cert';
     } elseif (substr($str ,0, 4) == 'ITSF' && $extname != 'txt')
     {
      $format = 'chm';
     } elseif (substr($str ,0, 4) == "\x2ERMF")
     {
      $format = 'rm';
     } elseif ($extname == 'sql')
     {
      $format = 'sql';
     } elseif ($extname == 'txt')
     {
      $format = 'txt';
     }
    }
   
    if ($limit_ext_types && stristr($limit_ext_types, '|' . $format . '|') === false)
    {
     $format = '';
    }
   
    return $format;
  }
  
  /**
   * 检查目标文件夹是否存在，如果不存在则自动创建该目录
   * @authur   xiaoguang
   * @access      public
   * @param       string      folder     目录路径。不能使用相对于网站根目录的URL djfkd
   *(很经典的创建目录的函数)
   * @return      bool
   */
  function make_dir($folder) //检查目标文件夹是否存在，不存在则创建之
  {
     $reval = false; //首先初始化这个变量为false
    
     if (!file_exists($folder))
     {
      /* 如果目录不存在则尝试创建该目录 */
      @umask(0); //改变原来的umask，PHP umask() 将 PHP 的 umask 设定为 mask&0777 并返回原来的 umask
    
      /* 将目录路径拆分成数组 */
      preg_match_all('/([^\/]*)\/?/i', $folder, $atmp); //运用preg_match_all()函数进行全局正则表达式匹配,将匹配的结果放入数组$atmp中
      
      /* 如果第一个字符为/则当作物理路径处理 */
      $base = ($atmp[0][0] == '/') ? '/' : ''; //若$atmp[0][0]这个匹配二维数组的[0][0]等于/的话，那么就$base就是/,否则为空
    
      /* 遍历包含路径信息的数组 */
      foreach ($atmp[1] AS $val) //遍历这个二维数组的第二个值，即$atmp[1]这个一维数组
      {
       if ($val != '') //若遍历出其中的值不等于空的话，就会执行以下的语句
       {
        $base .= $val; //此时的$base=$base+遍历值(1:$base='/.$val',2:$base='$val')
    
        if ('..' == $val || '.' == $val) //若遍历出来的值（传入的目录）中含有..或者.，这时候就把它们转换成'/'
        {
         /* 如果目录为.或者..则直接补/继续下一个循环 */
         $base .= '/'; //即..或者.变成了'../'
    
         continue; //补完'/'之后会中断本次循环，继续下次循环，将指针指向下一个遍历值
        }
       }
       else //若遍历出其中的值等于空的话，就会执行以下的语句（中断本次循环）
       {
        continue;
       }
    
       $base .= '/'; //为此时的$base加上'/',此时的值为(1:$base='/.$val./',2:$base='$val./')
    
       if (!file_exists($base)) //判断文件目录是否存在
       {
        /* 尝试创建目录，如果创建失败则继续循环 */
        if (@mkdir(rtrim($base, '/'), 0777)) //为了兼容windows（去除右边的斜杠为了在win下建文件，在linux下加不加斜杠都可以建目录），运用mkdir()函数创建权限为可读可写可执行的文件夹,去除左边的预定义字符
        {
         @chmod($base, 0777); //将该文件夹的权限设置为0777
         $reval = true; //创建成功后，设置刚开始初始化的变量$reval的值为true
        }
       }
      }
     }
     else
     {
      /* 路径已经存在。返回该路径是不是一个目录 */
      $reval = is_dir($folder); //检测传入的是不是个目录,如果不是个目录此时$reval为false
      if($revale){
      	$this ->dir = $folder;
      }
     }
    
     //clearstatcache();
    
     return $reval; //将这个bool变量返回给调用者使用
  }
  /**
   * 将上传文件转移到指定位置
   *
   * @param string $file_name
   * @param string $target_name
   * @return blog
   */
  function move_upload_file($file_name, $target_name = '')
  {
     if (function_exists("move_uploaded_file")) //若存在这个函数move_uploaded_file()
     {
      if (move_uploaded_file($file_name, $target_name)) //如果传入成功
      {
       @chmod($target_name,0755); //转移完成后则改变改文件的权限（设置其权限为可写、可执行）
       return true;
      }
      else if (copy($file_name, $target_name)) //若传入失败的话，则运用copy()函数将文件copy到指定的路径
      {
       @chmod($target_name,0755); //复制完成后则改变改文件的权限（设置其权限为可写、可执行）
       return true;
      }
     }
     elseif (copy($file_name, $target_name)) //若不存在这个函数move_uploaded_file(),则使用copy函数
     {
      @chmod($target_name,0755); //copy完成后改变文件的权限（设置其权限为可写、可执行）
      return true;
     }
     return false;
  }
  /**
   * 根据来源文件的文件类型创建一个图像操作的标识符
   *
   * @access  public
   * @param   string      $img_file   图片文件的路径
   * @param   string      $mime_type  图片文件的文件类型
   * @return  resource    如果成功则返回图像操作标志符，反之则返回错误代码
   */
  function img_resource($img_file, $mime_type) //返回源图像的操作资源
  {
   switch ($mime_type)
   {
    case 1:
    case 'image/gif':
     $res = imagecreatefromgif($img_file);
     break;
 
    case 2:
    case 'image/pjpeg':
    case 'image/jpeg':
     $res = imagecreatefromjpeg($img_file);
     break;
 
    case 3:
    case 'image/x-png':
    case 'image/png':
     $res = imagecreatefrompng($img_file);
     break;
 
    default:
     return false;
   }
 
   return $res;
  }
  /**
   * 获得服务器上的 GD 版本
   *
   * @access      public
   * @return      int         可能的值为0，1，2
   */
  function gd_version()
  {
   static $version = -1;
 
   if ($version >= 0)
   {
    return $version;
   }
 
   if (!extension_loaded('gd'))
   {
    $version = 0;
   }
   else
   {
    // 尝试使用gd_info函数
    if (PHP_VERSION >= '4.3')
    {
     if (function_exists('gd_info'))
     {
      $ver_info = gd_info();
      preg_match('/\d/', $ver_info['GD Version'], $match);
      $version = $match[0];
     }
     else
     {
      if (function_exists('imagecreatetruecolor'))
      {
       $version = 2;
      }
      elseif (function_exists('imagecreate'))
      {
       $version = 1;
      }
     }
    }
    else
    {
     if (preg_match('/phpinfo/', ini_get('disable_functions')))
     {
      /* 如果phpinfo被禁用，无法确定gd版本 */
      $version = 1;
     }
     else
     {
       // 使用phpinfo函数
        ob_start();
        phpinfo(8);
        $info = ob_get_contents();
        ob_end_clean();
        $info = stristr($info, 'gd version');
        preg_match('/\d/', $info, $match);
        $version = $match[0];
     }
     }
   }
 
   return $version;
   }
   
  /**
   * 检查图片处理能力
   *
   * @access  public
   * @param   string  $img_type   图片类型
   * @return  void
   */
  function check_img_function($img_type)
  {
   switch ($img_type)
   {
    case 'image/gif':
    case 1:
 
     if (PHP_VERSION >= '4.3')
     {
      return function_exists('imagecreatefromgif');
     }
     else
     {
      return (imagetypes() & IMG_GIF) > 0;
     }
    break;
 
    case 'image/pjpeg':
    case 'image/jpeg':
    case 2:
     if (PHP_VERSION >= '4.3')
     {
      return function_exists('imagecreatefromjpeg');
     }
     else
     {
      return (imagetypes() & IMG_JPG) > 0;
     }
    break;
 
    case 'image/x-png':
    case 'image/png':
    case 3:
     if (PHP_VERSION >= '4.3')
     {
       return function_exists('imagecreatefrompng');
     }
     else
     {
      return (imagetypes() & IMG_PNG) > 0;
     }
    break;
 
    default:
     return false;
   }
  }
  /**
   * 返回保存文件的文件名
   */
 function getImageName(){
 	return $this->img_name;
 }
 /**
  * 返回保存文件的目录
  * @return string
  */
 function getDir(){
 	return $this->dir;
 }
 }
?>