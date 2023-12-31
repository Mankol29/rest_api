<?php
include("dbconnection.php");
$connsql = dbconnection(); // Zmie? odpowiednio dane dost?powe do bazy danych

if ($connsql->connect_error) {
    die('B??d po??czenia: ' . $connsql->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tableName = $_POST['table_name'];
    $columnCount = intval($_POST['column_count']); // Ilo?? kolumn w tabeli

    // Tworzenie zapytania SQL do tworzenia tabeli
    $createTableSql = "CREATE TABLE IF NOT EXISTS `$tableName` (";
    
    // Dodawanie kolumny id jako integer z automatycznie generowanym kluczem g?�wnym
    $createTableSql .= "id INT AUTO_INCREMENT PRIMARY KEY,";

    for ($i = 0; $i < $columnCount; $i++) {
        $columnName = $_POST["column_name_$i"];
        $columnType = $_POST["column_type_$i"];

        $createTableSql .= "`$columnName` $columnType";

        if ($i < $columnCount - 1) {
            $createTableSql .= ", ";
        }
    }

    $createTableSql .= ")";
    
    if ($connsql->query($createTableSql) !== TRUE) {
        echo 'B??d podczas tworzenia tabeli: ' . $connsql->error;
    } else {
        echo 'Tabela zosta?a dodana.';
    }
}

$connsql->close();
?>
