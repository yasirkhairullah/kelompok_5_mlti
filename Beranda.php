<?php
    include 'koneksi.php';
    include 'sidebar.php';

    // Ambil jumlah pelanggan hari ini
    $get1 = mysqli_query($conn, "SELECT * FROM transaksi WHERE DATE(tanggal_transaksi) = CURDATE()");
    $count1 = mysqli_num_rows($get1);

    // Ambil jumlah pelanggan
    $get2 = mysqli_query($conn, "SELECT * FROM transaksi");
    $count2 = mysqli_num_rows($get2);

    // Ambil pendapatan hari ini
    $get3 = mysqli_query($conn, "SELECT SUM(biaya) AS pendapatan_hari_ini FROM transaksi WHERE DATE(tanggal_transaksi) = CURDATE()");
    $row3 = mysqli_fetch_assoc($get3);
    $pendapatan_hari_ini = $row3['pendapatan_hari_ini'];

    // Ambil pendapatan bulan ini
    $get4 = mysqli_query($conn, "SELECT SUM(biaya) AS pendapatan_bulan_ini FROM transaksi WHERE MONTH(tanggal_transaksi) = MONTH(CURDATE()) AND YEAR(tanggal_transaksi) = YEAR(CURDATE())");
    $row4 = mysqli_fetch_assoc($get4);
    $pendapatan_bulan_ini = $row4['pendapatan_bulan_ini'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dasbor Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Content area */
        .container {
            margin: 0 auto;
            padding: 20px;
            max-width: 175vh;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-left: 270px;
            margin-top: 50px;
        }

        .summary-box {
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            height: 100%;
            margin-bottom: 20px;
            background-color: #ffffff;
            border-left: 5px solid #007bff;
        }

        .summary-box h2 {
            font-size: 16px;
            margin-bottom: 10px;
            color: #333333;
        }

        .summary-box p {
            font-size: 22px;
            font-weight: bold;
            margin: 0;
            color: #007bff;
        }

        .icon {
            font-size: 24px;
            margin-bottom: 10px;
            color: #007bff;
        }
    </style>
</head>
<body>
    <!-- Content area -->
    <div class="container">
        <h2>Selamat Datang di Aplikasi Kasir Platinum Motor</h2>
        <p>Silakan mulai menggunakan fitur-fitur yang tersedia.</p>

        <div class="row">
            <div class="col-md-3">
                <div class="summary-box">
                    <h2><i class="fas fa-chart-line icon"></i> Total Transaksi Hari Ini</h2>
                    <p><?php echo $count1; ?></p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-box">
                    <h2><i class="fas fa-clipboard-list icon"></i> Total Transaksi</h2>
                    <p><?php echo $count2; ?></p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-box">
                    <h2><i class="fas fa-money-bill-wave icon"></i> Pemasukan Hari Ini</h2>
                    <p>Rp. <?php echo number_format($pendapatan_hari_ini, 0, ',', '.'); ?></p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-box">
                    <h2><i class="fas fa-coins icon"></i> Pemasukan Bulan Ini</h2>
                    <p>Rp. <?php echo number_format($pendapatan_bulan_ini, 0, ',', '.'); ?></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
