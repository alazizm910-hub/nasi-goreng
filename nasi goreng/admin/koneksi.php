<?php
// Pengaturan Database
$host     = "localhost"; // Nama host (biasanya localhost)
$username = "root";      // Username default XAMPP adalah root
$password = "";          // Password default XAMPP adalah kosong
$database = "nasgor_admin_db"; // Nama database yang kita buat sebelumnya

// Membuat koneksi ke database
$conn = mysqli_connect($host, $username, $password, $database);

// Cek apakah koneksi berhasil
if (!$conn) {
    die("Gagal terhubung ke database: " . mysqli_connect_error());
}

// Set timezone agar waktu transaksi akurat (WIB)
date_default_timezone_set('Asia/Jakarta');

// (Opsional) Mengatur karakter agar support emoji atau karakter khusus
mysqli_set_charset($conn, "utf8mb4");
?>