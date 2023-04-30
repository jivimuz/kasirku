

<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="main.css">
	<title>Pegawai</title>
</head>
<body>
<div class="app-title">
	<div>
		<h1><i class="fa fa-users"></i> Pegawai</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
		<li class="breadcrumb-item"><a href="javascript:void(0)">Pegawai</a></li>
	</ul>
</div>

<?php

$errors = array();

if (isset($_POST['do_register'])) {
    $nama_pegawai = sanitize($_POST['nama_pegawai']);	
    $username = sanitize($_POST['username']);	
    $password = sanitize($_POST['password']);	
	$email = sanitize($_POST['email']);	
    $no_hp = sanitize($_POST['no_hp']);	
    if(empty($_POST['is_admin'])){
        $is_admin = 0;
    }else{
        $is_admin = sanitize($_POST['is_admin']);	
    }
    $sel = $mysqli->query("select id_pegawai from tbl_pegawai where username = '$username'");

    if(mysqli_num_rows($sel) > 0){
        $errors[] = "Username Sudah Terdaftar.";
    }

    if (strlen($password) < 6) {
        $errors[] = "Gunakan mininal 6 karakter untuk password.";
    }
    
    if (!empty($errors)) {
        echo display_errors($errors);
    }else{
        $options = ['cost' => 10];					
        $password_hash = password_hash($password, PASSWORD_DEFAULT, $options);
        $update = $mysqli->query("INSERT INTO tbl_pegawai SET username='$username',  password = '$password_hash', nama_pegawai = '$nama_pegawai', email='$email', no_hp='$no_hp', is_admin = '$is_admin'");

        if ($update == true) {
            
            echo sweetalert('Berhasil.!', 'data didaftarkan', 'success', '3000', 'false', '?page=pegawai');

        }
    }
    echo "<hr>";
}


if (isset($_POST['do_edit'])) {
    $id_pegawai = sanitize($_POST['id_pegawai']);	
    $nama_pegawai = sanitize($_POST['nama_pegawai']);	
    $username = sanitize($_POST['username']);	
    $password = sanitize($_POST['password']);	
    $pass_before = sanitize($_POST['pass_before']);	
	$email = sanitize($_POST['email']);	
    $no_hp = sanitize($_POST['no_hp']);	
    if(empty($_POST['is_admin'])){
        $is_admin = 0;
    }else{
        $is_admin = sanitize($_POST['is_admin']);	
    }
    $sel = $mysqli->query("select id_pegawai from tbl_pegawai where username = '$username' and id_pegawai != '$id_pegawai'");

    if(mysqli_num_rows($sel) > 0){
        $errors[] = "Username Sudah Terdaftar.";
    }

    if (!empty($password) && strlen($password) < 6) {
        $errors[] = "Gunakan mininal 6 karakter untuk password.";
    }
    
    if (!empty($errors)) {
        echo display_errors($errors);
    }else{
        $options = ['cost' => 10];			
        	
        if(!empty($password)){
        $password_hash = password_hash($password, PASSWORD_DEFAULT, $options);
        }else{
        $password_hash = $pass_before;
        }	
        $update = $mysqli->query("UPDATE tbl_pegawai SET username='$username', password = '$password_hash', nama_pegawai = '$nama_pegawai', email='$email', no_hp='$no_hp', is_admin = '$is_admin' where id_pegawai = '$id_pegawai' ");

        if ($update == true) {
            
            echo sweetalert('', "", 'success', '0', 'false', '?page=pegawai');

        }
    }
    echo "<hr>";
}

	if (@$_GET['del_id']) {
		$del_id = $_GET['del_id'];
		$delete = $mysqli->query("DELETE FROM tbl_pegawai WHERE id_pegawai = '$del_id' ");
		if ($delete) {
			$text = "Data User berhasil dihapus.";
			echo sweetalert('Berhasil.!', $text, 'success', '2000', 'false', '?page=pegawai');
		}
	}
?>
<div class="row">
	<div class="col-md-12 col-xs-12 col-sm-12">
		<div class="tile">
			
					<div class="col-md-12 col-md-offset-3">
						<div class="pull-right">
						    <button class="btn btn-primary add_p"><i class="fa fa-fw fa-lg fa-user-plus"></i> User</button>
                        </div><br><br><br>
						
					</div>
<div class="col-md-13">
		<div class="tab-content">
			<div class="tab-pane active" id="user-info">
				<div class="user-info">

		<div class="table-responsive">
        <table class="table table-hover" id="tabelKu" width="100%">
            <thead>
                <tr><th class="text-center">No.</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">No. HP</th>
                    <th class="text-center">Role</th>
                    <th class="text-center">Opsi</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php 
                $noUrut = 0;
                $sql = $mysqli->query("SELECT * FROM tbl_pegawai order by id_pegawai desc");

                while($data = mysqli_fetch_assoc($sql)):
                        $noUrut++?>
                    <tr><td><?= $noUrut?></td>
                        <td><?= $data['nama_pegawai'] ?></td>
                        <td class="text-center"><?= $data['email'] ?></td>
                        <td class="text-center"><?= $data['no_hp'] ?></td>
                        <td class="text-center">
                            <?php if($data['is_admin'] == 1) {?>
                                <img src="images/assets/role1.png" width="50px">
                            <?php } else {?>
                                <img src="images/assets/role2.png" width="50px">
                            <?php }?>
                        </td>
                        <td class="text-center">
                        <a class="btn btn-warning btn-sm edit_p" 
                        <?php 
                        // if($data['is_admin'] == 1 && $data['id_pegawai'] != $dataku['id_pegawai']){
                            // echo 'disabled';}
                        ?>
                             id="<?=$data['id_pegawai']?>">&nbsp;<i class="fa fa-pencil" ></i></a>
                        <?php if($data['id_pegawai']=="1"):?> 
                            <a href="#"  disabled class="btn btn-sm btn-light tombol-hapus" alt="Tidak menghapus Administrator"	>&nbsp;<i class="fa fa-trash"></i></a>
                        <?php elseif($data['id_pegawai']== $idgue):?> 
                            <a href="#"  disabled class="btn btn-sm btn-light tombol-hapus" alt="Tidak menghapus Administrator"	>&nbsp;<i class="fa fa-trash"></i></a>
                        <?php else :?>
                            <a href="?page=pegawai&del_id=<?= $data['id_pegawai'] ?>" onclick="return confirm('Yakin Hapus <?php echo $data['nama_pegawai'] ?>')" class="btn btn-sm btn-danger tombol-hapus">&nbsp;<i class="fa fa-trash"></i></a>
                        <?php endif;?>
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

<!--                                                     end Modal                                                          -->

<script>
//form input
$(document).on('click', '.add_p', function(){
  $.ajax({
   url:"pages/pegawai/add_pegawai.php",
   success:function(data){
    $('#form_add').html(data);
    $('#addModal').modal('show');
   }
  });
 });

 $(document).on('click', '.edit_p', function(){
  var idnya = $(this).attr("id");
  $.ajax({
   url:"pages/pegawai/edit_pegawai.php",
   method:"POST",
   data:{idnya:idnya},
   success:function(data){
    $('#form_edit').html(data);
    $('#editModal').modal('show');
   }
  });
 });


</script>