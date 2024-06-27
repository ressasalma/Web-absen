<?php 
session_start();
include 'koneksi.php';
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
$username = $_SESSION['username']; // Ambil username pengguna yang sedang login

$query = "SELECT jenis_absensi FROM absensi WHERE nama = '$username' AND `waktu_absensi` = CURDATE()";
// var_dump($query);
// die();
$result = mysqli_query($conn, $query);

$jenis_absensi = "Masuk"; // Defaultnya adalah Masuk

if ($result && mysqli_num_rows($result) > 0) {
    // Pengguna sudah absen hari ini, maka jenis absensi diubah menjadi Pulang
    $jenis_absensi = "Pulang";
}
?>

<!doctype html>
<html lang="en">
  <head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>Dashboard - Atrana</title>

	<!-- Bootstrap CSS-->
	<link rel="stylesheet" href="assets/modules/bootstrap-5.1.3/css/bootstrap.css">
	<!-- Style CSS -->
	<link rel="stylesheet" href="assets/css/style.css">
	<!-- FontAwesome CSS-->
	<link rel="stylesheet" href="assets/modules/fontawesome6.1.1/css/all.css">
	<!-- Boxicons CSS-->
	<link rel="stylesheet" href="assets/modules/boxicons/css/boxicons.min.css">
	<!-- Apexcharts  CSS -->
	<link rel="stylesheet" href="assets/modules/apexcharts/apexcharts.css">
	<style>
        #clock{
            font-size: 30px;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
            color: black;
        }
        #date{
            font-size: 15px;
            font-weight: bold;
            text-align: center;
            margin-top: 3px;
            color: black;
        }
        .isi {
            display: flex;
            justify-content: space-between;
        }

        .kotak {
            width: 48%; /* Lebar dua kotak card */
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body style="background: #b01533;">
  
  <!--Topbar -->
  <div class="topbar transition">
	<div class="bars">
		<button type="button" class="btn transition" id="sidebar-toggle">
			<i class="fa fa-bars"></i>
		</button>
	</div>
		<div class="menu">
			<ul>
			 
				  <li class="nav-item dropdown">
					<a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
					  <img src="assets/images/avatar/avatar-1.png" alt="">
					</a>
				  </li>
			</ul>
		</div>
	</div>

	<!--Sidebar-->
	<div class="sidebar transition overlay-scrollbars animate__animated  animate__slideInLeft" style="background: white;" >
        <div class="sidebar-content"> 
        	<div id="sidebar">
			
			<!-- Logo -->
			<div class="logo" style="background: #b01533;">
					<h2 class="mb-0"><img src="img/logo.png"> GeoAbsen</h2>
			</div>

            <ul class="side-menu" >
            	<li style="color:black;">
            		Menu
            	</li>
                <li>
					<a href="logout.php" style="color:black;">
						<i class='bx bxs-dashboard icon' ></i> logout
					</a>
				</li>

				

       </div> 
	 </div>
	</div><!-- End Sidebar-->


	<div class="sidebar-overlay"></div>


	<!--Content Start-->
	<div class="content-start transition" style="background: white;">
		<div class="container-fluid dashboard">
			<div class="content-header">
				<h1>GeoAbsen</h1>
				<h2><?php echo $_SESSION['username']; ?></h2>
        		<div id="clock">
    			</div>
    			<div id="date">
    			</div>
    			<div class="isi">
            <div class="kotak">
                <div class="card-body">
                    <h5 class="card-title">Jam Masuk</h5>
                    <p class="card-text">08:00</p>
                </div>
            </div>
            <div class="kotak">
                <div class="card-body">
                    <h5 class="card-title">Jam Pulang</h5>
                    <p class="card-text">17:00</p>
                </div>
            </div>
        </div>
			</div>
			
			<div>
					<div>
					    <div class="card">
					        <div class="card-body">
					            <?php
					            // Cek apakah pengguna sudah absen sebanyak dua kali pada hari ini
					            $query = "SELECT COUNT(*) AS jumlah_absen FROM absensi WHERE nama = '$username' AND waktu_absensi = CURDATE()";
					            $result = mysqli_query($conn, $query);
					            $row = mysqli_fetch_assoc($result);
					            $jumlahAbsen = $row['jumlah_absen'];

					            if ($jumlahAbsen >= 2) {
					                echo '<p class="text-center text-danger">Kamu sudah absen</p>';
					            } else {
					                echo '<a href="absen.php?jenis_absensi='.$jenis_absensi.'" class="btn btn-lg btn-block">
					                        <div class="d-flex flex-column align-items-center">
					                            <i class="fas fa-id-card fa-3x icon-home bg-warning text-light" style="width: 100%;"></i>
					                            <p class="mt-2 mb-0 text-center">Proses Absen</p>
					                        </div>
					                    </a>';
					            }
					            ?>
					        </div>
					    </div>
					</div>



					<!-- <div class="card">
						<div class="card-body">
							<a href="" class="btn row">
								<div class="col-4 d-flex align-items-center">
									<i class="fas fa-clipboard-list icon-home bg-success text-light"></i>
								</div>
							</a>
						</div>
					</div>
					<div class="card">
						<div class="card-body">
							<a href="absen.php" class="btn row">
								<div class="col-4 d-flex align-items-center">
									<i class="fas fa-chart-bar  icon-home bg-info text-light"></i>
								</div>
							</a>
						</div>
					</div> -->
				 </div>
			</div>
		</div>


	<!-- Preloader -->
	<div class="loader">
		<div class="spinner-border text-light" role="status">
			<span class="sr-only">Loading...</span>
		</div>
	</div>
	
	<!-- Loader -->
	<div class="loader-overlay"></div>

	<!-- General JS Scripts -->
	<script>
    function updateClock() {
        const clockElement = document.getElementById("clock");
        const dateElement = document.getElementById("date"); // Tambahkan elemen untuk tanggal
        const now = new Date();
        const hours = now.getHours().toString().padStart(2, "0");
        const minutes = now.getMinutes().toString().padStart(2, "0");
        const seconds = now.getSeconds().toString().padStart(2, "0");
        const dateString = now.toLocaleDateString('id-ID'); // Format tanggal dalam bahasa Indonesia

        clockElement.textContent = `${hours}:${minutes}:${seconds}`;
        dateElement.textContent = dateString; // Setel teks tanggal
    }

    // Memperbarui jam setiap detik
    setInterval(updateClock, 1000);

    // Memanggil updateClock saat halaman dimuat
    updateClock();
</script>
	<script src="assets/js/atrana.js"></script>

	<!-- JS Libraies -->
	<script src="assets/modules/jquery/jquery.min.js"></script>
	<script src="assets/modules/bootstrap-5.1.3/js/bootstrap.bundle.min.js"></script>
	<script src="assets/modules/popper/popper.min.js"></script>

	<!-- Chart Js -->
	<script src="assets/modules/apexcharts/apexcharts.js"></script>
	<script src="assets/js/ui-apexcharts.js"></script>

    <!-- Template JS File -->
	<script src="assets/js/script.js"></script>
	<script src="assets/js/custom.js"></script>
 </body>
</html>
