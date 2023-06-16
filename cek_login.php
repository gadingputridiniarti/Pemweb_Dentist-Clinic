<?php
// mengaktifkan session pada php
session_start();

// menghubungkan php dengan koneksi database
include 'koneksi.php';

// menangkap data yang dikirim dari form login
$username = $_POST['username'];
$password = $_POST['password'];


// menyeleksi data user dengan username dan password yang sesuai
$login = mysqli_query($conn,"SELECT * FROM users WHERE username='$username' and password='$password'");
// menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($login);

// cek apakah username dan password di temukan pada database
if($cek > 0){

 $data = mysqli_fetch_assoc($login);

 // cek jika user login sebagai admin
 if($data['pekerjaan']=='1'){

  // buat session login dan username
  $_SESSION['username'] = $username;
  $_SESSION['pekerjaan'] = '1';
  // alihkan ke halaman dashboard admin
  header("location:halaman_admin.php");

 // cek jika user login sebagai pegawai
 }else if($data['level']=="pimpinan"){
  // buat session login dan username
  $_SESSION['username'] = $username;
  $_SESSION['level'] = "pimpinan";
  // alihkan ke halaman dashboard pegawai
  header("location:halaman_pimpinan.php");

 }else{

  // alihkan ke halaman login kembali
  header("location:index.php?pesan=gagal");
 } 
}else{
 header("location:index.php?pesan=gagal");
}

?>