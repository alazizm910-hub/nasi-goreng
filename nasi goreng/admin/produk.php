<?php 
include 'koneksi.php'; 
// Ambil semua data produk dari database
$query = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Produk - NasgorHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* CSS Tetap Sama */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { display: flex; background-color: #f8f9fa; min-height: 100vh; }
        .sidebar { width: 260px; background: #2d3436; color: white; position: fixed; height: 100%; padding: 20px; }
        .sidebar .logo { font-size: 24px; font-weight: bold; color: #fab1a0; text-align: center; margin-bottom: 40px; border-bottom: 1px solid #636e72; padding-bottom: 20px; }
        .sidebar .logo span { color: #ff7675; }
        nav a { display: flex; align-items: center; color: #dfe6e9; text-decoration: none; padding: 12px 15px; margin-bottom: 10px; border-radius: 10px; transition: 0.3s; }
        nav a i { margin-right: 15px; width: 20px; text-align: center; }
        nav a:hover, nav a.active { background: #ff7675; color: white; }
        .main-content { margin-left: 260px; width: calc(100% - 260px); padding: 40px; }
        .header-produk { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .btn-tambah { background: #ff7675; color: white; text-decoration: none; padding: 10px 20px; border-radius: 8px; font-weight: bold; transition: 0.3s; }
        .table-section { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; }
        table th { text-align: left; padding: 15px; background: #fdf2f2; color: #d63031; font-size: 14px; }
        table td { padding: 15px; border-bottom: 1px solid #f1f2f6; font-size: 14px; }
        
        /* Box Gambar yang rapi */
        .img-container { width: 80px; height: 60px; background: #eee; border-radius: 8px; overflow: hidden; display: flex; align-items: center; justify-content: center; border: 1px solid #ddd; }
        .img-produk { width: 100%; height: 100%; object-fit: cover; }
        
        .btn-edit { color: #74b9ff; font-size: 18px; margin-right: 15px; }
        .btn-hapus { color: #ff7675; font-size: 18px; border: none; background: none; cursor: pointer; }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="logo">NASGOR<span>HUB</span></div>
        <nav>
            <a href="index.php"><i class="fas fa-chart-pie"></i> Dashboard</a>
            <a href="produk.php" class="active"><i class="fas fa-hamburger"></i> Produk Menu</a>
            <a href="transaksi.php"><i class="fas fa-exchange-alt"></i> Transaksi</a>
            <a href="index.php" style="margin-top:50px; color:#fab1a0;"><i class="fas fa-sign-out-alt"></i> Keluar</a>
        </nav>
    </aside>

    <main class="main-content">
        <div class="header-produk">
            <h1>Daftar Menu Nasi Goreng</h1>
            <a href="tambah_produk.php" class="btn-tambah"><i class="fas fa-plus"></i> Tambah Menu Baru</a>
        </div>

        <section class="table-section">
            <table>
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Nama Menu</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($query)) : ?>
                    <tr>
                        <td>
                            <div class="img-container">
                                <?php 
                                // Cek apakah file benar-benar ada di folder uploads
                                if(!empty($row['gambar_url']) && file_exists("uploads/" . $row['gambar_url'])) {
                                    echo '<img src="uploads/'.$row['gambar_url'].'" class="img-produk">';
                                } else {
                                    // Tampilkan gambar default jika file tidak ditemukan
                                    echo '<i class="fas fa-image" style="color:#ccc; font-size:24px;"></i>';
                                }
                                ?>
                            </div>
                        </td>
                        <td><strong><?= $row['nama_produk']; ?></strong></td>
                        <td><?= $row['kategori']; ?></td>
                        <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                        <td><?= $row['stok']; ?> porsi</td>
                        <td>
                            <a href="edit_produk.php?id=<?= $row['id']; ?>" class="btn-edit"><i class="fas fa-edit"></i></a>
                            <a href="hapus_produk.php?id=<?= $row['id']; ?>" class="btn-hapus" onclick="return confirm('Hapus menu ini?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>