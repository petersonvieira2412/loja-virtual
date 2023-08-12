<?php
require_once "config.php";
if (!isset($_POST['tipo'])){$_POST['tipo'] = '';}
$tipo = $_POST['tipo'];

if ($tipo=='cor'){
	if (!isset($_POST['id'])){$_POST['id'] = '';}
	if (!isset($_POST['id_produto'])){$_POST['id_produto'] = '';}
	if (!isset($_POST['qtd'])){$_POST['qtd'] = '';}
	if (!isset($_POST['rgb'])){$_POST['rgb'] = '';}
	if (!isset($_POST['preco'])){$_POST['preco'] = '';}
	if (!isset($_POST['valor'])){$_POST['valor'] = '';}

	$id = $_POST['id'];
	$id_produto = $_POST['id_produto'];
	$qtd = $_POST['qtd'];
	$preco = $_POST['preco'];
	$rgb = $_POST['rgb'];
	$valor = $_POST['valor'];
    $data = date("Y-m-d");
    $hora = date("H:i:s");

	$insere = "INSERT INTO estoque (id_variacao, id_produto, id_pai, rgb, qtd, preco, data_cadastro, hora_cadastro, status) VALUES ('$id', '$id_produto', '0', '$rgb', '$qtd', '$preco', '$data', '$hora' , 'a')";
	$query = mysqli_query($conexao, $insere);
    $ultimo_id = mysqli_insert_id($conexao);

	if ($ultimo_id!=''){
		$dados = 'verdadeiro';
		$retorno["dados"] = $dados;
		$retorno["valor"] = $valor;
		$retorno["ultimo_id"] = $ultimo_id;
	}else{

		$dados = 'falso';
		$retorno["dados"] = $dados;
		$retorno["ultimo_id"] = $ultimo_id;

	}
}
if ($tipo=='tamanho'){
	if (!isset($_POST['id'])){$_POST['id'] = '';}
	if (!isset($_POST['id_cor'])){$_POST['id_cor'] = '';}
	if (!isset($_POST['id_produto'])){$_POST['id_produto'] = '';}
	if (!isset($_POST['qtd'])){$_POST['qtd'] = '';}
	if (!isset($_POST['preco'])){$_POST['preco'] = '';}
	if (!isset($_POST['valor'])){$_POST['valor'] = '';}

	$id = $_POST['id'];
	$id_cor = $_POST['id_cor'];
	$id_produto = $_POST['id_produto'];
	$qtd = $_POST['qtd'];
	$preco = $_POST['preco'];
	$valor = $_POST['valor'];
    $data = date("Y-m-d");
    $hora = date("H:i:s");

	$insere = "INSERT INTO estoque (id_variacao, id_produto, id_pai, qtd, preco, data_cadastro, hora_cadastro, status) VALUES ('$id', '$id_produto', '$id_cor', '$qtd', '$preco', '$data', '$hora' , 'a')";
	$query = mysqli_query($conexao, $insere);
    $ultimo_id = mysqli_insert_id($conexao);

	if ($ultimo_id!=''){
		$dados = 'verdadeiro';
		$retorno["dados"] = $dados;
		$retorno["valor"] = $valor;
		$retorno["ultimo_id"] = $ultimo_id;
	}else{

		$dados = 'falso';
		$retorno["dados"] = $dados;
		$retorno["ultimo_id"] = $ultimo_id;

	}
}
echo json_encode($retorno);