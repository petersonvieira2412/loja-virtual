<?
setlocale (LC_ALL, 'pt_BR');
date_default_timezone_set('America/Sao_Paulo');
session_start();

$agora = date('Y-m-d H:i:s');
if (!isset($_SESSION["controle_vb_tempo"])){$_SESSION["controle_vb_tempo"] = '';}

if((strtotime($agora) - strtotime($_SESSION["controle_vb_tempo"])) / 60 > 60 || $_SESSION['usr_id_cliente']<1){
	unset($_SESSION['controle_vb_cliente']);
	unset($_SESSION['usr_id_cliente']);
	unset($_SESSION['usr_nome_cliente']);
	unset($_SESSION["usr_foto_cliente"]);
	header('location:login');
    exit();
}else{
	$_SESSION["controle_vb_tempo"] = $agora;
}
?>