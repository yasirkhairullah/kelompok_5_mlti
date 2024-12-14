<?php
include 'koneksi.php';
include 'sidebar.php';

// Mengambil tanggal hari ini dalam format MySQL
$current_date = date("Y-m-d");

// Mengubah kueri SQL untuk memilih data transaksi sesuai dengan tanggal hari ini
$sql = "SELECT nota_no, nama_pelanggan, jenis_kendaraan, tanggal_transaksi FROM transaksi WHERE DATE(tanggal_transaksi) = '$current_date'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Jasa Cuci</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            margin: 0 auto;
            padding: 20px;
            max-width: 175vh;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-left: 270px;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: black;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th, .table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .table th {
            background-color: #f8f9fa;
            color: #333;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            margin-right: 8px;
            transition: background-color 0.3s;
        }

        .btn-success {
            background-color: #28a745;
            color: #fff;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
        }

        .btn-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .btn-danger {
            background-color: #dc3545;
            color: #fff;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .no-data {
            text-align: center;
            font-size: 16px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Daftar Transaksi Hari Ini - <span id="current-date"></span></h2>
        <a href="add.php" class="btn btn-success mb-3">Tambah Data</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No. Nota</th>
                    <th>Nama Pelanggan</th>
                    <th>Jenis Kendaraan</th>
                    <th>Tanggal</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $no = 1; // Initialize the counter variable
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $no . "</td>
                                <td>" . $row["nota_no"] . "</td>
                                <td>" . $row["nama_pelanggan"] . "</td>
                                <td>" . $row["jenis_kendaraan"] . "</td>
                                <td>" . date("d M Y", strtotime($row["tanggal_transaksi"])) . "</td>
                                <td>
                                    <a href='cetak_nota.php?nota_no=" . $row["nota_no"] . "' class='btn btn-primary'>Cetak Nota</a>
                                    <a href='edit_transaksi.php?nota_no=" . $row["nota_no"] . "' class='btn btn-warning'>Edit</a>
                                    <a href='hps_transaksi.php?nota_no=" . $row["nota_no"] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this record?\")'>Hapus</a>
                                </td>
                              </tr>";
                        $no++; // Increment the counter
                    }
                } else {
                    echo "<tr><td colspan='6' class='no-data'>Tidak ada transaksi hari ini</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script>
        // JavaScript to add the current date
        document.addEventListener('DOMContentLoaded', (event) => {
            const currentDateElement = document.getElementById('current-date');
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            const today = new Date().toLocaleDateString('id-ID', options);
            currentDateElement.textContent = today;
        });
    </script>
</body>
</html>
