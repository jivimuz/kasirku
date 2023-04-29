    <!-- Template Umum Jivi-->
<?php 


/* Variabel nya sesuai database user */
$host	= "127.0.0.1:3307";
$user	= "root";
$pass	= "";
$db		= "test_kasir";

//buat koneksi dengan mysqli//
$mysqli = new mysqli($host, $user, $pass, $db);
$config = mysqli_connect($host,$user,$pass,$db) or die(mysqli_error($config));
date_default_timezone_set('Asia/Jakarta');

//Menentukan zona waktu //
 ?>

