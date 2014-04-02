<?php
//Application Authentication Variables
 $aname = $_GET['appname'];				//Name of the application using the API
 $key = $_GET['key'];					//Application Security Key issued by BMCL
//UBM Single Sign on Authentication
 $username = $_GET['username'];
 $usrpasswd = $_GET['password']; 
 $usrname = 	$_GET['username'];
 $usremail = $_GET['email'];

//UBM User Application Preferences
 $carrier = $_GET['carrier']; 			//Wireless carrier, e.g. Verizon, Sprint, AT&T
 $phoneNumber = $_GET['phoneNumber'];	//User phone phone number
//UBM Geolocation Variables
 $lat = $_GET['lat'];					//Latitude
 $lng = $_GET['lng'];					//Longitude
//UBM Application Page Referencing Variables
 $pageid = $_GET['pageid'];				//The page ID that is displayed to the users at the top right corner of the app 

//UBM Change Request Variables Create New Feedback
 $reviewermemberid = $_GET['reviewermemberid'];
 $resolutionexplanation = $_GET['resolutionexplanation']; 
 $resolution = $_GET['resolution']; 
 $ubmchangerequestid = $_GET['ubmchangerequestid'];    
 
//UBM Change Request Variables Create New Request
 $ccode = $_GET['ccode']; 
 $datesubmitted = $_GET['datesubmitted']; 
 $ubmversion = $_GET['ubmversion']; 
 $contactphone = $_GET['contactphone'];
 $contactemail = $_GET['contactemail']; 
 $ubmrefmodel = $_GET['ubmrefmodel']; 
 $bmrefmodel = $_GET['bmrefmodel']; 
 $description = $_GET['description']; 
 $status = $_GET['status'];  
//UBM Change Request Variables Select all Feedback
 $openitemid = $_GET['openitemid'];
//UBM MCS add user to model
 $memberRole = $_GET['memberRole'];
 $inviteUsername = $_GET['inviteUsername'];
 $inviteEmail = $_GET['inviteEmail']; 
//UBM API Variables
 $RQType = $_GET['RQType'];				//Request type INSERT, UPDATE, DELETE, CREATE This may no longer be necessary because the name of the php script that is accessed is stored in the log.

//UBM MCS Model Variables
$activeModelId = $_GET['activeModelId'];

//UBM MCS Create Model Variables
$reference = $_GET['reference'];
$title = $_GET['title'];
$descritpion = $_GET['description'];
$creator_id= $_GET['creator_id'];
//Non Heirarchy Object Variables
	//UBM MCS Model Add Alternative
$alternativeDescription = $_GET['alternativeDescription'];
$alternativeDecision = $_GET['alternativeDecision'];
	//UBM MCS Model Add CoreValue
$activeCoreValueId = $_GET['activeCoreValueId'];
	//UBM MCS Model Add Customer
$activeCustomerId = $_GET['activeCustomerId'];
	//UBM MCS Model Add Feature
$activeFeatureId = $_GET['activeFeatureId'];
	//UBM MCS Model Add JobDescription
$activeJobDescriptionId = $_GET['activeJobDescriptionId'];
	//UBM MCS Model Add OrganizationalStructure
$organizationalStructureId = $_GET['organizationalStructureId'];
	//UBM MCS Model Add PhysicalFacility
$activePhysicalFacilityId = $_GET['activePhysicalFacilityId'];
	//UBM MCS Model Add Policy
$activePolicyId = $_GET['activePolicyId'];
	//UBM MCS Model Add Position
$activeModelId = $_GET['activeModelId'];
$activePositionId = $_GET['activePositionId'];
$positionReportsTo = $_GET['positionReportsTo'];
	//UBM MCS Model Add Procedure
$activeProcedureId = $_GET['activeProcedureId'];
	//UBM MCS Model Add Product
$activeProductId = $_GET['activeProductId'];
	//UBM MCS Model Add RequestedApplication
$activeRequestedApplicationId = $_GET['activeRequestedApplicationId'];
	//UBM MCS Model Add Service
$activeServiceId = $_GET['activeServiceId'];
	//UBM MCS Model Add Step
$activeStepId = $_GET['activeStepId'];
	//UBM MCS Model Add StrategicAlliance
$activeStrategicAllianceId = $_GET['activeStrategicAllianceId'];
	//UBM MCS Model Add StrategicPositioning
$activeStrategicPositioningId = $_GET['activeStrategicPositioningId'];
	//UBM MCS Model Add SwotAnalysis
$activeSwotAnalysisVariableId = $_GET['activeSwotAnalysisVariableId'];
	//UBM MCS Model Add Task
$activeTaskId = $_GET['activeTaskId'];						
//Heirarchy Object Variables
	//UBM MCS Model Add Policy
	//UBM MCS Model Add Position
	//UBM MCS Model Create Position
$activeModelId = $_GET['activeModelId'];
$positionDescription = $_GET['positionDescription'];
$positionTitle = $_GET['positionTitle'];
$positionReportsTo = $_GET['positionReportsTo'];