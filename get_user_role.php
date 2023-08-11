<?php

include("dbconnection.php");
$connsql = dbconnection();

// Sprawdzenie po??czenia
if ($connsql->connect_error) {
    die("Connection failed: " . $connsql->connect_error);
}

// Przyjmujemy, ?e dane u?ytkownika zosta?y przekazane za pomoc? GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["login"])) {
        // Pobierz login u?ytkownika z parametru URL
        $login = $_GET["login"]; // Upewnij si?, ?e filtrowane i walidujesz to, aby unikn?? ataków SQL Injection

        // Przyk?adowe zapytanie do bazy danych
        $sql = "SELECT role FROM login WHERE login = '$login'";
        
        $result = $connsql->query($sql);

        if ($result->num_rows > 0) {
            // Pobierz rol? u?ytkownika
            $row = $result->fetch_assoc();
            $role = $row["role"];
            
            // Wy?lij rol? jako odpowied? w formacie JSON
            echo json_encode(array("role" => $role));
        } else {
            // B??d, u?ytkownik nie istnieje w bazie danych
            echo json_encode(array("error" => "User not found"));
        }
    } else {
        echo json_encode(array("error" => "Login not provided"));
    }
}

$connsql->close();

?>
