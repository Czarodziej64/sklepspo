<?php
session_start();
require 'config.php';
?>

<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<title>Sklep</title>
<style>
body{font-family:Arial;margin:0}
nav{background:#f2f2f2;padding:10px;display:flex;justify-content:space-between;align-items:center}
nav a{margin-right:15px;text-decoration:none;color:#000}
.products{padding:20px}
.card{border:1px solid #ccc;padding:10px;margin:10px}
</style>
</head>
<body>

<nav>
    <div>
        <a href="index.php"><b>Sklep spożywczy</b></a>
    </div>

    <div>
        <?php if(isset($_SESSION['user'])): ?>
            <span>Witaj <?= htmlspecialchars($_SESSION['user']) ?></span>

            <?php if(isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin','manager','supplier'])): ?>
                <a href="dashboard.php" style="font-weight:bold;">Panel administracyjny</a>
            <?php endif; ?>

            <a href="logout.php">Wyloguj</a>
        <?php else: ?>
            <a href="login.php">Zaloguj</a>
            <a href="register.php">Rejestracja</a>
        <?php endif; ?>
    </div>
</nav>

<div class="products">
    <h1>Sklep spożywczy</h1>

    <?php
    $sql = "SELECT * FROM products";
    $result = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_assoc($result)):
    ?>
        <div class="card">
            <h2><?= htmlspecialchars($row['name']) ?></h2>
            <p><?= htmlspecialchars($row['description'] ?? '') ?></p>
            <p>Cena: <?= $row['price'] ?> zł</p>
        </div>
    <?php endwhile; ?>

</div>

</body>
</html>