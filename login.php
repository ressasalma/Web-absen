<?php
require 'koneksi.php'; 
session_start();

// cek cookie
if (isset($_COOKIE['username']) && isset($_COOKIE['key'])) {
    $username = $_COOKIE['username'];
    $key = $_COOKIE['key'];

    // ambil username berdasarkan id
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    $row = mysqli_fetch_assoc($result);

    // cek cookie dan username
    if ($key === hash('sha256', $row['username'])) {
        $_SESSION['login'] = true;
    }
}

if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (empty($username) || empty($password)) {
        echo "<script language='JavaScript'>
            alert('Username dan password wajib diisi');
            document.location = 'login.php';
            </script>";
        exit;
    }

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    // cek username
    if (mysqli_num_rows($result) === 1) {
        // cek password
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            // set session
            $_SESSION["login"] = true;
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $id;
            // cek remember me
            if (isset($_POST['remember'])) {
                // buat cookie
                setcookie('username', $row['username'], time() + 3600); // Anda dapat menyesuaikan waktu kadaluwarsa
                setcookie('key', hash('sha256', $row['username']), time() + 3600); // Anda dapat menyesuaikan waktu kadaluwarsa
            }

            header("Location: index.php");
            exit;
        } else {
            echo "<script language='JavaScript'>
                alert('Username atau password salah');
                document.location = 'login.php';
                </script>";
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Absensi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Tambahkan gaya kustom Anda di sini jika diperlukan */
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card rounded">
                    <div class="card-header bg-danger text-white text-center">
                        <img src="img/logo.png" width="50px">
                        <h1><i class="fa fa-user"></i> Login</h1>
                        <h6>Masukkan username dan password Anda untuk login ke sistem</h6>
                    </div>
                    <div class="card-body">
                        <form id="form-login" action="" method="post">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password" required>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Remember me :</label>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" name="login" class="btn btn-danger btn-block"><i class="fa fa-sign-in"></i> Login</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <a class="btn btn-danger btn-block" href="forgot"><i class="fa fa-key"></i> Reset Password</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Skrip JavaScript Bootstrap (opsional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
