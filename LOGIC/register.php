<?php
// register.php

$host = 'localhost';
$db   = 'db_etalase';  
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // Gagal koneksi, langsung stop script
    exit("Koneksi database gagal: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['user_email'] ?? '');
    $password = $_POST['user_password'] ?? '';
    $repeatPassword = $_POST['repeat_password'] ?? '';

    // Validasi field kosong
    if (!$username || !$email || !$password || !$repeatPassword) {
        header("Location: signup.html?error=emptyfields");
        exit;
    }

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: signup.html?error=invalidemail");
        exit;
    }

    // Validasi password sama
    if ($password !== $repeatPassword) {
        header("Location: signup.html?error=passwordmismatch");
        exit;
    }

    // Cek username/email sudah terdaftar
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM register WHERE username = ? OR user_email = ?");
    $stmt->execute([$username, $email]);
    $exists = $stmt->fetchColumn();

    if ($exists > 0) {
        header("Location: signup.html?error=userexists");
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO register (username, user_email, user_password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $hashedPassword]);

    header("Location: login.html?success=registered");
    exit;
} else {
    exit("Akses tidak valid.");
}
