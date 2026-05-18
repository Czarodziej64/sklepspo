<?php
session_start();
require 'config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    die("Brak dostępu");
}

if (isset($_POST['change_role'])) {
    $id = $_POST['id'];
    $role = $_POST['role'];

    $stmt = mysqli_prepare($conn, "UPDATE users SET role=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "si", $role, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

$result = mysqli_query($conn, "SELECT * FROM users");
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<title>Użytkownicy</title>
<style>
body{font-family:Arial;margin:0}
header{background:#f2f2f2;padding:15px}
.container{padding:20px}
table{width:100%;border-collapse:collapse}
th,td{border:1px solid #ccc;padding:8px}
select,button{padding:6px}
</style>
</head>
<body>

<header>
<h1>Użytkownicy</h1>
<a href="dashboard.php">Powrót</a>
</header>

<div class="container">

<table>
<tr>
<th>ID</th>
<th>Imię</th>
<th>Email</th>
<th>Rola</th>
<th>Zmiana</th>
</tr>

<?php foreach($users as $u): ?>
<tr>
<td><?= $u['id'] ?></td>
<td><?= htmlspecialchars($u['name']) ?></td>
<td><?= htmlspecialchars($u['email']) ?></td>
<td><?= $u['role'] ?></td>
<td>
<form method="POST">
<input type="hidden" name="id" value="<?= $u['id'] ?>">
<select name="role">
<option value="client" <?= $u['role']=='client'?'selected':'' ?>>client</option>
<option value="manager" <?= $u['role']=='manager'?'selected':'' ?>>manager</option>
<option value="supplier" <?= $u['role']=='supplier'?'selected':'' ?>>supplier</option>
<option value="admin" <?= $u['role']=='admin'?'selected':'' ?>>admin</option>
</select>
<button type="submit" name="change_role">Zmień</button>
</form>
</td>
</tr>
<?php endforeach; ?>

</table>

</div>

</body>
</html>