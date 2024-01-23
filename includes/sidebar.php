<div class="collections__sidebar--width-md col-auto d-lg-block" data-sticky-sidebar-parent style="margin-top: 0px; top: 65px; position: sticky;">
    <div class="js-sticky-sidebar">
        <div data-js-position-desktop="sidebar" data-sticky-sidebar-inner>
            <div id="theme-section-collection-sidebar" class="theme-section">
                <div data-section-id="collection-sidebar" data-section-type="collection-sidebar">
                    <aside class="collection-sidebar js-position js-collection-sidebar" data-js-collection-sidebar data-js-position-name="sidebar">
                        <nav class="collection-sidebar__navigation">
                            <div class="layer-navigation" data-js-collection-nav-section="collections" data-js-accordion="all">
                                <div class="layer-navigation__head pb-10 cursor-pointer open" data-js-accordion-button>
                                    <h5 class="d-flex align-items-center mb-0"><strong>CATEGORIAS</strong>
                                        <i class="layer-navigation__arrow">
                                            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-229" viewBox="0 0 24 24">
                                                <path d="M11.783 14.088l-3.75-3.75a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176l3.301 3.32 3.301-3.32a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176.117.13.176.28.176.449a.652.652 0 0 1-.176.449l-3.75 3.75a.877.877 0 0 1-.215.127.596.596 0 0 1-.468 0 .841.841 0 0 1-.215-.127z"/>
                                            </svg>
                                        </i>
                                    </h5>
                                </div>
                                <div class="layer-navigation__accordion" data-js-accordion-content>
                                    <div class="pt-2 pb-10">
                                        <div class="collections-menu" data-js-collections-menu>
                                            <?
                                            if (isset($onde) AND $onde=='outlet'){
                                                $cmd = "SELECT c.id, c.categoria_pai, c.categoria, c.url_amigavel FROM categorias AS c LEFT JOIN produtos AS p ON (c.id=p.categoria) WHERE c.status='a' AND c.categoria_pai='0' AND p.promocao='sim' GROUP BY c.id ORDER BY c.ordem, c.categoria ASC";
                                            }else{
                                                $cmd = "SELECT id, categoria_pai, categoria, url_amigavel FROM categorias WHERE status='a' AND categoria_pai='0' ORDER BY ordem, categoria ASC";
                                            }
                                            $query = mysqli_query($conn, $cmd);
                                            $total = mysqli_num_rows($query);
                                            
                                            if(mysqli_num_rows($query)>0) {
                                                while ($dadosV = mysqli_fetch_assoc($query)) {
                                                    echo monta_menu($conn, $url_loja, $dadosV['id'], $dadosV['categoria'], $dadosV['url_amigavel'], $onde);
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="border-bottom"></div>
                            </div>
                            <?
                            $sql_variacao = mysqli_query($conn, "SELECT v.id, v.variacao, v.rgb FROM variacoes as v INNER JOIN estoque AS e ON (v.id=e.id_variacao) INNER JOIN produtos AS p ON (e.produto=p.id) WHERE v.titulo='Cor' AND p.status='a' AND v.status='a' AND e.status='a' GROUP BY v.variacao ORDER BY v.variacao ASC");
                            $num_variacao = mysqli_num_rows($sql_variacao);
                            if ($num_variacao>0){
                            ?>
                            <div class="layer-navigation" data-js-collection-nav-section="filters" data-js-accordion="all">
                                <div class="layer-navigation__head py-10 cursor-pointer open" data-js-accordion-button>
                                    <h5 class="d-flex align-items-center mb-0"><strong>COR</strong>
                                        <i class="layer-navigation__arrow">
                                            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-229" viewBox="0 0 24 24">
                                                <path d="M11.783 14.088l-3.75-3.75a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176l3.301 3.32 3.301-3.32a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176.117.13.176.28.176.449a.652.652 0 0 1-.176.449l-3.75 3.75a.877.877 0 0 1-.215.127.596.596 0 0 1-.468 0 .841.841 0 0 1-.215-.127z"/>
                                            </svg>
                                        </i>
                                    </h5>
                                </div>
                                <div class="layer-navigation__accordion" data-js-accordion-content>
                                    <div class="pt-2 pb-10">
                                        <div data-js-collection-replace="filter-1" data-js-collection-replace-only-full>
                                            <div class="collection-filters d-flex flex-wrap" data-js-collection-filters data-property="color">
                                                <?
                                                $contador=0;
                                                while ($dados_variacao=mysqli_fetch_assoc($sql_variacao)){
                                                    $id_variacao = $dados_variacao['id'];
                                                    $variacao = $dados_variacao['variacao'];
                                                    $rgb = $dados_variacao['rgb'];
                                                    if (isset($_SESSION['filtro'])){
                                                        $compara_variacao = array_search($id_variacao, $_SESSION['filtro']);
                                                    }
                                                ?>
                                                <label class="input-checkbox d-flex align-items-center mb-15 mb-lg-10 mr-15 mr-lg-10 input-checkbox--unbordered cursor-pointer">
                                                    <input type="checkbox" class="d-none filtro" name="filtro" value="<?=$id_variacao;?>" <?echo ((isset($_SESSION['filtro']) AND $compara_variacao!==false)?'checked':'');?>>
                                                        <span class="position-relative d-block rounded-circle lazyload" data-value="red" data-bg="none" style="background-color: <?=$rgb;?>; width: 22px; height:22px; border: #2a2a2a 1px solid;" data-js-tooltip="" data-tippy-content="<?=mb_convert_case($variacao, MB_CASE_TITLE, "UTF-8");?>" data-tippy-placement="top" data-tippy-distance="3">
                                                            <i class="d-none standard-color-arrow">
                                                                <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-146" viewBox="0 0 24 24" style="background-color: #ffffff; border-radius: 50%;">
                                                                    <path d="M9.703 15.489l-2.5-2.5a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449.13-.117.28-.176.449-.176s.319.059.449.176l2.051 2.07 5.801-5.82c.13-.117.28-.176.449-.176s.319.059.449.176c.117.13.176.28.176.449a.652.652 0 0 1-.176.449l-6.25 6.25a.877.877 0 0 1-.215.127.596.596 0 0 1-.468 0 .93.93 0 0 1-.215-.127z"/>
                                                                </svg>
                                                            </i>
                                                        </span>
                                                    </label>
                                                <?$contador++;}?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="border-bottom"></div>
                            </div>
                            <?}mysqli_free_result($sql_variacao);
                            $sql_variacao = mysqli_query($conn, "SELECT v.id, v.variacao FROM variacoes AS v INNER JOIN estoque AS e ON (v.id=e.id_variacao) INNER JOIN produtos AS p ON (e.produto=p.id) WHERE v.titulo='Tamanho' AND p.status='a' AND v.status='a' AND e.status='a' GROUP BY v.variacao ORDER BY v.id ASC");
                            $num_variacao = mysqli_num_rows($sql_variacao);
                            if ($num_variacao>0){
                            ?>
                            <div class="layer-navigation" data-js-collection-nav-section="filters" data-js-accordion="all">
                                <div class="layer-navigation__head py-10 cursor-pointer open" data-js-accordion-button>
                                    <h5 class="d-flex align-items-center mb-0"><strong>TAMANHO</strong>
                                        <i class="layer-navigation__arrow">
                                            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-229" viewBox="0 0 24 24">
                                                <path d="M11.783 14.088l-3.75-3.75a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176l3.301 3.32 3.301-3.32a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176.117.13.176.28.176.449a.652.652 0 0 1-.176.449l-3.75 3.75a.877.877 0 0 1-.215.127.596.596 0 0 1-.468 0 .841.841 0 0 1-.215-.127z"/>
                                            </svg>
                                        </i>
                                    </h5>
                                </div>
                                <div class="layer-navigation__accordion" data-js-accordion-content>
                                    <div class="pt-2 pb-10">
                                        <div data-js-collection-replace="filter-2" data-js-collection-replace-only-full>
                                            <div class="collection-filters row" data-js-collection-filters>
                                                <?
                                                $contador=0;
                                                while ($dados_variacao=mysqli_fetch_assoc($sql_variacao)){
                                                    $id_variacao = $dados_variacao['id'];
                                                    $variacao = $dados_variacao['variacao'];
                                                    if (isset($_SESSION['filtro'])){
                                                        $compara_variacao = array_search($id_variacao, $_SESSION['filtro']);
                                                    }
                                                ?>
                                                    <div class="col-6" style="display: flex;">
                                                        <label class="input-checkbox d-flex align-items-center mb-15 cursor-pointer" style="margin-right:0;">
                                                            <input type="checkbox" class="d-none filtro" name="filtro" value="<?=$id_variacao;?>" <?echo ((isset($_SESSION['filtro']) AND $compara_variacao!==false)?'checked':'');?>>
                                                            <span class="position-relative d-block mr-8 border lazyload" data-bg="none">
                                                                <i class="d-none">
                                                                    <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-146" viewBox="0 0 24 24">
                                                                        <path d="M9.703 15.489l-2.5-2.5a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449.13-.117.28-.176.449-.176s.319.059.449.176l2.051 2.07 5.801-5.82c.13-.117.28-.176.449-.176s.319.059.449.176c.117.13.176.28.176.449a.652.652 0 0 1-.176.449l-6.25 6.25a.877.877 0 0 1-.215.127.596.596 0 0 1-.468 0 .93.93 0 0 1-.215-.127z"/>
                                                                    </svg>
                                                                </i>
                                                            </span>
                                                            <span><?=mb_convert_case($variacao, MB_CASE_UPPER, "UTF-8");?></span>
                                                        </label>
                                                    </div>
                                                <?$contador++;}?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="border-bottom"></div>
                            </div>
                            <?}mysqli_free_result($sql_variacao);?>
                            <div class="layer-navigation" data-js-collection-nav-section="filter_by_price" data-js-accordion="all">
                                <div class="layer-navigation__head py-10 cursor-pointer open" data-js-accordion-button>
                                    <h5 class="d-flex align-items-center mb-0"><strong>PREÇO</strong>
                                        <i class="layer-navigation__arrow">
                                            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-229" viewBox="0 0 24 24">
                                                <path d="M11.783 14.088l-3.75-3.75a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176l3.301 3.32 3.301-3.32a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176.117.13.176.28.176.449a.652.652 0 0 1-.176.449l-3.75 3.75a.877.877 0 0 1-.215.127.596.596 0 0 1-.468 0 .841.841 0 0 1-.215-.127z"/>
                                            </svg>
                                        </i>
                                    </h5>
                                </div>
                                <div class="layer-navigation__accordion" data-js-accordion-content>
                                    <div class="pt-2 pb-10">
                                        <div class="collection-filter-by-price">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <span>Mínimo R$</span>
                                                    <input type="text" class="min dinheiro" id="min_preco" name="min_preco" min="0" step="10" <?echo ((isset($_SESSION['preco']) AND $_SESSION['preco']!='')?'value="'.$_SESSION['preco'][0].'"':'value="0"');?>>
                                                </div>
                                                <div class="col-md-6">
                                                    <span>Máximo R$</span>
                                                    <input type="text" class="max dinheiro" id="max_preco" name="max_preco" min="50" max="9000" step="10" <?echo ((isset($_SESSION['preco']) AND $_SESSION['preco']!='')?'value="'.$_SESSION['preco'][1].'"':'value="9000.00"');?>>
                                                </div>
                                                <div class="col-md-12">
                                                    <button class="btn btn--secondary btn--full" onclick="Preco('');">FILTRAR</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="border-bottom"></div>
                            </div>
                            <?
                            $sql_banner = mysqli_query($conn, "SELECT * FROM banners WHERE tipo='lateral' AND status='a' ORDER BY id DESC LIMIT 1");
                            $num_banner = mysqli_num_rows($sql_banner);
                            if ($num_banner>0){
                            ?>
                            <div class="layer-navigation" data-js-collection-nav-section="promobox" data-js-accordion="all">
                                <div class="pt-20"></div>
                                <div class="layer-navigation__accordion" data-js-accordion-content>
                                    <div class="pt-2 pb-10">
                                        <div class="promobox promobox--type-02 position-relative d-flex flex-column align-items-center text-center">
                                             <?
                                                $dados_banner = mysqli_fetch_assoc($sql_banner);

                                                $titulo = $dados_banner['titulo'];
                                                $link = $dados_banner['link'];
                                                $img = '/assets/img/banners/'.$dados_banner['img'];
                                                
                                                if (file_exists($img)){
                                                    $img_banner_lateral = $url_loja."/".$img;
                                                }else{
                                                    $img_banner_lateral = $url_loja."/assets/img/banners/sem_imagem.jpg";
                                                }
                                            ?>
                                            <div class="w-100">
                                                <a href="<?=$link;?>" title="<?=$titulo;?>" class="w-100" target="_blank" rel="noopener">
                                                    <div class="image-animation image-animation--from-default image-animation--to-center image-animation--to-opacity">
                                                        <div class="rimage" style="padding-top:100%;">
                                                            <img src="<?=$img_banner_lateral;?>" class="rimage__img rimage__img--fade-in lazyload" data-master="<?=$img;?>" data-aspect-ratio="0.7803468208092486" data-srcset="<?=$img;?>" data-scale-perspective="1.1" alt="<?=$titulo;?>" titile="<?=$titulo;?>">
                                                        </div>
                                                    </div>
                                                </a>
                                                <? if (isset($titulo) AND $titulo!=''){ ?>
                                                <div class="promobox__plate position-absolute d-flex flex-column flex-center px-10 py-7 pointer-events-none">
                                                    <p class="promobox__text-line-01 h5 position-relative m-0"><?=$titulo;?></p>
                                                </div>
                                                <? } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?}mysqli_free_result($sql_banner);?>
                            <div class="layer-navigation d-none d-lg-block" data-js-collection-nav-section="products" data-js-accordion="all">
                                <div class="layer-navigation__head py-10 cursor-pointer" data-js-accordion-button>
                                    <h5 class="d-flex align-items-center mb-0"><strong>MAIS DESEJADOS</strong>
                                    <i class="layer-navigation__arrow">
                                        <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-229" viewBox="0 0 24 24">
                                            <path d="M11.783 14.088l-3.75-3.75a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176l3.301 3.32 3.301-3.32a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176.117.13.176.28.176.449a.652.652 0 0 1-.176.449l-3.75 3.75a.877.877 0 0 1-.215.127.596.596 0 0 1-.468 0 .841.841 0 0 1-.215-.127z"/>
                                        </svg>
                                    </i>
                                    </h5>
                                </div>
                                <div class="layer-navigation__accordion" data-js-accordion-content>
                                    <div class="pt-2 pb-10">
                                        <div class="collection-sidebar-offers">
                                               <?
                								$sqlV = "SELECT id,img,produto,por,preco,url_amigavel FROM produtos WHERE status='a' ORDER BY qtd_visto DESC LIMIT 3";
                								$queryV = mysqli_query($conn,$sqlV);
                                                $num_rows_side = mysqli_num_rows($queryV);
                								if($num_rows_side>0){
                                                $contador_sidebar = 1;
                							  while ($dadosV = mysqli_fetch_assoc($queryV)) {
                								$nome_produto = $dadosV['produto'];
                                                $nome_produto = ucwords($nome_produto);
                                                $preco = $dadosV['preco'];
                                                $por = $dadosV['por'];
                                                $id = $dadosV['id'];
                                                $img = $dadosV['img'];
                                                $url_amigavel = $dadosV['url_amigavel'];
                                                $pagina_referencia = 'produtos';
                                                
                                                $url = $url_loja."/produto/".$url_amigavel;
                                                
                                                if ($dadosV['img'] == '') {
                                                    $imagem = $url_loja.'/assets/img/'.$pagina_referencia.'/sem_imagem.jpg';
                                                } elseif (file_exists('assets/img/'.$pagina_referencia.'/'.$img.'')) {
                                                    $imagem = $url_loja.'/assets/img/'.$pagina_referencia.'/'.$img.'';
                                                } else {
                                                    $imagem = $url_loja.'/assets/img/'.$pagina_referencia.'/sem_imagem.jpg';
                                                }
                                                
                                                $caminho_interno = "assets/img/".$pagina_referencia."/".$id."/";
                                                $arquivos = glob("$caminho_interno{*.jpg,*.png,*.gif,*.bmp,*.webp}", GLOB_BRACE);
                                                if (count($arquivos)>0){
                                                    for($i=0; $i<1; $i++){
                                                        $img_interna = explode(".", $arquivos[$i]);
                                                        $img_interna = $url_loja."/".$img_interna[0]."_{width}x.progressive.".$img_interna[1];
                                                    }
                                                }else{
                                                    $imagem_interna = str_replace($url_loja."/", "", $imagem);
                                                    $img_interna = explode(".", $imagem_interna);
                                                    $img_interna = $url_loja."/".$img_interna[0]."_{width}x.progressive.".$img_interna[1];
                                                }
                                        
                                                //preco_produto
                                                if ($preco <= '0.00' && $por <= '0.00') {
                                                    $preco_produto = 'Consulte-nos';
                                                    $exibe_preco = '<span  class="price" data-js-product-price><span><span class="money" style="font-size: 21px;">'.$preco_produto.'</span></span></span>';
                                                } elseif ($preco > '0.00' && $por <= '0.00') {
                                                    $preco_produto = $preco;
                                                    $exibe_preco = '<span  class="price" data-js-product-price><span><span class="money" style="font-size: 21px;">R$ '.number_format($preco_produto, 2, ',', '.').'</span></span></span>';
                                                } elseif ($preco <= '0.00' && $por > '0.00') {
                                                    $preco_produto = $por;
                                                    $exibe_preco = '<span  class="price" data-js-product-price><span><span class="money" style="font-size: 21px;">R$ '.number_format($preco_produto, 2, ',', '.').'</span></span></span>';
                                                } elseif ($preco <= $por) {
                                                    $preco_produto = $preco;
                                                    $exibe_preco = '<span  class="price"  data-js-product-price><span><span class="money" style="font-size: 21px;">R$ '.number_format($preco_produto, 2, ',', '.').'</span></span></span>';
                                                } elseif ($preco > $por) {
                                                    $exibe_preco = '<span class="price price--sale" style="display: flex; flex-direction: column; align-items: flex-start;" data-js-product-price><span><span class="money" style="font-size: 11px;">R$ '.number_format($preco, 2, ',', '.').'</span></span><span><span style="font-size: 21px;">R$ '.number_format($por, 2, ',', '.').'</span></span></span>';
                                                } else {
                                                    $preco_produto = $preco;
                                                    $exibe_preco = '<span   class="price" data-js-product-price><span><span class="money" style="font-size: 21px;">R$ '.number_format($preco_produto, 2, ',', '.').'</span></span></span>';
                                                }
                							 ?>
                                            <div class="product-featured d-flex flex-row align-items-start <?if($contador_sidebar==$num_rows_side){echo 'mb-10';}?>" style="height: 100px;">
                                                <div class="product-featured__image mr-20 js-product-images-hovered-end js-product-images-hover" data-js-product-image-hover="<?=$img_interna;?>" data-js-product-image-hover-id="<?=$id;?>" style="height: 100px;">
                                                    <a href="<?=$url;?>" class="d-block" title="<?=$nome_produto;?>" style="height: 100px;">
                                                        <div class="rimage" style="padding-top:100%;" style="height: 100px;">
                                                            <img src="<?=$imagem;?>" class="rimage__img rimage__img--fade-in lazyload" data-master="<?=$imagem;?>" data-aspect-ratio="0.7798440311937612" data-srcset="<?=$imagem;?>" alt="<?=$nome_produto;?>" title="<?=$nome_produto;?>">
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="product-featured__content d-flex flex-column align-items-start">
                                                    <div class="product-featured__title mb-3">
                                                        <a href="<?=$url;?>" class="d-block" title="<?=$nome_produto;?>">
                                                            <h3 class="h6 mb-5">
                                                                <?echo mb_strimwidth("$nome_produto", 0, 50, "...");?>
                                                            </h3>
                                                        </a>
                                                    </div>
                                                    <div class="product-featured__price mb-10">
                                                        <a href="<?=$url;?>"  title="<?=$nome_produto;?>"><?=$exibe_preco;?></a>
                                                    </div>
                                                    <div class="product-featured__reviews">
                                                        <div class="spr spr--text-hide spr--empty-hide d-flex flex-column">
                                                            <span class="shopify-product-reviews-badge" data-id="1463888117812"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?if($contador_sidebar<$num_rows_side){?>
                                                <div class="border-bottom my-10"></div>
                                            <?}?>
                                            <?$contador_sidebar++;}}?>
                                        </div>
    
                                    </div>
                                </div>
                                <div class="border-bottom"></div>
                            </div>
                        </nav>
                    </aside>
                </div>
                <script>
                    Loader.require({
                        type: "script",
                        name: "collection_sidebar"
                    });
                </script>
            </div>
        </div>
    </div>
</div>
<script>
    Loader.require({
        type: "script",
        name: "plugin_sticky_sidebar"
    });

    Loader.require({
        type: "script",
        name: "sticky_sidebar"
    });
</script>
<script type="text/javascript">
$('.categoria').each(function(){
  $('.categoria').click(function() {
    if ($("input[type='radio'][name='categoria']").is(':checked') ){
      location.href=$(this).prop('value');
    }
  });
}); 
</script>