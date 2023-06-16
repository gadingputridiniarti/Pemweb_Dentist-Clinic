<?php
    include 'koneksi.php';
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APPOINTMENT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <style>
    .card-header {
        background-color: #00a6d0;
        color: #fff;
        text-align: center;
        font-size: 28px;
        font-family: Poppins;
    }

    .card-footer {
        background-color: #000;
        color: #00a6d0;
        font-size: 15px;
        text-align: center;
    }

    .warning {
        color: #00a6d0;
    }
    </style>
</head>
<style>
body {
    background-image: url('form_appoinment.jpg');
    background-size: cover;
    background-position: center;
    height: auto;
}
</style>

<body>

    <?php
    $error_created_at ="";
    $error_nama_pasien=""; 
    $error_jenis_kelamin="";
    $error_telephone="";
    $error_alamat="";
    $error_tglperiksa="";
    $error_layanan="";

    $created_at = date('Y-m-d');
    $nama_pasien = "";
    $jenis_kelamin="";
    $telephone="";
    $alamat="";
    $tglperiksa="";
    $layanan="";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["nama_pasien"])) {
            $error_nama_pasien = "Nama pasien tidak boleh kosong";
        } else {
            $nama_pasien = cek_input($_POST["nama_pasien"]);
            if (!preg_match("/^[a-zA-Z ]*$/", $nama_pasien)) {
                $error_nama_pasien = "Inputan hanya boleh berisi huruf dan spasi";
            }
        }

        if (empty($_POST["jenis_kelamin"])) {
            $error_jenis_kelamin = "Jenis kelamin tidak boleh kosong";
        } else {
            $jenis_kelamin = cek_input($_POST["jenis_kelamin"]);
        }

        if (empty($_POST["telephone"])) {
            $error_telephone = "Nomor HP tidak boleh kosong";
        } else {
            $telephone = cek_input($_POST["telephone"]);
            if (!is_numeric($telephone)) {
                $error_telephone = 'Nomor HP hanya boleh berisi angka';
            }
        }

        if (empty($_POST["alamat"])) {
            $error_alamat = "Alamat tidak boleh kosong";
        } else {
            $alamat = cek_input($_POST["alamat"]);
        }

        if (empty($_POST["tglperiksa"])) {
            $error_tglperiksa = "Tanggal periksa tidak boleh kosong";
        } else {
            $tglperiksa = cek_input($_POST["tglperiksa"]);
        }

        if (empty($_POST["layanan"])) {
            $error_layanan = "Pilih salah satu layanan";
        } else {
            $layanan = cek_input($_POST["layanan"]);
        }
    }

    function cek_input($data) {
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $sql = mysqli_query($conn, "select max(id) as maxID from appointment");
    $data = mysqli_fetch_array($sql);

    $kode = $data['maxID'];
    $kode++;
    $ket = date("Ymd");
    $kodeauto = $ket . sprintf("%03s", $kode);
    ?>

    <div class=" row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-5">
                <div class="card-header">
                    <b>Appointment Klinik Gigi DESCIC</b>
                </div>
                <div class="card-body">
                    <form method="post" action="proses_appointment.php">
                        <div class="form-group row">
                            <label for="id" class="col-sm-4 col-form-label">ID</label>
                            <div class="col-sm-8">
                                <input type="number" name="id" value="<?php echo $kodeauto?>" class="form-control"
                                    readonly>
                            </div>
                        </div>
                        <br>

                        <div class="form-group row">
                            <label for="nama_pasien" class="col-sm-4 col-form-label">Nama Pasien</label>
                            <div class="col-sm-8">
                                <input type="text" name="nama_pasien"
                                    class="form-control <?php echo ($error_nama_pasien != "" ? "is-invalid" : ""); ?>"
                                    id="nama_pasien" placeholder="Silakan isi nama Anda"
                                    value="<?php echo $nama_pasien; ?>">
                                <span class="invalid-feedback"><?php echo $error_nama_pasien; ?></span>
                            </div>
                        </div>
                        <br>

                        <div class="form-group row">
                            <label for="jenis_kelamin" class="col-sm-4 col-form-label">Jenis Kelamin</label>
                            <div class="col-sm-8">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki-laki"
                                        value="Laki-laki">
                                    <label class="form-check-label" for="laki-laki">Laki-laki</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan"
                                        value="Perempuan" required>
                                    <label class="form-check-label" for="perempuan">Perempuan</label>
                                </div>
                                <span class="invalid-feedback"><?php echo $error_jenis_kelamin; ?></span>
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="telephone" class="col-sm-4 col-form-label">Telephone</label>
                            <div class="col-sm-8">
                                <input type="text" name="telephone"
                                    class="form-control <?php echo ($error_telephone != "" ? "is-invalid" : ""); ?>"
                                    id="telephone" placeholder="Nomor HP" value="<?php echo $telephone; ?>">
                                <span class="invalid-feedback"><?php echo $error_telephone; ?></span>
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="alamat" class="col-sm-4 col-form-label">Alamat</label>
                            <div class="col-sm-8">
                                <textarea name="alamat"
                                    class="form-control <?php echo ($error_alamat != "" ? "is-invalid" : ""); ?>"
                                    id="alamat" placeholder="Silakan isi alamat Anda"><?php echo $alamat; ?></textarea>
                                <span class="invalid-feedback"><?php echo $error_alamat; ?></span>
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="tglperiksa" class="col-sm-4 col-form-label">Tanggal Periksa</label>
                            <div class="col-sm-8">
                                <input type="date" name="tglperiksa"
                                    class="form-control <?php echo ($error_tglperiksa != "" ? "is-invalid" : ""); ?>"
                                    id="tglperiksa" value="<?php echo $tglperiksa; ?>">
                                <span class="invalid-feedback"><?php echo $error_tglperiksa; ?></span>
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="layanan" class="col-sm-4 col-form-label">Pilih Layanan</label>
                            <div class="col-sm-8">
                                <select class="form-control <?php echo ($error_layanan != "" ? "is-invalid" : ""); ?>"
                                    name="layanan">
                                    <option value="">- Pilih -</option>
                                    <option value="Bleaching">Bleaching</option>
                                    <option value="Invisalign">Invisalign</option>
                                    <option value="PencabutanGigi">Pencabutan Gigi</option>
                                    <option value="ImplanGigi">Implan Gigi</option>
                                    <option value="BehelGigi">Behel Gigi</option>
                                    <option value="Scaling">Scaling</option>
                                    <option value="TambalGigi">Tambal Gigi</option>
                                    <option value="GigiPalsu">Gigi Palsu</option>
                                </select>
                                <span class="invalid-feedback"><?php echo $error_layanan; ?></span>
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <div class="col-sm-12 text-center">
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>