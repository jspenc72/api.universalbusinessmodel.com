 <?php
 $aname = $_GET['appname'];
 $RQType = $_GET['RQType'];
 $username = $_GET['username'];
 $usrpasswd = $_GET['password'];
 $openitemid = $_GET['openitemid'];

//			echo "$openitemid";
	
			$sqllink = mysqli_connect("localhost","jessespe","Xfn73Xm0","jessespe_UBMv1"); 	//Define db Connection
			/* check connection */
			if (mysqli_connect_errno()) {
			    printf("Connect failed: %s\n", mysqli_connect_error());
			    exit();
			}
			$query = "SELECT * FROM `ubm_mcs_app_item_comments` WHERE `openitemid`='$openitemid'";
			$result = mysqli_query($sqllink, $query);
			if (!$result) { //there is a problem with the table
			}
			$all_items = array();
			while ($items = $result->fetch_assoc()) {					
				$all_items[] = $items;
			}
		//	echo $_GET['callback'] . '(' . "{'message' : 'This is a new message! $openitemid'}" . ')';							
			echo $_GET['callback'] . '(' . json_encode($all_items) . ')';
			mysqli_close($sqllink);
?>