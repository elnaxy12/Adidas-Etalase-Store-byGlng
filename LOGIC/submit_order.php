<?php
session_start();
header('Content-Type: application/json');
include 'db_connect.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    echo json_encode(['success'=>false,'message'=>'User belum login']);
    exit;
}

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);
$payment_method = mysqli_real_escape_string($conn, $data['payment_method'] ?? 'COD');
$totally = (float)($data['totally'] ?? 0);

// Ambil cart user
$cart_result = mysqli_query($conn, "SELECT * FROM cart WHERE user_id='$user_id'");
if (mysqli_num_rows($cart_result) == 0) {
    echo json_encode(['success'=>false,'message'=>'Cart kosong']);
    exit;
}

// Ambil alamat terakhir
$address_result = mysqli_query($conn, "SELECT * FROM address WHERE user_id='$user_id' ORDER BY tanggal_daftar DESC LIMIT 1");
$address = mysqli_fetch_assoc($address_result);
if (!$address) {
    echo json_encode(['success'=>false,'message'=>'Alamat tidak ditemukan']);
    exit;
}

// Insert ke order_pending
// Insert ke order_pending
while ($item = mysqli_fetch_assoc($cart_result)) {
    $product_name = mysqli_real_escape_string($conn, $item['product_name']);
    $brand = mysqli_real_escape_string($conn, $item['brand']); // <--- ambil brand
    $size = mysqli_real_escape_string($conn, $item['size']);
    $qty = (int)$item['qty'];
    $price = (float)$item['price'];

    $nama_lengkap = mysqli_real_escape_string($conn, $address['nama_lengkap']);
    $no_telp = mysqli_real_escape_string($conn, $address['no_telp']);
    $street = mysqli_real_escape_string($conn, $address['street']);

    mysqli_query($conn, "INSERT INTO order_pending
        (user_id, nama_lengkap, no_telp, street, product_name, brand, size, qty, price, totally, payment_method)
        VALUES ('$user_id','$nama_lengkap','$no_telp','$street','$product_name','$brand','$size',$qty,$price,$totally,'$payment_method')");
}

// Hapus cart user
mysqli_query($conn, "DELETE FROM cart WHERE user_id='$user_id'");

echo json_encode(['success'=>true,'message'=>'Order berhasil disimpan']);
?>
