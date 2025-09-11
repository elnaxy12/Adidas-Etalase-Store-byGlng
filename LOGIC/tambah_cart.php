<?php
session_start();
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $pdo = new PDO("mysql:host=localhost;dbname=db_etalase;charset=utf8mb4", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Koneksi database gagal: ' . $e->getMessage()]);
    exit;
}

// Ambil data JSON dari JS
$data = json_decode(file_get_contents("php://input"), true);

$product_name = $data['title'] ?? '';
$brand = $data['brand'] ?? '';
$price = $data['price'] ?? 0;
$imageUrl = $data['imageUrl'] ?? '';
$qty = $data['qty'] ?? 1;
$user_id = $data['user_id'] ?? null;

if (!$product_name || !$user_id) {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
    exit;
}

try {
    // Cek apakah produk sudah ada di cart user (cari berdasarkan product_name dan user_id)
    $stmt = $pdo->prepare("SELECT id, qty FROM cart WHERE user_id = :user_id AND product_name = :product_name");
    $stmt->execute(['user_id' => $user_id, 'product_name' => $product_name]);
    $item = $stmt->fetch();

    if ($item) {
        // Produk sudah ada, update qty
        $newQty = $item['qty'] + $qty;
        $update = $pdo->prepare("UPDATE cart SET qty = :qty WHERE id = :id");
        $update->execute(['qty' => $newQty, 'id' => $item['id']]);
        echo json_encode(['success' => true, 'message' => 'Jumlah produk diperbarui']);
        exit;
    } else {
        // Produk belum ada, insert baru
        $insert = $pdo->prepare("
            INSERT INTO cart (user_id, product_name, brand, price, image_url, qty) 
            VALUES (:user_id, :product_name, :brand, :price, :image_url, :qty)
        ");
        $insert->execute([
            'user_id' => $user_id,
            'product_name' => $product_name,
            'brand' => $brand,
            'price' => $price,
            'image_url' => $imageUrl,
            'qty' => $qty
        ]);
        echo json_encode(['success' => true, 'message' => 'Produk ditambahkan ke keranjang']);
        exit;
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error query: ' . $e->getMessage()]);
    exit;
}
