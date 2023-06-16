<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $page = "Data Appointment";
  session_start();
  include 'auth/connect.php';
  include "part/head.php";
  ?>
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>

      <?php
      include 'part/navbar.php';
      include 'part/sidebar.php';
      ?>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1><?php echo $page; ?></h1>
          </div>
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Daftar Appointment</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>
                          <tr>
                            <th class="text-center">#</th>
                            <th>Nama Pasien</th>
                            <th>Telephone</th>
                            <th>Alamat</th>
                            <th>Tanggal appointment</th>
                            <th class="text-center">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                          $sql = mysqli_query($conn, "SELECT * FROM appointment");
                          $i = 0;
                          while ($row = mysqli_fetch_array($sql)) {
                            $i++;
                          ?>
                            <tr>
                              <td><?php echo $i; ?></td>
                              <td><?php echo ucwords($row['nama_pasien']) ?></td>
                              <td><?php echo substr($row['telephone'], 0, 4) . '-' . substr($row['telephone'], 4, 4) . '-' . substr($row['telephone'], 8); ?></td>
                              <td><?php echo ucwords($row['alamat']) ?></td>
                              <td><?php echo date('d/m/Y', strtotime($row['tglperiksa'])); ?></td>>
                              <td align="center">
                                <a class="btn btn-danger btn-action mr-1" data-toggle="tooltip" title="Hapus" data-confirm="Hapus Data|Apakah Sudah selesai melakukan periksa?" data-confirm-yes="window.location.href = 'auth/apselesai.php?type=appointment&id=<?php echo $row['id']; ?>'" ;><i class="fas fa-trash"></i></a>
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
          </div>
        </section>
      </div>
      <?php include 'part/footer.php'; ?>
    </div>
  </div>
  <?php include "part/all-js.php"; ?>

</body>

</html>