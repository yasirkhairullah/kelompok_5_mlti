<?php
// Sertakan file koneksi.php
include 'koneksi.php';

// Mulai session
session_start();

// Memeriksa apakah form login telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Melakukan query ke database untuk mendapatkan data user
    $query = "SELECT id, username FROM admin WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Jika data ditemukan, simpan ID pengguna dan nama pengguna ke dalam sesi
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];

        // Redirect ke halaman selanjutnya
        header("Location: Beranda.php");
        exit();
    } else {
        // Jika data tidak ditemukan, tampilkan pesan error
        $error_message = "Email atau password salah";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN PAGE</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        .container {
            position: relative;
            width: 100%;
            max-width: 400px;
        }

        .form-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        .input-field {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #555;
        }

        .social-icons {
            margin-bottom: 20px;
            text-align: center;
        }

        .social-icons .icon {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            margin: 0 5px;
            color: #fff;
            background-color: #333;
            border-radius: 50%;
            font-size: 18px;
        }

        .link-text {
            text-align: center;
            margin-top: 20px;
        }

        .link-text a {
            text-decoration: none;
            color: #333;
        }

        .link-text a:hover {
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <h1>MASUK</h1>
                <?php if(isset($error_message)) { ?>
                    <p><?php echo $error_message; ?></p>
                <?php } ?>
                <div class="social-icons">
                <img src="IMG/logo1.png" alt="logo" style="width: 200px; height: auto;">
                </div>
                <input type="email" name="email" id="email" class="input-field" placeholder="Email">
                <input type="password" name="password" id="password" class="input-field" placeholder="Password">
                <button type="submit">Masuk</button>
            </form>
        </div>
    </div>
</body>
</html>
