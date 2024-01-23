<?php
require_once "config.php";

	if (!isset($_POST['id_lead'])){$_POST['id_lead'] = '';}
	if (!isset($_POST['nivel'])){$_POST['nivel'] = '';}
	if (!isset($_POST['nome'])){$_POST['nome'] = '';}
	if (!isset($_POST['comentario'])){$_POST['comentario'] = '';}

	$id_lead = $_POST['id_lead'];
	$nivel = $_POST['nivel'];
	$nome = $_POST['nome'];
	$comentario = $_POST['comentario'];

	$insere = "INSERT INTO atendimento (id_lead, nivel, data, hora, comentario, status) VALUES ('$id_lead', '$nivel', '".date("Y-m-d")."', '".date("H:i:s")."', '$comentario', 'a')" or die(mysqli_error());
	$query = mysqli_query($conexao, $insere);
	
	if ($query==true){
	    
	    if ($nivel=='10'){
            $classe = 'class="timeline-inverted"';
            $cor = 'success';
            $nome = 'ADM';
        }else{
            $classe = '';
            $cor = '';
        }

		$dados = 'verdadeiro';
		$conteudo = '<li '.$classe.'>
                        <div class="timeline-badge '.$cor.'"><i class="fa fa-check"></i> </div>
                        <div class="timeline-panel">
                          <div class="timeline-heading">
                            <h4 class="timeline-title">'.$nome.'</h4>
                            <p><small class="text-muted"><i class="fa fa-clock-o"></i> '.date("d/m/Y").' às '.date("H:i").'</small> </p>
                          </div>
                          <div class="timeline-body">
                            <p>'.$comentario.'</p>
                          </div>
                        </div>
                    </li>';

	}else{
		
		$dados = 'falso';
		$conteudo = '';

	}
$retorno["conteudo"] = $conteudo;
$retorno["dados"] = $dados;
echo json_encode($retorno);