<?php
session_start();
require '../php/config.php';

$categories = $pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);

$where = [];
$params = [];

if (!empty($_GET['category'])) {
    $where[] = "p.product_category = ?";
    $params[] = $_GET['category'];
}

if (!empty($_GET['search'])) {
    $where[] = "p.product_name LIKE ?";
    $params[] = "%" . $_GET['search'] . "%";
}

$order = "p.product_name ASC";
if (!empty($_GET['sort'])) {
    if ($_GET['sort'] == "price_asc") $order = "p.product_price ASC";
    if ($_GET['sort'] == "price_desc") $order = "p.product_price DESC";
}

$sql = "SELECT p.product_id, p.product_name, p.product_price, p.product_image, c.category_name 
        FROM products p 
        LEFT JOIN categories c ON p.product_category = c.category_id";

if ($where) $sql .= " WHERE " . implode(" AND ", $where);
$sql .= " ORDER BY $order";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Koszulki</title>
    <link rel="stylesheet" href="../styl.css">
    <link rel="stylesheet" href="../styl2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
    .filter-container {
        width: 100%;
        max-width: 1200px;
        margin: 40px auto;
        padding: 10px;
        display: flex;
        justify-content: center;
    }

    .filter-container form {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .filter-container input,
    .filter-container select,
    .filter-container button {
        padding: 12px 15px;
        font-size: 15px;
        border: 1px solid #a1a1a1;
        border-radius: 4px;
    }

    .filter-container button {
        background: black;
        color: white;
        cursor: pointer;
        transition: 0.3s;
    }

    .filter-container button:hover {
        background: #333;
    }

    .products-grid {
        width: 100%;
        max-width: 1350px;
        margin: 30px auto 60px;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 35px;
    }

    .product-card {
        background: #fff;
        border-radius: 10px;
        border: 1px solid #e3e3e3;
        padding: 10px;
        text-align: center;
        transition: 0.3s ease;
    }

    .product-card:hover {
        transform: scale(1.03);
        box-shadow: 0 10px 22px rgba(0,0,0,0.15);
    }

    .product-card img {
        width: 100%;
        height: 330px;
        object-fit: cover;
    }

    .product-card h3 {
        font-size: 18px;
        margin: 10px 0 4px;
    }

    .product-card p {
        margin: 3px 0;
    }

    .add-cart-btn {
        margin-top: 8px;
        background: #000;
        color: #fff;
        padding: 10px 15px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        width: 100%;
        font-weight: 600;
        transition: background 0.18s ease, transform 0.12s ease;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }
    .add-cart-btn:hover { background: #333; transform: translateY(-2px); }
    </style>

    <script>
    function addToCart(id) {
        fetch('add_to_cart.php', { 
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'id=' + id + '&quantity=1'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Produkt dodany do koszyka!');
            } else {
                alert('Wystąpił błąd podczas dodawania produktu.');
            }
        }).catch(error => {
            console.error('Błąd:', error);
            alert('Wystąpił błąd podczas dodawania produktu.');
        });
    }
    </script>
</head>
<body>

<div class="dostawa">
    <p id="dostawa">DARMOWA DOSTAWA OD 300 PLN</p>
</div>

<div class="menu">
    <div class="lewomenu">
        <a href="../glowna.php">Home</a>
        <a href="#">Koszulki</a>
        <a href="../rozmiary.html">Tabele rozmiarów</a>
        <a href="../kontakt.html">Kontakt</a>
    </div>

    <img class="logo" src="../../assets/zdjecia/logo.png" height="50">

    <div class="prawomenu">
        <a href="login.html"><i class="fa-regular fa-user"></i></a>
        <a href="koszyk.php"><i class="fa-solid fa-cart-shopping"></i></a>
    </div>
</div>

<div class="filter-container">
    <form method="GET">
        <input type="text" name="search" placeholder="Szukaj produktu..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        
        <select name="category">
            <option value="">Wszystkie kategorie</option>
            <?php foreach($categories as $cat): ?>
                <option value="<?= $cat['category_id'] ?>" <?= (!empty($_GET['category']) && $_GET['category']==$cat['category_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['category_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="sort">
            <option value="">Sortowanie</option>
            <option value="price_asc" <?= (!empty($_GET['sort']) && $_GET['sort']=='price_asc')?'selected':'' ?>>Cena rosnąco</option>
            <option value="price_desc" <?= (!empty($_GET['sort']) && $_GET['sort']=='price_desc')?'selected':'' ?>>Cena malejąco</option>
        </select>

        <button type="submit">Filtruj</button>
    </form>
</div>

<div class="products-grid">
    <?php foreach($products as $p): ?>
        <div class="product-card">
            <img src="<?= htmlspecialchars($p['product_image']) ?>" alt="<?= htmlspecialchars($p['product_name']) ?>">
            <h3><?= htmlspecialchars($p['product_name']) ?></h3>
            <p><?= $p['product_price'] ?> PLN</p>
            <p>Kategoria: <?= htmlspecialchars($p['category_name']) ?></p>
            <button class="add-cart-btn" onclick="addToCart(<?= $p['product_id'] ?>)">
                Dodaj do koszyka
            </button>
        </div>
    <?php endforeach; ?>

    <?php if (count($products) == 0): ?>
        <p style="text-align:center; width:100%;">Brak produktów spełniających kryteria wyszukiwania.</p>
    <?php endif; ?>
</div>

<footer>
    <p>&copy; 2025 Copyright Harry Potter</p>
</footer>

</body>
</html>
