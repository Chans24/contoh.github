<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wedding_organizer";

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mendapatkan data dari form
$nama_wo = $_POST['nama-wo'];
$tagline_wo = $_POST['tagline-wo'];
$jenis_paket = $_POST['jenis-paket'];
$deskripsi_paket = $_POST['deskripsi-paket'];
$harga_paket = $_POST['harga-paket'];

// Menyimpan data ke dalam database
$sql = "INSERT INTO konten_wo (nama_wo, tagline_wo, jenis_paket, deskripsi_paket, harga_paket) VALUES ('$nama_wo', '$tagline_wo', '$jenis_paket', '$deskripsi_paket', '$harga_paket')";

if ($conn->query($sql) === TRUE) {
    echo "Data berhasil disimpan";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
