<?php
include 'koneksi.php';

if (isset($_GET['nota_no'])) {
    $nota_no = $_GET['nota_no'];

    // Fetch the transaksi data
    $sql = "SELECT * FROM transaksi WHERE nota_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nota_no);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<script>alert('Record not found');window.location.href='transaksi.php';</script>";
        exit;
    }
    $stmt->close();
} else {
    echo "<script>alert('No Nota No specified');window.location.href='transaksi.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Invoice</title>
    <style>
        /* CSS for container */
        .container {
            margin: 0 auto;
            padding: 20px;
            max-width: 300px;
            font-family: Arial, sans-serif;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* CSS for header */
        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        /* CSS for invoice details */
        .invoice-details {
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .invoice-details p {
            margin: 0;
            line-height: 1.5;
        }

        /* CSS for items */
        .item {
            margin-bottom: 10px;
            line-height: 1.5;
        }

        /* CSS for total */
        .total {
            text-align: right;
            font-weight: bold;
            margin-top: 10px;
        }

        /* CSS for buttons */
        .btn-container {
            text-align: center;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            width: 100%;
        }

        .btn:hover {
            background-color: #45a049;
        }

        /* CSS for print */
        @media print {
            body * {
                visibility: hidden;
            }
            .container, .container * {
                visibility: visible;
            }
            .container {
                position: absolute;
                left: 0;
                top: 0;
            }
            .cancel-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Nota Transaksi</h2>
        </div>
        <div class="invoice-details">
            <p>No. Nota: <?php echo $row['nota_no']; ?></p>
            <p>Tanggal: <?php echo date("d M Y"); ?></p>
        </div>
        <div class="item">
            <p>Nama Pelanggan: <?php echo $row['nama_pelanggan']; ?></p>
            <p>Jenis Kendaraan: <?php echo $row['jenis_kendaraan']; ?></p>
            <p>Biaya: <?php echo $row['biaya']; ?></p>
            <p>Bayar: <?php echo $row['bayar']; ?></p>
            <p>Kembalian: <?php echo $row['kembalian']; ?></p>
        </div>
        <div class="total">
            <p>Total: <?php echo $row['biaya']; ?></p>
        </div>
        <div class="thankyou">
            <p>--- Terima kasih atas kunjungan Anda ---</p>
        </div>
        <div class="btn-container">
            <button class="btn cancel-button" onclick="window.print()">Cetak</button>
        </div>
    </div>
    <script>
        // Setelah mencetak, kembali ke transaksi.php
        window.onload = function() {
            window.onafterprint = function() {
                window.location.href = 'transaksi.php';
            };
            window.print();
        };
    </script>
</body>
</html>

