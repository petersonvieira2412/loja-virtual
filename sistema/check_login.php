<?php


ob_start();
session_start();

setlocale (LC_ALL, 'pt_BR');
date_default_timezone_set('America/Sao_Paulo');

$agora = date('Y-m-d H:i:s');if((strtotime($agora) - strtotime($_SESSION["controle_vb_tempo"])) / 60 > 30 || $_SESSION['usr_id']==''){	unset($_SESSION['controle_vb_painel_tempo']);	unset($_SESSION['usr_id']);	header('location:../sistema');    exit();}else{	$_SESSION["controle_vb_painel_tempo"] = $agora;}

?>