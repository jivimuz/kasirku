<?php 
$stmt = $mysqli->prepare("SELECT * FROM tbl_transaksi WHERE id_transaksi = ?");
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();
$result = $stmt->get_result();

    if($result->num_rows == 0 || empty($_GET['id'])){
        echo sweetalert('', '', 'success', '0', 'false', '?page=transaksi');
    }else{
    $data = $result->fetch_array(MYSQLI_ASSOC);
    ?>


<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="main.css">
	<title>Cetak Invoice</title>
</head>
<body onload="printIni()">
<div class="app-title">
	<div class="row">
		<a href="?page=transaksi" class="btn btn-default"><i class="fa fa-chevron-left"></i></a><h1><i class="fa fa-cart-plus"></i> Cetak Invoice</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
		<li class="breadcrumb-item"><a href="?page=product">Produk</a></li>
		<li class="breadcrumb-item"><a href="javascript:void(0)">Cetak Invoice</a></li>
	</ul>
</div>
<div class="tile">
    
    <div class="col-md-12">
        
    </div>
    <div class="col-md-12 ">
    <div class="table-responsive">
     <table class="table" width="100%"  border="1">
        <tr style="background-color: gold;">
            <th> Keranjang Pesanan
            </th>
        </tr>
        <tr>
            <td>
            <table class="table table-hover" width="100%"  id="">
                 <tr>
                    <th>Produk</td>
                    <th>Harga</td>
                    <th>Qty</td>
                    <th >Subtotal</td>
                 </tr>
                <?php 
                $d = $mysqli->query("SELECT tbl_cart.*, tbl_product.*
                FROM tbl_cart 
                JOIN tbl_product ON tbl_cart.id_product = tbl_product.id_product 
                WHERE tbl_cart.id_transaksi = '$data[id_transaksi]' AND tbl_product.stok > 0");
                            
                $total = 0;
                            
                if(mysqli_num_rows($d) > 0){
                    while($i = mysqli_fetch_array($d)){?>
                 <tr>
                    <td><?= $i['nama_product']?></td>
                    <td>Rp. <?= buatRupiah($i['harga_jual'])?></td>
                    <td><?=$i['qty']?></td>
                    <td><?php 
                        $sub = $i['harga_jual'] * $i['qty'];
                        $total += $sub;
                        echo 'Rp. '.buatRupiah($sub);
                    ?></td>
                    
                 </tr>
                 <?php }}?>

                 <tr>
                    <th colspan="3">Total pembelian :</td>
                    <th >Rp. <?= buatRupiah($total)?></td>
                    
                 </tr>
                 <tr>
                    <th colspan="3">Tunai :</td>
                    <th >Rp. <?= buatRupiah($data['total_tunai'])?></td>
                 </tr>
                 <tr>
                    <th colspan="3">Total Kembalian :</td>
                    <th >Rp. <?= buatRupiah($data['total_kembali'])?></td>
                 </tr>
             </table>
            </td>
        </tr>
    </table>
    
    </div>
    <div class="row">
           
          
            
        </div>
    </div>
</div>
<?php }
$stmt->close();?>