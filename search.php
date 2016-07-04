<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'alvahugh1';
$schema = 'gurps';
$mysqli = new mysqli($dbhost,$dbuser,$dbpass,$schema);
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

$output = "";
$query = "select * from items where item_name like '%ee%'";
if ($result = $mysqli->query($query)) {
    $output = "<table border='1'>";
    while ($row = $result->fetch_assoc()) {
        $output .= "<tr>";
        $output .= '<td>' . $row["itemID"] . '</td>';
        $output .= '<td>' . $row["class"] . '</td>';
        $output .= '<td>' . $row["source"] . '</td>';
        $output .= '<td>' . $row["item_name"] . '</td>';
        $output .= '<td>' . $row["specialization"] . '</td>';
        $output .= '<td>' . $row["points"] . '</td>';
        $output .= '<td>' . $row["reference"] . '</td>';
        $output .= '<td>' . $row["difficulty"] . '</td>';
        $output .= '<td>' . $row["type"] . '</td>';
        $output .= '<td>' . $row["base_points"] . '</td>';
        $output .= '<td>' . $row["quantity"] . '</td>';
        $output .= '<td>' . $row["tech_level"] . '</td>';
        $output .= '<td>' . $row["legality_class"] . '</td>';
        $output .= '<td>' . $row["value"] . '</td>';
        $output .= '<td>' . $row["notes"] . '</td>';
        $output .= '<td>' . $row["levels"] . '</td>';
        $output .= '<td>' . $row["cr"] . '</td>';
        $output .= '<td>' . $row["points_per_level"] . '</td>';
        $output .= '<td>' . $row["weight"] . '</td>';
        $output .= "</tr>";
    }
    $result->free();
    $output .= "</table>";
}else{
    echo("$sql" . PHP_EOL);
    echo($mysqli->error . PHP_EOL);
}
echo($output . PHP_EOL);
$mysqli->close();
?>
