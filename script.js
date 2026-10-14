// dipanggil saat tombol Pesan ditekan (onsubmit di index.html)
// return false = form batal dikirim, return true = lanjut ke proses.php
function validasiForm() {
  const nama = document.getElementById("nama").value.trim();
  const menu = document.getElementById("menu").value;
  const jumlah = document.getElementById("jumlah").value;

  // nama cuma boleh huruf dan spasi
  const polaNama = /^[A-Za-z\s]+$/;

  if (nama === "") {
    alert("Nama wajib diisi!");
    document.getElementById("nama").focus();
    return false;
  } else if (!polaNama.test(nama)) {
    alert("Nama hanya boleh berisi huruf dan spasi!");
    document.getElementById("nama").focus();
    return false;
  }

  if (menu === "") {
    alert("Silakan pilih menu terlebih dahulu!");
    document.getElementById("menu").focus();
    return false;
  }

  if (jumlah === "") {
    alert("Jumlah wajib diisi!");
    document.getElementById("jumlah").focus();
    return false;
  } else if (jumlah < 1 || jumlah > 100 || !Number.isInteger(Number(jumlah))) {
    alert("Jumlah harus bilangan bulat antara 1 sampai 100!");
    document.getElementById("jumlah").focus();
    return false;
  }

  // semua data sudah benar, form boleh dikirim
  return true;
}