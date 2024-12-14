<?php
// Menghubungkan ke database
include 'koneksi.php';

// Mengambil nilai tanggal dari parameter URL, atau menggunakan tanggal saat ini jika tidak ada
$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');

// Variabel untuk menentukan apakah laporan bulan ini sedang ditampilkan
$bulan_ini = isset($_GET['bulan_ini']) ? $_GET['bulan_ini'] : false;

// Menyiapkan query berdasarkan apakah laporan bulan ini atau tanggal tertentu yang dipilih
if ($bulan_ini) {
    $sql = "SELECT jenis_kendaraan, COUNT(*) AS total_transaksi, SUM(biaya) AS total_pendapatan
            FROM transaksi 
            WHERE MONTH(tanggal_transaksi) = MONTH(CURDATE()) AND YEAR(tanggal_transaksi) = YEAR(CURDATE())
            GROUP BY jenis_kendaraan";
} else {
    $sql = "SELECT jenis_kendaraan, COUNT(*) AS total_transaksi, SUM(biaya) AS total_pendapatan
            FROM transaksi 
            WHERE DATE(tanggal_transaksi) = '$tanggal'
            GROUP BY jenis_kendaraan";
}

// Menjalankan query
$result = $conn->query($sql);

// Inisialisasi total transaksi dan pendapatan keseluruhan
$total_transaksi_keseluruhan = 0;
$total_pendapatan_keseluruhan = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Transaksi</title>
    <style>
        /* CSS untuk bentuk tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 1px solid #ddd;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Laporan Transaksi</h2>
    <table>
        <thead>
            <tr>
                <th>Jenis Kendaraan</th>
                <th>Total Transaksi</th>
                <th>Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Memeriksa apakah ada data transaksi yang ditemukan
            if ($result->num_rows > 0) {
                // Melakukan iterasi melalui setiap baris hasil
                while ($row = $result->fetch_assoc()) {
                    // Menambahkan nilai total transaksi dan pendapatan keseluruhan
                    $total_transaksi_keseluruhan += $row['total_transaksi'];
                    $total_pendapatan_keseluruhan += $row['total_pendapatan'];

                    // Menampilkan data transaksi dalam baris tabel
                    echo "<tr>
                            <td>" . $row['jenis_kendaraan'] . "</td>
                            <td>" . $row['total_transaksi'] . "</td>
                            <td>" . $row['total_pendapatan'] . "</td>
                          </tr>";
                }
            } else {
                // Jika tidak ada data transaksi ditemukan
                echo "<tr><td colspan='3'>Tidak ada data transaksi</td></tr>";
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td><strong>Total Keseluruhan</strong></td>
                <td><?php echo $total_transaksi_keseluruhan; ?></td>
                <td><?php echo $total_pendapatan_keseluruhan; ?></td>
            </tr>
        </tfoot>
    </table>

    <script>
        // Otomatis memicu dialog cetak saat halaman dimuat
        window.onload = function() {
            window.print();
        };

        // Fungsi untuk melakukan redirect setelah pencetakan selesai atau dibatalkan
        window.onafterprint = function() {
            window.location.href = "laporan.php"; // Redirect ke halaman cetak_laporan.php
        };
    </script>
</body>
</html>
