<?php
include("dbconnection.php");
$connsql = dbconnection();

if ($connsql->connect_error) {
    die("Connection failed: " . $connsql->connect_error);
}

if (isset($_POST["table_name"], $_POST["data"])) {
    $tableName = mysqli_real_escape_string($connsql, $_POST["table_name"]);
    $jsonData = $_POST["data"];
    $data = json_decode($jsonData, true);

    if ($data === null) {
        echo json_encode(array("error" => "Invalid JSON data."));
        exit;
    }

    $columns = implode(",", array_keys($data));

    // Mapowanie warto?ci do odpowiednich typów kolumn
    $values = array_map(function ($value) use ($connsql) {
        if (is_numeric($value)) {
            return $value;
        } else {
            return "'" . mysqli_real_escape_string($connsql, $value) . "'";
        }
    }, array_values($data));

    $values = implode(",", $values);

    $sql = "INSERT INTO $tableName ($columns) VALUES ($values)";

    $response = array();

    if ($connsql->query($sql) === TRUE) {
        $response["message"] = "Data inserted successfully";
    } else {
        $response["error"] = "Error inserting data: " . $connsql->error;
    }

    echo json_encode($response);
} else {
    echo json_encode(array("error" => "Missing or incomplete parameters in the POST request."));
}

$connsql->close();
?>
