<!-- Template Umum Jivi--><?php 
session_start();
session_destroy();
unset($_SESSION['logedin']);
unset($_SESSION['username']);
unset($_SESSION['id_user']);
header('Location: index.php');
?>