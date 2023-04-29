<!-- Template Umum Jivi-->
<?php 
session_start();
if (!isset($_SESSION['logedin'])) {
    header('location: login.php');

}

require_once 'library/config.php';
require_once 'library/f_library.php';
require_once 'library/f_notification.php';

include 'extend/header.php';

@$page = $_GET['page'];

if ($page=="" || $page=="dashboard") {
    include 'pages/dashboard.php';}

elseif ($page=="pegawai") {
     include 'pages/pegawai/pegawai.php';}

elseif ($page=="product") {
        include 'pages/produk/product.php';}

elseif ($page=="jenis_product") {
            include 'pages/produk/jenis_product.php';}

elseif ($page=="show_product") {
                include 'pages/produk/show_product.php';}

else{
    include 'pages/dashboard.php';}

    
    include 'extend/footer.php';

 ?>