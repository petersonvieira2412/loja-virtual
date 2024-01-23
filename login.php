<?
require_once "includes/config.php";
if (isset($_POST['usuario']) AND $_POST['usuario']!=''){
    $usuario = $_POST['usuario'];
}else{
    $usuario = '';
}
if (isset($_POST['senha']) AND $_POST['senha']!=''){
    $senha = $_POST['senha'];
    $senha = sha1($senha);
}else{
    $senha = '';
}
$sql = "SELECT * FROM clientes WHERE email='$usuario' AND senha='$senha' AND status='a' LIMIT 1";
$resultado = mysqli_query($conn, $sql) or die(mysqli_error($conn));
if(mysqli_num_rows($resultado)>0){
	while ($user_info = mysqli_fetch_array($resultado)) {
		$usr_id = $user_info['id'];
		$usr_nome = $user_info['responsavel_nome'];
		$usr_foto = $user_info['foto'];
		$usr_autorizado = 1;
	}
	$resultado->close();
	$_SESSION["usr_id_cliente"] = $usr_id;
	$_SESSION["usr_nome_cliente"] = $usr_nome;
	$_SESSION["usr_foto_cliente"] = $usr_foto;
	$_SESSION["controle_vb_cliente"] = "vb_cliente";
	$_SESSION["controle_vb_tempo"] = date('Y-m-d H:i:s');
	
	$sql = "SELECT id FROM carrinho WHERE sessao='".session_id()."'";
	$query = mysqli_query($conn, $sql);
	$num_rows = mysqli_num_rows($query);
	
	if($num_rows>0){
		$retorno["pagina"] = $url_loja.'/carrinho';
	}else{
	    $retorno["pagina"] = $url_loja.'/perfil';
	}

	while ($dados = mysqli_fetch_array($query)){
		$id = $dados['id'];

		$update = "UPDATE carrinho SET id_cliente='".$_SESSION["usr_id_cliente"]."' WHERE id='".$id."'";
		$query_update = mysqli_query($conn, $update);
	}
	$retorno["login"] = 'sucesso';
}else{
    $retorno["login"] = 'falso';
    $retorno["pagina"] = '';
}
echo json_encode($retorno);
?>