 <?php
 $aname = $_GET['appname'];
 $RQType = $_GET['RQType'];
 $username = $_GET['username'];
 $usrpasswd = $_GET['password'];

 require_once('ubms_db_config.php');	

 //Put your json request variables here

$activeModelId = $_GET['activeModelId'];

//End JSON Request Variables
//Start Device Position Variables

$lat = $_GET['lat'];
$lng = $_GET['lng'];

//End Device Position Variables
			$sqllink = mysqli_connect("localhost","jessespe","Xfn73Xm0","jessespe_UBMv1"); 	//Define db Connection
			/* check connection */
			if (mysqli_connect_errno()) {
			    printf("Connect failed: %s\n", mysqli_connect_error());
			    exit();
			}
			$query = "SELECT * FROM `ubm_model` WHERE `creator_id`='$username'";
			$result = mysqli_query($sqllink, $query);
			if (!$result) { //there is a problem with the table
			}
			$all_items = array();
			while ($items = $result->fetch_assoc()) {					
				$all_items[] = $items;
			}
			//echo $_GET['callback'] . '(' . "{'message' : ''}" . ')';							
			echo $_GET['callback'] . '(' . json_encode($all_items) . ')';
			mysqli_close($sqllink);
?>