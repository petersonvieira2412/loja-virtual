<?php
function imagens_internas($parametros, $id_destino=0) {
    if ($id_destino=='imagens_internas_produto'){
        $id = $parametros[0];
        $img_secundaria = ((isset($parametros[1]) AND $parametros[1]!='')?$parametros[1]:'');
        $pasta = '../../../assets/img/produtos/'.$id.'/';
        $arquivos = glob("$pasta{*.jpg,*.png,*.gif,*.bmp,*.webp}", GLOB_BRACE);
        $conta = count($arquivos);
        $return = '';
        foreach($arquivos as $img){
            $aleatorio = rand(1,999999);
            
            $id_imagem = explode('-', $img);
            $id_imagem = end($id_imagem);
            $id_imagem = explode('.', $id_imagem);
            $id_imagem = $id_imagem[0];
            $click = "ExcluirImagem('excluir_imagem', '".str_replace('../../../', '../', $img)."', '$id')";
            
            $flag_img = end(explode('/', $img));
            if ($flag_img!=$img_secundaria){
            
            $return .= '<div class="col-lg-3 col-md-4 col-sm-6" id="'.$id_imagem.'">
                            <div class="panel panel-default userlist">
                                <div class="panel-body text-center">
                                    <div class="grid-item">
                                        <a href="'.$img.'" rel="gallery-1" class="swipebox">
                                            <img src="'.$img.'" class="productpic">
                                        </a>
                                    </div>
                                </div>
                                <div class="panel-footer"> <a href="#" data-toggle="modal" data-target="#myModal'.$aleatorio.'"> <button type="button" class="btn btn-danger" style="float: right;height: 24px; width: 24px; display: flex; justify-content: center; align-items: center; margin-bottom: 10px;"><i class="fa fa-trash"></i></button> </a> </div>
                            </div>
                            <div class="modal fade" id="myModal'.$aleatorio.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel3">REMOVER ITEM</h4>
                                    </div>
                                    <div class="modal-body">Confirma a exclusão deste item? Após a confirmação o mesmo não poderá ser desfeito. </div>
                                    <div class="modal-footer">
                                        <button type="button" onclick="'.$click.'" class="btn btn-danger" data-dismiss="modal" role="button"><i class="fa fa-trash"></i> Sim, desejo excluir</button>
                                        <button type="button" class="btn btn-light" data-dismiss="modal">NÃO</button>
                                    </div>
                                </div>
                              </div>
                            </div>
                        </div>';
            }
        }
        if ($conta<=0) {
            $return .= '<h3 style="color:#ccc;">Nenhuma imagem cadastrada no momento.</h3>';
        }
        return $return;
    }else{
        $id = $parametros[0];
        $contador = $parametros[1];
        $pasta = '../../../assets/img/produtos/'.$id.'/';
        $arquivos = glob("$pasta{*.jpg,*.png,*.gif,*.bmp,*.webp}", GLOB_BRACE);
        $conta = count($arquivos);
        $return = '';
        foreach($arquivos as $img){
            $aleatorio = rand(1,999999);
            
            $id_imagem = explode('-', $img);
            $id_imagem = end($id_imagem);
            $id_imagem = explode('.', $id_imagem);
            $id_imagem = $id_imagem[0];
            $click = "$('#img_ancora_escolhida_".$contador."').attr('src', this.src);$('#escolhida_imagem_ancora_".$contador."').show();$('#img_ancora_".$contador."').prop('value', this.src);$('#icone_imagem_ancora_".$contador."').hide();";
            
            $return .= '<div class="col-lg-3 col-md-3 col-sm-6" id="'.$id_imagem.'">
                <div class="panel panel-default userlist">
                    <div class="panel-body text-center">
                        <div class="grid-item">
                            <img src="'.$img.'" class="productpic" style="max-width: max-content;cursor:pointer;" data-dismiss="modal" onclick="'.$click.'">
                        </div>
                    </div>
                </div>
            </div>';
        }
        if ($conta<=0) {
            $return .= '<h3 style="color:#ccc;">Nenhuma imagem cadastrada no momento.</h3>';
        }
        return $return;
    }
}
function imagens_cores($parametros=false, $id_destino=0) {
    $pasta = '../../../assets/img/produtos/cores/';
    $contador = $parametros[0];
    $arquivos = glob("$pasta{*.jpg,*.png,*.gif,*.bmp,*.webp}", GLOB_BRACE);
    $conta = count($arquivos);
    $return = '';
    foreach($arquivos as $img){
        $aleatorio = rand(1,999999);
        
        $id_imagem = explode('-', $img);
        $id_imagem = end($id_imagem);
        $id_imagem = explode('.', $id_imagem);
        $id_imagem = $id_imagem[0];
        $click = "$('#img_rgb_".$contador."').css('background', 'url('+this.src+')').css('background-size', '100% 100%').css('background-repeat', 'no-repeat');$('#img_cor_".$contador."').prop('value', this.src);";
        
        $return .= '<div class="col-lg-2 col-md-2 col-sm-6" id="'.$id_imagem.'">
                        <div class="panel panel-default userlist">
                            <div class="panel-body text-center">
                                <div class="grid-item">
                                    <img src="'.$img.'" class="productpic" style="max-width: max-content;cursor:pointer;" data-dismiss="modal" onclick="'.$click.'">
                                </div>
                            </div>
                        </div>
                    </div>';
    }
    if ($conta<=0) {
        $return .= '<h3 style="color:#ccc;">Nenhuma imagem cadastrada no momento.</h3>';
    }
    return $return;
}
function envia_imagens_cores($parametros=false, $id_destino=0) {
    $contador = $parametros[0];
    $imagem = $parametros[1];
    $produto = $parametros[2];

    $aleatorio = rand(1,999999);
    $nome = "cor-".$produto."-".$aleatorio;
    $caminho = "../../../assets/img/produtos/cores";
    
	$imagem_array_1 = explode(";", $imagem);
	$imagem_array_2 = explode(",", $imagem_array_1[1]);
	$imagem = base64_decode($imagem_array_2[1]);
	$imagem_nome = $caminho.'/'.$nome.'.png';
	$nova_imagem = $nome.'.webp';
	$nova_imagem_email = $nome.'.jpg';

	file_put_contents($imagem_nome, $imagem);
	
	$img = imagecreatefrompng($imagem_nome);
    imagepalettetotruecolor($img);
    imagealphablending($img, true);
    imagesavealpha($img, true);
    $img_produto = imagewebp($img, $caminho.'/'.$nova_imagem, 80);
    unlink($imagem_nome);

    $caminho .= '/';
    $arquivos = glob("$caminho{*.jpg,*.png,*.gif,*.bmp,*.webp}", GLOB_BRACE);
    $conta = count($arquivos);
    $return = '';
    foreach($arquivos as $img){
        $aleatorio = rand(1,999999);
        
        $id_imagem = explode('-', $img);
        $id_imagem = end($id_imagem);
        $id_imagem = explode('.', $id_imagem);
        $id_imagem = $id_imagem[0];
        $click = "$('#img_rgb_".$contador."').css('background', 'url('+this.src+')').css('background-size', '100% 100%').css('background-repeat', 'no-repeat');$('#img_cor_".$contador."').prop('value', this.src);";
        
        $return .= '<div class="col-lg-2 col-md-2 col-sm-6" id="'.$id_imagem.'">
                        <div class="panel panel-default userlist">
                            <div class="panel-body text-center">
                                <div class="grid-item">
                                    <img src="'.$img.'" class="productpic" style="max-width: max-content;cursor:pointer;" data-dismiss="modal" onclick="'.$click.'">
                                </div>
                            </div>
                        </div>
                    </div>';
    }
    if ($conta<=0) {
        $return .= '<h3 style="color:#ccc;">Nenhuma imagem cadastrada no momento.</h3>';
    }
    return $return;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['acao']) AND $_POST['acao']!=''){
        $acao = $_POST['acao'];
        $parametro = $_POST['parametro'];
        $id = $_POST['id'];
        echo $acao($parametro, $id);
    }
}
exit;
?>