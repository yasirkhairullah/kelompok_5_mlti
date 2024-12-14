<?php
// Menghubungkan ke database
include 'koneksi.php';

// Fungsi untuk mengubah format tanggal menjadi DD-MM-YYYY
function formatTanggal($tanggal) {
    $tgl = strtotime($tanggal); // Mengonversi string tanggal menjadi timestamp
    return date("d-m-Y", $tgl); // Mengonversi ke format DD-MM-YYYY
}

// Inisialisasi variabel untuk filter tanggal awal dan akhir
$tanggal_awal = isset($_GET['tanggal_awal']) && strtotime($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : '';
$tanggal_akhir = isset($_GET['tanggal_akhir']) && strtotime($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : '';

// Validasi input tanggal
if (empty($tanggal_awal) || empty($tanggal_akhir)) {
    echo "<p>Harap masukkan rentang tanggal yang valid untuk melihat laporan.</p>";
    exit;
}

// Mengubah format tanggal menjadi YYYY-MM-DD untuk query
$tanggal_awal = date("Y-m-d", strtotime($tanggal_awal));
$tanggal_akhir = date("Y-m-d", strtotime($tanggal_akhir));

// Query untuk menghitung total transaksi dan total pendapatan per jenis kendaraan berdasarkan rentang waktu
$sql = "SELECT jenis_kendaraan, COUNT(*) AS total_transaksi, SUM(biaya) AS total_pendapatan
        FROM transaksi 
        WHERE DATE(tanggal_transaksi) BETWEEN ? AND ?
        GROUP BY jenis_kendaraan";

// Menyiapkan statement
$stmt = $conn->prepare($sql);

// Bind parameter tanggal awal dan tanggal akhir
$stmt->bind_param("ss", $tanggal_awal, $tanggal_akhir);

// Menjalankan query
$stmt->execute();

// Mengambil hasil query
$result = $stmt->get_result();

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

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: black;
            text-align: center; /* Posisi center */
            border-bottom: 2px solid #ddd; /* Garis bawah */
            padding-bottom: 10px; /* Jarak antara teks dan garis */
        }
    </style>
</head>
<body>
    <h2>Laporan Transaksi</h2>
    <h4>Periode:<br> <?php echo formatTanggal($tanggal_awal); ?> s/d <?php echo formatTanggal($tanggal_akhir); ?></h4>
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
            // Memeriksa apakah hasil query mengandung data
            if ($result->num_rows > 0) {
                // Melakukan iterasi untuk menampilkan setiap baris hasil query
                while ($row = $result->fetch_assoc()) {
                    // Menampilkan data transaksi dalam bentuk baris tabel
                    echo "<tr>
                            <td>" . htmlspecialchars($row["jenis_kendaraan"]) . "</td>
                            <td>" . htmlspecialchars($row["total_transaksi"]) . "</td>
                            <td>Rp " . number_format($row["total_pendapatan"], 0, ',', '.') . "</td>
                          </tr>";
                    // Menambahkan total transaksi dan pendapatan untuk total keseluruhan
                    $total_transaksi_keseluruhan += $row["total_transaksi"];
                    $total_pendapatan_keseluruhan += $row["total_pendapatan"];
                }
            } else {
                // Menampilkan pesan jika tidak ada data transaksi
                echo "<tr><td colspan='3'>Tidak ada data transaksi untuk periode ini.</td></tr>";
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td><strong>Total Keseluruhan</strong></td>
                <td><?php echo $total_transaksi_keseluruhan; ?></td>
                <td>Rp <?php echo number_format($total_pendapatan_keseluruhan, 0, ',', '.'); ?></td>
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
            window.location.href = "laporan_bulan_ini.php?tanggal_awal=<?php echo urlencode($tanggal_awal); ?>&tanggal_akhir=<?php echo urlencode($tanggal_akhir); ?>";
        };
    </script>
</body>
</html>

<?php
// Menutup statement
$stmt->close();

// Menutup koneksi
$conn->close();
?>
