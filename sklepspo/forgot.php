<?php
require 'config.php';

if(isset($_POST['reset'])) {

    $email = $_POST['email'];
    $oldPassword = $_POST['old_password'];
    $newPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if($user) {

        if(password_verify($oldPassword, $user['password'])) {

            $update = "UPDATE users SET password='$newPassword' WHERE email='$email'";
            mysqli_query($conn, $update);

            echo "Hasło zmienione! <br><br>";
            echo "<a href='login.php'>Przejdź do logowania</a>";

        } else {
            echo "Stare hasło jest niepoprawne!";
        }

    } else {
        echo "Nie znaleziono użytkownika!";
    }
}
?>

<h1>Zmiana hasła</h1>

<form method="POST">

    <input type="email" name="email" placeholder="Email" required>
    <br><br>

    <input type="password" name="old_password" placeholder="Stare hasło" required>
    <br><br>

    <input type="password" name="new_password" placeholder="Nowe hasło" required>
    <br><br>

    <button type="submit" name="reset">
        Zmień hasło
    </button>

</form>