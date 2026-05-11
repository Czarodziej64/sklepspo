<?php
session_start();

require 'config.php';

if(isset($_SESSION['user'])) {

    echo "<h2>Witaj " . $_SESSION['user'] . "</h2>";

    echo "<a href='logout.php'>Wyloguj</a>";

} else {

    echo "<a href='login.php'>Zaloguj się</a>";
    echo "<br>";
    echo "<a href='register.php'>Rejestracja</a>";
}

echo "<h1>Sklep spożywczy</h1>";

$sql = "SELECT * FROM products";

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)) {

    echo "<div style='border:1px solid #ccc; padding:10px; margin:10px;'>";

    echo "<h2>" . $row['name'] . "</h2>";

    echo "<p>" . $row['description'] . "</p>";

    echo "<p>Cena: " . $row['price'] . " zł</p>";

    echo "</div>";
}
?>