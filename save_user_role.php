<?php
include("dbconnection.php");
$connsql = dbconnection();

if ($connsql->connect_error) {
    die("Connection failed: " . $connsql->connect_error);
}

// Receive data from the POST request
$login = isset($_POST["login"]) ? $_POST["login"] : '';
$password = isset($_POST["password"]) ? $_POST["password"] : '';
$role = isset($_POST["role"]) ? $_POST["role"] : '';

if (empty($login) || empty($password) || empty($role)) {
    echo json_encode(array("error" => "Missing or incomplete parameters in the POST request."));
} else {
    // Check if the user with the same login already exists
    $checkSql = "SELECT * FROM login WHERE login = '$login'";
    $checkResult = $connsql->query($checkSql);

    if ($checkResult->num_rows > 0) {
        echo json_encode(array("error" => "User with the same login already exists"));
    } else {
        // Insert data into the database
        $insertSql = "INSERT INTO login (login, pass, role) VALUES ('$login', '$password', '$role')";

        if ($connsql->query($insertSql) === TRUE) {
            echo json_encode(array("success" => "User role added successfully"));
        } else {
            echo json_encode(array("error" => "Error adding user role: " . $connsql->error));
        }
    }
}

$connsql->close();
?>
