<?php 

// panggil koneksi
require(__DIR__ . '/setup.php');

// ambil semua data dari tabel mahasiswa
$stmt = $conn->prepare("SELECT * FROM mahasiswa");
$stmt->execute();

$mahasiswa = $stmt->fetchAll(PDO::FETCH_ASSOC);

// convert ke bentuk json
header('Content-Type: application/json');
echo json_encode($mahasiswa);
