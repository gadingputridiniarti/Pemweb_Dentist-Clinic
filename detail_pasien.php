<!DOCTYPE html>
<html lang="en">

<head>
    <?php
  $idnama = $_POST['id'];
  $page1 = "det";
  $page = "Detail Pasien : " . $idnama;
  session_start();
  include 'auth/connect.php';
  include "part/head.php";
  $cek = mysqli_query($conn, "SELECT * FROM pasien WHERE nama_pasien='$idnama'");
  $pasien = mysqli_fetch_array($cek);
  $idid = $pasien['id'];
  ?>
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>

            <?php
      include 'part/navbar.php';
      include 'part/sidebar.php';
      include 'part_func/umur.php';
      include 'part_func/tgl_ind.php';
      ?>

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Detail Pasien</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="pasien.php">Data Pasien</a></div>
                            <div class="breadcrumb-item">Detail Pasien : <?php echo ucwords($idnama); ?></div>
                        </div>
                    </div>

                    <div class="section-body">
                        <?php include 'part/info_pasien.php'; ?>

                        <div class="section-body">
                            <div class="row">
                                <div class="col-12 col-sm-6 col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Info Pasien</h4>
                                            <div class="card-header-action">
                                                <form method="POST" action="print.php" target="_blank">
                                                    <input type="hidden" name="id" value="<?php echo $idnama; ?>">
                                                    <?php
                          $cekrekam = mysqli_num_rows($rekam);
                          if ($cekrekam == 0) {
                            echo '';
                          } else {
                            echo '<button type="submit" class="btn btn-primary" name="printall">Print Semua</button> &emsp;';
                          } ?>

                                                </form>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="gallery">
                                                <table class="table table-striped table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">Nama Lengkap</th>
                                                            <td> : <?php echo ucwords($idnama); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Tanggal Lahir</th>
                                                            <td> : <?php echo tgl_indo($pasien['tgl_lahir']); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Alamat</th>
                                                            <td> : <?php echo $pasien['alamat']; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Catatan Riwayat Periksa Pasien</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered" id="table-1">
                                                    <thead>
                                                        <tr>
                                                            <th>Tanggal Berobat</th>
                                                            <th>Jenis layanan</th>
                                                            <th>Keluhan</th>
                                                            <th>Obat</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                            $sql = mysqli_query($conn, "SELECT * FROM data_pemeriksaan WHERE id_pasien='$idid'");
                            $i = 0;
                            while ($row = mysqli_fetch_array($sql)) {
                              $idpenyakit = $row['id'];
                            ?>
                                                        <tr>
                                                            <td><?php echo ucwords(tgl_indo($row['tgl'])); ?></td>
                                                            <td><?php echo ucwords($row['penyakit']); ?></td>
                                                            <td><?php
                                    echo $row['keluhan']."";
                                    $status = substr($row['id_rawatinap'], 0, 3);
                                    $idrawatinap = substr($row['id_rawatinap'], 3);
                                    if ($row['id_rawatinap'] == '0') {
                                      echo '';
                                    } else {
                                      if ($status == "tmp") {
                                        
                                      } else {
                                        
                                      }
                                    } ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                  $obat2an = mysqli_query($conn, "SELECT * FROM riwayat_obat WHERE id_penyakit='$idpenyakit' AND id_pasien='$idid'");
                                  $jumobat = mysqli_num_rows($obat2an);
                                  if ($jumobat == 0) {
                                    echo "Tidak ada obat yang diberikan";
                                  } else {
                                    $count = 0;
                                    while ($showobat = mysqli_fetch_array($obat2an)) {
                                      $idobat = $showobat['id_obat'];
                                      $obatlagi = mysqli_query($conn, "SELECT * FROM obat WHERE id='$idobat'");
                                      $namaobat = mysqli_fetch_array($obatlagi);
                                      echo $str = ucwords($namaobat['nama_obat']);
                                      $count = $count + 1;

                                      if ($count < $jumobat) {
                                        echo ", ";
                                      }
                                    }
                                  }
                                  ?>
                                                            </td>
                                                            <td>
                                                                <form method="POST" action="print.php" target="_blank">
                                                                    <input type="hidden" name="id"
                                                                        value="<?php echo $idnama; ?>">
                                                                    <input type="hidden" name="idriwayat"
                                                                        value="<?php echo $idpenyakit ?>">
                                                                    <div class="btn-group">
                                                                        <button type="submit" class="btn btn-info"
                                                                            name="detail" title="Detail"
                                                                            data-toggle="tooltip"><i
                                                                                class="fas fa-info"></i></button>
                                                                        <button type="submit" class="btn btn-primary"
                                                                            name="printone" title="Print"
                                                                            data-toggle="tooltip"><i
                                                                                class="fas fa-print"></i></button>
                                                                    </div>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                </section>
            </div>

            <?php include 'part/footer.php'; ?>
        </div>
    </div>
    <?php include "part/all-js.php"; ?>
</body>

</html>