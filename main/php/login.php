<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if(empty($email) || empty($password)) {
        header("Location: ../login.html?error=empty");
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user) {
        header("Location: ../login.html?error=notfound");
        exit;
    }

    if (password_verify($password, $user['passwd'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        header("Location: ../glowna.php");
        exit;
    } else {
        header("Location: ../login.html?error=wrongpass");
        exit;
    }
} else {
    header("Location: ../login.html");
    exit;
}
?>
