<?php
// Koneksi ke database
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'test_kasir';

$conn = mysqli_connect($host, $user, $pass, $db);

// Query untuk mengambil data count(id_produk)
$query = "SELECT id_product, count(id_product) as jumlah FROM tbl_transaksi GROUP BY id_product";

// Eksekusi query
$result = mysqli_query($conn, $query);

// Tampung data ke dalam array
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Konversi data ke format JSON
$jsonData = json_encode($data);

// Cetak data
echo $jsonData;
?>