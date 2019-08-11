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
if(isset($_REQUEST['itemID_fk'])){
    $where .= ' and itemID_fk = ' . intval($_REQUEST['itemID_fk']);
}
$sql = "select * from categories2 where $where order by category";
$response = $dbconn->getAll($sql);
if(!$response){
    $response = array();
}
echo json_encode($response);
$dbconn->close();
?>
