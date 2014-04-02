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
$v2 = "'" . $conn -> real_escape_string($reference) . "'";
$v3 = "'" . $conn -> real_escape_string($title) . "'";
$v4 = "'" . $conn -> real_escape_string($descritpion) . "'";
$v5 = "'" . $conn -> real_escape_string($creator_id) . "'";
	//1. Insert Model Title into the Models table.
$sqlins = "INSERT INTO ubm_model (reference, title, description, creator_id) 								
			VALUES ($v2, $v3, $v4, $v5)";										
if ($conn -> query($sqlins) === false) {
	trigger_error('Wrong SQL: ' . $sqlins . ' Error: ' . $conn -> error, E_USER_ERROR);
} else {
	$last_inserted_id = $conn -> insert_id;
	$affected_rows += $conn -> affected_rows;
	//2. Make an entry in the antiSlipsism table to generate a Universal Unique Identifier for the Model to allow objects to be attached to it.
	$sqlins2 = "INSERT INTO ubm_modelcreationsuite_heirarchy_object_antiSolipsism_UUID (legal_entity_id, model_id, position_id, jobDescription_id, policy_id, procedure_id, step_id	, task_id, created_by) 
				VALUES ( '0',$last_inserted_id,'0','0','0','0','0', '0', $v5 )";
	if ($conn -> query($sqlins2) === false) {
		trigger_error('Wrong SQL: ' . $sqlins2 . ' Error: ' . $conn -> error, E_USER_ERROR);
	} else {
			$last_inserted_model_uuid = $conn -> insert_id;		
	//3. Make an entry in the antiSlipsism table to generate a Universal Unique Identifier for a position called Owners to automatically attach it to the model.
		$sqlins3 = "INSERT INTO ubm_modelcreationsuite_heirarchy_object_antiSolipsism_UUID (legal_entity_id, model_id, position_id, jobDescription_id, policy_id, procedure_id, step_id	, task_id, created_by) 
					VALUES ( '0','0','1','0','0','0','0','0',$v5 )";
		if ($conn -> query($sqlins3) === false) {
			trigger_error('Wrong SQL: ' . $sqlins3 . ' Error: ' . $conn -> error, E_USER_ERROR);
		} else {
			$last_inserted_position_uuid = $conn -> insert_id;					
			$affected_rows = $affected_rows + $conn -> affected_rows;
			$last_inserted_id = $conn -> insert_id;
	//4. Insert a row in the hierarchy object closureTable so the model is tied to itself in the hierarchy object table.
			$sqlins3 = "INSERT INTO ubm_modelcreationsuite_heirarchy_object_closureTable ( ancestor_id, descendant_id, path_length, created_by ) 
						VALUES ( $last_inserted_model_uuid, $last_inserted_model_uuid, '2', $v5 )";
			if ($conn -> query($sqlins3) === false) {
				trigger_error('Wrong SQL: ' . $sqlins3 . ' Error: ' . $conn -> error, E_USER_ERROR);
			} else {
	//5. Insert a row in the hierarchy object closureTable so an owners position is tied to the last inserted model in the hierarchy object table.
	//6. Insert a row in the hierarchy object closureTable so an owners position is tied to itself in the hierarchy object table.
					$sqlins3 = "INSERT INTO ubm_modelcreationsuite_heirarchy_object_closureTable ( ancestor_id, descendant_id, path_length, created_by ) 
							VALUES ( $last_inserted_model_uuid, $last_inserted_position_uuid, '3', $v5 ), ( $last_inserted_position_uuid, $last_inserted_position_uuid, '3', $v5 )";
				if ($conn -> query($sqlins3) === false) {
					trigger_error('Wrong SQL: ' . $sqlins3 . ' Error: ' . $conn -> error, E_USER_ERROR);
				} else {
					$affected_rows = $affected_rows + $conn -> affected_rows;
					echo $_GET['callback'] . '(' . "{'message' : 'The number of affected rows is $affected_rows, the UUID of the new model is $last_inserted_id'}" . ')';
				}
			}
		}
	}
}
//Send Email Message
$to = "jspenc72@gmail.com";
$subject = "A new Business Model was created by $v5!";
$message = "$v5 created the model using version 3.3.1 of the model creation suite. Current latitude and longitude is $v108";
$from = "notify@universalbusinessmodel.com";
$headers = "From:" . $from;
mail($to, $subject, $message, $headers);
//echo "Mail Sent.";
/*http://www.pontikis.net/blog/how-to-use-php-improved-mysqli-extension-and-why-you-should
 * SELECT
 $sql='SELECT col1, col2, col3 FROM table1 WHERE condition';

 $rs=$conn->query($sql);

 if($rs === false) {
 trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
 } else {
 $rows_returned = $rs->num_rows;
 }
 * Iterate over Recordset
 $rs->data_seek(0);
 while($row = $rs->fetch_assoc()){
 echo $row['col1'] . '<br>';
 }
 * 	Store all values to array
 $rs=$conn->query($sql);

 if($rs === false) {
 trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
 } else {
 $arr = $rs->fetch_all(MYSQLI_ASSOC);
 }
 foreach($arr as $row) {
 echo $row['co1'];
 }
 * 		Record count
 $rows_returned = $rs->num_rows;
 * Move inside recordset
 $rs->data_seek(10);
 *	Free memory

 $rs->free();
 *
 * INSERT
 $v1="'" . $conn->real_escape_string('col1_value') . "'";

 $sql="INSERT INTO tbl (col1_varchar, col2_number) VALUES ($v1,10)";

 if($conn->query($sql) === false) {
 trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
 } else {
 $last_inserted_id = $conn->insert_id;
 $affected_rows = $conn->affected_rows;
 }
 * UPDATE
 $v1="'" . $conn->real_escape_string('col1_value') . "'";

 $sql="UPDATE tbl SET col1_varchar=$v1, col2_number=1 WHERE id>10";

 if($conn->query($sql) === false) {
 trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
 } else {
 $affected_rows = $conn->affected_rows;
 }
 * DELETE
 $sql="DELETE FROM tbl WHERE id>10";

 if($conn->query($sql) === false) {
 trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
 } else {
 $affected_rows = $conn->affected_rows;
 }

 * */
?>