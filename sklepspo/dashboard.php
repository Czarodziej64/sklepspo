<?php
session_start();
require 'config.php';

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}

$allowedRoles = ['admin','manager','supplier'];

if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    $stmt = mysqli_prepare($conn, "INSERT INTO products(name, price, quantity) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sdi", $name, $price, $quantity);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = mysqli_prepare($conn, "DELETE FROM products WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: dashboard.php");
    exit;
}

if (isset($_POST['group_delete']) && !empty($_POST['selected'])) {
    foreach ($_POST['selected'] as $id) {
        $stmt = mysqli_prepare($conn, "DELETE FROM products WHERE id=?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

$order = "name ASC";
if (isset($_GET['sort'])) {
    if ($_GET['sort'] == 'price_asc') $order = "price ASC";
    if ($_GET['sort'] == 'price_desc') $order = "price DESC";
    if ($_GET['sort'] == 'name_desc') $order = "name DESC";
}

$sql = "SELECT * FROM products ORDER BY $order";
$result = mysqli_query($conn, $sql);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<title>Dashboard</title>
<style>
body{margin:0;font-family:Arial}
header{background:#f2f2f2;padding:15px}
.container{display:flex}
nav{width:200px;background:#fafafa;padding:20px}
nav a{display:block;margin-bottom:10px;text-decoration:none}
main{flex:1;padding:20px}
table{width:100%;border-collapse:collapse}
th,td{border:1px solid #ccc;padding:8px}
input,button{padding:8px;width:100%;margin:5px 0}
</style>
</head>
<body>

<header>
<h1>Panel</h1>
</header>

<div class="container">

<nav>
<a href="index.php">Sklep</a>

<?php if($_SESSION['role'] == 'admin'): ?>
<a href="users.php">Użytkownicy</a>
<?php endif; ?>

<a href="logout.php">Wyloguj</a>
</nav>

<main>

<h2>Produkty</h2>

<form method="POST">
<input type="text" name="name" placeholder="Nazwa" required>
<input type="number" step="0.01" name="price" placeholder="Cena" required>
<input type="number" name="quantity" placeholder="Ilość" required>
<button type="submit" name="add_product">Dodaj</button>
</form>

<form method="POST">
<table>
<tr>
<th></th>
<th>ID</th>
<th>Nazwa</th>
<th>Cena</th>
<th>Ilość</th>
<th>Akcja</th>
</tr>

<?php foreach($products as $p): ?>
<tr>
<td><input type="checkbox" name="selected[]" value="<?= $p['id'] ?>"></td>
<td><?= $p['id'] ?></td>
<td><?= htmlspecialchars($p['name']) ?></td>
<td><?= $p['price'] ?></td>
<td><?= $p['quantity'] ?></td>
<td><a href="?delete=<?= $p['id'] ?>">Usuń</a></td>
</tr>
<?php endforeach; ?>

</table>
<button type="submit" name="group_delete">Usuń zaznaczone</button>
</form>

</main>
</div>

</body>
</html>