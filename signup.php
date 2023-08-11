<?php
include("dbconnection.php");
$connsql = dbconnection();

if (isset($_POST['login']) && isset($_POST['password'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Sprawdzenie, czy login jest unikalny
    $checkQuery = "SELECT * FROM `login` WHERE `login` = '$login'";
    $checkResult = mysqli_query($connsql, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // jeslu ustnieje juz taki login zwroc blad
        $arr["success"] = "false";
        $arr["message"] = "Login already exists. Please choose a different login.";
    } else {
        // dodaj uzytkownika poprzez login
        $query = "INSERT INTO `login`(`login`, `pass`) VALUES ('$login','$password')";
        $exe = mysqli_query($connsql, $query);

        if ($exe) {
            $arr["success"] = "true";
        } else {
            $arr["success"] = "false";
            $arr["message"] = "Failed to insert user data.";
        }
    }
} else {
    $arr["success"] = "false";
    $arr["message"] = "Please provide login and password.";
}

header('Content-Type: application/json');
echo json_encode($arr);
?>
