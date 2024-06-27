<?php 
session_start();
include 'koneksi.php';
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
$jenis_absensi = isset($_GET['jenis_absensi']) ? $_GET['jenis_absensi'] : "Masuk";
 ?>

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
	<style type="text/css">
		 video {
        width: 100%;
        height: 100%;
    }
    	 textarea {
        width: 100%;
        height: 100%;
    }
    .preview {
        width: 100%;
        height: 100%;
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
				<!-- Tombol untuk mengaktifkan kamera dan deteksi lokasi -->
    <button type="button" id="aktifkan-kamera" class="btn btn-primary">Aktifkan Kamera</button>

    <!-- Elemen video untuk menampilkan tampilan kamera (awalnya disembunyikan) -->
    <video id="kamera" autoplay playsinline style="display: none;"></video>

    <button type="button" id="ambil-foto" style="display: none;" class="btn btn-primary">Ambil Selfie</button>
    

    <!-- Elemen img untuk menampilkan preview foto (awalnya disembunyikan) -->
    <img id="preview-foto" class="preview" style="display: none;" />
    <button type="button" id="ambil-ulang" style="display: none;" class="btn btn-success">Ambil Ulang</button>


    <!-- Informasi lokasi -->
    <div style="display: none;">
        <p>Lokasi Anda:</p>
        <p id="latitude">Latitude: </p>
        <p id="longitude">Longitude: </p>
    </div>

    <form action="proses_absen.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="nama" value="<?php echo $_SESSION['username']?>">

        <input type="hidden" name="jenis_absensi" value="<?php echo $jenis_absensi; ?>">

        <!-- Input tersembunyi untuk menyimpan data URL foto -->
        <input type="hidden" name="foto_selfie" id="foto-selfie" required><br><br>
        <textarea name="alasan" rows="4" cols="50" placeholder="Masukkan alasan absensi..." required></textarea><br><br>
    <!-- Input tersembunyi untuk menyimpan informasi lokasi -->
        <!-- Input tersembunyi untuk menyimpan informasi lokasi -->
        <input type="hidden" name="latitude" id="latitude-input" required>
        <input type="hidden" name="longitude" id="longitude-input" required>
        
        <button type="submit" id="simpan-absensi" style="display: none;" class="btn btn-danger">Simpan Absensi</button><br>	<br>	<br>	
    </form>
    
	<!-- Footer -->				
<!-- 	<footer>
		<div class="footer">
				<div class="float-end">
					<p>Crafted with 
						<span class="text-danger">
							<i class="fa fa-heart"></i> by 
							<a href="https://www.facebook.com/andreew.co.id/" class="author-footer">Andre Tri Ramadana</a>
						</span> 
					</p>
			</div>
		</div>
	</footer>
 -->

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
        var video = document.getElementById("kamera");
        var previewFoto = document.getElementById("preview-foto");
        var fotoSelfieInput = document.getElementById("foto-selfie");

        document.getElementById("aktifkan-kamera").addEventListener("click", function () {
            // Menampilkan elemen video (tampilan kamera)
            video.style.display = "block";

            // Menggunakan getUserMedia API untuk mengaktifkan kamera
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(function (stream) {
                    video.srcObject = stream;
                    video.play();

                    // Menampilkan tombol "Ambil Selfie" setelah mengaktifkan kamera
                    document.getElementById("ambil-foto").style.display = "block";
                    document.getElementById("aktifkan-kamera").style.display = "none";
                })
                .catch(function (error) {
                    console.error("Error mengaktifkan kamera: " + error);
                });

            // Mendeteksi lokasi pengguna
            // ...
			if (navigator.geolocation) {
			    navigator.geolocation.getCurrentPosition(function (position) {
			        var latitude = position.coords.latitude;
			        var longitude = position.coords.longitude;


			        // Mengisi nilai input tersembunyi dengan informasi lokasi
			        document.getElementById("latitude-input").value = latitude;
			        document.getElementById("longitude-input").value = longitude;
			    });
			} else {
			    console.log("Geolocation tidak didukung oleh perangkat ini.");
			}
// ...

        });

        document.getElementById("ambil-foto").addEventListener("click", function () {
            // Membuat elemen canvas untuk mengambil foto
            var canvas = document.createElement("canvas");
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            canvas.getContext("2d").drawImage(video, 0, 0, canvas.width, canvas.height);

            // Mengambil data URL foto
            var fotoDataUrl = canvas.toDataURL("image/jpeg");

            // Menampilkan preview foto
            previewFoto.style.display = "block";
            previewFoto.src = fotoDataUrl;

            // Mengisi nilai input tersembunyi dengan data URL foto
            fotoSelfieInput.value = fotoDataUrl;

            // Menampilkan tombol "Simpan Absensi"
            document.getElementById("simpan-absensi").style.display = "block";

            // Menyembunyikan tampilan kamera
            video.style.display = "none";
			document.getElementById("ambil-ulang").style.display = "block";
			    document.getElementById("simpan-absensi").style.display = "block";

			    // Menyembunyikan tombol "Ambil Foto"
			    this.style.display = "none";
			});

			document.getElementById("ambil-ulang").addEventListener("click", function () {
			    // Menyembunyikan preview foto
			    previewFoto.style.display = "none";

			    // Mengosongkan nilai input tersembunyi untuk data URL foto
			    fotoSelfieInput.value = "";

			    // Menampilkan kembali elemen video (kamera)
			    video.style.display = "block";

			    // Menampilkan tombol "Ambil Foto" dan menyembunyikan tombol "Ambil Ulang" dan "Simpan Absensi"
			    document.getElementById("ambil-foto").style.display = "block";
			    this.style.display = "none";
			    document.getElementById("simpan-absensi").style.display = "none";
			});
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