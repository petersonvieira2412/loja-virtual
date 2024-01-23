<?
ob_start();
require_once "includes/config.php";
$onde = 'home';
if (!isset($titulo_site) || $titulo_site==''){$titulo_site = '';}
if (!isset($descricao_site) || $descricao_site==''){$descricao_site = '';}
if (!isset($meta_site) || $meta_site==''){$meta_site= '';}
?>
<!doctype html>
<html class="no-js supports-no-cookies" lang="pt-br">
<head>
    <?require_once "includes/head.php";?>
</head>
<body id="index" class="template-index theme-css-animate" data-currency-multiple="true">
<?
if (isset($_SESSION['tag_manager_body']) AND $_SESSION['tag_manager_body']!='') {
	echo $_SESSION['tag_manager_body'];
}
?>
<div id="theme-section-header" class="theme-section">
    <div data-section-id="header" data-section-type="header">
        <header id="header" class="header position-lg-relative js-header-sticky" data-js-sticky="desktop_and_mobile" data-js-desktop-sticky-sidebar="true">
            <?require_once "includes/header.php";?>
        </header>
    </div>
    <script>Loader.require({
        type: "script",
        name: "sticky_header"
    });
    Loader.require({
        type: "script",
        name: "header"
    });
    </script>
</div>
<main id="MainContent">
    <!-- BEGIN content_for_index -->
    <div id="theme-section-1551844786848" class="theme-section" style="text-align: -webkit-center;">
        <div data-section-id="1551844786848" data-section-type="home-builder" style="width: 100%; max-width: 1200px;">
            <div class="overflow-x-hidden">
                <div class="row mt-0 mb-0 justify-content-start align-items-start">
                    <div class="col-12 col-md-12 mt-0 mb-0">
                        <div class="slider position-relative">
                            <div class="slider__prev d-none d-lg-block position-absolute cursor-pointer" data-js-slider-prev style="background-color: #78787880;">
                                <i>
                                    <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-006" viewBox="0 0 24 24">
                                        <path d="M16.736 3.417a.652.652 0 0 1-.176.449l-8.32 8.301 8.32 8.301c.117.13.176.28.176.449s-.059.319-.176.449a.91.91 0 0 1-.215.127c-.078.032-.156.049-.234.049s-.156-.017-.234-.049a.93.93 0 0 1-.215-.127l-8.75-8.75a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449l8.75-8.75a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176.117.13.176.28.176.449z"/>
                                    </svg>
                                </i>
                            </div>
                            <div class="slider__slick" data-js-slider-slick data-arrows="true" data-bullets="true" data-speed="7">
                                <?
                                $sql_slide = mysqli_query($conn, "SELECT * FROM destaque WHERE status='a' AND (CASE WHEN data_fim>data_inteiro THEN data_inteiro<='".date('Y-m-d H:i:s')."' AND data_fim>='".date('Y-m-d H:i:s')."' ELSE data_inteiro<='".date('Y-m-d H:i:s')."' END) ORDER BY ordem ASC, id DESC");
                                $num_slide = mysqli_num_rows($sql_slide);
                                
                                if ($num_slide>0){
                                    while ($dados_slide = mysqli_fetch_assoc($sql_slide)){
                                        $data_inteiro = $dados_slide['data_inteiro'];
                                        $link = $dados_slide['url'];
                                        $titulo = $dados_slide['titulo'];
                                        $chamada = $dados_slide['chamada'];
                                        $tipo = $dados_slide['tipo'];
                                        $cor = $dados_slide['cor'];
                                        $flag = $dados_slide['flag'];
                                        if ($flag=='i'){
                                            $img = $url_loja."/assets/img/destaque/imagens/".$dados_slide['img'];
                                        }else{
                                            $img = $url_loja."/assets/img/destaque/videos/".$dados_slide['img'];
                                        }
                                ?>
                                    <a href="<?=$link;?>" title="<?=$titulo;?>" <?echo ((isset($tipo) AND $tipo=='externo')?'target="_blank" rel="noopener"':'');?>>
                                        <div class="slider__slide media-slider">
                                            <div class="promobox promobox--type-07 promobox--is-slider position-relative d-flex flex-column align-items-center text-center overflow-hidden">
                                                <div class="image-animation-trigger w-100">
                                                    <div class="w-100">
                                                        <div class="image-animation image-animation--from-default image-animation--to-default">
                                                            <div class="rimage slider-home" style="max-height: 400px;">
                                                                <div class="d-sm-none" style="padding-top: 400px;"></div>
                                                                <div class="d-none d-sm-block d-md-none" style="padding-top: 400px;"></div>
                                                                <div class="d-none d-md-block d-lg-none" style="padding-top: 400px;"></div>
                                                                <div class="d-none d-lg-block d-xl-none" style="padding-top: 400px;"></div>
                                                                <div class="d-none d-xl-block" style="padding-top: 400px;"></div>
                                                                <?if (isset($flag) AND $flag=='i'){?>
                                                                    <img data-srcset="<?=$img;?>" alt="<?=$titulo;?>" title="<?=$titulo;?>" data-aspect-ratio="3.4909090909090907" class=" media-slider rimage__img rimage__img--cover rimage__img--fade-in lazyload" style="width: 100%;">
                                                                <?}else{?>
                                                                    <video class="rvideo__video" muted playsinline autoplay loop preload="auto" style="height: 100%;">
                                                                        <source src="<?=$img;?>" alt="<?=$titulo;?>" title="<?=$titulo;?>" type="video/mp4" style="height: 100%;">
                                                                    </video>
                                                                <?}?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                <?}}else{?>
                                    <a href="produtos" title="<?=$nome_loja_completa;?>">
                                        <div class="slider__slide media-slider">
                                            <div class="promobox promobox--type-07 promobox--is-slider position-relative d-flex flex-column align-items-center text-center overflow-hidden">
                                                <div class="image-animation-trigger w-100">
                                                    <div class="w-100">
                                                        <div class="image-animation image-animation--from-default image-animation--to-default">
                                                            <div class="rimage" style="max-height: 400px;">
                                                                <div class="d-sm-none" style="padding-top: 400px;"></div>
                                                                <div class="d-none d-sm-block d-md-none" style="padding-top: 400px;"></div>
                                                                <div class="d-none d-md-block d-lg-none" style="padding-top: 400px;"></div>
                                                                <div class="d-none d-lg-block d-xl-none" style="padding-top: 400px;"></div>
                                                                <div class="d-none d-xl-block" style="padding-top: 400px;"></div>
                                                                <img data-srcset="<?=$url_loja;?>/assets/img/destaque/imagens/sem_imagem.webp" alt="<?=$nome_loja_completa;?>" title="<?=$nome_loja_completa;?>" data-aspect-ratio="3.4909090909090907" class=" media-slider rimage__img rimage__img--cover rimage__img--fade-in lazyload" style="width: 100%;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                <?}mysqli_free_result($sql_slide);?>
                            </div>
                            <div class="slider__next d-none d-lg-block position-absolute cursor-pointer" data-js-slider-next style="background-color: #78787880;"><i>
                                <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-007" viewBox="0 0 24 24">
                                    <path d="M6.708 20.917c0-.169.059-.319.176-.449l8.32-8.301-8.32-8.301a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176l8.75 8.75c.117.13.176.28.176.449a.652.652 0 0 1-.176.449l-8.75 8.75a.91.91 0 0 1-.215.127c-.078.032-.156.049-.234.049s-.156-.017-.234-.049a.91.91 0 0 1-.215-.127.652.652 0 0 1-.176-.449z"/>
                                </svg>
                            </i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            Loader.require({
                type: "script",
                name: "home_builder"
            });
        </script>
    </div>
    <div id="theme-section-1537199513853" class="theme-section d-none d-md-block">
        <div data-section-id="1537199513853" data-section-type="carousel-brands" data-postload="carousel_brands">
            <div class="container mt-0 mt-20">
                <div class="carousel carousel--arrows carousel-brands position-relative">
                    <div class="carousel__slider position-relative invisible" data-js-carousel data-autoplay="true" data-speed="5000" data-count="5" data-infinite="true" data-arrows="true" data-bullets="false">
                        <div class="carousel__prev position-absolute cursor-pointer" data-js-carousel-prev>
                            <i>
                                <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-006" viewBox="0 0 24 24">
                                    <path d="M16.736 3.417a.652.652 0 0 1-.176.449l-8.32 8.301 8.32 8.301c.117.13.176.28.176.449s-.059.319-.176.449a.91.91 0 0 1-.215.127c-.078.032-.156.049-.234.049s-.156-.017-.234-.049a.93.93 0 0 1-.215-.127l-8.75-8.75a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449l8.75-8.75a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176.117.13.176.28.176.449z"/>
                                </svg>
                            </i>
                        </div>
                        <div class="carousel__items overflow-hidden">
                            <div class="carousel__slick" data-js-carousel-slick>
                                <div class="carousel__item promobox promobox--type-03 icones-home" style="height:60px;">
                                    <a href="<?=$url_loja;?>/termos-e-condicoes" class="position-relative w-100 icones-home" style="height:60px;" title="ENTREGA EM TODO BRASIL">
                                        <div class="rimage icones-home" style="height: 60px;">
                                            <img src="<?=$url_loja;?>/assets/img/icones/entrega.svg" class="rimage__img rimage__img--fade-in lazyload icones-home" data-master="assets/img/icones/entrega.svg" data-aspect-ratio="2.45" data-srcset="assets/img/icones/entrega.svg 1x, assets/img/icones/entrega.svg 2x" style="height: 60px;" alt="ENTREGA EM TODO BRASIL" title="ENTREGA EM TODO BRASIL">
                                        </div>
                                        <div class="promobox__border absolute-stretch" style="height: 60px;"></div>
                                    </a>
                                </div>
                                <div class="carousel__item promobox promobox--type-03 icones-home" style="height:60px;">
                                    <a href="<?=$url_loja;?>/termos-e-condicoes" class="position-relative w-100 icones-home" style="height:60px;" title="PARCELAMOS EM ATÉ 12X NO CARTÃO">
                                        <div class="rimage icones-home" style="height: 60px;">
                                            <img src="<?=$url_loja;?>/assets/img/icones/cartao.svg" class="rimage__img rimage__img--fade-in lazyload icones-home" data-master="assets/img/icones/cartao.svg" data-aspect-ratio="2.45" data-srcset="assets/img/icones/cartao.svg 1x, assets/img/icones/cartao.svg 2x" style="height: 60px;" alt="PARCELAMOS EM ATÉ 12X NO CARTÃO" title="PARCELAMOS EM ATÉ 12X NO CARTÃO">
                                        </div>
                                        <div class="promobox__border absolute-stretch" style="height: 60px;"></div>
                                    </a>
                                </div>
                                <div class="carousel__item promobox promobox--type-03 icones-home" style="height:60px;">
                                    <a href="<?=$url_loja;?>/termos-e-condicoes" class="position-relative w-100 icones-home" style="height:60px;" title="DESCONTO DE 5% NO BOLETO">
                                        <div class="rimage icones-home" style="height: 60px;">
                                            <img src="<?=$url_loja;?>/assets/img/icones/boleto.svg" class="rimage__img rimage__img--fade-in lazyload icones-home" data-master="assets/img/icones/boleto.svg" data-aspect-ratio="2.45" data-srcset="assets/img/icones/boleto.svg 1x, assets/img/icones/boleto.svg 2x" style="height: 60px;" alt="DESCONTO DE 5% NO BOLETO" title="DESCONTO DE 5% NO BOLETO">
                                        </div>
                                        <div class="promobox__border absolute-stretch" style="height: 60px;"></div>
                                    </a>
                                </div>
                                <div class="carousel__item promobox promobox--type-03 icones-home" style="height:60px;">
                                    <a href="<?=$url_loja;?>/termos-e-condicoes" class="position-relative w-100 icones-home" style="height:60px;" title="PAGAMENTOS VIA PIX 5% DE DESCONTO">
                                        <div class="rimage icones-home" style="height: 60px;">
                                            <img src="<?=$url_loja;?>/assets/img/icones/pix.svg" class="rimage__img rimage__img--fade-in lazyload icones-home" data-master="assets/img/icones/pix.svg" data-aspect-ratio="2.45" data-srcset="assets/img/icones/pix.svg 1x, assets/img/icones/pix.svg 2x" style="height: 60px;" alt="PAGAMENTOS VIA PIX 5% DE DESCONTO" title="PAGAMENTOS VIA PIX 5% DE DESCONTO">
                                        </div>
                                        <div class="promobox__border absolute-stretch" style="height: 60px;"></div>
                                    </a>
                                </div>
                                <div class="carousel__item promobox promobox--type-03 icones-home" style="height:60px;">
                                    <a href="<?=$url_loja;?>/politica-de-privacidade" class="position-relative w-100 icones-home" style="height:60px;" title="COMPRA GARANTIDA LOJA 100% SEGURA">
                                        <div class="rimage icones-home" style="height: 60px;">
                                            <img src="<?=$url_loja;?>/assets/img/icones/loja-segura.svg" class="rimage__img rimage__img--fade-in icones-home lazyload" data-master="assets/img/icones/loja-segura.svg" data-aspect-ratio="2.45" data-srcset="assets/img/icones/loja-segura.svg 1x, assets/img/icones/loja-segura.svg 2x" style="height: 60px;" alt="COMPRA GARANTIDA LOJA 100% SEGURA" title="COMPRA GARANTIDA LOJA 100% SEGURA">
                                        </div>
                                        <div class="promobox__border absolute-stretch" style="height: 60px;"></div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel__next position-absolute cursor-pointer" data-js-carousel-next>
                            <i>
                                <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-007" viewBox="0 0 24 24">
                                    <path d="M6.708 20.917c0-.169.059-.319.176-.449l8.32-8.301-8.32-8.301a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176l8.75 8.75c.117.13.176.28.176.449a.652.652 0 0 1-.176.449l-8.75 8.75a.91.91 0 0 1-.215.127c-.078.032-.156.049-.234.049s-.156-.017-.234-.049a.91.91 0 0 1-.215-.127.652.652 0 0 1-.176-.449z"/>
                                </svg>
                            </i>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <script>
            Loader.require({
                type: "style",
                name: "plugin_slick"
            });

            Loader.require({
                type: "script",
                name: "carousel_brands"
            });
        </script>
    </div>
    <?
    $sql2 = "SELECT DISTINCT id,img,img_secundaria,url_amigavel,produto,preco,por,qtd,sku,forma FROM produtos WHERE status='a' ORDER BY data_editar DESC, hora_editar DESC LIMIT 8";
    $query2 = mysqli_query($conn, $sql2);
    if (mysqli_num_rows($query2) > 0) {?>
    <div id="theme-section-1537200465879" class="theme-section" style="margin-top: 22px;">
        <div data-section-id="1537200465879" data-section-type="carousel-products" data-postload="carousel_products">
            <div class="container">
                <div class="carousel carousel--arrows carousel-products position-relative mt-0 mb-60">
                    <div class="carousel__head row justify-content-center mb-25" data-carousel-control>
                        <h1 class="carousel__title col-auto mb-10 text-center" style="letter-spacing: 5px; font-size: 20px;">
                            <a href="<?=$url_loja;?>/produtos" title="LAN&Ccedil;AMENTOS" class="active" data-collection="trending-now-hp">- LAN&Ccedil;AMENTOS -</a>
                        </h1>
                    </div>
                    <div class="carousel__slider position-relative invisible" data-js-carousel data-autoplay="true" data-speed="5000" data-count="4" data-infinite="true" data-arrows="true" data-bullets="true">
                        <div class="carousel__prev position-absolute cursor-pointer d-none d-lg-block" data-js-carousel-prev><i>
                                <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-006" viewBox="0 0 24 24">
                                    <path d="M16.736 3.417a.652.652 0 0 1-.176.449l-8.32 8.301 8.32 8.301c.117.13.176.28.176.449s-.059.319-.176.449a.91.91 0 0 1-.215.127c-.078.032-.156.049-.234.049s-.156-.017-.234-.049a.93.93 0 0 1-.215-.127l-8.75-8.75a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449l8.75-8.75a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176.117.13.176.28.176.449z" />
                                </svg>
                            </i></div>
                        <div class="carousel__products overflow-hidden">
                            <div class="carousel__slick row" data-js-carousel-slick data-carousel-items data-max-count="6" data-products-pre-row="4" data-async-ajax-loading="true">
                                <?require_once "includes/paginas/lancamentos.php";?>
                            </div>
                        </div>
                        <div class="carousel__next position-absolute cursor-pointer d-none d-lg-block" data-js-carousel-next><i>
                            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-007" viewBox="0 0 24 24">
                                <path d="M6.708 20.917c0-.169.059-.319.176-.449l8.32-8.301-8.32-8.301a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176l8.75 8.75c.117.13.176.28.176.449a.652.652 0 0 1-.176.449l-8.75 8.75a.91.91 0 0 1-.215.127c-.078.032-.156.049-.234.049s-.156-.017-.234-.049a.91.91 0 0 1-.215-.127.652.652 0 0 1-.176-.449z" />
                            </svg>
                        </i></div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            Loader.require({
                type: "style",
                name: "plugin_slick"
            });
    
            Loader.require({
                type: "script",
                name: "carousel_products"
            });
        </script>
    </div>
    <?}
    $sql_banner = mysqli_query($conn, "SELECT * FROM banners WHERE status='a' AND tipo='home' ORDER BY id DESC");
    $num_banner = mysqli_num_rows($sql_banner);
    if ($num_banner>0){
    ?>
    <div id="theme-section-1537197792650" class="theme-section">
        <div data-section-id="1537197792650" data-section-type="home-builder" class="container">
            <div class="overflow-x-hidden">
                <div class="row">
                    <?
                    $contador=0;
                    while ($dados_banner = mysqli_fetch_assoc($sql_banner)) {
                		$titulo = $dados_banner['titulo'];
                		$img = $url_loja."/assets/img/banners/".$dados_banner['img'];
                		$link = $dados_banner['link'];
                		$flag = $dados_banner['flag'];
                		
                        if ($flag=='p'){
                            $contador++;
                        }
            		
                	if ($flag=='g'){?>
                        <div class="col-12 col-md-6 mt-0">
                            <a href="<?=$link;?>" title="<?=$titulo;?>">
                                <div style="margin-top: 25px;">
                                    <img src="<?=$img;?>" alt="<?=$titulo;?>" title="<?=$titulo;?>" style="width: 570px">
                                </div>
                            </a>
                        </div>
                    <?}if ($contador==1){?>
                        <div class="col-12 col-md-6 mt-0">
                            <div class="row">
                                <div class="col-12 col-md-12 mt-0">
                                    <a href="<?=$link;?>" title="<?=$titulo;?>">
                                        <div style="margin-top: 25px;">
                                            <img src="<?=$img;?>" alt="<?=$titulo;?>" title="<?=$titulo;?>">
                                        </div>
                                    </a>
                                </div>
                    <?}elseif($contador==2){?>
                        <div class="col-12 col-md-12 mt-0">
                            <a href="<?=$link;?>" title="<?=$titulo;?>">
                                <div style="margin-top: 12px;">
                                    <img src="<?=$img;?>" alt="<?=$titulo;?>" title="<?=$titulo;?>">
                                </div>
                            </a>
                        </div>
                        </div>
                        </div>
                    <?$contador=0;}?>
                    <?if ($flag=='t'){?>
                        <div class="col-12 col-md-12 mt-0 mb-45">
                            <a href="<?=$link;?>" title="<?=$titulo;?>">
                                <div style="margin-top: 12px;">
                                    <img src="<?=$img;?>" alt="<?=$titulo;?>" title="<?=$titulo;?>" style="width: 1170px;">
                                </div>
                            </a>
                        </div>
                    <?}?>
                <?}?>
                </div>
            </div>
        </div>
        <script>
            Loader.require({
                type: "script",
                name: "home_builder"
            });
        </script>
    </div>
    <?}mysqli_free_result($sql_banner);?>
    <div id="theme-section-1537377097986" class="theme-section">
        <div data-section-id="1537377097986" data-section-type="sorting-collections">
            <div class="container mt-0 mb-20">
                <div class="tabs js-tabs" data-type="horizontal">
                    <div class="sorting-collections">
                        <div class="tabs__head" data-js-tabs-head>
                            <div class="tabs__slider justify-content-lg-center" data-js-tabs-slider>
                                <?
                                $sql_vistos = "SELECT DISTINCT id,img,img_secundaria,produto,preco,por,qtd,cor,tamanho,sku,sistema,url_amigavel,forma FROM produtos WHERE status='a' ORDER BY qtd_visto DESC LIMIT 8";
                                $query_vistos = mysqli_query($conn, $sql_vistos);
                                $num_rows_vistos = mysqli_num_rows($query_vistos);
                                if ($num_rows_vistos>0) {
                                ?>
                                    <div class="tabs__btn" data-js-tabs-btn data-active="true">
                                        <h2 class="h1 carousel__title text-center" style="letter-spacing: 5px; margin:0; font-size: 15px;">
                                            <span title="MAIS VISTOS">- MAIS VISTOS -</span>
                                        </h2>
                                    </div>
                                <?}
                                $sql_vendidos = "SELECT DISTINCT id,img,img_secundaria,produto,preco,por,qtd,cor,tamanho,sku,sistema,url_amigavel,forma FROM produtos WHERE status='a' ORDER BY qtd_vendido DESC LIMIT 8";
                                $query_vendidos = mysqli_query($conn, $sql_vendidos);
                                $num_rows_vendidos = mysqli_num_rows($query_vendidos);
                                if ($num_rows_vendidos>0) {
                                ?>
                                <div class="tabs__btn" data-js-tabs-btn>
                                    <h2 class="h1 carousel__title text-center" style="letter-spacing: 5px; margin:0; font-size: 15px;">
                                        <span title="MAIS VENDIDOS">- MAIS VENDIDOS -</span>
                                    </h2>
                                </div>
                                <?}
                                $sql_procurados = "SELECT DISTINCT id,img,img_secundaria,produto,preco,por,qtd,cor,tamanho,sku,sistema,url_amigavel,forma FROM produtos WHERE status='a' ORDER BY qtd_buscado DESC LIMIT 8";
                                $query_procurados = mysqli_query($conn, $sql_procurados);
                                $num_rows_procurados = mysqli_num_rows($query_procurados);
                                if ($num_rows_procurados>0) {
                                ?>
                                <div class="tabs__btn" data-js-tabs-btn>
                                    <h2 class="h1 carousel__title text-center" style="letter-spacing: 5px; margin:0; font-size: 15px;">
                                        <span title="MAIS PROCURADOS">- MAIS PROCURADOS -</span>
                                    </h2>
                                </div>
                                <?}?>
                            </div>
                            <div class="tabs__nav tabs__nav--prev" data-js-tabs-nav-prev>
                                <i>
                                    <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-006" viewBox="0 0 24 24">
                                        <path d="M16.736 3.417a.652.652 0 0 1-.176.449l-8.32 8.301 8.32 8.301c.117.13.176.28.176.449s-.059.319-.176.449a.91.91 0 0 1-.215.127c-.078.032-.156.049-.234.049s-.156-.017-.234-.049a.93.93 0 0 1-.215-.127l-8.75-8.75a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449l8.75-8.75a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176.117.13.176.28.176.449z"/>
                                    </svg>
                                </i>
                            </div>
                            <div class="tabs__nav tabs__nav--next" data-js-tabs-nav-next>
                                <i>
                                    <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-007" viewBox="0 0 24 24">
                                        <path d="M6.708 20.917c0-.169.059-.319.176-.449l8.32-8.301-8.32-8.301a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176l8.75 8.75c.117.13.176.28.176.449a.652.652 0 0 1-.176.449l-8.75 8.75a.91.91 0 0 1-.215.127c-.078.032-.156.049-.234.049s-.156-.017-.234-.049a.91.91 0 0 1-.215-.127.652.652 0 0 1-.176-.449z"/>
                                    </svg>
                                </i>
                            </div>
                        </div>
                        <div class="tabs__body">
                            <?if ($num_rows_vistos>0) {?>
                                <div data-js-tabs-tab>
                                    <span data-js-tabs-btn-mobile>MAIS VISTOS
                                        <i>
                                            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-188" d="M7.158 12.206a.598.598 0 0 1-.186-.439.6.6 0 0 1 .186-.439.602.602 0 0 1 .439-.186h3.75v-3.75a.6.6 0 0 1 .186-.439.602.602 0 0 1 .439-.186c.169 0 .315.063.439.186a.605.605 0 0 1 .186.439v3.75h3.75c.169 0 .315.063.439.186a.605.605 0 0 1 .186.439.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186h-3.75v3.75a.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186.597.597 0 0 1-.439-.186.598.598 0 0 1-.186-.439v-3.75h-3.75a.598.598 0 0 1-.439-.186z"/></svg>
                                        </i>
                                    </span>
                                    <div class="tabs__content rte overflow-hidden" data-js-tabs-content>
                                        <div class="sorting-collections__products row" data-sorting-collections-items="8" id="mais_vistos" data-limit="8" data-grid="col-6 col-sm-6 col-md-4 col-lg-3" style="justify-content: center;">
                                            <?require_once "includes/paginas/mais-vistos.php";?>
                                        </div>
                                    </div>
                                </div>
                            <?}if ($num_rows_vendidos>0) {?>
                                <div data-js-tabs-tab>
                                    <span data-js-tabs-btn-mobile>MAIS VENDIDOS
                                        <i>
                                            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-188" d="M7.158 12.206a.598.598 0 0 1-.186-.439.6.6 0 0 1 .186-.439.602.602 0 0 1 .439-.186h3.75v-3.75a.6.6 0 0 1 .186-.439.602.602 0 0 1 .439-.186c.169 0 .315.063.439.186a.605.605 0 0 1 .186.439v3.75h3.75c.169 0 .315.063.439.186a.605.605 0 0 1 .186.439.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186h-3.75v3.75a.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186.597.597 0 0 1-.439-.186.598.598 0 0 1-.186-.439v-3.75h-3.75a.598.598 0 0 1-.439-.186z"/></svg>
                                        </i>
                                    </span>
                                    <div class="tabs__content rte overflow-hidden text-center" data-js-tabs-content>
                                        <div class="sorting-collections__products row" data-sorting-collections-items="8" id="mais_vendidos" data-limit="8" data-grid="col-6 col-sm-6 col-md-4 col-lg-3" style="justify-content: center;">
                                            <?require_once "includes/paginas/mais-vendidos.php";?>
                                        </div>
                                    </div>
                                </div>
                            <?}if ($num_rows_procurados>0) {?>
                                <div data-js-tabs-tab>
                                    <span data-js-tabs-btn-mobile>MAIS PROCURADOS
                                        <i>
                                            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-188" d="M7.158 12.206a.598.598 0 0 1-.186-.439.6.6 0 0 1 .186-.439.602.602 0 0 1 .439-.186h3.75v-3.75a.6.6 0 0 1 .186-.439.602.602 0 0 1 .439-.186c.169 0 .315.063.439.186a.605.605 0 0 1 .186.439v3.75h3.75c.169 0 .315.063.439.186a.605.605 0 0 1 .186.439.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186h-3.75v3.75a.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186.597.597 0 0 1-.439-.186.598.598 0 0 1-.186-.439v-3.75h-3.75a.598.598 0 0 1-.439-.186z"/></svg>
                                        </i>
                                    </span>
                                    <div class="tabs__content rte overflow-hidden text-center" data-js-tabs-content>
                                        <div class="sorting-collections__products row" data-sorting-collections-items="8" id="mais_vendidos" data-limit="8" data-grid="col-6 col-sm-6 col-md-4 col-lg-3" style="justify-content: center;">
                                            <?require_once "includes/paginas/mais-procurados.php";?>
                                        </div>
                                    </div>
                                </div>
                            <?}?>
                        </div>
                    </div>
                </div>
                <script>
                    Loader.require({
                        type: "script",
                        name: "tabs"
                    });
                </script>
            </div>
        </div>
        <script>
            Loader.require({
                type: "script",
                name: "sorting_collections"
            });
        </script>
    </div>
    <?
    $query_blog = mysqli_query($conn, "SELECT id, titulo, img, chamada, url_amigavel FROM blog WHERE status='a' ORDER BY id DESC LIMIT 6");
    $rows_blog = mysqli_num_rows($query_blog);
    if ($rows_blog>0){
    ?>
    <div id="theme-section-1537199704472" class="theme-section pb-10">
        <div data-section-id="1537199704472" data-section-type="carousel-articles" data-postload="carousel_articles">
            <div class="container mt-0 mb-60">
                <div class="carousel carousel--arrows carousel-articles position-relative">
                    <h2 class="carousel__title h4 mb-35 text-center" style="letter-spacing: 5px;">
                        <a href="<?=$url_loja;?>/blog" title="BLOG">- BLOG -</a>
                    </h2>
                    <div class="carousel__slider position-relative invisible" data-js-carousel data-autoplay="true" data-speed="5000" data-count="4" data-infinite="false" data-arrows="true" data-bullets="true">
                    <div class="carousel__prev position-absolute cursor-pointer d-none d-lg-block" data-js-carousel-prev><i>
                        <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-006" viewBox="0 0 24 24">
                            <path d="M16.736 3.417a.652.652 0 0 1-.176.449l-8.32 8.301 8.32 8.301c.117.13.176.28.176.449s-.059.319-.176.449a.91.91 0 0 1-.215.127c-.078.032-.156.049-.234.049s-.156-.017-.234-.049a.93.93 0 0 1-.215-.127l-8.75-8.75a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449l8.75-8.75a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176.117.13.176.28.176.449z"/>
                        </svg>
                    </i></div>
                    <div class="carousel__items overflow-hidden">
                        <div class="carousel__slick row" data-js-carousel-slick>
                            <?
                            while ($dados_blog = mysqli_fetch_assoc($query_blog)) {
                                $id_blog = $dados_blog['id'];
                                $chamada_blog = $dados_blog['chamada'];
                                $url_amigavel_blog = $dados_blog['url_amigavel'];
                                $titulo_blog = preconj($dados_blog['titulo']);
                                $img_blog = 'assets/img/blog/'.$dados_blog['img'];
                                $url_blog = $url_loja."/blog/".$url_amigavel_blog;

                                if (!file_exists($img_blog)){
                                    $img_blog = $url_loja."/assets/img/blog/sem_imagem.jpg";
                                }
                            ?>
                                <div class="col-md-12">
                                    <div class="carousel__item carousel-articles__item col-auto d-flex flex-column flex-xl-row align-items-center align-items-xl-start text-center text-xl-left">
                                        <div class="col-md-12" style="display: flex;flex-direction: column;align-items: center;">
                                            <a href="<?=$url_blog;?>" title="<?=$titulo_blog;?>" class="carousel-articles__image d-block">
                                                <div class="rimage" style="padding-top:0; width: 100%;">
                                                    <img src="<?=$img_blog;?>" loading="lazy" class="rimage__img rimage__img--fade-in lazyload" style="position: relative !important; width: 100%;" data-master="<?=$img_blog;?>" data-aspect-ratio="1.3701067615658362" data-srcset="<?=$img_blog;?>" alt="<?=$titulo_blog;?>" title="<?=$titulo_blog;?>">
                                                </div>
                                            </a>
                                            <div class="mt-20">
                                                <a href="<?=$url_blog;?>" title="<?=$titulo_blog;?>" class="btn btn--secondary">Ler mais</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?}?>
                        </div>
                    </div>
                    <div class="carousel__next position-absolute cursor-pointer d-none d-lg-block" data-js-carousel-next><i>
                        <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-007" viewBox="0 0 24 24">
                            <path d="M6.708 20.917c0-.169.059-.319.176-.449l8.32-8.301-8.32-8.301a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176l8.75 8.75c.117.13.176.28.176.449a.652.652 0 0 1-.176.449l-8.75 8.75a.91.91 0 0 1-.215.127c-.078.032-.156.049-.234.049s-.156-.017-.234-.049a.91.91 0 0 1-.215-.127.652.652 0 0 1-.176-.449z"/>
                        </svg>
                    </i></div>
                    </div>                             
                </div>
            </div>
        </div>       
        <script>
            Loader.require({
                type: "style",
                name: "plugin_slick"
            });
            Loader.require({
                type: "script",
                name: "carousel_articles"
            });
        </script>
    </div>
    <?}?>
</main>
<?require_once "includes/footer.php"?>
</body>
</html>
<? 
$cntACmp =ob_get_contents(); 
ob_end_clean(); 
$cntACmp=str_replace("\n",' ',$cntACmp); 
$cntACmp=preg_replace('/[[:space:]]+/',' ',$cntACmp);
echo $cntACmp; 
ob_end_flush(); 
?>