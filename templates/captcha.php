<?php
session_start();
$ranStr = $_SESSION['cap_code'];
$newImage = imagecreatefromjpeg("image/cap_bg.jpg");
$txtColor = imagecolorallocate($newImage,  0, 136, 204);
imagestring($newImage, 5, 65, 25, $ranStr, $txtColor);
header("Content-type: image/jpeg");
imagejpeg($newImage);
?>


