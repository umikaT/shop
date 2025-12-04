<?php
session_start();
require 'config.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cart = &$_SESSION['cart'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = intval($_POST['id'] ?? 0);
    $quantity = intval($_POST['quantity'] ?? 0);
    $discountCode = $_POST['discount_code'] ?? '';

    if ($action === 'update' && isset($cart[$id])) {
        if ($quantity > 0) {
            $cart[$id] = $quantity;
        } else {
            unset($cart[$id]);
        }
    }

    if ($action === 'remove' && isset($cart[$id])) {
        unset($cart[$id]);
    }

    if ($action === 'apply_discount') {
        if (strtolower(trim($discountCode)) === 'mateusz10') {
            $_SESSION['discount'] = 0.1; // 10% zniżki
        } else {
            $_SESSION['discount'] = 0;
        }
    }

    echo json_encode(['success' => true]);
    exit;
}
?>
