<?php
session_start();
require '../php/config.php';

$cart = $_SESSION['cart'] ?? [];
$discount = $_SESSION['discount'] ?? 0;

$products = [];
$total = 0;

if ($cart) {
    $ids = implode(",", array_keys($cart));
    $query = $pdo->query("SELECT * FROM products WHERE product_id IN ($ids)");
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $row['quantity'] = $cart[$row['product_id']];
        $row['sum'] = $row['quantity'] * $row['product_price'];
        $total += $row['sum'];
        $products[] = $row;
    }
}

$discountAmount = $total * $discount;
$finalTotal = $total - $discountAmount;
?>
<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<title>Koszyk</title>
<link rel="stylesheet" href="../styl.css">
<link rel="stylesheet" href="../styl2.css">
<style>
.cart-container { 
    max-width: 1100px; 
    margin: 40px auto; 
    padding: 20px; 
}
.cart-item { 
    display: flex; 
    align-items: center; 
    
    gap: 20px; 
    padding: 15px 0; 
    border-bottom: 1px solid #ddd; 
}
.cart-item img 
{ 
    width: 110px; 
    height: 110px; 
    object-fit: cover; 
    border-radius: 6px; 
}
.cart-item h3 
{ 
    margin: 0; 
}
.cart-qty input 
{ 
    width: 50px; padding: 5px; text-align: center; 
}
.remove-btn 
{ 
    background: crimson; 
    color: white; 
    padding: 7px 10px; 
    border-radius: 4px; 
    cursor: pointer; 
}
.checkout-box { 
    margin-top: 25px;
     text-align: right; 
    }

.checkout-btn { 
    background: black; 
    color: white; 
    padding: 12px 25px; 
    text-decoration: none; 
    border-radius: 5px; 
}
.discount-box {
    margin-top: 20px;
    padding: 15px;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 6px;
    display: flex;
    gap: 10px;
    align-items: center;
}
.discount-box input {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 200px;
}
.discount-box button {
    padding: 10px 20px;
    background-color: #333;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
.discount-box button:hover {
    background-color: #555;
}
</style>
<script>
function updateCart(id, qty) {
    fetch('../php/cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'action=update&id=' + id + '&quantity=' + qty
    }).then(response => response.json())
      .then(data => location.reload());
}

function removeItem(id) {
    fetch('../php/cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'action=remove&id=' + id
    }).then(response => response.json())
      .then(data => location.reload());
}

function applyDiscount() {
    const code = document.getElementById('discount_code').value;
    fetch('../php/cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'action=apply_discount&discount_code=' + code
    }).then(response => response.json())
      .then(data => location.reload());
}
</script>
</head>
<body>
<div class="menu">
    <div class="lewomenu">
        <a href="../glowna.php">Home</a>
        <a href="koszulki.php">Koszulki</a>
        <a href="../rozmiary.html">Tabele rozmiarów</a>
        <a href="../kontakt.html">Kontakt</a>
    </div>
    <img class="logo" src="../../assets/zdjecia/logo.png" height="50">
    <div class="prawomenu">
        <a href="#"><i class="fa-solid fa-magnifying-glass"></i></a>
        <a href="login.html"><i class="fa-regular fa-user"></i></a>
        <a href="koszyk.php"><i class="fa-solid fa-cart-shopping"></i></a>
    </div>
</div>

<div class="cart-container">
<h2>Twój koszyk</h2>
<?php if (!$products): ?>
    <p>Koszyk jest pusty.</p>
<?php else: ?>
    <?php foreach ($products as $p): ?>
        <div class="cart-item">
            <img src="<?= htmlspecialchars($p['product_image']) ?>" alt="<?= htmlspecialchars($p['product_name']) ?>">
            <div style="flex:1;">
                <h3><?= htmlspecialchars($p['product_name']) ?></h3>
                <p>Cena: <b><?= $p['product_price'] ?> PLN</b></p>
                <p>Suma: <b><?= $p['sum'] ?> PLN</b></p>
            </div>
            <div class="cart-qty">
                <input type="number" value="<?= $p['quantity'] ?>" oninput="updateCart(<?= $p['product_id'] ?>, this.value)">
            </div>
            <button class="remove-btn" onclick="removeItem(<?= $p['product_id'] ?>)">Usuń</button>
        </div>
    <?php endforeach; ?>

    <div class="discount-box">
        <input type="text" id="discount_code" placeholder="Kod rabatowy">
        <button onclick="applyDiscount()">Zastosuj</button>
    </div>

    <div class="checkout-box">
        <h3>Łącznie przed rabatem: <?= number_format($total, 2) ?> PLN</h3>
        <h3>Łącznie po rabacie: <?= number_format($finalTotal, 2) ?> PLN</h3>
        <a class="checkout-btn" href="#">Przejdź do płatności</a>
    </div>
<?php endif; ?>
</div>
</body>
</html>
