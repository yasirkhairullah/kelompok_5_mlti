<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Jasa Cuci</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* CSS for Sidebar */
        * {
            text-decoration: none;
            font-family: Arial, Helvetica, sans-serif;
        }

        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100; 
            padding: 56px 0 0; /* Lebih besar padding untuk menyisipkan navbar */
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1); 
            background-color: #343a40; /* Warna sidebar */
            width: 250px; 
        }

        /* Style for Sidebar Header */
        .sidebar .sidebar-heading {
            font-size: 1.2rem; /* Lebih besar ukuran font */
            font-weight: 600;
            padding: 1rem;
            text-align: center;
            color: #ffffff; /* Warna teks putih */
        }

        /* Style for Sidebar Menu */
        .sidebar-sticky {
            position: relative;
            height: calc(100vh - 56px); /* Sesuaikan dengan padding navbar */
            overflow-x: hidden;
            overflow-y: auto; 
            margin-top: -50px;
        }

        /* Style for Sidebar Menu Items */
        .sidebar .nav-link {
            font-weight: 500;
            color: #ffffff; /* Warna teks putih */
            padding: 1rem 1.1rem;
            font-size: 1.2rem;
        }

        .sidebar .nav-link.active {
            background-color: #4e5d6c; /* Warna latar belakang untuk link aktif */
            color: #ffffff; /* Warna teks putih untuk link aktif */
            font-weight: bold; /* Teks tebal untuk link aktif */
        }
        /* Navbar */
        .navbar {
            padding: 15px 20px; /* Padding navbar */
            height: 70px;
            background-color:#4e5d6c; /* Warna navbar baru */
            border-bottom: 1px solid #dee2e6; /* Tambahkan garis bawah */
        }
        .logout {
            color: #ffffff; /* Warna teks putih */
            padding: 0.5rem 1rem; /* Atur padding */
            margin-right: 20px; /* Jarak dari tepi kanan */
            border: 1px solid transparent; /* Atur border */
            border-radius: 0.25rem; /* Atur sudut border */
            background-color: #dc3545; /* Warna background */
            text-decoration: none;
        }

        .logout:hover {
            color: #ffffff; /* Warna teks putih saat hover */
            background-color: #c82333; /* Warna background saat hover */
            border-color: #bd2130; /* Warna border saat hover */
        }

    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid"> <!-- Tambahkan class container-fluid -->
            <a class="navbar-brand" href="#">Aplikasi Jasa Cuci</a> <!-- Ganti # dengan link yang sesuai -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto"> <!-- Tambahkan class ml-auto untuk menu sebelah kanan -->
                    <li class="nav-item">
                        <a class="logout" href="login.php">Logout</a> <!-- Ganti # dengan link yang sesuai -->
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-sticky">
            <div class="logo" style="margin-left:20px;">
                <img src="IMG/logo.png" alt="logo" style="width: 200px; height: auto;">
            </div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) === 'Beranda.php') echo 'active'; ?>" href="Beranda.php">
                        <i class="fas fa-home"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) === 'transaksi.php') echo 'active'; ?>" href="transaksi.php">
                        <i class="fas fa-exchange-alt"></i>
                        Transaksi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) === 'data_kendaraan.php') echo 'active'; ?>" href="data_kendaraan.php">
                        <i class="fas fa-car"></i>
                        Data Kendaraan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) === 'laporan.php') echo 'active'; ?>" href="laporan.php">
                        <i class="fas fa-file-alt"></i>
                        Laporan
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</body>
</html>
