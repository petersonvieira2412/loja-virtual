<?php
require_once "config.php";
if (!isset($_POST['tipo'])){$_POST['tipo'] = '';}
$tipo = $_POST['tipo'];

if ($tipo=='cor'){
	if (!isset($_POST['id'])){$_POST['id'] = '';}
	if (!isset($_POST['qtd'])){$_POST['qtd'] = '';}
	if (!isset($_POST['preco'])){$_POST['preco'] = '';}

	$id = $_POST['id'];
	$qtd = $_POST['qtd'];
	$preco = $_POST['preco'];

	$insere = "UPDATE estoque SET qtd='$qtd', preco='$preco' WHERE id='$id'";
	$query = mysqli_query($conexao, $insere);

	if ($query){
		$dados = 'verdadeiro';
		$retorno["dados"] = $dados;
	}else{
		$dados = 'falso';
		$retorno["dados"] = $dados;
	}
}elseif ($tipo=='tamanho'){
    if (!isset($_POST['id'])){$_POST['id'] = '';}
	if (!isset($_POST['qtd'])){$_POST['qtd'] = '';}
	if (!isset($_POST['preco'])){$_POST['preco'] = '';}

	$id = $_POST['id'];
	$qtd = $_POST['qtd'];
	$preco = $_POST['preco'];

	$insere = "UPDATE estoque SET qtd='$qtd', preco='$preco' WHERE id='$id'";
	$query = mysqli_query($conexao, $insere);

	if ($query){
		$dados = 'verdadeiro';
		$retorno["dados"] = $dados;
	}else{
		$dados = 'falso';
		$retorno["dados"] = $dados;
	}
}
echo json_encode($retorno);