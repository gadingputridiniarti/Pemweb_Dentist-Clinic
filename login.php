<?php
include 'koneksi.php';
session_start();
error_reporting(0);

if (isset($_SESSION['username'])) {
    // Jika session username sudah ada, redirect ke halaman appointment
    header("Location: appointment.php");
    exit();
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $row['username'];
        header("Location: appointment.php");
        exit();
    } else {
        echo "<script>alert('Woops! username Atau Password anda Salah.')</script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>DESCIC</title>
</head>

<body style="background-image: url('form_appoinment.jpg');">
    <div class="container">
        <?php if (!isset($_SESSION['username'])) : ?>
        <!-- Tampilkan formulir login jika session belum ada -->
        <form action="" method="POST" class="login-email">
            <p class="login-text" style="font-size: 2rem; font-weight: 800;">Login</p>
            <div class="input-group">
                <input type="usernamel" placeholder="username" name="username" value="<?php echo $_POST['username'] ; ?>" required>
            </div>
            <div class="input-group">
                <input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>"
                    required>
            </div>
            <div class="input-group">
                <button name="submit" class="btn">Login</button>
            </div>
            <p class="login-register-text">Don't have an account? <a href="register.php">Register Here</a>.</p>
        </form>
        <?php else : ?>
        <!-- Tampilkan pesan jika sudah login -->
        <p>Welcome, <?php echo $_SESSION['username']; ?>!</p>
        <p>You can make an appointment now.</p>
        <a href="appointment.php">Make Appointment</a>
        <?php endif; ?>
    </div>
</body>

</html>