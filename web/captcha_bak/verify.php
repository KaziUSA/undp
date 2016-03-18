<?php
//CAPTCHA Matching code
session_start();
$name = $_POST["name"];
$address = $_POST["address"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$message = $_POST["message"];
$captcha = $_POST["captcha"];

/*if($name == '' || $address == '' || $address == '' || $phone == '' || $message == '' || $captcha == '') {
	echo 'Please fill all the fields.';
}*/

if ($_SESSION["code"] == $captcha) {
    echo "success";

    $to = "giovanni.congi@one.un.org";
    $subject = "Contact From UNDP Website";
    
    $txt = '<strong>Name:</strong> ' . $data_name . 
        '<br><strong>Address:</strong> ' . $data_address .
        '<br><strong>Email:</strong> ' . $data_email . 
        '<br><strong>Phone:</strong> ' . $data_phone .
        '<br><strong>Message:</strong> ' . $data_message;

    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // More headers
    $headers .= "From: <info@undp.kazi270.com>" . "\r\n";
    $headers .= "CC: bronwyn.russel@one.un.org" . "\r\n";
    $headers .= "Bcc: manish@kazistudios.com"."\r\n";

    mail($to,$subject,$txt,$headers);
} else {
    die("Incorrect");
}
?>
