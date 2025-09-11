<?php
// Mulai session (jika kamu butuh user_id dari session)
session_start();

// Koneksi ke database
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
    echo json_encode(['success' => false, 'message' => 'Koneksi gagal: ' . $e->getMessage()]);
    exit;
}

// Ambil input JSON dari body
$input = json_decode(file_get_contents("php://input"), true);

$id  = $input['id'] ?? null;     // id = id dari tabel cart
$qty = $input['qty'] ?? null;

// Validasi input
if (!$id || !$qty || !is_numeric($qty) || $qty < 1) {
    echo json_encode(['success' => false, 'message' => 'Data tidak valid']);
    exit;
}

// Update qty di database
$sql = "UPDATE cart SET qty = :qty WHERE id = :id";
$stmt = $pdo->prepare($sql);

try {
    $stmt->execute(['qty' => $qty, 'id' => $id]);

    if ($stmt->rowCount() === 0) {
        echo json_encode(['success' => false, 'message' => 'ID tidak ditemukan atau tidak ada perubahan']);
    } else {
        echo json_encode(['success' => true, 'message' => 'Berhasil update']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Gagal update: ' . $e->getMessage()]);
}