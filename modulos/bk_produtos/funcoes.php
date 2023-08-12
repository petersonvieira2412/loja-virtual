<?php
function imagens_internas($parametros) {
    $id = $parametros[0];
    $contador = $parametros[1];
    $click = "$('#img_ancora_escolhida_".$contador."').attr('src', this.src);$('#escolhida_imagem_ancora_".$contador."').show();$('#img_ancora_".$contador."').prop('value', this.src);$('#icone_imagem_ancora_".$contador."').hide();";
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['acao']) AND $_POST['acao']!=''){
        $acao = $_POST['acao'];
        $parametro = $_POST['parametro'];
        echo $acao($parametro);
    }
}
exit;
?>