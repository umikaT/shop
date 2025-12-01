<?php
session_start();
require '../php/config.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: ../login.html");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: admin.php");
    exit;
}
$stmt = $pdo->prepare("SELECT * FROM products WHERE product_id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    header("Location: admin.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['product_name'];
    $price = $_POST['product_price'];
    $category = $_POST['product_category'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];

    $imagePath = $product['image'];
    if (!empty($_POST['image_url'])) {
        $imagePath = $_POST['image_url'];
    }

    if (!empty($_FILES['image_file']['name'])) {
        $targetDir = "../assets/images/products/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
        $fileName = basename($_FILES["image_file"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        if (move_uploaded_file($_FILES["image_file"]["tmp_name"], $targetFilePath)) {
            $imagePath = $targetFilePath;
        }
    }

    $stmt = $pdo->prepare("UPDATE products SET product_name=?, product_price=?, product_category=?, stock=?, description=?, image=? WHERE product_id=?");
    $stmt->execute([$name, $price, $category, $stock, $description, $imagePath, $id]);

    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Edytuj produkt</title>
    <link rel="stylesheet" href="../styl.css">
    <link rel="stylesheet" href="../styl2.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h2 { text-align: center; margin-bottom: 20px; }
        form { max-width: 600px; margin-left: auto; margin-right: auto; }
        input, textarea { width: 100%; padding: 8px; margin: 5px 0; box-sizing: border-box; }
        button { padding: 10px 20px; margin-top: 10px; cursor: pointer; }
        img { max-height: 100px; display: block; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h2>Edytuj produkt</h2>

    <form action="" method="POST" enctype="multipart/form-data">
        <label>Nazwa produktu:</label>
        <input type="text" name="product_name" value="<?= htmlspecialchars($product['product_name']) ?>" required>

        <label>Cena:</label>
        <input type="number" name="product_price" value="<?= $product['product_price'] ?>" required>

        <label>Kategoria (ID):</label>
        <input type="number" name="product_category" value="<?= $product['product_category'] ?>" required>

        <label>Ilość:</label>
        <input type="number" name="stock" value="<?= $product['stock'] ?>" required>

        <label>Opis:</label>
        <textarea name="description"><?= htmlspecialchars($product['description']) ?></textarea>

        <label>Aktualne zdjęcie:</label>
        <?php if ($product['image']): ?>
            <img src="<?= htmlspecialchars($product['image']) ?>" alt="zdjęcie produktu">
        <?php endif; ?>

        <label>Nowe zdjęcie z URL:</label>
        <input type="text" name="image_url" placeholder="Wklej link do zdjęcia">

        <label>Lub wybierz plik:</label>
        <input type="file" name="image_file">

        <button type="submit">Zapisz zmiany</button>
    </form>

    <p><a href="admin.php">Powrót do panelu admina</a></p>
</body>
</html>
