<?php
include("dbconnection.php");
$connsql = dbconnection();

// Sprawdzenie po??czenia
if ($connsql->connect_error) {
    die("Connection failed: " . $connsql->connect_error);
}

// Odczytanie danych przes?anych z ??dania POST
if (isset($_POST["table_name"]) && isset($_POST["column_name"]) && isset($_POST["column_type"])) {
    $tableName = $_POST["table_name"];
    $columnName = $_POST["column_name"];
    $columnType = $_POST["column_type"];

    // Wykonanie zapytania do dodania nowej kolumny
    $sql = "ALTER TABLE $tableName ADD $columnName $columnType";

    if ($connsql->query($sql) === TRUE) {
        $response = ["message" => "Column added successfully"];
    } else {
        $response = ["error" => "Error adding column: " . $connsql->error];
    }
} else {
    $response = ["error" => "Missing required data"];
}

// Zamkni?cie po??czenia
$connsql->close();

// Wys?anie odpowiedzi w formacie JSON
header("Content-Type: application/json");
echo json_encode($response);
?>
