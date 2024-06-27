<?php
include 'koneksi.php';
date_default_timezone_set('Asia/Jakarta');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $nama = $_POST["nama"];
    $jenisAbsensi = $_POST["jenis_absensi"];
    $fotoSelfie = $_POST["foto_selfie"];
    $latitude = $_POST["latitude"];
    $longitude = $_POST["longitude"];
    $alasan = $_POST["alasan"];
    $waktu_absensi = date('Y-m-d'); 
    
    // Get the current time
    $waktu = date('H:i:s'); // Format the time as HH:MM:SS
    
    // Tentukan jam batas untuk tidak dianggap telat (contoh: 08:00:00)
    $batasTelat = '08:00:00';

    // Set the initial status
    $batasTelatPulang = '17:00:00';

    // Set the initial status
    if ($jenisAbsensi == "Masuk") {
        $status = (strtotime($waktu) > strtotime($batasTelat)) ? "telat" : "tidak telat";
    } elseif ($jenisAbsensi == "Pulang") {
        $status = (strtotime($waktu) < strtotime($batasTelatPulang)) ? "telat" : "tidak telat";
    } else {
        $status = "Tidak valid"; // Atur status ke "Tidak valid" jika jenis absensi tidak valid
    }
    // Generate nama file gambar pendek dengan timestamp
    $namaFile = time() . ".jpg"; // Contoh: 1637680123.jpg

    // Simpan foto selfie dengan nama file baru
    $lokasiSimpan = "img/" . $namaFile; // Direktori folder "img"
    file_put_contents($lokasiSimpan, base64_decode(explode(",", $fotoSelfie)[1]));
    
    // SQL untuk menyimpan data absensi ke tabel
    $sql = "INSERT INTO absensi (nama, jenis_absensi, foto_selfie, latitude, longitude, waktu_absensi, waktu, alasan, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Bind parameters, including $status
    $stmt->bind_param("ssssdssss", $nama, $jenisAbsensi, $namaFile, $latitude, $longitude, $waktu_absensi, $waktu, $alasan, $status);

    if ($stmt->execute()) {
        ?><script language="JavaScript">alert('Absensi Berhasil!');
        document.location='index.php'</script><?php
    } else {
        ?><script language="JavaScript">alert('Absensi Gagal!');
        document.location='absen.php'</script><?php
    }

    $stmt->close();
    $conn->close();
}
?>
