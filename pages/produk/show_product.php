<?php 
if(!isset($_GET["id"])){
    echo sweetalert('', '', 'success', '0', 'false', '?page=product');
     
}else{
    $id = $_GET["id"];
     $dataa = $mysqli->query("SELECT * FROM tbl_product WHERE id_product = '$id'");
     $data = mysqli_fetch_assoc($dataa);

?>
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