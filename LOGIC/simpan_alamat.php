<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_etalase";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil user_id dari session login
$user_id = $_SESSION['user_id'] ?? null;

// Ambil data dari POST
$nama_lengkap   = trim($_POST['nama_lengkap'] ?? '');
$no_telp        = trim($_POST['no_telp'] ?? '');
$street         = trim($_POST['street'] ?? '');
$tanggal_daftar = trim($_POST['tanggal_daftar'] ?? date('Y-m-d'));

// Validasi lengkap
if ($user_id && $nama_lengkap && $no_telp && $street) {

    // Hapus alamat lama (jika ada)
    $deleteStmt = $conn->prepare("DELETE FROM address WHERE user_id = ?");
    $deleteStmt->bind_param("s", $user_id);
    $deleteStmt->execute();
    $deleteStmt->close();

    // Simpan alamat baru
    $stmt = $conn->prepare("
        INSERT INTO address (user_id, nama_lengkap, no_telp, street, tanggal_daftar)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("sssss", $user_id, $nama_lengkap, $no_telp, $street, $tanggal_daftar);

    if ($stmt->execute()) {
        echo "Data alamat berhasil disimpan.";
    } else {
        echo "Gagal menyimpan: " . $conn->error;
    }
    $stmt->close();
} else {
    echo "Data tidak lengkap atau user belum login.";
}

$conn->close();
?>
