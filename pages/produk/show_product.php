<?php 
if(!isset($_GET["id"])){
    echo sweetalert('', '', 'success', '0', 'false', '?page=product');
     
}else{
    $id = $_GET["id"];
     $dataa = $mysqli->query("SELECT * FROM tbl_product WHERE id_product = '$id'");
     $data = mysqli_fetch_assoc($dataa);

?>


<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="main.css">
	<title>Detail Produk</title>
</head>
<body>
<div class="app-title">
    <div class="row">
		<a href="?page=product" class="btn btn-default"><i class="fa fa-chevron-left"></i></a><h1><i class="fa fa-cube"></i> Detail Produk</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
		<li class="breadcrumb-item"><a href="?page=product">Produk</a></li>
		<li class="breadcrumb-item"><a href="javascript:void(0)">detail</a></li>
	</ul>
</div>
<div class="tile row">
    
    <div class="col-md-12 col-xs-8 col-sm-8">
            <h3 class="login-head text-center"> Data Product : <?=$data['nama_product']?> </h3><br>
            <hr>
    </div>
    <div class="col-md-7 col-xs-8 col-sm-8">
				<div class="form-group">
					<label class="control-label col-md-3">Nama Produk</label>
					<span class="col-md-9">: <?=$data['nama_product']?></span>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Jenis Produk</label>
                    <span class="col-md-9">: 
                    <?php
                    if (!empty($data['id_jenis_product'])) {
                        $as = $mysqli->query("SELECT * FROM tbl_jenis_product WHERE id_jenis_product='$data[id_jenis_product]'");
                        $jenis_product = mysqli_fetch_array($as);
                        echo $jenis_product['nama_jenis_product'];
                        }
                    ?>
                    </span>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Stok</label>
                    <span class="col-md-9">: <?= $data['stok']?></span>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Harga Beli</label>
                    <span class="col-md-9">: Rp. <?= buatRupiah($data['harga_beli'])?></span>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Harga Jual</label>
                    <span class="col-md-9">: Rp. <?= buatRupiah($data['harga_jual'])?></span>
				</div>
    </div>
    <div class="col-md-5 col-xs-8 col-sm-8">
				<div class="form-group">
                    <?php if($data['foto']) { ?>
                        <img src="images/products/<?= $data['foto']?>" class="img-line" alt="foto produk" width="170px">
                    <?php } else { ?>
                        <span class="col-md-9">Tidak Ada Foto</span>
                    <?php } ?>
				</div>
				
				
				
    </div>
</div>
<?php }?>