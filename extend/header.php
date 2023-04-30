<?php 
     $idgue = $_SESSION['id_pegawai'];

    $sql1 = $mysqli->query("SELECT * FROM tbl_pegawai WHERE id_pegawai = '$idgue'");
    $dataku = mysqli_fetch_array($sql1);
    @$page = $_GET['page'];

	function buatRupiah($angka){
		$hasil =  number_format($angka,0,',','.');
		$hasil = $hasil.",-";
		return $hasil;
	}

	// akses tombol print
	if($page == 'show_transaksi' || $page == 'show_product'){
        $printini = '';
    }else{
        $printini = 'hidden';
    }

?>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" href="#">

	<!-- og:property -->
	
<meta name="mobile-web-app-capable" content="yes">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href=".css/dropify.min.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/sweetalert2.css">

	<script src="js/jquery-3.3.1.min.js"></script>
	
	<script src="js/dropify.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/sweetalert.min.js"></script>


</head>
<body class="app sidebar-mini">
<header class="app-header">
	<a class="app-header__logo text-left" href="?page=dashboard">KASIRKU</a>
	<a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
			<a class="app-nav__item btn btn-default" <?= $printini ?> onclick="printIni()" style="text-decoration: none;"><i class="fa fa-print"></i>Print Page</a>
		<ul class="app-nav ">

			<li class="dropdown"><a class="app-nav__item" href="javascript:void(0)" style="text-decoration: none;" data-toggle="dropdown" aria-label="Open Profile Menu">
				<i class="fa fa-user fa-lg"></i>&nbsp; <?= $dataku['nama_pegawai']; ?></a>
				<ul class="dropdown-menu settings-menu dropdown-menu-right">
				    <li><a class="dropdown-item" style="font-size:14px;" href="logout.php" onclick="return confirm('anda yakin untuk logout?')"  id="logout" >&nbsp;&nbsp;<i class="fa fa-sign-out fa-lg"></i> &nbsp;Logout</a></li>
				</ul>
			</li>
		</ul>
</header>
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
	<aside class="app-sidebar">
		<ul class="app-menu">
			<h6 class="title-menu">Dashboard</h6>
			<li><a class="app-menu__item <?php if($page=='' || $page=='dashboard'){echo "active";} ?>" href="?page=dashboard"><i class="app-menu__icon fa fa-dashboard"></i>
			<span class="app-menu__label">Dashboard</span></a></li>
			
			<?php if($dataku['is_admin'] == 1):?>
			<h6 class="title-menu">Menu Admin</h6>
			<li><a class="app-menu__item <?php if($page=='pegawai'){echo "active";} ?>" href="?page=pegawai"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Pegawai</span></a></li>
			<?php endif;?>

			<h6 class="title-menu">Menu Kasir</h6>
			<li><a class="app-menu__item <?php if($page=='product'){echo "active";} ?>" href="?page=product"><i class="app-menu__icon fa fa-cube"></i><span class="app-menu__label">Produk</span></a></li>
			<li><a class="app-menu__item <?php if($page=='transaksi'){echo "active";} ?>" href="?page=transaksi"><i class="app-menu__icon fa fa-cart-arrow-down"></i><span class="app-menu__label">Transaksi</span></a></li>
			<li><a class="app-menu__item"  href="logout.php"><i class="app-menu__icon fa fa-sign-out"></i><span class="app-menu__label">Logout</span></a></li>
		</ul>
	</aside>
<div>
<main class="app-content">