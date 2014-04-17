<?php
require_once('globalGetVariables.php');
require_once('ubms_db_config.php');
require_once('DBConnect_UBMv1.php');		//Provides the variables used for UBMv1 database connection $conn

$conn = new mysqli($DBServer, $DBUser, $DBPass, $DBName);
// check connection
if ($conn -> connect_error) {
	trigger_error('Database connection failed: ' . $conn -> connect_error, E_USER_ERROR);
}

//INSERT
$v2 = "'" . $conn -> real_escape_string($physicalFacilityTitle) . "'";
$v3 = "'" . $conn -> real_escape_string($physicalFacilityAssociatedCost) . "'";
$v5 = "'" . $conn -> real_escape_string($activeModelUUID) . "'";

$sqlins = "INSERT INTO ubm_model_physicalfacilities (facility_title, associated_cost) VALUES ( $v2, $v3 )"; //Creates a New Core Value record.
if ($conn -> query($sqlins) === false) {
	trigger_error('Wrong SQL: ' . $sqlins . ' Error: ' . $conn -> error, E_USER_ERROR);
} else {
	$last_inserted_id = $conn -> insert_id;
	//$affected_rows = $conn -> affected_rows;
	$sqlins2 = "INSERT INTO ubm_model_has_physicalfacilities (model_UUID, physicalfacility_id) VALUES ( $v5, $last_inserted_id )";
	if ($conn -> query($sqlins2) === false) {
		trigger_error('Wrong SQL: ' . $sqlins2 . ' Error: ' . $conn -> error, E_USER_ERROR);
	} else {

	}
}

echo $_GET['callback'] . '(' . "{'message' : 'Physical Facility $title created successfully!'}" . ')';
