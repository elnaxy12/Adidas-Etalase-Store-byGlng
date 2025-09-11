<?php
header('Content-Type: application/json');
session_start();

// Ambil user_id dari session
$userId = $_SESSION['user_id'] ?? null;

// Validasi jika user belum login
if (!$userId) {
    echo json_encode(['success' => false, 'message' => 'User tidak ditemukan']);
    exit;
}

try {
    // Koneksi ke database menggunakan PDO
    $pdo = new PDO("mysql:host=localhost;dbname=db_etalase;charset=utf8mb4", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Hapus semua cart milik user yang sedang login
    $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ?");
    $stmt->execute([$userId]);

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    // Tangani jika terjadi error koneksi atau query
    echo json_encode(['success' => false, 'message' => 'DB error: ' . $e->getMessage()]);
}
