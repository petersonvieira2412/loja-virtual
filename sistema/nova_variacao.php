<?php
require_once "config.php";

if (!isset($_POST['tipo'])){$_POST['tipo'] = '';}
$tipo = $_POST['tipo'];
if ($tipo=='cor'){

	if (!isset($_POST['nome_cor'])){$_POST['nome_cor'] = '';}
	if (!isset($_POST['rgb_cor'])){$_POST['rgb_cor'] = '';}

	$nome_cor = $_POST['nome_cor'];
	$rgb_cor = $_POST['rgb_cor'];
    $data = date("Y-m-d");
    $hora = date("H:i:s");

	$insere = "INSERT INTO variacoes (titulo, variacao, rgb, data_cadastro, hora_cadastro, status) VALUES ('Cor', '$nome_cor', '$rgb_cor', '$data', '$hora' , 'a')";
	$query = mysqli_query($conexao, $insere);
    $ultimo_id = mysqli_insert_id($conexao);

	if ($ultimo_id!=''){
		$conteudo = '<option value="'.$ultimo_id.'>'.$nome_cor.'</option>';
		$dados = 'verdadeiro';
		$retorno["dados"] = $dados;
		$retorno["conteudo"] = $conteudo;
	}else{

		$conteudo = '';
		$dados = 'falso';
		$retorno["dados"] = $dados;
		$retorno["conteudo"] = $conteudo;

	}
}
echo json_encode($retorno);