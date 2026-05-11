<?php
session_start();

require 'config.php';

if(isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";

    $result = mysqli_query($conn, $sql);

    $user = mysqli_fetch_assoc($result);

    if($user) {

        if(password_verify($password, $user['password'])) {

            $_SESSION['user'] = $user['name'];

            header("Location: index.php");
        }
        else {
            echo "Złe hasło";
        }

    } else {
        echo "Użytkownik nie istnieje";
    }
}
?>

<h1>Logowanie</h1>

<form method="POST">

    <input type="email" name="email" placeholder="Email" required>
    <br><br>

    <input type="password" name="password" placeholder="Hasło" required>
    <br><br>

    <button type="submit" name="login">
        Zaloguj
    </button>
    <a href="forgot.php">Nie pamiętasz hasła?</a>

</form>