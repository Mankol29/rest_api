<?php
include("dbconnection.php");
$connsql = dbconnection();

// Sprawdzenie po??czenia
if ($connsql->connect_error) {
    die("Connection failed: " . $$connsql->connect_error);
}

// Odczytanie danych przes?anych z ??dania POST
if (isset($_POST["table_name"]) && isset($_POST["record_id"])) {
    $tableName = $_POST["table_name"];
    $recordId = $_POST["record_id"];

    // Wykonanie zapytania do usuni?cia rekordu
    $sql = "DELETE FROM $tableName WHERE id = $recordId";

    if ($connsql->query($sql) === TRUE) {
        $response = ["message" => "Record deleted successfully"];
    } else {
        $response = ["error" => "Error deleting record: " . $connsql->error];
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