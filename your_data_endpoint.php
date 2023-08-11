<?php
include("dbconnection.php");
$connsql = dbconnection();

if ($connsql->connect_error) {
    die("Connection failed: " . $connsql->connect_error);
}

// Ustawienie nag?ówka odpowiedzi na JSON
header("Content-Type: application/json");

$searchPhrase = $_GET['search']; // Pobranie przekazanej frazy
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

// Tworzenie zapytania SQL z uwzgl?dnieniem frazy
$dataSql = "SELECT * FROM $tableName WHERE column_name LIKE '%$searchPhrase%'";
$dataResult = $connsql->query($dataSql);

$data = array();
if ($dataResult->num_rows > 0) {
    while ($dataRow = $dataResult->fetch_assoc()) {
        $data[] = $dataRow;
    }
}

echo json_encode($data);

$connsql->close();
?>
