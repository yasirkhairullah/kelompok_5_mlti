<?php
include 'koneksi.php';
include 'sidebar.php';

if (isset($_GET['nota_no'])) {
    $nota_no = $_GET['nota_no'];

    // Fetch the existing transaksi data
    $sql = "SELECT nota_no, nama_pelanggan, jenis_kendaraan, biaya, bayar, kembalian FROM transaksi WHERE nota_no = ?";
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nota_no = $_POST['nota_no'];
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $jenis_kendaraan = $_POST['jenis_kendaraan'];
    $biaya = $_POST['biaya'];
    $bayar = $_POST['bayar'];
    $kembalian = $_POST['kembalian'];

    // Update the transaksi data
    $sql = "UPDATE transaksi SET nama_pelanggan = ?, jenis_kendaraan = ?, biaya = ?, bayar = ?, kembalian = ? WHERE nota_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $nama_pelanggan, $jenis_kendaraan, $biaya, $bayar, $kembalian, $nota_no);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Transaksi berhasil diperbarui.</div>";
        echo "<script>alert('Transaksi berhasil diperbarui.'); window.location.href = 'transaksi.php';</script>";
    } else {
        echo "<div class='alert alert-danger'>Error updating record: " . $conn->error . "</div>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transaksi</title>
    <style>
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
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-success {
            background-color: #28a745;
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

</head>
<body>
    <div class="container">
        <h2 class="mt-4">Edit Transaksi</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?nota_no=" . $nota_no; ?>">
            <div class="form-group">
                <label for="nota_no">No. Nota</label>
                <input type="text" class="form-control" id="nota_no" name="nota_no" value="<?php echo $row['nota_no']; ?>" readonly required>
            </div>
            <div class="form-group">
                <label for="nama_pelanggan">Nama Pelanggan</label>
                <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" value="<?php echo $row['nama_pelanggan']; ?>" required>
            </div>
            <div class="form-group">
                <label for="jenis_kendaraan">Jenis Kendaraan</label>
                <select class="form-control" id="jenis_kendaraan" name="jenis_kendaraan" required style="width: 100%; height: 40px;">
                    <option value="">--- Pilih Jenis Kendaraan ---</option>
                    <?php
                    $sql_jenis = "SELECT jenis_kendaraan, biaya FROM biaya_kendaraan";
                    $result_jenis = $conn->query($sql_jenis);
                    if ($result_jenis->num_rows > 0) {
                        while($jenis = $result_jenis->fetch_assoc()) {
                            echo "<option value='" . $jenis["jenis_kendaraan"] . "' data-biaya='" . $jenis["biaya"] . "' " . ($jenis["jenis_kendaraan"] == $row["jenis_kendaraan"] ? "selected" : "") . ">" . $jenis["jenis_kendaraan"] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="biaya">Biaya</label>
                <input type="number" class="form-control" id="biaya" name="biaya" value="<?php echo $row['biaya']; ?>" readonly required>
            </div>
            <div class="form-group">
                <label for="bayar">Bayar</label>
                <input type="number" class="form-control" id="bayar" name="bayar" value="<?php echo $row['bayar']; ?>" oninput="calculateChange()" required>
            </div>
            <div class="form-group">
                <label for="kembalian">Kembalian</label>
                <input type="number" class="form-control" id="kembalian" name="kembalian" value="<?php echo $row['kembalian']; ?>" readonly required>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="javascript:history.go(-1)" class="btn btn-danger">Batal</a>
        </form>

        <script>
            document.getElementById('jenis_kendaraan').addEventListener('change', function() {
                var selectedOption = this.options[this.selectedIndex];
                document.getElementById('biaya').value = selectedOption.getAttribute('data-biaya');
            });

            function calculateChange() {
                var biaya = document.getElementById('biaya').value;
                var bayar = document.getElementById('bayar').value;
                var kembalian = parseFloat(bayar) - parseFloat(biaya);
                document.getElementById('kembalian').value = kembalian.toFixed(2);
            }
        </script>
    </div>
</body>
</html>
