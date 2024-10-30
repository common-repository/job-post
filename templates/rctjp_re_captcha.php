<?php session_start();
function rctjp_re_captcha(){
$ranStr = md5(microtime());
$ranStr = substr($ranStr, 0, 6);
$_SESSION['cap_code'] = $ranStr;
echo $cap = $_SESSION['cap_code'];
die();
}