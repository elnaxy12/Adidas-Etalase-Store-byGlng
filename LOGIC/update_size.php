<?php
include 'db_connect.php'; // koneksi DB

if(isset($_POST['id']) && isset($_POST['size'])) {
    $id = $_POST['id'];
    $size = $_POST['size'];

    $stmt = $conn->prepare("UPDATE cart SET size = ? WHERE id = ?");
    $stmt->bind_param("si", $size, $id);
    $stmt->execute();
}
?>
