<?php
// kalau halaman ini dibuka langsung (bukan dari form), balikin ke form
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.html");
    exit;
}

// ambil data dari form, trim buat buang spasi di awal/akhir
$nama   = trim($_POST["nama"] ?? "");
$menu   = $_POST["menu"] ?? "";
$jumlah = trim($_POST["jumlah"] ?? "");

// validasi ulang di server, karena validasi JavaScript bisa dilewati
$errors = [];

if ($nama === "") {
    $errors[] = "Nama wajib diisi.";
} elseif (!preg_match("/^[A-Za-z\s]+$/", $nama)) {
    $errors[] = "Nama hanya boleh berisi huruf dan spasi.";
}

// harga ditentukan di server, bukan dikirim dari form, jadi tidak bisa diakali
if ($menu === "nasi_goreng") {
    $namaMenu = "Nasi Goreng";
    $harga    = 15000;
} elseif ($menu === "mie_ayam") {
    $namaMenu = "Mie Ayam";
    $harga    = 12000;
} else {
    $errors[] = "Menu yang dipilih tidak valid.";
}

if ($jumlah === "") {
    $errors[] = "Jumlah wajib diisi.";
} elseif (!ctype_digit($jumlah) || $jumlah < 1 || $jumlah > 100) {
    $errors[] = "Jumlah harus bilangan bulat antara 1 sampai 100.";
}

// kalau semua valid, hitung total
if (empty($errors)) {
    $jumlah = (int) $jumlah;
    $total  = $harga * $jumlah;
}

// ubah angka jadi format rupiah, contoh 30000 -> Rp30.000
function rupiah($angka)
{
    return "Rp" . number_format($angka, 0, ",", ".");
}
?>
<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Hasil Pesanan</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <main class="card">
      <?php if (!empty($errors)) : ?>
        <h1 class="judul-error">Pesanan Gagal</h1>
        <p class="subjudul">Data yang dikirim belum benar:</p>
        <ul class="daftar-error">
          <?php foreach ($errors as $error) : ?>
            <li><?php echo htmlspecialchars($error); ?></li>
          <?php endforeach; ?>
        </ul>
        <a class="tombol" href="index.html">Kembali ke Form</a>
      <?php else : ?>
        <h1>Pesanan Berhasil</h1>
        <p class="subjudul">Terima kasih, <?php echo htmlspecialchars($nama); ?>! Berikut rincian pesananmu:</p>

        <table class="tabel-pesanan">
          <tr>
            <th>Nama</th>
            <td><?php echo htmlspecialchars($nama); ?></td>
          </tr>
          <tr>
            <th>Menu</th>
            <td><?php echo $namaMenu; ?></td>
          </tr>
          <tr>
            <th>Harga</th>
            <td><?php echo rupiah($harga); ?></td>
          </tr>
          <tr>
            <th>Jumlah</th>
            <td><?php echo $jumlah; ?></td>
          </tr>
          <tr class="baris-total">
            <th>Total</th>
            <td><?php echo rupiah($total); ?></td>
          </tr>
        </table>

        <a class="tombol" href="index.html">Pesan Lagi</a>
      <?php endif; ?>
    </main>
  </body>
</html>