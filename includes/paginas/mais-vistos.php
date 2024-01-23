<?
    while ($dados_vistos = mysqli_fetch_assoc($query_vistos)) {
        $nome_produto = $dados_vistos['produto'];
        $nome_produto = ucwords($nome_produto);
        $preco = $dados_vistos['preco'];
        $por = $dados_vistos['por'];
        $qtd = $dados_vistos['qtd'];
        $cor = $dados_vistos['cor'];
        $tamanho = $dados_vistos['tamanho'];
        $id = $dados_vistos['id'];
        $sku = $dados_vistos['sku'];
        $sistema = $dados_vistos['sistema'];
        $url_amigavel = $dados_vistos['url_amigavel'];
        $forma = $dados_vistos['forma'];
        $img = $dados_vistos['img'];
        $img_secundaria = $dados_vistos['img_secundaria'];
        $pagina_referencia = 'produtos';
        
        $url = $url_loja."/produto/".$url_amigavel;
        
        if ($dados_vistos['img'] == '') {
            $imagem = 'assets/img/' . $pagina_referencia . '/sem_imagem.jpg';
        } elseif (file_exists('assets/img/'.$pagina_referencia.'/'.$img.'')) {
            $imagem = 'assets/img/'.$pagina_referencia.'/'.$img.'';
        } else {
            $imagem = "assets/img/$pagina_referencia/sem_imagem.jpg";
        }
        
        $caminho_interno = "assets/img/".$pagina_referencia."/".$id."/";

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
        
        $caminho_interno = "assets/img/".$pagina_referencia."/".$id."/";
        
        if (isset($img_secundaria) AND $img_secundaria!='sem_imagem.webp' AND file_exists($caminho_interno.$img_secundaria)){
            $img_secundaria = "assets/img/".$pagina_referencia."/".$id."/".$img_secundaria;
            $img_interna = explode(".", $img_secundaria);
            $img_interna = $url_loja."/".$img_interna[0]."_{width}x.progressive.".$img_interna[1];
        }else{
            $arquivos = glob("$caminho_interno{*.jpg,*.png,*.gif,*.bmp,*.webp}", GLOB_BRACE);
            if (count($arquivos)>0){
                for($i=0; $i<1; $i++){
                    $img_interna = explode(".", $arquivos[$i]);
                    $img_interna = $url_loja."/".$img_interna[0]."_{width}x.progressive.".$img_interna[1];
                }
            }else{
                $img_interna = explode(".", $imagem);
                $img_interna = $imagem;
            }
        }
    ?>
        <div class="col-6 col-sm-6 col-md-4 col-lg-3 carrossel-produtos" style="max-width: 276px;">
            <div class="product-collection d-flex flex-column" data-js-product data-js-product-json-preload data-product-handle="<?=$id;?>" data-product-variant-id="<?=$id;?>" style="max-width: 276px;">
                <div class="div-img-carrossel product-collection__image product-image product-image--hover-emersion-z position-relative w-100 js-product-images-navigation js-product-images-hovered-end js-product-images-hover" data-js-product-image-hover="<?=$img_interna;?>" data-js-product-image-hover-id="<?=$id;?>">
                    <a href="<?=$url;?>" title="<?=$nome_produto;?>" class="d-block cursor-default div-img-carrossel" data-js-product-image>
                        <div class="rimage">
                            <img data-src="<?=$imagem;?>" data-master="<?=$imagem;?>" data-aspect-ratio="" data-srcset="<?=$imagem;?>" data-image-id="<?=$id;?>" alt="" class="rimage__img rimage__img--contain rimage__img--fade-in lazyload">
                        </div>
                    </a>
                    <div class="product-image__overlay-top position-absolute d-flex flex-wrap top-0 left-0 w-100 px-10 pt-10">
                        <?if (isset($economize_porcentagem) AND $economize_porcentagem!=''){?>
                            <div class="product-image__overlay-top-left product-collection__labels position-relative d-flex flex-column align-items-start mb-10">
                                <a href="<?=$url;?>" title="<?=$nome_produto;?>">
                                    <div class="label label--sale mb-3 mr-3 text-nowrap" style="color: white;" data-js-product-label-sale>- <?=$economize_porcentagem;?>%</div>
                                </a>
                            </div>
                        <?}?>
                        <div class="product-image__overlay-top-right product-collection__button-quick-view position-lg-relative d-none d-lg-flex mb-lg-10 ml-lg-auto">
                            <div class="product-collection__button-add-to-wishlist">
                            <?if (isset($_SESSION["usr_id_cliente"]) AND $_SESSION["usr_id_cliente"]>=1){?>
                                <a onclick="Favoritar('<?=$id;?>');" title="Favoritar" style="background-color: <?=$cor_site;?>;" class="button-quick-view pl-0 pr-0 btn btn--text btn--status rounded-circle js-store-lists-add-wishlist" data-js-tooltip data-tippy-content="Favoritar" data-tippy-placement="top" data-tippy-distance="-3">
                            <?}else{?>
                                <a href="#" title="Favoritar" style="background-color: <?=$cor_site;?>;" data-js-popup-button="account" class="button-quick-view pl-0 pr-0 btn btn--text btn--status rounded-circle js-popup-button" data-js-tooltip data-tippy-content="Favoritar" data-tippy-placement="top" data-tippy-distance="-3">
                            <?}?>
                                    <i class="mb-1 ml-1">
                                        <svg style="fill: #fff !important;" aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-180" viewBox="0 0 24 24">
                                            <path d="M21.486 6.599a5.661 5.661 0 0 0-1.25-1.865c-.56-.56-1.191-.979-1.895-1.26a5.77 5.77 0 0 0-4.326 0c-.71.28-1.345.7-1.904 1.26-.026.039-.056.075-.088.107l-.107.107-.107-.107a.706.706 0 0 1-.088-.107c-.56-.56-1.194-.979-1.904-1.26s-1.433-.42-2.168-.42-1.455.14-2.158.42-1.335.7-1.895 1.26c-.547.546-.964 1.168-1.25 1.865s-.43 1.429-.43 2.197.144 1.501.43 2.197.703 1.318 1.25 1.865l7.871 7.871c.003.003.007.004.011.006l.439.436.439-.437c.003-.002.007-.003.01-.006l7.871-7.871c.547-.547.964-1.169 1.25-1.865s.43-1.429.43-2.197-.145-1.5-.431-2.196zm-1.162 3.916a4.436 4.436 0 0 1-.967 1.445l-7.441 7.441-7.441-7.441c-.417-.417-.739-.898-.967-1.445s-.342-1.12-.342-1.719.114-1.172.342-1.719.55-1.035.967-1.465c.442-.43.94-.755 1.494-.977s1.116-.332 1.689-.332a4.496 4.496 0 0 1 3.467 1.641c.098.117.186.241.264.371.117.169.293.254.527.254s.41-.085.527-.254c.078-.13.166-.254.264-.371s.198-.228.303-.332a4.5 4.5 0 0 1 3.164-1.309c.573 0 1.136.11 1.689.332s1.052.547 1.494.977c.417.43.739.918.967 1.465s.342 1.12.342 1.719-.114 1.172-.342 1.719z" />
                                        </svg>
                                    </i>
                                    <i class="mb-1 ml-1" data-button-content="added">
                                        <svg aria-hidden="true" focusable="false" style="fill: white;" role="presentation" class="icon icon-theme-181" viewBox="0 0 24 24">
                                            <path d="M21.861 6.568a5.661 5.661 0 0 0-1.25-1.865c-.56-.56-1.191-.979-1.895-1.26a5.77 5.77 0 0 0-4.326 0c-.71.28-1.345.7-1.904 1.26-.026.039-.056.075-.088.107l-.107.107-.107-.107a.706.706 0 0 1-.088-.107c-.56-.56-1.194-.979-1.904-1.26s-1.433-.42-2.168-.42-1.455.14-2.158.42-1.335.7-1.895 1.26c-.547.547-.964 1.169-1.25 1.865s-.43 1.429-.43 2.197.144 1.501.43 2.197.703 1.318 1.25 1.865l7.871 7.871c.003.003.007.004.011.006l.439.436.439-.437c.003-.002.007-.003.01-.006l7.871-7.871c.547-.547.964-1.169 1.25-1.865s.43-1.429.43-2.197-.145-1.499-.431-2.196z" />
                                        </svg>
                                    </i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-collection__content d-flex flex-column align-items-start pt-15 pl-5 pr-5">
                    <div class="product-collection__title mb-3 w-100">
                        <h4 class="h6 m-0">
                            <a href="<?=$url;?>" title="<?=$nome_produto;?>" class="titulo-produto"><?echo mb_strimwidth("$nome_produto", 0, 80, "...");?></a>
                        </h4>
                    </div>
                    <div class="product-collection__price">
                        <div class="product-collection__price" >
                            <a href="<?=$url;?>" title="<?=$nome_produto;?>">
                                <?=$exibe_preco;?>
                            </a>
                        </div>
                    </div>
                    <form method="post" action="" accept-charset="UTF-8" class="d-flex flex-column w-100 m-0" enctype="multipart/form-data" data-js-product-form="">
                        <input type="hidden" name="form_type" value="product"/>
                        <input type="hidden" name="utf8" value="✓"/>
                        <div class="product-collection__buttons d-flex flex-column flex-lg-row align-items-lg-center flex-wrap my-lg-15 justify-content-center">
                            <div class="product-collection__buttons-section d-flex">
                                <a href="<?=$url;?>" title="VER DETALHES" class="btn btn--status btn--animated botao-detalhes">
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
<? } ?>