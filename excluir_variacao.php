<?php
require_once "config.php";
if (!isset($_POST['tipo'])){$_POST['tipo'] = '';}
$tipo = $_POST['tipo'];

if ($tipo=='cor'){
	if (!isset($_POST['id'])){$_POST['id'] = '';}

	$id = $_POST['id'];

	$insere = "DELETE FROM estoque WHERE id='$id' OR id_pai='$id'";
	$query = mysqli_query($conexao, $insere);

	if ($query){
		$dados = 'verdadeiro';
		$retorno["dados"] = $dados;
	}else{
		$dados = 'falso';
		$retorno["dados"] = $dados;
	}
}
if ($tipo=='tamanho'){
	if (!isset($_POST['id'])){$_POST['id'] = '';}

	$id = $_POST['id'];

	$insere = "DELETE FROM estoque WHERE id='$id'";
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