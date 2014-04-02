<?php
require_once('globalGetVariables.php');
require_once('ubms_db_config.php');
require_once('DBConnect_UBMv1.php');		//Provides the variables used for UBMv1 database connection $conn
$conn = new mysqli($DBServer, $DBUser, $DBPass, $DBName);
// check connection
if ($conn -> connect_error) {
	trigger_error('Database connection failed: ' . $conn -> connect_error, E_USER_ERROR);
}
$v2 = "'" . $conn -> real_escape_string($activeModelId) . "'";
$v3 = "'" . $conn -> real_escape_string($positionDescription) . "'";
$v4 = "'" . $conn -> real_escape_string($positionTitle) . "'";
$v5 = "'" . $conn -> real_escape_string($username) . "'";
$v6 = "'" . $conn -> real_escape_string($positionReportsTo) . "'";
//SELECT
//1. Find the current active model UUID
$activeModelUUID = 1;
	$sqlsel1="SELECT * FROM ubm_modelcreationsuite_heirarchy_object_antiSolipsism_UUID WHERE model_id=$v2";		//Select all 
	$rs1=$conn->query($sqlsel1);
	if($rs1 === false) {
	  trigger_error('Wrong SQL: ' . $sqlsel1 . ' Error: ' . $conn->error, E_USER_ERROR);
	} else{
		while ($items1 = $rs1->fetch_assoc()) {
			$activeModelUUID = stripslashes($items1['UUID']);
		}
	}
//INSERT
	//1. Insert Position into the model_positions table.
$sqlins = "INSERT INTO ubm_model_positions (description, title, creator_username, reports_to_id) VALUES ( $v3, $v4, $v5, $v6 )"; //Creates a New Core Value record.
if ($conn -> query($sqlins) === false) {
	trigger_error('Wrong SQL: ' . $sqlins . ' Error: ' . $conn -> error, E_USER_ERROR);
} else {
	$last_inserted_id = $conn -> insert_id;
	$affected_rows += $conn -> affected_rows;
	//2. Make an entry in the antiSlipsism table to generate a Universal Unique Identifier for the Position to create an instance that will allow objects to be attached to it.
	$sqlins2 = "INSERT INTO ubm_modelcreationsuite_heirarchy_object_antiSolipsism_UUID (legal_entity_id, model_id, position_id, jobDescription_id, policy_id, procedure_id, step_id	, task_id, created_by) 
				VALUES ( '0','0',$last_inserted_id,'0','0','0','0','0',$v5 )";
	if ($conn -> query($sqlins2) === false) {
		trigger_error('Wrong SQL: ' . $sqlins2 . ' Error: ' . $conn -> error, E_USER_ERROR);
	} else {
			$last_inserted_position_uuid = $conn -> insert_id;		
	//3. Insert a row in the hierarchy object closureTable so our position is tied to the current activeModel in the hierarchy object table.
	//4. Insert a row in the hierarchy object closureTable so the position is tied to itself in the hierarchy object table.
			$sqlins3 = "INSERT INTO ubm_modelcreationsuite_heirarchy_object_closureTable ( ancestor_id, descendant_id, path_length, created_by ) 
						VALUES ( $last_inserted_position_uuid, $last_inserted_position_uuid, '3', $v5 ), ( $activeModelUUID, $last_inserted_position_uuid, '3', $v5 )";
		if ($conn -> query($sqlins3) === false) {
			trigger_error('Wrong SQL: ' . $sqlins3 . ' Error: ' . $conn -> error, E_USER_ERROR);
		} else {
			$affected_rows = $affected_rows + $conn -> affected_rows;
			$last_inserted_id = $conn -> insert_id;
					echo $_GET['callback'] . '(' . "{'message' : 'Requested Position $title was created successfully and assigned UUID $last_inserted_position_uuid and added to model id: $activeModelId and reports to $reportsTo !'}" . ')';
		}
	}
}
?>