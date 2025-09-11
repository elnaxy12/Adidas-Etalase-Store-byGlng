<?php
session_start();
header('Content-Type: application/json');

include 'db_connect.php';

// Pastikan user sudah login dan punya user_id
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    echo json_encode(['success' => false, 'message' => 'User belum login']);
    exit;
}

// Ambil data JSON dari request body
$data = json_decode(file_get_contents('php://input'), true);
$cart = $data['cart'] ?? [];

if (empty($cart)) {
    echo json_encode(['success' => false, 'message' => 'Cart kosong']);
    exit;
}

// Hapus dulu cart lama user ini (opsional)
mysqli_query($conn, "DELETE FROM cart WHERE user_id = $user_id");

// Simpan data cart baru
foreach ($cart as $item) {
    $title = mysqli_real_escape_string($conn, $item['title']);
    $qty = (int)$item['qty'];
    $price = (float)$item['price'];

    // Contoh: cari product_id dari nama produk (title)
    $result = mysqli_query($conn, "SELECT product_id FROM products WHERE nama_barang = '$title' LIMIT 1");
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $product_id = $row['product_id'];
        // Insert ke tabel cart
        mysqli_query($conn, "INSERT INTO cart (user_id, product_id, jumlah) VALUES ($user_id, $product_id, $qty)");
    }
}

echo json_encode(['success' => true]);
