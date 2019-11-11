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
{
	$contactId = $_REQUEST['contactId'];

	$returnFields = array('Id');
	$conDat = $app->dsLoad("Contact", $contactId, $returnFields);

	$company = $_REQUEST['company'];

	$returnFields = array('AccountId','Company');
	$query = array('Company' => $company);

	$contacts = $app->dsQuery("Contact",10,0,$query,$returnFields);

if ($contacts){
	foreach ($contacts as $contacts){
		$compID = $contacts['AccountId'];
		$compName = $contacts['Company'];
		break;
	}


	$conDat = array('AccountId' => $compID, 'Company' => $compName);
	$conID = $app->updateCon($contactId, $conDat);

}else{
	$data = array('Company' => $company);
	$added = $app->dsAdd("Contact", $data);

	$returnFields = array('Id');
	$conData = $app->dsLoad("Contact", $added, $returnFields);

	$company = $_REQUEST['company'];

	$conDat = array('AccountId' => $added, 'Company' => $company);
	$conID = $app->updateCon($added, $conDat);

	$conDat = array('AccountId' => $added, 'Company' => $company);
	$conID = $app->updateCon($contactId, $conDat);

}


}
