<?php 
if (@$_GET['edit']) {
	$update_id = $_GET['edit'];
	$sql = $mysqli->query("SELECT * FROM tbl_jenis_product WHERE id_jenis_product = '$update_id'");
	$data = mysqli_fetch_assoc($sql);

	$nama_jenis_product = ((isset($_POST['nama_jenis_product']))?sanitize($_POST['nama_jenis_product']):$data['nama_jenis_product']);
	$nama_jenis_product = trim($nama_jenis_product);

}else{
	$nama_jenis_product = ((isset($_POST['nama_jenis_product']))?sanitize($_POST['nama_jenis_product']):'');
	$nama_jenis_product = trim($nama_jenis_product);	
}

$errors = array();
?><div class="app-title">
	<div class="row">
		<a href="?page=product" class="btn btn-default"><i class="fa fa-chevron-left"></i></a><h1> Jenis</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
		<li class="breadcrumb-item"><a href="?page=product">Produk</a></li>
		<li class="breadcrumb-item"><a href="javascript:void(0)">jenis</a></li>
	</ul>
</div>
<div class="row">
	<div class="col-md-4">
		<div class="tile">
			<?php if(@$_GET['edit']): ?>
				<form method="POST" action="">
					<h3 class="tile-title">Edit Data</h3>
					<?php 
					if (isset($_POST['submit'])) {
						$update_id = sanitize($_GET['edit']);
						$nama_jenis_product = sanitize($_POST['nama_jenis_product']);

						if (empty($nama_jenis_product)) {
							$errors[] = "Nama jenis harus diisi.";
						}
						$sqlCek = $mysqli->query("SELECT * FROM tbl_jenis_product WHERE nama_jenis_product = '$nama_jenis_product' AND id_jenis_product != '$update_id'");
						if (mysqli_num_rows($sqlCek) > 0) {
							$errors[] = "$nama_jenis_product sudah ada.";
						}
						if (!empty($errors)) {
							echo display_errors($errors);
						}else{
							$insert = $mysqli->query("UPDATE tbl_jenis_product SET nama_jenis_product = '$nama_jenis_product' WHERE id_jenis_product = '$update_id'");
							if ($insert) {
								$text = "Berhasil menyimpan $nama_jenis_product.";
								echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '?page=jenis_product');
							}
						}
					}
					?>
					<div class="tile-body">
						<div class="form-group">
							<label class="control-label col-md-4" for="nama_jenis_product">Jenis</label>
							<div class="col-md-12">
								<input class="form-control" id="nama_jenis_product" type="text" placeholder="Nama Jenis Product" name="nama_jenis_product" autofocus value="<?= $nama_jenis_product; ?>">
							</div>
						</div>
					</div>
					<div class="tile-footer">
						<div class="row">
							<div class="col-md-8 col-md-offset-3">
								<button class="btn btn-primary" type="submit" name="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>

								<a href="?page=jenis_product" class="btn btn-default">Batal <i class="fa fa-fw fa-remove"></i></a>
							</div>
						</div>
					</div>
					</form><?php else: ?>
					<form method="POST" action="">
						<h3 class="tile-title">Tambah Jenis</h3>
						<?php 
						if (isset($_POST['submit'])) {
							$nama_jenis_product = sanitize($_POST['nama_jenis_product']);

							if (empty($nama_jenis_product)) {
								$errors[] = "Nama jenis harus diisi.";
							}
							$sqlCek = $mysqli->query("SELECT * FROM tbl_jenis_product WHERE nama_jenis_product = '$nama_jenis_product'");
							if (mysqli_num_rows($sqlCek) > 0) {
								$errors[] = "$nama_jenis_product sudah ada.";
							}
							if (!empty($errors)) {
								echo display_errors($errors);
							}else{
								$insert = $mysqli->query("INSERT INTO tbl_jenis_product SET nama_jenis_product = '$nama_jenis_product'");
								if ($insert) {
									$text = "Berhasil menambah $nama_jenis_product pada data jenis.";
									echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '?page=jenis_product');
								}
							}
						}
						?>
						<div class="tile-body">
							<div class="form-group">
								<p>Nama Jenis Produk </p>
								<div class="col-md-12">
									<input class="form-control" id="nama_jenis_product" type="text" placeholder="Nama Jenis Produk" name="nama_jenis_product" autofocus value="<?= $nama_jenis_product; ?>">
								</div>
							</div>
						</div>
						<div class="tile-footer">
							<div class="row">
								<div class="col-md-8 col-md-offset-3">
									<button class="btn btn-primary" type="submit" name="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
								</div>
							</div>
						</div>
					</form>
				<?php endif; ?>
			</div>
		</div>
		<div class="col-md-8">
			<div class="tile">
				<div class="tile-body">
					<div class="table-responsive">
						<table class="table table-hover" id="tabelKu">
							<thead>
								<tr>
									<th class="text-center">jenis</th>
									<th class="text-center">Opsi</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$sql = $mysqli->query("SELECT * FROM tbl_jenis_product ORDER BY nama_jenis_product ASC");
								while($data = mysqli_fetch_assoc($sql)):
									 $cekUp = $mysqli->query("select id_jenis_product from tbl_product where id_jenis_product = '$data[id_jenis_product]'");
									 $r =mysqli_num_rows($cekUp);
									?>
									<tr>
										<td class="text-center"><?= $data['nama_jenis_product']; ?> <span class="badge badge-warning">
										<?= $r?>
										</span></td>
										<td class="text-center">				
											<a href="?page=jenis_product&edit=<?= $data['id_jenis_product']; ?>" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></a>
									<?php
									if($r==0){?>
											<a href="?page=jenis_product&del=<?= $data['id_jenis_product']; ?>" class="btn btn-sm btn-danger tombol-hapus"><i class="fa fa-trash"></i></a>
										</td>
									</tr>
								<?php } endwhile; ?>
							</tbody>
						</table><br>
					</div><div class="alert alert-warning">
			<strong>*Notes :</strong><br>
			Hanya dapat menghapus jenis product yang kosong 
				</div>
			</div>
		</div>
		
		</div>
	</div>
	
	<?php 
	if (@$_GET['del']) {
		$del_id = $_GET['del'];
		$delete = $mysqli->query("DELETE FROM tbl_jenis_product WHERE id_jenis_product = '$del_id' ");
		if ($delete) {
			$text = "Data berhasil dihapus.";
			echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '?page=jenis_product');
		}
	}
	?>