<?php
include 'koneksi.php';
include 'sidebar.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jenis_kendaraan = $_POST["jenis_kendaraan"];
    $biaya = $_POST["biaya"];

    $sql = "INSERT INTO biaya_kendaraan (jenis_kendaraan, biaya) VALUES ('$jenis_kendaraan', '$biaya')";

    if ($conn->query($sql) === TRUE) {
        // Pesan peringatan setelah data berhasil dimasukkan
        echo '<script>alert("Data berhasil ditambahkan");</script>';
        // Redirect ke halaman data_transaksi.php setelah data berhasil dimasukkan
        echo '<script>window.location.replace("data_kendaraan.php");</script>';
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Biaya Kendaraan</title>
    <style>
        /* CSS for container */
        .container {
            margin: 0 auto;
            padding: 20px;
            max-width: 175vh;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-left: 270px;
            margin-top: 50px;
            margin-bottom: 30px;
        }

        /* CSS for form */
        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        label {
            font-weight: bold;
        }

        /* CSS for buttons */
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
        }

        .btn-danger {
            background-color: #dc3545;
            color: #fff;
            margin-left: 10px;
        }

        .btn:hover {
            opacity: 0.8;
        }

        /* CSS for alerts */
        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Tambah Biaya Kendaraan</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="jenis_kendaraan">Jenis Kendaraan</label>
                <input type="text" class="form-control" id="jenis_kendaraan" name="jenis_kendaraan" required>
            </div>
            <div class="form-group">
                <label for="biaya">Biaya</label>
                <input type="number" class="form-control" id="biaya" name="biaya" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="javascript:history.go(-1)" class="btn btn-danger">Batal</a>
        </form>
    </div>
</body>
</html>
