<?php 
// Hubungkan ke database (jalur ke folder admin karena koneksi.php ada di sana)
include 'admin/koneksi.php'; 

// Ambil semua menu nasi goreng yang stoknya masih ada
$query = mysqli_query($conn, "SELECT * FROM produk WHERE stok > 0 ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NasgorHub - Nasi Goreng Favorit Keluarga</title>
    <!-- Google Fonts & Font Awesome -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: #fdfdfd; color: #333; scroll-behavior: smooth; }

        /* Navbar */
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 8%;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .logo { font-size: 24px; font-weight: 800; color: #ff7675; text-decoration: none; }
        .logo span { color: #2d3436; }
        .nav-links { list-style: none; display: flex; align-items: center; }
        .nav-links li { margin-left: 30px; }
        .nav-links a { text-decoration: none; color: #636e72; font-weight: 500; transition: 0.3s; }
        .nav-links a:hover { color: #ff7675; }

        /* Hero Section */
        .hero {
            height: 60vh;
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1603133872878-684f208fb84b?auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            padding: 0 20px;
        }
        .hero h1 { font-size: 45px; margin-bottom: 15px; }
        .hero p { font-size: 18px; margin-bottom: 30px; opacity: 0.9; }
        .btn-order {
            padding: 15px 40px;
            background: #ff7675;
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: bold;
            box-shadow: 0 10px 20px rgba(255, 118, 117, 0.4);
            transition: 0.3s;
        }
        .btn-order:hover { background: #d63031; transform: translateY(-3px); }

        /* Menu Section */
        .menu-container { padding: 80px 8%; text-align: center; }
        .menu-container h2 { font-size: 32px; margin-bottom: 40px; color: #2d3436; }
        .menu-container h2 span { color: #ff7675; }

        .grid-menu {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 35px;
        }

        .card {
            background: white;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: 0.3s;
            border: 1px solid #f8f9fa;
        }
        .card:hover { transform: translateY(-12px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
        
        .card-img-box { width: 100%; height: 220px; overflow: hidden; position: relative; }
        .card-img { width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }
        .card:hover .card-img { transform: scale(1.1); }
        
        .badge-kategori {
            position: absolute;
            top: 15px;
            left: 15px;
            background: rgba(255, 255, 255, 0.9);
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            color: #ff7675;
            text-transform: uppercase;
        }

        .card-content { padding: 25px; text-align: left; }
        .card-content h3 { font-size: 20px; margin-bottom: 10px; color: #2d3436; }
        .card-content p { font-size: 13px; color: #636e72; margin-bottom: 20px; line-height: 1.6; }
        
        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #f1f1f1;
            padding-top: 15px;
        }
        .price { font-size: 19px; font-weight: 800; color: #2d3436; }
        .btn-buy {
            background: #2d3436;
            color: white;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            text-decoration: none;
            transition: 0.3s;
        }
        .btn-buy:hover { background: #ff7675; }

        footer { background: #2d3436; color: white; padding: 60px 8%; text-align: center; margin-top: 50px; }
        .footer-logo { font-size: 24px; font-weight: bold; color: #ff7675; margin-bottom: 15px; display: block; text-decoration: none; }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav>
        <a href="index_pembeli.php" class="logo">NASGOR<span>HUB</span></a>
        <ul class="nav-links">
            <li><a href="#">Beranda</a></li>
            <li><a href="#menu">Menu</a></li>
            <li><a href="#">Promo</a></li>
            <li><a href="admin/index.php" class="btn-login" style="background: #f1f2f6; padding: 8px 15px; border-radius: 10px;"><i class="fas fa-user-lock"></i> Admin</a></li>
        </ul>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <h1>Rasakan Kelezatan Nasi Goreng Asli!</h1>
        <p>Pilih menu favoritmu dan kami antar selagi hangat ke depan pintumu.</p>
        <a href="#menu" class="btn-order">Lihat Menu Sekarang</a>
    </section>

    <!-- Menu Section -->
    <section class="menu-container" id="menu">
        <h2>Pilihan <span>Menu Terbaik</span></h2>
        
        <div class="grid-menu">
            <?php while($row = mysqli_fetch_assoc($query)) : ?>
            <div class="card">
                <div class="card-img-box">
                    <span class="badge-kategori"><?= $row['kategori']; ?></span>
                    
                    <!-- Gambar dari folder admin/uploads -->
                    <?php if(!empty($row['gambar_url'])) : ?>
                        <img src="admin/uploads/<?= $row['gambar_url']; ?>" class="card-img" alt="<?= $row['nama_produk']; ?>">
                    <?php else : ?>
                        <img src="https://via.placeholder.com/300x220?text=NasgorHub" class="card-img">
                    <?php endif; ?>
                </div>

                <div class="card-content">
                    <h3><?= $row['nama_produk']; ?></h3>
                    <p><?= (strlen($row['deskripsi']) > 70) ? substr($row['deskripsi'], 0, 70) . "..." : $row['deskripsi']; ?></p>
                    
                    <div class="card-footer">
                        <span class="price">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></span>
                        <a href="#" class="btn-buy" title="Tambah ke Keranjang"><i class="fas fa-plus"></i></a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <a href="#" class="footer-logo">NASGOR<span>HUB</span></a>
        <p>Solusi lapar di tengah malam. Kualitas rasa adalah prioritas kami.</p>
        <div style="margin-top: 20px; font-size: 14px; opacity: 0.6;">
            &copy; 2024 Dunia Nasi Goreng Indonesia.
        </div>
    </footer>

</body>
</html>