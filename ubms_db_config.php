<?php
$ip = $_SERVER['REMOTE_ADDR'];
$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
$DBSServer = 'localhost'; // e.g 'localhost' or '192.168.1.100'
$DBSUser   = 'jessespe';
$DBSPass   = 'Xfn73Xm0';
$DBSName   = 'jessespe_ubm_applications';	
	$sconn = new mysqli($DBSServer, $DBSUser, $DBSPass, $DBSName);
	$v1="'" . $sconn -> real_escape_string($_GET['key']) . "'";
	$v2="'" . $sconn -> real_escape_string($_SERVER['REMOTE_ADDR']) . "'";
	$v3="'" . $sconn -> real_escape_string($_SERVER['HTTP_X_FORWARDED_FOR']) . "'";
	$v4="'" . $sconn -> real_escape_string($details->hostname) . "'";
	$v5="'" . $sconn -> real_escape_string($details->city) . "'";
	$v6="'" . $sconn -> real_escape_string($details->region) . "'";
	$v7="'" . $sconn -> real_escape_string($details->country) . "'";
	$v8="'" . $sconn -> real_escape_string($details->loc) . "'";
	$v9="'" . $sconn -> real_escape_string($details->org) . "'";
	$v10="'" . $sconn -> real_escape_string(basename($_SERVER['SCRIPT_NAME'])) . "'";
	$v11="'" . $sconn -> real_escape_string($_GET['username']) . "'";

	if($sconn->connect_error){
	  trigger_error('Database connection failed: '  . $sconn->connect_error, E_USER_ERROR);
	}
		$ssqlsel="SELECT * FROM applications WHERE application_key=$v1";
		$srs=$sconn->query($ssqlsel);
		if(mysqli_num_rows($srs)>0){
			while ($items = $srs->fetch_assoc()) {
				$returnApplicationKeyId = stripslashes($items['application_key']);
//				echo $returnApplicationKeyId;
				 $sql="INSERT INTO connection_log (app_key, remote_ip, proxy_ip, hostname, city, region, country, loc, org, pagename, username) VALUES ( $v1,$v2,$v3,$v4,$v5,$v6,$v7,$v8,$v9,$v10,$v11 )";
				 if($sconn->query($sql) === false) {
				 trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $sconn->error, E_USER_ERROR);
				 } else {
					 $last_inserted_id = $conn->insert_id;
					echo $affected_rows = $conn->affected_rows;
				 }
			}
		}else {
			echo $_GET['callback'] . '(' . "{'message' : 'The Universal Business Model is a collaborative project. However, our financiers insist we reserve access to this resource for UBM developers only. If you are not a robot, visit our website at www.universalbusinessmodel.com to sign up for a developer account and get access to this as well as our many other extensive API's. If you are having trouble accessing an application email us at support@universalbusinessmodel.com'}" . ')';
			die();
		}	
	
	