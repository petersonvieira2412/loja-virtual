<?php
require_once "includes/config.php"; 
$token = $_GET['token'];
if($token!=''){
	$temCod = mysqli_query($conn,"SELECT id FROM clientes WHERE token='$token' AND status='a' LIMIT 1") or die(mysqli_error($conn));
	if(mysqli_num_rows($temCod)==0){
		echo "<script>alert('Token de recuperação de Senha inválido!');</script>";
		echo "<meta http-equiv='refresh' content=0;url='/login'>";
		exit(); 
	}else{
		$_SESSION["_browser_nav_cache_token_"] = $token;
		echo "<meta http-equiv='refresh' content=0;url='".$url_loja."/recuperar_senha'>";
		exit();
	}
}else{
	echo "<script>alert('Token de recuperação de Senha inválido!');</script>";
	echo "<meta http-equiv='refresh' content=0;url='".$url_loja."/login'>";
	exit();
}