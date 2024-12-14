<?php
include 'koneksi.php';
include 'sidebar.php';

$sql = "SELECT id, jenis_kendaraan, biaya FROM biaya_kendaraan";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biaya Kendaraan</title>
    <style>
        /* CSS for table */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th, .table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #dee2e6;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        /* CSS for buttons */
        .btn {
            padding: 8px 16px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            border-radius: 4px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-success {
            color: #fff;
            background-color: #28a745;
            border: 1px solid #28a745;
        }

        .btn-warning {
            color: #212529;
            background-color: #ffc107;
            border: 1px solid #ffc107;
        }

        .btn-danger {
            color: #fff;
            background-color: #dc3545;
            border: 1px solid #dc3545;
        }

        .btn:hover {
            opacity: 0.8;
        }

        /* CSS for container */
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
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Biaya Kendaraan</h2>
        <a href="tambah_kendaraan.php" class="btn btn-success mb-3">Tambah Biaya Kendaraan</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Kendaraan</th>
                    <th>Biaya</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $nomor = 1; // Inisialisasi nomor urut
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $nomor++ . "</td>
                                <td>" . $row["jenis_kendaraan"] . "</td>
                                <td>RP. " . number_format($row["biaya"], 0, ',', '.') . "</td>
                                <td>
                                    <a href='edit_biaya_kendaraan.php?id=" . $row["id"] . "' class='btn btn-warning'>Edit</a>
                                    <a href='hapus_biaya_kendaraan.php?id=" . $row["id"] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this record?\")'>Hapus</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Tidak ada data ditemukan</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
