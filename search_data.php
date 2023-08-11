<?php
include("dbconnection.php");
$connsql = dbconnection();

if ($connsql->connect_error) {
    die("Connection failed: " . $connsql->connect_error);
}

// Ustawienie nag?ówka odpowiedzi na JSON
header("Content-Type: application/json");

// Pobranie nazw wszystkich tabel
$tablesSql = "SHOW TABLES";
$tablesResult = $connsql->query($tablesSql);

$tables = array();
if ($tablesResult->num_rows > 0) {
    while ($tableRow = $tablesResult->fetch_assoc()) {
        $tableName = reset($tableRow); // Pobranie nazwy tabeli z wyniku zapytania
        $columnsSql = "SHOW COLUMNS FROM $tableName";
        $columnsResult = $connsql->query($columnsSql);

        $columns = array();
        if ($columnsResult->num_rows > 0) {
            while ($columnRow = $columnsResult->fetch_assoc()) {
                $columns[] = $columnRow['Field'];
            }
        }

        $dataSql = "SELECT * FROM $tableName";
        $dataResult = $connsql->query($dataSql);

        $data = array();
        if ($dataResult->num_rows > 0) {
            while ($dataRow = $dataResult->fetch_assoc()) {
                $data[] = $dataRow;
            }
        }

        $tables[] = array(
            "table" => $tableName,
            "columns" => $columns,
            "data" => $data
        );
    }
}

echo json_encode($tables);

$connsql->close();
?>
