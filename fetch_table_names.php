<?php
include("dbconnection.php");
$connsql = dbconnection();

if ($connsql->connect_error) {
    die("Connection failed: " . $connsql->connect_error);
}

$sql = "SHOW TABLES";
$result = $connsql->query($sql);

$tableNames = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_row()) {
        $tableNames[] = $row[0];
    }
}

echo json_encode($tableNames);

$connsql->close();
?>
