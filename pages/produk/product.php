

<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="main.css">
	<title>Produk</title>
</head>
<body>
<div class="app-title">
	<div>
		<h1><i class="fa fa-cube"></i> Produk</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
		<li class="breadcrumb-item"><a href="javascript:void(0)">Produk</a></li>
	</ul>
</div>

<?php

$errors = array();

if (isset($_POST['add_product'])) {
        $id_jenis_product = sanitize($_POST['id_jenis_product']);
        $nama_product = sanitize($_POST['nama_product']);
        $stok = sanitize($_POST['stok']);
        $harga_beli = sanitize($_POST['harga_beli']);
        $harga_jual = sanitize($_POST['harga_jual']);
        $gambar ="";
        if (!is_numeric($stok) || !is_numeric($harga_beli) || !is_numeric($harga_jual)) {
            $errors[] ="Stok, harga beli, dan harga jual harus berupa angka. Silakan coba lagi.";
        }

        $dir = "images/products/";

        if ($_FILES['foto']['name']) {
            $allowed_types = array('image/jpeg', 'image/png', 'image/gif');
            if (in_array($_FILES['foto']['type'], $allowed_types)) {
                if ($_FILES['foto']['size'] <= 1000000) {
                    $timestamp = time();
                    $gambar = $timestamp . '_' . $_FILES['foto']['name'];
                    move_uploaded_file($_FILES['foto']['tmp_name'], $dir . $gambar);
                } else {
                    $errors[] ="Gambar melebihi batas 1 MB.";
                }
            } else {
                $errors[] = "Tipe file gambar tidak sesuai (harus JPG, PNG, atau GIF)";
            }
        }

        if(!empty($errors)){
            if(file_exists($dir.$gambar)){
            unlink($dir.$gambar);}
            display_errors($errors);
        }else{
            $up = $mysqli->query("INSERT INTO tbl_product set id_jenis_product = '$id_jenis_product', nama_product = '$nama_product', stok='$stok', harga_beli='$harga_beli', harga_jual='$harga_jual', foto='$gambar'");
            if($up == true){
            echo sweetalert('Berhasil.!', 'data didaftarkan', 'success', '3000', 'false', '?page=product');
            }else{
            echo sweetalert('Gagal.!', 'Upload Error!', 'warning', '3000', 'false', '?page=product');
            if(file_exists($dir.$gambar)){
                unlink($dir.$gambar);}
            }
        }
       

    }


    if (isset($_POST['edit_product'])) {
        $id_product = sanitize($_POST['id_product']);
        $file_before = sanitize($_POST['file_before']);
        $id_jenis_product = sanitize($_POST['id_jenis_product']);
        $nama_product = sanitize($_POST['nama_product']);
        $stok = sanitize($_POST['stok']);
        $harga_beli = sanitize($_POST['harga_beli']);
        $harga_jual = sanitize($_POST['harga_jual']);
        $gambar ="";
        if (!is_numeric($stok) || !is_numeric($harga_beli) || !is_numeric($harga_jual)) {
            $errors[] ="Stok, harga beli, dan harga jual harus berupa angka. Silakan coba lagi.";
        }

        $dir = "images/products/";

        if ($_FILES['foto']['name']) {
            $allowed_types = array('image/jpeg', 'image/png', 'image/gif');
            if (in_array($_FILES['foto']['type'], $allowed_types)) {
                if ($_FILES['foto']['size'] <= 1000000) {
                    $timestamp = time();
                    $gambar = $timestamp . '_' . $_FILES['foto']['name'];
                    move_uploaded_file($_FILES['foto']['tmp_name'], $dir . $gambar);
                } else {
                    $errors[] ="Gambar melebihi batas 1 MB.";
                }
            } else {
                $errors[] = "Tipe file gambar tidak sesuai (harus JPG, PNG, atau GIF)";
            }
        }

        if(!empty($errors)){
            if(file_exists($dir.$gambar)){
            unlink($dir.$gambar);}
            display_errors($errors);
        }else{
            if(empty($gambar)){
                $gambar = $file_before;
            }
            $up = $mysqli->query("UPDATE tbl_product set id_jenis_product = '$id_jenis_product', nama_product = '$nama_product', stok='$stok', harga_beli='$harga_beli', harga_jual='$harga_jual', foto='$gambar' where id_product = '$id_product'");
            if($up == true){
            echo sweetalert('Berhasil.!', 'data berhasil di update', 'success', '3000', 'false', '?page=product');
            }else{
            echo sweetalert('Gagal.!', 'Upload Error!', 'warning', '3000', 'false', '?page=product');
            if(file_exists($dir.$gambar)){
                unlink($dir.$gambar);}
            }
        }
       

    }

if (@$_GET['del_id']) {
		$del_id = $_GET['del_id'];
        $img = $mysqli->query("SELECT foto FROM tbl_product WHERE id_product = '$del_id' ");
        $a= mysqli_fetch_array($img);
        if(mysqli_num_rows($img)>0 && file_exists("images/products/".$a['foto'])){
            unlink("images/products/".$a['foto']);
		    $delete = $mysqli->query("DELETE FROM tbl_product WHERE id_product = '$del_id' ");
            $text = "Data User berhasil dihapus.";
            echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '?page=product');
        }
	}
?>
<div class="row">
	<div class="col-md-12 col-xs-12 col-sm-12">
		<div class="tile">
			
					<div class="col-md-12 col-md-offset-3">
						<div class="pull-right">
						    <a href="?page=jenis_product"  class="btn btn-warning"><i class="fa fa-fw fa-lg fa-eye"></i> Jenis Produk</a>
						    <button class="btn btn-primary add_p"><i class="fa fa-fw fa-lg fa-plus"></i> Produk</button>
                        </div><br><br><br>
						
					</div>
<div class="col-md-13">
		<div class="tab-content">
			<div class="tab-pane active" id="user-info">
				<div class="user-info">

		<div class="table-responsive">
        <table class="table table-hover table-bordered" id="tabelKu" width="100%">
            <thead>
                <tr><th class="text-center">No.</th>
                    <th class="text-center">-</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Jenis</th>
                    <th class="text-center">Stock</th>
                    <th class="text-center">Harga Jual</th>
                    <th class="text-center">Opsi</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php 
                $noUrut = 0;
                $sql = $mysqli->query("SELECT tbl_product.*, tbl_jenis_product.* FROM tbl_product 
                        JOIN tbl_jenis_product ON tbl_product.id_jenis_product = tbl_jenis_product.id_jenis_product 
                        ORDER BY tbl_product.id_product DESC");

                while($data = mysqli_fetch_assoc($sql)):
                    $file = file_exists(('images/products/'.$data['foto']));

                        $noUrut++?>
                    <tr><td class="text-center"><?= $noUrut?>.</td>
                        <td class="text-center">
                        <?php if($file && !empty($data['foto'])): ?>
                            <a id="show_foto" data-toggle="modal" data-target="#img" href="javascript:void(0)" data-id="<?= $data['id_product']; ?>" data-foto="<?= $data['foto']; ?>">
                                <img class="img-responsive user-img-data img-thumbnail" alt="<?= $data['foto']; ?>" src="images/products/<?= $data['foto']; ?>" />
                            </a>
						<?php else: ?>
											<i class="fa fa-cube fa-fw"></i>
						<?php endif; ?></td>
                        <td><?= $data['nama_product'] ?></td>
                        <td class="text-center"><?= $data['nama_jenis_product'] ?></td>
                        <td class="text-center"><?= $data['stok'] ?></td>
                        <td class="text-center">Rp. <?= buatRupiah($data['harga_jual']) ?></td>
                        <td class="text-center">
                        <a href="?page=show_product&id=<?= $data['id_product'] ?>" class="btn btn-sm btn-info ">&nbsp;<i class="fa fa-eye"></i></a>

                        <a class="btn btn-warning btn-sm edit_p" id="<?=$data['id_product']?>">&nbsp;<i class="fa fa-pencil" ></i></a>
                        
                        <a href="?page=product&del_id=<?= $data['id_product'] ?>" onclick="return confirm('Yakin Hapus <?php echo $data['nama_product'] ?>')" class="btn btn-sm btn-danger tombol-hapus">&nbsp;<i class="fa fa-trash"></i></a>
                        </td>
                        
                    </tr>

                <?php endwhile; ?>
            </tbody>
        </table>
				</div>
			</div>
		</div>

	</div>
</div>



<!--              Modal Add                   -->


<div id="addModal" class="modal fade" style="font-size: 12px;">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
   </div>
   <div class="modal-body" id="form_add">
     
   </div>                      
<div class="row text-right">
                        <div class="col-md-12">
<span>
    <button style="font-size:12px;" type="button" class="btn btn-dark" id="tutop" data-dismiss="modal">Cancel</button>&nbsp;&nbsp;&nbsp;<br>&nbsp;&nbsp;</span>
</div>
   </div>
  </div>
 </div>
</div>

<!--                 Modal Edit_Pegawai                   -->


<div id="editModal" class="modal fade" style="font-size: 12px;">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
   </div>
   <br>
   <div class="modal-body" id="form_edit">  
   </div>
                      
<div class=" row text-right">

                        <div class="col-md-12">
<span>
    <button style="font-size:12px;" type="button" class="btn btn-dark" id="tutop" data-dismiss="modal">Close</button>&nbsp;&nbsp;&nbsp;<br>&nbsp;&nbsp;</span>
</div>
   </div>
  </div>
 </div>
</div>



<div id="img" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body" id="modal-gambar">
				<div style="padding-bottom: 5px;">
					<center>
						<img src="" id="pict" alt="" class="img-responsive img-thumbnail">
					</center>
				</div>
			</div>
		</div>
	</div>
</div>
<!--                                                     end Modal                                                          -->

<script>
//form input
$(document).on('click', '.add_p', function(){
  $.ajax({
   url:"pages/produk/add_product.php",
   success:function(data){
    $('#form_add').html(data);
    $('#addModal').modal('show');
   }
  });
 });

 $(document).on('click', '.edit_p', function(){
  var idnya = $(this).attr("id");
  $.ajax({
   url:"pages/produk/edit_product.php",
   method:"POST",
   data:{idnya:idnya},
   success:function(data){
    $('#form_edit').html(data);
    $('#editModal').modal('show');
   }
  });
 });

 $(document).on("click", "#show_foto", function() {
		var id = $(this).data('id');
		var ft = $(this).data('foto');
		$("#modal-gambar #id").val(id);
		$("#modal-gambar #pict").attr("src", "images/products/"+ft);
	});
</script>