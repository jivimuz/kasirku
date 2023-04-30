<?php 
$stmt = $mysqli->prepare("SELECT * FROM tbl_transaksi WHERE id_pegawai = ? and is_paid=0 ORDER BY id_transaksi DESC LIMIT 1");
$stmt->bind_param("i", $dataku['id_pegawai']);
$stmt->execute();
$result = $stmt->get_result();

    if($result->num_rows == 0){
        $now = date("Y-m-d H:i:s");
        $mysqli->query("INSERT INTO tbl_transaksi set id_pegawai='$dataku[id_pegawai]', created_at='$now' ");
        echo sweetalert('', '', 'success', '0', 'false', '');
    }else{
    $data = $result->fetch_array(MYSQLI_ASSOC);
    ?>


<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="main.css">
	<title>Keranjang</title>
</head>
<body>
<div class="app-title">
	<div class="row">
		<a href="?page=transaksi" class="btn btn-default"><i class="fa fa-chevron-left"></i></a><h1><i class="fa fa-cart-plus"></i> Keranjang</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
		<li class="breadcrumb-item"><a href="?page=product">Produk</a></li>
		<li class="breadcrumb-item"><a href="javascript:void(0)">Keranjang</a></li>
	</ul>
</div>
<div class="tile">
    <?php
    $errors = array();
        if (isset($_POST['add-product'])) {
            $id_transaksi = sanitize($_POST['id_transaksi']);
            $product = sanitize($_POST['product']);
            $cekProduk = $mysqli->query("SELECT id_product FROM tbl_product where nama_product = '$product'");
            if(mysqli_num_rows($cekProduk) == 0){
                $errors[] = "masukan nama produk yang sesuai";
            }
            if(!empty($errors)){
                display_errors($errors);
            }else{
            $g = mysqli_fetch_array($cekProduk);
            $send = $mysqli->query("INSERT INTO tbl_cart set id_product='$g[id_product]', id_transaksi='$id_transaksi'");
            $down = $mysqli->query("UPDATE tbl_product SET stok = stok - 1 WHERE id_product = '$g[id_product]'");
            echo sweetalert('', '', 'success', '0', 'false', '');
        }
        }
        if (isset($_POST['upCart'])) {
            $id_product =sanitize($_POST['id_product']);
            $id_cart =sanitize($_POST['id_cart']);
            $qty_before =sanitize($_POST['qty_before']);
            $qty =sanitize($_POST['qty']);

            if(empty($qty)){
                $errors[] = "QTY tidak boleh Kosong";
            }
             
            if(!empty($errors)){
                display_errors($errors);
            }else{
                if($qty > $qty_before){
                   $jumlah = $qty - $qty_before; 
                    $down = $mysqli->query("UPDATE tbl_product set stok = stok - '$jumlah' where id_product='$id_product'");
                }else{
                    $jumlah = $qty_before - $qty; 
                    $down = $mysqli->query("UPDATE tbl_product set stok = stok + '$jumlah' where id_product='$id_product'");
                }
            $send = $mysqli->query("UPDATE tbl_cart set qty='$qty' where id_cart='$id_cart'");
            echo sweetalert('', '', 'success', '0', 'false', '');
            }

        }
        if (isset($_POST['delCart'])) {
            $id_product =sanitize($_POST['id_product']);
            $id_cart =sanitize($_POST['id_cart']);
            $qty =sanitize($_POST['qty_before']);
            
            $down = $mysqli->query("UPDATE tbl_product set stok = stok + '$qty' where id_product='$id_product'");
            if($down == true){
                $send = $mysqli->query("DELETE from tbl_cart where id_cart='$id_cart'");
                echo sweetalert('', '', 'success', '0', 'false', '');
            }
        }
        if (isset($_POST['resetCart'])) {
            $cekProduk = $mysqli->query("SELECT id_product, qty FROM tbl_cart where id_transaksi = '$data[id_transaksi]'");
            if(mysqli_num_rows($cekProduk) > 0){
                while($r = mysqli_fetch_array($cekProduk)){
                    $down = $mysqli->query("UPDATE tbl_product set stok = stok + '$r[qty]' where id_product='$r[id_product]'");
                }
            }
            $send = $mysqli->query("DELETE from tbl_cart where id_transaksi='$data[id_transaksi]'");
            echo sweetalert('', '', 'success', '0', 'false', '');
        }

        if (isset($_POST['data-post'])) {
            $data1 =sanitize($_POST['data-1']);
            $data2 =sanitize($_POST['data-2']);
            $data3 =sanitize($_POST['data-3']);

            $send = $mysqli->query("UPDATE tbl_transaksi set total_tunai='$data2', total_harga='$data1', total_kembali='$data3', is_paid='1' , paid_at ='$now'  where id_transaksi='$data[id_transaksi]'");

            echo sweetalert('Sukses', 'Data Berhasil ditambahkan', 'success', '1000', 'false', '?page=transaksi');
        }


    ?>
    <div class="col-md-12">
        <form  action="?page=cart"  method="POST">
        <datalist id="auto-product">
            <?php $list = $mysqli->query("SELECT nama_product FROM tbl_product where stok > 0 order by nama_product asc");
            while($li = mysqli_fetch_array($list)){
                echo "<option value='".$li['nama_product']."'>";
            }
            ?>    
        </datalist>
        <div class="row">
            <div class="col-md-10">
                <input type="text" name="id_transaksi" value="<?=$data['id_transaksi']?>" hidden>
                <input type="text" name="product" list="auto-product" placeholder="Masukan nama barang untuk menambah barang" class="form-control">
            </div>
                <button type="submit" class="btn btn-lg btn-primary col-md-2" name="add-product"><i class="fa fa-cart-plus"></i></button>
        </div>
		</form>
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
                    <th colspan="2">Subtotal</td>
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
                    <td>
                        <form action='' method='post'>
                            <input type="text" name="id_product" value="<?=$i['id_product']?>" hidden>
                            <input type="text" name="id_cart" value="<?=$i['id_cart']?>" hidden>
                            <input type="text" name="qty_before" value="<?=$i['qty']?>" hidden>
                            <input type="number" max="999" style="width:70px" required name="qty" class="" value="<?=$i['qty']?>">
                            <button type="submit" name="upCart" ><i class="fa fa-save"></i></button>
                        </form>
                    </td>
                    <td><?php 
                        $sub = $i['harga_jual'] * $i['qty'];
                        $total += $sub;
                        echo 'Rp. '.buatRupiah($sub);
                    ?></td>
                    <td>
                        <form method="post" action="">
                            <input type="text" name="id_product" value="<?=$i['id_product']?>" hidden>
                            <input type="text" name="id_cart" value="<?=$i['id_cart']?>" hidden>
                            <input type="text" name="qty_before" value="<?=$i['qty']?>" hidden>
                            <button type="submit" name="delCart" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                 </tr>
                 <?php }}?>

                 <tr>
                    <th colspan="3">Total pembelian :</td>
                    <th colspan="2">Rp. <?= buatRupiah($total)?></td>
                    
                 </tr>
                 <tr>
                    <th colspan="3">Tunai :</td>
                    <th colspan="2">Rp. <input type="text" id="uang" onkeyup="kembalian();" style="width:130px;" maxlength="99999999999" value="0"?></td>
                 </tr>
                 <tr>
                    <th colspan="3">Total Kembalian :</td>
                    <th colspan="2"><span id="kembalian">Rp. <?= buatRupiah(0)?></span></td>
                 </tr>
             </table>
            </td>
        </tr>
    </table>
    
    </div>
    <div class="row">
            <div class="col-md-4 text-left">
                <a href="?page=transaksi" class="btn btn-lg btn-warning"><i class="fa fa-chevron-left"></i> Kembali</a></div>
            <div class="col-md-4 text-center">
                <form action="" method="post">
                <button class="btn btn-sm btn-danger" name="resetCart" type="submit"><i class="fa fa-trash"></i> Reset Pesanan</button>
            </form>
            </div>
            <div class="col-md-4 text-right">
            <form action="" method="post">
                <input type="text" hidden name="data-1" id="data-1" value="<?=$total?>">
                <input type="text" hidden name="data-2" id="data-2" value="<?=$total?>">
                <input type="text" hidden name="data-3" id="data-3" value="<?=$total?>">
                <button type="submit" disabled name="data-post" id="data-post" class="btn btn-lg btn-info"><i class="fa fa-save" onclick="return confirm('apakah yakin untuk submit')"></i> Submit</button>
            </form>
            </div>
        </div>
    </div>
</div>
<script>
  function kembalian() {
  var uang = parseFloat(document.getElementById('uang').value);
  var total = parseFloat(document.getElementById('data-1').value);
  var kembalian = uang - total;
  if(uang >= total && total > 0){
    document.getElementById('data-post').disabled = false;
  }else{
    document.getElementById('data-post').disabled = true;
  }

  if (!isNaN(kembalian)) {
    document.getElementById('data-2').value = uang;
    document.getElementById('data-3').value = kembalian;
    document.getElementById('kembalian').innerHTML = buatRupiah(kembalian);
  } 
  
}

function buatRupiah(angka) {
  var hasil = angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  hasil = "Rp. " + hasil + ",-";
  return hasil;
}
</script>

<?php }
$stmt->close();?>