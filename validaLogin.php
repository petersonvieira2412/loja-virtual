<?php
require_once "includes/config.php";

$email = trim(addslashes(htmlspecialchars($_POST['email'])));
$senha = trim(addslashes(htmlspecialchars($_POST['senha'])));

$retorno["erro"] = true;

$qr = mysqli_query($conn,"SELECT * FROM clientes WHERE email='".$email."' AND senha='".sha1($senha)."' AND status='a' LIMIT 1");
if(mysqli_num_rows($qr)>0){
	$retorno["erro"] = false;
	$dados = mysqli_fetch_array($qr);
	$_SESSION["usr_id_cliente"] = $dados['id'];
	$_SESSION["usr_nome_cliente"] = $dados['responsavel_nome'];
	$_SESSION["usr_foto_cliente"] = $dados['foto'];
	$_SESSION["controle_vb_cliente"] = "vb_cliente";
	$_SESSION["controle_vb_tempo"] = date('Y-m-d H:i:s');
	$_SESSION["sessao_rola_endereco"] = 'sim';

	$sql = "SELECT id FROM carrinho WHERE sessao='".$_POST['sessao']."'";
	$query = mysqli_query($conn, $sql);
	$num_rows = mysqli_num_rows($query);

	while ($dados = mysqli_fetch_array($query)){
		$id = $dados['id'];

		$update = "UPDATE carrinho SET id_cliente='".$_SESSION["usr_id_cliente"]."' WHERE id='".$id."'";
		$query_update = mysqli_query($conn, $update);
	}
}
echo json_encode($retorno);