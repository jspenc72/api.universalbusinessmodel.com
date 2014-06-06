 <?php
 $aname = $_GET['appname'];
 $RQType = $_GET['RQType'];
 $username = $_GET['username'];
 $usrpasswd = $_GET['password'];
 //Put your json request variables here

$activeModelId= $_GET['activeModelId'];
$activePositionId = $_GET['activePositionId'];

//End JSON Request Variables
//Start Device Position Variables
$lat = $_GET['lat'];
$lng = $_GET['lng'];
//End Device Position Variables
$DBServer = 'localhost'; // e.g 'localhost' or '192.168.1.100'
$DBUser   = 'jessespe';
$DBPass   = 'Xfn73Xm0';
$DBName   = 'jessespe_UBMv1';			
	$conn = new mysqli($DBServer, $DBUser, $DBPass, $DBName);
	// check connection
	if ($conn->connect_error) {
	  trigger_error('Database connection failed: '  . $conn->connect_error, E_USER_ERROR);
	}
//SELECT
$all_items = array();
$some_items = array();
//1. Select all records for checklist items stored in model_creation_suite, Count the number of items in the checklist.
			$sqlsel1="SELECT * FROM ubm_model_has_positions WHERE model_id=$activeModelId AND position_id=$activePositionId ORDER BY position_id DESC";		//Select all 
			$rs1=$conn->query($sqlsel1);
			if($rs1 === false) {
			  trigger_error('Wrong SQL: ' . $sqlsel1 . ' Error: ' . $conn->error, E_USER_ERROR);
			} else{
				while ($items1 = $rs1->fetch_assoc()) {
					//Extract Position Id from items1 array
					$returnItemId = stripslashes($items1['position_id']);
					$sqlsel2="SELECT * FROM ubm_model_position_has_jobDescriptions WHERE position_id=$returnItemId ORDER BY jobdescription_id";		//Select all 
					$rs2=$conn->query($sqlsel2);
					if($rs2 === false) {
					  trigger_error('Wrong SQL: ' . $sqlsel2 . ' Error: ' . $conn->error, E_USER_ERROR);
					} else {
						while ($items2 = $rs2->fetch_assoc()) {
							$returnItem2Id = stripslashes($items2['jobdescription_id']);
							$sqlsel3="SELECT * FROM ubm_model_jobDescriptions WHERE id=$returnItem2Id ORDER BY id";		//Select all 
							$rs3=$conn->query($sqlsel3);
							if($rs3 === false) {
							  trigger_error('Wrong SQL: ' . $sqlsel3 . ' Error: ' . $conn->error, E_USER_ERROR);
							} else {
								while ($items3 = $rs3->fetch_assoc()) {				
									$all_items [] = $items3;
								}	
							}													
						}	
					}									
				}								
			}

//6. JSONP packaged $all_items array
			echo $_GET['callback'] . '(' . json_encode($all_items) . ')';				//Output $all_items array in json encoded format.
	 