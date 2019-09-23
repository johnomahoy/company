<?php
//http://scaleupmarketing.asia/httpscripts/kc477/linkcontact/company.php 

//Get the data
$api = $_REQUEST['app'];
$key = $_REQUEST['key'];
function apiLog(){
	return array($GLOBALS["api"].':'.$GLOBALS["api"].':i:'.$GLOBALS["key"].':This is the connection for '.$GLOBALS["api"].'.infusionsoft.com'); 
}

require_once("isdk.php");
$app = new iSDK;
//Test Connection
if( $app->cfgCon("kc477"))
{ //echo "You are connected"; 
	// echo ' You are connected';
	$contactId = $_REQUEST['contactId'];
	// $contactId = '9189'; // preset value for testing
	$returnFields = array('Id');
	$conDat = $app->dsLoad("Contact", $contactId, $returnFields); 
	// $company = $conDat['FirstName'].$conDat['LastName'];
	$company = $_REQUEST['company']; 
	// echo $conDat['Id'];
	$returnFields = array('AccountId','Company');
	$query = array('Company' => $company);
	//insert the data into the contact custom fields
	$contacts = $app->dsQuery("Contact",10,0,$query,$returnFields);
	// print_r($contacts);
if ($contacts){ //if account eaxis
	foreach ($contacts as $contacts){
		$compID = $contacts['AccountId'];
		$compName = $contacts['Company'];
		break;
	}

	//Insert into contact
	$conDat = array('AccountId' => $compID, 'Company' => $compName);
	$conID = $app->updateCon($contactId, $conDat);
	 
}else{//Add company to contact
	$data = array('Company' => $company); 
	$added = $app->dsAdd("Contact", $data);  
 	
	$returnFields = array('Id');
	$conData = $app->dsLoad("Contact", $added, $returnFields); 
	// $company = $conData['FirstName'].$conData['LastName'];
	$company = $_REQUEST['company'];
	//Update the contact
	$conDat = array('AccountId' => $added, 'Company' => $company); 
	$conID = $app->updateCon($added, $conDat); 
	
	$conDat = array('AccountId' => $added, 'Company' => $company);
	$conID = $app->updateCon($contactId, $conDat); 
 
}

 
}
