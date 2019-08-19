<?php
require_once 'Connect.php';
$conn = new Connect();
$dbconn = $conn->conn();
if(!$dbconn->isConnected()){
	$response = array('status' => -1, 'errorMessage' => $dbconn->errorMsg());
	echo json_encode($response);
	exit(1);
}
$where = '1=1';
if(isset($_REQUEST['category'])){
	$qStr = $dbconn->qStr($_REQUEST['category'], true);
	$where .= " and l.category like '%{$_REQUEST['category']}%' ";
}
if(isset($_REQUEST['lookupName'])){
	$qStr = $dbconn->qStr($_REQUEST['lookupName'], true);
	$where .= " and l.lookupName like '%{$_REQUEST['lookupName']}%' ";
}

if(isset($_REQUEST['itemName'])){
	$qStr = $dbconn->qStr($_REQUEST['itemName'], true);
	$where .= " and ld.itemName like '%{$_REQUEST['itemName']}%' ";
}
if(isset($_REQUEST['itemDetail'])){
	$qStr = $dbconn->qStr($_REQUEST['itemDetail'], true);
	$where .= " and ld.itemDetail like '%{$_REQUEST['itemDetail']}%' ";
}
$sql = "SELECT l.category, l.lookupID, l.lookupName, l.lookupRef, ld.lookupItemID, ld.itemName, ld.itemDetail, ld.itemRef
FROM Lookup l inner join LookupData ld on l.lookupID = ld.lookupID where {$where} order by l.lookupName, ld.itemName;";
// echo "/* {$sql} */";
$response = $dbconn->getAll($sql);
if(!$response){
	$response = array('status' => -4, 'errors' => array('errorMessage' => $dbconn->errorMsg()));
}
echo json_encode($response);
$dbconn->close();
