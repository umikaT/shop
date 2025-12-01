<?php
session_start();
require '../php/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT role FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user || $user['role'] !== 'admin') {
    die("Nie masz uprawnień do tego panelu.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = $_POST['product_name'];
    $price = $_POST['product_price'];
    $category = $_POST['product_category'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];

    $stmt = $pdo->prepare("INSERT INTO products (product_name, product_price, product_category, stock, description) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $price, $category, $stock, $description]);
    header("Location: admin.php");
    exit;
}

if (isset($_GET['delete_product'])) {
    $pid = $_GET['delete_product'];
    $stmt = $pdo->prepare("DELETE FROM products WHERE product_id = ?");
    $stmt->execute([$pid]);
    header("Location: admin.php");
    exit;
}

$products = $pdo->query("SELECT p.product_id, p.product_name, p.product_price, c.category_name, p.stock, p.description FROM products p LEFT JOIN categories c ON p.product_category = c.category_id")->fetchAll(PDO::FETCH_ASSOC);

$users = $pdo->query("SELECT user_id, username, email, first_name, last_name FROM users")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Panel Admina</title>
    <link rel="stylesheet" href="../admin/admin.css">
    
</head>
<body>
<div class="admin-container">
    <h1>Panel Administratora</h1>
    <a class="logout-btn" href="../logout.php">Wyloguj się</a>

    <section class="section">
        <h2>Dodaj nowy produkt</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="product_name" placeholder="Nazwa produktu" required>
            <input type="number" name="product_price" placeholder="Cena" required>
            <input type="number" name="product_category" placeholder="ID kategorii" required>
            <input type="number" name="stock" placeholder="Ilość w magazynie" required>
            <textarea name="description" placeholder="Opis"></textarea>
            <label>Zdjęcie z komputera:</label>
            <input type="file" name="product_image" accept="image/*">
            <label>Lub link do zdjęcia:</label>
            <input type="text" name="product_image_link" placeholder="https://...">
            <button type="submit" name="add_product">Dodaj produkt</button>
        </form>
    </section>



    <section class="section">
        <h2>Produkty</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nazwa</th>
                    <th>Cena</th>
                    <th>Kategoria</th>
                    <th>Stock</th>
                    <th>Opis</th>
                    <th>Akcje</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $p): ?>
                <tr>
                    <td><?= $p['product_id'] ?></td>
                    <td><?= htmlspecialchars($p['product_name']) ?></td>
                    <td><?= $p['product_price'] ?></td>
                    <td><?= htmlspecialchars($p['category_name']) ?></td>
                    <td><?= $p['stock'] ?></td>
                    <td><?= htmlspecialchars($p['description']) ?></td>
                    <td>
                        <a href="admin.php?delete_product=<?= $p['product_id'] ?>" class="delete-btn">Usuń</a>
                    
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <section class="section">
        <h2>Użytkownicy</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nazwa użytkownika</th>
                    <th>Email</th>
                    <th>Imię</th>
                    <th>Nazwisko</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= $u['user_id'] ?></td>
                    <td><?= htmlspecialchars($u['username']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><?= htmlspecialchars($u['first_name']) ?></td>
                    <td><?= htmlspecialchars($u['last_name']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</div>
</body>
</html>
