<?php 

session_start();
require_once 'class/CaptchaMS.class.php';
require_once 'class/WDealMode.data.php';

$mode = new WDealMode(WDealMode::MODE_NONE);
$picture = new Captcha();
$picture -> createCaptcha("",$mode->getMode());
$_SESSION['captcha'] = $picture->getCaptchaValue();
?>