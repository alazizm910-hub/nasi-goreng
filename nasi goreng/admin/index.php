<?php 
// 1. Memanggil koneksi ke database
include 'koneksi.php'; 

// 2. Mengambil data asli dari database untuk kartu statistik
// Hitung Total Pendapatan
$q_pendapatan = mysqli_query($conn, "SELECT SUM(total_bayar) as total FROM transaksi WHERE status_pembayaran='lunas'");
$d_pendapatan = mysqli_fetch_assoc($q_pendapatan);
$total_pendapatan = $d_pendapatan['total'] ?? 0;

// Hitung Jumlah Pesanan Selesai
$q_transaksi = mysqli_query($conn, "SELECT COUNT(*) as total FROM transaksi WHERE status_pembayaran='lunas'");
$d_transaksi = mysqli_fetch_assoc($q_transaksi);
$total_transaksi = $d_transaksi['total'] ?? 0;

// Hitung Total Menu Tersedia
$q_produk = mysqli_query($conn, "SELECT COUNT(*) as total FROM produk");
$d_produk = mysqli_fetch_assoc($q_produk);
$total_produk = $d_produk['total'] ?? 0;

// 3. Mengambil data transaksi untuk tabel (Limit 5 transaksi terbaru)
$query_tabel = mysqli_query($conn, "SELECT * FROM transaksi ORDER BY id DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin NasgorHub - Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* --- CSS TETAP SAMA --- */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Roboto, sans-serif; }
        body { display: flex; background-color: #f8f9fa; min-height: 100vh; }
        .sidebar { width: 260px; background: #2d3436; color: white; position: fixed; height: 100%; padding: 20px; }
        .sidebar .logo { font-size: 24px; font-weight: bold; color: #fab1a0; text-align: center; margin-bottom: 40px; border-bottom: 1px solid #636e72; padding-bottom: 20px; }
        .sidebar .logo span { color: #ff7675; }
        nav a { display: flex; align-items: center; color: #dfe6e9; text-decoration: none; padding: 12px 15px; margin-bottom: 10px; border-radius: 10px; transition: 0.3s; }
        nav a i { margin-right: 15px; width: 20px; text-align: center; }
        nav a:hover, nav a.active { background: #ff7675; color: white; box-shadow: 0 4px 10px rgba(255, 118, 117, 0.3); }
        .main-content { margin-left: 260px; width: calc(100% - 260px); padding: 40px; }
        header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 25px; margin-bottom: 40px; }
        .card { background: white; padding: 25px; border-radius: 15px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 10px 20px rgba(0,0,0,0.05); border-left: 5px solid #ff7675; }
        .card-info h3 { font-size: 24px; color: #2d3436; margin-bottom: 5px; }
        .card-info p { color: #636e72; font-size: 14px; }
        .card i { font-size: 35px; color: #fab1a0; }
        .table-section { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; }
        table th { text-align: left; padding: 15px; background: #fdf2f2; color: #d63031; font-size: 14px; }
        table td { padding: 15px; border-bottom: 1px solid #f1f2f6; color: #2d3436; font-size: 14px; }
        .status { padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; text-transform: capitalize; }
        .status.lunas { background: #55efc4; color: #00b894; }
        .status.pending { background: #ffeaa7; color: #d6a01d; }
        .btn-action { background: #74b9ff; color: white; border: none; padding: 8px 15px; border-radius: 8px; cursor: pointer; }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="logo">NASGOR<span>HUB</span></div>
        <nav>
            <a href="index.php" class="active"><i class="fas fa-chart-pie"></i> Dashboard</a>
            <a href="produk.php"><i class="fas fa-hamburger"></i> Produk Menu</a>
            <a href="transaksi.php"><i class="fas fa-exchange-alt"></i> Transaksi</a>
            <a href="#"><i class="fas fa-users"></i> Pelanggan</a>
            <a href="#"><i class="fas fa-cog"></i> Pengaturan</a>
            <a href="#" class="logout" style="margin-top:50px; color:#fab1a0;"><i class="fas fa-sign-out-alt"></i> Keluar</a>
        </nav>
    </aside>

    <main class="main-content">
        <header>
            <h1>Ringkasan Penjualan</h1>
            <div class="admin-profile"><i class="fas fa-user-circle"></i> Admin Utama</div>
        </header>

        <section class="stats-grid">
            <div class="card">
                <div class="card-info">
                    <!-- DATA ASLI DARI SQL -->
                    <h3>Rp <?= number_format($total_pendapatan, 0, ',', '.'); ?></h3>
                    <p>Total Pendapatan</p>
                </div>
                <i class="fas fa-wallet"></i>
            </div>
            <div class="card" style="border-left-color: #74b9ff;">
                <div class="card-info">
                    <!-- DATA ASLI DARI SQL -->
                    <h3><?= $total_transaksi; ?></h3>
                    <p>Pesanan Selesai</p>
                </div>
                <i class="fas fa-receipt"></i>
            </div>
            <div class="card" style="border-left-color: #55efc4;">
                <div class="card-info">
                    <!-- DATA ASLI DARI SQL -->
                    <h3><?= $total_produk; ?></h3>
                    <p>Menu Tersedia</p>
                </div>
                <i class="fas fa-utensils"></i>
            </div>
        </section>

        <section class="table-section">
            <h3>Transaksi Terbaru</h3>
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Pelanggan</th>
                        <th>Total Bayar</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($query_tabel)) : ?>
                    <tr>
                        <td>#<?= $row['kode_transaksi']; ?></td>
                        <td><?= $row['nama_pembeli']; ?></td>
                        <td>Rp <?= number_format($row['total_bayar'], 0, ',', '.'); ?></td>
                        <td><?= $row['metode_pembayaran']; ?></td>
                        <td>
                            <span class="status <?= strtolower($row['status_pembayaran']); ?>">
                                <?= $row['status_pembayaran']; ?>
                            </span>
                        </td>
                        <td><button class="btn-action">Lihat</button></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>