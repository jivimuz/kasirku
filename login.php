<!-- Template Umum Jivi--><?php
session_start();
if (isset($_SESSION['logedin'])) {
	header('location: .');
}

require_once 'library/f_library.php';
require_once 'library/config.php';
	
?>
<style type="text/css">
.pont{
	cursor: pointer;
}
body {
  background-image: url('https://img.freepik.com/free-vector/elegant-white-background-with-shiny-lines_1017-17580.jpg?w=2000');
  background-size: cover;
}
</style>
<body>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" href="">
	<title>Kasirku</title>
	<!-- og:property -->
	
<meta name="mobile-web-app-capable" content="yes">

    <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/sweetalert2.css">


    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/sweetalert.min.js"></script>

    
	<section class="login-content">
			<p class="text-aja"> KASIRKU <i class="fa fa-cart-arrow-down"></i></p>
		<div class="logo"></div>
		<div class="col-md-6 col-sm-6 col-xs-8">
			<?php 
			$username = ((isset($_POST['username']))?sanitize($_POST['username']):'');
			$username = trim($username);
			$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
			$password = trim($password);

			$errors = array();

			if (isset($_POST['login'])) {
				$username = sanitize($_POST['username']);
				$password = sanitize($_POST['password']);

				$sql = $mysqli->query("SELECT * FROM tbl_pegawai WHERE username = '$username'");
				$data = mysqli_fetch_array($sql);
				
				if (mysqli_num_rows($sql) > 0) {
					if (!password_verify($password, $data['password'])) {
						$errors[] = "Password Yang Anda Masukkan Salah.!";

					}
				}else{
					$errors[] = "<strong>Harap masukan id atau Password dengan benar...</strong>";
				}

				if (!empty($errors)) {
					echo display_errors($errors);
				}else{

					$_SESSION['logedin'] = TRUE;
					$_SESSION['username'] = $data['username'];
					$_SESSION['id_pegawai'] = $data['id_pegawai'];

                    header("location: .");		
								
				}
			}
			
						$nama_pegawai = ((isset($_POST['nama_pegawai']))?sanitize($_POST['nama_pegawai']):'');
						$nama_pegawai = trim($nama_pegawai);

                        $username2 = ((isset($_POST['username2']))?sanitize($_POST['username2']):'');
						$username2 = trim($username2);

                        $password2 = ((isset($_POST['password2']))?sanitize($_POST['password2']):'');
						$password2 = trim($password2);


						$errors = array();

						if (isset($_POST['do_register'])) {
							$nama_pegawai = sanitize($_POST['nama_pegawai']);	
							$username2 = sanitize($_POST['username2']);	
							$password2 = sanitize($_POST['password2']);	
							$email = sanitize($_POST['email']);	
							$no_hp = sanitize($_POST['no_hp']);	

                            $sel = $mysqli->query("select id_pegawai from tbl_pegawai where username = '$username2'");

                            if(mysqli_num_rows($sel) > 0){
								$errors[] = "Username Sudah Terdaftar.";
                            }

							if (strlen($password2) < 6) {
								$errors[] = "Gunakan mininal 6 karakter untuk password.";
							}
							
							if (!empty($errors)) {
								echo display_errors($errors);
							}else{
								$options = ['cost' => 10];					
								$password_hash = password_hash($password2, PASSWORD_DEFAULT, $options);
								$update = $mysqli->query("INSERT INTO tbl_pegawai SET username='$username2',  password = '$password_hash', nama_pegawai = '$nama_pegawai',email='$email', no_hp='$no_hp'");

								if ($update == true) {
									echo '<div class="col-md-12 alert alert-success alert-dismissable" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<font style="font-style: italic;">Data Berhasil ditambahkan, silahkan login</font></div>&nbsp;&nbsp;';
								}
							}
							echo "<hr>";
						}

						?>
		</div>
        <div class="row">
        <div class="col-md-6 ">
            <img class="img-goyang" src="https://i0.wp.com/capitalsoutsider.com/wp-content/uploads/2012/01/LegoVechkinLARGEtransparent.gif?resize=400%2C404&ssl=1" width="370px  vertical-center justify-content-center">
        </div>
        <div class="col-md-6">
		    <div class="login-box">

		<form class="login-form" method="POST" action="">
			<h3 class="login-head"><i class="fa fa-user-circle-o"></i> Login</h3>
				<div class="form-group">
					<label class="control-label">Username</label>
					<input class="form-control" name="username" onkeyup="this.value = this.value.toUpperCase()" type="text" placeholder="Username" value="<?= $username; ?>" autofocus required>
				</div>
				<div class="form-group">
					<label class="control-label">Password</label>
    					<div class="input-group">
					        <input class="form-control" type="password" id="password"  name="password" placeholder="Password" value="<?= $password; ?>" required>

							<div class="input-group-append mb-3">
								<span class="input-group-text" id="basic-addon2" style="background-color:white;">
									<i style="font-size:22px;" id="show" onclick="show()" class="fa fa-eye-slash pont"></i>
									<i style="font-size:22px;color: orange;" id="hide" onclick="hide()" class="fa fa-eye pont" hidden=""></i></span>
							</div>
						</div>
                    <!-- <p class="semibold-text mb-2"><a style="text-decoration: none;" href="#" data-toggle="flip">Belum Punya Akun ?</a></p> -->

				</div>
				
		        <input type="text"  id="current" hidden="" name="lokasi" align="center">
				
				<div class="form-group btn-container">
					<button type="submit" name="login" class="btn btn-warning btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>Login</button><br><br>
					</div>
					<br>

			</form>

           
            <form  action=""  class="forget-form" method="POST">
				<h3 class="login-head"><i class="fa fa-user-plus"></i> Register</h3>
				<div class="form-group">
					<label class="control-label">Silahkan Isi data dibawah:</label>
					<input class="form-control" name="username2" type="text" maxlength="30" placeholder="Username" onkeyup="this.value = this.value.toUpperCase()" autofocus required>
                </div>
                <div class="form-group">
                    <input class="form-control" name="password2" type="password" maxlength="50" placeholder="Password (min 6)" autofocus required>
                </div>
                <div class="form-group">
                     <input class="form-control" name="nama_pegawai" type="text" maxlength="50" placeholder="Nama Lengkap" autofocus required>
                </div>
                <div class="form-group">
                    <input class="form-control" name="email" type="email" maxlength="255" placeholder="Email" autofocus required>
				</div>
				<div class="form-group">
                    <input class="form-control" name="no_hp" type="number" maxlength="99999999999999" placeholder="No. HP" autofocus>
				</div>
				<div class="form-group btn-container">
					<button class="btn btn-primary btn-block" type="submit" name="do_register"><i class="fa fa-check fa-lg fa-fw"></i>Register</button>
				</div>
				<div class="form-group mt-3">
					<p class="semibold-text mb-0"><a style="text-decoration: none;" href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Kembali Login</a></p>
				</div>
			</form>
            </div>
         </div>
		</div>
	</section>


</div>
</body>

<script src="js/js-login.js" type="text/javascript" charset="utf-8"></script>

