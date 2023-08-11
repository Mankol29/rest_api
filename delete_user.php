<?php
include("dbconnection.php");
$connsql = dbconnection();

if ($connsql->connect_error) {
    die("Connection failed: " . $connsql->connect_error);
}

// Check if "id" parameter is provided in the POST request
if (isset($_POST["id"])) {
    $id = $_POST["id"];

    // Escape the "id" to prevent SQL injection
    $id = mysqli_real_escape_string($connsql, $id);

    $sql = "DELETE FROM login WHERE id = $id";

    if ($connsql->query($sql) === TRUE) {
        echo "User data deleted successfully";
    } else {
        echo "Error deleting user data: " . $connsql->error;
    }
} else {
    echo "No 'id' parameter provided.";
}

$connsql->close();
?>
