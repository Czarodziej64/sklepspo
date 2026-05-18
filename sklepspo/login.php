<?php
session_start();
require 'config.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            header("Location: index.php");
            exit;
        } else {
            $error = "Złe hasło";
        }
    } else {
        $error = "Użytkownik nie istnieje";
    }
}
?>

<h1>Logowanie</h1>

<?php if (!empty($error)) echo '<p style="color:red;">'.$error.'</p>'; ?>

<form method="POST">
    <input type="email" name="email" placeholder="Email" required>
    <br><br>
    <input type="password" name="password" placeholder="Hasło" required>
    <br><br>
    <button type="submit" name="login">Zaloguj</button>
</form>

<br>

<a href="register.php">Zarejestruj się</a><br>
<a href="forgot.php">Zapomniałeś hasła?</a>