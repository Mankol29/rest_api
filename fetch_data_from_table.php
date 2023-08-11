<?php
include("dbconnection.php");
$connsql = dbconnection();

if ($connsql->connect_error) {
    die("Connection failed: " . $connsql->connect_error);
}

$tableName = isset($_POST['table_name']) ? $_POST['table_name'] : '';

if (empty($tableName)) {
    die("Table name not provided.");
}

// Escape the table name to prevent SQL injection
$tableName = mysqli_real_escape_string($connsql, $tableName);

// Pobierz nazwy kolumn z tabeli
$columns = array();
$sqlColumns = "SHOW COLUMNS FROM $tableName";
$resultColumns = $connsql->query($sqlColumns);

if ($resultColumns) {
    while ($row = $resultColumns->fetch_assoc()) {
        $columns[] = $row["Field"];
    }
} else {
    die("Error retrieving columns: " . $connsql->error);
}

// Pobierz dane z tabeli
$sqlData = "SELECT * FROM $tableName";
$resultData = $connsql->query($sqlData);

$tableData = array();
if ($resultData) {
    while ($row = $resultData->fetch_assoc()) {
        $tableData[] = $row;
    }
} else {
    die("Error retrieving data: " . $connsql->error);
}

$response = array(
    "columns" => $columns,
    "data" => $tableData
);

echo json_encode($response);

$connsql->close();
?>
