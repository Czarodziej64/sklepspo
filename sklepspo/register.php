<?php
require 'config.php';

if(isset($_POST['register'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users(name, email, password)
            VALUES('$name', '$email', '$password')";

    mysqli_query($conn, $sql);

    echo "Konto utworzone!";
}
?>

<h1>Rejestracja</h1>

<form method="POST">

    <input type="text" name="name" placeholder="Imię" required>
    <br><br>

    <input type="email" name="email" placeholder="Email" required>
    <br><br>

    <input type="password" name="password" placeholder="Hasło" required>
    <br><br>

    <button type="submit" name="register">
        Zarejestruj
    </button>

</form>