<?php
include 'koneksi.php';
include 'sidebar.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $jenis_kendaraan = $_POST['jenis_kendaraan'];
    $biaya = $_POST['biaya'];

    $sql = "UPDATE biaya_kendaraan SET jenis_kendaraan='$jenis_kendaraan', biaya='$biaya' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        $message = "Data berhasil diubah";
        // Menampilkan pesan alert setelah berhasil disimpan
        echo "<script>alert('Data berhasil diubah'); window.location.href = 'data_kendaraan.php';</script>";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
        // Menampilkan pesan alert jika terjadi kesalahan
        echo "<script>alert('Terjadi kesalahan. Silakan coba lagi.');</script>";
    }
}

// Ambil ID data yang akan diedit dari parameter URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mengambil data dari database
    $sql = "SELECT * FROM biaya_kendaraan WHERE id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        $message = "Data tidak ditemukan";
    }
}
?>

<?php
include 'koneksi.php';
include 'sidebar.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $jenis_kendaraan = $_POST['jenis_kendaraan'];
    $biaya = $_POST['biaya'];

    $sql = "UPDATE biaya_kendaraan SET jenis_kendaraan='$jenis_kendaraan', biaya='$biaya' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        $message = "Data berhasil diubah";
        // Menampilkan pesan alert setelah berhasil disimpan
        echo "<script>alert('Data berhasil diubah'); window.location.href = 'data_kendaraan.php';</script>";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
        // Menampilkan pesan alert jika terjadi kesalahan
        echo "<script>alert('Terjadi kesalahan. Silakan coba lagi.');</script>";
    }
}

// Ambil ID data yang akan diedit dari parameter URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mengambil data dari database
    $sql = "SELECT * FROM biaya_kendaraan WHERE id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        $message = "Data tidak ditemukan";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Biaya Kendaraan</title>
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
        <h2>Edit Biaya Kendaraan</h2>
        <?php if (!empty($message)): ?>
            <div class="alert <?php echo strpos($message, 'berhasil') !== false ? 'alert-success' : 'alert-danger'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="form-group">
                <label for="jenis_kendaraan">Jenis Kendaraan</label>
                <input type="text" class="form-control" id="jenis_kendaraan" name="jenis_kendaraan" value="<?php echo $row['jenis_kendaraan']; ?>" required>
            </div>
            <div class="form-group">
                <label for="biaya">Biaya</label>
                <input type="number" class="form-control" id="biaya" name="biaya" value="<?php echo $row['biaya']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="javascript:history.go(-1)" class="btn btn-danger">Batal</a>
        </form>
    </div>
</body>
</html>
