<?php 
include 'koneksi.php';

if (isset($_POST['submit'])) {
    $nama_pasien = $_POST['nama_pasien'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $telephone = $_POST['telephone'];
    $alamat = $_POST['alamat'];
    $tglperiksa = $_POST['tglperiksa'];
    $layanan = $_POST['layanan'];

    // Menyimpan ke database
    $sql = mysqli_query($conn, "INSERT INTO appointment (nama_pasien,jenis_kelamin, telephone, alamat, tglperiksa, layanan) VALUES ('$nama_pasien', '$jenis_kelamin', '$telephone', '$alamat', '$tglperiksa', '$layanan')");

    if ($sql) {
        // pesan jika data tersimpan
        echo "<script>alert('Appoinment Succeded!'); window.location.href='index.html'</script>"; 
    } else {
        // pesan jika data gagal disimpan
        echo "<script>alert('Log Gagal Ditambahkan!!');</script>";
        echo mysqli_error($conn);
    }
}
?>