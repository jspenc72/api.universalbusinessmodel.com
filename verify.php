 <?php
//require_once ('ubms_db_config.php');
$email = $_GET['email'];
$hash = $_GET['activationCode'];
 
$DBServer = 'localhost'; // e.g 'localhost' or '192.168.1.100'
$DBUser   = 'jessespe';
$DBPass   = 'Xfn73Xm0';
$DBName   = 'jessespe_FindMyDriver';			

	$conn = new mysqli($DBServer, $DBUser, $DBPass, $DBName);
	 
	// check connection
	if ($conn->connect_error) {
	  trigger_error('Database connection failed: '  . $conn->connect_error, E_USER_ERROR); 
	}
	

//UPDATE
 		//$v1="'" . $conn->real_escape_string($disposition) . "'";		
 			 
		$sql="UPDATE `members` SET email_activation_status='1' WHERE activation_code='$hash' AND email='$email' AND email_activation_status='0'";
		if($conn->query($sql) === false) {
		  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
		} else {
		  $affected_rows = $conn->affected_rows;
		  echo "Your account has been successfully activated!";
		}
		?>
		<p>Please click <a href="http://www.universalbusinessmodel.com/dev">here</a> to log in!</p>
