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
if(isset($_REQUEST['class'])){
    $qStr = $dbconn->qStr($_REQUEST['class'], true);
    $where .= " and class = $qStr ";
}
if(isset($_REQUEST['item_name'])){
    $qStr = $dbconn->qStr($_REQUEST['item_name'], true);
    $where .= " and item_name like '%{$_REQUEST['item_name']}%' ";
}
if(isset($_REQUEST['itemType'])){
    $qStr = $dbconn->qStr($_REQUEST['itemType'], true);
    $where .= " and itemType like '%{$_REQUEST['itemType']}%' ";
}
if(isset($_REQUEST['notes'])){
    $qStr = $dbconn->qStr($_REQUEST['notes'], true);
    $where .= " and notes like '%{$_REQUEST['notes']}%' ";
}
if(isset($_REQUEST['type'])){
    $qStr = $dbconn->qStr($_REQUEST['type'], true);
    $where .= " and type = $qStr ";
}
if(isset($_REQUEST['legality_class'])){
    $where .= ' and legality_class = ' . intval($_REQUEST['legality_class']);
}
if(isset($_REQUEST['base_points'])){
    $where .= ' and base_points = ' . intval($_REQUEST['base_points']);
}
if(isset($_REQUEST['points'])){
    $where .= ' and points = ' . intval($_REQUEST['points']);
}

$sql = "select * from items2 where $where order by item_name";
echo '/*' . $sql . '*/';
$response = $dbconn->getAll($sql);
if(!$response){
    $response = array();
}
echo json_encode($response);
$dbconn->close();
