<?php
include("dbconnection.php");
$connsql = dbconnection();

if ($connsql->connect_error) {
    die("Connection failed: " . $connsql->connect_error);
}

if (isset($_POST["id"], $_POST["pass"], $_POST["role"])) {
    $id = mysqli_real_escape_string($connsql, $_POST["id"]);
    $pass = mysqli_real_escape_string($connsql, $_POST["pass"]);
    $role = mysqli_real_escape_string($connsql, $_POST["role"]);

    $sql = "UPDATE login SET pass = '$pass', role = '$role' WHERE id = $id";

    if ($connsql->query($sql) === TRUE) {
        echo "User data updated successfully";
    } else {
        echo "Error updating user data: " . $connsql->error;
    }
} else {
    echo "Missing or incomplete parameters in the POST request.";
}

$connsql->close();
?>
