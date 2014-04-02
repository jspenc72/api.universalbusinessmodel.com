 <?php
 $aname = $_GET['appname'];
 $RQType = $_GET['RQType'];
 $username = $_GET['username'];
 $usrpasswd = $_GET['password'];
 //Put your json request variables here

$activeModelId = $_GET['activeModelId'];
$selectedUser = $_GET['selectedUserId'];

//End JSON Request Variables
//Start Device Position Variables

$lat = $_GET['lat'];
$lng = $_GET['lng'];

//End Device Position Variables
$DBServer = 'localhost'; // e.g 'localhost' or '192.168.1.100'
$DBUser   = 'jessespe';
$DBPass   = 'Xfn73Xm0';
$DBName   = 'jessespe_UBMv1';

$numberofresolutions = 2;
	$conn = new mysqli($DBServer, $DBUser, $DBPass, $DBName);
	// check connection
	if ($conn->connect_error) {
	  trigger_error('Database connection failed: '  . $conn->connect_error, E_USER_ERROR);
	}
//SELECT
$all_items = array();
//1. Check to see if the user is the creator of the currently active model..
			$sqlsel1="SELECT * FROM ubm_model WHERE id='$activeModelId'";		//Select all 
			$rs1=$conn->query($sqlsel1);
			if($rs1 === false) {
			  trigger_error('Wrong SQL: ' . $sqlsel1 . ' Error: ' . $conn->error, E_USER_ERROR);
			} else {		
				while ($items = $rs1->fetch_assoc()) {
							$returnModelCreatorId = stripslashes($items['creator_id']);
					if($returnModelCreatorId==$username){
//2. If user is the creator of the model, remove the selected user permission from model_has_members
						$sql="DELETE FROM ubm_model_has_members WHERE id='$selectedUser'";
						if($conn->query($sql) === false) {
						  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);

						} else {
							$affected_rows = $conn->affected_rows;
							//echo $affected_rows;
					       	echo $_GET['callback'] . '(' . "{'message' : 'User was successfully removed from this model.','validation' : 'TRUE'}" . ')';							
						}							
					}else{
				       echo $_GET['callback'] . '(' . "{'message' : 'Only the creator of this model can modify users who have access.','validation' : 'FALSE'}" . ')';							
					}
				}								
						$num_rows = mysqli_num_rows($rs1);
//						echo "the total number of rows: $num_rows </br>";						
			}
 
//6. JSONP packaged $all_items array
//			echo $_GET['callback'] . '(' . json_encode($all_items) . ')';				//Output $all_items array in json encoded format.
				 