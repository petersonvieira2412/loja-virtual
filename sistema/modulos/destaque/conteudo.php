<?php
include_once "config.php";
$pagina_titulo = "destaque";
$pagina_referencia = "destaque";
$id = (int)$id;

setlocale(LC_ALL, 'pt_BR.UTF8');
function UrlAmigavel($str, $replace=array(), $delimiter='-') {
	if( !empty($replace) ) {
		$str = str_replace((array)$replace, ' ', $str);
	}

	$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
	$clean = strtolower(trim($clean, '-'));
	$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
	$clean = substr($clean, 0, 120);

	return $clean;
}
function comprimirImagem($diretorio, $diretorio_final, $qualidade) {
    $info = getimagesize($diretorio);
    if ($info['mime'] == 'image/jpeg') {
        $image = imagecreatefromjpeg($diretorio);
    } elseif ($info['mime'] == 'image/gif') {
        $image = imagecreatefrompng($diretorio);
    } elseif ($info['mime'] == 'image/png') {
        $image = imagecreatefrompng($diretorio);
    }
    imagejpeg($image, $diretorio_final, $qualidade);
    return $diretorio_final;
}

if ($acao=="cadastrar") {
  
    if (isset($_POST['upload_img'])) {

        $titulo = $_POST['titulo'];
        $extensao = ".jpg";
        //$extensao = $_POST['extensao'];
        $base64_img = $_POST['base64'];
        $url = $_POST['url'];
        $tipo = $_POST['tipo'];
        $data_cadastro = $_POST['data_cadastro'];
        $hora_cadastro = $_POST['hora_cadastro'];
        $data_inteiro = $data_cadastro.' '.$hora_cadastro;
        if (isset($_POST['check']) AND $_POST['check']=='sim'){
            $data_fim = $_POST['data_fim'];
            $hora_fim = $_POST['hora_fim'];
            $data_final = $data_fim.' '.$hora_fim.':00';
        }else{
            $data_final = '0000-00-00 00:00:00';
        }
        $rand = rand(1,999999);

        $insert_destaque = "INSERT INTO $pagina_referencia (img, titulo, url, tipo, data_inteiro, data_fim, data_cadastro, hora_cadastro, flag, status) VALUES ('sem_imagem.webp', '$titulo', '$url', '$tipo', '$data_inteiro', '$data_final', '$data_cadastro', '$hora_cadastro', 'i', 'a')" or die(mysqli_error());
        $insert_query = mysqli_query($conexao, $insert_destaque);
        $ultimo_id = mysqli_insert_id($conexao);

        if ($base64_img == "") {
            $_SESSION['alerta_mensagem'] = "Corte a imagem antes de enviar!";
            $_SESSION['alerta_tipo'] = "red";
        } else {
            $image = explode(',', $base64_img);		
            $upload_img = base64_decode($image[1]);        
            $img = $sitenome.'-'.$ultimo_id.'-'.UrlAmigavel($titulo).'-'.$rand.$extensao;		
            $caminho = "../assets/img/destaque/imagens/";
            $file_uploaded = file_put_contents($caminho.$img, $upload_img);		
            if (!$file_uploaded) {
                header('Location: index.php?file_upload_failed');
            } else {
                comprimirImagem($caminho.$img, $caminho.$img, 90);
                $update_destaque = "UPDATE $pagina_referencia SET img='$img', data_fim='$data_final' WHERE (id = '$ultimo_id');" or die(mysqli_error());
                $update_query = mysqli_query($conexao, $update_destaque);
                if ($update_query) {
                    $_SESSION['alerta_mensagem'] = "Imagem enviada com sucesso!";
                    $_SESSION['alerta_tipo'] = "green";
                    echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";
                }
            }
        }
    }
?>

<div class="row">
    <div class="col-md-12  header-wrapper">
        <h1 class="page-header">Adicionar destaque</h1>
        <p class="page-subtitle">Para cadastrar um novo item, preencha os dados abaixo.</p>
    </div>
</div>

<!-- Content -->
<div class="container">
    <div class="alert alert-warning" role="alert">
        <strong>Tamanho de imagem minimo: 1200x400 pixels</strong>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="img-container">
                <img id="image" src="../assets/img/destaque/imagens/sem_imagem.webp" alt="Imagem indisponivel" title="Imagem indisponivel">
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-12 docs-buttons">

            <div class="docs-data" hidden>
                <div class="input-group input-group-sm">
                    <span class="input-group-prepend">
                        <label class="input-group-text" for="dataWidth">Largura</label>
                    </span>
                    <input type="text" class="form-control" id="dataWidth" placeholder="width" value="1200">
                    <span class="input-group-append">
                        <span class="input-group-text">px</span>
                    </span>
                </div>
                <div class="input-group input-group-sm">
                    <span class="input-group-prepend">
                        <label class="input-group-text" for="dataHeight">Altura</label>
                    </span>
                    <input type="text" class="form-control" id="dataHeight" placeholder="height" value="400">
                    <span class="input-group-append">
                        <span class="input-group-text">px</span>
                    </span>
                </div>
            </div>

            <!-- <h3>Toolbar:</h3> -->
            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="move" data-option="-10"
                    data-second-option="0" title="Move Left">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Mover à esquerda">
                        <span class="fa fa-arrow-left"></span>
                    </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="move" data-option="10" data-second-option="0"
                    title="Move Right">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Mover à direita">
                        <span class="fa fa-arrow-right"></span>
                    </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="move" data-option="0"
                    data-second-option="-10" title="Move Up">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Mover para cima">
                        <span class="fa fa-arrow-up"></span>
                    </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="10"
                    title="Move Down">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Mover para baixo">
                        <span class="fa fa-arrow-down"></span>
                    </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="rotate" data-option="-15"
                    title="Rotate Left">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Girar à esquerda">
                        <span class="fa fa-rotate-left"></span>
                    </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="rotate" data-option="15"
                    title="Rotate Right">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Girar à direita">
                        <span class="fa fa-rotate-right"></span>
                    </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="scaleX" data-option="-1"
                    title="Flip Horizontal">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Inverter horizontal">
                        <span class="fa fa-arrows-h"></span>
                    </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="scaleY" data-option="-1"
                    title="Flip Vertical">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Inverter vertical">
                        <span class="fa fa-arrows-v"></span>
                    </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="reset" title="Reset">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Resetar">
                        <span class="fa fa-compress"></span>
                    </span>
                </button>
                <label class="btn btn-primary btn-upload" for="inputImage" title="Upload image file">
                    <input type="file" class="sr-only" id="inputImage" name="file"
                        accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Importar imagem">
                        <i class="fa fa-image "></i>
                        <span style="margin-left: 5px;">Escolha o arquivo</span>
                    </span>
                </label>
            </div>

            <div class="btn-group btn-group-crop">
                <button type="button" class="btn btn-success" data-method="getCroppedCanvas" data-option="{ &quot;width&quot;: 1200, &quot;height&quot;: 400 }">
                    <span class="docs-tooltip" data-toggle="tooltip" title="Enviar">
                        Enviar
                    </span>
                </button>
            </div>

            <div class="btn-group btn-group-crop pull-right">
                <a href="<?=$pagina_referencia;?>" title="Voltar" class="btn btn-primary" Title="Voltar">Voltar</a>
            </div>

            <!-- Show the cropped image in modal -->
            <div class="modal fade docs-cropped" id="getCroppedCanvasModal" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" role="dialog" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="getCroppedCanvasTitle">Deseja enviar?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer" style="padding-bottom: 0px;">
                            <form action="" method="post" style="padding: 0 !important;margim: 0 !important;margin-bottom: 0px;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="pull-left">TÍTULO DA IMAGEM</label>
                                            <input name="titulo" type="text" class="form-control" id="titulo" placeholder="Descreva esta imagem">
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label class="pull-left">LINK DA IMAGEM</label>
                                            <input name="url" type="url" class="form-control" id="url" placeholder="<?=$psite;?>" value="<?=$psite;?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="pull-left">TIPO DE LINK</label>
                                            <select class="form-control" name="tipo">
                                                <option value="interno">Interno</option>
                                                <option value="externo">Externo</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="pull-left">DATA DA POSTAGEM</label>
                                            <input name="data_cadastro" type="date" required="required" autofocus class="form-control" id="data_cadastro" placeholder="" maxlength="255" value="<?=date('Y-m-d');?>" min="<?=date('Y-m-d');?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="pull-left">HORA DA POSTAGEM</label>
                                            <input name="hora_cadastro" type="time" required="required" class="form-control" id="hora_cadastro" placeholder="" value="<?=date('H:i');?>">
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="list-group">
                                            <div class="list-group-item withswitch" style="text-align: -webkit-left;">
                                                <h5 class="list-group-item-heading">PROGAMAR REMOÇÃO?</h5>
                                                <div class="switch">
                                                    <input id="check" name="check" value="sim" class="cmn-toggle cmn-toggle-round" type="checkbox">
                                                    <label for="check"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6" style="display: none;" id="div_data_remocao">
                                        <div class="form-group">
                                            <label class="pull-left">DATA DA REMOÇÃO</label>
                                            <input name="data_fim" type="date" required="required" autofocus class="form-control" id="data_fim" placeholder="" maxlength="255" value="<?=date('Y-m-d');?>" min="<?=date('Y-m-d');?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6" style="display: none;" id="div_hora_remocao">
                                        <div class="form-group">
                                            <label class="pull-left">HORA DA REMOÇÃO</label>
                                            <input name="hora_fim" type="time" required="required" class="form-control" id="hora_fim" placeholder="" value="<?=date('H:i');?>">
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <hr>
                                </div>

                                <br>

                                <div class="col-md-12">
                                    <div class="form-group" style="margim: 0 !important;padding: 0 !important;margin-bottom: 0px;">
                                        <button type="submit" id="upload_img" name="upload_img" class="btn btn-primary">
                                            <i class="fas fa-file-upload"></i> Salvar </button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" hidden>Fechar</button>
                                    </div>
                                </div>

                                <!-- IGNORA -->
                                <input type="hidden" name="extensao" id="extensao">
                                <input type="hidden" name="base64" id="base64">
                                <a hidden class="btn btn-primary invisible" id="download" href="javascript:void(0);" download="cropped.jpg">Download</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal -->
        </div><!-- /.docs-buttons -->

    </div>
</div>

<? }

if ($acao=="excluir") { //ANCHOR exluir

    $data_excluir = date('Y-m-d');
    $hora_excluir = date('H:i:s');
    $ip = $_SERVER['REMOTE_ADDR'];
    $endereco_ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);

    $update = "UPDATE $pagina_referencia SET status='d' WHERE id='".$id."'";

    if (!mysqli_query($conexao, $update)) {  
        die('Error: '.mysqli_error($conexao)); 
    } else {
        $_SESSION['alerta_mensagem'] = "Removido com sucesso!";
        $_SESSION['alerta_tipo'] = "green";
        echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";
    }

}	
if (isset($_POST['delete'])){
    $id = $_POST['id'];
    $arquivo = $_POST['arquivo'];
    $delete = "DELETE FROM $pagina_referencia WHERE status='d' AND id='".$id."'";
    if (!mysqli_query($conexao, $delete)) {  
        die('Error: '.mysqli_error($conexao)); 
    } else {
        unlink($arquivo);
        $_SESSION['alerta_mensagem'] = "Excluido com sucesso!";
        $_SESSION['alerta_tipo'] = "green";
        echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";
    }
}
if ($acao=="gravar_editar") { //ANCHOR Gravar Editar
    $titulo = $_POST['titulo'];
	$data_cadastro = trim(addslashes(htmlspecialchars($_POST['data_cadastro'])));
	$hora_cadastro = trim(addslashes(htmlspecialchars($_POST['hora_cadastro'])));
	$data_inteiro = $data_cadastro.' '.$hora_cadastro;
	
	if (isset($_POST['check']) AND $_POST['check']=='sim'){
        $data_fim = $_POST['data_fim'];
        $hora_fim = $_POST['hora_fim'];
        $data_final = $data_fim.' '.$hora_fim.':00';
        if ($data_final<$data_inteiro){
            $data_final = '0000-00-00 00:00:00';
        }
    }else{
        $data_final = '0000-00-00 00:00:00';
    }
    
	
    $url = trim(addslashes($_POST['url']));
    $tipo = trim(addslashes($_POST['tipo']));
	$ip = $_SERVER['REMOTE_ADDR'];
    $endereco_ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        
    $editar = "UPDATE $pagina_referencia SET titulo='$titulo', url='$url', tipo='$tipo', data_inteiro='$data_inteiro', data_fim='$data_final' WHERE id='$id'" or die(mysqli_error());

    if (mysqli_query($conexao, $editar)) {
        $_SESSION['alerta_mensagem'] = "Atualizado com sucesso!";
        $_SESSION['alerta_tipo'] = "green";
        echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";
    }
}
 
  if ($acao=="editar") { //ANCHOR Editar?>
<?
	$sql = "SELECT * FROM $pagina_referencia WHERE id='$id'";
	$query = mysqli_query($conexao, $sql);
	  
	$condicao = mysqli_num_rows($query);
	
	while ($dados = mysqli_fetch_assoc($query)) {
        $id = $dados['id'];
        $titulo = $dados['titulo'];
        
        $data_inteiro = explode(" ", $dados['data_inteiro']);
        $data_inicio = $data_inteiro[0];
        $hora_inicio = $data_inteiro[1];
        
        $data_final = $dados['data_fim'];
        
        if ($data_final>$dados['data_inteiro'] AND $dados['data_inteiro']>0){
            $data_final = explode(" ", $data_final);
            $data_fim = $data_final[0];
            $hora_fim = $data_final[1];
            $check = 'ativado';
        }else{
            $check = 'desativado';
        }
        
        $url = $dados['url'];
        $tipo = $dados['tipo'];
        $status = $dados['status'];
    }

	mysqli_free_result($query);
	?>
<div class="row">
    <div class="col-md-12 header-wrapper">
        <h1 class="page-header">Editar destaque</h1>
        <p class="page-subtitle">Para cadastrar um novo item, preencha os dados abaixo.</p>
    </div>
</div>

<form method="post" action="" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="panel panel-default ">
                <div class="panel-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>TÍTULO</label>
                            <input name="titulo" type="text" required="required" autofocus class="form-control"
                                id="titulo" placeholder="Título atual: <?=$titulo;?>" value="<?=$titulo;?>">
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label>LINK</label>
                            <input name="url" type="url" class="form-control" id="url"
                                placeholder="Link atual: <?=$url?>" value="<?=$url;?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>DATA DE POSTAGEM</label>
                            <input name="data_cadastro" type="date" required="required" autofocus class="form-control"
                                id="data_cadastro" placeholder="" maxlength="255" value="<?=$data_inicio;?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>HORA DE POSTAGEM</label>
                            <input name="hora_cadastro" type="time" required="required" class="form-control" id="hora_cadastro" value="<?=$hora_inicio;?>">
                        </div>
                    </div>

                    <div class="col-md-4"> 
                        <div class="form-group">
                        <label >TIPO DE LINK</label>
                            <select class="form-control" name="tipo">
                                <option value="interno" <?if ($tipo=="interno"){echo 'selected'; } ?>>Interno</option>
                                <option value="externo" <? if ($tipo=="externo"){echo 'selected'; } ?>>Externo</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="list-group">
                            <div class="list-group-item withswitch" style="text-align: -webkit-left;">
                                <h5 class="list-group-item-heading">PROGAMAR REMOÇÃO?</h5>
                                <div class="switch">
                                    <input id="check" name="check" value="sim" class="cmn-toggle cmn-toggle-round" type="checkbox" <?echo ((isset($check) AND $check=='ativado')?'checked':'');?>>
                                    <label for="check"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" style="<?echo ((isset($check) AND $check=='desativado')?'display: none;':'');?>" id="div_data_remocao">
                        <div class="form-group">
                            <label class="pull-left">DATA DA REMOÇÃO</label>
                            <input name="data_fim" type="date" required="required" autofocus class="form-control" id="data_fim" placeholder="" maxlength="255" value="<?=((isset($check) AND $check=='desativado')?$data_inicio:$data_fim);?>" min="<?=$data_inicio;?>">
                        </div>
                    </div>

                    <div class="col-md-4" style="<?echo ((isset($check) AND $check=='desativado')?'display: none;':'');?>" id="div_hora_remocao">
                        <div class="form-group">
                            <label class="pull-left">HORA DA REMOÇÃO</label>
                            <input name="hora_fim" type="time" required="required" class="form-control" id="hora_fim" value="<?=((isset($check) AND $check=='desativado')?$hora_inicio:$hora_fim);?>">
                        </div>
                    </div>

                    <div class="col-md-12"> </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label></label>
                            <input name="id" id="acao" value="<?=$id;?>" type="hidden">
                            <input name="acao" id="acao" value="gravar_editar" type="hidden">
                            <button type="submit" name="enviar" value="enviar" class="btn btn-success" style="float:right;"><i class="fa fa-check"></i> Atualizar </button>
                            <div class="btn-group btn-group-crop pull-right">
                                <a href="<?=$pagina_referencia;?>" title="Voltar" class="btn btn-primary" style="margin-right: 15px;">Voltar</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12"> </div>
                </div>
            </div>
        </div>
    </div>
</form>
<? } 

  if ($acao=="imagem") { //ANCHOR Imagem

	if (isset($_POST['upload_img'])) {

        $base64_img = $_POST['base64'];
        $selecionar = "SELECT img FROM $pagina_referencia WHERE id='$id'";
        $qery = mysqli_query($conexao, $selecionar);
        $dado = mysqli_fetch_assoc($qery);
        $img =  explode('.', $dado['img']);
    
        if ($base64_img == "") {
            echo "<script type='text/javascript'> alert('Corte a imagem antes de enviar!'); </script>";
        } else {
            $image = explode(',', $base64_img);		
            $upload_img = base64_decode($image[1]);        
            $img = $img[0].'-editado.jpg';		
            $caminho = "../assets/img/destaque/imagens/";
            $file_uploaded = file_put_contents($caminho.$img, $upload_img);		
            if (!$file_uploaded) {
                echo "<script type='text/javascript'> alert('Erro ao atualizar imagem!'); </script>";
            } else {
                comprimirImagem($caminho.$img, $caminho.$img, 70);
                $update_destaque = "UPDATE $pagina_referencia SET img = '$img' WHERE (id = '$id');" or die(mysqli_error());
                $update_query = mysqli_query($conexao, $update_destaque);
                if ($update_query) {
                    echo "<script type='text/javascript'> alert('Imagem atualizada com sucesso!'); </script>";
                }      
            }
        }	
    }
    
?>

<div class="row">
    <div class="col-md-12  header-wrapper">
        <h1 class="page-header">Atualizar foto</h1>
        <p class="page-subtitle">Para cadastrar um novo item, preencha os dados abaixo.</p>
    </div>
</div>

<!-- Content -->
<div class="container">
    <div class="alert alert-warning" role="alert">
        <strong>Tamanho de imagem minimo: 1200x400 pixels</strong>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="img-container">
                <img id="image" src="../assets/img/destaque/imagens/<?php $selecionar = "SELECT img FROM $pagina_referencia WHERE id='$id'"; 
                $qery = mysqli_query($conexao, $selecionar); 
                $img = mysqli_fetch_assoc($qery); 
                echo $img['img']; ?>" alt="Imagem Atual" title="Imagem Atual">
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-12 docs-buttons">

            <div class="docs-data" hidden>
                <div class="input-group input-group-sm">
                    <span class="input-group-prepend">
                        <label class="input-group-text" for="dataWidth">Largura</label>
                    </span>
                    <input type="text" class="form-control" id="dataWidth" placeholder="width" value="1200">
                    <span class="input-group-append">
                        <span class="input-group-text">px</span>
                    </span>
                </div>
                <div class="input-group input-group-sm">
                    <span class="input-group-prepend">
                        <label class="input-group-text" for="dataHeight">Altura</label>
                    </span>
                    <input type="text" class="form-control" id="dataHeight" placeholder="height" value="400">
                    <span class="input-group-append">
                        <span class="input-group-text">px</span>
                    </span>
                </div>
            </div>

            <!-- <h3>Toolbar:</h3> -->
            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="move" data-option="-10"
                    data-second-option="0" title="Move Left">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Mover à esquerda">
                        <span class="fa fa-arrow-left"></span>
                    </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="move" data-option="10" data-second-option="0"
                    title="Move Right">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Mover à direita">
                        <span class="fa fa-arrow-right"></span>
                    </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="move" data-option="0"
                    data-second-option="-10" title="Move Up">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Mover para cima">
                        <span class="fa fa-arrow-up"></span>
                    </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="10"
                    title="Move Down">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Mover para baixo">
                        <span class="fa fa-arrow-down"></span>
                    </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="rotate" data-option="-15"
                    title="Rotate Left">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Girar à esquerda">
                        <span class="fa fa-rotate-left"></span>
                    </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="rotate" data-option="15"
                    title="Rotate Right">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Girar à direita">
                        <span class="fa fa-rotate-right"></span>
                    </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="scaleX" data-option="-1"
                    title="Flip Horizontal">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Inverter horizontal">
                        <span class="fa fa-arrows-h"></span>
                    </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="scaleY" data-option="-1"
                    title="Flip Vertical">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Inverter vertical">
                        <span class="fa fa-arrows-v"></span>
                    </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="reset" title="Reset">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Resetar">
                        <span class="fa fa-compress"></span>
                    </span>
                </button>
                <label class="btn btn-primary btn-upload" for="inputImage" title="Upload image file">
                    <input type="file" class="sr-only" id="inputImage" name="file"
                        accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Importar imagem">
                        <i class="fa fa-image "></i>
                        <span style="margin-left: 5px;">Escolha o arquivo</span>
                    </span>
                </label>
            </div>

            <div class="btn-group btn-group-crop">
                <button type="button" class="btn btn-success" data-method="getCroppedCanvas"
                    data-option="{ &quot;width&quot;: 1184, &quot;height&quot;: 550 }">
                    <span class="docs-tooltip" data-toggle="tooltip" title="Enviar">
                        Enviar
                    </span>
                </button>
            </div>

            <div class="btn-group btn-group-crop pull-right">
                <a href="<?=$pagina_referencia;?>" title="Voltar" class="btn btn-primary">Voltar</a>
            </div>
            <!-- Show the cropped image in modal -->
            <div class="modal fade docs-cropped" id="getCroppedCanvasModal" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" role="dialog" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="getCroppedCanvasTitle">Deseja enviar?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer" style="padding-bottom: 0px;">
                            <form action="" method="post" style="padding: 0 !important;margim: 0 !important;margin-bottom: 0px;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <hr>
                                    </div>

                                    <br>

                                    <div class="col-md-12">
                                        <div class="form-group" style="margim: 0 !important;padding: 0 !important;margin-bottom: 0px;">
                                            <button type="submit" id="upload_img" name="upload_img" class="btn btn-primary">
                                                <i class="fas fa-file-upload"></i> Salvar </button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal" hidden>Fechar</button>
                                        </div>
                                    </div>

                                    <!-- IGNORA -->
                                    <input type="hidden" name="extensao" id="extensao">
                                    <input type="hidden" name="base64" id="base64">
                                    <a hidden class="btn btn-primary invisible" id="download" href="javascript:void(0);" download="cropped.jpg">Download</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- /.modal -->
            </div><!-- /.docs-buttons -->
        </div>
    </div>
</div>

<? } ?>

<?
if ($acao == "video") { //ANCHOR video
    if(isset($_POST['enviar'])) {
        $name= $_FILES['destaque']['name'];
        $tmp_name= $_FILES['destaque']['tmp_name'];
        $position= strpos($name, ".");
        $fileextension= substr($name, $position + 1);
        $fileextension= strtolower($fileextension);
        $link_destaque = $_POST['url'];
        
        $data_cadastro = trim(addslashes(htmlspecialchars($_POST['data_cadastro'])));
    	$hora_cadastro = trim(addslashes(htmlspecialchars($_POST['hora_cadastro'])));
    	$data_inteiro = $data_cadastro.' '.$hora_cadastro;
    	
    	if (isset($_POST['check']) AND $_POST['check']=='sim'){
            $data_fim = $_POST['data_fim'];
            $hora_fim = $_POST['hora_fim'];
            $data_final = $data_fim.' '.$hora_fim.':00';
            if ($data_final<$data_inteiro){
                $data_final = '0000-00-00 00:00:00';
            }
        }else{
            $data_final = '0000-00-00 00:00:00';
        }
        
        $titulo = $_POST['descricao'];
        $rand = rand(1,999999);

        $insert_banner = "INSERT INTO $pagina_referencia (img, titulo, url, data_inteiro, data_fim, flag, status) VALUES ('sem_imagem.webp', '$titulo', '$link_destaque', '$data_inteiro', '$data_final', 'v', 'a')" or die(mysqli_error());
        $insert_banner_query = mysqli_query($conexao, $insert_banner);
        $ultimo_id = mysqli_insert_id($conexao);

        $img = $sitenome.'-'.$ultimo_id.'-'.UrlAmigavel($titulo).'-'.$rand.'.'.$fileextension;

        if (isset($name)) {
            $path= '../assets/img/destaque/videos/';
            if (empty($name)) {
                echo "<script type='text/javascript'> alert('Escolha um arquivo!'); </script>";
            } else if (!empty($name)){                
                if (($fileextension !== "mp4") && ($fileextension !== "ogg") && ($fileextension !== "webm")) {
                    echo "<script type='text/javascript'> alert('Apenas .mp4, .ogg ou .webm'); </script>";
                } else if (($fileextension == "mp4") || ($fileextension == "ogg") || ($fileextension == "webm")) {
                    if (move_uploaded_file($tmp_name, $path.$img)) {
                        $update_banner = "UPDATE $pagina_referencia SET img='$img', data_fim='$data_final' WHERE (id = '$ultimo_id');" or die(mysqli_error());
                        $update_banner_query = mysqli_query($conexao, $update_banner);
                        // Caminho para o arquivo .mp4 original
                        $videoPath = $path.$img;
                        
                        // Caminho para o arquivo .mp4 reduzido
                        $reducedVideoPath = $videoPath;
                        
                        // Comando FFmpeg para redimensionar o vídeo
                        $ffmpegCommand = "ffmpeg -i $videoPath -vf scale=640:480 -c:v libx264 -crf 23 -c:a aac -b:a 128k $reducedVideoPath";
                        
                        // Executa o comando FFmpeg
                        exec($ffmpegCommand);
                        echo "<script type='text/javascript'> alert('Video enviado com sucesso!'); </script>";
                        echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";
                    }
                }
            }
        }
    }   
?>

<div class="row">
      <div class="col-md-12  header-wrapper" >
        <h1 class="page-header">Adicionar vídeo</h1>
        <p class="page-subtitle">Para cadastrar um novo item, preencha os dados abaixo.</p>
      </div>
</div>

<form method="post" action="" enctype="multipart/form-data">
      <div class="row">
        <div class="col-lg-12 ">
          <div class="panel panel-default ">
            <div class="panel-body">
                <br>
                <div class="col-md-12">
                    <div class="form-group">
                      <label >VIDEO DESTAQUE</label>
                      <input class="form-control" name="destaque" id="destaque" type="file" accept=".mp4">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <label >TÍTULO</label>
                      <input name="descricao" type="text" autofocus class="form-control" id="descricao" placeholder="" maxlength="255">
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label class="pull-left">LINK</label>
                        <input name="url" type="url" class="form-control" id="url" placeholder="<?=$psite;?>" value="<?=$psite;?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="pull-left">TIPO DE LINK</label>
                        <select class="form-control" name="tipo">
                            <option value="interno">Interno</option>
                            <option value="externo">Externo</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="pull-left">DATA DA POSTAGEM</label>
                        <input name="data_cadastro" type="date" required="required" autofocus class="form-control" id="data_cadastro" placeholder="" maxlength="255" value="<?=date('Y-m-d');?>" min="<?=date('Y-m-d');?>">
                    </div>
                </div>
    
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="pull-left">HORA DA POSTAGEM</label>
                        <input name="hora_cadastro" type="time" required="required" class="form-control" id="hora_cadastro" placeholder="" value="<?=date('H:i');?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="list-group">
                        <div class="list-group-item withswitch" style="text-align: -webkit-left;">
                            <h5 class="list-group-item-heading">PROGAMAR REMOÇÃO?</h5>
                            <div class="switch">
                                <input id="check" name="check" value="sim" class="cmn-toggle cmn-toggle-round" type="checkbox">
                                <label for="check"></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" style="display: none;" id="div_data_remocao">
                    <div class="form-group">
                        <label class="pull-left">DATA DA REMOÇÃO</label>
                        <input name="data_fim" type="date" required="required" autofocus class="form-control" id="data_fim" placeholder="" maxlength="255" value="<?=date('Y-m-d');?>" min="<?=date('Y-m-d');?>">
                    </div>
                </div>
    
                <div class="col-md-4" style="display: none;" id="div_hora_remocao">
                    <div class="form-group">
                        <label class="pull-left">HORA DA REMOÇÃO</label>
                        <input name="hora_fim" type="time" required="required" class="form-control" id="hora_fim" placeholder="" value="<?=date('H:i');?>">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label></label>
                        <input name="id_banner" id="acao" value="<?=$id;?>" type="hidden">
                        <input name="acao" id="acao" value="video" type="hidden">
                        <button type="submit" name="enviar" value="enviar" class="btn btn-success" style="float:right;"><i class="fa fa-check"></i> Adicionar </button>
                        <div class="btn-group btn-group-crop pull-right">
                            <a href="<?=$pagina_referencia;?>" title="Voltar" class="btn btn-primary" style="margin-right: 15px;">Voltar</a>
                        </div>
                    </div>
                </div>
              
            </div>
          </div>
        </div>
      </div>

    </form>

<?}?>

<? 
if (isset($_POST['recuperar'])) {
    $id = (int)$_POST['id'];

    $update = "UPDATE $pagina_referencia SET status='a' WHERE id='".$id."' " or die(mysqli_error()); 
    if (!mysqli_query($conexao, $update)) {  
		die('Error: '.mysqli_error($conexao)); 
	} else {
		$_SESSION['alerta_mensagem'] = "Recuperado com sucesso!";
        $_SESSION['alerta_tipo'] = "green";
        echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";
    }
}	
?>

<?
if ($acao=="lixeira") { //ANCHOR Lixeira ?>
  
<div class="row">
    <div class="col-md-12  header-wrapper">
        <h1 class="page-header">Lixeira</h1>
        <p class="page-subtitle">Listagens dos itens excluídos no sistema.</p>
        <div class="pull-right">
            <a href="<?=$pagina_referencia;?>-cadastrar" title="Adicionar Foto" class="btn btn-primary">+ FOTO</a>
            <a href="<?=$pagina_referencia;?>-video" title="Adicionar Video" class="btn btn-primary">+ VIDEO</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-hover" id="dataTables-userlist">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>DESTAQUE</th>
                    <th>TÍTULO</th>
                    <th>DATA</th>
                    <th style="width: 250px;">AÇÕES</th>
                </tr>
            </thead>
            <tbody>
                <?
            	$sql = "SELECT * FROM $pagina_referencia WHERE status!='a' ORDER BY id DESC";
            	$query = mysqli_query($conexao, $sql);
            	  
            	$condicao = mysqli_num_rows($query);
            	$classe="even ";
            		
            	while ($dados = mysqli_fetch_assoc($query)) {
            	    $id = $dados['id'];
            		$img = $dados['img'];
            		$titulo  = $dados['titulo'];
                    $url  = $dados['url'];
                    $flag  = $dados['flag'];
                    $status  = $dados['status'];
                    $data_inteiro = $dados['data_inteiro'];
                    $data = date('d/m/Y - H:i', strtotime($data_inteiro));
                    $data_inteiro = $dados['data_inteiro'];
                    $data_fim = $dados['data_fim'];
                    $data_remocao = date('d/m/Y - H:i', strtotime($data_fim));

            		if(file_exists("../assets/img/destaque/imagens/$img")){
                        $imagem = '../assets/img/destaque/imagens/'.$img;
                    } elseif (file_exists("../assets/img/destaque/videos/$img")) {   
                        $imagem = '../assets/img/destaque/videos/'.$img;
                    } else{ 
                        $imagem = '../assets/img/destaque/imagens/sem_imagem.webp';
                    }
                    
            		if ($classe=="odd") { $classe="even "; } else {$classe="odd"; }
                ?>
                <tr class="<?=$classe;?>">
                    <td style="text-align: right"><b><?=$id;?></b></td>
                    <td class="center">
                        <?if ($flag=='i'){?>
                            <img src="<?=$imagem;?>" alt="<?=$titulo;?>" title="<?=$titulo;?>" style="max-width: 250px; max-height: 83px;">
                        <?}else{?>
                            <video width="250" height="141" autoplay controls loop muted> <source src="<?=$imagem;?>" type="video/mp4"> Seu navegador não suporta video. </video>
                        <?}?>
                    </td>
                    <td>
                        <a href="<?=$url;?>" target="_blank" title="<?=$titulo;?>" style="color: black;">
                            <h3 style="margin:-4px;"><?=$titulo;?></h3>
                            <p><?=$url;?></p>
                        </a>
                        <span class="status inactive">DESATIVADO</span>
                    </td>
                    <td>
                        <b>POSTAGEM:</b> <?=$data;?><br>
                        <?if ($data_fim>$data_inteiro){?>
                            <b>REMOÇÃO:</b> <?=$data_remocao;?>
                        <?}?>
                    </td>
                    <td>
                        <div class="socials tex-center">
                            <a href="#" class="btn btn-circle btn-warning " data-toggle="modal" data-target="#recuperar_<?=$id;?>"><i class="fa fa-undo"></i></a>
                            <div class="modal fade" id="recuperar_<?=$id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel3">RECUPERAR ITEM</h4>
                                        </div>
                                        <div class="modal-body">
                                            Confirma a recuperação deste item?
                                        </div>
                                        <div class="modal-footer">
                                            <form method="POST" action="" style="display: contents;">
                                                <input type="hidden" name="id" value="<?=$id;?>">
                                                <button type="submit" name="recuperar" class="btn btn-danger" role="button" aria-pressed="true" style="margin-right: 5px;">SIM</button>
                                            </form>
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">NÃO</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <a href="#" class="btn btn-circle btn-danger " data-toggle="modal" data-target="#deletar_<?=$id;?>"><i class="fa fa-close"></i></a>
                            <div class="modal fade" id="deletar_<?=$id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel3">REMOVER ITEM PERMANENTEMENTE</h4>
                                        </div>
                                        <div class="modal-body">Confirma a exclusão permanentemente deste item? </div>
                                        <div class="modal-footer">
                                            <form method="POST" action="" style="display: contents;">
                                                <input type="hidden" name="id" value="<?=$id;?>">
                                                <input type="hidden" name="arquivo" value="<?=$imagem;?>">
                                                <button type="submit" name="delete" class="btn btn-danger" role="button" aria-pressed="true" style="margin-right: 5px;">SIM</button>
                                            </form>
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">NÃO</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                        </div>
                    </td>
                </tr>
                <?}mysqli_free_result($query);?>
            </tbody>
        </table>
    </div>
</div>
<!-- /.row -->

<? } ?>

<? if ($acao=="") { //ANCHOR Listar?>

<div class="row">
    <div class="col-md-12  header-wrapper">
        <h1 class="page-header">Destaques</h1>
        <p class="page-subtitle">Listagens dos itens cadastrados no sistema.</p>
        <div class="pull-right">
            <a href="<?=$pagina_referencia;?>-cadastrar" title="Adicionar Foto" class="btn btn-primary">+ FOTO</a>
            <a href="<?=$pagina_referencia;?>-video" title="Adicionar Video" class="btn btn-primary">+ VIDEO</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-hover" id="dataTables-userlist">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>DESTAQUE</th>
                    <th>TÍTULO</th>
                    <th>DATA</th>
                    <th style="width: 250px;">AÇÕES</th>
                </tr>
            </thead>
            <tbody>
                <?
            	$sql = "SELECT * FROM $pagina_referencia WHERE status='a' ORDER BY id DESC";
            	$query = mysqli_query($conexao, $sql);
            	  
            	$condicao = mysqli_num_rows($query);
            	$classe="even ";
            		
            	while ($dados = mysqli_fetch_assoc($query)) {
            	    $id = $dados['id'];
            		$img = $dados['img'];
            		$titulo  = $dados['titulo'];
                    $url  = $dados['url'];
                    $status  = $dados['status'];
                    $data_inteiro = $dados['data_inteiro'];
                    $data = date('d/m/Y - H:i', strtotime($data_inteiro));
                    $data_inteiro = $dados['data_inteiro'];
                    $data_fim = $dados['data_fim'];
                    $data_remocao = date('d/m/Y - H:i', strtotime($data_fim));

            		if ($classe=="odd") { $classe="even "; } else {$classe="odd"; }
                ?>
                <tr class="<?=$classe;?>">
                    <td style="text-align: right"><b><?=$id;?></b></td>
                    <td class="center">
                    <?
                    if(file_exists("../assets/img/destaque/imagens/$img")){
                       echo '<img src="../assets/img/destaque/imagens/'.$img.'" alt="'.$titulo.'" title="'.$titulo.'" style="max-width: 250px; max-height: 83px;">';
                    } elseif (file_exists("../assets/img/destaque/videos/$img")) {   
                       echo '<video width="250" height="141" autoplay controls loop muted> <source src="../assets/img/destaque/videos/'.$img.'" type="video/mp4"> Seu navegador não suporta video. </video>';
                    } else{ 
                       echo '<img src="../assets/img/destaque/imagens/sem_imagem.webp" alt="'.$titulo.'" title="'.$titulo.'" style="max-width: 250px; max-height: 83px;">';
                    }
                    ?>
                    </td>
                    <td>
                        <a href="<?=$url;?>" target="_blank" title="<?=$titulo;?>" style="color: black;">
                            <h3 style="margin:-4px;"><?=$titulo;?></h3>
                            <p><?=$url;?></p>
                        </a>
                        <?if (($data_inteiro<=date('Y-m-d H:i:s') AND $data_fim>=date('Y-m-d H:i:s')) || $data_fim<=$data_inteiro) {
                            echo '<span class="status active">ATIVO</span>';
                        }else{
                            echo '<span class="status inactive">EXPIRADO</span>';
                        }
                        ?>
                    </td>
                    <td>
                        <b>POSTAGEM:</b> <?=$data;?><br>
                        <?if ($data_fim>$data_inteiro){?>
                            <b>REMOÇÃO:</b> <?=$data_remocao;?>
                        <?}?>
                    </td>
                    <td>
                        <div class="socials tex-center">
                            <a href="<?=$pagina_referencia;?>-editar_<?=$id;?>" class="btn btn-circle btn-primary "><i class="fa fa-pencil"></i></a>
                            <a href="#" class="btn btn-circle btn-danger" data-toggle="modal" data-target="#myModal<?=$id;?>"><i class="fa fa-close"></i></a>
                            <div class="modal fade" id="myModal<?=$id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel3">REMOVER ITEM</h4>
                                        </div>
                                        <div class="modal-body">Confirma a exclusão deste item? </div>
                                        <div class="modal-footer">
                                            <a href="<?=$pagina_referencia;?>-excluir_<?=$id;?>" class="btn btn-danger" role="button" aria-pressed="true">SIM</a>
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">NÃO</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                        </div>
                    </td>
                </tr>
                <?}mysqli_free_result($query);?>
            </tbody>
        </table>
    </div>
</div>
<!-- /.row -->
<? } ?>

<!-- Bootstrap Core JavaScript -->
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/cropper/js/cropper.js"></script>

<?php
if (($pag == 'destaque' && $acao == 'cadastrar') || ($pag == 'destaque' && $acao == 'imagem')){
    echo "<script src='vendor/cropper/js/main_destaque.js'></script>";
}

?>

<!-- DataTables JavaScript -->
<script src="vendor/datatables/js/jquery.dataTables.min.js"></script> 
<script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script> 
<script src="vendor/datatables-responsive/dataTables.responsive.js"></script> 

<!-- Custom Theme JavaScript -->
<script src="js/adminnine.js"></script>
<script>
$("#data_cadastro").on("change", function() {
    $("#data_fim").prop('value', $(this).prop('value'));
    $("#data_fim").attr('min', $(this).prop('value'));
    $("#hora_fim").prop('value', $("#hora_cadastro").prop('value'));
    $("#hora_fim").attr('min', $("#hora_cadastro").prop('value'));
});
$("#hora_cadastro").on("change", function() {
    $("#hora_fim").prop('value', $(this).prop('value'));
    $("#hora_fim").attr('min', $(this).prop('value'));
    $("#data_fim").prop('value', $('#data_remocao').prop('value'));
    $("#data_fim").attr('min', $('#data_remocao').prop('value'));
});
$("#check").on("change", function() {
    if ($(this).is(':checked')) {
        $('#div_data_remocao').show();
        $('#div_hora_remocao').show();
    }else{
        $('#div_data_remocao').hide();
        $('#div_hora_remocao').hide();
    }
});
$(document).ready(function () {
    $('#dataTables-userlist').DataTable({
        responsive: true,
        pageLength: 10,
        sPaginationType: "full_numbers",
        oLanguage: {
            oPaginate: {
                sFirst: "<<",
                sPrevious: "<",
                sNext: ">",
                sLast: ">>"
            }
        }
    });
});
</script>