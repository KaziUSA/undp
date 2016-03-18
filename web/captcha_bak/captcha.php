<?php
//staring session
session_start();

//Initializing PHP variable with string
$captchanumber = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';

//Getting first 6 word after shuffle
$captchanumber = substr(str_shuffle($captchanumber), 0, 6);

//Initializing session variable with above generated sub-string
$_SESSION["code"] = $captchanumber;

//Generating CAPTCHA
$image = imagecreatefromjpeg("bj.jpg");
$foreground = imagecolorallocate($image, 153, 188, 68); //font color

//imagestring($image, 5, 45, 8, $captchanumber, $foreground);
$color = imagecolorallocate($image, 153, 188, 68);//black - 0, 0, 0
$font = 'wwf.otf';
imagettftext($image, 20, 0, 45, 25, $color, $font, $captchanumber);

header('Content-type: image/png');
imagepng($image);
?>