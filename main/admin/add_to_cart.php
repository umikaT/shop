<?php
session_start();
require '../php/config.php'; 

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cart = &$_SESSION['cart'];

$id = intval($_POST['id'] ?? 0);
$quantity = intval($_POST['quantity'] ?? 1);


if ($id > 0) {
    if (isset($cart[$id])) {
        $cart[$id] += $quantity; 
    } else {
        $cart[$id] = $quantity;
    }
    echo json_encode(['success' => true, 'cart' => $cart]);
} else {
    echo json_encode(['success' => false, 'message' => 'Niepoprawny produkt']);
}
