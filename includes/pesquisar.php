<?php
require_once "config.php";
if (isset($_POST["valor_pesquisar"]) AND $_POST["valor_pesquisar"]!=''){
    $valor_pesquisar = $_POST["valor_pesquisar"];
    $valor_produto = explode(' ', $_POST["valor_pesquisar"]);
    
    if (count($valor_produto)>1){
        $produto = '';
        $contador = 1; 
        foreach ($valor_produto as $valor){
            $produto .=  (($contador>1)?" AND ":"")."P.produto LIKE '%$valor%'";
            $contador++;
        }
    }else{
        $produto = "P.produto LIKE '%$valor_pesquisar%'";
    }
    $sql = $conn->query("SELECT P.id,P.img,P.produto,P.preco,P.por,P.sku,P.sistema,P.qtd,P.url_amigavel,P.categoria FROM produtos AS P INNER JOIN categorias AS C ON(C.id=P.categoria) WHERE P.status='a' AND (($produto) OR C.categoria LIKE '%".$valor_pesquisar."%' OR P.produto LIKE '%".$valor_pesquisar."%' OR P.id LIKE '%".$valor_pesquisar."%' OR P.sku LIKE '%".$valor_pesquisar."%' OR P.sistema LIKE '%".$valor_pesquisar."%' OR P.Descricao_seo LIKE '%".$valor_pesquisar."%') LIMIT 4");

    if ($sql->num_rows>0){
        $conteudo = '';
        while ($dados = $sql->fetch_assoc()) {
            $id = $dados['id'];
            $nome_produto = $dados['produto'];
            $nome_produto = ucwords($nome_produto);
            $preco = $dados['preco'];
            $por = $dados['por'];
            $qtd = $dados['qtd'];
            $sku = $dados['sku'];
            $sistema = $dados['sistema'];
            $img = $dados['img'];
            $url_amigavel = $dados['url_amigavel'];
            $pagina_referencia = 'produtos';
            
            $url = $url_loja."/produto/".$url_amigavel;
            
            if ($dados['img'] == '') {
                $imagem = $url_loja.'/assets/img/'.$pagina_referencia.'/sem_imagem.jpg';
            } elseif (file_exists('../assets/img/'.$pagina_referencia.'/'.$img)) {
                $imagem = $url_loja.'/assets/img/'.$pagina_referencia.'/'.$img;
            } else {
                $imagem = $url_loja.'/assets/img/'.$pagina_referencia.'/sem_imagem.jpg';
            }
            //preco_produto
            if ($preco <= '0.00' && $por <= '0.00') {
                $preco_produto = 'Consulte-nos';
                $exibe_preco = '<span class="price" data-js-product-price><span><span class="money">'.$preco_produto.'</span></span></span>';
            } elseif ($preco > '0.00' && $por <= '0.00') {
                $preco_produto = $preco;
                $exibe_preco = '<span class="price" data-js-product-price><span><span class="money">R$ '.number_format($preco_produto, 2, ',', '.').'</span></span></span>';
            } elseif ($preco <= '0.00' && $por > '0.00') {
                $preco_produto = $por;
                $exibe_preco = '<span class="price" data-js-product-price><span><span class="money">R$ '.number_format($preco_produto, 2, ',', '.').'</span></span></span>';
            } elseif ($preco <= $por) {
                $preco_produto = $preco;
                $exibe_preco = '<span class="price" data-js-product-price><span><span class="money">R$ '.number_format($preco_produto, 2, ',', '.').'</span></span></span>';
            } elseif ($preco > $por) {
                $exibe_preco = '<span class="price price--sale" data-js-product-price><span><span class="money">R$ '.number_format($preco, 2, ',', '.').'</span></span><br><span><span>R$ '.number_format($por, 2, ',', '.').'</span></span></span>';
            } else {
                $preco_produto = $preco;
                $exibe_preco = '<span class="price" data-js-product-price><span><span class="money">R$ '.number_format($preco_produto, 2, ',', '.').'</span></span></span>';
            }
            
            if (isset($preco) && $preco!='' && $preco!='0.00' && $por!='0.00' && $preco>$por) {
                $economize = ($preco - $por);
                $economize_porcentagem = ($preco - $por) / $preco * 100;
                $economize_porcentagem = round($economize_porcentagem);
            }else{
                $economize_porcentagem = '';
            }
            
            $caminho_interno = "../assets/img/".$pagina_referencia."/".$id."/";
            $arquivos = glob("$caminho_interno{*.jpg,*.png,*.gif,*.bmp,*.webp}", GLOB_BRACE);
            if (count($arquivos)>0){
                for($i=0; $i<1; $i++){
                    $img_interna = explode(".", $arquivos[$i]);
                    $img_interna = $url_loja.$img_interna[0]."_{width}x.progressive.".$img_interna[1];
                }
            }else{
                $imagem_interna = str_replace($url_loja."/", "", $imagem);
                $img_interna = explode(".", $imagem);
                $img_interna = $url_loja.$img_interna[0]."_{width}x.progressive.".$img_interna[1];
            }

            $conteudo .= '
            <div class="col-12 col-sm-12 col-md-12 col-lg-3 carrossel-produtos-pesquisa" style="max-width: 276px;">
                <div class="product-collection d-flex flex-column" data-js-product data-js-product-json-preload data-product-handle="'.$id.'" data-product-variant-id="'.$id.'">
                    <div class= product-collection__image product-image product-image--hover-emersion-z position-relative w-100 js-product-images-navigation js-product-images-hovered-end js-product-images-hover" data-js-product-image-hover="'.$img_interna.'" data-js-product-image-hover-id="'.$id.'" style="height: 200px; background-color: #fff;">
                        <a href="'.$url.'" title="'.$nome_produto.'" class="d-block cursor-default" data-js-product-image style="height:100%;">
                            <div class="rimage">
                                <img data-src="'.$imagem.'" data-master="'.$imagem.'" data-aspect-ratio="" data-srcset="'.$imagem.'" data-image-id="'.$id.'" alt="" class="rimage__img rimage__img--contain rimage__img--fade-in lazyload">
                            </div>
                        </a>
                        <div class="product-image__overlay-top position-absolute d-flex flex-wrap top-0 left-0 w-100 px-10 pt-10">';
                            if (isset($economize_porcentagem) AND $economize_porcentagem!=""){
                            $conteudo .= '<div class="product-image__overlay-top-left product-collection__labels position-relative d-flex flex-column align-items-start mb-10">
                                    <a href="'.$url.'" title="'.$nome_produto.'">
                                        <div class="label label--sale mb-3 mr-3 text-nowrap" style="color: white;" data-js-product-label-sale>- '.$economize_porcentagem.'%</div>
                                    </a>
                                </div>';
                            }
                            $conteudo .= '
                        </div>
                    </div>
                    <div class="product-collection__content d-flex flex-column align-items-start pt-15 pl-5 pr-5">
                        <div class="product-collection__title mb-3 w-100">
                            <h4 class="h6 m-0">
                                <a href="'.$url.'" title="'.$nome_produto.'" class="titulo-produto">'.mb_strimwidth("$nome_produto", 0, 80, "...").'</a>
                            </h4>
                        </div>
                        <div class="product-collection__price">
                            <div class="product-collection__price" >
                                <a href="'.$url.'" title="'.$nome_produto.'">
                                    '.$exibe_preco.'
                                </a>
                            </div>
                        </div>
                        <form method="post" action="" accept-charset="UTF-8" class="d-flex flex-column w-100 m-0" enctype="multipart/form-data" data-js-product-form="">
                            <input type="hidden" name="form_type" value="product"/>
                            <input type="hidden" name="utf8" value="✓"/>
                            <div class="product-collection__buttons d-flex flex-column flex-lg-row align-items-lg-center flex-wrap my-lg-15 justify-content-center">
                                <div class="product-collection__buttons-section d-flex">
                                    <a href="'.$url.'" title="VER DETALHES" class="btn btn--status btn--animated botao-detalhes">
                                        <span class="d-flex flex-center">
                                            <i class="btn__icon mr-5 mb-4">
                                                <svg aria-hidden="true" style="fill: #fff !important;" focusable="false" role="presentation" class="icon icon-theme-109" viewBox="0 0 24 24"><path d="M19.884 21.897a.601.601 0 0 1-.439.186h-15a.6.6 0 0 1-.439-.186.601.601 0 0 1-.186-.439v-15a.6.6 0 0 1 .186-.439.601.601 0 0 1 .439-.186h3.75c0-1.028.368-1.911 1.104-2.646.735-.735 1.618-1.104 2.646-1.104s1.911.368 2.646 1.104c.735.736 1.104 1.618 1.104 2.646h3.75a.6.6 0 0 1 .439.186.601.601 0 0 1 .186.439v15a.604.604 0 0 1-.186.439zM18.819 7.083h-3.125v2.5a.598.598 0 0 1-.186.439c-.124.124-.271.186-.439.186s-.315-.062-.439-.186a.6.6 0 0 1-.186-.439v-2.5h-5v2.5a.598.598 0 0 1-.186.439c-.124.124-.271.186-.439.186s-.315-.062-.439-.186a.6.6 0 0 1-.186-.439v-2.5H5.069v13.75h13.75V7.083zm-8.642-3.018a2.409 2.409 0 0 0-.733 1.768h5c0-.69-.244-1.279-.732-1.768s-1.077-.732-1.768-.732-1.279.244-1.767.732z"/></svg>
                                            </i>
                                            <span class="btn__text">VER DETALHES</span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </form>
                        <div class="product-collection__reviews">
                            <div class="spr spr--text-hide spr--empty-hide d-flex flex-column">
                                <span class="shopify-product-reviews-badge" data-id="1463898767412"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            ';
        }
        $retorno["conteudo"] = $conteudo;
    }else{
        $retorno["conteudo"] = '';
    }
    $retorno["sql"] = "SELECT P.id,P.img,P.produto,P.preco,P.por,P.sku,P.sistema,P.qtd,P.url_amigavel,P.categoria FROM produtos AS P INNER JOIN categorias AS C ON(C.id=P.categoria) WHERE P.status='a' AND (($produto) OR C.categoria LIKE '%".$valor_pesquisar."%' OR P.produto LIKE '%".$valor_pesquisar."%' OR P.id LIKE '%".$valor_pesquisar."%' OR P.sku LIKE '%".$valor_pesquisar."%' OR P.sistema LIKE '%".$valor_pesquisar."%' OR P.Descricao_seo LIKE '%".$valor_pesquisar."%') LIMIT 4";

    echo json_encode($retorno);
    exit();
}else{
    echo "<meta http-equiv='refresh' content='0;URL=".$url_loja."'>";
    exit();
}