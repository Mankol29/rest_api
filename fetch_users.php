<?php
include("dbconnection.php");
$connsql = dbconnection();

if ($connsql->connect_error) {
    die("Connection failed: " . $connsql->connect_error);
}

$sql = "SELECT * FROM login";
$result = $connsql->query($sql);

$userData = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $userData[] = $row;
    }
}

echo json_encode($userData);

$connsql->close();
?>
