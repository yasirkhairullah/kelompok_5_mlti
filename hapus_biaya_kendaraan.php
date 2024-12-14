<?php
include 'koneksi.php';

// Periksa apakah parameter id telah diterima dari URL
if(isset($_GET['id'])) {
    // Lindungi parameter id dari serangan SQL injection
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Buat dan jalankan kueri DELETE
    $sql = "DELETE FROM biaya_kendaraan WHERE id = '$id'";
    if ($conn->query($sql) === TRUE) {
        // Pesan peringatan setelah penghapusan berhasil
        echo '<script>alert("Data berhasil dihapus");</script>';
        // Redirect kembali ke halaman biaya_kendaraan.php setelah penghapusan berhasil
        echo '<script>window.location.replace("data_kendaraan.php");</script>';
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "ID tidak ditemukan";
}

$conn->close();
?>
