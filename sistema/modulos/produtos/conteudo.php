<?php
ob_start();
  include_once "config.php";
  $pagina_titulo = "produtos";
  $pagina_referencia = "produtos";
  setlocale(LC_ALL, 'en_US.UTF8');

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
        if ($info['mime'] == 'image/jpeg' OR $info['mime'] == 'image/jpg') {
            $image = imagecreatefromjpeg($diretorio);
            imagejpeg($image, $diretorio_final, $qualidade);
        } elseif ($info['mime'] == 'image/gif') {
            $image = imagecreatefrompng($diretorio);
            imagegif($image, $diretorio_final, $qualidade);
        } elseif ($info['mime'] == 'image/png') {
            $image = imagecreatefrompng($diretorio);
            imagepng($image, $diretorio_final, $qualidade);
        }
        return $diretorio_final;
    }
    
    function enviaXml($data) {

        $post = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $_SERVER['HTTP_HOST']."/sistema/modulos/produtos/updateXml.php");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
    
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            return false;
        } else {
            return true;
        }

    }

if ($acao=="gravar") {
    ((isset($_POST['categoria']) AND $_POST['categoria']!='')?$categoria = (int)$_POST['categoria']:$categoria='');
    ((isset($_POST['produto']) AND $_POST['produto']!='')?$produto = addslashes(htmlspecialchars($_POST['produto'])):$produto='');
    ((isset($_POST['url_amigavel']) AND $_POST['url_amigavel']!='')?$url_amigavel = trim(addslashes(htmlspecialchars($_POST['url_amigavel']))):$url_amigavel='');
    ((isset($_POST['descricao']) AND $_POST['descricao']!='')?$descricao = base64_encode($_POST['descricao']):$descricao='');
    ((isset($_POST['qtd']) AND $_POST['qtd']!='')?$qtd = trim(addslashes(htmlspecialchars($_POST['qtd']))):$qtd='');
    ((isset($_POST['qtd_minimo']) AND $_POST['qtd_minimo']!='')?$qtd_minimo = trim(addslashes(htmlspecialchars($_POST['qtd_minimo']))):$qtd_minimo='');
    ((isset($_POST['qtd_vendido']) AND $_POST['qtd_vendido']!='')?$qtd_vendido = trim(addslashes(htmlspecialchars($_POST['qtd_vendido']))):$qtd_vendido='');
    ((isset($_POST['qtd_visto']) AND $_POST['qtd_visto']!='')?$qtd_visto = trim(addslashes(htmlspecialchars($_POST['qtd_visto']))):$qtd_visto='');
    ((isset($_POST['preco']) AND $_POST['preco']!='')?$preco = trim(addslashes(htmlspecialchars($_POST['preco']))):$preco='');
    ((isset($_POST['por']) AND $_POST['por']!='')?$por = trim(addslashes(htmlspecialchars($_POST['por']))):$por='');
    ((isset($_POST['qtd_parcela']) AND $_POST['qtd_parcela']!='')?$qtd_parcela = trim(addslashes(htmlspecialchars($_POST['qtd_parcela']))):$qtd_parcela='');
    ((isset($_POST['valor_parcela']) AND $_POST['valor_parcela']!='')?$valor_parcela = trim(addslashes(htmlspecialchars(str_replace(',', '.', $_POST['valor_parcela'])))):$valor_parcela='');
    ((isset($_POST['valor_parcela_juros']) AND $_POST['valor_parcela_juros']!='')?$valor_parcela_juros = trim(addslashes(htmlspecialchars(str_replace(',', '.', $_POST['valor_parcela_juros'])))):$valor_parcela_juros='');
    ((isset($_POST['forma']) AND $_POST['forma']!='')?$forma = trim(addslashes(htmlspecialchars($_POST['forma']))):$forma='');
    ((isset($_POST['prazo']) AND $_POST['prazo']!='')?$prazo = trim(addslashes(htmlspecialchars($_POST['prazo']))):$prazo='');
    ((isset($_POST['regiao']) AND $_POST['regiao']!='')?$regiao = trim(addslashes(htmlspecialchars($_POST['regiao']))):$regiao='');
    ((isset($_POST['promocao']) AND $_POST['promocao']!='')?$promocao = trim(addslashes(htmlspecialchars($_POST['promocao']))):$promocao='');
    ((isset($_POST['frete']) AND $_POST['frete']!='')?$frete = trim(addslashes(htmlspecialchars($_POST['frete']))):$frete='');
    ((isset($_POST['pronta']) AND $_POST['pronta']!='')?$pronta = trim(addslashes(htmlspecialchars($_POST['pronta']))):$pronta='');
    ((isset($_POST['faturamento']) AND $_POST['faturamento']!='')?$faturamento = trim(addslashes(htmlspecialchars($_POST['faturamento']))):$faturamento='');
    ((isset($_POST['destaquee']) AND $_POST['destaquee']!='')?$destaquee = trim(addslashes(htmlspecialchars($_POST['destaquee']))):$destaquee='');
    ((isset($_POST['ordem']) AND $_POST['ordem']!='')?$ordem = (int)$_POST['ordem']:$ordem='');
    ((isset($_POST['ordemdestaque']) AND $_POST['ordemdestaque']!='')?$ordemdestaque = (int)$_POST['ordemdestaque']:$ordemdestaque='');
    ((isset($_POST['sku']) AND $_POST['sku']!='')?$sku = trim(addslashes(htmlspecialchars($_POST['sku']))):$sku='');
    ((isset($_POST['sistema']) AND $_POST['sistema']!='')?$sistema = trim(addslashes(htmlspecialchars($_POST['sistema']))):$sistema='');
    ((isset($_POST['ean']) AND $_POST['ean']!='')?$ean = trim(addslashes(htmlspecialchars($_POST['ean']))):$ean='');
    ((isset($_POST['ncm']) AND $_POST['ncm']!='')?$ncm = trim(addslashes(htmlspecialchars($_POST['ncm']))):$ncm='');
    ((isset($_POST['fabricante']) AND $_POST['fabricante']!='')?$fabricante = (int)$_POST['fabricante']:$fabricante='');
    ((isset($_POST['status']) AND $_POST['status']!='')?$status = strtolower(trim(addslashes(htmlspecialchars($_POST['status'])))):$status='');
    ((isset($_POST['titulo_seo']) AND $_POST['titulo_seo']!='')?$titulo_seo = strtolower(trim(addslashes(htmlspecialchars($_POST['titulo_seo'])))):$titulo_seo='');
    ((isset($_POST['desc_seo']) AND $_POST['desc_seo']!='')?$descricao_seo = strtolower(trim(addslashes(htmlspecialchars($_POST['desc_seo'])))):$descricao_seo='');
    ((isset($_POST['palavras_seo']) AND $_POST['palavras_seo']!='')?$palavras_seo = strtolower(trim(addslashes(htmlspecialchars($_POST['palavras_seo'])))):$palavras_seo='');
    ((isset($_POST['informacoes_adicionais']) AND $_POST['informacoes_adicionais']!='')?$informacoes_adicionais = base64_encode($_POST['informacoes_adicionais']):$informacoes_adicionais='');
    ((isset($_POST['link_youtube']) AND $_POST['link_youtube']!='')?$link_youtube = strtolower(trim(addslashes(htmlspecialchars($_POST['link_youtube'])))):$link_youtube='');
    ((isset($_POST['link_compra']) AND $_POST['link_compra']!='')?$link_compra = strtolower(trim(addslashes(htmlspecialchars($_POST['link_compra'])))):$link_compra='');
    ((isset($_POST['peso']) AND $_POST['peso']!='')?$peso = $_POST['peso']:$peso='');
    ((isset($_POST['altura']) AND $_POST['altura']!='')?$altura = $_POST['altura']:$altura='');
    ((isset($_POST['largura']) AND $_POST['largura']!='')?$largura = $_POST['largura']:$largura='');
    ((isset($_POST['comprimento']) AND $_POST['comprimento']!='')?$comprimento = $_POST['comprimento']:$comprimento='');
    ((isset($_POST['google-shopping']) AND $_POST['google-shopping']!='')?$google_shopping = json_decode($_POST['google-shopping'], true):$google_shopping='');
    ((isset($_POST['catalogo-facebook']) AND $_POST['catalogo-facebook']!='')?$catalogo_facebook = json_decode($_POST['catalogo-facebook'], true):$catalogo_facebook='');
    ((isset($_POST['lojinha-instagram']) AND $_POST['lojinha-instagram']!='')?$lojinha_instagram = json_decode($_POST['lojinha-instagram'], true):$lojinha_instagram='');
    
    $ip = $_SERVER['REMOTE_ADDR'];
    $endereco_ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);

    if (isset($_POST['check_frete']) AND $_POST['check_frete']=='sim'){
        $insere = "INSERT INTO $pagina_referencia (sku, sistema, ean, ncm, img, categoria, produto, url_amigavel, descricao, informacoes_adicionais, link_youtube, link_compra, ordem, qtd, qtd_minimo, qtd_vendido, qtd_visto, preco, por, qtd_parcela, valor_parcela,valor_parcela_juros, forma, prazo, regiao, promocao, peso, altura, largura, comprimento, pronta, faturamento, destaque, destaque_ordem, fabricante, ip, endereco_ip, data_cadastro, hora_cadastro, data_editar, hora_editar, status, Titulo_seo, Descricao_seo, palavrasChave_seo) VALUES ('$sku', '$sistema', '$ean', '$ncm', 'sem_imagem.jpg', '$categoria', '$produto', '$url_amigavel', '$descricao', '$informacoes_adicionais', '$link_youtube', '$link_compra', '$ordem', '$qtd', '$qtd_minimo', '$qtd_vendido', '$qtd_visto', '$preco', '$por','$qtd_parcela','$valor_parcela', '$valor_parcela_juros','$forma', '$prazo', '$regiao', '$promocao', '$peso', '$altura', '$largura', '$comprimento', '$pronta', '$faturamento', '$destaquee', '$ordemdestaque', '$fabricante', '$ip', '$endereco_ip', '".date('Y-m-d')."', '".date('H:i:s')."','".date('Y-m-d')."', '".date('H:i:s')."', 'a', '$titulo_seo', '$descricao_seo', '$palavras_seo')" or die(mysqli_error());    
    }else{
        $insere = "INSERT INTO $pagina_referencia (sku, sistema, ean, ncm, img, categoria, produto, url_amigavel, descricao, informacoes_adicionais, link_youtube, link_compra, ordem, qtd, qtd_minimo, qtd_vendido, qtd_visto, preco, por, qtd_parcela, valor_parcela,valor_parcela_juros, forma, prazo, regiao, promocao, pronta, faturamento, destaque, destaque_ordem, fabricante, ip, endereco_ip, data_cadastro, hora_cadastro, data_editar, hora_editar, status, Titulo_seo, Descricao_seo, palavrasChave_seo) VALUES ('$sku', '$sistema', '$ean', '$ncm', 'sem_imagem.jpg', '$categoria', '$produto', '$url_amigavel', '$descricao', '$informacoes_adicionais', '$link_youtube', '$link_compra', '$ordem', '$qtd', '$qtd_minimo', '$qtd_vendido', '$qtd_visto', '$preco', '$por','$qtd_parcela','$valor_parcela', '$valor_parcela_juros','$forma', '$prazo', '$regiao', '$promocao', '$pronta', '$faturamento', '$destaquee', '$ordemdestaque', '$fabricante', '$ip', '$endereco_ip', '".date('Y-m-d')."', '".date('H:i:s')."','".date('Y-m-d')."', '".date('H:i:s')."', 'a', '$titulo_seo', '$descricao_seo', '$palavras_seo')" or die(mysqli_error());    
        $peso = $_POST['peso'];
        $altura = $_POST['altura'];
        $largura = $_POST['largura'];
        $comprimento = $_POST['comprimento'];
    }
    if (!mysqli_query($conexao, $insere)) {  
      die('Erro: '.mysqli_error($conexao)); 
    } else {
        $ultimo_id = mysqli_insert_id($conexao);
        
        $query = $conexao->query("SELECT url_amigavel FROM produtos WHERE url_amigavel='$url_amigavel' AND status='a'");
        $num_rows = $query->num_rows;
        if ($num_rows>1){
            $url_final = $url_amigavel.'-'.$ultimo_id;
            $update = mysqli_query($conexao, "UPDATE produtos SET url_amigavel='$url_final' WHERE id='$ultimo_id'");
        }

        $contador_variacao = $_POST['contador_variacao'];
        $check_cor = $_POST['check_cor'];
        $check_tamanho = $_POST['check_tamanho'];

        if ($contador_variacao AND $check_cor AND $check_tamanho){
            for ($i = 0; $i <$contador_variacao; $i++){
                if (isset($_POST['check_frete']) AND $_POST['check_frete']=='sim'){
                    $insert = mysqli_query($conexao, "INSERT INTO estoque (cor, tamanho, produto, qtd, operacao, tipo, valor, data_cadastro, hora_cadastro, data_editar, hora_editar, ip, endereco_ip, status) VALUES ('".$_POST['cor'][$i]."', '".$_POST['tamanho'][$i]."', '$ultimo_id',  '".$_POST['qtd_variacao'][$i]."', '".$_POST['operacao'][$i]."', '".$_POST['tipo'][$i]."', '".$_POST['valor'][$i]."', '".date('Y-m-d')."', '".date('H:i:s')."', '".date('Y-m-d')."', '".date('H:i:s')."', '$ip', '$endereco_ip', 'a')");
                }else{
                    $insert = mysqli_query($conexao, "INSERT INTO estoque (cor, tamanho, produto, qtd, operacao, tipo, valor, peso, altura, largura, comprimento, data_cadastro, hora_cadastro, data_editar, hora_editar, ip, endereco_ip, status) VALUES ('".$_POST['cor'][$i]."', '".$_POST['tamanho'][$i]."', '$ultimo_id',  '".$_POST['qtd_variacao'][$i]."', '".$_POST['operacao'][$i]."', '".$_POST['tipo'][$i]."', '".$_POST['valor'][$i]."', '".$peso[$i]."', '".$altura[$i]."', '".$largura[$i]."', '".$comprimento[$i]."', '".date('Y-m-d')."', '".date('H:i:s')."', '".date('Y-m-d')."', '".date('H:i:s')."', '$ip', '$endereco_ip', 'a')");
                }
            }
        }

        if (isset($_POST['img_destaque']) AND $_POST['img_destaque']!=''){
            $nome = clean($produto);
            if ($nome=="") { $nome=$purl_amigavel; }
            $aleatorio = rand(1,999999);
            $nome = "produto-".$ultimo_id."-".$nome."-".$aleatorio;
            $caminho = "../assets/img/".$pagina_referencia;
            
            $imagem = $_POST['img_destaque'];
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
            $img_email = imagejpeg($img, $caminho.'/'.$nova_imagem_email, 80);
            $img_produto = imagewebp($img, $caminho.'/'.$nova_imagem, 80);
            unlink($imagem_nome);
            
            $update = "UPDATE $pagina_referencia SET img='$nova_imagem', img_email='$nova_imagem_email' WHERE id='".$ultimo_id."' "  or die(mysqli_error());
            if (!mysqli_query($conexao, $update)) { die('Erro: '.mysqli_error($conexao)); }
            
        }
        
        if (isset($_POST['img_secundaria']) AND $_POST['img_secundaria']!=''){
            $nome = clean($produto);
            if ($nome=="") { $nome=$purl_amigavel; }
            $aleatorio = rand(1,999999);
            $nome = "produto-".$ultimo_id."-".$nome."-secundaria-".$aleatorio;
            $caminho = "../assets/img/".$pagina_referencia."/".$ultimo_id;
            
            if (!is_dir($caminho)) {
                mkdir($caminho, 0777, true);
            }
            
            $imagem = $_POST['img_secundaria'];
        	$imagem_array_1 = explode(";", $imagem);
        	$imagem_array_2 = explode(",", $imagem_array_1[1]);
        	$imagem = base64_decode($imagem_array_2[1]);
        	$imagem_nome = $caminho.'/'.$nome.'.png';
        	$nova_imagem = $nome.'.webp';
            
        	file_put_contents($imagem_nome, $imagem);
        	
        	$img = imagecreatefrompng($imagem_nome);
            imagepalettetotruecolor($img);
            imagealphablending($img, true);
            imagesavealpha($img, true);
            $img_produto = imagewebp($img, $caminho.'/'.$nova_imagem, 80);
            unlink($imagem_nome);
            
            $update = "UPDATE $pagina_referencia SET img_secundaria='$nova_imagem' WHERE id='".$ultimo_id."' "  or die(mysqli_error());
            if (!mysqli_query($conexao, $update)) { die('Erro: '.mysqli_error($conexao)); }
            
        }
        
        $numeroCampos = 8;
        $tamanhoMaximo = 1000000;
        $extensoes = array(".png", ".jpg", ".jpeg", ".gif", "webp");
        $substituir = false;
        $produto = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['produto'], MB_CASE_LOWER, "UTF-8"))));
        $nome = clean($produto);
        $caminho = "../assets/img/".$pagina_referencia."/".$ultimo_id;
        
        if (!is_dir($caminho)) {
            mkdir($caminho, 0777, true);
        }
    
        if ($nome=="") { $nome=$purl_amigavel; }
        for ($i = 0; $i < $numeroCampos; $i++) {
            if (isset($_FILES["arquivo"]["name"][$i])){
        	    $nomeArquivo = strtolower ($_FILES["arquivo"]["name"][$i]);
                $tamanhoArquivo = $_FILES["arquivo"]["size"][$i];
                $nomeTemporario = $_FILES["arquivo"]["tmp_name"][$i];
                $extensao = $_FILES["arquivo"]["type"][$i];
                if ($extensao=="image/gif")
                {
                    $extensao = ".gif";
                }
                elseif ($extensao=="image/jpeg" || $extensao=="image/pjpeg")
                {
                    $extensao = ".jpg";
                }
                elseif ($extensao=="image/png")
                {
                    $extensao = ".png";
                }
                elseif ($extensao=="image/webp")
                {
                    $extensao = ".webp";
                }
                
                $i_temp = $i+1;
                $aleatorio = rand(1,999999);
                $nome_final = $nome."-".$i_temp."-".$aleatorio.$extensao;
                if (!empty($nomeArquivo)) {
                    $erro = false;
        
                    if ($tamanhoArquivo > $tamanhoMaximo) {
                      $erro = "O arquivo " . $nomeArquivo . " não deve ultrapassar " . $tamanhoMaximo. " bytes";
                    } 
                    elseif (!in_array(strrchr($nomeArquivo, "."), $extensoes)) {
                      $erro = "A extensão do arquivo <b>" . $nomeArquivo . "</b> não é válida";
                    } 
                    elseif (file_exists($caminho.'/'.$nomeArquivo) and !$substituir) {
                      $erro = "O arquivo <b>" . $nomeArquivo . "</b> já existe";
                    }
                    if (!$erro) {
                        move_uploaded_file($nomeTemporario, ($caminho.'/'.$nome_final));
                        $imagem = $caminho.'/'.$nome_final;
                        $nome_imagem = explode('.', $nome_final);
                        $nova_imagem = $nome_imagem[0].'.webp';
                        $dir = $caminho.'/';
                        
                        if ($extensao=='.png'){
                            $img = imagecreatefrompng($imagem);
                            imagepalettetotruecolor($img);
                            imagealphablending($img, true);
                            imagesavealpha($img, true);
                            $img_produto = imagewebp($img, $dir.$nova_imagem, 80);
                            unlink($imagem);
                        }elseif($extensao=='.jpg'){
                            $img = imagecreatefromjpeg($imagem);
                            imagepalettetotruecolor($img);
                            imagealphablending($img, true);
                            imagesavealpha($img, true);
                            $img_produto = imagewebp($img, $dir.$nova_imagem, 80);
                            unlink($imagem);
                        }elseif($extensao=='.gif'){
                            rename($nomeTemporario, $dir.$img_produto);
                            $nova_imagem = $nome_final;
                        }elseif($extensao=='.webp'){
                            rename($nomeTemporario, $dir.$nome_final);
                            $nova_imagem = $nome_final;
                        }
                    } 
                    else {
                      echo $erro . "<br/>";
                    }
                }
            }
        }
        if ($google_shopping!=''){
            $insert_integracao = mysqli_query($conexao, "INSERT INTO integracoes (produto, rede) VALUES ('$ultimo_id', '".$google_shopping['id']."')");
        }
        if ($catalogo_facebook!=''){
            $insert_integracao = mysqli_query($conexao, "INSERT INTO integracoes (produto,  rede) VALUES ('$ultimo_id', '".$catalogo_facebook['id']."')");
        }
        if ($lojinha_instagram!=''){
            $insert_integracao = mysqli_query($conexao, "INSERT INTO integracoes (produto,  rede) VALUES ('$ultimo_id', '".$lojinha_instagram['id']."')");
        }
        $_SESSION['alerta_mensagem'] = "Produto cadastrado com sucesso!";
        $_SESSION['alerta_tipo'] = "green";
        echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";
        exit();
    }
}
if ($acao=="cadastrar") { ?>
    <div id="wrapper">
        <form method="POST" action="" enctype="multipart/form-data" id="form_produto">
            <div class="row">
                <div class="col-md-12  header-wrapper" >
                    <h1 class="page-header"><?=mb_convert_case("$pagina_titulo", MB_CASE_TITLE, "UTF-8");?> Adicionar</h1>
                    <p class="page-subtitle">Para cadastrar um novo item, preencha os dados abaixo.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 ">
              <div class="panel panel-default">
                  <div class="panel-body"> 
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#descritivo" id="li_descritivo" data-toggle="tab" aria-expanded="true"> <span class="fa fa-home icon"></span>DESCRITIVO</a> </li>
                      <li class=""><a href="#imagens" id="li_imagens" data-toggle="tab" aria-expanded="false"> <span class="fa fa-camera icon"></span>IMAGENS</a> </li>
                      <li class=""><a href="#variacoes" id="li_variacoes" data-toggle="tab" aria-expanded="false"> <span class="fa fa-tasks icon"></span>VARIAÇÕES</a> </li>
                      <li class=""><a href="#frete" id="li_frete" data-toggle="tab" aria-expanded="false"> <span class="fa fa-truck icon"></span>FRETE</a> </li>
                      <li class=""><a href="#seo" id="li_seo" data-toggle="tab" aria-expanded="false"> <span class="fa fa-gear icon"></span>SEO</a> </li>
                      <li class=""><a href="#integracoes" id="li_integracoes" data-toggle="tab" aria-expanded="false"> <span class="fa fa-share-alt icon"></span>INTEGRAÇÕES</a> </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="descritivo">
                            <br>
                            <div class="col-md-12"> 
                                <div class="form-group">
                                  <label>CATEGORIA </label>
                                    <select class="form-control" name="categoria">
                                      <?
                                        $sql = "SELECT id, categoria FROM categorias WHERE status='a' ORDER BY categoria ASC";
                                        $query = mysqli_query($conexao, $sql);
                                        $num_rows = mysqli_num_rows($query);
                                        if ($num_rows<1){
                                            echo "<script>alert('Cadastre uma categoria para o produto!');
                                            location.href='categorias-cadastrar';</script>";
                                        }
                                        while ($dados = mysqli_fetch_assoc($query)) {
                                            if ($categoria==$dados['id']) { $selecao = 'selected'; } else { $selecao = ''; }
                                            echo "<option value='".$dados['id']."' $selecao>".$dados['categoria']."</option>";
                                        }
                                        mysqli_free_result($query);
                                      ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12"> 
                                <div class="form-group">
                                  <label>TÍTULO DO PRODUTO</label>
                                    <input name="produto" type="text" required="required" autofocus class="form-control" id="produto" placeholder="" maxlength="255" value="" onkeyup="UrlAmigavel(this.value, 'produto', '2')">
                                    <input type="hidden" id="tabela" value="produtos">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group" id="form_url_amigavel">
                                  <label>URL AMIGÁVEL</label>
                                  <label class="control-label" for="url_amigavel" style="display:none;" id="label_url_amigavel">Url amigável indisponível</label>
                                  <input name="url_amigavel" type="text" required="required" class="form-control" id="url_amigavel" placeholder="Ex: nome-do-produto" maxlength="255" onkeyup="UrlAmigavel(this.value, 'url_amigavel', '1')">
                                </div>
                            </div>
                            <div class="col-md-3"> 
                                <div class="form-group">
                                  <label>SKU (UNIDADE DE MANUTENÇÃO DE ESTOQUE)</label>
                                    <input name="sku" type="text" class="form-control" id="sku">
                                </div>
                            </div>
                            <div class="col-md-3"> 
                                <div class="form-group">
                                  <label>CÓDIGO DO PRODUTO (SISTEMA)</label>
                                    <input name="sistema" type="text" class="form-control" id="sistema">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                  <label>EAN (NÚMERO EUROPEU DO ARTIGO)</label>
                                    <input name="ean" type="text" class="form-control" id="ean">
                                </div>
                            </div>
                            <div class="col-md-3"> 
                                <div class="form-group">
                                  <label>NCM (NOMENCLATURA COMUM DO MERCOSUL)</label>
                                    <input name="ncm" type="text" class="form-control" id="ncm">
                                </div>
                            </div>
                            <div class="col-md-12"> 
                                <div class="form-group">
                                  <label>LINK P/ COMPRA DIRETA</label>
                                    <input name="link_compra" type="url" class="form-control" id="link_compra">
                                </div>
                            </div>
                            <div class="col-md-12"> 
                                <div class="form-group">
                                  <label>DESCRIÇÃO</label>
                                    <textarea class="form-control" rows="4" name="descricao" id="descricao"></textarea>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                  <label>ESTOQUE</label>
                                    <input name="qtd" type="number" required="required" class="form-control" id="qtd" min="0" step="1" value="99999999">
                                </div>
                            </div>
                            <div class="col-md-3"> 
                                <div class="form-group">
                                  <label>QUANTIDADE MÍNIMA</label>
                                    <input name="qtd_minimo" type="number" required="required" class="form-control" id="qtd_minimo" min="1" step="1" value="1">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                  <label>VENDIDOS</label>
                                    <input name="qtd_vendido" type="number" class="form-control" id="qtd_vendido" min="0" step="1" value="0">
                                </div>
                            </div>
                            <div class="col-md-3"> 
                                <div class="form-group">
                                  <label>VISTO</label>
                                    <input name="qtd_visto" type="number" class="form-control" id="qtd_visto" min="0" step="1" value="0">
                                </div>
                            </div>
                            <div class="col-md-3"> 
                                <div class="form-group">
                                  <label>PREÇO</label>
                                    <input name="preco" type="number" required="required" class="form-control" id="preco" min="0" step="0.01" value="0">
                                </div>
                            </div>
                            <div class="col-md-3"> 
                                <div class="form-group">
                                  <label>POR</label>
                                    <input name="por" type="number" class="form-control" id="por" min="0" step="0.01" value="0">
                                </div>
                            </div>
                            <div class="col-md-3"> 
                                <div class="form-group">
                                  <label>ORDEM</label>
                                  <input name="ordem" type="number" class="form-control" placeholder="" value="100" min="1">
                                </div>
                            </div>
                            <div class="col-md-3"> 
                                <div class="form-group">
                                  <label>PROMOÇÃO</label>
                                  <select class="form-control" name="promocao">
                                      <option value='sim'>Sim</option>
                                      <option value='nao'>Não</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4"> 
                                <div class="form-group">
                                  <label>DESTAQUE</label>
                                  <select class="form-control" name="destaquee">
                                      <option value='sim'>Sim</option>
                                      <option value='nao' selected>Não</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4"> 
                                <div class="form-group">
                                  <label>ESTRELAS</label>
                                    <input name="estrelas_soma" type="number" class="form-control" id="estrelas_soma" placeholder="Quantidade de estrelas por produtos" value="0" step="1" min="0" max="5" >
                                </div>
                            </div>
                            <div class="col-md-4"> 
                                <div class="form-group">
                                  <label>FABRICANTE</label>
                                  <select class="form-control" name="fabricante">
                                        <?
                                        $sql = "SELECT * FROM fabricante WHERE status='a' ORDER BY titulo ASC";
                                        $query = mysqli_query($conexao, $sql);
                
                                        while ($dados = mysqli_fetch_assoc($query)) {
                                            echo "<option value='".$dados['id']."'>" . $dados['titulo'] . "</option>";
                                        }
                                        mysqli_free_result($query);
                                        ?> 
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4"> 
                                <div class="form-group">
                                  <label>FORMA DE PAGAMENTO</label>
                                    <input name="forma" type="text" class="form-control" id="forma" placeholder="Formas de Pagamento" maxlength="255" value="Boleto Bancário / Cartão de Crédito / Transferência">
                                </div>
                            </div>
                            <div class="col-md-4"> 
                                <div class="form-group">
                                  <label>PRAZO DE ENTREGA</label>
                                    <input name="prazo" type="text" class="form-control" id="prazo" placeholder="Prazo de Entrega" maxlength="255" value="Consulte-nos">
                                </div>
                            </div>
                            <div class="col-md-4"> 
                                <div class="form-group">
                                  <label>REGIÃO ATENDIDA</label>
                                    <input name="regiao" type="text" class="form-control" id="regiao" placeholder="Região Atendida" maxlength="255" value="Consulte-nos">
                                </div>
                            </div>
                            <div class="col-md-12"> 
                                <div class="form-group">
                                  <label>INFORMAÇÕES ADICIONAIS</label>
                                    <textarea class="form-control" rows="4" name="informacoes_adicionais" id="informacoes_adicionais"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12"> 
                                <div class="form-group">
                                  <label>LINK DO YOUTUBE</label>
                                    <input name="link_youtube" type="url" class="form-control" id="link_youtube" placeholder="Link do produto no Youtube" >
                                </div>
                            </div>
                            <div class="col-md-12"> 
                                <div class="form-group">
                                  <label>STATUS</label>
                                  <select class="form-control" name="status">
                                      <option value='a'>Ativo</option>
                                      <option value='d'>Desativado</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-12" style="margin-top: 15px;">
                                <div class="pull-right">
                                    <a onclick="$('#li_imagens').click();" data-toggle="tab" aria-expanded="false" class="btn btn-default">SEGUINTE &nbsp;<i class="fa  fa-mail-forward "></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="imagens">
                            <br>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="image_area">
    							        <label for="upload_destaque" style="width: 100%; display: flex; align-items: center;align-items: flex-start;">
        							        <div class="col-md-4 padding-img-upload">
            							        <a href="#" data-toggle="modal" data-target="#excluir_destaque" style="position: absolute; left:0; z-index:99;">
                                                    <button type="button" class="btn btn-danger" style="float: right;height: 24px; width: 24px; display: flex; justify-content: center; align-items: center;"><i class='fa fa-trash'></i></button>
                                                </a>
                                                <div class="modal fade" id="excluir_destaque" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                  <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            <h4 class="modal-title" id="myModalLabel3">REMOVER IMAGEM DESTAQUE</h4>
                                                        </div>
                                                        <div class="modal-body">Confirma a exclusão da foto desse produto? Após a confirmação o mesmo não poderá ser desfeito. </div>
                                                        <div class="modal-footer">
                                                            <button type="button" name="excluir_todas_imagens" onclick="$('#uploaded_destaque').attr('src', '../assets/img/<?=$pagina_referencia;?>/sem_imagem.jpg');$('#img_destaque').prop('value', '');$('#upload_destaque').val('');" class="btn btn-danger" data-dismiss="modal" role="button"><i class='fa fa-trash'></i> Sim, desejo excluir</button>
                                                            <button type="button" class="btn btn-light" data-dismiss="modal">NÃO</button>
                                                        </div>
                                                    </div>
                                                  </div>
                                                </div>
            								    <img src="../assets/img/<?=$pagina_referencia;?>/sem_imagem.jpg" id="uploaded_destaque" class="img-responsive" style="border: 1px solid #eee; max-height: 130px;"/>
            								    <input type="file" name="upload_destaque" class="upload_image" id="upload_destaque" data-width="800" data-height="800" style="display:none;">
            								    <input type="hidden" name="img_destaque" id="img_destaque" value=""/>
            								</div>
            								<div class="col-md-8">
        							            <label>DESTAQUE</label>
        							            <button type="button" onclick="$('#upload_destaque').click();" class="btn btn-success btn-upload">Adicionar </button>
        							        </div>
    							        </label>
                					</div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="image_area">
    							        <label for="upload_secundaria" style="width: 100%; display: flex; align-items: center;align-items: flex-start;">
        							        <div class="col-md-4 padding-img-upload">
            							        <a href="#" data-toggle="modal" data-target="#excluir_secundaria" style="position: absolute; left:0;">
                                                    <button type="button" class="btn btn-danger" style="float: right;height: 24px; width: 24px; display: flex; justify-content: center; align-items: center;"><i class='fa fa-trash'></i></button>
                                                </a>
                                                <div class="modal fade" id="excluir_secundaria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                  <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            <h4 class="modal-title" id="myModalLabel3">REMOVER IMAGEM SECUNDÁRIA</h4>
                                                        </div>
                                                        <div class="modal-body">Confirma a exclusão da foto desse produto? Após a confirmação o mesmo não poderá ser desfeito. </div>
                                                        <div class="modal-footer">                 
                                                            <button type="button" name="excluir_todas_imagens" onclick="$('#uploaded_secundaria').attr('src', '../assets/img/<?=$pagina_referencia;?>/sem_imagem.jpg');$('#img_secundaria').prop('value', '');$('#upload_secundaria').val('');" class="btn btn-danger" data-dismiss="modal" role="button"><i class='fa fa-trash'></i> Sim, desejo excluir</button>
                                                            <button type="button" class="btn btn-light" data-dismiss="modal">NÃO</button>
                                                        </div>
                                                    </div>
                                                  </div>
                                                </div>
            								    <img src="../assets/img/<?=$pagina_referencia;?>/sem_imagem.jpg" id="uploaded_secundaria" class="img-responsive" style="border: 1px solid #eee; max-height: 130px;"/>
            								    <input type="file" name="upload_secundaria" class="upload_image" id="upload_secundaria" data-width="800" data-height="800" style="display:none;">
            								    <input type="hidden" name="img_secundaria" id="img_secundaria" value=""/>
            								</div>
            								<div class="col-md-8">
        							            <label>SECUNDÁRIA <smal>(Ao passar o mouse)</smal></label>
        							            <button type="button" onclick="$('#upload_secundaria').click();" class="btn btn-success btn-upload">Adicionar </button>
        							        </div>
    							        </label>
                					</div>
                                </div>
                            </div>
                            <input type="hidden" id="imagem" value="">
                    		<div class="modal fade" id="nova_imagem_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                			  	<div class="modal-dialog modal-lg" role="document">
                			    	<div class="modal-content">
                			      		<div class="modal-header">
                			        		<h5 class="modal-title">Recorte sua imagem para fazer o upload</h5>
                			        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                			          			<span aria-hidden="true">×</span>
                			        		</button>
                			      		</div>
                			      		<div class="modal-body">
                			        		<div class="img-container">
                			            		<div class="row">
                			                		<div class="col-md-8">
                			                    		<img src="" id="sample_image"/>
                			                		</div>
                			                		<div class="col-md-4">
                			                    		<div class="preview"></div>
                			                		</div>
                			            		</div>
                			        		</div>
                			      		</div>
                			      		<div class="modal-footer" id="modal_rodape">
                			      			<button type="button" id="crop" class="btn btn-primary">Enviar</button>
                			        		<button type="button" class="btn btn-default" id="enviando" style="display:none;">Enviando...</button>
                			        		<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                			      		</div>
                			    	</div>
                			  	</div>
                			</div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group" style="display:flex;">
                                            <div>
                                                <label for="file_input_2" class="label-interna">
                                                <i class="fa fa-file"></i>
                                                <span>IMAGENS INTERNAS <small>(Máximo de 8 fotos)</small></span>
                                                </label>
                                                <input type="file"  id="file_input_2" data-preview="preview_2" data-action="preview" accept=".png, .jpeg, .jpg, .pdf"  multiple name="arquivo[]"/>
                                                <div id="imagens_alerta" style="display:none;"></div>
                                            </div>
                                        </div>
                                        <div class="container-internas">
                                            <div id="preview_2" class="row preview"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="imagens_internas_produto"> </div>
                            </div>
                            <br>
                            <div class="col-md-12" style="margin-top: 15px;">
                                <div class="pull-right">
                                    <a onclick="$('#li_descritivo').click();" data-toggle="tab" aria-expanded="false" class="btn btn-default"><i class="fa fa-reply"></i>&nbsp; ANTERIOR</a>
                                    <a onclick="$('#li_variacoes').click();" data-toggle="tab" aria-expanded="false" class="btn btn-default">SEGUINTE &nbsp;<i class="fa  fa-mail-forward "></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="variacoes">
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="list-group ">
                                        <div class="list-group-item withswitch">
                                            <h5 class="list-group-item-heading">TAMANHO</h5>
                                            <div class="switch">
                                              <input id="check_tamanho" name="check_tamanho" class="cmn-toggle cmn-toggle-round" type="checkbox">
                                              <label for="check_tamanho"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="list-group ">
                                        <div class="list-group-item withswitch">
                                            <h5 class="list-group-item-heading">COR</h5>
                                            <div class="switch">
                                              <input id="check_cor" name="check_cor" value="sim" class="cmn-toggle cmn-toggle-round" type="checkbox">
                                              <label for="check_cor"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <?
                            $sql_cor = mysqli_query($conexao, "SELECT * FROM cores WHERE status='a' ORDER BY cor ASC");
                            if (mysqli_num_rows($sql_cor)>0){
                                $option_cor = '';
                                $contador_cor = 0;
                                while ($dados_cor = mysqli_fetch_assoc($sql_cor)){
                                    $option_cor .= '<option value="'.$dados_cor['id'].'" data-rgb="'.$dados_cor['rgb'].'">'.$dados_cor['cor'].'</option>';
                                    if ($contador_cor==0){
                                        $rgb = $dados_cor['rgb'];
                                        $bg_novo = 'background: '.$dados_cor['rgb'];
                                    }
                                    $contador_cor++;
                                }
                            }
                            $sql_tamanho = mysqli_query($conexao, "SELECT * FROM tamanhos WHERE status='a' ORDER BY tamanho ASC");
                            if (mysqli_num_rows($sql_tamanho)>0){
                                $option_tamanho = '';
                                while ($dados_tamanho = mysqli_fetch_assoc($sql_tamanho)){
                                    $option_tamanho .= '<option value="'.$dados_tamanho['id'].'">'.$dados_tamanho['tamanho'].'</option>';
                                }
                            }
                            ?>
                            <div class="row" id="variacao" style="display: none;">
                                <hr>
                                <div class="col-md-12">
                                    <div class="pull-right mb-15">
                                        <a onclick="novaVariacao();" data-toggle="tab" aria-expanded="false" class="btn btn-success"><i class="fa fa-plus "></i>&nbsp; ADICIONAR VARIAÇÃO</a>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="tabela_variacoes" style="display: none;">
                                            <thead>
                                                <tr>
                                                    <th id="th_linha">Linha</th>
                                                    <th id="th_tamanho">Tamanho</th>
                                                    <th id="th_cor">Cor</th>
                                                    <th id="th_qtd">Qtd</th>
                                                    <th id="th_ordem">Ordem</th>
                                                    <th id="th_operacao">Operação</th>
                                                    <th id="th_valor">Valor</th>
                                                    <th id="th_tipo">Tipo</th>
                                                    <th id="th_acao">Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody_variacoes">
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" value="0" id="contador_variacao" name="contador_variacao">
                            <br>
                            <div class="col-md-12" style="margin-top: 15px;">
                                <div class="pull-right">
                                    <a onclick="$('#li_imagens').click();" data-toggle="tab" aria-expanded="false" class="btn btn-default"><i class="fa fa-reply "></i>&nbsp; ANTERIOR</a>
                                    <a onclick="$('#li_frete').click();" data-toggle="tab" aria-expanded="false" class="btn btn-default">SEGUINTE &nbsp;<i class="fa  fa-mail-forward "></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="frete">
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="list-group">
                                        <div class="list-group-item withswitch">
                                            <h5 class="list-group-item-heading">FRETE ÚNICO?</h5>
                                            <div class="switch">
                                              <input id="check_frete" name="check_frete" checked value="sim" class="cmn-toggle cmn-toggle-round" type="checkbox">
                                              <label for="check_frete"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div id="frete_unico">
                                <div class="col-md-3"> 
                                    <div class="form-group">
                                      <label>PESO (kg)</label>
                                        <input name="peso" type="number" class="form-control" id="peso" min="0" step="0.001" value="0">
                                    </div>
                                </div>
                                <div class="col-md-3"> 
                                    <div class="form-group">
                                      <label>ALTURA (cm)</label>
                                        <input name="altura" type="number" class="form-control" id="altura" placeholder="Altura do produto" value="0" step="1" min="0" max="100">
                                    </div>
                                </div>
                                <div class="col-md-3"> 
                                    <div class="form-group">
                                      <label>LARGURA (cm)</label>
                                        <input name="largura" type="number" class="form-control" id="largura" placeholder="Largura do produto" value="0" step="1" min="0" max="100">
                                    </div>
                                </div>
                                <div class="col-md-3"> 
                                    <div class="form-group">
                                      <label>COMPRIMENTO (cm)</label>
                                        <input name="comprimento" type="number" class="form-control" id="comprimento" placeholder="Comprimento do produto" value="0" step="1" min="0" max="1000" >
                                    </div>
                                </div>
                            </div>
                            <div id="frete_multi" style="display: none;">
                              <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive" id="tabela_frete">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Linha</th>
                                                    <th>Cor</th>
                                                    <th>Tamanho</th>
                                                    <th>Peso</th>
                                                    <th>Altura</th>
                                                    <th>Largura</th>
                                                    <th>Comprimento</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody_frete">
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="sem_variacao" style="display: none;"></div>
                                </div>
                              </div>
                            </div>
                            <br>
                            <div class="col-md-12" style="margin-top: 15px;">
                                <div class="pull-right">
                                    <a onclick="$('#li_variacoes').click();" data-toggle="tab" aria-expanded="false" class="btn btn-default"><i class="fa fa-reply"></i>&nbsp; ANTERIOR</a>
                                    <a onclick="$('#li_seo').click();" data-toggle="tab" aria-expanded="false" class="btn btn-default">SEGUINTE &nbsp;<i class="fa fa-mail-forward "></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="seo">
                            <br>
                            <div class="col-md-12"> 
                                <div class="form-group">
                                  <label>TÍTULO DO PRODUTO (SEO)</label>
                                    &nbsp;<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="top" data-content="Títulos curtos com até 60 caracteres tem um melhor posicionamento no Google" data-title="Título SEO" data-trigger="focus" title="" aria-describedby="popover260526" style="line-height: normal; padding: 3px 7px 3px 7px;"> ? </button>
                                    &nbsp;<button class="btn btn-danger caracteres" id="caracteres_titulo_seo">0 Caracteres</button>
                                    <input name="titulo_seo" type="text" autofocus class="form-control" id="titulo_seo" placeholder="Títulos com até 60 caracteres tem um melhor posicionamento" maxlength="255">
                                </div>
                            </div>
                            <div class="col-md-12"> 
                                <div class="form-group">
                                  <label>DESCRIÇÃO DO PRODUTO (SEO)</label>
                                    &nbsp;<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="top" data-content="Sugerimos no máximo 156 caracteres sendo os 50 primeiros mais importantes, para um melhor posicionamento no Google" data-title="Descrição SEO" data-trigger="focus" title="" aria-describedby="popover260526" style="line-height: normal; padding: 3px 7px 3px 7px;"> ? </button>
                                    &nbsp;<button class="btn btn-danger caracteres" id="caracteres_descricao_seo">0 Caracteres</button>
                                    <input name="desc_seo" type="text" autofocus class="form-control" id="descricao_seo" placeholder="Sugerimos no máximo 156 caracteres sendo os 50 primeiros mais importantes" maxlength="255">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                  <label>PALAVRAS CHAVES DO PRODUTO (SEO)</label>
                                    &nbsp;<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="top" data-content="Palavras relevantes separadas por vírgula, máximo de 200 caracteres, para um melhor posicionamento no Google (Algo que você pesquisaria para encontrar o produto em questão)" data-title="Palavras SEO" data-trigger="focus" title="" aria-describedby="popover260526" style="line-height: normal; padding: 3px 7px 3px 7px;"> ? </button>
                                    &nbsp;<button class="btn btn-danger caracteres" id="caracteres_palavras_seo">0 Caracteres</button>
                                    <input name="palavras_seo" type="text"  autofocus class="form-control" id="palavras_seo" placeholder="Palavras relevantes separadas por vírgula, máximo de 200 caracteres" maxlength="255">
                                </div>
                            </div>
                            <br>
                            <div class="col-md-12" style="margin-top: 15px;">
                                <div class="pull-right">
                                    <a onclick="$('#li_frete').click();" data-toggle="tab" aria-expanded="false" class="btn btn-default"><i class="fa fa-reply "></i>&nbsp; ANTERIOR</a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="integracoes">
                            <br>
                            <div id="row">
                                <?
                                $query_integracoes = mysqli_query($conexao, "SELECT id, rede FROM redes WHERE status='a' ORDER BY id ASC");
                                if (mysqli_num_rows($query_integracoes)>0){
                                    while ($dados_redes = mysqli_fetch_assoc($query_integracoes)){
                                    $value = json_encode(array('id' => $dados_redes['id'], 'rede' => $dados_redes['rede'], 'valor' => 'add'));
                                ?>
                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <div class="list-group-item withswitch">
                                                <h5 class="list-group-item-heading"><?=$dados_redes['rede'];?></h5>
                                                <div class="switch">
                                                <input id="<?=clean($dados_redes['rede']);?>" name="<?=clean($dados_redes['rede']);?>" value='<?=$value;?>' class="cmn-toggle cmn-toggle-round" type="checkbox">
                                                <label for="<?=clean($dados_redes['rede']);?>"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?}}?>
                            </div>
                            <br>
                            <div class="col-md-12" style="margin-top: 15px;">
                                <div class="pull-right">
                                    <a onclick="$('#li_seo').click();" data-toggle="tab" aria-expanded="false" class="btn btn-default"><i class="fa fa-reply"></i>&nbsp; ANTERIOR</a>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
                <div class="col-md-12" >
                    <div class="panel panel-default">
                      <div class="panel-body"> 
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label></label>
                              <input name="acao" id="acao" value="gravar" type="hidden">
                              <button type="submit" name="enviar" value="enviar" class="btn btn-success" style="float:right;"><i class="fa fa-check"></i> Cadastrar </button>
                            </div>
                          </div> 
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?
if(!isset($pasta)){$pasta='';}
if(!isset($img_secundaria)){$img_secundaria='';}
if(!isset($produto)){$produto='';}
}
  if ($acao=="excluir") { 
      $ip = $_SERVER['REMOTE_ADDR'];
      $endereco_ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
      $update = "UPDATE $pagina_referencia SET ip='$ip', endereco_ip='$endereco_ip', data_excluir='".date('Y-m-d')."', hora_excluir='".date('H:i:s')."', status='d' WHERE id='".$id."' " or die(mysqli_error());
      if (!mysqli_query($conexao, $update)) {  
          die('Erro: '.mysqli_error($conexao)); 
      } else {
          echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";
      }
  }
  if ($acao=="gravar_editar") {
    ((isset($_POST['id']) AND $_POST['id']!='')?$id = (int)$_POST['id']:$id='');
    ((isset($_POST['categoria']) AND $_POST['categoria']!='')?$categoria = (int)$_POST['categoria']:$categoria='');
    ((isset($_POST['produto']) AND $_POST['produto']!='')?$produto = trim(addslashes(htmlspecialchars($_POST['produto']))):$produto='');
    ((isset($_POST['url_amigavel']) AND $_POST['url_amigavel']!='')?$url_amigavel = trim(addslashes(htmlspecialchars($_POST['url_amigavel']))):$url_amigavel='');
    ((isset($_POST['descricao']) AND $_POST['descricao']!='')?$descricao = base64_encode(($_POST['descricao'])):$descricao='');
    ((isset($_POST['qtd']) AND $_POST['qtd']!='')?$qtd = trim(addslashes(htmlspecialchars($_POST['qtd']))):$qtd='');
    ((isset($_POST['qtd_minimo']) AND $_POST['qtd_minimo']!='')?$qtd_minimo = trim(addslashes(htmlspecialchars($_POST['qtd_minimo']))):$qtd_minimo='');
    ((isset($_POST['qtd_vendido']) AND $_POST['qtd_vendido']!='')?$qtd_vendido = trim(addslashes(htmlspecialchars($_POST['qtd_vendido']))):$qtd_vendido='');
    ((isset($_POST['qtd_visto']) AND $_POST['qtd_visto']!='')?$qtd_visto = trim(addslashes(htmlspecialchars($_POST['qtd_visto']))):$qtd_visto='');
    ((isset($_POST['preco']) AND $_POST['preco']!='')?$preco = trim(addslashes(htmlspecialchars($_POST['preco']))):$preco='');
    ((isset($_POST['por']) AND $_POST['por']!='')?$por = trim(addslashes(htmlspecialchars($_POST['por']))):$por='');
    ((isset($_POST['qtd_parcela']) AND $_POST['qtd_parcela']!='')?$qtd_parcela = trim(addslashes(htmlspecialchars($_POST['qtd_parcela']))):$qtd_parcela='');
    ((isset($_POST['valor_parcela']) AND $_POST['valor_parcela']!='')?$valor_parcela = trim(addslashes(htmlspecialchars(str_replace(',', '.', $_POST['valor_parcela'])))):$valor_parcela='');
    ((isset($_POST['valor_parcela_juros']) AND $_POST['valor_parcela_juros']!='')?$valor_parcela_juros = trim(addslashes(htmlspecialchars(str_replace(',', '.', $_POST['valor_parcela_juros'])))):$valor_parcela_juros='');
    ((isset($_POST['forma']) AND $_POST['forma']!='')?$forma = trim(addslashes(htmlspecialchars($_POST['forma']))):$forma='');
    ((isset($_POST['prazo']) AND $_POST['prazo']!='')?$prazo = trim(addslashes(htmlspecialchars($_POST['prazo']))):$prazo='');
    ((isset($_POST['regiao']) AND $_POST['regiao']!='')?$regiao = trim(addslashes(htmlspecialchars($_POST['regiao']))):$regiao='');
    ((isset($_POST['promocao']) AND $_POST['promocao']!='')?$promocao = trim(addslashes(htmlspecialchars($_POST['promocao']))):$promocao='');
    ((isset($_POST['frete']) AND $_POST['frete']!='')?$frete = trim(addslashes(htmlspecialchars($_POST['frete']))):$frete='');
    ((isset($_POST['pronta']) AND $_POST['pronta']!='')?$pronta = trim(addslashes(htmlspecialchars($_POST['pronta']))):$pronta='');
    ((isset($_POST['faturamento']) AND $_POST['faturamento']!='')?$faturamento = trim(addslashes(htmlspecialchars($_POST['faturamento']))):$faturamento='');
    ((isset($_POST['destaque']) AND $_POST['destaque']!='')?$destaque = trim(addslashes(htmlspecialchars($_POST['destaque']))):$destaque='');
	((isset($_POST['ordemdestaque']) AND $_POST['ordemdestaque']!='')?$ordemdestaque = trim(addslashes(htmlspecialchars($_POST['ordemdestaque']))):$ordemdestaque='');
    ((isset($_POST['sku']) AND $_POST['sku']!='')?$sku = trim(addslashes(htmlspecialchars($_POST['sku']))):$sku='');
    ((isset($_POST['informacoes_adicionais']) AND $_POST['informacoes_adicionais']!='')?$informacoes_adicionais = base64_encode(($_POST['informacoes_adicionais'])):$informacoes_adicionais='');
    ((isset($_POST['link_youtube']) AND $_POST['link_youtube']!='')?$link_youtube = trim(addslashes(htmlspecialchars($_POST['link_youtube']))):$link_youtube='');
    ((isset($_POST['link_compra']) AND $_POST['link_compra']!='')?$link_compra = strtolower(trim(addslashes(htmlspecialchars($_POST['link_compra'])))):$link_compra='');
    ((isset($_POST['avaliacao']) AND $_POST['avaliacao']!='')?$avaliacao = trim(addslashes(htmlspecialchars($_POST['avaliacao']))):$avaliacao='');
    ((isset($_POST['fabricante']) AND $_POST['fabricante']!='')?$fabricante = (int)$_POST['fabricante']:$fabricante='');
    ((isset($_POST['status']) AND $_POST['status']!='')?$status = strtolower(trim(addslashes(htmlspecialchars($_POST['status'])))):$status='');
    ((isset($_POST['titulo_seo']) AND $_POST['titulo_seo']!='')?$titulo_seo = ucfirst(trim(addslashes(htmlspecialchars($_POST['titulo_seo'])))):$titulo_seo='');
    ((isset($_POST['desc_seo']) AND $_POST['desc_seo']!='')?$desc_seo = ucfirst(trim(addslashes(htmlspecialchars($_POST['desc_seo'])))):$desc_seo='');
    ((isset($_POST['palavras_seo']) AND $_POST['palavras_seo']!='')?$palavras_seo = strtolower(trim(addslashes(htmlspecialchars($_POST['palavras_seo'])))):$palavras_seo='');
    ((isset($_POST['peso']) AND $_POST['peso']!='')?$peso = $_POST['peso']:$peso='');
    ((isset($_POST['altura']) AND $_POST['altura']!='')?$altura = $_POST['altura']:$altura='');
    ((isset($_POST['largura']) AND $_POST['largura']!='')?$largura = $_POST['largura']:$largura='');
    ((isset($_POST['comprimento']) AND $_POST['comprimento']!='')?$comprimento = $_POST['comprimento']:$comprimento='');
    ((isset($_POST['google-shopping']) AND $_POST['google-shopping']!='')?$google_shopping = json_decode($_POST['google-shopping'], true):$google_shopping='');
    ((isset($_POST['catalogo-facebook']) AND $_POST['catalogo-facebook']!='')?$catalogo_facebook = json_decode($_POST['catalogo-facebook'], true):$catalogo_facebook='');
    ((isset($_POST['lojinha-instagram']) AND $_POST['lojinha-instagram']!='')?$lojinha_instagram = json_decode($_POST['lojinha-instagram'], true):$lojinha_instagram='');
    
    $contador_variacao = ((isset($_POST['contador_variacao']))?$_POST['contador_variacao']:$_POST['contador_variacao'] = '');
    $check_cor = ((isset($_POST['check_cor']))?$_POST['check_cor']:$_POST['check_cor'] = '');
    $check_tamanho = ((isset($_POST['check_tamanho']))?$_POST['check_tamanho']:$_POST['check_tamanho'] = '');
    
    $ip = $_SERVER['REMOTE_ADDR'];
    $endereco_ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);

    if (($check_cor!='' || $check_tamanho!='') AND isset($contador_variacao) AND $contador_variacao>0){
        for ($i = 0; $i < $contador_variacao; $i++){
            ((!isset($_POST['cor'][$i]) || $check_cor=='')?$_POST['cor'][$i] = 0:'');
            ((!isset($_POST['tamanho'][$i]) || $check_tamanho=='')?$_POST['tamanho'][$i] = 0:'');
            if (isset($_POST['img_ancora'][$i])){
                $img_ancora = explode('/', str_replace($psite, '..', $_POST['img_ancora'][$i]));
                $img_ancora = end($img_ancora);
            }else{
                $img_ancora = '';
            }
            
            if (isset($_POST['estoque'][$i]) AND $_POST['estoque'][$i]!=''){
                $update = mysqli_query($conexao, "UPDATE estoque SET cor='".$_POST['cor'][$i]."', tamanho='".$_POST['tamanho'][$i]."', produto='$id', qtd='".$_POST['qtd_variacao'][$i]."', img_ancora='".$img_ancora."', ordem='".$_POST['ordem_variacao'][$i]."', operacao='".$_POST['operacao'][$i]."', tipo='".$_POST['tipo'][$i]."', valor='".$_POST['valor'][$i]."', data_cadastro='".date('Y-m-d')."', hora_cadastro='".date('H:i:s')."', data_editar='".date('Y-m-d')."', hora_editar='".date('H:i:s')."', ip='$ip', endereco_ip='$endereco_ip', status='a' WHERE id='".$_POST['estoque'][$i]."'");
                $id_estoque = $_POST['estoque'][$i];
                if (isset($_POST['img_cor'][$i])){
                    if ($_POST['img_cor'][$i]!=''){
                        $img_cor = end(explode('/' ,$_POST['img_cor'][$i]));
                    }else{
                        $img_cor = '';
                    }
                    $update_cor = mysqli_query($conexao, "UPDATE estoque SET img='".$img_cor."' WHERE id='".$id_estoque."' AND status='a'");
                }
                $excluir_estoque = array_search($_POST['estoque'][$i], $_POST['estoque']);
                if($excluir_estoque!==false){
                    unset($_POST['estoque'][$excluir_estoque]);
                }
            }else{
                $insert = mysqli_query($conexao, "INSERT INTO estoque (cor, tamanho, produto, img_ancora, qtd, ordem, operacao, tipo, valor, data_cadastro, hora_cadastro, data_editar, hora_editar, ip, endereco_ip, status) VALUES ('".$_POST['cor'][$i]."', '".$_POST['tamanho'][$i]."', '$id', '$img_ancora', '".$_POST['qtd_variacao'][$i]."', '".$_POST['ordem_variacao'][$i]."', '".$_POST['operacao'][$i]."', '".$_POST['tipo'][$i]."', '".$_POST['valor'][$i]."', '".date('Y-m-d')."', '".date('H:i:s')."', '".date('Y-m-d')."', '".date('H:i:s')."', '$ip', '$endereco_ip', 'a')");
                $id_estoque = mysqli_insert_id($conexao);
            }
        }
        foreach ($_POST['estoque'] as $item){
            $delete = mysqli_query($conexao, "DELETE FROM estoque WHERE id='$item'");
        }
    }else{
        $delete = mysqli_query($conexao, "DELETE FROM estoque WHERE produto='$id'");
    }

    $query = $conexao->query("SELECT url_amigavel FROM produtos WHERE url_amigavel='$url_amigavel' AND status='a'");
    $num_rows = $query->num_rows;
    if ($num_rows>1){
        $url_final = $url_amigavel.'-'.$id;
        $update = mysqli_query($conexao, "UPDATE produtos SET url_amigavel='$url_final' WHERE id='$produto_id'");
    }
    
    $update = "UPDATE $pagina_referencia SET sku='$sku', categoria='$categoria', produto='$produto', url_amigavel='$url_amigavel', descricao='$descricao', informacoes_adicionais='$informacoes_adicionais', avaliacao_qtd='$avaliacao', link_youtube='$link_youtube', link_compra='$link_compra', qtd='$qtd', qtd_minimo='$qtd_minimo', qtd_vendido='$qtd_vendido', qtd_visto='$qtd_visto', preco='$preco', por='$por',qtd_parcela='$qtd_parcela',valor_parcela='$valor_parcela',valor_parcela_juros='$valor_parcela_juros', forma='$forma', prazo='$prazo', regiao='$regiao', promocao='$promocao', peso='$peso', altura='$altura', largura='$largura', comprimento='$comprimento', pronta='$pronta', faturamento='$faturamento', destaque='$destaque', destaque_ordem='$ordemdestaque', fabricante='$fabricante', ip='$ip', endereco_ip='$endereco_ip', data_editar='".date('Y-m-d')."', hora_editar='".date('H:i:s')."', status='$status', Titulo_seo='$titulo_seo', Descricao_seo='$desc_seo', palavrasChave_seo='$palavras_seo' WHERE id='".$id."' "  or die(mysqli_error());
    
    if (!mysqli_query($conexao, $update)) {
      die('Erro: '.mysqli_error($conexao)); 
    } else {
        
        $query_imagens = mysqli_query($conexao, "SELECT img, img_secundaria, img_email FROM $pagina_referencia WHERE id='$id' AND status='a' LIMIT 1");
        $dados_imagens = mysqli_fetch_assoc($query_imagens);
        
        if (isset($_POST['img_destaque']) AND $_POST['img_destaque']!='' AND $_POST['img_destaque']!=$dados_imagens['img']){
            $nome = clean($produto);
            if ($nome=="") { $nome=$purl_amigavel; }
            $aleatorio = rand(1,999999);
            $nome = "produto-".$id."-".$nome."-".$aleatorio;
            $caminho = "../assets/img/".$pagina_referencia;
            
            $imagem = $_POST['img_destaque'];
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
            $img_email = imagejpeg($img, $caminho.'/'.$nova_imagem_email, 80);
            $img_produto = imagewebp($img, $caminho.'/'.$nova_imagem, 80);
            unlink($imagem_nome);
            
            $update = "UPDATE $pagina_referencia SET img='$nova_imagem', img_email='$nova_imagem_email' WHERE id='".$id."' "  or die(mysqli_error());
            if (!mysqli_query($conexao, $update)) { die('Erro: '.mysqli_error($conexao)); }
            
            unlink($caminho.'/'.$dados_imagens['img']);
            unlink($caminho.'/'.$dados_imagens['img_email']);
            
        }elseif(isset($_POST['img_destaque']) AND $_POST['img_destaque']==''){
            $nova_imagem = 'sem_imagem.jpg';
            $update = "UPDATE $pagina_referencia SET img='$nova_imagem', img_email='$nova_imagem' WHERE id='".$id."' "  or die(mysqli_error());
            if (!mysqli_query($conexao, $update)) { die('Erro: '.mysqli_error($conexao)); }
            $caminho = "../assets/img/".$pagina_referencia;
            if ($dados_imagens['img']!=$nova_imagem){
                unlink($caminho.'/'.$dados_imagens['img']);
                unlink($caminho.'/'.$dados_imagens['img_email']);
            }
        }
        
        if (isset($_POST['img_secundaria']) AND $_POST['img_secundaria']!='' AND $_POST['img_secundaria']!=$dados_imagens['img_secundaria']){
            $nome = clean($produto);
            if ($nome=="") { $nome=$purl_amigavel; }
            $aleatorio = rand(1,999999);
            $nome = "produto-".$id."-".$nome."-secundaria-".$aleatorio;
            $caminho = "../assets/img/".$pagina_referencia."/".$id;
            
            $imagem = $_POST['img_secundaria'];
        	$imagem_array_1 = explode(";", $imagem);
        	$imagem_array_2 = explode(",", $imagem_array_1[1]);
        	$imagem = base64_decode($imagem_array_2[1]);
        	$imagem_nome = $caminho.'/'.$nome.'.png';
        	$nova_imagem = $nome.'.webp';
        
        	file_put_contents($imagem_nome, $imagem);
        	
        	$img = imagecreatefrompng($imagem_nome);
            imagepalettetotruecolor($img);
            imagealphablending($img, true);
            imagesavealpha($img, true);
            $img_produto = imagewebp($img, $caminho.'/'.$nova_imagem, 80);
            unlink($imagem_nome);
            
            $update = "UPDATE $pagina_referencia SET img_secundaria='$nova_imagem' WHERE id='".$id."' "  or die(mysqli_error());
            if (!mysqli_query($conexao, $update)) { die('Erro: '.mysqli_error($conexao)); }
            unlink($caminho.'/'.$dados_imagens['img_secundaria']);
            
        }elseif(isset($_POST['img_secundaria']) AND $_POST['img_secundaria']==''){
            $nova_imagem = 'sem_imagem.jpg';
            $caminho = "../assets/img/".$pagina_referencia."/".$id;
            $update = "UPDATE $pagina_referencia SET img_secundaria='$nova_imagem' WHERE id='".$id."' "  or die(mysqli_error());
            if (!mysqli_query($conexao, $update)) { die('Erro: '.mysqli_error($conexao)); }
            if ($dados_imagens['img_secundaria']!=$nova_imagem){
                unlink($caminho.'/'.$dados_imagens['img_secundaria']);
            }
        }
        
        $numeroCampos = 8;
        $tamanhoMaximo = 1000000;
        $extensoes = array(".png", ".jpg", ".jpeg", ".gif", ".webp");
        $substituir = false;
        $produto = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['produto'], MB_CASE_LOWER, "UTF-8"))));
        $nome = clean($produto);
    
        if ($nome=="") { $nome=$purl_amigavel; }
        for ($i = 0; $i < $numeroCampos; $i++) {
            if (isset($_FILES["arquivo"]["name"][$i])){
        	    $nomeArquivo = strtolower ($_FILES["arquivo"]["name"][$i]);
                $tamanhoArquivo = $_FILES["arquivo"]["size"][$i];
                $nomeTemporario = $_FILES["arquivo"]["tmp_name"][$i];
                $extensao = $_FILES["arquivo"]["type"][$i];
                if ($extensao=="image/gif")
                {
                    $extensao = ".gif";
                }
                elseif ($extensao=="image/jpeg" || $extensao=="image/pjpeg")
                {
                    $extensao = ".jpg";
                }
                elseif ($extensao=="image/png")
                {
                    $extensao = ".png";
                }
                elseif ($extensao=="image/webp")
                {
                    $extensao = ".webp";
                }
                
                $i_temp = $i+1;
                $aleatorio = rand(1,999999);
                $nome_final = $nome."-".$i_temp."-".$aleatorio.$extensao;
                if (!empty($nomeArquivo)) {
                    $erro = false;
        
                    if ($tamanhoArquivo > $tamanhoMaximo) {
                      $erro = "O arquivo " . $nomeArquivo . " não deve ultrapassar " . $tamanhoMaximo. " bytes";
                    } 
                    elseif (!in_array(strrchr($nomeArquivo, "."), $extensoes)) {
                      $erro = "A extensão do arquivo <b>" . $nomeArquivo . "</b> não é válida";
                    } 
                    elseif (file_exists($caminho . $nomeArquivo) and !$substituir) {
                      $erro = "O arquivo <b>" . $nomeArquivo . "</b> já existe";
                    }
                    if (!$erro) {
                        move_uploaded_file($nomeTemporario, ($caminho.$nome_final));
                        $imagem = $caminho.$nome_final;
                        $nome_imagem = explode('.', $nome_final);
                        $nova_imagem = $nome_imagem[0].'.webp';
                        $dir = $caminho;
                        
                        if ($extensao=='.png'){
                            $img = imagecreatefrompng($imagem);
                            imagepalettetotruecolor($img);
                            imagealphablending($img, true);
                            imagesavealpha($img, true);
                            $img_produto = imagewebp($img, $dir.$nova_imagem, 80);
                            unlink($imagem);
                        }elseif($extensao=='.jpg'){
                            $img = imagecreatefromjpeg($imagem);
                            imagepalettetotruecolor($img);
                            imagealphablending($img, true);
                            imagesavealpha($img, true);
                            $img_produto = imagewebp($img, $dir.$nova_imagem, 80);
                            unlink($imagem);
                        }elseif($extensao=='.gif'){
                            rename($nomeTemporario, $dir.$nome_final);
                            $nova_imagem = $nome_final;
                        }elseif($extensao=='.webp'){
                            rename($nomeTemporario, $dir.$nome_final);
                            $nova_imagem = $nome_final;
                        }
                    } 
                    else {
                      echo $erro . "<br/>";
                    }
                }
            }
        }
        
        if ($google_shopping!=''){
            $sql = mysqli_query($conexao, "SELECT id FROM integracoes WHERE rede='".$google_shopping['id']."' AND produto='$id'");
            if (mysqli_num_rows($sql)<1){
                $insert_integracao = mysqli_query($conexao, "INSERT INTO integracoes (produto, rede) VALUES ('$id', '".$google_shopping['id']."')");
                $acaoXml = 'add';
            }else{
                $acaoXml = 'update';
            }
        }else{
            if (isset($_POST['google-shopping-id']) AND $_POST['google-shopping-id']>0){
                $delete_integracao = mysqli_query($conexao, "DELETE FROM integracoes WHERE id='".$_POST['google-shopping-id']."'");
                $acaoXml = 'remove';
            }
        }
        $data = array(
            'arquivo' => 'xml-google-shopping.xml',
            'acao' => $acaoXml,
            'id' => $id
        );

        $result = enviaXml($data);

        if ($catalogo_facebook!=''){
            $sql = mysqli_query($conexao, "SELECT id FROM integracoes WHERE rede='".$catalogo_facebook['id']."' AND produto='$id'");
            if (mysqli_num_rows($sql)<1){
                $insert_integracao = mysqli_query($conexao, "INSERT INTO integracoes (produto, rede) VALUES ('$id', '".$catalogo_facebook['id']."')");
            }
        }else{
            if (isset($_POST['catalogo-facebook-id']) AND $_POST['catalogo-facebook-id']>0){
                $delete_integracao = mysqli_query($conexao, "DELETE FROM integracoes WHERE id='".$_POST['catalogo-facebook-id']."'");
            }
        }

        if ($lojinha_instagram!=''){
            $sql = mysqli_query($conexao, "SELECT id FROM integracoes WHERE rede='".$lojinha_instagram['id']."' AND produto='$id'");
            if (mysqli_num_rows($sql)<1){
                $insert_integracao = mysqli_query($conexao, "INSERT INTO integracoes (produto, rede) VALUES ('$id', '".$lojinha_instagram['id']."')");
            }
        }else{
            if (isset($_POST['lojinha-instagram-id']) AND $_POST['lojinha-instagram-id']>0){
                $delete_integracao = mysqli_query($conexao, "DELETE FROM integracoes WHERE id='".$_POST['lojinha-instagram-id']."'");
            }
        }

        $_SESSION['alerta_mensagem'] = "Atualizado com sucesso!";
        $_SESSION['alerta_tipo'] = "green";
        echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia-editar_$id'>";
        exit;
    }
  }
  if ($acao=="editar") { ?>
    <?
    $sql = "SELECT * FROM $pagina_referencia WHERE id='$id' limit 1";
    $query = mysqli_query($conexao, $sql);
      
    $condicao = mysqli_num_rows($query);
    
    while ($dados = mysqli_fetch_assoc($query)) {
      $id = $dados['id'];
      $img = $dados['img'];
      $img_secundaria = $dados['img_secundaria'];
      $categoria = $dados['categoria'];
      $produto = $dados['produto'];
      $url_amigavel = $dados['url_amigavel'];
      $descricao = ((base64_decode($dados['descricao'])));
      $qtd = $dados['qtd'];
      $qtd_minimo = $dados['qtd_minimo'];
      $qtd_vendido = $dados['qtd_vendido'];
      $qtd_visto = $dados['qtd_visto'];
      $preco = $dados['preco'];
      $por = $dados['por'];
      $qtd_parcela = $dados['qtd_parcela'];
      $valor_parcela = $dados['valor_parcela'];
      $valor_parcela_juros = $dados['valor_parcela_juros'];
      $forma = $dados['forma'];
      $prazo = $dados['prazo'];
      $regiao = $dados['regiao'];
      $promocao = $dados['promocao'];
      $peso = $dados['peso'];
      $altura = $dados['altura'];
      $largura = $dados['largura'];
      $comprimento = $dados['comprimento'];
      $frete = $dados['frete'];
      $pronta = $dados['pronta'];
      $faturamento = $dados['faturamento'];
      $destaque = $dados['destaque'];
      $ordem = $dados['ordem'];
      $ordemdestaque = $dados['destaque_ordem'];
      $sku = $dados['sku'];
      $sistema = $dados['sistema'];
      $ean = $dados['ean'];
      $ncm = $dados['ncm'];
      $fabricante = $dados['fabricante'];
      $avaliacao = $dados['avaliacao_qtd'];
      $informacoes_adicionais = ((isset($dados['informacoes_adicionais']) AND $dados['informacoes_adicionais']!='')?base64_decode($dados['informacoes_adicionais']):'');
      $link_youtube = $dados['link_youtube'];
      $link_compra = $dados['link_compra'];
      $status = $dados['status'];
      $titulo_seo = $dados['Titulo_seo'];
      $desc_seo = $dados['Descricao_seo'];
      $palavras_seo = $dados['palavrasChave_seo'];
      
      if(file_exists("../assets/img/produtos/$img")){ 
        $imagem_exibe = "../assets/img/produtos/$img";
      } elseif ($img=='') {
          $imagem_exibe ="../assets/img/produtos/sem_imagem.jpg";
      } else{ $imagem_exibe = "../assets/img/produtos/sem_imagem.jpg"; }
      
      if(file_exists("../assets/img/produtos/$id/$img_secundaria")){ 
        $img_secundaria_exibe = "../assets/img/produtos/$id/$img_secundaria";
      } elseif ($img_secundaria=='') {
          $img_secundaria_exibe ="../assets/img/produtos/sem_imagem.jpg";
      } else{ $img_secundaria_exibe = "../assets/img/produtos/sem_imagem.jpg"; }
    }
    mysqli_free_result($query);
    ?>
    <div id="wrapper">
        <form method="POST" action="" enctype="multipart/form-data" id="form_produto">
            <div class="row">
                <div class="col-md-12  header-wrapper" style="margin-top:0; display: flex; justify-content: space-between; align-items: flex-end;">
                    <div
                        <h1 class="page-header" style="margin: 0;"><?=mb_convert_case("$pagina_titulo", MB_CASE_TITLE, "UTF-8");?> Editar</h1>
                        <p class="page-subtitle">Para alterar este item, preencha os dados abaixo.</p>
                    </div>
                    <div class="pull-right">
              		    <a href="../produto/<?=$url_amigavel;?>" target="_blank" rel="noopener" title="Visualizar" class="btn btn-warning"><i class="fa fa-eye"></i> VISUALIZAR</a>
            		</div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 ">
              <div class="panel panel-default">
                  <div class="panel-body"> 
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#descritivo" id="li_descritivo" data-toggle="tab" aria-expanded="true"> <span class="fa fa-home icon"></span>DESCRITIVO</a> </li>
                      <li class=""><a href="#imagens" id="li_imagens" data-toggle="tab" aria-expanded="false"> <span class="fa fa-camera icon"></span>IMAGENS</a> </li>
                      <li class=""><a href="#variacoes" id="li_variacoes" data-toggle="tab" aria-expanded="false"> <span class="fa fa-tasks icon"></span>VARIAÇÕES</a> </li>
                      <li class=""><a href="#frete" id="li_frete" data-toggle="tab" aria-expanded="false"> <span class="fa fa-truck icon"></span>FRETE</a> </li>
                      <li class=""><a href="#seo" id="li_seo" data-toggle="tab" aria-expanded="false"> <span class="fa fa-gear icon"></span>SEO</a> </li>
                      <li class=""><a href="#integracoes" id="li_integracoes" data-toggle="tab" aria-expanded="false"> <span class="fa fa-share-alt icon"></span>INTEGRAÇÕES</a> </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="descritivo">
                            <br>
                            <div class="col-md-12"> 
                                <div class="form-group">
                                  <label>CATEGORIA </label>
                                    <select class="form-control" name="categoria">
                                      <?
                                        $sql = "SELECT id, categoria FROM categorias WHERE status='a' ORDER BY categoria ASC";
                                        $query = mysqli_query($conexao, $sql);
                                        $num_rows = mysqli_num_rows($query);
                                        if ($num_rows<1){
                                          echo "<script>alert('Cadastre uma categoria para o produto!');
                                          location.href='categorias-cadastrar';</script>";
                                        }                                     
                                        while ($dados = mysqli_fetch_assoc($query)) {
                                            if ($categoria==$dados['id']) { $selecao = 'selected'; } else { $selecao = ''; }
                                            echo "<option value='".$dados['id']."' $selecao>".$dados['categoria']."</option>";
                                        }
                                        mysqli_free_result($query);
                                      ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12"> 
                                <div class="form-group">
                                  <label>TÍTULO DO PRODUTO</label>
                                    <input name="produto" type="text" required="required" class="form-control" id="produto" maxlength="255" value="<?=$produto;?>">
                                    <input type="hidden" id="tabela" value="produtos">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group" id="form_url_amigavel">
                                  <label>URL AMIGÁVEL</label>
                                  <label class="control-label" for="url_amigavel" style="display:none;" id="label_url_amigavel">Url amigável indisponível</label>
                                  <input name="url_amigavel" type="text" class="form-control" id="url_amigavel" placeholder="Ex: nome-do-produto" maxlength="255" value="<?=$url_amigavel;?>" onkeyup="UrlAmigavel(this.value, 'url_amigavel', '1', <?=$id;?>)">
                                </div>
                            </div>
                            <div class="col-md-3"> 
                                <div class="form-group">
                                  <label>SKU (UNIDADE DE MANUTENÇÃO DE ESTOQUE)</label>
                                    <input name="sku" type="text" class="form-control" id="sku" value="<?=$sku;?>">
                                </div>
                            </div>
                            <div class="col-md-3"> 
                                <div class="form-group">
                                  <label>CÓDIGO DO PRODUTO (SISTEMA)</label>
                                    <input name="sistema" type="text" class="form-control" id="sistema" value="<?=$sistema;?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                  <label>EAN (NÚMERO EUROPEU DO ARTIGO)</label>
                                    <input name="ean" type="text" class="form-control" id="ean" value="<?=$ean;?>">
                                </div>
                            </div>
                            <div class="col-md-3"> 
                                <div class="form-group">
                                  <label>NCM (NOMENCLATURA COMUM DO MERCOSUL)</label>
                                    <input name="ncm" type="text" class="form-control" id="ncm" value="<?=$ncm;?>">
                                </div>
                            </div>
                            <div class="col-md-12"> 
                                <div class="form-group">
                                  <label>LINK P/ COMPRA DIRETA</label>
                                    <input name="link_compra" type="url" class="form-control" id="link_compra" value="<?=$link_compra;?>">
                                </div>
                            </div>
                            <div class="col-md-12"> 
                                <div class="form-group">
                                  <label>DESCRIÇÃO</label>
                                    <textarea class="form-control textarea" rows="4" name="descricao" id="descricao"><?=$descricao;?></textarea>
                                </div>
                            </div>
                            <div class="col-md-3"> 
                                <div class="form-group">
                                  <label>ESTOQUE</label>
                                    <input name="qtd" type="number" required="required" class="form-control" id="qtd" min="0" step="1" value="<?=$qtd;?>">
                                </div>
                            </div>
                            <div class="col-md-3"> 
                                <div class="form-group">
                                  <label>QUANTIDADE MÍNIMA</label>
                                    <input name="qtd_minimo" type="number" required="required" class="form-control" id="qtd_minimo" min="1" step="1" value="<?=$qtd_minimo;?>">
                                </div>
                            </div>
                            <div class="col-md-3"> 
                                <div class="form-group">
                                  <label>VENDIDOS</label>
                                    <input name="qtd_vendido" type="number" class="form-control" id="qtd_vendido" min="0" step="1" value="<?=$qtd_vendido;?>">
                                </div>
                            </div>
                            <div class="col-md-3"> 
                                <div class="form-group">
                                  <label>VISTO</label>
                                    <input name="qtd_visto" type="number" class="form-control" id="qtd_visto" min="0" step="1" value="<?=$qtd_visto;?>">
                                </div>
                            </div>
                            <div class="col-md-3"> 
                                <div class="form-group">
                                  <label>PREÇO</label>
                                    <input name="preco" type="number" required="required" class="form-control" id="preco" min="0" step="0.01" value="<?=$preco;?>">
                                </div>
                            </div>
                            <div class="col-md-3"> 
                                <div class="form-group">
                                  <label>POR</label>
                                    <input name="por" type="number" class="form-control" id="por" min="0" step="0.01" value="<?=$por;?>">
                                </div>
                            </div>
                            <div class="col-md-3"> 
                                <div class="form-group">
                                  <label>ORDEM</label>
                                  <input name="ordem" type="number" class="form-control" placeholder="" min="1" value="<?=$ordem;?>">
                                </div>
                            </div>
                            <div class="col-md-3"> 
                                <div class="form-group">
                                  <label>PROMOÇÃO</label>
                                    <select class="form-control" name="promocao">
                                        <option value='sim' <? if ($promocao=="sim") { echo 'selected'; } ?>>Sim</option>
                                        <option value='nao' <? if ($promocao!="sim") { echo 'selected'; } ?>>Não</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4"> 
                                <div class="form-group">
                                  <label>DESTAQUE</label>
                                    <select class="form-control" name="destaquee">
                                        <option value='sim' <? if ($destaque=="sim") { echo 'selected'; } ?>>Sim</option>
                                        <option value='nao' <? if ($destaque!="sim") { echo 'selected'; } ?>>Não</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4"> 
                                <div class="form-group">
                                  <label>ESTRELAS</label>
                                    <input name="avaliacao" type="number" class="form-control" id="avaliacao" placeholder="Quantidade de estrelas por produtos" value="<?=$avaliacao;?>" step="1" min="0">
                                </div>
                            </div>
                            <div class="col-md-4"> 
                                <div class="form-group">
                                  <label>FABRICANTE</label>
                                    <select class="form-control" name="fabricante">
                                        <?
                                        $sql = "SELECT * FROM fabricante WHERE status='a' ORDER BY titulo ASC";
                                        $query = mysqli_query($conexao, $sql);
                
                                        while ($dados = mysqli_fetch_assoc($query)) {
                                            echo "<option value='".$dados['id']."'>" . $dados['titulo'] . "</option>";
                                        }
                                        mysqli_free_result($query);
                                        ?> 
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4"> 
                                <div class="form-group">
                                  <label>FORMA DE PAGAMENTO</label>
                                    <input name="forma" type="text" class="form-control" id="forma" placeholder="Formas de Pagamento" maxlength="255" value="<?=$forma;?>">
                                </div>
                            </div>
                            <div class="col-md-4"> 
                                <div class="form-group">
                                  <label>PRAZO DE ENTREGA</label>
                                    <input name="prazo" type="text" class="form-control" id="prazo" placeholder="Prazo de Entrega" maxlength="255" value="<?=$prazo;?>">
                                </div>
                            </div>
                            <div class="col-md-4"> 
                                <div class="form-group">
                                  <label>REGIÃO ATENDIDA</label>
                                    <input name="regiao" type="text" class="form-control" id="regiao" placeholder="Região Atendida" maxlength="255" value="<?=$regiao;?>">
                                </div>
                            </div>
                            <div class="col-md-12"> 
                                <div class="form-group">
                                  <label>INFORMAÇÕES ADICIONAIS</label>
                                    <textarea class="form-control textarea" rows="4" id="informacoes_adicionais" name="informacoes_adicionais"><?=$informacoes_adicionais;?></textarea>
                                </div>
                            </div>
                            <div class="col-md-12"> 
                                <div class="form-group">
                                  <label>LINK DO YOUTUBE</label>
                                    <input name="link_youtube" type="url" class="form-control" id="link_youtube" value="<?=$link_youtube;?>" placeholder="Link do produto no Youtube" >
                                </div>
                            </div>
                            <div class="col-md-12"> 
                                <div class="form-group">
                                  <label>STATUS</label>
                                  <select class="form-control" name="status">
                                        <option value='a' <? if ($status=="a") { echo 'selected'; } ?>>Ativo</option>
                                        <option value='d' <? if ($status!="a") { echo 'selected'; } ?>>Desativado</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-12" style="margin-top: 15px;">
                                <div class="pull-right">
                                    <a onclick="$('#li_imagens').click();" data-toggle="tab" aria-expanded="false" class="btn btn-default">SEGUINTE &nbsp;<i class="fa  fa-mail-forward "></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="imagens">
                            <br>
                                <div class="col-lg-12 ">
                                    <div class="panel panel-default ">
                                      <div class="panel-body">
                                      <? if ($condicao<=0) { ?>
                                        <div class="col-md-12"> 
                                          <div class="form-group">
                                            <h3>NÃO LOCALIZAMOS ESTE REGISTRO</h3>
                                            <p>Favor entrar em contato com o seu Administrador</p>
                                          </div>
                                        </div>              
                                      <? } else { ?>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="image_area">
                							        <label for="upload_destaque" style="width: 100%; display: flex; align-items: center;align-items: flex-start;">
                    							        <div class="col-md-4 padding-img-upload">
                        							        <a href="#" data-toggle="modal" data-target="#excluir_destaque" style="position: absolute; left:0; z-index:99;">
                                                                <button type="button" class="btn btn-danger" style="float: right;height: 24px; width: 24px; display: flex; justify-content: center; align-items: center;"><i class='fa fa-trash'></i></button>
                                                            </a>
                                                            <div class="modal fade" id="excluir_destaque" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                              <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                        <h4 class="modal-title" id="myModalLabel3">REMOVER IMAGEM DESTAQUE</h4>
                                                                    </div>
                                                                    <div class="modal-body">Confirma a exclusão da foto desse produto? Após a confirmação o mesmo não poderá ser desfeito. </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" name="excluir_todas_imagens" onclick="$('#uploaded_destaque').attr('src', '../assets/img/<?=$pagina_referencia;?>/sem_imagem.jpg');$('#img_destaque').prop('value', '');$('#upload_destaque').val('');" class="btn btn-danger" data-dismiss="modal" role="button"><i class='fa fa-trash'></i> Sim, desejo excluir</button>
                                                                        <button type="button" class="btn btn-light" data-dismiss="modal">NÃO</button>
                                                                    </div>
                                                                </div>
                                                              </div>
                                                            </div>
                        								    <img src="<?=$imagem_exibe;?>" id="uploaded_destaque" class="img-responsive" style="border: 1px solid #eee; max-height: 130px;"/>
                        								    <input type="file" name="upload_destaque" class="upload_image" id="upload_destaque" data-width="800" data-height="800" style="display:none;">
                        								    <input type="hidden" name="img_destaque" id="img_destaque" value="<?=$img;?>"/>
                        								</div>
                        								<div class="col-md-8">
                    							            <label>DESTAQUE</label>
                    							            <button type="button" onclick="$('#upload_destaque').click();" class="btn btn-success btn-upload">Adicionar </button>
                    							        </div>
                							        </label>
                            					</div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="image_area">
                							        <label for="upload_secundaria" style="width: 100%; display: flex; align-items: center;align-items: flex-start;">
                    							        <div class="col-md-4 padding-img-upload">
                        							        <a href="#" data-toggle="modal" data-target="#excluir_secundaria" style="position: absolute; left:0;">
                                                                <button type="button" class="btn btn-danger" style="float: right;height: 24px; width: 24px; display: flex; justify-content: center; align-items: center;"><i class='fa fa-trash'></i></button>
                                                            </a>
                                                            <div class="modal fade" id="excluir_secundaria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                              <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                        <h4 class="modal-title" id="myModalLabel3">REMOVER IMAGEM SECUNDÁRIA</h4>
                                                                    </div>
                                                                    <div class="modal-body">Confirma a exclusão da foto desse produto? Após a confirmação o mesmo não poderá ser desfeito. </div>
                                                                    <div class="modal-footer">                 
                                                                        <button type="button" name="excluir_todas_imagens" onclick="$('#uploaded_secundaria').attr('src', '../assets/img/<?=$pagina_referencia;?>/sem_imagem.jpg');$('#img_secundaria').prop('value', '');$('#upload_secundaria').val('');" class="btn btn-danger" data-dismiss="modal" role="button"><i class='fa fa-trash'></i> Sim, desejo excluir</button>
                                                                        <button type="button" class="btn btn-light" data-dismiss="modal">NÃO</button>
                                                                    </div>
                                                                </div>
                                                              </div>
                                                            </div>
                        								    <img src="<?=$img_secundaria_exibe;?>" id="uploaded_secundaria" class="img-responsive" style="border: 1px solid #eee; max-height: 130px;"/>
                        								    <input type="file" name="upload_secundaria" class="upload_image" id="upload_secundaria" data-width="800" data-height="800" style="display:none;">
                        								    <input type="hidden" name="img_secundaria" id="img_secundaria" value="<?=$img_secundaria;?>"/>
                        								</div>
                        								<div class="col-md-8">
                    							            <label>SECUNDÁRIA <smal>(Ao passar o mouse)</smal></label>
                    							            <button type="button" onclick="$('#upload_secundaria').click();" class="btn btn-success btn-upload">Adicionar </button>
                    							        </div>
                							        </label>
                            					</div>
                                            </div>
                                        </div>
                            		</div>
                            	</div>
                            </div>
                            <div id="imagens_internas">
                                <div class="col-lg-12">
                                  <div class="panel panel-default ">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group" style="display:flex;">
                                                    <div>
                                                        <label for="file_input_2" class="label-interna">
                                                        <h3 style="margin: 0;">Imagens Internas <small>(Máximo de 8 fotos)</small></h3>
                                                        </label>
                                                        <input type="file"  id="file_input_2" data-preview="preview_2" data-action="preview" accept=".png, .jpeg, .jpg, .pdf"  multiple name="arquivo[]"/>
                                                    </div>
                                                    <button type="button" name="enviar_imagens" id="enviar_imagens" value="enviar_imagens" onclick="enviarImagens('<?=clean($produto);?>', '<?=$img_secundaria;?>')" class="btn btn-success" style="margin-left: 15px; display:none;"><i class="fa fa-upload"></i> Enviar </button>
                                                    <div id="imagens_alerta" style="display:none;"></div>
                                                </div>
                                                <div class="container-internas">
                                                    <div id="preview_2" class="row preview"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <?
                                        $pasta = '../assets/img/produtos/'.$id.'/';
                                        $arquivos = glob("$pasta{*.jpg,*.png,*.gif,*.bmp,*.webp}", GLOB_BRACE);
                                        $arquivos = array_filter($arquivos, function ($arquivo) use ($img_secundaria) {
                                            return basename($arquivo) !== $img_secundaria;
                                        });
                                        $conta = count($arquivos);
                                        ?>
                                        <div class="row" style="display: flex; align-items: flex-end; <?echo (($conta>0)?'':'display:none;');?>" id="excluir_todas_imagens">
                                            <div class="col-md-9">
                                                <p>Veja suas imagens já cadastradas, caso deseje excluir alguma, basta clicar no botão vermelho.</p>
                                            </div>
                                            <div class="col-md-3">
                                                <a href="#" data-toggle="modal" data-target="#myModal_excluir_todas">
                                                    <button type="button" class="btn btn-danger" style="float: right;"><i class='fa fa-trash'></i> Excluir todas as imagens</button>
                                                </a>
                                                <div class="modal fade" id="myModal_excluir_todas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title" id="myModalLabel3">REMOVER TODOS AS FOTOS</h4>
                                                            </div>
                                                            <div class="modal-body">Confirma a exclusão de todos as fotos desse produto? Após a confirmação o mesmo não poderá ser desfeito. </div>
                                                            <div class="modal-footer">
                                                                <form name="deleta_todas_imagens" method="POST" action="">                  
                                                                    <button type="submit" name="excluir_todas_imagens" onclick="ExcluirImagem('excluir_todas_imagens', '', '<?=$id;?>', '<?=$img_secundaria;?>')" class="btn btn-danger" data-dismiss="modal" role="button"><i class='fa fa-trash'></i> Sim, desejo excluir</button>
                                                                </form>
                                                                <button type="button" class="btn btn-light" data-dismiss="modal">NÃO</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?if ($conta>0){?>
                                            <br><br>
                                        <?}?>
                                        <div class="row" id="imagens_internas_produto">
                                        <?
                                        foreach($arquivos as $img){
                                            if($img!=$img_secundaria_exibe){
                                            $aleatorio = rand(1,999999);
                                            
                                            $id_imagem = explode('-', $img);
                                            $id_imagem = end($id_imagem);
                                            $id_imagem = explode('.', $id_imagem);
                                            $id_imagem = $id_imagem[0];
                                        ?>
                                            <div class="col-lg-3 col-md-4 col-sm-6" id="<?=$id_imagem;?>">
                                                <div class="panel panel-default userlist">
                                                    <div class="panel-body text-center">
                                                        <div class="grid-item">
                                                            <a href="<?=$img;?>" rel="gallery-1" class="swipebox" title="<?=$produto;?>">
                                                                <img src="<?=$img;?>" class="productpic" alt="<?=$produto;?>" title="<?=$produto;?>">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="panel-footer"> <a href="#" data-toggle="modal" data-target="#myModal<?=$aleatorio;?>"> <button type="button" class="btn btn-danger" style="float: right;height: 24px; width: 24px; display: flex; justify-content: center; align-items: center; margin-bottom: 10px;"><i class='fa fa-trash'></i></button> </a> </div>
                                                </div>
                                                <div class="modal fade" id="myModal<?=$aleatorio;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                  <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            <h4 class="modal-title" id="myModalLabel3">REMOVER ITEM</h4>
                                                        </div>
                                                        <div class="modal-body">Confirma a exclusão deste item? Após a confirmação o mesmo não poderá ser desfeito. </div>
                                                        <div class="modal-footer">
                                                            <button type="button" onclick="ExcluirImagem('excluir_imagem', '<?=$img;?>', '<?=$id;?>')" class="btn btn-danger" data-dismiss="modal" role="button"><i class='fa fa-trash'></i> Sim, desejo excluir</button>
                                                            <button type="button" class="btn btn-light" data-dismiss="modal">NÃO</button>
                                                        </div>
                                                    </div>
                                                  </div>
                                                </div>
                                            </div>
                                        <?}}
                                          if ($conta<=0) {
                                            echo '<div class="row"><div class="col-md-12"><h3 style="color:#ccc;">Nenhuma imagem cadastrada no momento.</h3></div></div>';
                                          }
                                          ?>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                                <?}?>
                                <br>
                                <div class="col-md-12" style="margin-top: 15px;">
                                    <div class="pull-right">
                                        <a onclick="$('#li_descritivo').click();" data-toggle="tab" aria-expanded="false" class="btn btn-default"><i class="fa fa-reply "></i>&nbsp; ANTERIOR</a>
                                        <a onclick="$('#li_variacoes').click();" data-toggle="tab" aria-expanded="false" class="btn btn-default">SEGUINTE &nbsp;<i class="fa  fa-mail-forward "></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="variacoes">
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="list-group ">
                                        <div class="list-group-item withswitch">
                                            <h5 class="list-group-item-heading">TAMANHO</h5>
                                            <div class="switch">
                                              <input id="check_tamanho" name="check_tamanho" class="cmn-toggle cmn-toggle-round" type="checkbox">
                                              <label for="check_tamanho"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="list-group ">
                                        <div class="list-group-item withswitch">
                                            <h5 class="list-group-item-heading">COR</h5>
                                            <div class="switch">
                                              <input id="check_cor" name="check_cor" value="sim" class="cmn-toggle cmn-toggle-round" type="checkbox">
                                              <label for="check_cor"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <?
                            $sql_tamanho = mysqli_query($conexao, "SELECT * FROM tamanhos WHERE status='a' ORDER BY tamanho ASC");
                            if (mysqli_num_rows($sql_tamanho)>0){
                                $option_tamanho = '';
                                while ($dados_tamanho = mysqli_fetch_assoc($sql_tamanho)){
                                    $option_tamanho .= '<option value="'.$dados_tamanho['id'].'">'.$dados_tamanho['tamanho'].'</option>';
                                }
                            }
                            $sql_cor = mysqli_query($conexao, "SELECT * FROM cores WHERE status='a' ORDER BY cor ASC");
                            if (mysqli_num_rows($sql_cor)>0){
                                $option_cor = '';
                                $contador_cor = 0;
                                while ($dados_cor = mysqli_fetch_assoc($sql_cor)){
                                    $option_cor .= '<option value="'.$dados_cor['id'].'" data-rgb="'.$dados_cor['rgb'].'">'.$dados_cor['cor'].'</option>';
                                    if ($contador_cor==0){
                                        $rgb = $dados_cor['rgb'];
                                        $bg = 'background: '.$dados_cor['rgb'];
                                        $bg_novo = $bg;
                                    }
                                    $contador_cor++;
                                }
                            }

                            $sql_variacoes = mysqli_query($conexao, "SELECT e.id, e.cor AS id_cor, e.tamanho AS id_tamanho, e.qtd, c.rgb, e.img, e.img_ancora, e.ordem, e.operacao, e.tipo, e.valor, e.peso, e.largura, e.altura, e.comprimento, c.cor, t.tamanho FROM cores AS c RIGHT JOIN estoque AS e ON (e.cor=c.id) LEFT JOIN tamanhos AS t ON (e.tamanho=t.id) WHERE e.produto='$id' AND e.status='a' ORDER BY e.id ASC");
                            $num_rows = mysqli_num_rows($sql_variacoes);
                            ?>
                            <div class="row" id="variacao" style="<?=(($num_rows==0)?'display: none;':'');?>">
                                <hr>
                                <div class="col-md-12">
                                    <div class="pull-right mb-15">
                                        <a onclick="novaVariacao();" data-toggle="tab" aria-expanded="false" class="btn btn-success"><i class="fa fa-plus "></i>&nbsp; ADICIONAR VARIAÇÃO</a>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="tabela_variacoes" style="<?=(($num_rows==0)?'display: none;':'');?>">
                                            <thead>
                                                <tr>
                                                    <th id="th_linha">Linha</th>
                                                    <th id="th_tamanho">Tamanho</th>
                                                    <th id="th_cor">Cor</th>
                                                    <th id="th_qtd">Qtd</th>
                                                    <th id="th_ordem">Ordem</th>
                                                    <th id="th_operacao">Operação</th>
                                                    <th id="th_valor">Valor</th>
                                                    <th id="th_tipo">Tipo</th>
                                                    <th id="th_acao">Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody_variacoes">
                                              <?
                                              if ($num_rows>0){
                                              $contador = 1;
                                              $contadorA = 0;
                                              $array_frete = array();
                                              while($dados = mysqli_fetch_assoc($sql_variacoes)){
                                                if ($dados['id_tamanho']>0){
                                                    echo '
                                                    <script>
                                                        $(document).ready(function() {
                                                        $("#check_tamanho").attr("checked", true);
                                                    });
                                                    </script>';
                                                }else{
                                                    echo '
                                                    <script>
                                                        $(document).ready(function() {
                                                        $("#th_tamanho").hide();
                                                    });
                                                    </script>';
                                                }
                                                if ($dados['id_cor']>0){
                                                    echo '
                                                    <script>
                                                        $(document).ready(function() {
                                                        $("#check_cor").attr("checked", true);
                                                        });
                                                    </script>';
                                                }else{
                                                    echo '
                                                    <script>
                                                        $(document).ready(function() {
                                                        $("#th_cor").hide();
                                                    });
                                                    </script>';
                                                }
                                                if ($dados['peso']>0 || $dados['altura']>0 || $dados['largura']>0 || $dados['comprimento']>0){
                                                    $flag_frete = 'sim';
                                                }else{
                                                    $flag_frete = 'nao';
                                                }
                                                $array_frete[$contadorA] = array("id_tamanho" => $dados['id_tamanho'], "tamanho" => $dados['tamanho'], "id_cor" => $dados['id_cor'], "cor" => $dados['cor'], "peso" => $dados['peso'], "altura" => $dados['altura'], "largura" => $dados['largura'], "comprimento" => $dados['comprimento']);
                                              ?>
                                                <input type="hidden" name="estoque[]" id="estoque_<?=$contador;?>" value="<?=$dados['id'];?>">
                                                <tr id="variacao_<?=$contador;?>">
                                                    <td class="align-middle" id="td_linha_<?=$contador;?>"><a href="javascript:void(0)" class="btn btn-circle btn-primary" id="linha_<?=$contador;?>"><?=$contador;?></a></td>
                                                    <td class="align-middle" id="td_tamanho_<?=$contador;?>" <?echo(($dados['id_tamanho']==0)?'style="display: none;"':'');?>>
                                                        <?if ($dados['id_tamanho']>0){?>
                                                          <select class="form-control input-borda" name="tamanho[]" id="tamanho_<?=$contador;?>">
                                                              <?=$option_tamanho;?>
                                                          </select>
                                                          <script>
                                                            $(document).ready(function() {
                                                                $("#tamanho_<?=$contador;?>").find("option[value=<?=$dados['id_tamanho']?>]").attr("selected", true);
                                                            });
                                                          </script>
                                                        <?}?>
                                                    </td>
                                                    <td class="align-middle" id="td_cor_<?=$contador;?>" <?echo(($dados['id_cor']==0)?'style="display: none;"':'');?>>
                                                        <?if ($dados['id_cor']>0){?>
                                                            <div style="display:flex;align-items: center;">
                                                                <?
                                                                if (isset($dados['img']) AND $dados['img']!='' AND file_exists('../assets/img/'.$pagina_referencia.'/cores/'.$dados['img'])){
                                                                    $bg = 'background: url(../assets/img/'.$pagina_referencia.'/cores/'.$dados['img'].')';
                                                                    $img_cor_exibe = "../assets/img/".$pagina_referencia."/cores/".$dados['img'];
                                                                }else{
                                                                    $bg = 'background: '.$dados['rgb'];
                                                                }
                                                                ?>
                                                                <span data-toggle="modal" data-target="#imagem_rgb_<?=$contador;?>" id="img_rgb_<?=$contador;?>" data-rgb="<?=$dados['rgb'];?>" onclick="funcao('imagens_cores', ['<?=$contador;?>'], 'imagens_cores_<?=$contador;?>');" style="height:20px; width:24px; margin-right:5px; border-radius: 50%; <?=$bg;?>; background-size: 100% 100%; background-repeat: no-repeat; cursor: pointer;"></span>
                                                                <div class="modal fade" id="imagem_rgb_<?=$contador;?>" tabindex="-1" role="dialog" aria-labelledby="imagem_rgb_<?=$contador;?>" aria-hidden="true">
                                                                    <div class="modal-dialog modal-lg">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                                <h4 class="modal-title" id="myModalLabel3">FAÇA O UPLOAD DE UMA IMAGEM PARA COR</h4>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <div class="image_area">
                                                            							        <label for="upload_img_cor_<?=$contador;?>" style="width: 100%; display: flex; align-items: center;align-items: flex-start;">
                                                                							        <div class="col-md-2 padding-img-upload">
                                                                    								    <img src="../assets/img/produtos/sem_imagem.jpg" id="uploaded_img_cor_<?=$contador;?>" class="img-responsive" style="border: 1px solid #eee; max-height: 130px;"/>
                                                                    								    <input type="file" name="upload_img_cor_<?=$contador;?>" class="upload_image" id="upload_img_cor_<?=$contador;?>" onchange="setTimeout(function(){$('#img_rgb_<?=$contador;?>').css('background', 'url(' + $('#uploaded_img_cor_<?=$contador;?>').attr('src') + ')').css('background-size', '100% 100%').css('background-repeat', 'no-repeat');}, 2000);$('#enviar_imagens_cores_<?=$contador;?>').show();" data-width="100" data-height="100" style="display:none;">
                                                                    								    <input type="hidden" name="img_cor[]" id="img_cor_<?=$contador;?>" value="<?=((isset($dados['img']) AND isset($img_cor_exibe) AND file_exists($img_cor_exibe))?$img_cor_exibe:'');?>"/>
                                                                    								</div>
                                                                    								<div class="col-md-10">
                                                                							            <label>Faça o upload de uma imagem para cor</label>
                                                                							            <button type="button" onclick="$('#upload_img_cor_<?=$contador;?>').click();" class="btn btn-success btn-upload">Adicionar </button>
                                                                							        </div>
                                                            							        </label>
                                                                        					</div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <button type="button" id="enviar_imagens_cores_<?=$contador;?>" onclick="funcao('envia_imagens_cores', ['<?=$contador;?>', $('#uploaded_img_cor_<?=$contador;?>').attr('src'), '<?=clean($produto);?>'], 'imagens_cores_<?=$contador;?>');$('#uploaded_img_cor_<?=$contador;?>').attr('src', '../assets/img/<?=$pagina_referencia;?>/sem_imagem.jpg');$(this).hide();" class="btn btn-success btn-upload" style="display: none;">Enviar Imagem </button>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row" id="imagens_cores_<?=$contador;?>">
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="$('#img_cor_<?=$contador;?>').prop('value', '');$('#uploaded_img_cor_<?=$contador;?>').attr('src', '../assets/img/<?=$pagina_referencia;?>/sem_imagem.jpg');$('#img_rgb_<?=$contador;?>').css('background', $('#img_rgb_<?=$contador;?>').data('rgb'));$('#uploaded_img_cor_<?=$contador;?>').attr('src', '../assets/img/<?=$pagina_referencia;?>/sem_imagem.jpg');">REMOVER IMAGEM</button>
                                                                                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="cancelar_img_rgb_<?=$contador;?>">CANCELAR</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <select class="form-control input-borda" name="cor[]" id="cor_<?=$contador;?>" onchange="trocaCor('<?=$contador;?>')" onclick="funcao('imagens_internas');">
                                                                    <?=$option_cor;?>
                                                                </select>
                                                            </div>
                                                            <script>
                                                                $(document).ready(function() {
                                                                    $("#cor_<?=$contador;?>").find("option[value=<?=$dados['id_cor']?>]").attr("selected", true);
                                                                });
                                                            </script>
                                                        <?}?>
                                                    </td>
                                                    <td class="align-middle" id="td_qtd_variacao_<?=$contador;?>">
                                                        <input type="number" class="input-borda" name="qtd_variacao[]" id="qtd_variacao_<?=$contador;?>" value="<?=$dados['qtd'];?>" min="0" max="9999">
                                                    </td>
                                                    <td class="align-middle" id="td_ordem_<?=$contador;?>">
                                                        <input type="number" class="input-borda" name="ordem_variacao[]" id="ordem_variacao_<?=$contador;?>" value="<?=$dados['ordem'];?>" min="1" max="9999">
                                                    </td>
                                                    <td class="align-middle" id="td_operacao_<?=$contador;?>">
                                                        <select class="form-control input-borda" name="operacao[]" id="operacao_<?=$contador;?>">
                                                            <option value="1" <?echo((isset($dados['operacao']) AND $dados['operacao']=='1')?'selected':'');?>>+</option>
                                                            <option value="2" <?echo((isset($dados['operacao']) AND $dados['operacao']=='2')?'selected':'');?>>-</option>
                                                        </select>
                                                    </td>
                                                    <td class="align-middle" id="td_valor_<?=$contador;?>">
                                                        <div class="form-group mb-0">
                                                            <input type="text" class="form-control input-borda <?echo((isset($dados['tipo']) AND $dados['tipo']=='1')?'dinheiro':'numero');?>" name="valor[]" id="valor_<?=$contador;?>" value="<?=$dados['valor'];?>">
                                                        </div>
                                                    </td>
                                                    <td class="align-middle" id="td_tipo_<?=$contador;?>">
                                                        <select class="form-control input-borda" name="tipo[]" id="tipo_<?=$contador;?>" onchange="trocaValor(<?=$contador;?>);">
                                                            <option value="1" <?echo((isset($dados['tipo']) AND $dados['tipo']=='1')?'selected':'');?>>Real (R$)</option>
                                                            <option value="2" <?echo((isset($dados['tipo']) AND $dados['tipo']=='2')?'selected':'');?>>Porcentagem (%)</option>
                                                        </select>
                                                    </td>
                                                    <td class="align-middle">
                                                        <a href="#" class="btn btn-circle btn-warning" data-toggle="modal" data-target="#imagem_ancora_<?=$contador;?>" onclick="funcao('imagens_internas', ['<?=$id;?>', '<?=$contador;?>'], 'imagens_internas_<?=$contador;?>');" id="icone_imagem_ancora_<?=$contador;?>"<?echo ((isset($dados['img_ancora']) AND file_exists('../assets/img/produtos/'.$id.'/'.$dados['img_ancora']) AND $dados['img_ancora']!='')?'style="display:none;"':'')?>>
                                                            <i class="fa fa-camera" id="icone_camara_<?=$contador;?>"></i>
                                                        </a>
                                                        <a href="#" class="btn" data-toggle="modal" data-target="#imagem_ancora_<?=$contador;?>" data-contador="<?=$contador;?>" onclick="funcao('imagens_internas', ['<?=$id;?>', '<?=$contador;?>'], 'imagens_internas_<?=$contador;?>');" id="escolhida_imagem_ancora_<?=$contador;?>" style="padding:0; <?echo ((isset($dados['img_ancora']) AND file_exists('../assets/img/produtos/'.$id.'/'.$dados['img_ancora']) AND $dados['img_ancora']!='')?'':'display:none;')?>">
                                                            <img src="<?echo ((isset($dados['img_ancora']) AND file_exists('../assets/img/produtos/'.$id.'/'.$dados['img_ancora']) AND $dados['img_ancora']!='')?'../assets/img/produtos/'.$id.'/'.$dados['img_ancora']:'')?>" id="img_ancora_escolhida_<?=$contador;?>" class="gridpic" style="margin-right:0;">
                                                        </a>
                                                        <input type="hidden" value="<?echo ((isset($dados['img_ancora']) AND file_exists('../assets/img/produtos/'.$id.'/'.$dados['img_ancora']) AND $dados['img_ancora']!='')?'../assets/img/produtos/'.$id.'/'.$dados['img_ancora']:'')?>" name="img_ancora[]" id="img_ancora_<?=$contador;?>">
                                                        <div class="modal fade" id="imagem_ancora_<?=$contador;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                        <h4 class="modal-title" id="myModalLabel3">ESCOLHA UMA IMAGEM ÂNCORA</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row" id="imagens_internas_<?=$contador;?>">
                                                                            
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="$('#img_ancora_escolhida_<?=$contador;?>').attr('src', '');$('#escolhida_imagem_ancora_<?=$contador;?>').hide();$('#img_ancora_<?=$contador;?>').prop('value', '');$('#icone_imagem_ancora_<?=$contador;?>').show();">REMOVER</button>
                                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <!-- /.modal-content --> 
                                                            </div>
                                                            <!-- /.modal-dialog --> 
                                                        </div>
                                                        <button type="button" class="btn btn-circle btn-danger" onclick="excluirVariacao(<?=$contador;?>);" id="remover_<?=$contador;?>"><i class="fa fa-close"></i></button>
                                                    </td>
                                                </tr>
                                                <?
                                                $contador++;
                                                $contadorA++;
                                                }}else{
                                                    $flag_frete='nao';
                                                }?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" value="<?=(($num_rows>0)?$contador-1:'0');?>" id="contador_variacao" name="contador_variacao">
                            <br>
                            <div class="col-md-12" style="margin-top: 15px;">
                                <div class="pull-right">
                                    <a onclick="$('#li_imagens').click();" data-toggle="tab" aria-expanded="false" class="btn btn-default"><i class="fa fa-reply "></i>&nbsp; ANTERIOR</a>
                                    <a onclick="$('#li_frete').click();" data-toggle="tab" aria-expanded="false" class="btn btn-default">SEGUINTE &nbsp;<i class="fa  fa-mail-forward "></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="frete">
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="list-group">
                                        <div class="list-group-item withswitch">
                                            <h5 class="list-group-item-heading">FRETE ÚNICO?</h5>
                                            <div class="switch">
                                              <input id="check_frete" name="check_frete" <?echo((isset($flag_frete) AND $flag_frete=='nao')?'checked':'');?> value="sim" class="cmn-toggle cmn-toggle-round" type="checkbox">
                                              <label for="check_frete"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div id="frete_unico" <?echo((isset($flag_frete) AND $flag_frete=='sim')?'style="display:none;"':'')?>>
                                <div class="col-md-3"> 
                                    <div class="form-group">
                                      <label>PESO (kg)</label>
                                        <input name="peso" type="number" class="form-control" id="peso" min="0" step="0.001" value="<?=$peso;?>">
                                    </div>
                                </div>
                                <div class="col-md-3"> 
                                    <div class="form-group">
                                      <label>ALTURA (cm)</label>
                                        <input name="altura" type="number" class="form-control" id="altura" placeholder="Altura do produto" value="<?=$altura;?>" step="1" min="0" max="100">
                                    </div>
                                </div>
                                <div class="col-md-3"> 
                                    <div class="form-group">
                                      <label>LARGURA (cm)</label>
                                        <input name="largura" type="number" class="form-control" id="largura" placeholder="Largura do produto" value="<?=$largura;?>" step="1" min="0" max="100">
                                    </div>
                                </div>
                                <div class="col-md-3"> 
                                    <div class="form-group">
                                      <label>COMPRIMENTO (cm)</label>
                                        <input name="comprimento" type="number" class="form-control" id="comprimento" placeholder="Comprimento do produto" value="<?=$comprimento;?>" step="1" min="0" max="1000" >
                                    </div>
                                </div>
                            </div>
                            <div id="frete_multi" <?echo((isset($flag_frete) AND $flag_frete=='nao')?'style="display:none;"':'')?>>
                              <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive" id="tabela_frete">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th id="th_frete_linha">Linha</th>
                                                    <th id="th_frete_tamanho">Tamanho</th>
                                                    <th id="th_frete_cor">Cor</th>
                                                    <th id="th_frete_peso">Peso</th>
                                                    <th id="th_frete_altura">Altura</th>
                                                    <th id="th_frete_largura">Largura</th>
                                                    <th id="th_frete_comprimento">Comprimento</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody_frete">
                                              <?
                                              if (isset($array_frete) AND is_array($array_frete)){
                                              $total = count($array_frete);
                                              $count = 1;
                                              foreach ($array_frete as $valor){
                                              ?>
                                                <tr id="frete_<?=$count;?>">
                                                    <td class="align-middle"><a href="javascript:void(0)" class="btn btn-circle btn-primary"><?=$count;?></a></td>
                                                    <?if (isset($valor["id_tamanho"]) AND $valor["id_tamanho"]!='' AND $valor["id_tamanho"]>0 AND isset($valor["tamanho"]) AND $valor["tamanho"]!=''){?>
                                                        <td class="align-middle">
                                                            <select class="form-control input-borda" disabled>
                                                                <option value="<?=$valor["id_tamanho"];?>"><?=$valor["tamanho"];?></option>
                                                            </select>
                                                        </td>
                                                    <?}?>
                                                    <?if (isset($valor["id_cor"]) AND $valor["id_cor"]!='' AND $valor["id_cor"]>0 AND isset($valor["cor"]) AND $valor["cor"]!=''){?>
                                                        <td class="align-middle">
                                                            <select class="form-control input-borda" disabled>
                                                                <option value="<?=$valor["id_cor"];?>"><?=$valor["cor"];?></option>
                                                            </select>
                                                        </td>
                                                    <?}?>
                                                    <td class="align-middle">
                                                        <input name="peso[]" type="number" class="form-control input-borda" min="0" step="0.001" value="<?=$valor["peso"];?>">
                                                    </td>
                                                    <td class="align-middle">
                                                        <input name="altura[]" type="number" class="form-control input-borda" placeholder="Altura" step="1" min="0" max="100" value="<?=$valor["altura"];?>">
                                                    </td>
                                                    <td class="align-middle">
                                                        <input name="largura[]" type="number" class="form-control input-borda" placeholder="Largura" step="1" min="0" max="100" value="<?=$valor["largura"];?>">
                                                    </td>
                                                    <td class="align-middle">
                                                        <input name="comprimento[]" type="number" class="form-control input-borda" placeholder="Comprimento" step="1" min="0" max="1000" value="<?=$valor["comprimento"];?>">
                                                    </td>
                                                </tr>
                                              <?$count++;}}?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="sem_variacao" style="display: none;"></div>
                                </div>
                              </div>
                            </div>
                            <br>
                            <div class="col-md-12" style="margin-top: 15px;">
                                <div class="pull-right">
                                    <a onclick="$('#li_variacoes').click();" data-toggle="tab" aria-expanded="false" class="btn btn-default"><i class="fa fa-reply "></i>&nbsp; ANTERIOR</a>
                                    <a onclick="$('#li_seo').click();" data-toggle="tab" aria-expanded="false" class="btn btn-default">SEGUINTE &nbsp;<i class="fa  fa-mail-forward "></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="seo">
                            <br>
                            <div class="col-md-12"> 
                                <div class="form-group">
                                    <label>TÍTULO DO PRODUTO (SEO)</label>
                                    &nbsp;<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="top" data-content="Títulos curtos com até 60 caracteres tem um melhor posicionamento no Google" data-title="Título SEO" data-trigger="focus" title="" aria-describedby="popover260526" style="line-height: normal; padding: 3px 7px 3px 7px;" tabindex="-1"> ? </button>
                                    &nbsp;<button class="btn btn-danger caracteres" id="caracteres_titulo_seo" tabindex="-1">0 Caracteres</button>
                                    <input name="titulo_seo" type="text" autofocus class="form-control" id="titulo_seo" placeholder="Títulos com até 60 caracteres tem um melhor posicionamento" maxlength="255" value="<?=$titulo_seo;?>" onload="titulo_seo();">
                                </div>
                            </div>  
                            <div class="col-md-12"> 
                                <div class="form-group">
                                    <label>DESCRIÇÃO DO PRODUTO (SEO)</label>
                                    &nbsp;<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="top" data-content="Sugerimos no máximo 156 caracteres sendo os 50 primeiros mais importantes, para um melhor posicionamento no Google" data-title="Descrição SEO" data-trigger="focus" title="" aria-describedby="popover260526" style="line-height: normal; padding: 3px 7px 3px 7px;" tabindex="-1"> ? </button>
                                    &nbsp;<button class="btn btn-danger caracteres" id="caracteres_descricao_seo" tabindex="-1">0 Caracteres</button>
                                    <input name="desc_seo" type="text" autofocus class="form-control" id="descricao_seo" placeholder="Sugerimos no máximo 156 caracteres sendo os 50 primeiros mais importantes" maxlength="255" value="<?=$desc_seo;?>" onload="descricao_seo();">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>PALAVRAS CHAVES DO PRODUTO (SEO)</label>
                                    &nbsp;<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="top" data-content="Palavras relevantes separadas por vírgula, máximo de 200 caracteres, para um melhor posicionamento no Google (Algo que você pesquisaria para encontrar o produto em questão)" data-title="Palavras SEO" data-trigger="focus" title="" aria-describedby="popover260526" style="line-height: normal; padding: 3px 7px 3px 7px;" tabindex="-1"> ? </button>
                                    &nbsp;<button class="btn btn-danger caracteres" id="caracteres_palavras_seo" tabindex="-1">0 Caracteres</button>
                                    <input name="palavras_seo" type="text" autofocus class="form-control" id="palavras_seo" placeholder="Palavras relevantes separadas por vírgula, máximo de 200 caracteres" maxlength="255" value="<?=$palavras_seo;?>" onload="palavras_seo();">
                                </div>
                            </div>
                            <br>
                            <div class="col-md-12" style="margin-top: 15px;">
                                <div class="pull-right">
                                    <a onclick="$('#li_frete').click();" data-toggle="tab" aria-expanded="false" class="btn btn-default"><i class="fa fa-reply "></i>&nbsp; ANTERIOR</a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="integracoes">
                            <br>
                            <div id="row">
                                <?
                                $query_integracoes = mysqli_query($conexao, "SELECT r.id, r.rede, i.rede as id_rede, i.produto, i.id as id_integracao FROM redes as r LEFT JOIN integracoes as i ON (r.id=i.rede) WHERE r.status='a' ORDER BY r.id ASC, CASE WHEN i.produto = $id THEN 0 ELSE 1 END");
                                
                                $redes_processadas = array();
                                
                                if (mysqli_num_rows($query_integracoes) > 0) {
                                    while ($dados_redes = mysqli_fetch_assoc($query_integracoes)) {
                                        if (isset($redes_processadas[$dados_redes['rede']])) {
                                            continue;
                                        }
                                
                                        $redes_processadas[$dados_redes['rede']] = true;
                                
                                        $value = json_encode(array('id' => $dados_redes['id'], 'rede' => $dados_redes['rede'], 'valor' => 'add'));
                                    ?>
                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <div class="list-group-item withswitch">
                                                    <h5 class="list-group-item-heading"><?= $dados_redes['rede']; ?></h5>
                                                    <div class="switch">
                                                        <input id="<?= clean($dados_redes['rede']); ?>" name="<?= clean($dados_redes['rede']); ?>" value='<?= $value; ?>' <? echo (($dados_redes['id_rede'] == $dados_redes['id'] AND $dados_redes['produto'] == $id) ? 'checked' : '') ?> class="cmn-toggle cmn-toggle-round" type="checkbox">
                                                        <label for="<?= clean($dados_redes['rede']); ?>"></label>
                                                        <input id="<?= clean($dados_redes['rede']); ?>-id" name="<?= clean($dados_redes['rede']); ?>-id" value="<? echo (($dados_redes['produto'] == $id) ? $dados_redes['id_integracao'] : ''); ?>" type="hidden">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?
                                    }
                                }
                                ?>

                            </div>
                            <br>
                            <div class="col-md-12" style="margin-top: 15px;">
                                <div class="pull-right">
                                    <a onclick="$('#li_seo').click();" data-toggle="tab" aria-expanded="false" class="btn btn-default"><i class="fa fa-reply"></i>&nbsp; ANTERIOR</a>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
                <div class="col-md-12" >
                    <div class="panel panel-default">
                      <div class="panel-body"> 
                        <div class="row">
                          <div class="col-md-12"> 
                            <div class="form-group">
                              <label></label>
                              <input name="acao" id="acao" value="gravar_editar" type="hidden">
                              <input name="id" id="id" value="<?=$id;?>" type="hidden">
                              <button type="submit" name="enviar" value="enviar" class="btn btn-success" style="float:right;"><i class="fa fa-check"></i> Atualizar </button>
                              <input type="hidden" id="imagem" value="">
                        		<div class="modal fade" id="nova_imagem_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    			  	<div class="modal-dialog modal-lg" role="document">
                    			    	<div class="modal-content">
                    			      		<div class="modal-header">
                    			        		<h5 class="modal-title">Recorte sua imagem para fazer o upload</h5>
                    			        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    			          			<span aria-hidden="true">×</span>
                    			        		</button>
                    			      		</div>
                    			      		<div class="modal-body">
                    			        		<div class="img-container">
                    			            		<div class="row">
                    			                		<div class="col-md-8">
                    			                    		<img src="" id="sample_image"/>
                    			                		</div>
                    			                		<div class="col-md-4">
                    			                    		<div class="preview"></div>
                    			                		</div>
                    			            		</div>
                    			        		</div>
                    			      		</div>
                    			      		<div class="modal-footer" id="modal_rodape">
                    			      			<button type="button" id="crop" class="btn btn-primary">Enviar</button>
                    			        		<button type="button" class="btn btn-default" id="enviando" style="display:none;">Enviando...</button>
                    			        		<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    			      		</div>
                    			    	</div>
                    			  	</div>
                    			</div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
<? }
if ($acao=="clonar") {
    $sql = "INSERT INTO produtos (sku, sistema, img, categoria, produto, url_amigavel, descricao, informacoes_adicionais, link_youtube, link_compra, ordem, qtd, qtd_vendido, qtd_visto, preco, por, qtd_parcela, valor_parcela,valor_parcela_juros, forma, prazo, regiao, promocao, peso, altura, largura, comprimento, pronta, faturamento, destaque, destaque_ordem, fabricante, ip, endereco_ip, data_cadastro, hora_cadastro, data_editar, hora_editar, status, Titulo_seo, Descricao_seo, palavrasChave_seo)
    SELECT sku, sistema, img, categoria, produto, url_amigavel, descricao, informacoes_adicionais, link_youtube, link_compra, ordem, qtd, qtd_vendido, qtd_visto, preco, por, qtd_parcela, valor_parcela,valor_parcela_juros, forma, prazo, regiao, promocao, peso, altura, largura, comprimento, pronta, faturamento, destaque, destaque_ordem, fabricante, ip, endereco_ip, data_cadastro, hora_cadastro, data_editar, hora_editar, status, Titulo_seo, Descricao_seo, palavrasChave_seo FROM produtos WHERE id='$id' LIMIT 1";
    $query = mysqli_query($conexao, $sql);
    $produto_id = mysqli_insert_id($conexao);
    
    $query = $conexao->query("SELECT url_amigavel FROM produtos WHERE id='$produto_id' AND status='a' LIMIT 1");
    $num_rows = $query->num_rows;
    if ($num_rows>0){
        $dados = mysqli_fetch_assoc($query);
        $query = $conexao->query("SELECT url_amigavel FROM produtos WHERE url_amigavel='".$dados['url_amigavel']."' AND status='a'");
        $num_rows = $query->num_rows;
        if ($num_rows>1){
            $url_final = $dados['url_amigavel'].'-'.$produto_id;
            $update = mysqli_query($conexao, "UPDATE produtos SET url_amigavel='$url_final' WHERE id='$produto_id'");
        }
    }
    
    $query = $conexao->query("SELECT img, produto FROM produtos WHERE id='$produto_id' LIMIT 1");
    $num_rows = $query->num_rows;
    
    if ($num_rows > 0) {
        $dados = mysqli_fetch_assoc($query);
        $nome = UrlAmigavel($dados['produto']);
        $caminho_imagem_original = "../assets/img/".$pagina_referencia."/".$dados['img'];
        $caminho_pasta_interna = "../assets/img/".$pagina_referencia."/".$id;
    }
    
    if (!empty($caminho_imagem_original) AND file_exists($caminho_imagem_original)) {
        $aleatorio = rand(1,999999);
        $nome = "produto-".$produto_id."-".$nome."-".$aleatorio.".webp";
        $novo_caminho_imagem = "../assets/img/".$pagina_referencia."/".$nome;
        copy($caminho_imagem_original, $novo_caminho_imagem);

        $update_imagem = mysqli_query($conexao, "UPDATE produtos SET img='$nome' WHERE id='$produto_id'");
    }
    
    if (!empty($caminho_pasta_interna) && is_dir($caminho_pasta_interna)) {
        $caminho_pasta_nova = "../assets/img/".$pagina_referencia."/".$produto_id;

        if (!mkdir($caminho_pasta_nova)) {
            die('Falha ao criar a nova pasta.');
        }
    
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($caminho_pasta_interna, RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::SELF_FIRST);
        foreach ($iterator as $item) {
            if ($item->isDir()) {
                mkdir($caminho_pasta_nova . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
            } else {
                copy($item, $caminho_pasta_nova . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
            }
        }
    }

    $_SESSION['alerta_mensagem'] = "Produto clonado com sucesso!";
    $_SESSION['alerta_tipo'] = "green";
    echo "<meta http-equiv='refresh' content='0;URL=".$pagina_referencia."-editar_".$produto_id."'>";
    exit();
}
if ($acao=="") { ?>
  <div class="row">
    <div class="col-md-12  header-wrapper" >
        <h1 class="page-header"><?=mb_convert_case("$pagina_titulo", MB_CASE_TITLE, "UTF-8");?></h1>
        <p class="page-subtitle">Listagens dos itens cadastrados no sistema.</p>
        <div class="pull-right">
  		    <a href="<?=$pagina_referencia;?>-cadastrar" title="CADASTRAR" class="btn btn-primary">+ CADASTRAR</a>
		</div>
    </div>
  </div>
    <div class="row">
      <div class="col-md-12">
        <table class="table table-bordered table-hover" id="dataTables-userlist">
         <thead>
            <tr>
              <th>ID</th>
              <th>IMAGEM</th>
              <th>PRODUTO</th>
              <th>CATEGORIA</th>
              <th>PREÇO</th>
              <th>AÇÕES</th>
            </tr>
          </thead>
          <tbody>
              <?
              $sql = "SELECT id, categoria FROM categorias WHERE status='a' ORDER BY categoria ASC";
              $query = mysqli_query($conexao, $sql);
                  
              while ($dados = mysqli_fetch_assoc($query)) {
                $id = $dados['id'];
                $categorias[$id] = $dados['categoria'];
              }
              mysqli_free_result($query);
                    
              $sql = "SELECT * FROM $pagina_referencia WHERE status='a' ORDER BY id DESC";
              $query = mysqli_query($conexao, $sql);
                
              $condicao = mysqli_num_rows($query);
              $classe="even ";
                
              while ($dados = mysqli_fetch_assoc($query)) {
                $id = $dados['id'];
                $img = $dados['img'];
                $categoria = $dados['categoria'];
                $produto = $dados['produto'];
                $url_amigavel = $dados['url_amigavel'];
                $descricao = $dados['descricao'];
                $qtd = $dados['qtd'];
                $qtd_vendido = $dados['qtd_vendido'];
                $qtd_visto = $dados['qtd_visto'];
                $preco = $dados['preco'];
                $por = $dados['por'];
                $forma = $dados['forma'];
                $prazo = $dados['prazo'];
                $regiao = $dados['regiao'];
                $promocao = $dados['promocao'];
                $peso = $dados['peso'];
                $frete = $dados['frete'];
                $pronta = $dados['pronta'];
                $faturamento = $dados['faturamento'];
                $destaque = $dados['destaque'];
                $tamanho = $dados['tamanho'];
                $cor = $dados['cor'];
                $sku = $dados['sku'];
                $fabricante = $dados['fabricante'];
                
                if ($dados['img']=='') {
                    $imagem = '../assets/img/'.$pagina_referencia.'/sem_imagem.jpg';
                } elseif(file_exists('../assets/img/'.$pagina_referencia.'/'.$img.'')){
                    $imagem = '../assets/img/'.$pagina_referencia.'/'.$img.'';
                } else {
                    $imagem = "../assets/img/$pagina_referencia/sem_imagem.jpg";
                } 
                if ($classe=="odd") { $classe="even "; } else {$classe="odd"; }
                ?>
                <tr class="<?=$classe;?>">
                    <td class="center">
                        <?=$id;?>
                    </td>
                    <td class="center"><a href="../produto/<?=$url_amigavel;?>" target="_blank" rel="noopener"><img src="<?=$imagem;?>" alt="<?=$produto;?>" title="<?=$produto;?>" class="gridpic"></a></td>
                    <td><?=$produto;?></td>
                    <td><? if (isset($categorias[$categoria])) { echo $categorias[$categoria]; } else { echo "<span class='status btn-danger'>Não Localizada</span>"; };?></td>
                    <td class="center">R$ <? if ($por!='0.00') { echo $por; } else { echo $preco; };?></td>
                    <td>
                        <div class="socials tex-center"> 
                            <a href="../produto/<?=$url_amigavel;?>" target="_blank" rel="noopener" class="btn btn-circle btn-warning" title="Ver"><i class="fa fa-eye"></i></a> 
                            <a href="<?=$pagina_referencia;?>-clonar_<?=$id;?>" class="btn btn-circle btn-success" title="Clonar"><i class="fa fa-clone"></i></a> 
                            <!--<a href="<?=$pagina_referencia;?>-imagem_<?=$id;?>" class="btn btn-circle btn-warning" title="Adicionar Foto"><i class="fa fa-camera"></i></a> -->
                            <a href="<?=$pagina_referencia;?>-editar_<?=$id;?>" class="btn btn-circle btn-primary" title="Editar"><i class="fa fa-pencil"></i></a> 
                            <a href="#" class="btn btn-circle btn-danger " data-toggle="modal" data-target="#myModal<?=$id;?>" title="Excluir"><i class="fa fa-close"></i></a> 
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

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/mode/xml/xml.min.js"></script>
<!-- Include Editor JS files. -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.8.4/js/froala_editor.pkgd.min.js"></script>
<!-- /#wrapper -->
<!-- jQuery --> 
<script src="vendor/jquery/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript --> 
<script src="vendor/bootstrap/js/bootstrap.min.js"></script> 
<!-- DataTables JavaScript --> 
<script src="vendor/datatables/js/jquery.dataTables.min.js"></script> 
<script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script> 
<script src="vendor/datatables-responsive/dataTables.responsive.js"></script> 
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/super-build/ckeditor.js"></script>

<script src="vendor/masonry_swipebox/jquery.swipebox.js"></script>
<script src="vendor/masonry_swipebox/masonry.pkgd.min.js"></script>
<!-- Custom Theme JavaScript --> 
<script src="js/adminnine.js"></script>
<script>
$('.grid').masonry({
  itemSelector: '.grid-item'
});
$('.swipebox').swipebox();
</script>
<script>
<?if ($acao=='cadastrar' || $acao=='editar'){?>
  $(document).ready(function () {
    const inputs = $('input[data-action="preview"]');

    inputs.each(function () {
      const input = $(this);
      const previewId = input.attr('data-preview');
      const preview = $('#' + previewId);

      if (preview.length > 0) {
        input.on('change', loadingPreviewImage);
        input.trigger('change');

        return;
      }

      console.error('O atributo elemento com o id ' + previewId + ' para o preview não foi definido');
    });
  });

  function loadingPreviewImage(event) {
    const input = $(event.target);
    const preview = $('#' + input.attr('data-preview'));

    preview.empty();

    if (input[0].files.length > 0) {
      for (let file of input[0].files) {
        const reader = new FileReader();
        const figure = $('<figure></figure>');
        const figCap = $('<figcaption></figcaption>');

        figCap.text(file.name);
        figure.append(figCap);

        reader.onload = () => {
            const img = $('<img>');

            if (figCap.text().split('.').pop() == 'pdf') {
                img.attr('src', 'pdf.png');
            } else {
                img.attr('src', reader.result);
            }

            const removeBtn = $('<button type="button" class="btn btn-danger" style="float: right;height: 24px; width: 24px; display: flex; justify-content: center; align-items: center; margin-bottom: 10px; position: absolute; top: 75px;"><i class="fa fa-trash"></i></button>');
            removeBtn.on('click', function () {
                removerArquivo(file, input[0]);
                figure.remove();
            });

            figure.prepend(img, removeBtn);
        };

        preview.append(figure);
        reader.readAsDataURL(file);
      }
      $('#enviar_imagens').show();

      return;
    }
}
function removerArquivo(arquivoParaRemover, inputElement) {
    const arquivosSelecionados = Array.from(inputElement.files);
    const novaListaArquivos = arquivosSelecionados.filter((file) => file !== arquivoParaRemover);

    const novoFileList = new DataTransfer();
    novaListaArquivos.forEach((file) => novoFileList.items.add(file));

    inputElement.files = novoFileList.files;
    
    if (novoFileList.files.length === 0) {
        $('#enviar_imagens').hide();
    }
}
function enviarImagens(produto, img_secundaria) {
    const input = $('input[data-action="preview"]');
    const formData = new FormData();

    for (let file of input[0].files) {
      formData.append('imagens[]', file);
    }

    formData.append('diretorio', '<?=$pasta;?>');
    formData.append('produto', produto);
    formData.append('img_secundaria', img_secundaria);

    $.ajax({
        type: 'POST',
        url: 'modulos/<?=$pagina_referencia;?>/envia_imagens_internas.php',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            const responseArray = JSON.parse(response);
            if(responseArray[0].resultado=='sucesso'){
                input.val('');
                $('#' + input.attr('data-preview')).html('');
                funcao('imagens_internas', ['<?=$id;?>', '<?=$img_secundaria;?>'], 'imagens_internas_produto');
                $('#excluir_todas_imagens').show();
            }else{
                $('#imagens_alerta').html('<p style="color: red;">'+responseArray[0].mensagem+'</p>');
                $('#imagens_alerta').show();
                window.setTimeout(function(){
                    $('#imagens_alerta').fadeOut();
                }, 5000);
            }
        },
        error: function (xhr, status, error) {
            console.error('Erro ao enviar as imagens:', error);
        }
    });
  }
function novaVariacao(){
    var contador_atual = parseInt($('#contador_variacao').prop('value'));
    var contador = contador_atual + 1;
    if(contador>0){
       $('#tabela_variacoes').show(); 
    }
    let cor = '<td class="align-middle" id="td_cor_'+contador+'" style="display:none;"></td>';
    let tamanho = '<td class="align-middle" id="td_tamanho_'+contador+'" style="display:none;"></td>';
    if($('#check_tamanho').is(':checked')){
      tamanho = '<td class="align-middle" id="td_tamanho_'+contador+'">'+
                    '<select class="form-control input-borda" name="tamanho[]" id="tamanho_'+contador+'">'+
                        '<?=$option_tamanho;?>'+
                    '</select>'+
                '</td>';
    }else{
      $('#th_tamanho').hide();
    }
    if($('#check_cor').is(':checked')){
        cor = '<td class="align-middle" id="td_cor_'+contador+'">'+
                '<div style="display: flex; align-items: center;">'+
                    '<span data-toggle="modal" data-target="#imagem_rgb_'+contador+'" id="img_rgb_'+contador+'" data-rgb="<?=$rgb;?>" onclick="funcao(\'imagens_cores\', [\''+contador+'\'], \'imagens_cores_'+contador+'\');" style="height:20px; width:24px; margin-right:5px; border-radius: 50%; <?=$bg_novo;?>; background-size: 100% 100%; background-repeat: no-repeat; cursor: pointer;"></span>'+
                    '<div class="modal fade" id="imagem_rgb_'+contador+'" tabindex="-1" role="dialog" aria-labelledby="imagem_rgb_'+contador+'" aria-hidden="true">'+
                        '<div class="modal-dialog modal-lg">'+
                            '<div class="modal-content">'+
                                '<div class="modal-header">'+
                                    '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>'+
                                    '<h4 class="modal-title" id="myModalLabel3">FAÇA O UPLOAD DE UMA IMAGEM PARA COR</h4>'+
                                '</div>'+
                                '<div class="modal-body">'+
                                    '<div class="row">'+
                                        '<div class="col-md-12">'+
                                            '<div class="form-group">'+
                                                '<div class="image_area">'+
                                                    '<label for="upload_img_cor_'+contador+'" style="width: 100%; display: flex; align-items: center;align-items: flex-start;">'+
                                                        '<div class="col-md-2 padding-img-upload">'+
                                                            '<img src="../assets/img/produtos/sem_imagem.jpg" id="uploaded_img_cor_'+contador+'" class="img-responsive" style="border: 1px solid #eee; max-height: 130px;"/>'+
                                                            '<input type="file" name="upload_img_cor_' + contador + '" class="upload_image" id="upload_img_cor_' + contador + '" onchange="setTimeout(function(){$(\'#img_rgb_' + contador + '\').css(\'background\', \'url(\' + $(\'#uploaded_img_cor_' + contador + '\').attr(\'src\') + \')\').css(\'background-size\', \'100% 100%\').css(\'background-repeat\', \'no-repeat\');}, 2000);$(\'#enviar_imagens_cores_' + contador + '\').show();" data-width="100" data-height="100" style="display:none;">'+
                                                            '<input type="hidden" name="img_cor[]" id="img_cor_'+contador+'" value=""/>'+
                                                        '</div>'+
                                                        '<div class="col-md-10">'+
                                                            '<label>Faça o upload de uma imagem para cor</label>'+
                                                            '<button type="button" onclick="$(\'#upload_img_cor_'+contador+'\').click();" class="btn btn-success btn-upload">Adicionar </button>'+
                                                        '</div>'+
                                                    '</label>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="col-md-12">'+
                                            '<button type="button" id="enviar_imagens_cores_'+contador+'" onclick="funcao(\'envia_imagens_cores\', [\''+contador+'\', $(\'#uploaded_img_cor_'+contador+'\').attr(\'src\'), \'<?=clean($produto);?>\'], \'imagens_cores_'+contador+'\');$(\'#uploaded_img_cor_'+contador+'\').attr(\'src\', \'../assets/img/<?=$pagina_referencia;?>/sem_imagem.jpg\');$(this).hide();" class="btn btn-success btn-upload" style="display: none;">Enviar Imagem </button>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="row" id="imagens_cores_'+contador+'">'+
                                    '</div>'+
                                '</div>'+
                                '<div class="modal-footer">'+
                                    '<div class="modal-footer">'+
                                        '<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="$(\'#img_cor_'+contador+'\').prop(\'value\', \'\');$(\'#uploaded_img_cor_'+contador+'\').attr(\'src\', \'../assets/img/<?=$pagina_referencia;?>/sem_imagem.jpg\');$(\'#img_rgb_'+contador+'\').css(\'background\', $(\'#img_rgb_'+contador+'\').data(\'rgb\'));$(\'#uploaded_img_cor_'+contador+'\').attr(\'src\', \'../assets/img/<?=$pagina_referencia;?>/sem_imagem.jpg\');">REMOVER IMAGEM</button>'+
                                        '<button type="button" class="btn btn-danger" data-dismiss="modal" id="cancelar_img_rgb_'+contador+'">CANCELAR</button>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<select class="form-control input-borda" name="cor[]" id="cor_'+contador+'" onchange="trocaCor('+contador+')">'+
                        '<?=$option_cor;?>'+
                    '</select>'+
                '</div>'+
            '</td>';
    }else{
      $('#th_cor').hide();
    }
    $('#contador_variacao').prop('value', contador);
    $('#tbody_variacoes').append(
        '<tr id="variacao_'+contador+'">'+
            '<td class="align-middle" id="td_linha_'+contador+'"><a href="javascript:void(0)" class="btn btn-circle btn-primary" id="linha_'+contador+'">'+contador+'</a></td>'+
            tamanho+
            cor+
            '<td class="align-middle" id="td_qtd_variacao_'+contador+'">'+
                '<input type="number" class="input-borda" name="qtd_variacao[]" id="qtd_variacao_'+contador+'" value="1" min="0" max="9999">'+
            '</td>'+
            '<td class="align-middle" id="td_ordem_variacao_'+contador+'">'+
                '<input type="number" class="input-borda" name="ordem_variacao[]" id="ordem_variacao_'+contador+'" value="100" min="1" max="9999">'+
            '</td>'+
            '<td class="align-middle" id="td_operacao_'+contador+'">'+
                '<select class="form-control input-borda" name="operacao[]" id="operacao_'+contador+'">'+
                    '<option value="1">+</option>'+
                    '<option value="2">-</option>'+
                '</select>'+
            '</td>'+
            '<td class="align-middle" id="td_valor_'+contador+'">'+
                '<div class="form-group mb-0">'+
                    '<input type="text" class="form-control input-borda dinheiro" name="valor[]" id="valor_'+contador+'" value="0">'+
                '</div>'+
            '</td>'+
            '<td class="align-middle" id="td_tipo_'+contador+'">'+
                '<select class="form-control input-borda" name="tipo[]" id="tipo_'+contador+'" onchange="trocaValor('+contador+');">'+
                    '<option value="1">Real (R$)</option>'+
                    '<option value="2">Porcentagem (%)</option>'+
                '</select>'+
            '</td>'+
            '<td class="align-middle">'+
                '<a href="#" class="btn btn-circle btn-warning" data-toggle="modal" data-target="#imagem_ancora_'+contador+'" id="icone_imagem_ancora_'+contador+'">'+
                    '<i class="fa fa-camera" id="icone_camara_'+contador+'"></i>'+
                '</a>'+
                '<a href="#" class="btn" data-toggle="modal" data-target="#imagem_ancora_'+contador+'" data-contador="'+contador+'" id="escolhida_imagem_ancora_'+contador+'" style="padding:0; display:none;">'+
                    '<img src="" id="img_ancora_escolhida_'+contador+'" class="gridpic" style="margin-right:0;">'+
                '</a>'+
                '<input type="hidden" value="" name="img_ancora[]" id="img_ancora_'+contador+'">'+
                '<div class="modal fade" id="imagem_ancora_'+contador+'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'+
                    '<div class="modal-dialog modal-lg">'+
                        '<div class="modal-content">'+
                            '<div class="modal-header">'+
                                '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>'+
                                '<h4 class="modal-title" id="myModalLabel3">ESCOLHA UMA IMAGEM ÂNCORA</h4>'+
                            '</div>'+
                            '<div class="modal-body">'+
                                '<div class="row" id="imagens_internas_'+contador+'">'+funcao('imagens_internas', ['<?=$id;?>', contador], 'imagens_internas_'+contador)+'</div>'+
                            '</div>'+
                            '<div class="modal-footer">'+
                                '<div class="modal-footer">'+
                                    '<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="$(\'#img_ancora_escolhida_' + contador + '\').attr(\'src\', \'\');$(\'#escolhida_imagem_ancora_'+ contador +'\').hide();$(\'#img_ancora_'+ contador +'\').prop(\'value\', \'\');$(\'#icone_imagem_ancora_'+ contador +'\').show();">REMOVER</button>'+
                                    '<button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
                '<button type="button" class="btn btn-circle btn-danger" onclick="excluirVariacao('+contador+');" id="remover_'+contador+'"><i class="fa fa-close"></i></button>'+
            '</td>'+
        '</tr>');
        $('#contador_variacao').prop('value', contador);
}
$('#check_tamanho').change(function(){
    if (this.checked){
        $('#variacao').show();
        var contador = parseInt($('#contador_variacao').prop('value'));
        if (contador>0){
            for (var i = 1; i <= contador; i++){
                $('#td_tamanho_'+i).show();
                if ($('#td_tamanho_'+i).html().length<=1){
                    $('#td_tamanho_'+i).html(
                        '<select class="form-control input-borda" name="tamanho[]" id="tamanho_'+i+'">'+
                            '<?=$option_tamanho;?>'+
                        '</select>'
                    );
                }else{
                    $('#tamanho_'+i).show();
                }
            }
        }
        $('#th_tamanho').show();
    }else{
        if ($('#check_cor').is(':checked')){
            $('#variacao').show();
            var contador = parseInt($('#contador_variacao').prop('value'));
            if (contador>0){
                for (var i = 1; i <= contador; i++){
                    $('#tamanho_'+i).hide();
                    $('#td_tamanho_'+i).hide();
                }
            }
            $('#th_tamanho').hide();
        }else{
            $('#variacao').hide();
        }
    }
});
$('#check_cor').change(function(){
    if (this.checked){
        $('#variacao').show();
        var contador = parseInt($('#contador_variacao').prop('value'));
        if (contador>0){
            for (var i = 1; i <= contador; i++){
                $('#td_cor_'+i).show();
                if ($('#td_cor_'+i).html().length<=1){
                    $('#td_cor_'+i).html(
                        '<select class="form-control input-borda" name="cor[]" id="cor_'+i+'" onchange="trocaCor('+i+')">'+
                            '<?=$option_cor;?>'+
                        '</select>'
                    );
                }else{
                    $('#cor_'+i).show();
                }
            }
        }
        $('#th_cor').show();
    }else{
        if ($('#check_tamanho').is(':checked')){
            $('#variacao').show();
            var contador = parseInt($('#contador_variacao').prop('value'));
            if (contador>0){
                for (var i = 1; i <= contador; i++){
                    $('#cor_'+i).hide();
                    $('#td_cor_'+i).hide();
                }
            }
            $('#th_cor').hide();
        }else{
            $('#variacao').hide();
        }
    }
});
function trocaCor(contador){
    let rgb = $('#cor_'+contador+' option:selected').data('rgb');
    $('#img_rgb_'+contador).css('background', rgb);
}
function excluirVariacao(contador){
  $('#variacao_'+contador).remove();
  var contador_atual = parseInt($('#contador_variacao').prop('value'));
    if (contador_atual>contador){
        for (var i = contador; i <= contador_atual; i++){
            var subtracao = i-1;
            $('#variacao_'+i).attr('id', 'variacao_'+subtracao);
            $('#td_linha_'+i).attr('id', 'td_linha_'+subtracao);
            $('#td_cor_'+i).attr('id', 'td_cor_'+subtracao);
            $('#td_tamanho_'+i).attr('id', 'td_tamanho_'+subtracao);
            $('#td_qtd_variacao_'+i).attr('id', 'td_qtd_variacao_'+subtracao);
            $('#td_operacao_'+i).attr('id', 'td_operacao_'+subtracao);
            $('#td_tipo_'+i).attr('id', 'td_tipo_'+subtracao);
            $('#td_valor_'+i).attr('id', 'td_valor_'+subtracao);
            $('#linha_'+i).html(subtracao).attr('id', 'linha_'+subtracao);
            $('#cor_'+i).attr('id', 'cor_'+subtracao);
            $('#tamanho_'+i).attr('id', 'tamanho_'+subtracao);
            $('#qtd_variacao_'+i).attr('id', 'qtd_variacao_'+subtracao);
            $('#operacao_'+i).attr('id', 'operacao_'+subtracao);
            $('#tipo_'+i).attr('id', 'tipo_'+subtracao);
            $('#valor_'+i).attr('id', 'valor_'+subtracao);
            $('#remover_'+i).attr('id', 'remover_'+subtracao).attr('onclick', 'excluirVariacao('+subtracao+')');
        }
    }
    $('#contador_variacao').prop('value', contador_atual-1);
    if(contador_atual-1==0){
      $('#tabela_variacoes').hide(); 
    }
}
function trocaValor(contador){
  if ($("#valor_"+contador).hasClass("dinheiro")) {
    $("#valor_"+contador).removeClass('dinheiro');
    $("#valor_"+contador).addClass('numero');
    $("#valor_"+contador).prop('value', '0');
  }else{
    $("#valor_"+contador).removeClass('numero');
    $("#valor_"+contador).addClass('dinheiro');
    $("#valor_"+contador).prop('value', '0,00');
  }
}
function UrlAmigavel(valor, tipo, flag, id = 0){
    var tabela = $('#tabela').prop('value');
    $.ajax({
        type: "POST",
        url: "url_amigavel.php",
        data: {
            url_amigavel: tipo,
            valor: valor,
            tabela: tabela,
            id: id
        },
        dataType: "json",
        success: function (dataOK) {
          if (tipo=='url_amigavel'){
            if (dataOK.ok=='sucesso' && dataOK.conteudo!=''){
              $('#form_url_amigavel').removeClass('has-error');
              $('#form_url_amigavel').addClass('has-success');
              $('#label_url_amigavel').html(dataOK.mensagem);
              $('#label_url_amigavel').show();
              $('#url_amigavel').prop('value', dataOK.conteudo);
              if (flag==1){
                $('#url_amigavel').focus();
              }
            }else{
              $('#form_url_amigavel').removeClass('has-success');
              $('#form_url_amigavel').addClass('has-error');
              $('#label_url_amigavel').html(dataOK.mensagem);
              $('#label_url_amigavel').show();
              $('#url_amigavel').prop('value', dataOK.conteudo);
              if (flag==1){
                $('#url_amigavel').focus();
              }
            }
          }else{
            if (dataOK.ok=='sucesso'){
              $('#url_amigavel').prop('value', dataOK.mensagem);
              UrlAmigavel(dataOK.mensagem, 'url_amigavel', 2);
            }
          }
        }
    });
}
function validaFrete(){
  if ($('#check_frete').is(':checked')){
      $('#frete_multi').hide();
      $('#frete_unico').show();
  }else{
      $('#frete_unico').hide();
      $('#frete_multi').show();
      var contador = parseInt($('#contador_variacao').prop('value'));
      if (contador>0){
        $('#sem_variacao').hide();
        $('#tabela_frete').show();
        $('#tbody_frete').html('');
        for(var i = 1; i<=contador; i++){
          let cor = $('#cor_'+i+' option:selected').text();
          let cor_valor = $('#cor_'+i).prop('value');
          let tamanho = $('#tamanho_'+i+' option:selected').text();
          let tamanho_valor = $('#tamanho_'+i).prop('value');
          if ($('#check_tamanho').is(':checked')){
            $('#th_frete_tamanho').show();
          }else{
            $('#th_frete_tamanho').hide();
          }
          if ($('#check_cor').is(':checked')){
            $('#th_frete_cor').show();
          }else{
            $('#th_frete_cor').hide();
          }
          $('#tbody_frete').append(
          '<tr id="frete_'+i+'">'+
              '<td class="align-middle"><a href="javascript:void(0)" class="btn btn-circle btn-primary">'+i+'</a></td>'+
              ($('#check_tamanho').is(':checked') ? 
              '<td class="align-middle">'+
                  '<select class="form-control input-borda" disabled>'+
                      '<option value="'+tamanho_valor+'">'+tamanho+'</option>'+
                  '</select>'+
              '</td>'
               : '')+
               ($('#check_cor').is(':checked') ? 
              '<td class="align-middle">'+
                  '<select class="form-control input-borda" disabled>'+
                      '<option value="'+cor_valor+'">'+cor+'</option>'+
                  '</select>'+
              '</td>'
               :'')+
              '<td class="align-middle">'+
                  '<input name="peso[]" type="number" class="form-control input-borda" min="0" step="0.001" value="0">'+
              '</td>'+
              '<td class="align-middle">'+
                  '<input name="altura[]" type="number" class="form-control input-borda" placeholder="Altura" step="1" min="0" max="100" value="0">'+
              '</td>'+
              '<td class="align-middle">'+
                  '<input name="largura[]" type="number" class="form-control input-borda" placeholder="Largura" step="1" min="0" max="100" value="0">'+
              '</td>'+
              '<td class="align-middle">'+
                  '<input name="comprimento[]" type="number" class="form-control input-borda" placeholder="Comprimento" step="1" min="0" max="1000" value="0">'+
              '</td>'+
          '</tr>');
        }
      }else{
          $('#frete_unico').hide();
          $('#sem_variacao').html('<h3>Adicione variações do produto para continuar!</h3>').show();
          $('#tabela_frete').hide();
          $('#frete_multi').show();
      }
  }
}
$('#check_frete').change(function(){
  validaFrete();
});
$('#li_frete').click(function(){
  validaFrete();
});
CKEDITOR.ClassicEditor.create(document.getElementById("descricao"),{
    toolbar: {
        items: [
            'exportPDF','exportWord', '|',
            'findAndReplace', 'selectAll', '|',
            'heading', '|',
            'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
            'bulletedList', 'numberedList', 'todoList', '|',
            'outdent', 'indent', '|',
            'undo', 'redo',
            '-',
            'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
            'alignment', '|',
            'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
            'specialCharacters', 'horizontalLine', 'pageBreak', '|',
            'textPartLanguage', '|',
            'sourceEditing'
        ],
        shouldNotGroupWhenFull: true
    },
    list: {
        properties: {
            styles: true,
            startIndex: true,
            reversed: true
        }
    },
    heading: {
        options: [
            { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
            { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
            { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
            { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
            { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
            { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
            { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
        ]
    },
    placeholder: 'Digite aqui!',
    fontFamily: {
        options: [
            'default',
            'Arial, Helvetica, sans-serif',
            'Courier New, Courier, monospace',
            'Georgia, serif',
            'Lucida Sans Unicode, Lucida Grande, sans-serif',
            'Tahoma, Geneva, sans-serif',
            'Times New Roman, Times, serif',
            'Trebuchet MS, Helvetica, sans-serif',
            'Verdana, Geneva, sans-serif'
        ],
        supportAllValues: true
    },
    fontSize: {
        options: [ 10, 12, 14, 'default', 18, 20, 22 ],
        supportAllValues: true
    },
    htmlSupport: {
        allow: [
            {
                name: /.*/,
                attributes: true,
                classes: true,
                styles: true
            }
        ]
    },
    htmlEmbed: {
        showPreviews: true
    },
    link: {
        decorators: {
            addTargetToExternalLinks: true,
            defaultProtocol: 'https://',
            toggleDownloadable: {
                mode: 'manual',
                label: 'Downloadable',
                attributes: {
                    download: 'file'
                }
            }
        }
    },
    mention: {
        feeds: [
            {
                marker: '@',
                feed: [
                    '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                    '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                    '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                    '@sugar', '@sweet', '@topping', '@wafer'
                ],
                minimumCharacters: 1
            }
        ]
    },
    removePlugins: [
        'CKBox',
        'CKFinder',
        'EasyImage',
        'RealTimeCollaborativeComments',
        'RealTimeCollaborativeTrackChanges',
        'RealTimeCollaborativeRevisionHistory',
        'PresenceList',
        'Comments',
        'TrackChanges',
        'TrackChangesData',
        'RevisionHistory',
        'Pagination',
        'WProofreader',
        'MathType'
    ]
});
CKEDITOR.ClassicEditor.create(document.getElementById("informacoes_adicionais"),{
    toolbar: {
        items: [
            'exportPDF','exportWord', '|',
            'findAndReplace', 'selectAll', '|',
            'heading', '|',
            'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
            'bulletedList', 'numberedList', 'todoList', '|',
            'outdent', 'indent', '|',
            'undo', 'redo',
            '-',
            'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
            'alignment', '|',
            'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
            'specialCharacters', 'horizontalLine', 'pageBreak', '|',
            'textPartLanguage', '|',
            'sourceEditing'
        ],
        shouldNotGroupWhenFull: true
    },
    list: {
        properties: {
            styles: true,
            startIndex: true,
            reversed: true
        }
    },
    heading: {
        options: [
            { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
            { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
            { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
            { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
            { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
            { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
            { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
        ]
    },
    placeholder: 'Digite aqui!',
    fontFamily: {
        options: [
            'default',
            'Arial, Helvetica, sans-serif',
            'Courier New, Courier, monospace',
            'Georgia, serif',
            'Lucida Sans Unicode, Lucida Grande, sans-serif',
            'Tahoma, Geneva, sans-serif',
            'Times New Roman, Times, serif',
            'Trebuchet MS, Helvetica, sans-serif',
            'Verdana, Geneva, sans-serif'
        ],
        supportAllValues: true
    },
    fontSize: {
        options: [ 10, 12, 14, 'default', 18, 20, 22 ],
        supportAllValues: true
    },
    htmlSupport: {
        allow: [
            {
                name: /.*/,
                attributes: true,
                classes: true,
                styles: true
            }
        ]
    },
    htmlEmbed: {
        showPreviews: true
    },
    link: {
        decorators: {
            addTargetToExternalLinks: true,
            defaultProtocol: 'https://',
            toggleDownloadable: {
                mode: 'manual',
                label: 'Downloadable',
                attributes: {
                    download: 'file'
                }
            }
        }
    },
    mention: {
        feeds: [
            {
                marker: '@',
                feed: [
                    '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                    '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                    '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                    '@sugar', '@sweet', '@topping', '@wafer'
                ],
                minimumCharacters: 1
            }
        ]
    },
    removePlugins: [
        'CKBox',
        'CKFinder',
        'EasyImage',
        'RealTimeCollaborativeComments',
        'RealTimeCollaborativeTrackChanges',
        'RealTimeCollaborativeRevisionHistory',
        'PresenceList',
        'Comments',
        'TrackChanges',
        'TrackChangesData',
        'RevisionHistory',
        'Pagination',
        'WProofreader',
        'MathType'
    ]
});
<?}?>
function mostrarImagem(id, id_destino) {
    var fileInput = document.getElementById(id);
    var file = fileInput.files[0];
    
    if (fileInput.files[0]===''){
        let rgb = $('#'+id_destino).data('rgb');
        $('#'+id_destino).css('background', rgb);
    }else{
        var reader = new FileReader();
    
        reader.onload = function(e) {
            var imgSecundaria = document.getElementById(id_destino);
            imgSecundaria.style.backgroundImage = 'url('+e.target.result+')';
        };
    
        if (file) {
            reader.readAsDataURL(file);
        }
    } 
}

$(document).ready(function() {
    $('[data-toggle="popover"').on('mouseover',function(){
        $(this).popover();
    });
    
	tinymce.init({
		selector: '.tinymce',
		height: 200,
		menubar: false,
		language: 'pt_BR',
		plugins: [
			'link'
		],
		toolbar: 'bold italic underline | bullist numlist | link',
	});
    $('#dataTables-userlist').DataTable({
        responsive: true,
        order: [0, "desc"],
        pageLength:10,
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
<?
$cntACmp = ob_get_contents();
ob_end_clean();
$cntACmp = str_replace("\n", ' ', $cntACmp);
$cntACmp = preg_replace('/[[:space:]]+/', ' ', $cntACmp);
echo $cntACmp;
ob_end_flush();
?>