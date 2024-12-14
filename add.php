<?php
include 'koneksi.php';
include 'sidebar.php';

        // Fungsi untuk menghasilkan nomor nota otomatis
        function generateNotaNumber() {
            $timestamp = time();
            $randomNum = mt_rand(100000, 999999);
            return "INV-" . $timestamp . "-" . $randomNum;
        }

        // Fetch jenis kendaraan and biaya from database
        $sql = "SELECT jenis_kendaraan, biaya FROM biaya_kendaraan";
        $result = $conn->query($sql);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve data from form
            $nota_no = $_POST['nota_no'];
            $nama_pelanggan = $_POST['nama_pelanggan'];
            $jenis_kendaraan = $_POST['jenis_kendaraan'];
            $biaya = $_POST['biaya'];
            $bayar = $_POST['bayar'];
            $kembalian = $_POST['kembalian'];

            
            // SQL INSERT statement
            $sql_insert = "INSERT INTO transaksi (nota_no, nama_pelanggan, jenis_kendaraan, biaya, bayar, kembalian) 
                           VALUES ('$nota_no', '$nama_pelanggan', '$jenis_kendaraan', '$biaya', '$bayar', '$kembalian')";

            if ($conn->query($sql_insert) === TRUE) {
                // Jika data berhasil dimasukkan, tampilkan alert sukses
                echo "<script>alert('Transaksi berhasil ditambahkan.'); window.location.href = 'transaksi.php';</script>";
            } else {
                // Jika terjadi kesalahan, tampilkan pesan error
                echo "<script>alert('Terjadi kesalahan saat menambahkan transaksi.');</script>";
            }
        }
        ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Jasa Cuci</title>
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Tambah Transaksi Baru</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="nota_no">No. Nota</label>
                <input type="text" class="form-control" id="nota_no" name="nota_no" value="<?php echo generateNotaNumber(); ?>" readonly required>
            </div>   
            <div class="form-group">
                <label for="nama_pelanggan">Nama Pelanggan</label>
                <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" required>
            </div>
            <div class="form-group">
                <label for="jenis_kendaraan">Jenis Kendaraan</label>
                <select class="form-control" id="jenis_kendaraan" name="jenis_kendaraan" required style="width: 100%; height: 40px;">
                    <option value="">--- Pilih Jenis Kendaraan ---</option>
                    <?php
                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["jenis_kendaraan"] . "' data-biaya='" . $row["biaya"] . "'>" . $row["jenis_kendaraan"] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="biaya">Biaya</label>
                <input type="number" class="form-control" id="biaya" name="biaya" readonly required>
            </div>
            <div class="form-group">
                <label for="bayar">Bayar</label>
                <input type="number" class="form-control" id="bayar" name="bayar" oninput="calculateChange()" required>
            </div>
            <div class="form-group">
                <label for="kembalian">Kembalian</label>
                <input type="number" class="form-control" id="kembalian" name="kembalian" readonly required>
            </div>
         
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="javascript:history.go(-1)" class="btn btn-danger">Batal</a>
        </form>
    </div>

    <script>
        // Script to update the biaya field based on the selected jenis_kendaraan
        document.getElementById('jenis_kendaraan').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            document.getElementById('biaya').value = selectedOption.getAttribute('data-biaya');
        });

        // Function to calculate change (kembalian)
        function calculateChange() {
            var biaya = document.getElementById('biaya').value;
            var bayar = document.getElementById('bayar').value;
            var kembalian = parseFloat(bayar) - parseFloat(biaya);
            document.getElementById('kembalian').value = kembalian.toFixed(2);
        }
    </script>
</body>
</html>
