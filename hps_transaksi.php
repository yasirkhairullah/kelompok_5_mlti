<?php
include 'koneksi.php';

if (isset($_GET['nota_no'])) {
    $nota_no = $_GET['nota_no'];

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("<script>alert('Connection failed: " . $conn->connect_error . "');window.location.href='transaksi.php';</script>");
    }

    // Prepare and bind
    $stmt = $conn->prepare("DELETE FROM transaksi WHERE nota_no = ?");
    
    if ($stmt === false) {
        die("<script>alert('Prepare failed: " . $conn->error . "');window.location.href='transaksi.php';</script>");
    }
    
    $stmt->bind_param("s", $nota_no);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>alert('Record deleted successfully');window.location.href='transaksi.php';</script>";
    } else {
        echo "<script>alert('Error deleting record: " . $stmt->error . "');window.location.href='transaksi.php';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('No Nota No specified');window.location.href='index.php';</script>";
}
?>