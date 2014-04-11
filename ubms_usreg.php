<?php
require_once ('ubms_db_config.php');
$aname = $_GET['appname'];
$RQType = $_GET['RQType'];
$usremail = $_GET['email'];
$usrpasswd = $_GET['password']; 
$usrname = $_GET['username']; 
$licenseAgreement = $_GET['licenseAgreement']; 
$termsOfService = $_GET['termsOfService']; 
$hash = md5( rand(0,1000) );
$securePassword = md5($usrpasswd);

$conn = mysqli_connect("localhost", "jessespe", "Xfn73Xm0", "jessespe_FindMyDriver");
//Define db Connection
if (mysqli_connect_errno($conn))// Check connection
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$v2 = "'" . $conn -> real_escape_string($aname) . "'";
$v3 = "'" . $conn -> real_escape_string($RQType) . "'";
$v4 = "'" . $conn -> real_escape_string($usremail) . "'";
$v5 = "'" . $conn -> real_escape_string(md5($usrpasswd)) . "'";
$v6 = "'" . $conn -> real_escape_string($usrname) . "'";
$v7 = "'" . $conn -> real_escape_string($licenseAgreement) . "'";
$v8 = "'" . $conn -> real_escape_string($termsOfService) . "'";
$v9 = "'" . $conn -> real_escape_string($hash) . "'";


mysqli_query($conn, "INSERT INTO members (username, email, password, agree_to_license_agreement, agree_to_terms_of_service, activation_code, email_activation_status)
				VALUES ('$usrname', '$usremail', '$securePassword', '$licenseAgreement', '$termsOfService', '$hash', '0')");
				echo $_GET['callback'] . '(' . "{'message' : 'Registration successful!'}" . ')';
mysqli_close($conn);


$to      = $usremail; // Send email to our user
$subject = 'Please Verify Your Account'; // Give the email a subject 
$message = '
 
Your account has been created, you can login with the following credentials after you have activated your account by clicking on the url below.
 
------------------------
Username: '.$usrname.'
Password: '.$usrpasswd.'
------------------------
 
Please click this link to activate your account:
http://api.universalbusinessmodel.com/verify.php?callback=?&email='.$usremail.'&activationCode='.$hash.'
 
'; 
                     
$headers = 'From:notify@universalbusinessmodel.com' . "\r\n"; // Set from headers
mail($to, $subject, $message, $headers); // Send our email

 ?>
