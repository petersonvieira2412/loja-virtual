<?
session_start();
unset($_SESSION['controle_vb_cliente']);
unset($_SESSION['usr_id_cliente']);
unset($_SESSION['usr_nome_cliente']);
unset($_SESSION['usr_foto_cliente']);
unset($_SESSION['pag_confirmacao']);
header('location:/');exit();
?>