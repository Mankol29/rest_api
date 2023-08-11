<?php

function dbconnection()
{
    $connsql = mysqli_connect("localhost", "root", "","flutter_x_sql");
    return $connsql;
}

?>
