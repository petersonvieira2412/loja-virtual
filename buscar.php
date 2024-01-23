<?
ob_start();
require_once "includes/config.php";
$onde = 'buscar';

if (!isset($_GET['categoria'])){$_GET['categoria'] = '';}
if (!isset($_GET['pagina'])){$_GET['pagina'] = '1';}
if (!isset($_GET['item'])){$_GET['item'] = '';}
$valor_pesquisar = $_GET['item'];
$valor_pesquisar = str_replace('-',' ',$valor_pesquisar);
$categoria = $_GET['categoria'];

if (!isset($_SESSION["loja_opcao_ordem"]) || $_SESSION["loja_opcao_ordem"]==''){
    $_SESSION["loja_opcao_ordem"] = '4';
}

if (!isset($_GET['ordenar']) || $_GET['ordenar']==''){
    $ordenar = $_SESSION["loja_opcao_ordem"];
}else{
    $ordenar = $_GET['ordenar'];
}

if (isset($_SESSION['filtro']) AND $_SESSION['filtro']!=''){
    $flag = 'p.';
}else{
    $flag = '';
}
if ($ordenar=='0') {
	$order=" ORDER BY ".$flag."destaque DESC, ".$flag."ordem ASC, ".$flag."por ASC, ".$flag."preco ASC ";
}
elseif ($ordenar=='1') {
   $order=" ORDER BY ".$flag."destaque DESC, ".$flag."ordem ASC, ".$flag."por DESC, ".$flag."preco DESC ";
}
elseif ($ordenar=='2') {
   $order=" ORDER BY ".$flag."destaque DESC, ".$flag."ordem ASC, ".$flag."produto ASC ";
}
elseif ($ordenar=='3') {
   $order=" ORDER BY ".$flag."destaque DESC, ".$flag."ordem ASC, ".$flag."produto DESC ";
}
 elseif ($ordenar=='4') {
   $order=" ORDER BY ".$flag."destaque DESC, ".$flag."ordem ASC, ".$flag."qtd_visto DESC ";
}
elseif ($ordenar=='5') {
	$order=" ORDER BY ".$flag."destaque DESC, ".$flag."ordem ASC, ".$flag."qtd_vendido DESC ";
}else{
	$ordenar='4';
	$order=" ORDER BY ".$flag."destaque DESC, ".$flag."ordem ASC, ".$flag."qtd_visto DESC ";
}

$pagina = $_GET['pagina'];

if (isset($categoria) AND $categoria!="") {
	$nome_categoria = "SELECT categoria, img, descricao_site, meta_site FROM categorias WHERE id='$categoria' LIMIT 1";
	$queryc = mysqli_query($conn,$nome_categoria);
	$dadosc = mysqli_fetch_assoc($queryc);
	$nome_cat = $dadosc['categoria'];
    $titulo_site = $nome_cat;
    
    $descricao_site = $dadosc['descricao_site'];
    $meta_site = $dadosc['meta_site'];
    if (isset($dadosc['img']) AND $dadosc['img']!=''){
        $img_og = $url_loja.'/assets/img/categorias/'.$dadosc['img'];
    }else{
        $img_og = $url_loja.'/assets/img/categorias/sem_imagem.jpg';
    }
}

if (!isset($nome_cat)){$nome_cat = '';}
if (!isset($titulo_site)){$titulo_site = '';}

$nome_pagina = clean($valor_pesquisar);

$ip = $_SERVER['REMOTE_ADDR'];
$ip_endereco = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$data_busca = date("Y-m-d");
$hora_busca = date("H:i:s");

function getBrowser() { 
    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }
    
    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Internet Explorer'; 
        $ub = "MSIE"; 
    } 
    elseif(preg_match('/Firefox/i',$u_agent)) 
    { 
        $bname = 'Mozilla Firefox'; 
        $ub = "Firefox"; 
    } 
    elseif(preg_match('/Chrome/i',$u_agent)) 
    { 
        $bname = 'Google Chrome'; 
        $ub = "Chrome"; 
    } 
    elseif(preg_match('/Safari/i',$u_agent)) 
    { 
        $bname = 'Apple Safari'; 
        $ub = "Safari"; 
    } 
    elseif(preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Opera'; 
        $ub = "Opera"; 
    } 
    elseif(preg_match('/Netscape/i',$u_agent)) 
    { 
        $bname = 'Netscape'; 
        $ub = "Netscape"; 
    }else{
        $bname = 'Indefinido'; 
        $ub = "Indefinido"; 
    }
    
    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }
    
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            if (!isset($matches['version'][0])){
                $matches['version'][0] = "Indefinido";
            }
            $version= $matches['version'][0];
        }
        else {
            if (!isset($matches['version'][1])){
                $matches['version'][1] = "Indefinido";
            }
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }
    
    // check if we have a number
    if ($version==null || $version=="") {$version="?";}
    
    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'   => $pattern
    );
} 
$ua=getBrowser();

if (!isset($titulo_site) || $titulo_site==''){$titulo_site = 'Busca por '.$valor_pesquisar;}
if (!isset($descricao_site) || $descricao_site==''){$descricao_site = 'Produtos relacionas à '.$valor_pesquisar;}
if (!isset($meta_site) || $meta_site==''){$meta_site= '';}
?>
<!doctype html>
<html class="no-js supports-no-cookies" lang="pt-br">
<head>
    <?require_once "includes/head.php";?>
    <style>
        @media (min-width: 767px){
            .width-produtos{
                max-width: 276px !important;
            }
        }
    </style>
</head>
<body id="women-39-s" class="template-collection theme-css-animate" data-currency-multiple="true">
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
    <div class="collections js-collections pb-10">
        <div data-js-collection-replace="breadcrumbs" data-js-collection-replace-only-full>
            <div class="breadcrumbs mt-15">
                <div class="container">
                    <ul class="list-unstyled d-flex flex-wrap align-items-center justify-content-start">
                        <li><a href="<?=$url_loja;?>" title="Home"><i class="fa-sharp fa-solid fa-house"></i></a></li>
                        <li><a href="produtos" title="Produtos">Produtos</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container mt-10 mt-lg-25">
            <div class="row mb-40">
                
                <?require_once "includes/sidebar.php";?>

                <div class="collections__body col pb-25">
                    <div id="theme-section-collection-body" class="theme-section">
                        <div data-section-id="collection-body" data-section-type="collection-body">
                            <div class="collection-body js-products-view">
                                <div class="collection-control mb-25 mb-lg-30 border-bottom">
                                    <div class="row">
                                        <div class="col-8 col-lg d-flex d-lg-flex align-items-center">
                                            <div class="collection-control__sort-by d-none d-lg-flex align-items-center mr-20" data-js-collection-sort-by>
                                                <i class="fa-solid fa-chevron-right"></i>&nbsp;<h1 class="titulo_categoria"><?=$titulo_site;?></h1>
                                            </div>
                                        </div>
                                        <div class="col-4 col-lg d-flex justify-content-lg-end align-items-center">
                                            <div class="collection-control__sort-by d-none d-lg-block mr-20" data-js-collection-sort-by>
                                                <div class="select position-relative js-dropdown js-select">
                                                    <div class="d-flex align-items-center" data-js-dropdown-button>
                                                        <label for="SortBy" class="mb-0 mr-3">Filtrar:</label>
                                                        <select name="ordenar" class="p-0 pr-25 mb-0 border-0 cursor-pointer" id="ordenar" style="min-width: 100px;">
                                                            <option value="manual" <?echo (($ordenar=='0')?'selected':'');?>>Menor Preço</option>
                                                            <option value="best-selling" <?echo (($ordenar=='1')?'selected':'');?>>Maior Preço</option>
                                                            <option value="price-ascending" <?echo (($ordenar=='2')?'selected':'');?>>Nome A-Z</option>
                                                            <option value="price-descending" <?echo (($ordenar=='3')?'selected':'');?>>Nome Z-A</option>
                                                            <option value="created-ascending" <?echo (($ordenar=='4')?'selected':'');?>>Mais Vistos</option>
                                                            <option value="created-descending" <?echo (($ordenar=='5')?'selected':'');?>>Mais Vendidos</option>
                                                        </select>
                                                        <i class="position-absolute right-0">
                                                            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-229" viewBox="0 0 24 24">
                                                                <path d="M11.783 14.088l-3.75-3.75a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176l3.301 3.32 3.301-3.32a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176.117.13.176.28.176.449a.652.652 0 0 1-.176.449l-3.75 3.75a.877.877 0 0 1-.215.127.596.596 0 0 1-.468 0 .841.841 0 0 1-.215-.127z"/>
                                                            </svg>
                                                        </i>
                                                    </div>
                                                    <div class="select__dropdown dropdown d-none position-lg-absolute top-lg-100 left-lg-0" data-js-dropdown data-js-select-dropdown>
                                                        <div class="px-15 pb-30 py-lg-15">
                                                            <a href="<?=$url_loja;?>/buscar/<?=$nome_pagina;?>/<?=$pagina;?>/0" title="Menor Preço"><span data-value="Menor Preço" <?echo (($ordenar=='0')?'class="selected"':'');?>>Menor Preço</span></a>
                                                            <a href="<?=$url_loja;?>/buscar/<?=$nome_pagina;?>/<?=$pagina;?>/1" title="Maior Preço"><span data-value="Maior Preço" <?echo (($ordenar=='1')?'class="selected"':'');?>>Maior Preço</span></a>
                                                            <a href="<?=$url_loja;?>/buscar/<?=$nome_pagina;?>/<?=$pagina;?>/2" title="Nome A-Z"><span data-value="Nome A-Z" <?echo (($ordenar=='2')?'class="selected"':'');?>>Nome A-Z</span></a>
                                                            <a href="<?=$url_loja;?>/buscar/<?=$nome_pagina;?>/<?=$pagina;?>/3" title="Nome Z-A"><span data-value="Nome Z-A" <?echo (($ordenar=='3')?'class="selected"':'');?>>Nome Z-A</span></a>
                                                            <a href="<?=$url_loja;?>/buscar/<?=$nome_pagina;?>/<?=$pagina;?>/4" title="Mais Vistos"><span data-value="Mais Vistos" <?echo (($ordenar=='4')?'class="selected"':'');?>>Mais Vistos</span></a>
                                                            <a href="<?=$url_loja;?>/buscar/<?=$nome_pagina;?>/<?=$pagina;?>/5" title="Mais Vendidos"><span data-value="Mais Vendidos" <?echo (($ordenar=='5')?'class="selected"':'');?>>Mais Vendidos</span></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="collection-control__view-length d-none d-lg-block" data-js-collection-view-length>
                                                <div class="select position-relative js-dropdown js-select">
                                                    <div class="d-flex align-items-center" data-js-dropdown-button>
                                                        <label for="ViewLength" class="mb-0 mr-5">Página:</label>
                                                        <select name="view_length" class="p-0 pr-25 mb-0 border-0 cursor-pointer" id="ViewLength">
                                                            <option value="<?=$pagina;?>"><?=$pagina;?></option>
                                                        </select>
                                                    </div>
                                                    <div class="select__dropdown dropdown d-none position-lg-absolute top-lg-100 left-lg-0">
                                                        <div class="px-15 pb-30 py-lg-15">
                                                            <span data-value="<?=$pagina;?>"><?=$pagina;?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    Loader.require({
                                        type: "script",
                                        name: "products_view"
                                    });
                                </script>
                                <?
                                    $pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;
									$dados = "INSERT INTO busca (meta, navegador, versao, plataforma, agente, padrao, ip, ip_endereco, data_cadastro, hora, status) VALUES ('$valor_pesquisar', '$ua[name]', '$ua[version]', '$ua[platform]', '$ua[userAgent]', '$ua[pattern]', '$ip', '$ip_endereco', '$data_busca', '$hora_busca', 'a')";
									if(!mysqli_query($conn, $dados)){
										die('Error: '.mysqli_error($conn));
									} 
                                ?>
    								<?
    								$categoria = ($categoria=='')?0:$categoria;
                                    //Selecionar todos os cursos da tabela
                                    
                                    if (isset($_SESSION['filtro'])){
                                        $filtro = '';
                                        $itens = count($_SESSION['filtro']);
                                        for ($i=0; $i<$itens; $i++){
                                            if ($i==0){
                                                $condicao = "AND";
                                            }else{
                                                $condicao = "OR";
                                            }
                                            $filtro .= " $condicao e.id_variacao='".$_SESSION['filtro'][$i]."'";
                                        }
                                    }else{
                                        $filtro = '';
                                    }
                                    if (isset($filtro) AND $filtro!=''){
                                        if (isset($_SESSION['preco']) AND $_SESSION['preco']!=''){
                                            $preco_min = str_replace(",", ".", str_replace(".", "", $_SESSION['preco'][0]));
                                            $preco_max = str_replace(",", ".", str_replace(".", "", $_SESSION['preco'][1]));
                                            $filtro_preco = "AND (CASE
                                                                    WHEN p.por>0 AND p.por<p.preco THEN p.por BETWEEN ".$preco_min." AND ".$preco_max."
                                                                    WHEN p.por>0 AND p.preco<1 THEN p.por BETWEEN ".$preco_min." AND ".$preco_max."
                                                                    ELSE p.preco BETWEEN ".$preco_min." AND ".$preco_max."
                                                                END)";
                                        }else{
                                            $filtro_preco = '';
                                        }
                                        $result = "SELECT p.id FROM produtos AS p INNER JOIN estoque AS e ON (p.id=e.id_produto) WHERE p.status='a' AND (MATCH (p.produto) AGAINST ('~".$valor_pesquisar."~' IN BOOLEAN MODE) OR p.produto LIKE '%".$valor_pesquisar."%' OR p.id LIKE '%".$valor_pesquisar."%' OR p.sku LIKE '%".$valor_pesquisar."%' OR p.sistema LIKE '%".$valor_pesquisar."%' OR p.Descricao_seo LIKE '%".$valor_pesquisar."%') $filtro_preco $filtro GROUP BY p.id";
                                    }else{
                                        if (isset($_SESSION['preco']) AND $_SESSION['preco']!=''){
                                            $preco_min = str_replace(",", ".", str_replace(".", "", $_SESSION['preco'][0]));
                                            $preco_max = str_replace(",", ".", str_replace(".", "", $_SESSION['preco'][1]));
                                            $filtro_preco = "AND (CASE
                                                                    WHEN por>0 AND por<preco THEN por BETWEEN ".$preco_min." AND ".$preco_max."
                                                                    WHEN por>0 AND preco<1 THEN por BETWEEN ".$preco_min." AND ".$preco_max."
                                                                    ELSE preco BETWEEN ".$preco_min." AND ".$preco_max."
                                                                END)";
                                        }else{
                                            $filtro_preco = '';
                                        }
                                        $result = "SELECT id,img,produto,preco,por,sku FROM produtos WHERE status='a' AND (MATCH (produto) AGAINST ('~".$valor_pesquisar."~' IN BOOLEAN MODE) OR produto LIKE '%".$valor_pesquisar."%' OR id LIKE '%".$valor_pesquisar."%' OR sku LIKE '%".$valor_pesquisar."%' OR sistema LIKE '%".$valor_pesquisar."%' OR Descricao_seo LIKE '%".$valor_pesquisar."%') $filtro_preco";
                                    }
                                    $resultado = mysqli_query($conn, $result);
                                    //Contar o total de cursos
                                    $total = mysqli_num_rows($resultado);
                                    //Seta a quantidade de cursos por pagina
                                    $quantidade_pg = 12;
                                    //calcular o número de pagina necessárias para apresentar os cursos
                                    $num_pagina = ceil($total/$quantidade_pg);
                                    //Calcular o inicio da visualizacao
                                    if (isset($pagina) AND $pagina==''){
                                      $pagina = 1;
                                    }
                                    $incio = ($quantidade_pg*$pagina)-$quantidade_pg;
                                    if ($incio<0){$incio = 0;}
                                    
                                    if (isset($filtro) AND $filtro!=''){
                                        $result = "SELECT p.id,p.img,p.img_secundaria,p.produto,p.preco,p.por,p.sku,p.sistema,p.link_compra,p.qtd,p.url_amigavel FROM produtos AS p INNER JOIN estoque AS e ON (p.id=e.id_produto) WHERE p.status='a' AND (MATCH (p.produto) AGAINST ('~".$valor_pesquisar."~' IN BOOLEAN MODE) OR p.produto LIKE '%".$valor_pesquisar."%' OR p.id LIKE '%".$valor_pesquisar."%' OR p.sku LIKE '%".$valor_pesquisar."%' OR p.sistema LIKE '%".$valor_pesquisar."%' OR p.Descricao_seo LIKE '%".$valor_pesquisar."%') $filtro_preco $filtro GROUP BY p.id $order limit $incio, $quantidade_pg";
                                    }else{
                                        $result = "SELECT id,img,img_secundaria,produto,preco,por,sku,sistema,link_compra,qtd,url_amigavel FROM produtos WHERE status='a' AND (MATCH (produto) AGAINST ('~".$valor_pesquisar."~' IN BOOLEAN MODE) OR produto LIKE '%".$valor_pesquisar."%' OR id LIKE '%".$valor_pesquisar."%' OR sku LIKE '%".$valor_pesquisar."%' OR sistema LIKE '%".$valor_pesquisar."%' OR Descricao_seo LIKE '%".$valor_pesquisar."%') $filtro_preco $order limit $incio, $quantidade_pg";
						            }
                                    $resultado = mysqli_query($conn, $result);
                                    $total = mysqli_num_rows($resultado);
                                    
                                    echo '<script>console.log("'.$result.'")</script>';
                                    $temproduto = true;
                                    if ($total>0){
                                    ?>
								    <div class="collection-products" data-js-products>
                                        <div class="row" data-js-collection-replace="products" data-js-collection-replace-method="add" style="display: flex;">
                                            <?
                                            while ($dados2 = mysqli_fetch_assoc($resultado)) {
                                                $nome_produto = $dados2['produto'];
                                                $nome_produto = ucwords($nome_produto);
                                                $preco = $dados2['preco'];
                                                $por = $dados2['por'];
                                                $qtd = $dados2['qtd'];
                                                $id = $dados2['id'];
                                                $sku = $dados2['sku'];
                                                $url_amigavel = $dados2['url_amigavel'];
                                                $img = $dados2['img'];
                                                $img_secundaria = $dados2['img_secundaria'];
                                                $pagina_referencia = 'produtos';
                                                
                                                $url = $url_loja."/produto/".$url_amigavel;
                                                
                                                if ($dados2['img'] == '') {
                                                    $imagem = $url_loja.'/assets/img/' . $pagina_referencia . '/sem_imagem.jpg';
                                                } elseif (file_exists('assets/img/'.$pagina_referencia.'/'.$img.'')) {
                                                    $imagem = $url_loja.'/assets/img/'.$pagina_referencia.'/'.$img.'';
                                                } else {
                                                    $imagem = $url_loja."/assets/img/$pagina_referencia/sem_imagem.jpg";
                                                }
                                                
                                                 $caminho_interno = "assets/img/".$pagina_referencia."/".$id."/";
        
                                                if (isset($img_secundaria) AND $img_secundaria!='sem_imagem.webp' AND file_exists($caminho_interno.$img_secundaria)){
                                                    $img_secundaria = $url_loja."/assets/img/".$pagina_referencia."/".$id."/".$img_secundaria;
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
                                        
                                                //preco_produto
                                                if ($preco <= '0.00' && $por <= '0.00') {
                                                    $preco_produto = 'Consulte-nos';
                                                    $exibe_preco = '<span class="price" data-js-product-price><span><span class="money" >'.$preco_produto.'</span></span></span>';
                                                } elseif ($preco > '0.00' && $por <= '0.00') {
                                                    $preco_produto = $preco;
                                                    $exibe_preco = '<span class="price" data-js-product-price><span><span class="money" >R$ '.number_format($preco_produto, 2, ',', '.').'</span></span></span>';
                                                } elseif ($preco <= '0.00' && $por > '0.00') {
                                                    $preco_produto = $por;
                                                    $exibe_preco = '<span class="price" data-js-product-price><span><span class="money" >R$ '.number_format($preco_produto, 2, ',', '.').'</span></span></span>';
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
                                            ?>
                                                <div class="col-md-4 mb-25 carrossel-produtos-home width-produtos" style="max-width: 80%;">
                                                    <div class="product-collection d-flex flex-column" data-js-product data-js-product-json-preload data-product-handle="<?=$id;?>" data-product-variant-id="<?=$id;?>">
                                                        <div class="div-img-carrossel product-collection__image product-image product-image--hover-emersion-z position-relative w-100 js-product-images-navigation js-product-images-hovered-end js-product-images-hover" data-js-product-image-hover="<?=$img_interna;?>" data-js-product-image-hover-id="<?=$id;?>">
                                                            <a href="<?=$url;?>" title="<?=$nome_produto;?>" class="d-block cursor-default div-img-carrossel" data-js-product-image>
                                                                <div class="rimage">
                                                                    <img src="<?=$imagem;?>" data-master="<?=$imagem;?>" data-aspect-ratio="" data-srcset="<?=$imagem;?>" data-image-id="<?=$id;?>" alt="" class="rimage__img rimage__img--contain rimage__img--fade-in lazyload">
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
                                                                        <a onclick="Favoritar('<?=$id;?>');" style="background-color: <?=$cor_site;?>;" class="button-quick-view pl-0 pr-0 btn btn--text btn--status rounded-circle js-store-lists-add-wishlist" data-js-tooltip data-tippy-content="Favoritar" data-tippy-placement="top" data-tippy-distance="-3">
                                                                    <?}else{?>
                                                                        <a href="#" style="background-color: <?=$cor_site;?>;" data-js-popup-button="account" class="button-quick-view pl-0 pr-0 btn btn--text btn--status rounded-circle js-popup-button" data-js-tooltip data-tippy-content="Favoritar" data-tippy-placement="top" data-tippy-distance="-3">
                                                                    <?}?>
                                                                            <i class="mb-1 ml-1">
                                                                                <svg style="fill: #fff !important;" aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-180" viewBox="0 0 24 24">
                                                                                    <path d="M21.486 6.599a5.661 5.661 0 0 0-1.25-1.865c-.56-.56-1.191-.979-1.895-1.26a5.77 5.77 0 0 0-4.326 0c-.71.28-1.345.7-1.904 1.26-.026.039-.056.075-.088.107l-.107.107-.107-.107a.706.706 0 0 1-.088-.107c-.56-.56-1.194-.979-1.904-1.26s-1.433-.42-2.168-.42-1.455.14-2.158.42-1.335.7-1.895 1.26c-.547.546-.964 1.168-1.25 1.865s-.43 1.429-.43 2.197.144 1.501.43 2.197.703 1.318 1.25 1.865l7.871 7.871c.003.003.007.004.011.006l.439.436.439-.437c.003-.002.007-.003.01-.006l7.871-7.871c.547-.547.964-1.169 1.25-1.865s.43-1.429.43-2.197-.145-1.5-.431-2.196zm-1.162 3.916a4.436 4.436 0 0 1-.967 1.445l-7.441 7.441-7.441-7.441c-.417-.417-.739-.898-.967-1.445s-.342-1.12-.342-1.719.114-1.172.342-1.719.55-1.035.967-1.465c.442-.43.94-.755 1.494-.977s1.116-.332 1.689-.332a4.496 4.496 0 0 1 3.467 1.641c.098.117.186.241.264.371.117.169.293.254.527.254s.41-.085.527-.254c.078-.13.166-.254.264-.371s.198-.228.303-.332a4.5 4.5 0 0 1 3.164-1.309c.573 0 1.136.11 1.689.332s1.052.547 1.494.977c.417.43.739.918.967 1.465s.342 1.12.342 1.719-.114 1.172-.342 1.719z" />
                                                                                </svg>
                                                                            </i>
                                                                            <i class="mb-1 ml-1" data-button-content="added">
                                                                                <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-181" viewBox="0 0 24 24">
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
                                                                        <a href="<?=$url;?>" title="VER DETALHES" class="btn btn--status btn--animated botao-detalhes" style="border-radius:0;">
                                                                            <span class="d-flex flex-center">
                                                                                <i class="btn__icon mr-5 mb-4">
                                                                                    <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-109" viewBox="0 0 24 24"><path d="M19.884 21.897a.601.601 0 0 1-.439.186h-15a.6.6 0 0 1-.439-.186.601.601 0 0 1-.186-.439v-15a.6.6 0 0 1 .186-.439.601.601 0 0 1 .439-.186h3.75c0-1.028.368-1.911 1.104-2.646.735-.735 1.618-1.104 2.646-1.104s1.911.368 2.646 1.104c.735.736 1.104 1.618 1.104 2.646h3.75a.6.6 0 0 1 .439.186.601.601 0 0 1 .186.439v15a.604.604 0 0 1-.186.439zM18.819 7.083h-3.125v2.5a.598.598 0 0 1-.186.439c-.124.124-.271.186-.439.186s-.315-.062-.439-.186a.6.6 0 0 1-.186-.439v-2.5h-5v2.5a.598.598 0 0 1-.186.439c-.124.124-.271.186-.439.186s-.315-.062-.439-.186a.6.6 0 0 1-.186-.439v-2.5H5.069v13.75h13.75V7.083zm-8.642-3.018a2.409 2.409 0 0 0-.733 1.768h5c0-.69-.244-1.279-.732-1.768s-1.077-.732-1.768-.732-1.279.244-1.767.732z"/></svg>
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
                                            <?}mysqli_free_result($resultado);?>
                                        </div>
                                    </div>
                                <?}else{?>
                                    <div class="collection-products" data-js-products>
                                        <?
                                        echo '<div class="row d-flex" style="justify-content: center;">
                                                <div>
										           <h1 class="h3">Nenhum produto encontrado relacionado a '.$valor_pesquisar.' :(</h1>
										           <h4 class="h4">Fique com alguns dos nossos produtos mais visualizados</h4>
										        </div>
										      </div>';
										?>
                                        <div class="row" data-js-collection-replace="products" data-js-collection-replace-method="add" style="display: flex;justify-content: center;">
            								<?
                                            $result = "SELECT id,img,img_secundaria,produto,por,qtd,cor,tamanho,preco,sku,sistema,link_compra FROM produtos WHERE categoria='".$categoria."' AND status='a' ORDER BY qtd_visto DESC LIMIT 9";
                                            $resultado = mysqli_query($conn, $result);
                                            $total = mysqli_num_rows($resultado);
                                            
                                            if($total==0){
											    $result = "SELECT id,img,img_secundaria,produto,por,qtd,preco,url_amigavel FROM produtos WHERE status='a' ORDER BY qtd_visto DESC LIMIT 9";
											    $resultado = mysqli_query($conn,$result);
										    }
										    
										    $temproduto = false;
                                            while ($dados2 = mysqli_fetch_assoc($resultado)) {
                                                $nome_produto = $dados2['produto'];
                                                $nome_produto = ucwords($nome_produto);
                                                $preco = $dados2['preco'];
                                                $por = $dados2['por'];
                                                $qtd = $dados2['qtd'];
                                                $id = $dados2['id'];
                                                $url_amigavel = $dados2['url_amigavel'];
                                                $img = $dados2['img'];
                                                $img_secundaria = $dados2['img_secundaria'];
                                                $pagina_referencia = 'produtos';
                                                
                                                $url = $url_loja."/".$url_amigavel;
                                                
                                                if ($dados2['img'] == '') {
                                                    $imagem = $url_loja.'/assets/img/' . $pagina_referencia . '/sem_imagem.jpg';
                                                } elseif (file_exists('assets/img/'.$pagina_referencia.'/'.$img.'')) {
                                                    $imagem = $url_loja.'/assets/img/'.$pagina_referencia.'/'.$img.'';
                                                } else {
                                                    $imagem = $url_loja."/assets/img/$pagina_referencia/sem_imagem.jpg";
                                                }
                                                
                                                $caminho_interno = "assets/img/".$pagina_referencia."/".$id."/";
                                                
                                                if (isset($img_secundaria) AND $img_secundaria!='sem_imagem.webp' AND file_exists($caminho_interno.$img_secundaria)){
                                                    $img_secundaria = $url_loja."/assets/img/".$pagina_referencia."/".$id."/".$img_secundaria;
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
                                        
                                                //preco_produto
                                                if ($preco <= '0.00' && $por <= '0.00') {
                                                    $preco_produto = 'Consulte-nos';
                                                    $exibe_preco = '<span class="price" data-js-product-price><span><span class="money" >'.$preco_produto.'</span></span></span>';
                                                } elseif ($preco > '0.00' && $por <= '0.00') {
                                                    $preco_produto = $preco;
                                                    $exibe_preco = '<span class="price" data-js-product-price><span><span class="money" >R$ '.number_format($preco_produto, 2, ',', '.').'</span></span></span>';
                                                } elseif ($preco <= '0.00' && $por > '0.00') {
                                                    $preco_produto = $por;
                                                    $exibe_preco = '<span class="price" data-js-product-price><span><span class="money" >R$ '.number_format($preco_produto, 2, ',', '.').'</span></span></span>';
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
                                            ?>
                                                <div class="col-md-4 mb-25 carrossel-produtos-home width-produtos" style="max-width: 80%;">
                                                    <div class="product-collection d-flex flex-column" data-js-product data-js-product-json-preload data-product-handle="<?=$id;?>" data-product-variant-id="<?=$id;?>">
                                                        <div class="div-img-carrossel product-collection__image product-image product-image--hover-emersion-z position-relative w-100 js-product-images-navigation js-product-images-hovered-end js-product-images-hover" data-js-product-image-hover="<?=$img_interna;?>" data-js-product-image-hover-id="<?=$id;?>">
                                                            <a href="<?=$url;?>" title="<?=$nome_produto;?>" class="d-block cursor-default div-img-carrossel" data-js-product-image>
                                                                <div class="rimage" >
                                                                    <img src="<?=$imagem;?>" data-master="<?=$imagem;?>" data-aspect-ratio="" data-srcset="<?=$imagem;?>" data-image-id="<?=$id;?>" alt="" class="rimage__img rimage__img--contain rimage__img--fade-in lazyload">
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
                                                                        <a onclick="Favoritar('<?=$id;?>');" style="background-color: <?=$cor_site;?>;" class="button-quick-view pl-0 pr-0 btn btn--text btn--status rounded-circle js-store-lists-add-wishlist" data-js-tooltip data-tippy-content="Favoritar" data-tippy-placement="top" data-tippy-distance="-3">
                                                                    <?}else{?>
                                                                        <a href="#" style="background-color: <?=$cor_site;?>;" data-js-popup-button="account" class="button-quick-view pl-0 pr-0 btn btn--text btn--status rounded-circle js-popup-button" data-js-tooltip data-tippy-content="Favoritar" data-tippy-placement="top" data-tippy-distance="-3">
                                                                    <?}?>
                                                                            <i class="mb-1 ml-1">
                                                                                <svg style="fill: #fff !important;" aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-180" viewBox="0 0 24 24">
                                                                                    <path d="M21.486 6.599a5.661 5.661 0 0 0-1.25-1.865c-.56-.56-1.191-.979-1.895-1.26a5.77 5.77 0 0 0-4.326 0c-.71.28-1.345.7-1.904 1.26-.026.039-.056.075-.088.107l-.107.107-.107-.107a.706.706 0 0 1-.088-.107c-.56-.56-1.194-.979-1.904-1.26s-1.433-.42-2.168-.42-1.455.14-2.158.42-1.335.7-1.895 1.26c-.547.546-.964 1.168-1.25 1.865s-.43 1.429-.43 2.197.144 1.501.43 2.197.703 1.318 1.25 1.865l7.871 7.871c.003.003.007.004.011.006l.439.436.439-.437c.003-.002.007-.003.01-.006l7.871-7.871c.547-.547.964-1.169 1.25-1.865s.43-1.429.43-2.197-.145-1.5-.431-2.196zm-1.162 3.916a4.436 4.436 0 0 1-.967 1.445l-7.441 7.441-7.441-7.441c-.417-.417-.739-.898-.967-1.445s-.342-1.12-.342-1.719.114-1.172.342-1.719.55-1.035.967-1.465c.442-.43.94-.755 1.494-.977s1.116-.332 1.689-.332a4.496 4.496 0 0 1 3.467 1.641c.098.117.186.241.264.371.117.169.293.254.527.254s.41-.085.527-.254c.078-.13.166-.254.264-.371s.198-.228.303-.332a4.5 4.5 0 0 1 3.164-1.309c.573 0 1.136.11 1.689.332s1.052.547 1.494.977c.417.43.739.918.967 1.465s.342 1.12.342 1.719-.114 1.172-.342 1.719z" />
                                                                                </svg>
                                                                            </i>
                                                                            <i class="mb-1 ml-1" data-button-content="added">
                                                                                <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-181" viewBox="0 0 24 24">
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
                                                                        <a href="<?=$url;?>" title="VER DETALHES" class="btn btn--status btn--animated botao-detalhes" style="border-radius:0;">
                                                                            <span class="d-flex flex-center">
                                                                                <i class="btn__icon mr-5 mb-4">
                                                                                    <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-109" viewBox="0 0 24 24"><path d="M19.884 21.897a.601.601 0 0 1-.439.186h-15a.6.6 0 0 1-.439-.186.601.601 0 0 1-.186-.439v-15a.6.6 0 0 1 .186-.439.601.601 0 0 1 .439-.186h3.75c0-1.028.368-1.911 1.104-2.646.735-.735 1.618-1.104 2.646-1.104s1.911.368 2.646 1.104c.735.736 1.104 1.618 1.104 2.646h3.75a.6.6 0 0 1 .439.186.601.601 0 0 1 .186.439v15a.604.604 0 0 1-.186.439zM18.819 7.083h-3.125v2.5a.598.598 0 0 1-.186.439c-.124.124-.271.186-.439.186s-.315-.062-.439-.186a.6.6 0 0 1-.186-.439v-2.5h-5v2.5a.598.598 0 0 1-.186.439c-.124.124-.271.186-.439.186s-.315-.062-.439-.186a.6.6 0 0 1-.186-.439v-2.5H5.069v13.75h13.75V7.083zm-8.642-3.018a2.409 2.409 0 0 0-.733 1.768h5c0-.69-.244-1.279-.732-1.768s-1.077-.732-1.768-.732-1.279.244-1.767.732z"/></svg>
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
                                            <?}mysqli_free_result($resultado);?>
                                        </div>
                                    </div>
                                <?}?>
                            </div>
                            <?if ($total>0 AND $temproduto==true){
                            $pagina_anterior = $pagina - 1;
                            $pagina_posterior = $pagina + 1;
                            $diferenca_anterior = $pagina - 1;
                            ?>
                                <div data-js-collection-pagination data-pagination-type="button_load_more" data-js-collection-replace="pagination">
                                    <style>
                                        ul:not(.list-unstyled) li::before {
                                            background-color: #fff;
                                            display: none;
                                        }
                                        .page-link:hover {
                                            color: #fff;
                                            background-color: <?=$cor_site;?>;
                                        }
                                        .page-item.active .page-link{
                                            background-color: <?=$cor_site;?>;
                                            border-color: <?=$cor_site;?>;
                                        }
                                    </style>
                                    <div class="pagination justify-content-center">
                                        <div class="d-flex justify-content-center mt-35">
                                            <nav aria-label="Navegação de página exemplo">
                                                <ul class="pagination">
                                                    <?if ($categoria!='') {
                                                        if($pagina_anterior!=0){ ?>
                                                            <li class="page-item" style="padding:0;">
                                                                <a class="page-link" href="<?=$url_loja;?>/buscar/<?=$nome_pagina;?>/<?=$pagina_anterior;?>/<?=((isset($_GET['ordenar']) AND $_GET['ordenar']!='')?$ordenar:'');?>" title="Anterior">Anterior</a>
                                                            </li>
                                                            <?if($diferenca_anterior>2){?>
                                                                <li class="page-item" style="padding:0;">
                                                                    <a class="page-link" href="<?=$url_loja;?>/buscar/<?=$nome_pagina;?>/1/<?=((isset($_GET['ordenar']) AND $_GET['ordenar']!='')?$ordenar:'');?>" title="Página 1">1</a>
                                                                </li>
                                                                <li class="page-item disabled" style="padding:0;">
                                                                    <a class="page-link" disabled>...</a>
                                                                </li>
                                                            <?}?>
                                                        <?}
                                                        if (!isset($num_pagina) || $num_pagina==0){$num_pagina=1;}
                                                        if (!isset($pagina) || $pagina==0){$pagina=1;}
        
                                                        for($i=1; $i<$num_pagina+1; $i++){ 
        
                                                            if ($i==$pagina) {
                                                                $class='active';
                                                            }
                                                            else{
                                                                $class='';
                                                            }
                                                            $minimo = $pagina-3;
                                                            $maximo = $pagina+3;
                                                            $diferenca_posterior = $num_pagina - $pagina_posterior;
                                                            
                                                            if ($i>$minimo AND $i<$maximo){
                                                                if ($num_pagina>1){
                                                        ?>
                                                            <li class="page-item <?=$class?>" style="padding:0;">
                                                                <a class="page-link" href="<?=$url_loja;?>/buscar/<?=$nome_pagina;?>/<?=$i;?>/<?=((isset($_GET['ordenar']) AND $_GET['ordenar']!='')?$ordenar:'');?>" title="Página <?=$i;?>"><?=$i;?></a>
                                                            </li>
                                                        <?}}}
                                                        if($pagina_posterior<=$num_pagina){?>
                                                            <?if($diferenca_posterior>1){?>
                                                                <li class="page-item disabled" style="padding:0;">
                                                                    <a class="page-link" disabled>...</a>
                                                                </li>
                                                                <li class="page-item" style="padding:0;">
                                                                    <a class="page-link" href="<?=$url_loja;?>/buscar/<?=$nome_pagina;?>/<?=$num_pagina;?>/<?=((isset($_GET['ordenar']) AND $_GET['ordenar']!='')?$ordenar:'');?>" title="Página <?=$num_pagina;?>"><?=$num_pagina;?></a>
                                                                </li>
                                                            <?}?>
                                                            <li class="page-item" style="padding:0;">
                                                                <a class="page-link" href="<?=$url_loja;?>/buscar/<?=$nome_pagina;?>/<?=$pagina_posterior;?>/<?=((isset($_GET['ordenar']) AND $_GET['ordenar']!='')?$ordenar:'');?>" title="Próximo">Próximo</a>
                                                            </li>
                                                        <?}
                                                    }?>
                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                    <input type="hidden" name="page" value="1">
                                </div>
                            <?}?>
                        </div>
                        <script>
                            Loader.require({
                                type: "script",
                                name: "collection_body"
                            });
                        </script>

                    </div>
                </div>
            </div>
            <script>
                Loader.require({
                    type: "script",
                    name: "collections"
                });
            </script>
        </div>
    </div>
</main>
<?require_once "includes/footer.php"?>
</body>
</html>
<script>
$(".filtro").change(function() {
    if(this.checked) {
        var marcado = 'sim';
    }else{
        var marcado = 'nao';
    }
    $.ajax({
        type: 'POST',
        url: 'includes/filtro.php',
        data: {
            id: this.value,
            marcado: marcado
        },
        dataType: 'json',
        success: function (data) {
            document.location.reload(true);
        }
    });
});
function Preco(){
    var min = $('#min_preco').prop('value');
    var max = $('#max_preco').prop('value');
    $.ajax({
        type: 'POST',
        url: '<?=$url_loja;?>/includes/filtro.php',
        data: {
            preco: 'preco',
            min: min,
            max: max
        },
        dataType: 'json',
        success: function (data) {
            document.location.reload(true);
        }
    });
}
</script>
<?
$cntACmp =ob_get_contents(); 
ob_end_clean(); 
$cntACmp=str_replace("\n",' ',$cntACmp); 
$cntACmp=preg_replace('/[[:space:]]+/',' ',$cntACmp);
echo $cntACmp; 
ob_end_flush(); 
?>