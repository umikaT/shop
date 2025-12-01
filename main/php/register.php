<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!isset($_POST['username'], $_POST['email'], $_POST['password'], $_POST['password2'])) {
        header("Location: ../register.html?error=missing");
        exit;
    }

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if ($password !== $password2) {
        header("Location: ../register.html?error=nomatch");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../register.html?error=email");
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        header("Location: ../register.html?error=exists");
        exit;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (username, email, passwd) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $hash]);

    header("Location: ../login.html?register=success");
    exit;
}
?>
