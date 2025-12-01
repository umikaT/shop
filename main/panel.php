<?php
session_start();
require 'php/config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT u.username, u.first_name, u.last_name, u.email, u.phone, a.country, a.street, a.home, a.flat
    FROM users u
    LEFT JOIN usersaddresses ua ON u.user_id = ua.user_id
    LEFT JOIN addresses a ON ua.address_id = a.address_id
    WHERE u.user_id = ?
");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $phone = trim($_POST['phone']);
    $country = trim($_POST['country']);
    $street = trim($_POST['street']);
    $home = trim($_POST['home']);
    $flat = trim($_POST['flat']);

    $stmt = $pdo->prepare("UPDATE users SET first_name=?, last_name=?, phone=? WHERE user_id=?");
    $stmt->execute([$first_name, $last_name, $phone, $user_id]);

    if ($user['country'] || $user['street'] || $user['home'] || $user['flat']) {
        $stmt = $pdo->prepare("UPDATE addresses a 
            JOIN usersaddresses ua ON a.address_id = ua.address_id
            SET country=?, street=?, home=?, flat=?
            WHERE ua.user_id=?");
        $stmt->execute([$country, $street, $home, $flat, $user_id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO addresses (country, street, home, flat) VALUES (?, ?, ?, ?)");
        $stmt->execute([$country, $street, $home, $flat]);
        $address_id = $pdo->lastInsertId();

        $stmt = $pdo->prepare("INSERT INTO usersaddresses (user_id, address_id) VALUES (?, ?)");
        $stmt->execute([$user_id, $address_id]);
    }

    header("Location: panel.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Panel użytkownika</title>
    <link rel="stylesheet" href="styl.css">
    <link rel="stylesheet" href="styl2.css">
    <style>
        .auth-container {
            width: 400px;
            margin: 50px auto;
            padding: 30px;
            background: #f8f8f8;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            font-family: Arial, sans-serif;
        }
        .auth-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .auth-container label {
            display: block;
            margin-top: 10px;
        }
        .auth-container input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        .auth-container button {
            margin-top: 20px;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
        }
        .auth-container button:hover {
            background-color: #0056b3;
        }
        .auth-container a {
            display: block;
            margin-top: 10px;
            text-align: center;
            text-decoration: none;
            color: #007bff;
        }
        .auth-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="auth-container">
    <h2>Panel użytkownika</h2>

    <form action="" method="POST">
        <label>Nazwa użytkownika:</label>
        <input type="text" value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
        <label>Imię:</label>
        <input type="text" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>">
        <label>Nazwisko:</label>
        <input type="text" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>">
        <label>Email:</label>
        <input type="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
        <label>Telefon:</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>">
        <h3>Adres</h3>
        <label>Kraj:</label>
        <input type="text" name="country" value="<?php echo htmlspecialchars($user['country']); ?>">
        <label>Ulica:</label>
        <input type="text" name="street" value="<?php echo htmlspecialchars($user['street']); ?>">
        <label>Numer domu:</label>
        <input type="text" name="home" value="<?php echo htmlspecialchars($user['home']); ?>">
        <label>Mieszkanie:</label>
        <input type="text" name="flat" value="<?php echo htmlspecialchars($user['flat']); ?>">
        <button type="submit">Zapisz zmiany</button>
    </form>
    <a href="php/logout.php">Wyloguj się</a>
</div>
</body>
</html>
