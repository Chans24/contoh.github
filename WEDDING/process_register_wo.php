<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jasa_pernikahan";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_wo = $_POST['nama-wo'];
    $jenis_layanan = $_POST['jenis-layanan'];
    $deskripsi_layanan = $_POST['deskripsi-layanan'];
    $kontak_person = $_POST['kontak-person'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $website = $_POST['website'];
    $media_sosial = $_POST['media-sosial'];
    $harga = $_POST['harga'];
    $daftar_layanan = $_POST['daftar-layanan'];

    $sql = "INSERT INTO wedding_organizer (nama_wo, jenis_layanan, deskripsi_layanan, kontak_person, telepon, email, alamat, website, media_sosial, harga, daftar_layanan)
    VALUES ('$nama_wo', '$jenis_layanan', '$deskripsi_layanan', '$kontak_person', '$telepon', '$email', '$alamat', '$website', '$media_sosial', '$harga', '$daftar_layanan')";

    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;

        // Menangani upload file untuk portofolio
        if (!empty($_FILES['portofolio']['name'][0])) {
            foreach ($_FILES['portofolio']['tmp_name'] as $key => $tmp_name) {
                $file_name = basename($_FILES['portofolio']['name'][$key]);
                $target_file = "uploads/portofolio/" . $file_name;
                if (move_uploaded_file($tmp_name, $target_file)) {
                    $sql_portofolio = "INSERT INTO portofolio (wedding_organizer_id, file_path) VALUES ('$last_id', '$target_file')";
                    $conn->query($sql_portofolio);
                }
            }
        }

        // Menangani upload file untuk foto KTP
        $foto_ktp = $_FILES['foto-ktp']['tmp_name'];
        if ($foto_ktp) {
            $foto_ktp_name = basename($_FILES['foto-ktp']['name']);
            $target_foto_ktp = "uploads/dokumen_pendukung/" . $foto_ktp_name;
            if (move_uploaded_file($foto_ktp, $target_foto_ktp)) {
                $sql_foto_ktp = "INSERT INTO dokumen_pendukung (wedding_organizer_id, file_path, dokumen_type) VALUES ('$last_id', '$target_foto_ktp', 'KTP')";
                $conn->query($sql_foto_ktp);
            }
        }

        // Menangani upload file untuk surat izin
        $surat_izin = $_FILES['surat-izin']['tmp_name'];
        if ($surat_izin) {
            $surat_izin_name = basename($_FILES['surat-izin']['name']);
            $target_surat_izin = "uploads/dokumen_pendukung/" . $surat_izin_name;
            if (move_uploaded_file($surat_izin, $target_surat_izin)) {
                $sql_surat_izin = "INSERT INTO dokumen_pendukung (wedding_organizer_id, file_path, dokumen_type) VALUES ('$last_id', '$target_surat_izin', 'Surat Izin')";
                $conn->query($sql_surat_izin);
            }
        }

        echo "Data berhasil disimpan!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
