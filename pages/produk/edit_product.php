<?php include '../../library/config.php';
if(isset($_POST["idnya"])){
     $idnya = $_POST["idnya"];
     $dataa = $mysqli->query("SELECT * FROM tbl_product WHERE id_product = '$idnya'");
     $data = mysqli_fetch_assoc($dataa);
}
?>
<div class="row">
    <div class="col-md-12 col-xs-8 col-sm-8">
        <form  action="?page=product"  method="POST" enctype="multipart/form-data">
				<h3 class="login-head text-center"><i class="fa fa-plus"></i> Edit Product</h3><br>
				<div class="form-group">
					<label class="control-label">Silahkan Isi data dibawah:</label>
					<input class="form-control" name="nama_product" value="<?=$data['nama_product']?>" type="text" maxlength="30" placeholder="Nama Produk" autofocus required>
                </div>
                <div class="form-group">
                <select name="id_jenis_product" class="form-control" required>
                    <option value="" hidden>Pilih</option>
                <?php 
                $list = $mysqli->query("SELECT * FROM tbl_jenis_product");
               if (!empty($data['id_jenis_product'])) {
                    $as = $mysqli->query("SELECT * FROM tbl_jenis_product WHERE id_jenis_product='$data[id_jenis_product]'");
                    $jenis_product = mysqli_fetch_array($as);
               ?>
                    <option hidden selected value="<?= $jenis_product['id_jenis_product'] ?>"><?= $jenis_product['nama_jenis_product'] ?></option>
<?php 
    }
                    if(mysqli_num_rows($list) > 0) {
                        while($i = mysqli_fetch_array($list)){?>
                        <option value="<?= $i['id_jenis_product']?>"><?= $i['nama_jenis_product']?></option>
                        <?php }
                    }?>
                </select>
                </div>
                <div class="form-group">
                    <input  type="text" hidden value="<?= $data['id_product']?>" name="id_product">
                    <input  type="text" hidden value="<?= $data['foto']?>" name="file_before">

                    <input class="form-control" name="stok" type="number" value="<?= $data['stok']?>" max="9999" placeholder="Stok" autofocus required>
                </div>
                <div class="form-group">
                     <input class="form-control" name="harga_beli" type="number"  value="<?= $data['harga_beli']?>"  max="99999999" placeholder="Harga Beli (satuan)" autofocus required>
                </div>
                <div class="form-group">
                    <input class="form-control" name="harga_jual" type="number"  value="<?= $data['harga_jual']?>"  max="99999999" placeholder="Harga Jual (satuan)" autofocus required>
				</div>
				<div class="form-group">
                    <input class="form-control" name="foto" type="file" accept="image/png, image/gif, image/jpeg" placeholder="Tipe JPG,PNG & GIF" autofocus>
				</div>
				
				<div class="form-group btn-container">
					<button class="btn btn-primary btn-block" type="submit" name="edit_product"><i class="fa fa-check fa-lg fa-fw"></i>Update</button>
				</div>
				
			</form>
    </div>
</div>