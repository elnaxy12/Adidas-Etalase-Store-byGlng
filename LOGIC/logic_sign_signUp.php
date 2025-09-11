<?php
session_start();

// Konfigurasi koneksi database
$host = 'localhost';
$db   = 'db_etalase';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}

// Jika sudah login, redirect langsung ke index
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Proses login hanya untuk POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['user_email'] ?? '');
    $password = $_POST['user_password'] ?? '';

    // Validasi input
    if (empty($email) || empty($password)) {
        header("Location: login.html?error=empty");
        exit;
    }

    // Validasi email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: login.html?error=invalidemail");
        exit;
    }

    // Cari user berdasarkan email
    $stmt = $pdo->prepare("SELECT * FROM register WHERE user_email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Cek apakah email terdaftar
    if (!$user) {
        // Email tidak ditemukan
        header("Location: login.html?error=notfound");
        exit;
    }

    // Cek password
    if (!password_verify($password, $user['user_password'])) {
        // Password salah
        header("Location: login.html?error=invalid");
        exit;
    }

    // Jika lolos semua, simpan session dan redirect
    $_SESSION['user_id']    = $user['username'];
    $_SESSION['user_email'] = $user['user_email'];

    header("Location: index.php");
    exit;
} else {
    // Jika akses bukan POST
    header("Location: login.html");
    exit;
}
?>
