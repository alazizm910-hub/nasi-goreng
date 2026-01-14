<?php 
include 'koneksi.php'; 

// Cek apakah tombol simpan diklik
if(isset($_POST['simpan'])) {
    // Menggunakan mysqli_real_escape_string agar aman jika ada tanda petik di nama produk
    $nama      = mysqli_real_escape_string($conn, $_POST['nama_produk']);
    $kategori  = mysqli_query($conn, "SELECT * FROM produk"); // Variabel kategori dari form
    $kategori  = $_POST['kategori'];
    $harga     = $_POST['harga'];
    $stok      = $_POST['stok'];
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    // --- PROSES UPLOAD GAMBAR ---
    $nama_gambar = $_FILES['gambar']['name'];
    $tmp_name    = $_FILES['gambar']['tmp_name'];
    $error       = $_FILES['gambar']['error'];

    // Cek apakah user mengupload file
    if($error === 0) {
        // Ambil ekstensi file (jpg, png, dll)
        $ekstensi = pathinfo($nama_gambar, PATHINFO_EXTENSION);
        
        // Buat nama file baru yang unik (Contoh: 65a2b3c4d5.jpg)
        // Ini menghindari error jika nama file asli pakai spasi atau karakter aneh
        $nama_file_baru = uniqid() . "." . $ekstensi;

        // Tentukan path tujuan ke folder uploads/
        $tujuan = 'uploads/' . $nama_file_baru;

        // Pindahkan file dari memori sementara ke folder uploads
        if(move_uploaded_file($tmp_name, $tujuan)) {
            // Jika berhasil pindah, simpan data ke database
            $query = "INSERT INTO produk (nama_produk, kategori, harga, stok, deskripsi, gambar_url) 
                      VALUES ('$nama', '$kategori', '$harga', '$stok', '$deskripsi', '$nama_file_baru')";
            
            $hasil = mysqli_query($conn, $query);

            if($hasil) {
                echo "<script>alert('Menu Berhasil Ditambah!'); window.location='produk.php';</script>";
            } else {
                echo "<script>alert('Gagal menyimpan ke database!');</script>";
            }
        } else {
            echo "<script>alert('Gagal memindahkan file ke folder uploads! Pastikan folder uploads sudah dibuat.');</script>";
        }
    } else {
        echo "<script>alert('Silakan pilih foto menu terlebih dahulu!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Menu Baru - NasgorHub</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f8f9fa; padding: 40px; }
        .form-container { background: white; max-width: 600px; margin: auto; padding: 30px; border-radius: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        h2 { margin-bottom: 25px; color: #2d3436; text-align: center; border-bottom: 2px solid #ff7675; padding-bottom: 10px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 8px; color: #636e72; font-weight: bold; }
        .form-group input, .form-group select, .form-group textarea { 
            width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; outline: none; transition: 0.3s;
        }
        .form-group input:focus { border-color: #ff7675; box-shadow: 0 0 5px rgba(255,118,117,0.3); }
        .btn-save { 
            background: #ff7675; color: white; border: none; padding: 15px; border-radius: 8px; 
            cursor: pointer; width: 100%; font-weight: bold; font-size: 16px; margin-top: 10px; transition: 0.3s;
        }
        .btn-save:hover { background: #d63031; transform: translateY(-2px); }
        .btn-back { display: block; text-align: center; margin-top: 20px; color: #636e72; text-decoration: none; font-size: 14px; }
        .btn-back:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Tambah Menu Baru</h2>
        
        <!-- PENTING: Atribut enctype wajib ada untuk upload file -->
        <form action="" method="POST" enctype="multipart/form-data">
            
            <div class="form-group">
                <label>Nama Nasi Goreng</label>
                <input type="text" name="nama_produk" placeholder="Contoh: Nasi Goreng Betawi" required>
            </div>

            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori">
                    <option value="Nasi Goreng">Nasi Goreng</option>
                    <option value="Minuman">Minuman</option>
                    <option value="Tambahan">Tambahan (Lauk/Kerupuk)</option>
                </select>
            </div>

            <div class="form-group">
                <label>Harga (Rp)</label>
                <input type="number" name="harga" placeholder="Contoh: 30000" required>
            </div>

            <div class="form-group">
                <label>Stok Awal</label>
                <input type="number" name="stok" placeholder="Contoh: 50" required>
            </div>

            <div class="form-group">
                <label>Foto Menu (JPG/PNG)</label>
                <input type="file" name="gambar" accept="image/*" required>
            </div>

            <div class="form-group">
                <label>Deskripsi Singkat</label>
                <textarea name="deskripsi" rows="3" placeholder="Jelaskan isi nasi gorengnya..."></textarea>
            </div>

            <button type="submit" name="simpan" class="btn-save">Simpan Menu ke Database</button>
            <a href="produk.php" class="btn-back"> <i class="fas fa-arrow-left"></i> Kembali ke Daftar Produk</a>
        </form>
    </div>

</body>
</html>