<?php
session_start();

// Ambil user_id dari session (misal user sudah login)
$user_id = $_SESSION['user_id'] ?? null;

$mysqli = new mysqli("localhost", "root", "", "db_etalase");

// Cek koneksi
if ($mysqli->connect_error) {
    die(json_encode(['count' => 0, 'error' => $mysqli->connect_error]));
}

// Hitung jumlah item di cart
if ($user_id) {
    $stmt = $mysqli->prepare("SELECT SUM(qty) AS total FROM cart WHERE user_id = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $count = $result['total'] ?? 0;
} else {
    $count = 0;
}

// Kembalikan data JSON
header('Content-Type: application/json');
echo json_encode(['count' => $count]);
?>
