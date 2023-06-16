<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $page = "Dashboard";
    session_start();
    include 'auth/connect.php';
    include "part/head.php";
    include 'part_func/tgl_ind.php';

    $pegawai = mysqli_query($conn, "SELECT * FROM pegawai WHERE pekerjaan='2'");
    $jumlahpegawai = mysqli_num_rows($pegawai);
    $pasien = mysqli_query($conn, "SELECT * FROM pasien");
    $jumpasien = mysqli_num_rows($pasien);
    $dokter = mysqli_query($conn, "SELECT * FROM pegawai WHERE pekerjaan='1'");
    $jumlahdokter = mysqli_num_rows($dokter);
    
    $jenis_kelamin = mysqli_query($conn, "SELECT DISTINCT jenis_kelamin FROM appointment");
    $nama_jenis_kelamin = array();
    $jumlah_jenis_kelamin = array();

while ($row = mysqli_fetch_array($jenis_kelamin)) {
    $jenis_kelamin_value = $row['jenis_kelamin'];
    $nama_jenis_kelamin[] = $jenis_kelamin_value;

    $query = mysqli_query($conn, "SELECT COUNT(*) as jumlah FROM appointment WHERE jenis_kelamin = '$jenis_kelamin_value'");
    $result = mysqli_fetch_array($query);
    $jumlah_jenis_kelamin[] = $result['jumlah'];
}
    
    $layanan = mysqli_query($conn, "SELECT layanan, COUNT(*) as tglperiksa FROM appointment GROUP BY layanan ORDER BY tglperiksa DESC");
    $nama_layanan = array();
    $jumlah_layanan = array();

    
    while ($row = mysqli_fetch_array($layanan)) {
        $layanan_value = $row['layanan'];
        $nama_layanan[] = $layanan_value;

        $query = mysqli_query($conn, "SELECT COUNT(*) as jumlah FROM appointment WHERE layanan = '$layanan_value'");
        $result = mysqli_fetch_array($query);
        $jumlah_layanan[] = $result['jumlah'];
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
    #link-no {
        text-decoration: none;
    }
    </style>
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
                        <h1>Dashboard</h1>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card card-statistic-1">
                                <div class="card-icon bg-primary">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Admin</h4>
                                    </div>
                                    <div class="card-body">
                                        <?php echo $jumlahpegawai; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card card-statistic-1">
                                <div class="card-icon bg-danger">
                                    <i class="fas fa-user-injured"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Data Pasien</h4>
                                    </div>
                                    <div class="card-body">
                                        <?php echo $jumpasien; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card card-statistic-1">
                                <div class="card-icon bg-success">
                                    <i class="fas fa-diagnoses"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Dokter</h4>
                                    </div>
                                    <div class="card-body">
                                        <?php echo $jumlahdokter; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Jumlah Banyaknya Orang yang Appointment</h4>
                                </div>
                                <div class="card-body">
                                    <div style="height: 300px; width: 100%;">
                                        <canvas id="chart-area"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Layanan yang paling banyak diminati</h4>
                                </div>
                                <div class="card-body">
                                    <div style="height: 300px; width: 100%;">
                                        <canvas id="chart-bar"></canvas>
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

    <script>
    var configPie = {
        type: 'doughnut',
        data: {
            datasets: [{
                data: <?php echo json_encode($jumlah_jenis_kelamin); ?>,
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255,99,132,1)'
                ],
                labels: <?php echo json_encode($jumlah_jenis_kelamin); ?>
            }],
            labels: <?php echo json_encode($nama_jenis_kelamin); ?>
        },
        options: {
            responsive: true
        }
    };

    var configBar = {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($nama_layanan); ?>,
            datasets: [{
                label: 'Total Layanan',
                data: <?php echo json_encode($jumlah_layanan); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };

    document.addEventListener('DOMContentLoaded', function() {
        var ctxPie = document.getElementById('chart-area').getContext('2d');
        window.myPie = new Chart(ctxPie, configPie);

        var ctxBar = document.getElementById('chart-bar').getContext('2d');
        window.myBar = new Chart(ctxBar, configBar);
    });
    </script>
</body>

</html>