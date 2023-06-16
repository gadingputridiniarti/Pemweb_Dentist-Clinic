<?php
$judul = "DESCIC";
$pecahjudul = explode(" ", $judul);
$acronym = "";

foreach ($pecahjudul as $w) {
  $acronym .= $w[0];
}
?>
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html"><?php echo $judul; ?></a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="home_admin.php"><?php echo $acronym; ?></a>
        </div>
        <ul class="sidebar-menu">
            <li <?php echo ($page == "Dashboard") ? "class=active" : ""; ?>><a class="nav-link" href="home_admin.php"><i
                        class="fas fa-fire"></i><span>Dashboard</span></a></li>
            <li class="menu-header">Menu</li>

            <li <?php echo ($page == "Rawat Jalan") ? "class=active" : ""; ?>><a class="nav-link"
                    href="Pemeriksaan.php"><i class="fas fa-stethoscope"></i> <span>Pemeriksaan</span></a></li>
            <li <?php echo ($page == "Data Pasien" || @$page1 == "det") ? "class=active" : ""; ?>><a class="nav-link"
                    href="pasien.php"><i class="fas fa-user-injured"></i> <span>Data Pasien</span></a></li>

            <li <?php echo ($page == "Data Pegawai") ? "class=active" : ""; ?>><a href="pegawai.php" class="nav-link"><i
                        class="fas fa-users"></i> <span>Data Pegawai</span></a></li>

            <li <?php echo ($page == "Data Appointment" || @$page1 == "detrot") ? "class=active" : ""; ?>><a
                    class="nav-link" href="data_appointment.php"><i class="fas fa-skull"></i>
                    <span>Appointment</span></a></li>

            <li <?php echo ($page == "Data Obat") ? "class=active" : ""; ?>><a class="nav-link" href="obat.php"><i
                        class="fas fa-briefcase-medical"></i> <span>Obat</span></a></li>

            <li <?php echo ($page == "Logout") ? "class=active" : ""; ?>>
                <a class="nav-link" href="index.html">
                    <i class="fas fa-sign-out-alt"></i> <!-- Add the logout icon class here -->
                    <span>Log Out</span>
                </a>
            </li>

    </aside>
</div>