<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "sklepspo";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Błąd połączenia: " . mysqli_connect_error());
}

?>