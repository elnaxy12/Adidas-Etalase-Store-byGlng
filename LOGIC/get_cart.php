<?php
session_start();
header('Content-Type: application/json');
include 'db_connect.php';

$user_id = $_SESSION['user_id'] ?? null;
if(!$user_id){
    echo json_encode([]);
    exit;
}

$result = mysqli_query($conn, "SELECT product_name, qty, price FROM cart WHERE user_id='$user_id'");
$cart = [];
while($row = mysqli_fetch_assoc($result)){
    $cart[] = [
        'product_name' => $row['product_name'],
        'qty' => (int)$row['qty'],
        'price' => (float)$row['price']
    ];
}

echo json_encode($cart);
