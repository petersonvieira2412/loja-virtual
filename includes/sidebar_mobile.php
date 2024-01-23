<div class="collections__sidebar--width-md col-auto d-lg-block" data-sticky-sidebar-parent>
    <div class="js-sticky-sidebar" style="margin-top: 0px; top: 65px; position: sticky;">
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
                                            $cmd = "SELECT id, categoria_pai, categoria, url_amigavel FROM categorias WHERE status='a' AND categoria_pai='0' ORDER BY ordem, categoria ASC";
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
                                                    <input type="text" class="min dinheiro" id="min_preco_mobile" name="min_preco" min="0" step="10" <?echo ((isset($_SESSION['preco']) AND $_SESSION['preco']!='')?'value="'.$_SESSION['preco'][0].'"':'value="0"');?>>
                                                </div>
                                                <div class="col-md-6">
                                                    <span>Máximo R$</span>
                                                    <input type="text" class="max dinheiro" id="max_preco_mobile" name="max_preco" min="50" max="9000" step="10" <?echo ((isset($_SESSION['preco']) AND $_SESSION['preco']!='')?'value="'.$_SESSION['preco'][1].'"':'value="9000.00"');?>>
                                                </div>
                                                <div class="col-md-12">
                                                    <button class="btn btn--secondary btn--full" onclick="Preco('_mobile');">FILTRAR</button>
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
                                                $img = "assets/img/banners/".$dados_banner['img'];
                                                if (!file_exists($img)){
                                                    $img = "assets/img/banners/sem_imagem.jpg";
                                                }
                                            ?>
                                            <div class="w-100">
                                                <a href="<?=$link;?>" title="<?=$titulo;?>" class="w-100">
                                                    <div class="image-animation image-animation--from-default image-animation--to-center image-animation--to-opacity">
                                                        <div class="rimage" style="padding-top:128.1481481%;">
                                                            <img src="<?=$img;?>" class="rimage__img rimage__img--fade-in lazyload" data-master="<?=$img;?>" data-aspect-ratio="0.7803468208092486" data-srcset="<?=$img;?>" data-scale-perspective="1.1" alt="<?=$titulo;?>" titile="<?=$titulo;?>">
                                                        </div>
                                                    </div>
                                                </a>
                                                <div class="promobox__plate position-absolute d-flex flex-column flex-center px-10 py-7 pointer-events-none">
                                                    <p class="promobox__text-line-01 h5 position-relative m-0"><?=$titulo;?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?}mysqli_free_result($sql_banner);?>
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