<?php
include("dbconnection.php");
$connsql = dbconnection();

$arr = []; // Create an array to store the response data

if (isset($_POST['login']) && isset($_POST['password'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Poni?ej zak?adamy, ?e w Twojej bazie danych tabela z u?ytkownikami nazywa si? 'users'
    $query = "SELECT * FROM `login` WHERE `login` = '$login' AND `pass` = '$password'";
    $result = mysqli_query($connsql, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $arr["success"] = true;
        } else {
            $arr["success"] = false;
            $arr["message"] = "Invalid login or password";
        }
    } else {
        $arr["success"] = false;
        $arr["message"] = "Database query error";
    }
} else {
    $arr["success"] = false;
    $arr["message"] = "Please provide login and password";
}

// Set the response content type to JSON
header('Content-Type: application/json');
// Disable error reporting and notices to avoid any additional output
error_reporting(0);
// Print the response data as JSON
echo json_encode($arr);
?>
