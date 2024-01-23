<?
ob_start();
require_once "includes/config.php";
require_once "includes/funcoes.php";
$onde = 'detalhes';

if (!isset($_GET['url_amigavel'])){$_GET['url_amigavel'] = '';}
if (!isset($_GET['id'])){$_GET['id'] = '';}

$url_amigavel = $_GET['url_amigavel'];
$id= (int)$_GET['id'];

if($id!='' AND $id>0){
    $sql = "SELECT url_amigavel FROM produtos WHERE id='".$id."' AND status='a' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    $dados = mysqli_fetch_assoc($query);
    if (isset($dados['url_amigavel']) AND $dados['url_amigavel']!=''){
        echo "<meta http-equiv='refresh' content='0;URL=".$url_loja."/produto/".$dados['url_amigavel']."'>";
        exit();
    }
}else{
    $sql = "SELECT p.id, p.estrelas_soma, p.avaliacao_qtd, p.quem_avaliou, p.produto, p.preco, p.por, p.qtd_parcela, p.valor_parcela, p.valor_parcela_juros, p.descricao, p.Descricao_seo, p.Titulo_seo, p.palavrasChave_seo, p.qtd_visto, p.qtd, p.qtd_minimo, p.categoria AS id_categoria, c.categoria AS categoria, c.url_amigavel, c.categoria_pai, p.peso, p.altura, p.largura, p.comprimento, p.frete, p.prazo, p.img, p.sku, p.informacoes_adicionais, p.link_compra, p.link_youtube, e.id AS estoque, e.valor, e.tipo, e.operacao FROM categorias AS c RIGHT JOIN produtos AS p ON (p.categoria=c.id) LEFT JOIN estoque AS e ON (p.id=e.produto) WHERE p.url_amigavel='".$url_amigavel."' AND p.status='a' ORDER BY e.tamanho ASC, e.cor ASC, e.id ASC LIMIT 1";
    $query = mysqli_query($conn, $sql);
}
$num_rows = mysqli_num_rows($query);
if ($num_rows<1){
    echo "<meta http-equiv='refresh' content='0;URL=".$url_loja."/produtos'>";
    exit();
}

if (!isset($_POST['acaoAval'])){$_POST['acaoAval'] = '';}

if($_POST['acaoAval']=='acaoAval'){
    $e = $_POST['hdnAval'];
    $pid = $_POST['hdnIDP'];
    $idc = $_SESSION["usr_id_cliente"];
    $dadosProd = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM produtos WHERE id='".$pid."' LIMIT 1"));
    $arrQuem = explode(',',$dadosProd['quem_avaliou']);
    array_push($arrQuem,$idc);
    $quemids = array_unique($arrQuem);
    $quemids = implode(',',$quemids);
    mysqli_query($conn,"UPDATE produtos SET estrelas_soma=estrelas_soma+".(int)$e.", avaliacao_qtd=avaliacao_qtd+1, quem_avaliou='".$quemids."' WHERE id='".$pid."'") or die(mysqli_error($conn));

    $_SESSION['loja_alerta_tem'] = 'sim';
    $_SESSION['loja_alerta_tipo'] = 'success';
    $_SESSION['loja_alerta_titulo'] = 'AVALIAÇÃO';
    $_SESSION['loja_alerta_msg'] = 'Avaliação feita com sucesso!';
    
    echo "<meta http-equiv='refresh' content='0;URL=".$_SERVER['REQUEST_URI']."'>";
    exit();
}

if(mysqli_num_rows($query)==0){  } else{
    while ($dados = mysqli_fetch_assoc($query)) {
        $id_p = $dados['id'];

        $estrelas = $dados['estrelas_soma'];
        $avaliacoes = $dados['avaliacao_qtd'];
        $quemavaliou = $dados['quem_avaliou'];

        $nome_produto = $dados['produto'];
        
        $estoque = ((isset($dados['estoque']) AND $dados['estoque']!='')?$dados['estoque']:'');
        $valor = ((isset($dados['valor']) AND $dados['valor']!='')?$dados['valor']:'');
        $tipo = ((isset($dados['tipo']) AND $dados['tipo']!='')?$dados['tipo']:'');
        $operacao = ((isset($dados['operacao']) AND $dados['operacao']!='')?$dados['operacao']:'');
        
        $preco = estoque($dados['preco'], $valor, $tipo, $operacao);
        $por = estoque($dados['por'], $valor, $tipo, $operacao);

        $qtd_parcela = $dados['qtd_parcela'];
        $valor_parcela = $dados['valor_parcela'];
        $valor_parcela_juros = $dados['valor_parcela_juros'];
        $descricao_return = base64_decode($dados['descricao']);
        $descricao = $descricao_return;
        $Descricao_seo = $dados['Descricao_seo'];
        $qtd_visto = $dados['qtd_visto'];
        $qtd = $dados['qtd'];
        $qtd_minimo = $dados['qtd_minimo'];
        $categoria = $dados['categoria'];
        $id_categoria = $dados['id_categoria'];
        $categoria_pai = $dados['categoria_pai'];
        $url_amigavel_categoria = $dados['url_amigavel'];
        $peso = $dados['peso'];
        $altura = $dados['altura'];
        $largura = $dados['largura'];
        $comprimento = $dados['comprimento'];
        $frete = $dados['frete'];

        $imagem = $dados['img'];
        $img_og = '/assets/img/produtos/'.$dados['img'];

        $titulo_seo = $dados['Titulo_seo'];
        if ($titulo_seo =='') { $titulo_seo = $nome_produto; }
        $Descricao_seo = $dados['Descricao_seo'];
        if ($Descricao_seo=='') { $Descricao_seo = $descricao; }
        $palavras_seo = $dados['palavrasChave_seo'];
        
        $sku = $dados['sku'];
        $informacoes_adicionais = $dados['informacoes_adicionais'];
        
        if (isset($informacoes_adicionais) AND $informacoes_adicionais!=''){
            $informacoes_adicionais = base64_decode($informacoes_adicionais);
        }
        
        $link_compra = $dados['link_compra'];
        $link_youtube = ((isset($dados['link_youtube']) AND $dados['link_youtube']!='')?linkYoutube($dados['link_youtube']):'');
        $qtd_visto=$qtd_visto+1;

        $sql = "UPDATE produtos SET qtd_visto='$qtd_visto' WHERE id='$id_p' limit 1";
        $resultado = mysqli_query($conn,$sql) or die ("Não foi possível realizar a consulta ao banco de dados");
        
        if ($preco<='0.00' && $por<='0.00') {
            $preco_produto = 'Consulte-nos';
            $exibe_preco = '<a href="'.$whats_quero_desconto.'?text=https://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"].'" target="_blank" rel="noopener"><span class="price" data-js-product-price data-js-show-sale-separator><span><span class="money">'.$preco_produto.'</span></span></span></a>';
        } elseif ($preco > '0.00' && $por <= '0.00') {
            $preco_produto = $preco;
            $exibe_preco = '<span class="price" data-js-product-price data-js-show-sale-separator><span><span class="money">R$ '.number_format($preco_produto, 2, ',', '.').'</span></span></span>';
        } elseif ($preco <= '0.00' && $por > '0.00') {
            $preco_produto = $por;
            $exibe_preco = '<span class="price" data-js-product-price data-js-show-sale-separator><span><span class="money">R$ '.number_format($preco_produto, 2, ',', '.').'</span></span></span>';
        } elseif ($preco <= $por) {
            $preco_produto = $preco;
            $exibe_preco = '<span class="price" data-js-product-price data-js-show-sale-separator><span><span class="money">R$ '.number_format($preco_produto, 2, ',', '.').'</span></span></span>';
        } elseif ($preco > $por) {
            $exibe_preco = '
            <span class="price price--sale" data-js-product-price data-js-show-sale-separator" style="text-align: -webkit-left; line-height: 23px;"><span><span class="money mb-5">R$ '.number_format($preco, 2, ',', '.').'</span></span><br><span><span class="money">R$ '.number_format($por, 2, ',', '.').'</span></span></span>';
        } else {
            $preco_produto = $preco;
            $exibe_preco = '<span class="price" data-js-product-price data-js-show-sale-separator><span><span class="money">R$ '.number_format($preco_produto, 2, ',', '.').'</span></span></span>';
        }
        
        if (isset($preco) && $preco!='' && $preco!='0.00' && $por!='0.00' && $preco>$por) {
            $economize = ($preco - $por);
            $economize_porcentagem = ($preco - $por) / $preco * 100;
            $economize_porcentagem = round($economize_porcentagem);
        }else{
            $economize_porcentagem = '';
        }
        
        if (isset($preco) AND $preco>0){
            $preco_final = number_format($preco,2,',','.');
        }
        if (isset($por) AND $por>0){
            $por_final = number_format($por,2,',','.');
        }
        if ($preco<='0.00' && $por<='0.00') {
            $preco_produto_carrinho = '0.00';
        }   
        elseif($preco>'0.00' && $por<='0.00') {
            $preco_produto_carrinho = $preco;
        }
        elseif($preco<='0.00' && $por>'0.00') {
            $preco_produto_carrinho = $por;
        }
        elseif($preco>$por && $por>'0.00'){
            $preco_produto_carrinho = $por;
        }
        elseif($preco<$por && $preco>'0.00'){
            $preco_produto_carrinho = $preco;
        }
        else{
            $preco_produto_carrinho = '0.00';
        }
        
        $img = $imagem;

        $pagina_referencia = 'produtos';

        if ($dados['img']=='') { $imagem = $url_loja.'/assets/img/'.$pagina_referencia.'/sem_imagem.jpg';
        } elseif(file_exists('assets/img/'.$pagina_referencia.'/'.$img)){
            $imagem = $url_loja.'/assets/img/'.$pagina_referencia.'/'.$img;
        } else {
            $imagem = $url_loja."/assets/img/$pagina_referencia/sem_imagem.jpg";
        }  
        if ($dados['peso']=='' || $dados['peso']=='0' || $dados['peso']=='0.00'){$vb_catalogo = 'sim';}
        if ($dados['altura']=='' || $dados['altura']=='0' || $dados['altura']=='0.00'){$vb_catalogo = 'sim';}
        if ($dados['largura']=='' || $dados['largura']=='0' || $dados['largura']=='0.00'){$vb_catalogo = 'sim';}
        if ($dados['comprimento']=='' || $dados['comprimento']=='0' || $dados['comprimento']=='0.00'){$vb_catalogo = 'sim';}
        
        if (!isset($sku) || $sku==''){
            $sku = $id;
        }
    }
}

$query = mysqli_query($conn, "SELECT email, celular, responsavel_nome, sexo, data_nascimento, cep, cidade, estado FROM clientes WHERE id='".$_SESSION['usr_id_cliente']."' AND status='a' LIMIT 1");
if (mysqli_num_rows($query)>0){
    $dados = mysqli_fetch_assoc($query);
}
$email = ((isset($dados['email']) AND $dados['email']!='')?hash('sha256', $dados['email']):'');
$celular = ((isset($dados['celular']) AND $dados['celular']!='')?hash('sha256', clean($dados['celular'])):'');

if (isset($dados['responsavel_nome']) AND $dados['responsavel_nome']!=''){
	$partes_nome = explode(" ", $dados['responsavel_nome']);
    $nome = $partes_nome[0];
    $sobrenome = implode(" ", array_slice($partes_nome, 1));
}
$nome = ((isset($nome) AND $nome!='')?hash('sha256', $nome):'');
$sobrenome = ((isset($sobrenome) AND $sobrenome!='')?hash('sha256', $sobrenome):'');
$sexo = ((isset($dados['sexo']) AND $dados['sexo']!='')?hash('sha256', $dados['sexo']):'');
$data_nascimento = ((isset($dados['data_nascimento']) AND $dados['data_nascimento']!='' AND $data_nascimento!='0000-00-00')?hash('sha256', $dados['data_nascimento']):'');
$cep = ((isset($dados['cep']) AND $dados['cep']!='')?hash('sha256', clean($dados['cep'])):'');
$cidade = ((isset($dados['cidade']) AND $dados['cidade']!='')?hash('sha256', $dados['cidade']):'');
$estado = ((isset($dados['estado']) AND $dados['estado']!='')?hash('sha256', $dados['estado']):'');

$pageviewevent = [
    "event_name" => "PageView",
    "event_time" => time(),
    "user_data" => [
        'client_ip_address' => $_SERVER['REMOTE_ADDR'],
        'client_user_agent' => $_SERVER['HTTP_USER_AGENT'],
        'em' => $email,
        'ph' => $celular,
        'fn' => $nome,
        'ln' => $sobrenome,
        'ge' => $sexo,
        'db' => $data_nascimento,
        'zp' => $cep,
        'ct' => $cidade,
        'st' => $estado
    ],
    'event_source_url' => getEventSourceUrl(),
    "opt_out" => false,
    "event_id" => generateUniqueEventId(),
    "action_source" => "website",
    "data_processing_options" => [],
    "data_processing_options_country" => 0,
    "data_processing_options_state" => 0,
];

$events = [$pageviewevent];
$data = [
    'data' => $events,
    'test_event_code' => TEST_EVENT_CODE
];

$url = 'https://graph.facebook.com/v16.0/'.PIXEL_ID.'/events?access_token='.ACCESS_TOKEN;
$post = json_encode($data);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

$response = curl_exec($ch);
curl_close($ch);

$categorias_pai = array();
function DescobrePai($categorias_pai, $conn, $id, $url_loja){
    $sql_cat = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id, categoria, url_amigavel, categoria_pai FROM categorias WHERE id='$id' AND status='a' LIMIT 1"));
    
    array_push($categorias_pai, '<li><a href="'.$url_loja.'/categoria/'.$sql_cat['url_amigavel'].'" title="'.preconj(ucwords($sql_cat['categoria'])).'">'.preconj(ucwords($sql_cat['categoria'])).'</a></li>');
    $categorias_pai = array_reverse($categorias_pai);
    
    if ($sql_cat['categoria_pai']>0){
        return DescobrePai($categorias_pai, $conn, $sql_cat['categoria_pai'], $url_loja);
    }else{
        return $categorias_pai;
    }
}

$ratingValue = rand(80, 100);
$bestRating = 100;
$ratingCount = rand(2, 9999);
$ratingValueReview = rand(3, 5);
$bestRatingReview = 5;

if (isset($titulo_seo) AND $titulo_seo!=''){
    $titulo_site = $titulo_seo;
}
if (isset($Descricao_seo) AND $Descricao_seo!=''){
    $descricao_site = mb_strimwidth($Descricao_seo, 0, 155, "...");
}
if (isset($palavras_seo) AND $palavras_seo!=''){
    $meta_site = $palavras_seo;
}
 
if (!isset($titulo_site) || $titulo_site==''){$titulo_site = '';}
if (!isset($descricao_site) || $descricao_site==''){$descricao_site = '';}
if (!isset($meta_site) || $meta_site==''){$meta_site= '';}
?>
<!doctype html>
<html class="no-js supports-no-cookies" lang="pt-br">
<head>
<?require_once "includes/head.php";?>
<style>
    .product-options__value{
        background-color: #fff;
    }
</style>
<script>
    window.dataLayer = window.dataLayer || [];
    dataLayer.push({
      event: "view_item",
      ecommerce: {
        items: [{
          produto: "<?=$nome_produto;?>",
          produto_id: "<?=$id_p;?>",
          produto_preco: <?=$preco_produto_carrinho;?>,
          produto_marca: "<?=$nome_loja;?>",
          produto_quantidade: 1
        }]
      }
    });
    fbq('track', 'Purchase', {
        content_ids: ['<?=$id_p;?>'],
        value: <?=$preco_produto_carrinho;?>,
        currency: 'BRL',
        content_type: 'product'
    });
</script>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Product",
        "brand": {
          "@type": "Brand",
          "name": "<?=$nome_loja_completa;?>"
        },
        "name": "<?=$nome_produto;?>",
        "url": "https://www.<?=$dominio;?>/produto/<?=$url_amigavel;?>",
        "image": "<?=$imagem;?>",
        "description": "<?=ucfirst(strip_tags(html_entity_decode(mb_strimwidth("$Descricao_seo", 0, 255, "..."))));?>",
        "sku": "<?if ($sku=='' or $sku=='0'){$sku = $id_p;} echo $sku;?>",
        "productID": "<?=$id_p;?>",
        "mpn": "<?if ($sku=='' or $sku=='0'){$sku = $id_p;} echo $sku;?>",
        "review": [{
            "@type": "Review",
            "reviewRating": {
              "@type": "Rating",
              "ratingValue": "<?=$ratingValueReview;?>"
            },
            "author": {
              "@type": "Person",
              "name": "<?=$nome_loja_completa;?>"
            }
        }],
        "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "<?=$ratingValue;?>",
            "bestRating": "<?=$bestRating;?>",
            "ratingCount": "<?=$ratingCount;?>"
        },
        "offers": {
            "@type": "Offer",
            "availability": "https://schema.org/InStock",
            "price": "<?=$preco_produto_carrinho;?>",
            "url": "https://www.<?=$dominio;?>/produto/<?=$url_amigavel;?>",
            "priceCurrency": "BRL",
            "priceValidUntil": "<?$data = date("Y/m/d");
                                echo date('d/m/Y', strtotime("+30 days",strtotime($data)));?>"
        }
}
</script>
</head>
<body id="trainers-with-heel-detail" class="template-product theme-css-animate" data-currency-multiple="true">
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
    <div itemscope itemtype="https://schema.org/Product">
        <div class="properties" style="display: none;">
            <div itemprop="brand" itemtype="https://schema.org/Brand" itemscope>
                <meta itemprop="name" content="<?=$nome_loja_completa;?>">
            </div>
            <meta itemprop="name" content="<?=trim(ucfirst($nome_produto));?>">
            <meta itemprop="description" content="<?=ucfirst(strip_tags(html_entity_decode($Descricao_seo)));?>">
            <meta itemprop="productID" content ="<?=$id_p;?>">
            <meta itemprop="url" content="https://<?=$_SERVER['HTTP_HOST'];?><?=$_SERVER['REQUEST_URI'];?>">
            <meta itemprop="image" content="<?=$imagem;?>">
            <span itemprop="sku"><?=$sku;?></span>
            <span itemprop="mpn"><?if ($sku=='' or $sku=='0'){$sku = $id_p;} echo $sku;?></span>
            <div itemprop="offers" itemscope itemtype="https://schema.org/Offer">
              <span property="position">1</span>
              <meta itemprop="price" content="<?=$preco_produto_carrinho;?>">
              <meta itemprop="priceCurrency" content="BRL">
              <span itemprop="priceValidUntil" content="<?$data = date("Y/m/d"); echo date('d/m/Y', strtotime("+30 days",strtotime($data)));?>"></span>
                <link itemprop="availability" href="https://schema.org/InStock"/>In stock
            </div>
            <div itemprop="review" itemscope itemtype="https://schema.org/Review">
                <span itemprop="reviewRating" itemscope itemtype="https://schema.org/Rating">
                    <span itemprop="ratingValue"><?=$ratingValueReview;?></span>
                </span>
                <b><span itemprop="name"><?=$nome_produto;?></span></b>
                <span itemprop="author" itemscope itemtype="https://schema.org/Person">
                 <span itemprop="name"><?=$nome_loja_completa;?></span></span>
                <meta itemprop="datePublished" content="<?=date('Y-m-d');?>">
                <span itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                  <meta itemprop="name" content="<?=$nome_loja_completa;?>">
                </span>
            </div>
            <div itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating">
              <span itemprop="ratingValue"><?=$ratingValue;?></span>
              <span itemprop="bestRating"><?=$bestRating;?></span>
              <span itemprop="reviewCount"><?=$ratingCount;?></span>
            </div>
        </div>
    </div>
    <div class="breadcrumbs mt-15">
        <div class="container">
            <ul class="list-unstyled d-flex flex-wrap align-items-center justify-content-start">
                <li><a href="<?=$url_loja;?>" title="Home"><i class="fa-sharp fa-solid fa-house"></i></a></li>
                <li><a href="<?=$url_loja;?>/produtos" title="Produtos">Produtos</a></li>
                <?if (isset($categoria_pai) AND $categoria_pai>0){
                    foreach(DescobrePai($categorias_pai, $conn, $categoria_pai, $url_loja) as $item){
                        echo $item;
                    }
                }?>
                <li><a href="<?=$url_loja;?>/categoria/<?=$url_amigavel_categoria;?>" title="<?=$categoria;?>"><?=$categoria;?></a></li>
                <li><span><?=$nome_produto;?></span></li>
            </ul>
        </div>
    </div>
    <div id="theme-section-product" class="theme-section">
        <div data-section-id="product" data-section-type="product-page" data-enable-history-state="true">
            <div class="product-page my-lg-30">
                <div class="container">
                    <div class="product-page__container">
                        <div class="product-page__main">
                            <div class="product-page-main" data-js-product data-js-product-json-preload data-product-handle="trainers-with-heel-detail" data-product-variant-id="13519976726580" data-js-product-clone-id="footbar">
                                <div class="row">
                                    <div class="col-12 col-lg-6" data-sticky-sidebar-parent>
                                        <div class="js-sticky-sidebar" data-top-spacing="10" data-disable-moz>
                                            <div data-sticky-sidebar-inner>
                                                <div class="product-page-gallery mx-auto pb-20" data-js-product-gallery data-active-image="0">
                                                    <div class="row" style="justify-content: flex-end;">
                                                        <div class="col-12 col-lg-12 d-flex justify-content-end align-items-center">
                                                            <div class="collection-control__sort-by d-lg-block mr-10" data-js-collection-sort-by>
                                                                <div class="select position-relative js-dropdown js-select">
                                                                    <div class="d-flex align-items-center justify-content-end" data-js-dropdown-button>
                                                                        <label for="SortBy" class="mb-0 mr-3" onclick="Compartilhar();" data-js-tooltip data-tippy-content="Compartilhar" data-tippy-placement="top" data-tippy-distance="1">
                                                                            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-195" viewBox="0 0 24 24">
                                                                                <path d="M16.577 8.81a3.746 3.746 0 0 1-1.299-1.123l-5.879 2.949c.052.169.091.345.117.527a4.013 4.013 0 0 1-.117 1.659l5.879 2.949a3.728 3.728 0 0 1 3.028-1.543c1.028 0 1.911.368 2.646 1.104.735.735 1.104 1.618 1.104 2.646s-.368 1.911-1.104 2.646c-.736.735-1.618 1.104-2.646 1.104-1.029 0-1.911-.368-2.646-1.104-.736-.735-1.104-1.618-1.104-2.646 0-.195.013-.384.039-.566.026-.183.065-.358.117-.527l-5.879-2.949c-.339.469-.771.843-1.299 1.123s-1.104.42-1.729.42c-1.029 0-1.911-.368-2.646-1.104-.736-.735-1.104-1.618-1.104-2.646s.368-1.911 1.104-2.646c.735-.735 1.618-1.104 2.646-1.104.625 0 1.201.14 1.729.42s.96.654 1.299 1.123l5.879-2.949a3.45 3.45 0 0 1-.117-.527 4.013 4.013 0 0 1-.039-.566c0-1.028.368-1.911 1.104-2.646.735-.735 1.618-1.104 2.646-1.104 1.028 0 1.911.368 2.646 1.104.735.735 1.104 1.618 1.104 2.646s-.368 1.911-1.104 2.646c-.736.735-1.618 1.104-2.646 1.104a3.641 3.641 0 0 1-1.729-.42zM5.806 14.229c.481 0 .915-.124 1.299-.371.384-.247.68-.566.889-.957.013-.013.02-.032.02-.059.013-.026.026-.042.039-.049.013-.007.02-.017.02-.029.078-.156.137-.322.176-.498s.059-.354.059-.537c0-.169-.017-.339-.049-.508a2.178 2.178 0 0 0-.146-.469.51.51 0 0 1-.098-.136c0-.026-.007-.046-.02-.059a2.548 2.548 0 0 0-.889-.957 2.369 2.369 0 0 0-1.3-.371c-.69 0-1.279.244-1.768.732s-.732 1.077-.732 1.768.244 1.279.732 1.768 1.077.732 1.768.732zM16.538 3.712c-.488.488-.732 1.077-.732 1.767s.244 1.279.732 1.768 1.077.732 1.768.732c.69 0 1.279-.244 1.768-.732s.732-1.077.732-1.768-.244-1.279-.733-1.767-1.078-.732-1.768-.732a2.404 2.404 0 0 0-1.767.732zm0 12.5c-.488.488-.732 1.077-.732 1.768s.244 1.279.732 1.768 1.077.732 1.768.732c.69 0 1.279-.244 1.768-.732s.732-1.077.732-1.768-.244-1.279-.732-1.768-1.078-.732-1.768-.732a2.405 2.405 0 0 0-1.768.732z"></path>
                                                                            </svg>
                                                                        </label>
                                                                    </div>
                                                                    <div class="select__dropdown dropdown d-none position-lg-absolute top-lg-100 mr-10" data-js-dropdown data-js-select-dropdown>
                                                                        <div class="p-10 d-flex justify-content-center">
                                                                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?=$_SERVER['HTTP_HOST'];?><?=$_SERVER['REQUEST_URI'];?>" title="Compartilhar no Facebook" target="_blank" rel="noopener" class="p-5 text-center m-5 d-flex justify-content-center align-items-end align-content-center" style="background-color: #3b5998; width: 32px; height: 32px;"><i style="font-size: 22px; color:#FFF;" class="fa-brands fa-facebook-f"></i></a>
                                                                            <a href="whatsapp://send?text=Compartilhado de <?=$nome_loja_completa;?>%0a%0ahttps://<?=$_SERVER['HTTP_HOST'];?><?=$_SERVER['REQUEST_URI'];?>" title="Compartilhar no WhatsApp" target="_blank" rel="noopener" class="p-5 text-center m-5 d-flex justify-content-center align-items-end align-content-center" style="background-color: #25d366; width: 32px; height: 32px;"><i style="font-size: 22px; color:#FFF;" class="fa-brands fa-whatsapp"></i></a>
                                                                            <a href="https://t.me/share/url?url=https://<?=$_SERVER['HTTP_HOST'];?><?=$_SERVER['REQUEST_URI'];?>" title="Compartilhar no Telegram" target="_blank" rel="noopener" class="p-5 text-center m-5 d-flex justify-content-center align-items-end align-content-center" style="background-color: #1c93e3; width: 32px; height: 32px;"><i style="font-size: 21px; color:#FFF;" class="fa-brands fa-telegram"></i></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="product-collection__button-add-to-wishlist">
                                                            <?if (isset($_SESSION["usr_id_cliente"]) AND $_SESSION["usr_id_cliente"]>0){?>
                                                                <a href="<?=$url_loja;?>/favoritos" onclick="Favoritar('<?=$id_p;?>');" title="Favoritar" class="button-quick-view pl-0 pr-0 btn btn--text btn--status rounded-circle js-store-lists-add-wishlist" data-js-tooltip data-tippy-content="Favoritar" data-tippy-placement="top" data-tippy-distance="-3">
                                                            <?}else{?>
                                                                <a href="<?=$url_loja;?>/favoritos" title="Favoritar" data-js-popup-button="account" class="button-quick-view pl-0 pr-0 btn btn--text btn--status rounded-circle js-popup-button" data-js-tooltip data-tippy-content="Favoritar" data-tippy-placement="top" data-tippy-distance="-3">
                                                            <?}?>
                                                                <i class="mb-1 ml-1">
                                                                    <svg style="fill: #141414 !important;" aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-180" viewBox="0 0 24 24">
                                                                        <path d="M21.486 6.599a5.661 5.661 0 0 0-1.25-1.865c-.56-.56-1.191-.979-1.895-1.26a5.77 5.77 0 0 0-4.326 0c-.71.28-1.345.7-1.904 1.26-.026.039-.056.075-.088.107l-.107.107-.107-.107a.706.706 0 0 1-.088-.107c-.56-.56-1.194-.979-1.904-1.26s-1.433-.42-2.168-.42-1.455.14-2.158.42-1.335.7-1.895 1.26c-.547.546-.964 1.168-1.25 1.865s-.43 1.429-.43 2.197.144 1.501.43 2.197.703 1.318 1.25 1.865l7.871 7.871c.003.003.007.004.011.006l.439.436.439-.437c.003-.002.007-.003.01-.006l7.871-7.871c.547-.547.964-1.169 1.25-1.865s.43-1.429.43-2.197-.145-1.5-.431-2.196zm-1.162 3.916a4.436 4.436 0 0 1-.967 1.445l-7.441 7.441-7.441-7.441c-.417-.417-.739-.898-.967-1.445s-.342-1.12-.342-1.719.114-1.172.342-1.719.55-1.035.967-1.465c.442-.43.94-.755 1.494-.977s1.116-.332 1.689-.332a4.496 4.496 0 0 1 3.467 1.641c.098.117.186.241.264.371.117.169.293.254.527.254s.41-.085.527-.254c.078-.13.166-.254.264-.371s.198-.228.303-.332a4.5 4.5 0 0 1 3.164-1.309c.573 0 1.136.11 1.689.332s1.052.547 1.494.977c.417.43.739.918.967 1.465s.342 1.12.342 1.719-.114 1.172-.342 1.719z" />
                                                                    </svg>
                                                                </i>
                                                                <i class="mb-1 ml-1" data-button-content="added">
                                                                    <svg aria-hidden="true" focusable="false" style="fill: red;" role="presentation" class="icon icon-theme-181" viewBox="0 0 24 24">
                                                                        <path d="M21.861 6.568a5.661 5.661 0 0 0-1.25-1.865c-.56-.56-1.191-.979-1.895-1.26a5.77 5.77 0 0 0-4.326 0c-.71.28-1.345.7-1.904 1.26-.026.039-.056.075-.088.107l-.107.107-.107-.107a.706.706 0 0 1-.088-.107c-.56-.56-1.194-.979-1.904-1.26s-1.433-.42-2.168-.42-1.455.14-2.158.42-1.335.7-1.895 1.26c-.547.547-.964 1.169-1.25 1.865s-.43 1.429-.43 2.197.144 1.501.43 2.197.703 1.318 1.25 1.865l7.871 7.871c.003.003.007.004.011.006l.439.436.439-.437c.003-.002.007-.003.01-.006l7.871-7.871c.547-.547.964-1.169 1.25-1.865s.43-1.429.43-2.197-.145-1.499-.431-2.196z" />
                                                                    </svg>
                                                                </i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex text-webkit-center">
                                                        <div class="product-page-gallery__preview position-relative d-none d-lg-block mr-10" style="max-height: 485px;">
                                                            <div class="h-100 invisible" data-js-product-gallery-preview>
                                                                <div class="mb-10 cursor-lg-pointer current" data-js-product-gallery-preview-image data-js-product-gallery-image-id="4166097928244">
                                                                    <div class="rimage" style="height: 68px;">
                                                                        <img src="<?=$imagem;?>" class="rimage__img rimage__img--fade-in lazyload" id="<?=$img;?>" data-master="<?=$imagem;?>" data-aspect-ratio="0.78125" data-srcset="<?=$imagem;?>" alt="<?=$nome_produto;?>" title="<?=$nome_produto;?>" style="width: 100%; height:auto; position: relative;">
                                                                    </div>
                                                                </div>
                                                                <?
                                                                $pasta = 'assets/img/produtos/'.$id_p.'/'; 
                                                                $arquivos = glob("$pasta{*.jpg,*.png,*.gif,*.bmp,*.webp}", GLOB_BRACE);
                                                                $count = 0;
                                                                foreach($arquivos as $img){
                                                                    $array_img[$count] = $img;
                                                                    $array_qtd[$count] = rand(99999, 9999999);
                                                                    $img_id = explode('assets/img/produtos/'.$id_p.'/', $img)
                                                                ?>
                                                                    <div class="mb-10 cursor-lg-pointer" data-js-product-gallery-preview-image data-js-product-gallery-image-id="<?=$array_qtd[$count];?>" id="<?=$img_id[1];?>">
                                                                        <div class="rimage" style="height: 68px;">
                                                                            <img src="<?=$url_loja;?>/<?=$img;?>" class="rimage__img rimage__img--fade-in lazyload" data-master="<?=$url_loja;?>/<?=$img;?>" data-aspect-ratio="0.78125" data-srcset="<?=$url_loja;?>/<?=$img;?>" alt="<?=$nome_produto;?>" title="<?=$nome_produto;?>" style="width: 100%; height:auto; position: relative;">
                                                                        </div>
                                                                    </div>
                                                                <?$count++;}?>
                                                            </div>
                                                            <div class="product-page-gallery__preview-arrows position-absolute bottom-0 w-100 d-flex flex-center">
                                                                <div class="d-flex cursor-lg-pointer" data-js-product-gallery-preview-btn-prev>
                                                                    <i>
                                                                        <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-230" viewBox="0 0 24 24">
                                                                            <path d="M8.149 14.264a.65.65 0 0 1-.449-.176.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449l3.75-3.75a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176l3.75 3.75c.117.13.176.28.176.449a.652.652 0 0 1-.176.449.877.877 0 0 1-.215.127.596.596 0 0 1-.468 0 .877.877 0 0 1-.215-.127l-3.301-3.32-3.301 3.32a.654.654 0 0 1-.449.176z"/>
                                                                        </svg>
                                                                    </i>
                                                                </div>
                                                                <div class="d-flex cursor-lg-pointer" data-js-product-gallery-preview-btn-next>
                                                                    <i>
                                                                        <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-229" viewBox="0 0 24 24">
                                                                            <path d="M11.783 14.088l-3.75-3.75a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176l3.301 3.32 3.301-3.32a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176.117.13.176.28.176.449a.652.652 0 0 1-.176.449l-3.75 3.75a.877.877 0 0 1-.215.127.596.596 0 0 1-.468 0 .841.841 0 0 1-.215-.127z"/>
                                                                        </svg>
                                                                    </i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="product-page-gallery__main">
                                                            <div class="position-relative">
                                                                <div class="invisible" data-js-product-gallery-main data-arrows="true" data-fullscreen="true" data-js-product-gallery-btn-fullscreen data-index-id='[4166097928244<?if (isset($array_qtd) AND $array_qtd!=''){foreach($array_qtd as $qtd_img){echo ",".$qtd_img;}}?>]' data-zoom-images='["<?=$imagem;?>"<?if (isset($array_img) AND $array_img!=''){foreach($array_img as $img_interna){echo ',"'.$url_loja.'/'.$img_interna.'"';}}?>]' data-zoom="true">
                                                                    <img src="<?=$imagem;?>" srcset="<?=$imagem;?>" data-full="<?=$imagem;?>" alt="<?=$nome_produto;?>" title="<?=$nome_produto;?>" style="top:0 !important;">
                                                                    <?
                                                                    $pasta = 'assets/img/produtos/'.$id_p.'/'; 
                                                                    $arquivos = glob("$pasta{*.jpg,*.png,*.gif,*.bmp,*.webp}", GLOB_BRACE);
                                                                    foreach($arquivos as $img){
                                                                    ?>
                                                                        <img src="<?=$url_loja;?>/<?=$img;?>" srcset="<?=$url_loja;?>/<?=$img;?>, <?=$url_loja;?>/<?=$img;?>" data-full="<?=$url_loja;?>/<?=$img;?>" alt="<?=$nome_produto;?>" title="<?=$nome_produto;?>">
                                                                    <?}?>
                                                                </div>
                                                                <div class="product-image__overlay-top position-absolute d-flex flex-wrap top-0 left-0 w-100 px-10 pt-10">
                                                                    <div class="product-image__overlay-top-left product-collection__labels position-relative d-flex flex-column align-items-start mb-10">
                                                                        <div class="d-flex align-items-center cursor-pointer" data-js-product-gallery-btn-fullscreen style="z-index: 999; background-color: #dddfe0; border-radius: 100%; padding: 5px;">
                                                                            <i>
                                                                                <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-166" viewBox="0 0 24 24">
                                                                                    <path d="M13.316 2.475a8.177 8.177 0 0 1 2.588 1.738 8.172 8.172 0 0 1 1.738 2.588 7.97 7.97 0 0 1 .635 3.164 7.836 7.836 0 0 1-.527 2.861 8.355 8.355 0 0 1-1.426 2.412l4.902 4.902c.117.131.176.28.176.449s-.059.319-.176.449c-.065.052-.137.095-.215.127s-.156.049-.234.049-.156-.017-.234-.049-.149-.075-.215-.127l-4.902-4.902c-.703.6-1.507 1.074-2.412 1.426s-1.858.527-2.861.527a7.945 7.945 0 0 1-3.164-.635 8.144 8.144 0 0 1-2.588-1.738 8.15 8.15 0 0 1-1.738-2.588 7.962 7.962 0 0 1-.635-3.164A7.97 7.97 0 0 1 2.663 6.8 8.16 8.16 0 0 1 4.4 4.213a8.177 8.177 0 0 1 2.588-1.738c.99-.423 2.044-.635 3.164-.635s2.175.212 3.164.635zM3.814 12.641c.358.834.85 1.563 1.475 2.188s1.354 1.117 2.188 1.475c.833.358 1.726.537 2.676.537s1.843-.179 2.676-.537c.833-.357 1.563-.85 2.188-1.475s1.116-1.354 1.475-2.188a6.705 6.705 0 0 0 .537-2.676c0-.95-.179-1.842-.537-2.676-.358-.833-.85-1.563-1.475-2.188s-1.354-1.116-2.188-1.475c-.834-.356-1.726-.536-2.677-.536s-1.842.18-2.675.537c-.833.358-1.563.85-2.188 1.475S4.173 6.456 3.814 7.289a6.712 6.712 0 0 0-.537 2.676c0 .951.179 1.843.537 2.676zm9.278-3.116a.601.601 0 0 1 .186.439c0 .17-.062.316-.186.439a.601.601 0 0 1-.439.186h-1.875v1.875c0 .17-.062.316-.186.439-.124.124-.271.186-.439.186s-.315-.062-.439-.186a.598.598 0 0 1-.186-.439V10.59H7.652a.6.6 0 0 1-.439-.186.598.598 0 0 1-.186-.439.6.6 0 0 1 .186-.439.6.6 0 0 1 .439-.186h1.875V7.465a.6.6 0 0 1 .186-.439c.124-.124.27-.186.439-.186s.315.063.439.186a.601.601 0 0 1 .186.439V9.34h1.875c.169 0 .316.062.44.185z"/>
                                                                                </svg>
                                                                            </i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="absolute-stretch d-none d-lg-block" data-js-product-gallery-zoom></div>
                                                                <div class="product-page-gallery__main-arrow position-absolute d-flex flex-center left-0 ml-10 rounded-circle overflow-hidden cursor-pointer" data-js-product-gallery-main-btn-prev>
                                                                    <i class="position-relative mr-1">
                                                                        <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-006" viewBox="0 0 24 24">
                                                                            <path d="M16.736 3.417a.652.652 0 0 1-.176.449l-8.32 8.301 8.32 8.301c.117.13.176.28.176.449s-.059.319-.176.449a.91.91 0 0 1-.215.127c-.078.032-.156.049-.234.049s-.156-.017-.234-.049a.93.93 0 0 1-.215-.127l-8.75-8.75a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449l8.75-8.75a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176.117.13.176.28.176.449z"/>
                                                                        </svg>
                                                                    </i>
                                                                </div>
                                                                <div class="product-page-gallery__main-arrow position-absolute d-flex flex-center right-0 mr-10 rounded-circle overflow-hidden cursor-pointer" data-js-product-gallery-main-btn-next>
                                                                    <i class="position-relative ml-4">
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
                                                        name: "plugin_fotorama"
                                                    });
                                                    Loader.require({
                                                        type: "style",
                                                        name: "plugin_slick"
                                                    });
                                                    Loader.require({
                                                        type: 'script',
                                                        name: 'plugin_fotorama'
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="product-page-info">
                                            <div class="product-page-info__labels d-flex justify-content-lg-start align-items-center">
                                                <div class="label label--sale mb-3 mr-3 text-nowrap" data-js-product-label-sale id="economize_porcentagem" style="<?echo((isset($economize_porcentagem) AND $economize_porcentagem!='')?'':'display:none;')?>"><?if (isset($economize_porcentagem) AND $economize_porcentagem!=''){?>- <?=$economize_porcentagem;?>%<?}?></div>
                                                <div class="label label--in-stock mb-3 mr-3 text-nowrap" data-js-product-label-in-stock>Em estoque</div>
                                                <label class="m-0">SKU:</label>&nbsp;<p class="m-0" data-js-product-sku><span><?=$sku;?></span></p>
                                            </div>
                                            <div class="product-page-info__title mb-35 text-lg-left">
                                                <h1 class="h3 m-0"><?=$nome_produto;?></h1>
                                                <?php
                              
                                                if(isset($avaliacoes) AND $avaliacoes==0){
                                                  $estrela = 5;
                                                }else{
                                                  $estrela = $estrelas / $avaliacoes;
                                                  $estrela = ceil($estrela);
                                                }

                                                switch($estrela){
                                                  case '0':
                                                    $e1 = '#f2f2f2';
                                                    $e2 = '#f2f2f2';
                                                    $e3 = '#f2f2f2';
                                                    $e4 = '#f2f2f2';
                                                    $e5 = '#f2f2f2';
                                                    break;
                                                  case '1':
                                                    $e1 = 'gold';
                                                    $e2 = '#f2f2f2';
                                                    $e3 = '#f2f2f2';
                                                    $e4 = '#f2f2f2';
                                                    $e5 = '#f2f2f2';
                                                    break;
                                                  case '2':
                                                    $e1 = 'gold';
                                                    $e2 = 'gold';
                                                    $e3 = '#f2f2f2';
                                                    $e4 = '#f2f2f2';
                                                    $e5 = '#f2f2f2';
                                                    break;
                                                  case '3':
                                                    $e1 = 'gold';
                                                    $e2 = 'gold';
                                                    $e3 = 'gold';
                                                    $e4 = '#f2f2f2';
                                                    $e5 = '#f2f2f2';
                                                    break;
                                                  case '4':
                                                    $e1 = 'gold';
                                                    $e2 = 'gold';
                                                    $e3 = 'gold';
                                                    $e4 = 'gold';
                                                    $e5 = '#f2f2f2';
                                                    break;
                                                  case '5':
                                                    $e1 = 'gold';
                                                    $e2 = 'gold';
                                                    $e3 = 'gold';
                                                    $e4 = 'gold';
                                                    $e5 = 'gold';
                                                    break;
                                                }
                                              ?>
                                              <div class="starContainer" title="Avaliação do produto <?=$nome_produto;?>: <?=$estrela?> estrela<?=($estrela!=1)?'s':''?> ">
                                                <?
                                                for ($i=1; $i<=5; $i++){
                                                ?>
                                                    <?if (isset($_SESSION["usr_id_cliente"]) AND $_SESSION["usr_id_cliente"]>=1){?>
                                                        <a href="javascript:void(0);" title="Avaliar em <?=$i;?> estrelas" onclick="$('#hdnAval').prop('value','<?=$i;?>');$('#frmAval').submit();">
                                                    <?}else{?>
                                                        <a href="https://<?=$_SERVER['HTTP_HOST']?><?=$_SERVER['REQUEST_URI'];?>" title="Avaliar em <?=$i;?> estrelas" data-js-popup-button="account" class="pl-0 pr-0 btn btn--text btn--status rounded-circle js-popup-button" style="min-height: 14px;" data-js-tooltip data-tippy-content="Avaliar" data-tippy-placement="top" data-tippy-distance="-3">
                                                    <?}
                                                        if ($i==1){echo '<span class="fa fa-star" style="color: '.$e1.'; font-size: 18px;margin-right:5px;"></span>';}
                                                        if ($i==2){echo '<span class="fa fa-star" style="color: '.$e2.'; font-size: 18px;margin-right:5px;"></span>';}
                                                        if ($i==3){echo '<span class="fa fa-star" style="color: '.$e3.'; font-size: 18px;margin-right:5px;"></span>';}
                                                        if ($i==4){echo '<span class="fa fa-star" style="color: '.$e4.'; font-size: 18px;margin-right:5px;"></span>';}
                                                        if ($i==5){echo '<span class="fa fa-star" style="color: '.$e5.'; font-size: 18px;margin-right:5px;"></span>';}
                                                    ?>
                                                    </a>
                                                <?}?>
                                              </div>
                                            </div>
                                            <div class="mb-35">
                                                <div class="product-page-info__price text-lg-left">
                                                    <div id="preco_exibe">
                                                        <?=$exibe_preco;?>
                                                    </div>
                                                    <div class="label label--in-stock mt-10 mb-3 mr-3 text-nowrap" data-js-product-label-sale style="width: fit-content; font-weight: bold; <?echo((isset($economize) AND $economize!='')?'':'display:none;')?>" id="economize"><?if (isset($economize) AND $economize!=''){?>Economia de <span style="color: #fcff00;">R$ <?=number_format($economize, 2, ',', '.');?></span><?}?></div>
                                                </div>
                                            </div>
                                            <div class="border-top border--dashed my-25"></div>
                                                <form method="post" action="" id="carrinho" accept-charset="UTF-8"class="d-flex text-lg-left flex-column w-100 m-0" enctype="multipart/form-data" data-js-product-form="">
                                                        <div class="product-page-info__options">
                                                            <div class="product-options product-options--type-page js-product-options" data-js-change-history>
                                                                <?
                                                                $sql_variacao = mysqli_query($conn, "SELECT e.id, e.qtd, e.valor, e.cor AS id_cor, c.cor, c.rgb, e.tamanho AS id_tamanho, e.img, t.tamanho FROM cores AS c RIGHT JOIN estoque AS e ON (c.id=e.cor) LEFT JOIN tamanhos AS t ON (e.tamanho=t.id) WHERE e.produto='$id_p' AND e.status='a' ORDER BY e.ordem ASC, e.id ASC");
                                                                $num_variacao = mysqli_num_rows($sql_variacao);
                                                                if ($num_variacao>0){
                                                                ?>
                                                                <div>
                                                                    <div class="product-options__section d-flex flex-wrap" data-style="large-text"  id="variacao_<?=$id_p;?>">
                                                                        <?
                                                                        $contador = 0;
                                                                        $temp = '';
                                                                        $temp_cor = '';
                                                                        $array_tamanho = array();
                                                                        $array_tamanho_id = array();
                                                                        $array_cor = array();
                                                                        $array_cor_id = array();
                                                                        while ($dados_variacao=mysqli_fetch_assoc($sql_variacao)){
                                                                            $variacao_id = $dados_variacao['id'];
                                                                            $tamanho = $dados_variacao['tamanho'];
                                                                            $cor = $dados_variacao['cor'];
                                                                            $id_tamanho = $dados_variacao['id_tamanho'];
                                                                            $id_cor = $dados_variacao['id_cor'];
                                                                            $variacao_rgb = $dados_variacao['rgb'];
                                                                            $variacao_qtd = $dados_variacao['qtd'];
                                                                            $variacao_img = 'assets/img/produtos/cores/'.$dados_variacao['img'];
                                                                            
                                                                            if ($dados_variacao['img']!='' AND file_exists('assets/img/produtos/cores/'.$dados_variacao['img'])){
                                                                                $bg = 'url('.$url_loja.'/'.$variacao_img.')';
                                                                            }else{
                                                                                $bg = $variacao_rgb;
                                                                            }
                                                                            
                                                                            if ($temp!=$id_tamanho AND $id_tamanho>0 AND !in_array($id_tamanho, $array_tamanho_id)){
                                                                                array_push($array_tamanho, '<input type="button" onclick="variacao('.$id_tamanho.', '.$variacao_id.', '.$id_p.', '.$id_tamanho.')" class="tamanho product-options__value product-options__value--large-text d-flex flex-center border cursor-pointer lazyload" id="'.$id_tamanho.'" data-estoque="'.$variacao_id.'" value="'.$tamanho.'">');
                                                                                $temp = $id_tamanho;
                                                                                $tamanho_flag = 'sim';
                                                                                array_push($array_tamanho_id, $id_tamanho);
                                                                            }
                                                                            if($id_cor>0){
                                                                                if($id_tamanho>0){
                                                                                    if($id_cor>0 AND $id_cor!=$temp_cor AND !in_array($id_cor, $array_cor_id)){
                                                                                        array_push($array_cor, '
                                                                                        <label class="product-options__value product-options__value--circle rounded-circle text-hide cursor-pointer lazyload" style="background: '.$bg.';" data-js-tooltip="" data-tippy-content="'.mb_convert_case($cor, MB_CASE_TITLE, "UTF-8").'" data-tippy-placement="top" data-tippy-distance="3">
                                                                                            <input type="checkbox" class="cor d-none" name="filtro" onclick="variacao('.$id_cor.', '.$variacao_id.', '.$id_p.', '.$id_tamanho.')" id="'.$id_cor.'" data-estoque="'.$variacao_id.'" value="'.$cor.'">
                                                                                        </label>');
                                                                                        $cor_flag = 'sim';
                                                                                        $temp_cor = $id_cor;
                                                                                        array_push($array_cor_id, $id_cor);
                                                                                    }
                                                                                }else{
                                                                                    $cor_flag = 'sim';
                                                                                    array_push($array_cor, '
                                                                                        <label class="product-options__value product-options__value--circle rounded-circle text-hide cursor-pointer lazyload" style="background: '.$bg.';" data-js-tooltip="" data-tippy-content="'.mb_convert_case($cor, MB_CASE_TITLE, "UTF-8").'" data-tippy-placement="top" data-tippy-distance="3">
                                                                                            <input type="checkbox" class="cor d-none" name="filtro" onclick="variacao('.$id_cor.', '.$variacao_id.', '.$id_p.', '.$id_tamanho.')" id="'.$id_cor.'" data-estoque="'.$variacao_id.'" value="'.$cor.'">
                                                                                        </label>');
                                                                                }
                                                                            }
                                                                            if($contador==0){
                                                                                $qtd_real = $variacao_qtd;
                                                                            }
                                                                            $contador++;
                                                                        }mysqli_free_result($sql_variacao);
                                                                        $cont = 0;
                                                                        foreach ($array_tamanho as $key){
                                                                            if ($cont==0){
                                                                                echo '<div id="tamanhos" style="display: contents;"><label style="width: 100%;"><b>Tamanho:</b></label>';
                                                                            }
                                                                            echo $key;
                                                                            $cont++;
                                                                        }
                                                                        if (count($array_tamanho)>0){
                                                                            echo "</div>";
                                                                        }
                                                                        $cont = 0;
                                                                        foreach ($array_cor as $key){
                                                                            if ($cont==0){
                                                                                echo '<div id="cores" style="display: contents;"><label style="width: 100%;"><b>Cor:</b></label>';
                                                                            }
                                                                            echo $key;
                                                                            $cont++;
                                                                        }
                                                                        if (count($array_cor)>0){
                                                                            echo "</div>";
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <?}else{
                                                                    $qtd_real = $qtd;
                                                                }?>
                                                                <div class="note note--error" style="position: absolute; display: none;" id="required">Escolha uma variação!</div>
                                                            </div>
                                                        </div>
                                                    <?if ($num_variacao>0){?>
                                                        <div class="border-top border--dashed my-25"></div>
                                                    <?}?>
                                                    <?if ($num_variacao>0 AND $qtd_real<100){?>
                                                        <div class="product-page-info__visitors mb-25" id="div_estoque" style="display:none;">
                                                            <div class="visitors text-lg-left">
                                                                <b>ESTOQUE:</b> <span class="visitors__counter d-inline-block px-8" id="qtd_real"><?=$qtd_real;?></span>
                                                            </div>
                                                        </div>
                                                    <?}?>
                                                    <div class="product-page-info__quantity mb-20" id="div_qtd">
                                                        <label for="qtd"><b>QUANTIDADE:</b></label>
                                                        <div class="input-quantity input-quantity--type-01 d-flex js-product-quantity" data-js-quantity-connect="footbar">
                                                            <input type="number" class="mb-0 mr-10" id="qtd" name="qtd" value="<?=$qtd_minimo;?>" min="<?=$qtd_minimo;?>" max="<?=((isset($qtd_real) AND $qtd_real>0)?$qtd_real:$qtd);?>">
                                                            <div class="d-flex flex-center mr-10 border cursor-pointer" data-control="-">
                                                                <i>
                                                                    <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-189" viewBox="0 0 24 24">
                                                                        <path d="M7.13 12.206a.598.598 0 0 1-.186-.439.6.6 0 0 1 .186-.439.605.605 0 0 1 .439-.186h8.75c.169 0 .315.063.439.186a.601.601 0 0 1 .186.439c0 .17-.062.316-.186.439a.601.601 0 0 1-.439.186h-8.75a.6.6 0 0 1-.439-.186z"/>
                                                                    </svg>
                                                                </i>
                                                            </div>
                                                            <div class="d-flex flex-center border cursor-pointer" data-control="+">
                                                                <i>
                                                                    <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-188" viewBox="0 0 24 24">
                                                                        <path d="M7.158 12.206a.598.598 0 0 1-.186-.439.6.6 0 0 1 .186-.439.602.602 0 0 1 .439-.186h3.75v-3.75a.6.6 0 0 1 .186-.439.602.602 0 0 1 .439-.186c.169 0 .315.063.439.186a.605.605 0 0 1 .186.439v3.75h3.75c.169 0 .315.063.439.186a.605.605 0 0 1 .186.439.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186h-3.75v3.75a.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186.597.597 0 0 1-.439-.186.598.598 0 0 1-.186-.439v-3.75h-3.75a.598.598 0 0 1-.439-.186z"/>
                                                                    </svg>
                                                                </i>
                                                            </div>
                                                        </div>
                                                        <div style="position: absolute; display: none; color: #ff0000;" id="qtd_alerta"></div>
                                                    </div>
                                                    <div data-js-footbar-product-limit>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="product-page-info__button-add-to-cart mb-10">
                                                                    <input type="hidden" value="<?=$id_p;?>" name="codigo" id="codigo">
                                                                    <input type="hidden" value="<?=$nome_produto;?>" name="nome" id="nome">
                                                                    <input type="hidden" value="<?=$preco_produto_carrinho;?>" name="preco" id="preco">
                                                                    <input type="hidden" value="<?=$imagem;?>" name="imagem" id="imagem">
                                                                    <input type="hidden" value="" name="cor" id="cor_final">
                                                                    <input type="hidden" value="" name="tamanho" id="tamanho_final">
                                                                    <input type="hidden" value="" data-estoque="<?=$num_variacao;?>" data-tamanho="<?echo ((isset($tamanho_flag))?$tamanho_flag:'nao');?>" data-cor="<?echo ((isset($cor_flag))?$cor_flag:'nao');?>" name="estoque" id="estoque">
                                                                    <div id="botao_adicionar">
                                                                        <?if (isset($qtd_real) AND $qtd_real>0){?>
                                                                            <button type="button" onclick="adicionar_carrinho();" class="btn btn--secondary btn--full btn--status btn--animated  btn-adicionar-carrinho" name="finalizar" data-js-trigger-id="add-to-cart" data-js-button-add-to-cart-clone-id="footbar" data-js-product-button-add-to-cart>
                                                                                <span class="d-flex flex-center">
                                                                                    <i class="btn__icon mr-5 mb-4">
                                                                                        <svg aria-hidden="true" syle="fill: #ff0000 !important;" focusable="false" role="presentation" class="icon icon-theme-109" viewBox="0 0 24 24"><path d="M19.884 21.897a.601.601 0 0 1-.439.186h-15a.6.6 0 0 1-.439-.186.601.601 0 0 1-.186-.439v-15a.6.6 0 0 1 .186-.439.601.601 0 0 1 .439-.186h3.75c0-1.028.368-1.911 1.104-2.646.735-.735 1.618-1.104 2.646-1.104s1.911.368 2.646 1.104c.735.736 1.104 1.618 1.104 2.646h3.75a.6.6 0 0 1 .439.186.601.601 0 0 1 .186.439v15a.604.604 0 0 1-.186.439zM18.819 7.083h-3.125v2.5a.598.598 0 0 1-.186.439c-.124.124-.271.186-.439.186s-.315-.062-.439-.186a.6.6 0 0 1-.186-.439v-2.5h-5v2.5a.598.598 0 0 1-.186.439c-.124.124-.271.186-.439.186s-.315-.062-.439-.186a.6.6 0 0 1-.186-.439v-2.5H5.069v13.75h13.75V7.083zm-8.642-3.018a2.409 2.409 0 0 0-.733 1.768h5c0-.69-.244-1.279-.732-1.768s-1.077-.732-1.768-.732-1.279.244-1.767.732z"/>
                                                                                        </svg>
                                                                                    </i>
                                                                                    <span class="btn__text btn-text-adicionar-carrinho">ADICIONAR AO CARRINHO</span>
                                                                                </span>
                                                                                <span class="d-flex flex-center btn-text-adicionar-carrinho" data-button-content="added">
                                                                                    <i class="mr-5 mb-4">
                                                                                        <svg aria-hidden="true" syle="fill: #ff0000 !important;" focusable="false" role="presentation" class="icon icon-theme-110" viewBox="0 0 24 24"><path d="M19.855 5.998a.601.601 0 0 0-.439-.186h-3.75c0-1.028-.368-1.911-1.104-2.646-.735-.735-1.618-1.104-2.646-1.104s-1.911.369-2.646 1.104c-.736.736-1.104 1.618-1.104 2.647h-3.75a.6.6 0 0 0-.439.186.598.598 0 0 0-.186.439v15a.6.6 0 0 0 .186.439c.124.123.27.186.439.186h15a.6.6 0 0 0 .439-.186.601.601 0 0 0 .186-.439v-15a.602.602 0 0 0-.186-.44zm-9.707-1.953c.488-.488 1.077-.732 1.768-.732s1.279.244 1.768.732.732 1.078.732 1.768h-5c0-.69.244-1.28.732-1.768zm6.926 7.194l-6.25 6.25a.877.877 0 0 1-.215.127.596.596 0 0 1-.468 0 .896.896 0 0 1-.215-.127l-2.5-2.5a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449.13-.117.28-.176.449-.176s.319.059.449.176l2.051 2.07 5.801-5.82c.13-.117.28-.176.449-.176s.319.059.449.176c.117.13.176.28.176.449a.652.652 0 0 1-.176.449z"/>
                                                                                        </svg>
                                                                                    </i>ADICIONADO
                                                                                </span>
                                                                            </button>
                                                                        <?}else{?>
                                                                            <button type="button" onclick="window.open('<?=$link_whats;?>', '_blank');" class="btn btn--secondary btn--full btn--status btn--animated js-product-button-add-to-cart btn-adicionar-carrinho" name="finalizar" data-js-trigger-id="add-to-cart" data-js-button-add-to-cart-clone-id="footbar" data-js-product-button-add-to-cart>
                                                                                <span class="d-flex flex-center">
                                                                                    <i class="btn__icon mr-5 mb-4">
                                                                                        <svg aria-hidden="true" syle="fill: #ff0000 !important;" focusable="false" role="presentation" class="icon icon-theme-109" viewBox="0 0 24 24"><path d="M19.884 21.897a.601.601 0 0 1-.439.186h-15a.6.6 0 0 1-.439-.186.601.601 0 0 1-.186-.439v-15a.6.6 0 0 1 .186-.439.601.601 0 0 1 .439-.186h3.75c0-1.028.368-1.911 1.104-2.646.735-.735 1.618-1.104 2.646-1.104s1.911.368 2.646 1.104c.735.736 1.104 1.618 1.104 2.646h3.75a.6.6 0 0 1 .439.186.601.601 0 0 1 .186.439v15a.604.604 0 0 1-.186.439zM18.819 7.083h-3.125v2.5a.598.598 0 0 1-.186.439c-.124.124-.271.186-.439.186s-.315-.062-.439-.186a.6.6 0 0 1-.186-.439v-2.5h-5v2.5a.598.598 0 0 1-.186.439c-.124.124-.271.186-.439.186s-.315-.062-.439-.186a.6.6 0 0 1-.186-.439v-2.5H5.069v13.75h13.75V7.083zm-8.642-3.018a2.409 2.409 0 0 0-.733 1.768h5c0-.69-.244-1.279-.732-1.768s-1.077-.732-1.768-.732-1.279.244-1.767.732z"/>
                                                                                        </svg>
                                                                                    </i>
                                                                                    <span class="btn__text">CONSULTAR DISPONIBILIDADE</span>
                                                                                </span>
                                                                            </button>
                                                                        <?}?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="product-page-info__button-add-to-cart mb-10">
                                                                    <a href="<?=$whats_quero_desconto;?>?text=Quero%20o%20meu%20desconto!%0Ahttps://<?=$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];?>" id="quero_meu_desconto" target="_blank" rel="noopener" title="Quero meu desconto" class="btn btn--status btn--animated btn-quero-desconto" style="width: 100%;">
                                                                        <span class="d-flex flex-center">
                                                                            <i style="font-size: 22px;" class="btn__icon fa-brands fa-whatsapp"></i>&nbsp;
                                                                            <span class="btn__text btn-text-quero-desconto">QUERO MEU DESCONTO</span>
                                                                        </span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <a href="#" id="abrir_sacola" data-js-popup-button="cart" class="btn btn--full btn--status btn--animated js-popup-button d-none" data-tippy-distance="-3"></a>
                                                    </div>
                                                    <div class="border-top border--dashed my-25"></div>
                                                    <div class="product-page-info__details-buttons mb-lg-15 d-flex flex-wrap justify-content-left justify-content-lg-start">
                                                        <?if (isset($guia_tamanho) AND $guia_tamanho!=''){?>
                                                            <div class="guias btn-link h6 mb-10 px-15 px-lg-10 js-popup-button d-flex align-items-center" data-js-popup-button="size-guide">
                                                                <i>
                                                                    <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-078" viewBox="0 0 24 24">
                                                                        <path d="M2.481 16.107c-.117-.13-.176-.28-.176-.449s.059-.319.176-.449l12.5-12.5c.13-.117.28-.176.449-.176s.319.059.449.176l4.375 4.375c.117.13.176.28.176.449s-.059.319-.176.449l-12.5 12.5c-.065.052-.137.095-.215.127s-.156.049-.234.049-.156-.017-.234-.049-.149-.075-.215-.127l-4.375-4.375zm2.949-2.07l-1.621 1.621 3.496 3.496L18.926 7.533 15.43 4.037l-1.621 1.621 1.445 1.426c.117.13.176.28.176.449s-.059.319-.176.449c-.065.052-.137.095-.215.127s-.156.049-.234.049-.156-.017-.234-.049-.149-.075-.215-.127L12.93 6.537l-.996.996.82.801c.117.13.176.28.176.449s-.059.319-.176.449c-.065.052-.137.095-.215.127s-.156.049-.234.049-.156-.017-.234-.049-.149-.075-.215-.127l-.801-.82-.996.996 1.445 1.426c.117.13.176.28.176.449s-.059.319-.176.449c-.065.052-.137.095-.215.127s-.156.049-.234.049-.156-.017-.234-.049-.149-.075-.215-.127L9.18 10.287l-.996.996.82.801c.117.13.176.28.176.449s-.059.319-.176.449c-.065.052-.137.095-.215.127s-.156.049-.234.049-.156-.017-.234-.049-.149-.075-.215-.127l-.801-.82-.996.996 1.445 1.426c.117.13.176.28.176.449s-.059.319-.176.449c-.065.052-.137.095-.215.127s-.156.049-.234.049-.156-.017-.234-.049-.149-.075-.215-.127L5.43 14.037z"></path>
                                                                    </svg>
                                                                </i> GUIA DE TAMANHOS
                                                            </div>
                                                        <?}?>
                                                        <div class="guias btn-link h6 mb-10 px-15 px-lg-10 js-popup-button d-flex align-items-center" data-js-popup-button="delivery-return">
                                                            <i>
                                                                <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-116" viewBox="0 0 24 24">
                                                                    <path d="M21.93 6.088l.029.029c.007.007.01.017.01.029l.039.127a.47.47 0 0 1 .02.127v15a.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186H2.652a.6.6 0 0 1-.439-.186.601.601 0 0 1-.186-.439v-15a.47.47 0 0 1 .02-.127l.039-.127c0-.013.003-.022.01-.029a.387.387 0 0 0 .029-.029.478.478 0 0 1 .049-.078.844.844 0 0 1 .049-.059l.02-.02 4.375-3.75a.776.776 0 0 1 .195-.117.575.575 0 0 1 .215-.039h10c.078 0 .149.013.215.039.065.026.13.065.195.117l4.375 3.75v.02a.19.19 0 0 1 .068.059.557.557 0 0 1 .049.078zm-1.153 14.687V7.025h-5.625v5.625a.598.598 0 0 1-.186.439.601.601 0 0 1-.439.186h-5a.6.6 0 0 1-.439-.186.6.6 0 0 1-.186-.439V7.025H3.277v13.75h17.5zM7.262 3.275l-2.93 2.5h4.805l1.25-2.5H7.262zm2.89 8.75h3.75v-5h-3.75v5zm1.641-8.75l-1.25 2.5h2.969l-1.25-2.5h-.469zm7.93 2.5l-2.93-2.5h-3.125l1.25 2.5h4.805z"></path>
                                                                </svg>
                                                            </i>&nbsp; FRETE E TAXAS
                                                        </div>
                                                    </div>
                                                    <div class="guias btn-link h6 mb-10 px-15 px-lg-10 js-popup-button d-flex align-items-center" data-js-popup-button="alerta" id="alerta" style="display:none;"></div>
                                                    <?if (isset($frete_gratis) AND $frete_gratis!=''){?>
                                                        <div class="product-page-info__free-shipping mt-10 mb-15">
                                                            <div class="free-shipping position-relative px-6 py-3 text-center text-lg-left js-free-shipping" data-value="20000">
                                                                <div class="free-shipping__progress position-absolute top-0 left-0 h-100" data-js-progress style="width: 0.0%;"></div>
                                                                <div class="free-shipping__text position-relative">
                                                                    <i class="mr-3">
                                                                        <svg aria-hidden="true" focusable="false"
                                                                             role="presentation" class="icon icon-theme-127"
                                                                             viewBox="0 0 24 24">
                                                                            <path d="M21.648 12.672c.104.052.188.13.254.234a.62.62 0 0 1 .098.332v5a.602.602 0 0 1-.186.439.601.601 0 0 1-.439.186h-2.559a3.043 3.043 0 0 1-1.074 1.787 3.03 3.03 0 0 1-1.992.713c-.756 0-1.42-.238-1.992-.713a3.028 3.028 0 0 1-1.074-1.787h-1.309a.597.597 0 0 1-.439-.186.6.6 0 0 1-.186-.439V4.488H2.625a.597.597 0 0 1-.439-.186A.597.597 0 0 1 2 3.863a.6.6 0 0 1 .186-.439.597.597 0 0 1 .439-.186h8.75a.6.6 0 0 1 .439.186c.123.124.186.27.186.439v2.5h5a.614.614 0 0 1 .586.41l1.797 4.766 2.265 1.133zM9.314 9.674c.123.124.186.27.186.439a.602.602 0 0 1-.186.439.601.601 0 0 1-.439.186h-3.75a.597.597 0 0 1-.439-.186.597.597 0 0 1-.186-.439.6.6 0 0 1 .186-.439.598.598 0 0 1 .439-.186h3.75a.6.6 0 0 1 .439.186zm0 3.125c.123.124.186.27.186.439a.602.602 0 0 1-.186.439.601.601 0 0 1-.439.186h-2.5a.597.597 0 0 1-.439-.186.6.6 0 0 1-.186-.439.6.6 0 0 1 .186-.439.598.598 0 0 1 .439-.186h2.5a.6.6 0 0 1 .439.186zm11.436 4.814v-3.984l-2.148-1.074a.635.635 0 0 1-.195-.146.557.557 0 0 1-.117-.205l-1.719-4.59H12v10h.684a3.033 3.033 0 0 1 1.074-1.787 3.026 3.026 0 0 1 1.992-.713 3.03 3.03 0 0 1 1.992.713 3.041 3.041 0 0 1 1.074 1.787h1.934zm-3.936-6.064c.123.124.186.27.186.439a.602.602 0 0 1-.186.439.601.601 0 0 1-.439.186h-2.5a.597.597 0 0 1-.439-.186.6.6 0 0 1-.186-.439v-2.5a.6.6 0 0 1 .186-.439.598.598 0 0 1 .439-.186.6.6 0 0 1 .439.186c.123.124.186.27.186.439v1.875h1.875a.6.6 0 0 1 .439.186zm.264 8.017a1.81 1.81 0 0 0 .547-1.328 1.81 1.81 0 0 0-.547-1.328 1.812 1.812 0 0 0-1.328-.547 1.81 1.81 0 0 0-1.328.547 1.808 1.808 0 0 0-.547 1.328c0 .521.182.964.547 1.328.364.365.807.547 1.328.547s.963-.182 1.328-.547z"/>
                                                                        </svg>
                                                                    </i> <span data-js-text>Na compra de até <span class=money> R$200.00</span> você garante o FRETE GRATIS!</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?}?>
                                                </form>
                                                <div class="d-none guias btn-link h6 mb-10 px-15 px-lg-10 js-popup-button d-flex align-items-center" id="compartilhar" data-js-popup-button="compartilhar"></div>
                                                <div class="loader js-loader animate visible" id="loader_detalhes" style="display: none;">
                                                    <div class="loader__bg" data-js-loader-bg=""></div>
                                                    <div class="loader__spinner animate" data-js-loader-spinner=""><img src="<?=$url_loja;?>/assets/img/preloader.svg" alt="Carregando..." title="Carregando..."></div>
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
                            </div>
                            <?if ($descricao!='' || $informacoes_adicionais!=''){?>
                                <div class="row">
                                    <div class="col-md-<?echo((isset($link_youtube) AND $link_youtube!='')?'6':'12');?>">
                                        <div class="product-page__tabs mt-10">
                                            <div class="tabs product-tabs js-tabs" data-type="horizontal">
                                                <div class="tabs__head" data-js-tabs-head>
                                                    <div class="tabs__slider" data-js-tabs-slider>
                                                        <?if (isset($descricao) AND $descricao!=''){?>
                                                        <div class="tabs__btn" data-js-tabs-btn data-active="true"><b>DESCRIÇÃO</b></div>
                                                        <?}if (isset($informacoes_adicionais) AND $informacoes_adicionais!=''){?>
                                                            <div class="tabs__btn" data-js-tabs-btn><b>INFORMAÇÕES ADICIONAIS</b></div>
                                                        <?}?>
                                                    </div>
                                                    <div class="tabs__nav tabs__nav--prev" data-js-tabs-nav-prev>
                                                        <i>
                                                            <svg aria-hidden="true" focusable="false" role="presentation"
                                                                 class="icon icon-theme-006" viewBox="0 0 24 24">
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
                                                    <?if (isset($descricao) AND $descricao!=''){?>
                                                    <div data-js-tabs-tab>
                                                        <span data-js-tabs-btn-mobile><b>DESCRIÇÃO</b>
                                                            <i>
                                                                <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-188" viewBox="0 0 24 24"><path d="M7.158 12.206a.598.598 0 0 1-.186-.439.6.6 0 0 1 .186-.439.602.602 0 0 1 .439-.186h3.75v-3.75a.6.6 0 0 1 .186-.439.602.602 0 0 1 .439-.186c.169 0 .315.063.439.186a.605.605 0 0 1 .186.439v3.75h3.75c.169 0 .315.063.439.186a.605.605 0 0 1 .186.439.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186h-3.75v3.75a.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186.597.597 0 0 1-.439-.186.598.598 0 0 1-.186-.439v-3.75h-3.75a.598.598 0 0 1-.439-.186z"/>
                                                                </svg>
                                                            </i>
                                                        </span>
                                                        <div class="tabs__content rte overflow-hidden" data-js-tabs-content>
                                                            <?=$descricao;?>
                                                        </div>
                                                    </div>
                                                    <?}if (isset($informacoes_adicionais) AND $informacoes_adicionais!=''){?>
                                                    <div data-js-tabs-tab>
                                                        <span data-js-tabs-btn-mobile><b>INFORMAÇÕES ADICIONAIS</b>
                                                            <i>
                                                                <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-188" viewBox="0 0 24 24"><path d="M7.158 12.206a.598.598 0 0 1-.186-.439.6.6 0 0 1 .186-.439.602.602 0 0 1 .439-.186h3.75v-3.75a.6.6 0 0 1 .186-.439.602.602 0 0 1 .439-.186c.169 0 .315.063.439.186a.605.605 0 0 1 .186.439v3.75h3.75c.169 0 .315.063.439.186a.605.605 0 0 1 .186.439.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186h-3.75v3.75a.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186.597.597 0 0 1-.439-.186.598.598 0 0 1-.186-.439v-3.75h-3.75a.598.598 0 0 1-.439-.186z"/>
                                                                </svg>
                                                            </i>
                                                        </span>
                                                        <div class="tabs__content rte overflow-hidden" data-js-tabs-content>
                                                            <div class="material-info">
                                                                <div class="mb-30 mb-lg-55">
                                                                    <div class="material-info__head-icons d-flex justify-content-between align-items-center mx-auto mb-15">
                                                                        <i class="icon-Dry-06"></i><i class="icon-Dry-37"></i>
                                                                        <i class="icon-Dry-24"></i><i class="icon-Dry-20"></i>
                                                                    </div>
                                                                    <?=$informacoes_adicionais;?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?}?>
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
                                    <?if (isset($link_youtube) AND $link_youtube!=''){?>
                                        <div class="col-md-6">
                                            <div class="product-page__tabs mt-10">
                                                <div class="tabs product-tabs js-tabs" data-type="horizontal">
                                                    <div class="tabs__head" data-js-tabs-head>
                                                        <div class="tabs__slider" data-js-tabs-slider>
                                                            <div class="tabs__btn" data-js-tabs-btn data-active="true"><b>VÍDEO</b></div>
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
                                                        <div data-js-tabs-tab>
                                                            <span data-js-tabs-btn-mobile><b>VÍDEO</b>
                                                                <i>
                                                                    <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-188" viewBox="0 0 24 24"><path d="M7.158 12.206a.598.598 0 0 1-.186-.439.6.6 0 0 1 .186-.439.602.602 0 0 1 .439-.186h3.75v-3.75a.6.6 0 0 1 .186-.439.602.602 0 0 1 .439-.186c.169 0 .315.063.439.186a.605.605 0 0 1 .186.439v3.75h3.75c.169 0 .315.063.439.186a.605.605 0 0 1 .186.439.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186h-3.75v3.75a.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186.597.597 0 0 1-.439-.186.598.598 0 0 1-.186-.439v-3.75h-3.75a.598.598 0 0 1-.439-.186z"/>
                                                                    </svg>
                                                                </i>
                                                            </span>
                                                            <div class="tabs__content rte overflow-hidden" data-js-tabs-content>
                                                                <iframe width="100%" height="500px" src="https://www.youtube.com/embed/<?=$link_youtube;?>?rel=1&autoplay=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                                            </div>
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
                                    <?}?>
                                </div>
                            <?}?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            Loader.require({
                type: "script",
                name: "product"
            });
        </script>
    </div>
    <?
    $sql2 = "SELECT DISTINCT id,img, img_secundaria,url_amigavel,produto,preco,por,qtd,cor,tamanho,sku,sistema,link_compra,forma FROM produtos WHERE categoria='$id_categoria' AND status='a' LIMIT 8";
    $query2 = mysqli_query($conn, $sql2);
    $num_rows = mysqli_num_rows($query2);
    if ($num_rows>=1) {
    ?>
    <div id="theme-section-carousel-related-products" class="theme-section">
        <div data-section-id="carousel-related-products" data-section-type="carousel-products" data-postload="carousel_products">
            <div class="container">
                <div class="carousel carousel-products position-relative mt-30 pb-60 mt-lg-0">
                    <div class="border-top mb-40"></div>
                    <div class="carousel__head row justify-content-center mb-25" style="width: 100%;">
                        <h2 class="carousel__title h4 col-auto mb-10 text-center" style="letter-spacing: 5px;"><b>RELACIONADOS</b></h2>
                    </div>
                    <div class="carousel__slider position-relative invisible" data-js-carousel data-autoplay="true" data-speed="5000" data-count="4" data-infinite="true" data-arrows="true" data-bullets="true">
                        <div class="carousel__prev d-none position-absolute cursor-pointer" data-js-carousel-prev><i>
                            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-006"
                                 viewBox="0 0 24 24">
                                <path d="M16.736 3.417a.652.652 0 0 1-.176.449l-8.32 8.301 8.32 8.301c.117.13.176.28.176.449s-.059.319-.176.449a.91.91 0 0 1-.215.127c-.078.032-.156.049-.234.049s-.156-.017-.234-.049a.93.93 0 0 1-.215-.127l-8.75-8.75a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449l8.75-8.75a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176.117.13.176.28.176.449z"/>
                            </svg>
                        </i></div>
                        <div class="carousel__products overflow-hidden">
                            <div class="carousel__slick row" data-js-carousel-slick data-carousel-products-items
                                 data-max-count="6" data-products-pre-row="4" data-async-ajax-loading="true">
                                <?
                                    while ($dados2 = mysqli_fetch_assoc($query2)) {
                                        $nome_produto = $dados2['produto'];
                                        $nome_produto = ucwords($nome_produto);
                                        $preco = $dados2['preco'];
                                        $por = $dados2['por'];
                                        $qtd = $dados2['qtd'];
                                        $id = $dados2['id'];
                                        $url_amigavel = $dados2['url_amigavel'];
                                        $forma = $dados2['forma'];
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
                                        <div class="carousel__item col-auto carrossel-produtos-home">
                                            <div class="product-collection d-flex flex-column" data-js-product data-js-product-json-preload data-product-handle="<?=$id;?>" data-product-variant-id="<?=$id;?>">
                                                <div class="div-img-carrossel product-collection__image product-image product-image--hover-emersion-z position-relative w-100 js-product-images-navigation js-product-images-hovered-end js-product-images-hover" data-js-product-image-hover="<?=$img_interna;?>" data-js-product-image-hover-id="<?=$id;?>">
                                                    <a href="<?=$url;?>" title="<?=$nome_produto;?>" class="d-block cursor-default div-img-carrossel" data-js-product-image>
                                                        <div class="rimage">
                                                            <img src="<?=$imagem;?>" data-master="<?=$imagem;?>" data-aspect-ratio="" data-srcset="<?=$imagem;?>" data-image-id="<?=$id;?>" alt="<?=$nome_produto;?>" title="<?=$nome_produto;?>" class="rimage__img rimage__img--contain rimage__img--fade-in lazyload">
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
                                                                <a href="<?=$url_loja;?>/favoritos" title="Favoritar" onclick="Favoritar('<?=$id;?>');" style="background-color: <?=$cor_site;?>;" class="button-quick-view pl-0 pr-0 btn btn--text btn--status rounded-circle js-store-lists-add-wishlist" data-js-tooltip data-tippy-content="Favoritar" data-tippy-placement="top" data-tippy-distance="-3">
                                                            <?}else{?>
                                                                <a href="<?=$url_loja;?>/favoritos" title="Favoritar" style="background-color: <?=$cor_site;?>;" data-js-popup-button="account" class="button-quick-view pl-0 pr-0 btn btn--text btn--status rounded-circle js-popup-button" data-js-tooltip data-tippy-content="Favoritar" data-tippy-placement="top" data-tippy-distance="-3">
                                                            <?}?>
                                                                    <i class="mb-1 ml-1">
                                                                        <svg style="fill: #fff !important;" aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-180" viewBox="0 0 24 24">
                                                                            <path d="M21.486 6.599a5.661 5.661 0 0 0-1.25-1.865c-.56-.56-1.191-.979-1.895-1.26a5.77 5.77 0 0 0-4.326 0c-.71.28-1.345.7-1.904 1.26-.026.039-.056.075-.088.107l-.107.107-.107-.107a.706.706 0 0 1-.088-.107c-.56-.56-1.194-.979-1.904-1.26s-1.433-.42-2.168-.42-1.455.14-2.158.42-1.335.7-1.895 1.26c-.547.546-.964 1.168-1.25 1.865s-.43 1.429-.43 2.197.144 1.501.43 2.197.703 1.318 1.25 1.865l7.871 7.871c.003.003.007.004.011.006l.439.436.439-.437c.003-.002.007-.003.01-.006l7.871-7.871c.547-.547.964-1.169 1.25-1.865s.43-1.429.43-2.197-.145-1.5-.431-2.196zm-1.162 3.916a4.436 4.436 0 0 1-.967 1.445l-7.441 7.441-7.441-7.441c-.417-.417-.739-.898-.967-1.445s-.342-1.12-.342-1.719.114-1.172.342-1.719.55-1.035.967-1.465c.442-.43.94-.755 1.494-.977s1.116-.332 1.689-.332a4.496 4.496 0 0 1 3.467 1.641c.098.117.186.241.264.371.117.169.293.254.527.254s.41-.085.527-.254c.078-.13.166-.254.264-.371s.198-.228.303-.332a4.5 4.5 0 0 1 3.164-1.309c.573 0 1.136.11 1.689.332s1.052.547 1.494.977c.417.43.739.918.967 1.465s.342 1.12.342 1.719-.114 1.172-.342 1.719z" />
                                                                        </svg>
                                                                    </i>
                                                                    <i class="mb-1 ml-1" data-button-content="added">
                                                                        <svg aria-hidden="true" style="fill: white;" focusable="false" role="presentation" class="icon icon-theme-181" viewBox="0 0 24 24">
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
                                                        <h2 class="h6 m-0">
                                                            <a href="<?=$url;?>" title="<?=$nome_produto;?>" class="titulo-produto"><?echo mb_strimwidth("$nome_produto", 0, 80, "...");?></a>
                                                        </h2>
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
                                                                            <svg aria-hidden="true" focusable="false" style="fill: #fff !important;" role="presentation" class="icon icon-theme-109" viewBox="0 0 24 24"><path d="M19.884 21.897a.601.601 0 0 1-.439.186h-15a.6.6 0 0 1-.439-.186.601.601 0 0 1-.186-.439v-15a.6.6 0 0 1 .186-.439.601.601 0 0 1 .439-.186h3.75c0-1.028.368-1.911 1.104-2.646.735-.735 1.618-1.104 2.646-1.104s1.911.368 2.646 1.104c.735.736 1.104 1.618 1.104 2.646h3.75a.6.6 0 0 1 .439.186.601.601 0 0 1 .186.439v15a.604.604 0 0 1-.186.439zM18.819 7.083h-3.125v2.5a.598.598 0 0 1-.186.439c-.124.124-.271.186-.439.186s-.315-.062-.439-.186a.6.6 0 0 1-.186-.439v-2.5h-5v2.5a.598.598 0 0 1-.186.439c-.124.124-.271.186-.439.186s-.315-.062-.439-.186a.6.6 0 0 1-.186-.439v-2.5H5.069v13.75h13.75V7.083zm-8.642-3.018a2.409 2.409 0 0 0-.733 1.768h5c0-.69-.244-1.279-.732-1.768s-1.077-.732-1.768-.732-1.279.244-1.767.732z"/></svg>
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
                                        <?if ($num_rows==1) {?><div class="carousel__item col-auto carrossel-produtos-home" style="display: none;"></div><?}?>
                                <?} mysqli_free_result($query2);?>
                            </div>
                        </div>
                        <div class="carousel__next d-none position-absolute cursor-pointer" data-js-carousel-next>
                            <i>
                                <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-007" viewBox="0 0 24 24">
                                    <path d="M6.708 20.917c0-.169.059-.319.176-.449l8.32-8.301-8.32-8.301a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176l8.75 8.75c.117.13.176.28.176.449a.652.652 0 0 1-.176.449l-8.75 8.75a.91.91 0 0 1-.215.127c-.078.032-.156.049-.234.049s-.156-.017-.234-.049a.91.91 0 0 1-.215-.127.652.652 0 0 1-.176-.449z"/>
                                </svg>
                            </i>
                        </div>
                    </div>
                    <div class="loader visible">
                        <div class="loader__bg"></div>
                        <div class="loader__spinner animate"></div>
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
    <?}?>
    <form id="frmAval" method="post" action="">
		<input type="hidden" name="hdnAval" id="hdnAval" value="">
		<input type="hidden" name="hdnIDP" value="<?=$id_p;?>">
		<input type="hidden" name="acaoAval" value="acaoAval">
	</form>
</main>
<?require_once "includes/footer.php"?>
<script>
function imagemAncora(id) {
    var minhaDiv = document.getElementById(id);

    var eventoMouseDown = new MouseEvent("mousedown", {
        view: window,
        bubbles: true,
        cancelable: true
    });
    minhaDiv.dispatchEvent(eventoMouseDown);

    setTimeout(function() {
        var eventoMouseUp = new MouseEvent("mouseup", {
            view: window,
            bubbles: true,
            cancelable: true
        });
        minhaDiv.dispatchEvent(eventoMouseUp);
    }, 0);
}
</script>
<script src="<?=$url_loja;?>/assets/scripts/variacoes.js"></script>
<script>
function Compartilhar(){
    var janela = $(window).width();
    if(janela<1000){
        $('#compartilhar').click();
    }
}
function alertaQtd(){
    let valor = parseInt($('#qtd').prop('value'));
    let maximo = parseInt($('#qtd').attr('max'));
    let minimo = parseInt($('#qtd').attr('min'));
    if (valor>maximo){
        $('#qtd_alerta').html('Máximo disponível no estoque!');
        $('#qtd_alerta').show();
        $('#qtd').addClass('error');
        setTimeout(function() {
           $('#qtd_alerta').hide();
           $('#qtd_alerta').html('');
           $('#qtd').removeClass('error');
        }, 4000);
    }else if (valor<minimo){
        $('#qtd_alerta').html('Quantidade mínima para compra');
        $('#qtd_alerta').show();
        $('#qtd').addClass('error');
        setTimeout(function() {
           $('#qtd_alerta').hide();
           $('#qtd_alerta').html('');
           $('#qtd').removeClass('error');
        }, 4000);
    }
}
$('#qtd').on({
    change: function() {
        alertaQtd();
    } 
});
</script>
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