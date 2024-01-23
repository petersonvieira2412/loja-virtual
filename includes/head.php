<?
if(isset($_POST['pesquisar'])){
    echo "<meta http-equiv='refresh' content='0;URL=".$url_loja."/buscar/".mb_convert_case(str_replace(' ','-',clean($_POST['pesquisar'])), MB_CASE_LOWER)."'>";
    exit();
}

if (isset($_SESSION['tag_manager_head']) AND $_SESSION['tag_manager_head']!='') {
	echo $_SESSION['tag_manager_head'];
}

if (isset($_SESSION['cookies_loja_lgpb_google'])  AND $_SESSION['cookies_loja_lgpb_google']!='desativado') {
	if (isset($_SESSION['google_analytics']) AND $_SESSION['google_analytics']!='') {
		echo $_SESSION['google_analytics'];
	}
}

if (!isset($titulo_site) || $titulo_site=='') { $titulo_site = $vb_titulo_site; }
if (!isset($descricao_site) || $descricao_site=='') { $descricao_site = $vb_descricao_site; }
if (!isset($meta_site) || $meta_site=='') { $meta_site = $vb_meta_site; }

$titulo_site = preconj(mb_convert_case($titulo_site,  MB_CASE_TITLE));
if (strlen($titulo_site)<50 AND !str_contains($titulo_site, $nome_loja)){
    $titulo_site = $titulo_site.' - '.$nome_loja;
}
$titulo_site = mb_strimwidth($titulo_site, 0, 67, "...");
?>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=$titulo_site;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta http-equiv="Content-Security-Policy" content="">
    <meta http-equiv="Referrer-Policy" content="no-referrer, strict-origin-when-cross-origin"> 
    
    <meta name="theme-color" content="#858585">
    <meta name="msapplication-navbutton-color" content="#858585">
    <meta name="apple-mobile-web-app-status-bar-style" content="#858585">

    <meta name="description" content="<?=ucfirst(strip_tags(html_entity_decode($descricao_site)));?>">
    <meta name="keywords" content="<?=strip_tags(html_entity_decode($meta_site));?>">
    <meta rel="canonical" href="https://<?=$_SERVER['HTTP_HOST'];?>">
    
    <meta name="subject" content="Business">
    <meta name="category" content="<?=$tipo_loja;?>">
    <meta name="Classification" content="Business">
    <meta name="robots" content="index, follow" />
    <meta name="robots" content="nositelinkssearchbox">
    <meta name="googlebot" content="index, follow" />
    <meta name="bingbot" content="index, follow" />
    <meta name="msnbot" content="index, follow" />
    <meta name="slurp" content="index, follow" />
    <meta name="rating" content="general">  
    <meta name="resource-type" content="document">
    <meta name="audience" content="all">
    <meta name="coverage" content="Worldwide">
    <meta name="distribution" content="Global">
    <meta name="abstract" content="Business">
    <meta name="topic" content="Business">
    <meta name="summary" content="<?=$sessao_loja;?>">
    <meta name="directory" content="submission">
    <meta name="referrer" content="never">
    <link rel="owner" content="<?=$nome_loja_completa;?> - <?=$_SERVER['HTTP_HOST']?>">
    <link rel="publisher" content="Virtua Brasil - www.virtuabrasil.com.br">
    <meta name="author" content="Virtua Brasil">
    <link rel="author" content="Virtua Brasil, www.virtuabrasil.com.br">
    <meta name="publish_date" property="og:publish_date" content="<?=date("Y-m-d");?>T<?=date("H:i:s");?>-0600">
    <meta name="copyright" content="<?=$nome_loja_completa;?>">
    <link rel="designer" content="Virtua Brasil">
    <meta name="email" content="contato@<?=$dominio;?>">
    <meta name="url" content="https://www.virtuabrasil.com.br">
    <meta name="identifier-URL" content="https://www.virtuabrasil.com.br">
    <meta name="site" content="https://www.virtuabrasil.com.br"/>
    <meta name="geo.country" content="Brasil" />
    <meta name="dc.language" content="pt-br" />
    <meta content="yes" name="apple-mobile-web-app-capable" />

    <meta property="og:locale" content="pt_br"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="<?=$titulo_site;?>"/>
    <meta property="og:site_name" content="<?=$nome_loja_completa;?>"/>
    <meta property="og:description" content="<?=ucfirst(strip_tags(html_entity_decode($descricao_site)));?>"/>
    
    <?
    if (!isset($img_og)){$img_og = '';}

    if($img_og=='https://'.$_SERVER['HTTP_HOST'].'/assets/img/categorias/sem_imagem.jpg' || $img_og=='https://'.$_SERVER['HTTP_HOST'].'/assets/img/produtos/sem_imagem.jpg' || $img_og==''){
        $ogimg = 'https://'.$_SERVER['HTTP_HOST'].'/assets/img/og.webp';
    }else{
        $ogimg = 'https://'.$_SERVER['HTTP_HOST'].$img_og;
    }
    $extensao = pathinfo($ogimg, PATHINFO_EXTENSION);

    if ($extensao=='jpg' || $extensao=='jpeg'){
        $image_type = "image/jpeg";
    }elseif ($extensao=='png'){
        $image_type = "image/png";
    }elseif ($extensao=='webp'){
        $image_type = "image/webp";
    }elseif ($extensao=='gif'){
        $image_type = "image/gif";
    }else{
        $image_type = "image/jpeg";
    }
    
    if (isset($_SESSION['pixel']) AND $_SESSION['pixel']!='') {
        echo $_SESSION['pixel'];
    }
    if (isset($_SESSION['facebook']) AND $_SESSION['facebook']!='') {
        echo $_SESSION['facebook'];
    }
    if (isset($_SESSION['clarity']) AND $_SESSION['clarity']!='') {
        echo $_SESSION['clarity'];
    }
    if (isset($_SESSION['scripts']) AND $_SESSION['scripts']!='') {
        echo $_SESSION['scripts'];
    }
    ?>
    
    <meta property="fb:app_id" content="955783162309766"/>
    
    <meta property="og:type" content="website" /> 
    <meta property="og:title" content="<?=$titulo_site;?>" />
    <meta property="og:description" content="<?=ucfirst(strip_tags(html_entity_decode($descricao_site)));?>"/>
    <meta property="og:updated_time" content="<?=date('Y-m-d');?>T<?=date('H:i:s');?>"/>

    <meta property="og:url" content="https://<?=$_SERVER['HTTP_HOST'];?><?=$_SERVER['REQUEST_URI'];?>"/>
    <meta property="og:image" content="<?=$ogimg;?>"/>
    <meta property="og:image:secure_url" content="<?=$ogimg;?>"/>
    <meta property="og:image:type" content="<?=$image_type;?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="<?=$titulo_site;?>"/>
    <meta property="og:updated_time" content="<?=date("Y-m-d");?>T<?=date("H:i:s");?>"/>

    <meta property="ia:markup_url" content="https://<?=$_SERVER['HTTP_HOST']?>">
    <meta property="ia:markup_url_dev" content="https://www.virtuabrasil.com.br">
    <meta property="ia:rules_url" content="https://<?=$_SERVER['HTTP_HOST']?>">
    <meta property="ia:rules_url_dev" content="https://www.virtuabrasil.com.br">

    <meta name="twitter:card" content="summary">
    <meta name="twitter:url" content="https://<?=$_SERVER['HTTP_HOST'];?><?=$_SERVER['REQUEST_URI'];?>">
    <meta name="twitter:title" content="<?=$titulo_site;?>">
    <meta name="twitter:description" content="<?=ucfirst(strip_tags(html_entity_decode($descricao_site)));?>">
    <meta name="twitter:image" content="<?=$img_og;?>">
        
    <meta itemprop="name" content="<?=$titulo_site;?>" />
    <meta itemprop="description" content="<?=ucfirst(strip_tags(html_entity_decode($descricao_site)));?>">
    <meta itemprop="image" content="<?=$img_og;?>">

    <link rel="stylesheet" href="<?=$url_loja;?>/assets/styles/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="<?=$url_loja;?>/assets/styles/start-style.min.css">
    <link rel="preload" href="<?=$url_loja;?>/assets/styles/fontawesome/css/fontawesome.min.css" as="style" onload="this.rel='stylesheet'">
    <link rel="preload" href="<?=$url_loja;?>/assets/styles/fontawesome/css/brands.css" as="style" onload="this.rel='stylesheet'">
    <link rel="preload" href="<?=$url_loja;?>/assets/styles/fontawesome/css/solid.css" as="style" onload="this.rel='stylesheet'">
    <link rel="canonical" href="https://<?=$_SERVER['HTTP_HOST'];?><?=$_SERVER['REQUEST_URI'];?>"/>

    <link rel="apple-touch-icon" sizes="57x57" href="<?=$url_loja;?>/assets/img/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?=$url_loja;?>/assets/img/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?=$url_loja;?>/assets/img/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?=$url_loja;?>/assets/img/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?=$url_loja;?>/assets/img/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?=$url_loja;?>/assets/img/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?=$url_loja;?>/assets/img/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?=$url_loja;?>/assets/img/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=$url_loja;?>/assets/img/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?=$url_loja;?>/assets/img/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=$url_loja;?>/assets/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?=$url_loja;?>/assets/img/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=$url_loja;?>/assets/img/favicon/favicon-16x16.png">
    <meta name="msapplication-TileColor" content="#e30613">
    <meta name="msapplication-TileImage" content="<?=$url_loja;?>/assets/img/favicon/ms-icon-144x144.png">
    <script src="<?=$url_loja;?>/assets/scripts/jquery-3.6.3.min.js"></script>
	<script src="<?=$url_loja;?>/assets/scripts/jquery.mask.min.js"></script>
    <script>
    var Loader = {
        settings: {
            scripts: {
                carousel_articles: {
                    postload: true
                },
                carousel_products: {
                    postload: true
                },
                carousel_brands: {
                    postload: true
                }
            },
            styles: {
                theme: {
                    loaded_class: 'css-theme-loaded'
                }
            }
        },
        main: {
            scripts: ['vendor', 'theme'],
            styles: []
        },
        includes: {
            scripts: {
                plugin_popper: '<?=$url_loja;?>/assets/scripts/plugin.popper.min.js',
                plugin_tippy: '<?=$url_loja;?>/assets/scripts/plugin.tippy.all.min.js',
                plugin_fotorama: '<?=$url_loja;?>/assets/scripts/plugin.fotorama.min.js',
                plugin_instafeed: '<?=$url_loja;?>/assets/scripts/plugin.instafeed.min.js',
                plugin_ion_range_slider: '<?=$url_loja;?>/assets/scripts/plugin.ion-range-slider.min.js',
                plugin_masonry: '<?=$url_loja;?>/assets/scripts/plugin.masonry.min.js',
                plugin_revolution_slider: '<?=$url_loja;?>/assets/scripts/plugin.revolution-slider.min.js',
                plugin_sticky_sidebar: '<?=$url_loja;?>/assets/scripts/plugin.sticky-sidebar.min.js',
                vendor: '<?=$url_loja;?>/assets/scripts/vendor.min.js',
                theme: '<?=$url_loja;?>/assets/scripts/theme.min.js',
                tooltip: '<?=$url_loja;?>/assets/scripts/module.tooltip.min.js',
                buttons_blocks_visibility: '<?=$url_loja;?>/assets/scripts/module.buttons-blocks-visibility.min.js',
                collections: '<?=$url_loja;?>/assets/scripts/module.collections.min.js',
                dynamic_checkout: '<?=$url_loja;?>/assets/scripts/module.dynamic-checkout.min.js',
                masonry: '<?=$url_loja;?>/assets/scripts/module.masonry.min.js',
                notifications: '<?=$url_loja;?>/assets/scripts/module.notifications.min.js',
                parallax: '<?=$url_loja;?>/assets/scripts/module.parallax.min.js',
                popup_subscription: '<?=$url_loja;?>/assets/scripts/module.popup-subscription.min.js',
                product_footbar: '<?=$url_loja;?>/assets/scripts/module.product-footbar.min.js',
                products_view: '<?=$url_loja;?>/assets/scripts/module.products-view.min.js',
                range_of_price: '<?=$url_loja;?>/assets/scripts/module.range-of-price.min.js',
                shipping_rates_calculation: '<?=$url_loja;?>/assets/scripts/module.shipping-rates-calculation.min.js',
                sticky_header: '<?=$url_loja;?>/assets/scripts/module.sticky-header.min.js',
                sticky_sidebar: '<?=$url_loja;?>/assets/scripts/module.sticky-sidebar.min.js',
                tabs: '<?=$url_loja;?>/assets/scripts/module.tabs.min.js',
                trigger: '<?=$url_loja;?>/assets/scripts/module.trigger.min.js',
                presentation: '<?=$url_loja;?>/assets/scripts/module.presentation.min.js',
                header: '<?=$url_loja;?>/assets/scripts/section.header.min.js',
                article_body: '<?=$url_loja;?>/assets/scripts/section.article-body.min.js',
                blog_body: '<?=$url_loja;?>/assets/scripts/section.blog-body.min.js',
                blog_sidebar: '<?=$url_loja;?>/assets/scripts/section.blog-sidebar.min.js',
                carousel_articles: '<?=$url_loja;?>/assets/scripts/section.carousel-articles.min.js',
                carousel_brands: '<?=$url_loja;?>/assets/scripts/section.carousel-brands.min.js',
                carousel_products: '<?=$url_loja;?>/assets/scripts/section.carousel-products.js',
                collection_body: '<?=$url_loja;?>/assets/scripts/section.collection-body.min.js',
                collection_head: '<?=$url_loja;?>/assets/scripts/section.collection-head.min.js',
                collection_sidebar: '<?=$url_loja;?>/assets/scripts/section.collection-sidebar.min.js',
                gallery: '<?=$url_loja;?>/assets/scripts/section.gallery.min.js',
                home_builder: '<?=$url_loja;?>/assets/scripts/section.home-builder.min.js',
                list_collections: '<?=$url_loja;?>/assets/scripts/section.list-collections.min.js',
                lookbook: '<?=$url_loja;?>/assets/scripts/section.lookbook.min.js',
                password_page_content: '<?=$url_loja;?>/assets/scripts/section.password-page-content.min.js',
                product: '<?=$url_loja;?>/assets/scripts/section.product.min.js',
                slider_revolution: '<?=$url_loja;?>/assets/scripts/section.slider-revolution.min.js',
                sorting_collections: '<?=$url_loja;?>/assets/scripts/section.sorting-collections.min.js',
                footbar: '<?=$url_loja;?>/assets/scripts/section.footbar.min.js',
                footer: '<?=$url_loja;?>/assets/scripts/section.footer.min.js'
            },
            styles: {
                plugin_tippy: '<?=$url_loja;?>/assets/styles/plugin.tippy.min.css',
                plugin_fotorama: '<?=$url_loja;?>/assets/styles/plugin.fotorama.min.css',
                plugin_ion_range_slider: '<?=$url_loja;?>/assets/styles/plugin.ion-range-slider.min.css',
                plugin_revolution: '<?=$url_loja;?>/assets/styles/plugin.revolution.min.css',
                plugin_slick: '<?=$url_loja;?>/assets/styles/plugin.slick.min.css',
                text_font: 'https://fonts.googleapis.com/css?family=Roboto',
                theme: '<?=$url_loja;?>/assets/styles/theme.min.css'
            }
        },
        deps: {
            scripts: {
                plugin_tippy: ['plugin_popper'],
                theme: ['vendor', 'plugin_fotorama'],
                tooltip: ['plugin_tippy'],
                collections: ['products_view'],
                masonry: ['plugin_masonry'],
                product_footbar: ['trigger'],
                range_of_price: ['plugin_ion_range_slider', 'collections'],
                sticky_sidebar: ['plugin_sticky_sidebar', 'sticky_header'],
                tabs: ['plugin_sticky_sidebar', 'sticky_sidebar', 'sticky_header'],
                header: ['sticky_header'],
                blog_body: ['masonry'],
                blog_sidebar: ['sticky_sidebar'],
                collection_sidebar: ['range_of_price'],
                gallery: ['plugin_fotorama', 'masonry'],
                home_builder: ['plugin_instafeed', 'plugin_revolution_slider', 'parallax'],
                list_collections: ['masonry'],
                product: ['sticky_sidebar', 'tabs'],
                article_body: ['plugin_slick'],
                footbar: ['notifications', 'trigger', 'product_footbar']
            },
            styles: {
                theme: ['plugin_tippy', 'plugin_fotorama', 'plugin_ion_range_slider', 'plugin_revolution', 'plugin_slick']
            }
        },
        callback: {
            scripts: {},
            styles: {}
        },
        queue: {
            scripts: [],
            styles: []
        },
        initials: {
            scripts: {},
            styles: {}
        },
        loaded: {
            scripts: {},
            styles: {}
        },
        postload: {
            scripts: {},
            styles: {}
        },
        postload_offset: 400,
        require: function (obj) {
            var namespace;
            switch (obj.type) {
                case 'style':
                {
                    namespace = 'styles';
                    break;
                }
                case 'script':
                {
                    namespace = 'scripts';
                    break;
                }
            }
            if (this.settings[namespace][obj.name] && this.settings[namespace][obj.name].postload) {
                this.postload[namespace][obj.name] = true;
            } else {
                this.queue[namespace].push(obj.name);
            }
            this.initials[namespace][obj.name] = true;
        },
        load: function () {
            var _ = this,
                    namespace,
                    i;
            for (namespace in this.main) {
                for (i = this.main[namespace].length - 1; i >= 0; i--) {
                    this.initials[namespace][this.main[namespace][i]] = true;
                    this.queue[namespace].unshift(this.main[namespace][i]);
                }
            }
            function load_deps(namespace, name, j, callback) {
                if (j < _.deps[namespace][name].length) {
                    if (_.initials[namespace][_.deps[namespace][name][j]]) {
                        delete _.initials[namespace][_.deps[namespace][name][j]];
                        _.loadTag(namespace, _.deps[namespace][name][j], function () {
                            j++;
                            load_deps(namespace, name, j, callback);
                        });
                    } else {
                        j++;
                        load_deps(namespace, name, j, callback);
                    }
                } else {
                    if (callback) {
                        callback();
                    }
                }
            };
            function iteration(namespace, i, callback) {
                var name = _.queue[namespace][i];
                if (i < _.queue[namespace].length && !_.initials[namespace][name]) {
                    i++;
                    iteration(namespace, i, callback);
                    return;
                }
                function load_deps_callback() {
                    delete _.initials[namespace][name];
                    _.loadTag(namespace, name, function () {
                        i++;
                        iteration(namespace, i, callback);
                    });
                };
                if (i < _.queue[namespace].length) {
                    if (_.checkDeps(namespace, name)) {
                        load_deps_callback();
                    } else {
                        load_deps(namespace, name, 0, load_deps_callback);
                    }
                } else if (callback) {
                    callback();
                }
            };
            iteration('styles', 0, function () {
                iteration('scripts', 0);
            });
            function onPostload(namespace, name, elems, j) {
                for (namespace in _.postload) {
                    for (name in _.postload[namespace]) {
                        elems = document.querySelectorAll('[data-postload="' + name + '"]');
                        for (j = 0; j < elems.length; j++) {
                            if (elems[j].getBoundingClientRect().top < window.innerHeight + _.postload_offset) {
                                _.queue[namespace].push(name);
                                delete _.postload[namespace][name];
                                continue;
                            }
                        }
                    }
                }
                iteration('styles', 0, function () {
                    iteration('scripts', 0);
                });
            };
            window.addEventListener('load', function () {
                onPostload();
                window.addEventListener('scroll', onPostload);
            });
        },
        checkDeps: function (namespace, name) {
            var deps = this.deps[namespace][name],
            clear_deps = true,
            i;
            if (deps) {
                for (i = 0; i < deps.length; i++) {
                    if (!this.loaded[namespace][deps[i]] && this.initials[namespace][deps[i]] !== undefined) {
                        clear_deps = false;
                        break;
                    }
                }
            }
            return clear_deps;
        },
        loadTag: function (namespace, name, callback) {
            var _ = this,
                    tag,
                    onload;
            if(document.querySelectorAll('[data-loader-name="' + namespace + '_' + name + '"]').length) {
                return;
            }
            onload = function () {
                _.loaded[namespace][name] = true;
                if (_.settings[namespace][name]) {
                    if (_.settings[namespace][name].loaded_class) {
                        document.getElementsByTagName('html')[0].classList.add(_.settings[namespace][name].loaded_class);
                    }
                }
                if (callback) {
                    if (_.callback[namespace][name]) {
                        _.callback[namespace][name](_);
                    }
                    callback();
                }
            };
            switch (namespace) {
                case 'styles':
                {
                    tag = this.buildStyle(name, onload);
                    break;
                }
                case 'scripts':
                {
                    tag = this.buildScript(name, onload);
                    break;
                }
            }
            tag.setAttribute('data-loader-name', namespace + '_' + name);
            document.head.insertBefore(tag, document.head.childNodes[document.head.childNodes.length - 1].nextSibling);
        },
        buildScript: function (name, onload) {
            var tag = document.createElement('script');
            tag.onload = onload;
            tag.async = true;
            tag.src = this.includes.scripts[name];
            return tag;
        },
        buildStyle: function (name, onload) {
            var tag = document.createElement('link');
            tag.onload = onload;
            tag.rel = 'stylesheet';
            tag.href = this.includes.styles[name];
            return tag;
        }
    }
    </script>
    <script>
    $(document).ready(function() {
        var CEPoptions =  {
            reverse: true,
            selectOnFocus: true,
            onComplete: function(cep) {
                buscaCep(cep);
            },
            onChange: function(cep){
                if(cep.length == 0){
                    $('#logradouro').prop('value','');
                    $('#numero').prop('value','');
                    $('#pto_referencia').prop('value','');
                    $('#complemento').prop('value','');
                    $('#bairro').prop('value','');
                    $('#cidade').prop('value','');
                    $('#estado').prop('value','');
    
                    $('#logradouro').attr('placeholder','Logradouro');
                    $('#numero').attr('placeholder','Numero');
                    $('#pto_referencia').attr('placeholder','Ponto de referência');
                    $('#complemento').attr('placeholder','Complemento');
                    $('#bairro').attr('placeholder','Bairro');
                    $('#cidade').attr('placeholder','Cidade');
                    $('#estado').attr('placeholder','Estado');
    
                }else{
    
                    if(cep.length < 9){
                        $('#logradouro').attr('placeholder','buscando...');
                        $('#numero').prop('value','');
                        $('#complemento').prop('value','');
                        $('#bairro').attr('placeholder','buscando...');
                        $('#cidade').attr('placeholder','buscando...');
                        $('#estado').attr('placeholder','buscando...');
                    }
                }
            }
        };
        <?if ($onde!='detalhes'){?>
            $('.cep').mask('00000-000', CEPoptions);
            $('.tel').mask('(00) 0000-0000');
            $('.cel').mask('(00) 00000-0000');
            $('.cpf').mask('000.000.000-00', {reverse: true});
            if ($('.rg').length > 7){
                $('.rg').mask('000.000-#', {reverse: true});
            }else{
                $('.rg').mask('00.000.000-0', {reverse: true});
            }
            $('.data').mask('00/00/0000');
            $('.dinheiro').mask("#.##0,00", {reverse: true});
        <?}?>
    
        function buscaCep(cep){
    
            var cepOK = cep.replace(/\D/g, '');
            $.getJSON('https://viacep.com.br/ws/'+cepOK+'/json/', function(data){
            $('#logradouro').prop('value',data.logradouro);
            $('#numero').prop('value','');
            $('#bairro').prop('value',data.bairro);
            $('#cidade').prop('value',data.localidade);
            $('#estado').prop('value',data.uf);
            $('#numero').focus();
            $('#logradouro').attr('placeholder','Logradouro');
            $('#numero').attr('placeholder','Numero');
            $('#pto_referencia').attr('placeholder','Ponto de referência');
            $('#bairro').attr('placeholder','Bairro');
            $('#cidade').attr('placeholder','Cidade');
            $('#estado').attr('placeholder','Estado');
            });
        }
    
    });
    function adicionar_carrinho(){
    	var codigo = document.getElementById('codigo').value;
    	var nome = $('#nome').prop('value');
    	var imagem = document.getElementById('imagem').value;
    	var preco = document.getElementById('preco').value;
    	var qtd = document.getElementById('qtd').value;

    	var cor = $("#cor_final").prop('value');
        var tamanho = $("#tamanho_final").prop('value');
        var variacoes_estoque = $("#estoque").data('estoque');
        var estoque = $("#estoque").prop('value');
        
        if (variacoes_estoque>0){
            if ($("#estoque").data('tamanho')=='sim' && tamanho<1){
                var liberado = false;
                $('#required').show();
                setTimeout(function() {
                   $('#required').hide();
                }, 4000);
            }else if ($("#estoque").data('cor')=='sim' && cor<1){
                var liberado = false;
                $('#required').show();
                setTimeout(function() {
                   $('#required').hide();
                }, 4000);
            }else{
                var liberado = true;
            }
        }else{
            var liberado = true;
        }
        
        if (liberado===true){
    
            var total = preco * qtd;
            
            var total_parcial = Number($('#subtotal_final').prop('value'))+total;
        
            var total_final = '';
        
            if (total_parcial=='' || total_parcial<1){
                total_final = 'Consulte-nos';
            }else{
                total_final = total_parcial.toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'});
            }
        
            if (qtd>1){
                var quantidade = '<br><br> Quantidade: '+qtd;
            }else{var quantidade = '';}
            var variacoes = '';
            if (tamanho!=""){
                variacoes += tamanho;
            }
            if (cor!="" & tamanho!=""){
                variacoes += ' / ';
            }
            if (cor!=""){
                variacoes += cor;
            }
        
            var preco_individual = '';
            var total = parseInt($('#carrinho_qtd_total').prop('value')) + 1;
            
            $.ajax({
                type: 'POST',
                url: '<?=$url_loja;?>/includes/adicionar_carrinho.php',
                data: {
                    codigo: codigo,
        			nome: nome,
        			imagem: imagem,
        			preco: preco,
        			qtd: qtd,
        			cor: cor,
        			tamanho: tamanho,
        			estoque: estoque
                },
                dataType: 'json',
                success: function (data) {
                    if(data.jatem){
        				$('#alerta').click();
        			}else{
                        preco = parseFloat(preco);
                        if (preco=='' || preco<1){
                          preco_individual = "Consulte-nos";
                        }else{
                          preco_individual = preco.toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'});
                        }
        				if(data.msgTipo=='success'){
        					$('#carrinho_lateral').append(
        					'<div id="carrinho_'+data.id+'">'+
                                '<div class="product-cart__content d-flex flex-column align-items-start">'+
                                    '<div class="product-cart__title mb-3">'+
                                        '<h3 class="h6 m-0">'+
                                            '<a href="<?=$url_loja;?>/produto/'+data.url+'" title="'+nome+'">'+nome+'</a>'+
                                        '</h3>'+
                                    '</div>'+
                                '</div>'+
        					    '<div class="product-cart d-flex flex-row align-items-start mb-20" data-js-product="" data-product-variant-id="'+data.id+'">'+
                                    '<div class="product-cart__image mr-15">'+
                                        '<a href="<?=$url_loja;?>/produto/'+data.url+'" class="d-block" title="'+nome+'">'+
                                            '<img src="'+imagem+'" srcset="'+imagem+'" alt="'+nome+'" title="'+nome+'">'+
                                        '</a>'+
                                    '</div>'+
                                    '<div class="product-cart__content d-flex flex-column align-items-start">'+
                                        '<div class="product-cart__variant">'+variacoes+'</div>'+
                                        '<div class="product-cart__price mt-10 mb-10">'+
                                            '<span class="product-cart__quantity">'+qtd+'</span>'+
                                            '<span>x </span>'+
                                            '<span class="price" data-wg-notranslate="manual">'+
                                                '<span>'+
                                                    '<span class="money" data-currency-usd="'+preco_individual+'" data-currency="BRL" data-wg-notranslate="manual" style="font-size: 18px;">'+preco_individual+'</span>'+
                                                '</span>'+
                                            '</span>'+
                                        '</div>'+
                                        '<a href="#" onclick="remover_carrinho('+data.id+');" class="product-cart__remove btn-link js-product-button-remove-from-cart d-flex" style="align-items: flex-end; color: #ff0000;">'+
                                            '<svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-165" viewBox="0 0 24 24" style="width: 18px; min-width: 18px; fill: #ff0000;">'+
                                                '<path d="M4.741 21.654a.601.601 0 0 1-.186-.439v-15h-1.25a.598.598 0 0 1-.439-.186.597.597 0 0 1-.186-.439.6.6 0 0 1 .186-.439.604.604 0 0 1 .439-.186h5v-2.5a.6.6 0 0 1 .186-.439.598.598 0 0 1 .439-.186h6.25c.169 0 .315.063.439.186a.601.601 0 0 1 .186.439v2.5h5c.169 0 .315.063.439.186a.601.601 0 0 1 .186.439c0 .17-.062.316-.186.439a.601.601 0 0 1-.439.186h-1.25v15a.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186H5.18a.598.598 0 0 1-.439-.186zM18.305 6.215h-12.5V20.59h12.5V6.215zM9.37 9.525a.601.601 0 0 1 .186.439v6.875c0 .17-.062.316-.186.439a.601.601 0 0 1-.439.186.598.598 0 0 1-.439-.186.598.598 0 0 1-.186-.439V9.965a.6.6 0 0 1 .186-.439.594.594 0 0 1 .438-.186c.169 0 .316.062.44.185zm.185-4.56h5V3.09h-5v1.875zm2.94 4.56a.601.601 0 0 1 .186.439v6.875c0 .17-.062.316-.186.439a.601.601 0 0 1-.439.186.598.598 0 0 1-.439-.186.598.598 0 0 1-.186-.439V9.965a.6.6 0 0 1 .186-.439.604.604 0 0 1 .439-.186c.168 0 .315.062.439.185zm2.246 0a.604.604 0 0 1 .439-.186c.169 0 .315.063.439.186a.601.601 0 0 1 .186.439v6.875c0 .17-.062.316-.186.439a.601.601 0 0 1-.439.186.598.598 0 0 1-.439-.186.598.598 0 0 1-.186-.439V9.965c0-.169.062-.316.186-.44z"></path>'+
                                            '</svg>'+
                                            'Remover'+
                                        '</a>'+
                                    '</div>'+
                                '</div>'+
        					'</div>');
        					$('#carrinho_lateral_total').html(
        					'<div class="popup-cart__subtotal h5 d-flex align-items-center mt-15 mb-0">'+
                                '<p class="m-0 font-weight-bold">SUBTOTAL: <span id="subtotal_lateral" value="'+total_parcial+'">'+total_final+'</span></p>'+
                                '<span class="ml-auto">'+
                                    '<span class="price" data-js-popup-cart-subtotal></span>'+
                                '</span>'+
                            '</div>'+
                            '<div class="popup-cart__buttons mt-15">'+
                                '<a href="<?=$url_loja;?>/carrinho" class="btn btn--full mt-20">VER CARRINHO</a>'+
                                '<a href="<?=$url_loja;?>/carrinho" class="btn btn--full btn--secondary">FINALIZAR COMPRA</a>'+
                            '</div>');
                            
                            var carrinho_qtd_total = total;
                            $('#subtotal_final').prop('value', total_parcial);
                            $('#carrinho_qtd_total').prop('value', carrinho_qtd_total);
                            if($('#total_header').hasClass('qtd_carrinho')){
                            }else{
                               $('#total_header').addClass('qtd_carrinho');
                            }
                            $('#total_header').html(carrinho_qtd_total);
                            $('#total_header_mobile').html(carrinho_qtd_total);
                            $('#total_header_mobile').attr('data-js-cart-count-mobile', carrinho_qtd_total);
                            $('#carrinho_lateral_qtd').html('<b>('+carrinho_qtd_total+')</b>');
                            $('#carrinho_lateral_total').show();
                            
                            $('#sacola_vazia').css("display", "none");
                            $('#abrir_sacola').click();
            			}
        		    }
                }
            });
        }
    }
    function remover_carrinho(id){
        <?if ($onde=='carrinho'){?>
          var carrinho = 'carrinho';
        <?}else{?>
          var carrinho = '';  
        <?}?>
        $.ajax({
            type: 'POST',
            url: '<?=$url_loja;?>/includes/remover_carrinho.php',
            data: {
                remover: 'remover',
                codigo: id,
                carrinho: carrinho
            },
            dataType: 'json',
            beforeSend: function () {
                $('#loader_carrinho').show();
            },
            success: function (data) {
                var total = parseInt($('#carrinho_qtd_total').prop('value')) - 1;
                if (total=='0'){
                    <?if ($onde=='carrinho'){?>
                        window.location.href='<?=$url_loja;?>/carrinho';
                    <?}?>
                    $('#carrinho_qtd_total').prop('value', total);
                    $('#carrinho_lateral_total').hide();
                    $('#sacola_vazia').show();
                    $('#total_header').html('');
                    $('#total_header').removeClass('qtd_carrinho');
                    $('#total_header').hide();
                    $('#total_header_mobile').html('');
                    $('#total_header_mobile').attr('data-js-cart-count-mobile', '');
                    $('#total_header_mobile').hide();
                    $('#carrinho_lateral_qtd').html('');
                    $('#carrinho_'+id).remove();
                    $('#subtotal_final').prop('value', '0');
                }else{
                    <?if ($onde=='carrinho'){?>
                        $('#total_parcial').html(data.total_parcial.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'}));
                        $('#div_produto_'+id).html('');
                    <?}?>
                    $('#subtotal_lateral').html(data.total_parcial.toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'}));
                    $('#carrinho_qtd_total').prop('value', total);
                    $('#total_header').html(total);
                    $('#total_header_mobile').html(total);
                    $('#total_header_mobile').attr('data-js-cart-count-mobile', total);
                    $('#carrinho_lateral_qtd').html('<b>('+total+')</b>');
                    $('#carrinho_'+id).remove();
                }
                $('#loader_carrinho').hide();
            }
        });
    }
    function monta_menu(id, categoria){
         $.ajax({
            type: 'POST',
            url: '<?=$url_loja;?>/includes/monta_menu.php',
            data: {
                idc: id,
                categoria: categoria
            },
            dataType: 'json',
            success: function (data) {
                $('#menu_pai_'+id).html(data.dados);
            }
        });
    }
    function Favoritar(id){
        $.ajax({
            type: 'POST',
            url: '<?=$url_loja;?>/includes/favoritar.php',
            data: {
                id: id
            },
            dataType: 'json',
            success: function (data) {
                if (data.total>0){
                    $('#total_favoritos_header').html(data.total);
                }else{
                    $('#total_favoritos_header').html('');
                }
            }
        });
    }
    </script>
    
    <?
    function monta_menu($conn, $url_loja, $id, $categoria, $url_amigavel, $pagina){
	
    	$menu = '';
    		
    	$temCat = mysqli_query($conn,"SELECT id, categoria, categoria_pai, url_amigavel FROM categorias WHERE categoria_pai='".$id."' AND status='a' ORDER BY categoria ASC");
    	$temCat_num = mysqli_num_rows($temCat);
    
    	if ($temCat_num>0) {
                $menu .= '
                <div class="collections-menu__item" data-js-accordion="all" data-section-for-collection="mens">
                    <div class="collections-menu__button d-flex align-items-center mb-15 mb-lg-9 cursor-pointer '.((isset($_SESSION['categorias']) AND in_array($id, $_SESSION['categorias']))?'open':'').'" data-js-accordion-button>
                        <label class="input-checkbox d-flex align-items-center mb-0 mr-0 cursor-pointer">
                            <input type="radio" class="d-none categoria" name="categoria" value="'.$url_loja.'/'.((isset($pagina) AND $pagina=='outlet')?'outlet':'categoria').'/'.$url_amigavel.'" data-js-accordion-input '.((isset($_GET['url_amigavel']) AND $_GET['url_amigavel']==$url_amigavel)?'checked="checked"':'').'>
                            <span class="position-relative d-block mr-8 border" '.((isset($_GET['url_amigavel']) AND $_GET['url_amigavel']==$url_amigavel)?'style="border-color: #141414!important; color: #141414!important;"':'').'>
                                <i class="'.((isset($_GET['url_amigavel']) AND $_GET['url_amigavel']==$url_amigavel)?'d-flex':'d-none').'">
                                    <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-146" viewBox="0 0 24 24"><path d="M9.703 15.489l-2.5-2.5a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449.13-.117.28-.176.449-.176s.319.059.449.176l2.051 2.07 5.801-5.82c.13-.117.28-.176.449-.176s.319.059.449.176c.117.13.176.28.176.449a.652.652 0 0 1-.176.449l-6.25 6.25a.877.877 0 0 1-.215.127.596.596 0 0 1-.468 0 .93.93 0 0 1-.215-.127z"/></svg>
                                </i>
                            </span>
                            <span style="color: #666; font-size:12px;">'.preconj(ucwords($categoria)).'</span>
                        </label>
                        <i class="collections-menu__arrow">
                            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-229" viewBox="0 0 24 24">
                                <path d="M11.783 14.088l-3.75-3.75a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176l3.301 3.32 3.301-3.32a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176.117.13.176.28.176.449a.652.652 0 0 1-.176.449l-3.75 3.75a.877.877 0 0 1-.215.127.596.596 0 0 1-.468 0 .841.841 0 0 1-.215-.127z"/>
                            </svg>
                        </i>
                    </div>
                    <div class="collections-menu__list '.((isset($_SESSION['categorias']) AND in_array($id, $_SESSION['categorias']))?'':'d-none').' ml-25" data-js-accordion-content>';
                        while($temCat_assoc = mysqli_fetch_assoc($temCat)){
            			    $menu .= monta_menu($conn, $url_loja, $temCat_assoc['id'], $temCat_assoc['categoria'], $temCat_assoc['url_amigavel'], $pagina);
                        }
            $menu .= '</div>
                </div>';
        }else{
            $menu .= '
                <div class="collections-menu__item" data-js-accordion="all" data-section-for-collection="womens">
                    <div class="collections-menu__button d-flex align-items-center mb-15 mb-lg-9 cursor-pointer">
                        <label class="input-checkbox d-flex align-items-center mb-0 mr-0 cursor-pointer">
                            <input type="radio" class="d-none categoria" name="categoria" value="'.$url_loja.'/'.((isset($pagina) AND $pagina=='outlet')?'outlet':'categoria').'/'.$url_amigavel.'" '.((isset($_GET['url_amigavel']) AND $_GET['url_amigavel']==$url_amigavel)?'checked="checked"':'').'>
                            <span class="position-relative d-block mr-8 border" '.((isset($_GET['url_amigavel']) AND $_GET['url_amigavel']==$url_amigavel)?'style="border-color: #141414!important; color: #141414!important;"':'').'>
                                <i class="'.((isset($_GET['url_amigavel']) AND $_GET['url_amigavel']==$url_amigavel)?'d-flex':'d-none').'">
                                    <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-146" viewBox="0 0 24 24"><path d="M9.703 15.489l-2.5-2.5a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449.13-.117.28-.176.449-.176s.319.059.449.176l2.051 2.07 5.801-5.82c.13-.117.28-.176.449-.176s.319.059.449.176c.117.13.176.28.176.449a.652.652 0 0 1-.176.449l-6.25 6.25a.877.877 0 0 1-.215.127.596.596 0 0 1-.468 0 .93.93 0 0 1-.215-.127z"/></svg>
                                </i>
                            </span>
                            <span style="color: #666; font-size:12px;">'.preconj(ucwords($categoria)).'</span>
                        </label>
                    </div>
                </div>';
        }
        return $menu;
    }
    function monta_menu_blog($conn, $url_loja, $id, $categoria, $url_amigavel){
	
    	$menu = '';
    		
    	$temCat = mysqli_query($conn,"SELECT id, categoria, categoria_pai, url_amigavel FROM categorias_blog WHERE categoria_pai='".$id."' AND status='a' ORDER BY categoria ASC");
    	$temCat_num = mysqli_num_rows($temCat);
    
    	if ($temCat_num>0) {
                $menu .= '
                <div class="collections-menu__item" data-js-accordion="all" data-section-for-collection="mens">
                    <div class="collections-menu__button d-flex align-items-center mb-15 mb-lg-9 cursor-pointer '.((isset($_SESSION['categorias']) AND in_array($id, $_SESSION['categorias']))?'open':'').'" data-js-accordion-button>
                        <label class="input-checkbox d-flex align-items-center mb-0 mr-0 cursor-pointer">
                            <input type="radio" class="d-none categoria" name="categoria" value="'.$url_loja.'/blog/categoria/'.$url_amigavel.'" data-js-accordion-input '.((isset($_GET['categoria']) AND $_GET['categoria']==$url_amigavel)?'checked="checked"':'').'>
                            <span class="position-relative d-block mr-8 border">
                                <i class="d-none"><svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-146" viewBox="0 0 24 24"><path d="M9.703 15.489l-2.5-2.5a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449.13-.117.28-.176.449-.176s.319.059.449.176l2.051 2.07 5.801-5.82c.13-.117.28-.176.449-.176s.319.059.449.176c.117.13.176.28.176.449a.652.652 0 0 1-.176.449l-6.25 6.25a.877.877 0 0 1-.215.127.596.596 0 0 1-.468 0 .93.93 0 0 1-.215-.127z"/></svg>
                                </i>
                            </span>
                            <span style="color: #666; font-size:12px;">'.preconj(ucwords($categoria)).'</span>
                        </label>
                        <i class="collections-menu__arrow">
                            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-229" viewBox="0 0 24 24">
                                <path d="M11.783 14.088l-3.75-3.75a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176l3.301 3.32 3.301-3.32a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176.117.13.176.28.176.449a.652.652 0 0 1-.176.449l-3.75 3.75a.877.877 0 0 1-.215.127.596.596 0 0 1-.468 0 .841.841 0 0 1-.215-.127z"/>
                            </svg>
                        </i>
                    </div>
                    <div class="collections-menu__list '.((isset($_SESSION['categorias']) AND in_array($id, $_SESSION['categorias']))?'':'d-none').' ml-25" data-js-accordion-content>';
                        while($temCat_assoc = mysqli_fetch_assoc($temCat)){
            			    $menu .= monta_menu_blog($conn, $url_loja, $temCat_assoc['id'], $temCat_assoc['categoria'], $temCat_assoc['url_amigavel']);
                        }
            $menu .= '</div>
                </div>';
        }else{
            $menu .= '
                <div class="collections-menu__item" data-js-accordion="all" data-section-for-collection="womens">
                    <div class="collections-menu__button d-flex align-items-center mb-15 mb-lg-9 cursor-pointer">
                        <label class="input-checkbox d-flex align-items-center mb-0 mr-0 cursor-pointer">
                            <input type="radio" class="d-none categoria" name="categoria" value="'.$url_loja.'/blog/categoria/'.$url_amigavel.'" '.((isset($_GET['categoria']) AND $_GET['categoria']==$url_amigavel)?'checked="checked"':'').'>
                            <span class="position-relative d-block mr-8 border">
                                <i class="d-none">
                                    <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-146" viewBox="0 0 24 24"><path d="M9.703 15.489l-2.5-2.5a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449.13-.117.28-.176.449-.176s.319.059.449.176l2.051 2.07 5.801-5.82c.13-.117.28-.176.449-.176s.319.059.449.176c.117.13.176.28.176.449a.652.652 0 0 1-.176.449l-6.25 6.25a.877.877 0 0 1-.215.127.596.596 0 0 1-.468 0 .93.93 0 0 1-.215-.127z"/></svg>
                                </i>
                            </span>
                            <span style="color: #666; font-size:12px;">'.preconj(ucwords($categoria)).'</span>
                        </label>
                    </div>
                </div>';
        }
        return $menu;
    }
    ?>