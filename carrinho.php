<?
ob_start();
require_once "includes/config.php";
require_once "includes/funcoes.php";
$onde='carrinho';

if (isset($_POST['remover_cupom'])) {
    unset($_SESSION['cupom_de_desconto']);
	unset($_SESSION['valor_antigo']);
	unset($_SESSION['cupom_exibe']);
    unset($_SESSION['valor_desconto']);
    unset($_SESSION['cupom_tipo']);
	echo "<meta http-equiv='refresh' content='0;URL=carrinho'>";	
	exit();
}
if (isset($_POST['limpar']) AND $_POST['limpar']=='limpar') {
  $sql_carrinho_excluir = "DELETE FROM carrinho WHERE sessao='".session_id()."' AND id_cliente='".$_SESSION['usr_id_cliente']."'";
  $exec_carrinho_excluir = mysqli_query($conn, $sql_carrinho_excluir) or die(mysqli_error());

  unset($_SESSION['cupom_de_desconto']);
  unset($_SESSION['valor_antigo']);
  unset($_SESSION['total_parcial']);
  unset($_SESSION['cupom_exibe']);
  unset($_SESSION['valor_desconto']);
  unset($_SESSION['cupom_tipo']);

  echo "<meta http-equiv='refresh' content='0;URL=carrinho'>";
  exit();
}

if (isset($_SESSION['usr_id_cliente']) AND $_SESSION['usr_id_cliente']>0) {
    $sql_meu_carrinho = "SELECT *, C.id, C.qtd, P.preco, P.por, E.valor, E.tipo, E.operacao FROM produtos AS P RIGHT JOIN carrinho AS C ON (P.id=C.cod) LEFT JOIN estoque AS E ON (C.estoque=E.id) WHERE sessao = '".session_id()."' AND id_cliente='".$_SESSION['usr_id_cliente']."' ORDER BY nome ASC";
} else{
    $sql_meu_carrinho = "SELECT *, C.id, C.qtd, P.preco, P.por, E.valor, E.tipo, E.operacao FROM produtos AS P RIGHT JOIN carrinho AS C ON (P.id=C.cod) LEFT JOIN estoque AS E ON (C.estoque=E.id) WHERE sessao='".session_id()."' ORDER BY nome ASC";
}
$exec_meu_carrinho =  mysqli_query($conn, $sql_meu_carrinho);
$qtd_carrinho = mysqli_num_rows($exec_meu_carrinho);
$soma_carrinho = 0;
while ($row_rs_produto_carrinho = mysqli_fetch_assoc($exec_meu_carrinho)){
	    
    $valor = $row_rs_produto_carrinho['valor'];
    $tipo = $row_rs_produto_carrinho['tipo'];
    $operacao = $row_rs_produto_carrinho['operacao'];
    
    if (isset($row_rs_produto_carrinho['por']) && $row_rs_produto_carrinho['por']!='' && $row_rs_produto_carrinho['por']!='0.00'){
        if ($row_rs_produto_carrinho['preco']=='0.00' OR $row_rs_produto_carrinho['por']<$row_rs_produto_carrinho['preco']){
            $row_rs_produto_carrinho['preco'] = $row_rs_produto_carrinho['por'];
        }
    }

    if ($row_rs_produto_carrinho['preco']=='' || $row_rs_produto_carrinho['preco']<1){$produto_vazio='sim';}

	$url = clean($row_rs_produto_carrinho['nome']);
	$soma_produto_individual = (estoque($row_rs_produto_carrinho['preco'], $valor, $tipo, $operacao)*$row_rs_produto_carrinho['qtd']);
	$soma_carrinho = $soma_carrinho + $soma_produto_individual;
	if ($soma_carrinho=='0') {
		$exibe_preco = 'CONSULTE-NOS';
		$_SESSION['total_parcial'] = $exibe_preco;
		$total_parcial = $exibe_preco;
	}else{
	    if(isset($_SESSION['cupom_de_desconto']) AND $_SESSION['cupom_de_desconto']!=''){
	        if ($_SESSION['cupom_tipo']=='1') {
                $preco_original = $soma_carrinho; // Preço Original do produto
                $calculo = ($preco_original)-($_SESSION['valor_desconto']) ; //Subtração do valor
                $valor = $calculo;
                 $_SESSION['total_parcial'] = 'R$ '.number_format($valor,2,',','.');
                if ($_SESSION['cupom_de_desconto']=='') {
                    $cupom_exibe='';
                }else{
                    $cupom_exibe = $_SESSION['cupom_exibe'];
                }
                $valor_antigo = 'R$ '.number_format($preco_original,2,',','.');
            }elseif($_SESSION['cupom_tipo']=='2'){
                $preco_original = $soma_carrinho; // Preço Original do produto
                $calculo = ($preco_original)*($_SESSION['valor_desconto'])/100 ; //Multiplicação do valor e desconto dividido por 100
                $valor = ($preco_original)-($calculo); // Para não negativar eu fiz essa subtração
                $_SESSION['total_parcial'] = 'R$ '.number_format($valor,2,',','.');
                if ($_SESSION['cupom_de_desconto']=='') {
                    $cupom_exibe='';
                }else{
                    $cupom_exibe = $_SESSION['cupom_exibe'];
                }
                $valor_antigo = 'R$ '.number_format($preco_original,2,',','.');
            }
		    $exibe_preco = $valor;
		    $total_parcial = $exibe_preco;
	    }else{
		    $exibe_preco = $soma_carrinho;
	    }
		$_SESSION['total_parcial'] = $exibe_preco;
		$total_parcial = $exibe_preco;
	}
}
if (!isset($total_parcial) || $total_parcial==''){
    $total_parcial = 0.00;
}
if (!isset($titulo_site) || $titulo_site==''){$titulo_site = 'Carrinho de compras';}
if (!isset($descricao_site) || $descricao_site==''){$descricao_site = 'Carrinho de compras - '.$nome_loja;}
if (!isset($meta_site) || $meta_site==''){$meta_site= '';}
?>
<!doctype html>
<html class="no-js supports-no-cookies" lang="pt-br"> 
<head>
<?require_once "includes/head.php";?>
<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
</head>
<body id="your-shopping-cart" class="template-cart theme-css-animate" data-currency-multiple="true">
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
    <script>
    Loader.require({
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
    <div class="breadcrumbs mt-15">
        <div class="container">
            <ul class="list-unstyled d-flex flex-wrap align-items-center justify-content-start">
                <li><a href="<?=$url_loja;?>" title="Home"><i class="fa-sharp fa-solid fa-house"></i></a></li>
                <li><span>Carrinho</span></li>
            </ul>
        </div>
    </div>
    <?
    if ($_SESSION['usr_id_cliente']!='' AND $_SESSION['usr_id_cliente']>0){
      $sessao = " AND id_cliente = '".$_SESSION['usr_id_cliente']."' ";
    }else{
      $sessao = "";
    }
    $sql_carrinho = "SELECT *, C.id, C.qtd, C.cor, C.tamanho, P.preco, P.por, P.peso, P.altura, P.largura, P.comprimento, P.qtd_minimo, E.valor, E.operacao, E.tipo, E.img_ancora FROM produtos AS P RIGHT JOIN carrinho AS C ON (P.id=C.cod) LEFT JOIN estoque AS E ON (C.estoque=E.id) WHERE  sessao='".session_id()."'".$sessao."ORDER BY nome ASC";
    $exec_carrinho =  mysqli_query($conn,$sql_carrinho);
    $qtd_carrinho = mysqli_num_rows($exec_carrinho);
    if ($qtd_carrinho>0){
    ?>
        <h1 class="h3 mt-20 mb-30 text-center">CARRINHO COMPRAS</h1>
        <div class="cart mb-60 mb-lg-70">
            <div class="container">
                <div class="row mb-15">
                <?if (!isset($_SESSION["usr_id_cliente"]) || $_SESSION["usr_id_cliente"]<1){?>
                    <div class="col-lg-8 col-xl-9">
                <?}else{?>
                    <div class="col-lg-12 col-xl-12">
                <?}?>
                        <div class="cart__items">
                            <div class="cart__head pb-10 border-bottom">
                                <div class="row">
                                    <div class="d-none d-sm-block col-sm-5 col-lg-4 col-xl-7">
                                        <label class="m-0">Produto</label>
                                    </div>
                                    <div class="col-sm-7 col-lg-8 col-xl-5">
                                        <div class="row">
                                            <div class="col col-sm-4 col-lg-4">
                                                <label class="m-0">Preço</label>
                                            </div>
                                            <div class="col col-sm-4 col-lg-4 text-center text-lg-left">
                                                <label class="m-0">Quantidade</label>
                                            </div>
                                            <div class="col col-sm-4 col-lg-4 text-right">
                                                <label class="m-0">Total</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?
                            $soma_carrinho = 0;
                            while ($row_rs_produto_carrinho = mysqli_fetch_assoc($exec_carrinho)){
                                $id = $row_rs_produto_carrinho['id'];
                                $cod = $row_rs_produto_carrinho['cod'];
                                $nome = $row_rs_produto_carrinho['nome'];
                                $url = $url_loja.'/produto/'.$row_rs_produto_carrinho['url_amigavel'];
                                $qtd = $row_rs_produto_carrinho['qtd'];
                                $qtd_minimo = $row_rs_produto_carrinho['qtd_minimo'];
                                $estoque = $row_rs_produto_carrinho['estoque'];
                                $cor = $row_rs_produto_carrinho['cor'];
                                $tamanho = $row_rs_produto_carrinho['tamanho'];
                                $sku = $row_rs_produto_carrinho['sku'];
                                $valor = $row_rs_produto_carrinho['valor'];
                                $tipo = $row_rs_produto_carrinho['tipo'];
                                $operacao = $row_rs_produto_carrinho['operacao'];
                                $img_ancora = 'assets/img/produtos/'.$cod.'/'.$row_rs_produto_carrinho['img_ancora'];
                                $preco = estoque($row_rs_produto_carrinho['preco'], $valor, $tipo, $operacao);
                                $por = estoque($row_rs_produto_carrinho['por'], $valor, $tipo, $operacao);
                            
                                if (isset($row_rs_produto_carrinho['por']) && $row_rs_produto_carrinho['por']!='' && $row_rs_produto_carrinho['por']!='0.00'){
                                    if ($row_rs_produto_carrinho['preco']=='0.00' OR $row_rs_produto_carrinho['por']<$row_rs_produto_carrinho['preco']){
                                        $row_rs_produto_carrinho['preco'] = $row_rs_produto_carrinho['por'];
                                    }
                                }
                            
                                $soma_produto_individual = (estoque($row_rs_produto_carrinho['preco'], $valor, $tipo, $operacao)*$row_rs_produto_carrinho['qtd']);
                                $soma_carrinho = $soma_carrinho + $soma_produto_individual;
                                $nome_produto = mb_convert_case($row_rs_produto_carrinho['nome'], MB_CASE_TITLE, "UTF-8");
                                
                                if ($preco <= '0.00' && $por <= '0.00') {
                                    $preco_produto = 'Consulte-nos';
                                    $exibe_precoP = '<span class="price-carrinho price" data-js-product-price><span><span class="money">'.$preco_produto.'</span></span></span>';
                                } elseif ($preco > '0.00' && $por <= '0.00') {
                                    $preco_produto = $preco;
                                    $exibe_precoP = '<span class="price-carrinho price" data-js-product-price><span><span class="money">R$ '.number_format($preco_produto, 2, ',', '.').'</span></span></span>';
                                } elseif ($preco <= '0.00' && $por > '0.00') {
                                    $preco_produto = $por;
                                    $exibe_precoP = '<span class="price-carrinho price" data-js-product-price><span><span class="money">R$ '.number_format($preco_produto, 2, ',', '.').'</span></span></span>';
                                } elseif ($preco <= $por) {
                                    $preco_produto = $preco;
                                    $exibe_precoP = '<span class="price-carrinho price" data-js-product-price><span><span class="money">R$ '.number_format($preco_produto, 2, ',', '.').'</span></span></span>';
                                } elseif ($preco > $por) {
                                    $preco_produto = $por;
                                    $exibe_precoP = '<span class="price price--sale" style="font-size: 20px;" data-js-product-price><span><span class="money price-carrinho--sale">R$ '.number_format($preco, 2, ',', '.').'</span></span><br><span><span>R$ '.number_format($por, 2, ',', '.').'</span></span></span>';
                                } else {
                                    $preco_produto = $preco;
                                    $exibe_precoP = '<span class="price-carrinho price" data-js-product-price><span><span class="money">R$ '.number_format($preco_produto, 2, ',', '.').'</span></span></span>';
                                }

                                if ($soma_carrinho=='0') {
                                    $exibe_preco = 'CONSULTE-NOS';
                                }else{
                                    $exibe_preco = 'R$ '.number_format($soma_produto_individual,2,',','.').'';
                                }
                                
                                if($row_rs_produto_carrinho['logo']!=''){
                                    if (file_exists($img_ancora) AND $row_rs_produto_carrinho['img_ancora']!=''){
                                        $imagem = $url_loja.'/'.$img_ancora;
                                    }else{
                                        $imagem = $row_rs_produto_carrinho['logo'];
                                    }
                                }
                                else{
                                  $imagem = 'assets/img/produtos/sem_imagem.jpg';
                                }
                                if ($row_rs_produto_carrinho['peso']=='' || $row_rs_produto_carrinho['peso']=='0' || $row_rs_produto_carrinho['peso']=='0.00'){$vb_catalogo = 'sim';}
                                if ($row_rs_produto_carrinho['altura']=='' || $row_rs_produto_carrinho['altura']=='0' || $row_rs_produto_carrinho['altura']=='0.00'){$vb_catalogo = 'sim';}
                                if ($row_rs_produto_carrinho['largura']=='' || $row_rs_produto_carrinho['largura']=='0' || $row_rs_produto_carrinho['largura']=='0.00'){$vb_catalogo = 'sim';}
                                if ($row_rs_produto_carrinho['comprimento']=='' || $row_rs_produto_carrinho['comprimento']=='0' || $row_rs_produto_carrinho['comprimento']=='0.00'){$vb_catalogo = 'sim';}
                            ?>
                                <div class="py-20 border-bottom product-page-main" id='div_produto_<?=$id;?>'>
                                    <div class="row d-flex align-items-center flex-column flex-sm-row">
                                        <div class="col-sm-5 col-lg-4 col-xl-7 d-flex align-items-center mb-20 mb-sm-0">
                                            <a href="#" onclick="remover_carrinho(<?=$id;?>);" class="mr-20" title="Remover">
                                                <i>
                                                    <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-165" viewBox="0 0 24 24">
                                                        <path d="M4.741 21.654a.601.601 0 0 1-.186-.439v-15h-1.25a.598.598 0 0 1-.439-.186.597.597 0 0 1-.186-.439.6.6 0 0 1 .186-.439.604.604 0 0 1 .439-.186h5v-2.5a.6.6 0 0 1 .186-.439.598.598 0 0 1 .439-.186h6.25c.169 0 .315.063.439.186a.601.601 0 0 1 .186.439v2.5h5c.169 0 .315.063.439.186a.601.601 0 0 1 .186.439c0 .17-.062.316-.186.439a.601.601 0 0 1-.439.186h-1.25v15a.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186H5.18a.598.598 0 0 1-.439-.186zM18.305 6.215h-12.5V20.59h12.5V6.215zM9.37 9.525a.601.601 0 0 1 .186.439v6.875c0 .17-.062.316-.186.439a.601.601 0 0 1-.439.186.598.598 0 0 1-.439-.186.598.598 0 0 1-.186-.439V9.965a.6.6 0 0 1 .186-.439.594.594 0 0 1 .438-.186c.169 0 .316.062.44.185zm.185-4.56h5V3.09h-5v1.875zm2.94 4.56a.601.601 0 0 1 .186.439v6.875c0 .17-.062.316-.186.439a.601.601 0 0 1-.439.186.598.598 0 0 1-.439-.186.598.598 0 0 1-.186-.439V9.965a.6.6 0 0 1 .186-.439.604.604 0 0 1 .439-.186c.168 0 .315.062.439.185zm2.246 0a.604.604 0 0 1 .439-.186c.169 0 .315.063.439.186a.601.601 0 0 1 .186.439v6.875c0 .17-.062.316-.186.439a.601.601 0 0 1-.439.186.598.598 0 0 1-.439-.186.598.598 0 0 1-.186-.439V9.965c0-.169.062-.316.186-.44z"/>
                                                    </svg>
                                                </i>
                                            </a>
                                            <div class="d-flex align-items-center align-items-sm-start align-items-xl-center flex-sm-column flex-xl-row w-100">
                                                <a href="<?=$url;?>" title="<?=$nome;?>" class="cart__image mb-sm-15 mb-xl-0 mr-20 mr-sm-0 mr-xl-20">
                                                    <div class="rimage" style="padding-top:100%;">
                                                        <img src="<?=$imagem;?>" class="rimage__img rimage__img--fade-in lazyload" data-master="<?=$imagem;?>" data-aspect-ratio="0.7798440311937612" data-srcset="<?=$imagem;?>" alt="<?=$nome;?>" title="<?=$nome;?>" style="height: auto; width: 100%;">
                                                    </div>
                                                </a>
                                                <div class="d-flex flex-column">
                                                    <a href="<?=$url;?>" title="<?=$nome;?>"><?=$nome;?></a>
                                                    <?if ((isset($tamanho) AND $tamanho!='') OR (isset($cor) AND $cor!='')){?>
                                                        <p class="mb-0">
                                                            <?if (isset($tamanho) AND $tamanho!=''){?>
                                                                <?=$tamanho;?> 
                                                            <?}?>
                                                            <?if (isset($tamanho) AND $tamanho!=''AND isset($cor) AND $cor!=''){?>
                                                                /
                                                            <?}?>
                                                            <?if (isset($cor) AND $cor!=''){?>
                                                                <?=$cor;?>
                                                            <?}?>
                                                        </p>
                                                    <?}?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-7 col-lg-8 col-xl-5">
                                            <div class="row d-flex align-items-center">
                                                <div class="col col-sm-4 col-lg-4 p-0">
                                                    <?=$exibe_precoP;?>
                                                </div>
                                                <div class="col col-sm-4 col-lg-4">
                                                    <input type="number" class="mb-0 text-center text-sm-left qtd" id="qtd_<?=$id;?>" data-id="<?=$id;?>" data-preco="<?=$preco_produto;?>" data-estoque="<?=$estoque;?>" data-cod="<?=$cod;?>" value="<?=$qtd;?>" min="<?=$qtd_minimo;?>">
                                                    <div class="note note--error" style="display: none; position: absolute;" id="qtd_disponivel_<?=$id;?>">Máximo!</div>
                                                </div>
                                                <div class="col col-sm-4 col-lg-4 text-right p-0">
                                                    <span class="price-carrinho price" data-js-product-price>
                                                        <span>
                                                            <span class="money" id="total_produto_<?=$id;?>"><?=$exibe_preco;?></span>
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?}mysqli_free_result($exec_carrinho);?>
                            <div class="loader js-loader animate visible" id="loader_carrinho" style="display: none;">
                                <div class="loader__bg" data-js-loader-bg=""></div>
                                <div class="loader__spinner animate" data-js-loader-spinner=""><img src="assets/img/preloader.svg" alt="Carregando..." title="Carregando..."></div>
                            </div>
                        </div>
                        <form action="" method="post">
                            <div class="d-flex pt-25">
                                <a href="produtos" class="btn btn--text" title="Continuar Comprando">
                                    <i class="mb-4 mr-4">
                                        <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-012" viewBox="0 0 24 24">
                                            <path d="M21.036 12.569a.601.601 0 0 1-.439.186H4.601l4.57 4.551c.117.13.176.28.176.449a.652.652 0 0 1-.176.449.877.877 0 0 1-.215.127.596.596 0 0 1-.468 0 .877.877 0 0 1-.215-.127l-5.625-5.625a2.48 2.48 0 0 1-.068-.107c-.02-.032-.042-.068-.068-.107a.736.736 0 0 1 0-.468 2.48 2.48 0 0 0 .068-.107c.02-.032.042-.068.068-.107l5.625-5.625a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176.117.13.176.28.176.449a.652.652 0 0 1-.176.449l-4.57 4.551h15.996a.6.6 0 0 1 .439.186.601.601 0 0 1 .186.439.599.599 0 0 1-.186.437z"/>
                                        </svg>
                                    </i>Continuar Comprando
                                </a>
                                <button type="submit" class="btn btn--text ml-auto" name="limpar" value="limpar">
                                    <i class="mb-4 mr-4">
                                        <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-165" viewBox="0 0 24 24">
                                            <path d="M4.741 21.654a.601.601 0 0 1-.186-.439v-15h-1.25a.598.598 0 0 1-.439-.186.597.597 0 0 1-.186-.439.6.6 0 0 1 .186-.439.604.604 0 0 1 .439-.186h5v-2.5a.6.6 0 0 1 .186-.439.598.598 0 0 1 .439-.186h6.25c.169 0 .315.063.439.186a.601.601 0 0 1 .186.439v2.5h5c.169 0 .315.063.439.186a.601.601 0 0 1 .186.439c0 .17-.062.316-.186.439a.601.601 0 0 1-.439.186h-1.25v15a.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186H5.18a.598.598 0 0 1-.439-.186zM18.305 6.215h-12.5V20.59h12.5V6.215zM9.37 9.525a.601.601 0 0 1 .186.439v6.875c0 .17-.062.316-.186.439a.601.601 0 0 1-.439.186.598.598 0 0 1-.439-.186.598.598 0 0 1-.186-.439V9.965a.6.6 0 0 1 .186-.439.594.594 0 0 1 .438-.186c.169 0 .316.062.44.185zm.185-4.56h5V3.09h-5v1.875zm2.94 4.56a.601.601 0 0 1 .186.439v6.875c0 .17-.062.316-.186.439a.601.601 0 0 1-.439.186.598.598 0 0 1-.439-.186.598.598 0 0 1-.186-.439V9.965a.6.6 0 0 1 .186-.439.604.604 0 0 1 .439-.186c.168 0 .315.062.439.185zm2.246 0a.604.604 0 0 1 .439-.186c.169 0 .315.063.439.186a.601.601 0 0 1 .186.439v6.875c0 .17-.062.316-.186.439a.601.601 0 0 1-.439.186.598.598 0 0 1-.439-.186.598.598 0 0 1-.186-.439V9.965c0-.169.062-.316.186-.44z"></path>
                                        </svg>
                                    </i>Limpar Carrinho
                                </button>
                            </div>
                        </form>
                        <div class="border-bottom border my-15"></div>
                        <div class="row d-flex">
                            <?if (!isset($_SESSION['cupom_de_desconto']) || $_SESSION['cupom_de_desconto']==''){?>
                                <div class="col-md-9 col-sm-6" style="display: flex;align-items: center;">
                                    <input type="text" id="cupom" name="cupom" class="mb-0" placeholder="Insira um cupom de desconto" onfocus="$(this).on('keydown',function (e){if (e.keyCode===13){$('#aplicar_cupom').click();}})">
                                </div>
                                <div class="col-md-3 col-sm-6" style="display: flex;align-items: center; justify-content: flex-end;">
                                    <button type="button" onclick="valida_cupom();" id="aplicar_cupom" title="APLICAR CUPOM" class="btn btn--status btn--animated botao-detalhes" style="border-radius:0;">
                                        <span class="d-flex flex-center">
                                            <i class="btn__icon mr-5 mb-4">
                                                <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-137" viewBox="0 0 24 24">
                                                    <path d="M2.176 10.525a.846.846 0 0 1-.127-.215.596.596 0 0 1-.049-.234v-7.5a.6.6 0 0 1 .186-.439.598.598 0 0 1 .439-.186h7.5c.078 0 .156.017.234.049a.93.93 0 0 1 .215.127l10.625 10.625c.117.13.176.28.176.449a.652.652 0 0 1-.176.449l-7.5 7.5a.91.91 0 0 1-.215.127c-.078.032-.156.049-.234.049s-.156-.017-.234-.049a.91.91 0 0 1-.215-.127L2.176 10.525zm1.074-.703l10 10 6.621-6.621-10-10H3.25v6.621zm5.078-4.199c.364.365.547.808.547 1.328 0 .521-.183.964-.547 1.328A1.807 1.807 0 0 1 7 8.826c-.521 0-.964-.182-1.328-.547a1.805 1.805 0 0 1-.547-1.328c0-.521.182-.963.547-1.328A1.81 1.81 0 0 1 7 5.076c.521 0 .963.183 1.328.547zm-.889 1.768a.604.604 0 0 0 .186-.439.604.604 0 0 0-.186-.439A.597.597 0 0 0 7 6.326a.597.597 0 0 0-.439.186.6.6 0 0 0-.186.439c0 .169.062.316.186.439A.593.593 0 0 0 7 7.576a.599.599 0 0 0 .439-.185z"></path>
                                                </svg>
                                            </i>
                                            <span class="btn__text">APLICAR CUPOM</span>
                                        </span>
                                    </button>
                                </div>
                            <?}else{?>
                                <form action="" method="post">
                                    <div class="col-md-12">
                                        <?echo $cupom_exibe;?>
                                    </div>
                                </form>
                            <?}?>
                        </div>
                        <div class="note" style="position: absolute; display: none;" id="msg_cupom"></div>
                        <div class="border-bottom border my-15"></div>
                    </div>
                    <?if (isset($_SESSION["usr_id_cliente"]) AND $_SESSION["usr_id_cliente"]>=1){?>
                        <div class="col-lg-8 col-xl-9">
                            <h1 class="h3 mt-20 mb-30 text-webkit-center">ENDEREÇO DE ENTREGA</h1>
                            <form method="post" action="" accept-charset="UTF-8" class="needs-validation" novalidate>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="selEndereco" class="label-required">Meus Endereços</label>
                                        <select id="selEndereco">
                                            <?
                                                $arrEn = array(
                                					"cep" => '',
                                					"endereco" => '',
                                					"numero" => '',
                                					"bairro" => '',
                                					"cidade" => '',
                                					"estado" => '',
                                					"complemento" => '',
                                					"pontoreferencia" => ''
                                				);
                                			?>
                                    		 <option value="novo" data-dados='<?=json_encode($arrEn)?>'>NOVO</option>
                                			<?	
                                    			$endr = mysqli_query($conn, "SELECT * FROM enderecos_entrega WHERE id_cliente='".$_SESSION["usr_id_cliente"]."'");
                                    			$option = '';
                                    			$contador = 0;
                                    			while($ln=mysqli_fetch_array($endr)){
                                    				$arrE = array(
                                    					"cep" => $ln['cep'],
                                    					"endereco" => $ln['endereco'],
                                    					"numero" => $ln['numero'],
                                    					"bairro" => $ln['bairro'],
                                    					"cidade" => $ln['cidade'],
                                    					"estado" => (($ln['estado']!='')?strtoupper($ln['estado']):$ln['estado']),
                                    					"complemento" => $ln['complemento'],
                                    					"pontoreferencia" => $ln['pto_referencia']
                                    				);
                                    				if ($ln['principal']=='sim'){
                                    				    $option .= "<option value='".$ln['id']."' data-dados='".json_encode($arrE)."' selected>ENDEREÇO PRINCIPAL</option>";
                                    				    $contador++;
                                    				}else{
                                    				    $option .= "<option value='".$ln['id']."' data-dados='".json_encode($arrE)."'>".mb_convert_case($ln['apelido'], MB_CASE_UPPER, "UTF-8")."</option>";
                                    				}
                                    			}
                                    			if ($contador==0){
                                    			    $dU = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM clientes WHERE id='".$_SESSION["usr_id_cliente"]."' AND status='a' LIMIT 1"));
                                    				$arrEp = array(
                                    					"cep" => $dU['cep'],
                                    					"endereco" => $dU['endereco'],
                                    					"numero" => $dU['numero'],
                                    					"bairro" => $dU['bairro'],
                                    					"cidade" => $dU['cidade'],
                                    					"estado" => (($dU['estado']!='')?strtoupper($dU['estado']):$dU['estado']),
                                    					"complemento" => $dU['complemento'],
                                    					"pontoreferencia" => $dU['pto_referencia']
                                    				);
                                    				echo "<option value='".$dU['id']."' data-dados='".json_encode($arrEp)."' selected>ENDEREÇO PRINCIPAL</option>";
                                    			}
                                    			echo $option;
                                    		 ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row apelidoendereco" id="apelidoendereco" style="display: none;">
                                    <div class="col-md-12">
                                        <label for="apelido" class="label-required">Apelido</label>
                                        <input type="text" class="apelido" name="apelido" id="apelido" placeholder="Insira um apelido para o novo endereço">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="cep" class="label-required">CEP</label>
                                        <input type="text" class="cep" name="cep" id="cep" placeholder="Insira seu cep" value="<?=((isset($contador) AND $contador>0)?$arrE['cep']:$dU['cep']);?>" onblur="Frete();" required>
                                        <div class="note note--error" style="display: none; position: absolute; top: 60px;" id="tooltip_cep">Preencha o CEP</div>
                                    </div>
                                    <div class="col-md-9">
                                        <label for="endereco" class="label-required">Endereço</label>
                                        <input type="text" name="endereco" id="logradouro" placeholder="Insira sua rua" value="<?=((isset($contador) AND $contador>0)?$arrE['endereco']:$dU['endereco']);?>" onblur="Frete();" required>
                                        <div class="note note--error" style="display: none; position: absolute; top: 60px;" id="tooltip_logradouro">Preencha o Endereço</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="numero" class="label-required">Número</label>
                                        <input type="text" name="numero" id="numero" placeholder="Insira seu numero" value="<?=((isset($contador) AND $contador>0)?$arrE['numero']:$dU['numero']);?>" onblur="Frete();" required>
                                        <div class="note note--error" style="display: none; position: absolute; top: 60px;" id="tooltip_numero">Preencha o Número</div>
                                    </div>
                                    <div class="col-md-9">
                                        <label for="complemento">Complemento</label>
                                        <input type="text" name="complemento" id="complemento" placeholder="Insira um complemento" value="<?=((isset($contador) AND $contador>0)?$arrE['complemento']:$dU['complemento']);?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="bairro" class="label-required">Bairro</label>
                                        <input type="text" name="bairro" id="bairro" placeholder="Insira seu bairro" value="<?=((isset($contador) AND $contador>0)?$arrE['bairro']:$dU['bairro']);?>" required>
                                        <div class="note note--error" style="display: none; position: absolute; top: 60px;" id="tooltip_bairro">Preencha o Bairro</div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="cidade" class="label-required">Cidade</label>
                                        <input type="text" name="cidade" id="cidade" placeholder="Insira sua cidade" value="<?=((isset($contador) AND $contador>0)?$arrE['cidade']:$dU['cidade']);?>" required>
                                        <div class="note note--error" style="display: none; position: absolute; top: 60px;" id="tooltip_cidade">Preencha a Cidade</div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="estado" class="label-required">Estado</label>
                                        <input type="text" name="estado" id="estado" placeholder="Insira seu estado" value="<?=((isset($contador) AND $contador>0)?strtoupper($arrE['estado']):strtoupper($dU['estado']));?>" required>
                                        <div class="note note--error" style="display: none; position: absolute; top: 60px;" id="tooltip_estado">Preencha o Estado</div>
                                    </div>
                                </div>
                                <a href="" sytle="display: none;" id="ancora"></a>
                            </form>
                            <?if ($vb_catalogo!='sim'){?>
                            <div class="border-bottom border my-15"></div>
                                <h1 class="h3 mt-20 mb-30 text-webkit-center">FRETE</h1>
                                <div class="table-wrap">
                                    <table class="responsive-table">
                                        <thead>
                                            <tr>
                                                <th>Empresa</th>
                                                <th>Tipo</th>
                                                <th>Prazo</th>
                                                <th>Valor</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tabela_frete">
                                            <div class="loader js-loader animate visible" id="loader_carrinho_frete" style="display: none;">
                                                <div class="loader__bg" data-js-loader-bg=""></div>
                                                <div class="loader__spinner animate" data-js-loader-spinner=""><img src="assets/img/preloader.svg" alt="Carregando..." title="Carregando..."></div>
                                            </div>
                                                <?
                                                if ($dU['cep']!='' AND $dU['endereco']!='' AND $dU['numero']!=''){
                                                  $arrC = array();
                                                  if (isset($_SESSION["usr_id_cliente"]) AND $_SESSION["usr_id_cliente"]>0){
                                                    $qr = mysqli_query($conn, "SELECT *, tb1.qtd AS qtd FROM carrinho AS tb1 INNER JOIN produtos AS tb2 ON(tb1.cod=tb2.id) WHERE sessao='".session_id()."' AND id_cliente='".$_SESSION["usr_id_cliente"]."'");
                                                  }else{
                                                    $qr = mysqli_query($conn,"SELECT *, tb1.qtd AS qtd FROM carrinho AS tb1 INNER JOIN produtos AS tb2 ON(tb1.cod=tb2.id) WHERE sessao='".session_id()."'");
                                                  }
                                                  while($ln=mysqli_fetch_array($qr)){
                                                    $arrP = array();
                                                    $peso = $ln['peso'];
                                                    $preco_final = $ln['preco'];
                                                    $arrP["id"] = $ln['id'];
                                                    $arrP["weight"] = $peso;
                                                    $arrP["width"] = $ln['largura'];
                                                    $arrP["height"] = $ln['altura'];
                                                    $arrP["length"] = $ln['comprimento'];
                                                    $arrP["quantity"] = $ln['qtd'];
                                                    $arrP["insurance_value"] = $preco_final;
                                                    
                                                    array_push($arrC, $arrP);
                                                  }
                                                  
                                                  $fields = array(
                                                        "from" => array("postal_code" => "$cep_loja", "address" => "$endereco_loja", "number" => "$numero_loja"),
                                                        "to" => array("postal_code" => "".$dU['cep']."", "address" => "".$dU['endereco']."", "number" => "".$dU['numero'].""),
                                                        "products" => $arrC,
                                                        "options" => array("insurance_value" => $arrP["insurance_value"], "receipt" => false, "own_hand" => false, "collect" => false),
                                                        "services" => "1,2"
                                                      );
                                                
                                                  $retorno["arrFields"] = $fields;
                                                
                                                  $fields = json_encode($fields);
                                                  
                                                  $ch = curl_init();
                                                  curl_setopt($ch, CURLOPT_URL, "https://www.melhorenvio.com.br/api/v2/me/ecommerce/calculate");
                                                  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                                          'Accept: application/json',
                                                                          'Authorization: Bearer '.$token_frete.''));
                                                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                                                  curl_setopt($ch, CURLOPT_HEADER, FALSE);
                                                  curl_setopt($ch, CURLOPT_POST, TRUE);
                                                  curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                                                  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                                                
                                                  $response = curl_exec($ch);
                                                  $err = curl_error($ch);
                                                  curl_close($ch);
                                                
                                                  if ($err) {
                                                    echo'<script>alert("Erro ao calcular o Frete.");</script>';
                                                    echo '<meta http-equiv="refresh" content=0;url="carrinho">';
                                                    exit();
                                                  } else {
                                                    $response = json_decode($response);
                                                    $dados = '';
                                                    foreach($response AS $k){
                                                      $erro = property_exists($k, "error");
                                            		    if($erro!='1'){
                                                            $dados .= '
                                                              <tr class="responsive-table-row">
                                                                <td><img src="'.$k->company->picture.'" width="100px" class="imagem-frete" valin="middle"></td>
                                                                <td>'.$k->name.'</td>
                                                                <td>'.$k->delivery_time.' dias</td>
                                                                <td>R$ '.number_format($k->price,2,',','.').'</td>
                                                                <td><input type="radio" data-id="'.$k->id.'" data-agency-id="'.$k->company->id.'" data-prazo="'.$k->delivery_time.'" data-empresa="'.$k->company->name.'" value="'.number_format($k->price,2).'" class="rdoFrete" name="radioFrete" onclick="somaFrete(\''.number_format($k->price,2).'\');" required></td>
                                                              </tr>
                                                            ';
                                                        }
                                                    }
                                                  }
                                                echo $dados;
                                                }else{?>
                                                    <tr class="responsive-table-row">
                                                        <td><p>Preencha os dados de endereço para entrega!</p></td>
                                                    </tr>
                                                <?}?>
                                        </tbody>
                                    </table>
                                </div>
                            <?}?>
                        </div>
                    <?}?>
                    <div class="col-lg-4 col-xl-3 mt-25 mt-lg-0">
                        <aside class="cart__sidebar p-20 border menu_carrinho">
                            <h3 class="h5 mb-20"><b>RESUMO DO PEDIDO</b></h3>
                            <div class="border-bottom border--dashed">
                                <form action="" method="post">
                                    <?if (!isset($_SESSION["usr_id_cliente"]) || $_SESSION["usr_id_cliente"]<1){?>
                                        <div class="col-md-12 p-0">
                                            <label for="usuario" class="label-required">E-mail</label>
                                            <input type="email" name="usuario" id="usuario_carrinho" class="" placeholder="E-mail" spellcheck="false" autocomplete="off" autocapitalize="off" required="required">
                                        </div>
                                        <div class="col-md-12 p-0">
                                            <label for="senha" class="label-required">Senha</label>
                                            <input type="password" name="senha" id="senha_carrinho" class="" placeholder="Senha" required="required">
                                            <svg aria-hidden="true" onclick="mostraSenha(senha_carrinho);" focusable="false" role="presentation" class="icon icon-theme-154" viewBox="0 0 24 24" style="border: none; margin-top: -3.65em; background: transparent; position: absolute; right: 3%;">
                                                <path d="M8.528 17.238c-1.107-.592-2.074-1.25-2.9-1.973-.827-.723-1.491-1.393-1.992-2.012-.501-.618-.771-.96-.811-1.025a.571.571 0 0 1-.117-.352c0-.13.039-.247.117-.352.039-.064.306-.406.801-1.025.495-.618 1.159-1.289 1.992-2.012.833-.723 1.803-1.38 2.91-1.973a7.424 7.424 0 0 1 3.555-.889c1.263 0 2.448.297 3.555.889 1.106.593 2.073 1.25 2.9 1.973.827.723 1.491 1.394 1.992 2.012.501.619.771.961.811 1.025a.573.573 0 0 1 .117.352.656.656 0 0 1-.117.371c-.039.053-.31.391-.811 1.016-.501.625-1.169 1.296-2.002 2.012-.833.717-1.804 1.371-2.91 1.963a7.375 7.375 0 0 1-3.535.889 7.415 7.415 0 0 1-3.555-.889zm.869-9.746c-.853.41-1.631.889-2.334 1.436s-1.312 1.101-1.826 1.66c-.515.561-.889.99-1.123 1.289.234.3.608.729 1.123 1.289.514.561 1.123 1.113 1.826 1.66s1.484 1.025 2.344 1.436 1.751.615 2.676.615c.924 0 1.813-.205 2.666-.615.853-.41 1.634-.889 2.344-1.436.709-.547 1.318-1.1 1.826-1.66.508-.56.885-.989 1.133-1.289a41.634 41.634 0 0 0-1.133-1.289c-.508-.56-1.113-1.113-1.816-1.66s-1.484-1.025-2.344-1.436-1.751-.615-2.676-.615c-.937 0-1.833.205-2.686.615zm.04 7.031c-.736-.735-1.104-1.617-1.104-2.646 0-1.028.368-1.91 1.104-2.646.735-.735 1.618-1.104 2.646-1.104 1.028 0 1.911.368 2.646 1.104.735.736 1.104 1.618 1.104 2.646 0 1.029-.368 1.911-1.104 2.646-.736.736-1.618 1.104-2.646 1.104-1.029 0-1.911-.367-2.646-1.104zm.878-4.414a2.41 2.41 0 0 0-.732 1.768c0 .69.244 1.279.732 1.768s1.077.732 1.768.732c.69 0 1.279-.244 1.768-.732s.732-1.077.732-1.768c0-.689-.244-1.279-.732-1.768s-1.078-.732-1.768-.732-1.279.244-1.768.732z"></path>
                                            </svg>
                                        </div>
                                        <div class="note note--error" style="display: none;" id="login_incorreto_carrinho">E-mail ou senha incorretos, por favor, tente novamente!</div>
                                        <input type="button" class="btn btn--full btn--secondary mb-20" value="ENTRAR" onclick="Login('_carrinho'); validaAcesso();">
                                        <div class="mb-10">
                                            <a href="cadastrar" title="Cadastre-se" class="btn-link js-button-block-visibility">Cadastre-se</a>
                                        </div>
                                        <div class="mb-10">
                                            <a href="login#recuperar" title="Esqueci minha senha" class="btn-link js-button-block-visibility" data-block-link="#recover" data-action="open" data-action-close-popup="account">Esqueci minha senha</a>
                                        </div>
                                    <?}?>
                                </form>
                            </div>
                            <?if (isset($_SESSION["usr_id_cliente"]) AND $_SESSION["usr_id_cliente"]>0){?>
                                <div class="pt-15 border-bottom border--dashed">
                                    <h5 class="mb-5"><b>FRETE</b></h5>
                                    <h3 class="mb-5">
                                        <span class="money" id="valor_frete" data-value="">Á calcular</span>
                                    </h3>
                                </div>
                            <?}?>
                            <?if (!isset($_SESSION['cupom_de_desconto']) || $_SESSION['cupom_de_desconto']==''){?>
                                <div class="pt-15 border-bottom border--dashed" id="div_total">
                                    <h5 class="mb-5"><b>TOTAL</b></h5>
                                    <h3 class="mb-5">
                                        <span class="price-carrinho-total price" data-js-product-price="">
                                            <?if(isset($total_parcial) AND $total_parcial>0 AND $total_parcial!='CONSULTE-NOS'){?>
                                                <span class="money" id="total_parcial" data-value="<?=$total_parcial;?>">R$ <?=number_format($total_parcial,2,',','.');?></span>
                                            <?}else{?>
                                                <span class="money" id="total_parcial" data-value="<?=$total_parcial;?>"><?=$total_parcial;?></span>
                                            <?}?>
                                        </span>
                                    </h3>
                                </div>
                            <?}else{?>
                                <div class="pt-15 border-bottom border--dashed" id="div_subtotal">
                                    <h5 class="mb-5"><b>SUB-TOTAL</b></h5>
                                    <h3 class="mb-5">
                                        <span class="money" style="font-size: 18px;"><stroke id="subtotal_parcial"><?=$_SESSION['valor_antigo'];?></stroke> - 
                                            <?
                                            if ($_SESSION['cupom_tipo']=='2'){echo $_SESSION['valor_desconto'].'%';}
                                            elseif ($_SESSION['cupom_tipo']=='1'){echo 'R$ '.number_format($_SESSION['valor_desconto'],2,',','.');}
                                            ?>
                                        </span>
                                    </h3>
                                </div>
                                <div class="pt-15 border-bottom border--dashed" id="div_total">
                                    <h5 class="mb-5"><b>TOTAL</b></h5>
                                    <h3 class="mb-5">
                                        <span class="price-carrinho-total price" data-js-product-price="">
                                            <span class="money" id="total_parcial" data-value="<?=str_replace(',', '.', str_replace('.', '', $total_parcial));?>">R$ <?=$total_parcial;?></span>
                                        </span>
                                    </h3>
                                </div>
                            <?}?>
                            <?if (isset($_SESSION["usr_id_cliente"]) AND $_SESSION["usr_id_cliente"]>0){?>
                                <?if ($vb_catalogo!='sim'){?>
                                    <div class="pt-15 border-bottom border--dashed" id="div_finalizar">
                                        <button type="button" class="btn btn--full btn--secondary" name="finalizar" value="FINALIZAR PEDIDO" data-toggle="tooltip" data-placement="bottom" title="Selecione o Frete para finalizar o pedido">FINALIZAR PEDIDO</button>
                                    </div>
                                <?}else{?>
                                    <div class="pt-15 border-bottom border--dashed" id="div_finalizar">
                                        <input type="button" class="btn btn--full btn--secondary" name="finalizar" value="FINALIZAR PEDIDO" onclick="finalizarOrcamento();">
                                    </div>
                                <?}?>
                            <?}?>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    <?}else{?>
        <h1 class="h3 mt-20 text-center">CARRINHO VAZIO</h1>
        <h5 class="h5 mt-10 mb-30 text-center">Fique com alguns dos queridinhos!</h5>
        <div id="theme-section-carousel-related-products" class="theme-section">
            <div data-section-id="carousel-related-products" data-section-type="carousel-products"
                 data-postload="carousel_products">
                <div class="container">
                    <div class="carousel carousel-products position-relative mt-30 pb-60 mt-lg-0">
                        <div class="carousel__slider position-relative invisible" data-js-carousel data-autoplay="true" data-speed="5000" data-count="4" data-infinite="true" data-arrows="true" data-bullets="true">
                            <div class="carousel__prev d-none position-absolute cursor-pointer" data-js-carousel-prev><i>
                                <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-006"
                                     viewBox="0 0 24 24">
                                    <path d="M16.736 3.417a.652.652 0 0 1-.176.449l-8.32 8.301 8.32 8.301c.117.13.176.28.176.449s-.059.319-.176.449a.91.91 0 0 1-.215.127c-.078.032-.156.049-.234.049s-.156-.017-.234-.049a.93.93 0 0 1-.215-.127l-8.75-8.75a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449l8.75-8.75a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176.117.13.176.28.176.449z"/>
                                </svg>
                            </i></div>
                            <div class="carousel__products overflow-hidden">
                                <div class="carousel__slick row" data-js-carousel-slick data-carousel-products-items data-max-count="6" data-products-pre-row="4" data-async-ajax-loading="true">
                                    <?
                                    $sql2 = "SELECT DISTINCT id,img,img_secundaria,produto,preco,por,qtd,url_amigavel FROM produtos WHERE status='a' ORDER BY qtd_visto LIMIT 8";
                                    $query2 = mysqli_query($conn, $sql2);
                                    while ($dados2 = mysqli_fetch_assoc($query2)) {
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
                                        
                                        $url = $url_loja."/produto/".$url_amigavel;
                                        
                                        if ($dados2['img'] == '') {
                                            $imagem = 'assets/img/' . $pagina_referencia . '/sem_imagem.jpg';
                                        } elseif (file_exists('assets/img/'.$pagina_referencia.'/'.$img.'')) {
                                            $imagem = 'assets/img/'.$pagina_referencia.'/'.$img.'';
                                        } else {
                                            $imagem = "assets/img/$pagina_referencia/sem_imagem.jpg";
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
                                        
                                         $caminho_interno = "assets/img/".$pagina_referencia."/".$id."/";
        
                                        if (isset($img_secundaria) AND $img_secundaria!='sem_imagem.webp' AND file_exists($caminho_interno.$img_secundaria)){
                                            $img_secundaria = "assets/img/".$pagina_referencia."/".$id."/".$img_secundaria;
                                            $img_interna = explode(".", $img_secundaria);
                                            $img_interna = $img_interna[0]."_{width}x.progressive.".$img_interna[1];
                                        }else{
                                            $arquivos = glob("$caminho_interno{*.jpg,*.png,*.gif,*.bmp,*.webp}", GLOB_BRACE);
                                            if (count($arquivos)>0){
                                                for($i=0; $i<1; $i++){
                                                    $img_interna = explode(".", $arquivos[$i]);
                                                    $img_interna = $img_interna[0]."_{width}x.progressive.".$img_interna[1];
                                                }
                                            }else{
                                                $img_interna = explode(".", $imagem);
                                                $img_interna = $img_interna[0]."_{width}x.progressive.".$img_interna[1];
                                            }
                                        }
                                    ?>
                                        <div class="carousel__item col-auto carrossel-produtos-home">
                                            <div class="product-collection d-flex flex-column" data-js-product data-js-product-json-preload data-product-handle="<?=$id;?>" data-product-variant-id="<?=$id;?>">
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
                                                                        <svg aria-hidden= "true" style="fill: white;" focusable="false" role="presentation" class="icon icon-theme-181" viewBox="0 0 24 24">
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
</main>
<?require_once "includes/footer.php";?>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script>
function Frete(){
    var cep = $('#cep').prop('value');
    var endereco = $('#logradouro').prop('value');
    var numero = $('#numero').prop('value');
    $.ajax({
		type: "POST",
		url: "includes/calculo_frete.php",
		data: {
			ses: '<?=session_id();?>',
			endereco: endereco,
			numero: numero,
			cep: cep
		},
		dataType: "json",
		beforeSend: function () {
            $('#loader_carrinho_frete').show();
        },
		success: function (dataOKF) {
		    $('#loader_carrinho_frete').hide();
			if(dataOKF.erro){
				$('#tabela_frete').html('<tr><td colspan="5">Dados para Frete inválidos, preencha novamente.</td></tr>');
			}else{
				$('#tabela_frete').html(dataOKF.dados);
			}
		},
		error: function(xhr, textStatus, errorThrown){
		    $('#loader_carrinho_frete').hide();
			var erro = JSON.parse(xhr.responseText);
			console.log(erro.Message);
			$('#tabela_frete').html('<tr><td colspan="5">Dados para Frete inválidos, preencha novamente.</td></tr>');
		}
	});
}
  $('#selEndereco').change(function(){
    
    var ender = $(this).find(':selected').attr('data-dados');
    var e = JSON.parse(ender);
    $('#cep').prop('value',e.cep);
    $('#logradouro').prop('value',e.endereco);
    $('#numero').prop('value',e.numero);
    $('#bairro').prop('value',e.bairro);
    $('#cidade').prop('value',e.cidade);
    $('#estado').prop('value',e.estado);
    $('#complemento').prop('value',e.complemento);
    
    $('#cep').prop('readonly',false);
    $('#logradouro').prop('readonly',false);
    $('#numero').prop('readonly',false);
    $('#bairro').prop('readonly',false);
    $('#cidade').prop('readonly',false);
    $('#estado').prop('readonly',false);
    if ($('#complemento').prop('value')==''){
        $('#complemento').prop('readonly',false);
    }else{
        $('#complemento').prop('readonly',false);
    }
    if($(this).prop('value')=='novo'){
        $('.apelidoendereco').prop('value','');
        $('#apelidoendereco').show();
        $('#apelidoendereco input').focus();
        $('#cep').prop('readonly',false);
        $('#logradouro').prop('readonly',false);
        $('#numero').prop('readonly',false);
        $('#bairro').prop('readonly',false);
        $('#cidade').prop('readonly',false);
        $('#estado').prop('readonly',false);
        $('#complemento').prop('readonly',false);
        $('#tabela_frete').html('<tr><td colspan="5">Informe o CEP</td></tr>');
    }else{
        <?php if (isset($_SESSION["usr_id_cliente"]) AND $_SESSION["usr_id_cliente"]>0){?>
            <?php if (isset($vb_catalogo) AND $vb_catalogo!='sim'){?>
            Frete();
        <?}}?>
        $('#apelidoendereco').hide();
    }	  
});
function somaFrete(v){
	var vP = $('#total_parcial').attr('data-value');
	var vtt = 0;
	vtt = parseFloat(vP) + parseFloat(v);
	var valorOK = parseFloat(vtt);
    var frete = parseFloat(v);
	var numero1 = valorOK.toFixed(2).split('.');
	numero1[0] = numero1[0].split(/(?=(?:...)*$)/).join('.');
	var valorOKOK = numero1.join(',');
	
	$('#total_parcial').html('R$ '+valorOKOK);
    $('#valor_frete').attr('data-value', v);
    
    var frete_final = frete.toFixed(2).split('.');
	frete_final[0] = frete_final[0].split(/(?=(?:...)*$)/).join('.');
	var frete_formatado = frete_final.join(',');
	
    $('#valor_frete').html('R$ '+frete_formatado);
    $('#div_finalizar').html('<input type="button" class="btn btn--full btn--secondary" name="finalizar" value="FINALIZAR PEDIDO" onclick="finalizarPedido();">');
    
}

function finalizarPedido(){

    var input_logradouro = document.getElementById('logradouro').value;
    var input_numero = document.getElementById('numero').value;
    var input_cep = document.getElementById('cep').value;
    var input_bairro = document.getElementById('bairro').value;
    var input_cidade = document.getElementById('cidade').value;
    var input_estado = document.getElementById('estado').value;
    var liberado = 'sim';
    
    if (input_cep=='' && liberado=='sim'){
        $('#tooltip_cep').show();
        setTimeout(function() {
           $('#tooltip_cep').fadeOut('medium');
        }, 4000);
        liberado = 'nao';
    }
    if (input_logradouro=='' && liberado=='sim'){
        $('#tooltip_logradouro').show();
        setTimeout(function() {
           $('#tooltip_logradouro').fadeOut('medium');
        }, 4000);
        liberado = 'nao';
    }
    if (input_numero=='' && liberado=='sim'){
        $('#tooltip_numero').show();
        setTimeout(function() {
           $('#tooltip_numero').fadeOut('medium');
        }, 4000);
        liberado = 'nao';
    }
    if (input_bairro=='' && liberado=='sim'){
        $('#tooltip_bairro').show();
        setTimeout(function() {
           $('#tooltip_bairro').fadeOut('medium');
        }, 4000);
        liberado = 'nao';
    }
    if (input_cidade=='' && liberado=='sim'){
        $('#tooltip_cidade').show();
        setTimeout(function() {
           $('#tooltip_cidade').fadeOut('medium');
        }, 4000);
        liberado = 'nao';
    }
    if (input_estado=='' && liberado=='sim'){
        $('#tooltip_estado').show();
        setTimeout(function() {
           $('#tooltip_estado').fadeOut('medium');
        }, 4000);
        liberado = 'nao';
    }
    
    var vF = 0;
	var vI = 0;
	var vAI = 0;
	var vE = '';
	var vP = 0;
	var end = 
	$('.rdoFrete').each(function(){
		if($(this).is(':checked')){
			vF = $(this).prop('value');
			vI = $(this).attr('data-id');
			vAI = $(this).attr('data-agency-id');
			vE = $(this).attr('data-empresa');
			vP = $(this).attr('data-prazo');
		}
	});

    var tipoEnd = $('#selEndereco').prop('value');
    if (liberado=='sim'){
        if(tipoEnd=='novo'){
            $.ajax({
    			type: "POST",
    			url: "pagseguro.php",
    			data: {
    				ses: '<?=session_id();?>',
    				nomeend: $('.apelidoendereco').prop('value'),
    				cep: $('#cep').prop('value'),
    				logradouro: $('#logradouro').prop('value'),
    				numero: $('#numero').prop('value'),
    				complemento: $('#complemento').prop('value'),
    				bairro: $('#bairro').prop('value'),
    				cidade: $('#cidade').prop('value'),
    				estado: $('#estado').prop('value'),
    				pontoreferencia: $('#pto_referencia').prop('value'),
    				frete_valor: $('#valor_frete').attr('data-value'),
    				frete: vF,
    				freteID: vI,
    				freteAID: vAI,
    				freteP: vP,
    				freteE: vE,
    				tipo: 'novo',
    				uid: '<?=$_SESSION["usr_id_cliente"];?>'
    			},
    			dataType: "json",
    			success: function (dataOK) {
    				var code = dataOK.pscode;
    				code = code[0];
    				var callback = {
    					success : function(transactionCode) {
    						$.ajax({
                              type: "POST",
                              url: "finalizar_pedido.php",
                              data: {
                                ses: '<?=session_id()?>',
                                nomeend: $('.apelidoendereco').prop('value'),
                                cep: $('#cep').prop('value'),
                                logradouro: $('#logradouro').prop('value'),
                                numero: $('#numero').prop('value'),
                                complemento: $('#complemento').prop('value'),
                                bairro: $('#bairro').prop('value'),
                                cidade: $('#cidade').prop('value'),
                                estado: $('#estado').prop('value'),
                                pontoreferencia: $('#pto_referencia').prop('value'),
                                selEnderecoN: tipoEnd,
                                id: '<?=$_SESSION["usr_id_cliente"];?>',
                                frete: $('#valor_frete').attr('data-value'),
                				freteID: vI,
                				freteAID: vAI,
                				freteP: vP,
                				freteE: vE,
                                transaction_id: transactionCode,
                                acao: 'Pedido'
                              },
                              dataType: "json",
                              success: function () {
                              }
                            });
                            $.ajax({
                                type: "POST",
                                url: "includes/adicionar_frete.php",
                                data: {
                                    ses: '<?=session_id();?>',
                                    nomeend: $('.apelidoendereco').prop('value'),
                                    cep: $('#cep').prop('value'),
                                    logradouro: $('#logradouro').prop('value'),
                                    numero: $('#numero').prop('value'),
                                    complemento: $('#complemento').prop('value'),
                                    bairro: $('#bairro').prop('value'),
                                    cidade: $('#cidade').prop('value'),
                                    estado: $('#estado').prop('value'),
                                    pontoreferencia: $('#pto_referencia').prop('value'),
                                    id: '<?=$_SESSION["usr_id_cliente"]?>',
                    				freteID: vI,
                    				freteAID: vAI
                                },
                                dataType: "json",
                                success: function (dataOK) {
                                    location.href="obrigado?transaction_id=" + transactionCode;
                                }
                            });
                            location.href="obrigado?transaction_id=" + transactionCode;
    					},
    					abort : function() {
    						if (transactionCode!=''){
    						    $.ajax({
                                    type: "POST",
                                    url: "includes/adicionar_frete.php",
                                    data: {
                                        ses: '<?=session_id();?>',
                                        nomeend: $('.apelidoendereco').prop('value'),
                                        cep: $('#cep').prop('value'),
                                        logradouro: $('#logradouro').prop('value'),
                                        numero: $('#numero').prop('value'),
                                        complemento: $('#complemento').prop('value'),
                                        bairro: $('#bairro').prop('value'),
                                        cidade: $('#cidade').prop('value'),
                                        estado: $('#estado').prop('value'),
                                        pontoreferencia: $('#pto_referencia').prop('value'),
                                        id: '<?=$_SESSION["usr_id_cliente"];?>',
                        				freteID: vI,
                        				freteAID: vAI
                                    },
                                    dataType: "json",
                                    success: function (dataOK) {
                                        location.href="obrigado?transaction_id=" + transactionCode;
                                    }
                                });
    						}
    					}
    				};
    				var isOpenLightbox = PagSeguroLightbox(code, callback);
    				if (!isOpenLightbox){
    				    location.href="https://pagseguro.uol.com.br/v2/checkout/payment.html?code=" + code;
    				}
    			},
    			error: function(xhr, textStatus, errorThrown){
    				for(i in XMLHttpRequest) {
    					if(i!="channel")
    					console.log(i +" : " + XMLHttpRequest[i])
    				}
    			}
    		});
        }else if(tipoEnd=='padrao'){
            $.ajax({
    			type: "POST",
    			url: "pagseguro.php",
    			data: {
    				ses: '<?=session_id();?>',
    				frete_valor: $('#valor_frete').attr('data-value'),
    				frete: vF,
    				freteID: vI,
    				freteAID: vAI,
    				freteP: vP,
    				freteE: vE,
    				tipo: 'padrao',
    				uid: '<?=$_SESSION["usr_id_cliente"];?>'
    			},
    			dataType: "json",
    			success: function (dataOK) {
    				var code = dataOK.pscode;
    				code = code[0];
    				var callback = {
    					success : function(transactionCode) {
    						$.ajax({
                              type: "POST",
                              url: "finalizar_pedido.php",
                              data: {
                                ses: '<?=session_id();?>',
                                cep: $('#cep').prop('value'),
                                logradouro: $('#logradouro').prop('value'),
                                numero: $('#numero').prop('value'),
                                complemento: $('#complemento').prop('value'),
                                bairro: $('#bairro').prop('value'),
                                cidade: $('#cidade').prop('value'),
                                estado: $('#estado').prop('value'),
                                pontoreferencia: $('#pto_referencia').prop('value'),
                                id: '<?=$_SESSION["usr_id_cliente"];?>',
                				frete: $('#valor_frete').attr('data-value'),
                				freteID: vI,
                				freteAID: vAI,
                				freteP: vP,
                				freteE: vE,
                                transaction_id: transactionCode,
                                acao: 'Pedido'
                              },
                              dataType: "json",
                              success: function () {
                              }
                            });
                            $.ajax({
                                type: "POST",
                                url: "includes/adicionar_frete.php",
                                data: {
                                    ses: '<?=session_id();?>',
                                    nomeend: $('.apelidoendereco').prop('value'),
                                    cep: $('#cep').prop('value'),
                                    logradouro: $('#logradouro').prop('value'),
                                    numero: $('#numero').prop('value'),
                                    complemento: $('#complemento').prop('value'),
                                    bairro: $('#bairro').prop('value'),
                                    cidade: $('#cidade').prop('value'),
                                    estado: $('#estado').prop('value'),
                                    pontoreferencia: $('#pto_referencia').prop('value'),
                                    id: '<?=$_SESSION["usr_id_cliente"]?>',
                    				freteID: vI,
                    				freteAID: vAI
                                },
                                dataType: "json",
                                success: function (dataOK) {
                                    location.href="obrigado?transaction_id=" + transactionCode;
                                }
                            });
                            location.href="obrigado?transaction_id=" + transactionCode;
    					},
    					abort : function() {
    						if (transactionCode!=''){
    						    $.ajax({
                                    type: "POST",
                                    url: "includes/adicionar_frete.php",
                                    data: {
                                        ses: '<?=session_id();?>',
                                        nomeend: $('.apelidoendereco').prop('value'),
                                        cep: $('#cep').prop('value'),
                                        logradouro: $('#logradouro').prop('value'),
                                        numero: $('#numero').prop('value'),
                                        complemento: $('#complemento').prop('value'),
                                        bairro: $('#bairro').prop('value'),
                                        cidade: $('#cidade').prop('value'),
                                        estado: $('#estado').prop('value'),
                                        pontoreferencia: $('#pto_referencia').prop('value'),
                                        id: '<?=$_SESSION["usr_id_cliente"]?>',
                        				freteID: vI,
                        				freteAID: vAI
                                    },
                                    dataType: "json",
                                    success: function (dataOK) {
                                        location.href="obrigado?transaction_id=" + transactionCode;
                                    }
                                });
    						}
    					}
    				};
    				var isOpenLightbox = PagSeguroLightbox(code, callback);
    				if (!isOpenLightbox){
    				    location.href="https://pagseguro.uol.com.br/v2/checkout/payment.html?code=" + code;
    				}
    			},
    			error: function(xhr, textStatus, errorThrown){
    				for(i in XMLHttpRequest) {
    					if(i!="channel")
    					console.log(i +" : " + XMLHttpRequest[i])
    				}
    			}
    		});       
        }else{
            $.ajax({
              type: "POST",
              url: "finalizar_pedido.php",
              data: {
                ses: '<?=session_id()?>',
                cep: $('#cep').prop('value'),
                logradouro: $('#logradouro').prop('value'),
                numero: $('#numero').prop('value'),
                complemento: $('#complemento').prop('value'),
                bairro: $('#bairro').prop('value'),
                cidade: $('#cidade').prop('value'),
                estado: $('#estado').prop('value'),
                pontoreferencia: $('#pto_referencia').prop('value'),
                id: '<?=$_SESSION["usr_id_cliente"]?>',
                acao: 'Pedido'
              },
              dataType: "json",
              beforeSend: function () {
                $('#btnFinalizar').hide();
                $('#btnFinalizarL').show();
              },
            });
        }
        $('#botaoF').hide();
        $('#botaoD').show();
    }
}
function finalizarOrcamento(){
    var input_cep = document.getElementById('cep').value;
    var input_logradouro = document.getElementById('logradouro').value;
    var input_numero = document.getElementById('numero').value;
    var input_bairro = document.getElementById('bairro').value;
    var input_cidade = document.getElementById('cidade').value;
    var input_estado = document.getElementById('estado').value;
    var liberado = 'sim';
    
    
    if (input_cep=='' && liberado=='sim'){
        $('#tooltip_cep').show();
        setTimeout(function() {
           $('#tooltip_cep').fadeOut('medium');
        }, 4000);
        liberado = 'nao';
    }
    if (input_logradouro=='' && liberado=='sim'){
        $('#tooltip_logradouro').show();
        setTimeout(function() {
           $('#tooltip_logradouro').fadeOut('medium');
        }, 4000);
        liberado = 'nao';
    }
    if (input_numero=='' && liberado=='sim'){
        $('#tooltip_numero').show();
        setTimeout(function() {
           $('#tooltip_numero').fadeOut('medium');
        }, 4000);
        liberado = 'nao';
    }
    if (input_bairro=='' && liberado=='sim'){
        $('#tooltip_bairro').show();
        setTimeout(function() {
           $('#tooltip_bairro').fadeOut('medium');
        }, 4000);
        liberado = 'nao';
    }
    if (input_cidade=='' && liberado=='sim'){
        $('#tooltip_cidade').show();
        setTimeout(function() {
           $('#tooltip_cidade').fadeOut('medium');
        }, 4000);
        liberado = 'nao';
    }
    if (input_estado=='' && liberado=='sim'){
        $('#tooltip_estado').show();
        setTimeout(function() {
           $('#tooltip_estado').fadeOut('medium');
        }, 4000);
        liberado = 'nao';
    }
    
    if (liberado=='sim'){
        $.ajax({
            type: "POST",
            url: "finalizar_pedido.php",
            data: {
                ses: '<?=session_id();?>',
                cep: $('#cep').prop('value'),
                logradouro: $('#logradouro').prop('value'),
                numero: $('#numero').prop('value'),
                complemento: $('#complemento').prop('value'),
                bairro: $('#bairro').prop('value'),
                cidade: $('#cidade').prop('value'),
                estado: $('#estado').prop('value'),
                pontoreferencia: $('#pto_referencia').prop('value'),
                id: '<?=$_SESSION["usr_id_cliente"]?>',
                acao: 'Pedido'
            },
            dataType: "json",
            success: function (data) {
                if (data.OK)
                location.href="obrigado";
            }
        });
    }
}
function validaAcesso(){
    var email = $('#usuario_carrinho').prop('value');
    var senha = $('#senha_carrinho').prop('value');
    
    $.ajax({
        type: "POST",
        url: "validaLogin.php",
        data: {
          email: email,
          senha: senha,
          sessao: '<?=session_id();?>'
        },
        dataType: "json",
        success: function(dataL){
          if(!dataL.erro){
            window.location='carrinho';
          }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown){
          console.log('erro');
        }
    });
}
function calculo_carrinho(id){
    let valor = parseInt($('#qtd_'+id).prop('value'));
    let preco = $('#qtd_'+id).data('preco');
    let estoque = $('#qtd_'+id).data('estoque');
    let cod = $('#qtd_'+id).data('cod');
    let qtd_minimo = parseInt($('#qtd_'+id).attr('min'));
    $.ajax({
        type: 'POST',
        url: 'includes/calculo_carrinho.php',
        data: {
            id: id,
            valor: valor,
            preco_produto: preco,
            total_parcial: '<?=$total_parcial;?>',
            estoque: estoque,
            cod: cod
        },
        dataType: 'json',
        beforeSend: function () {
            $('#loader_carrinho').show();
        },
        success: function (data) {
            $('#loader_carrinho').hide();
            $('#total_produto_'+id).html(data.preco_final.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'}));
            $('#total_parcial').html(data.total_parcial.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'}));
            $('#total_parcial').attr('data-value', data.total_parcial);
            if (data.cupom!='nao'){
                $('#subtotal_parcial').html(data.cupom.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'}));    
            }
            <?php if (isset($_SESSION["usr_id_cliente"]) AND $_SESSION["usr_id_cliente"]>0){?>
                $('#valor_frete').attr('data-value', '');
                $('#valor_frete').html('Á calcular');
            <?}?>
            if (data.estoque=='nao'){
                $('#qtd_'+id).prop('value', data.qtd_real);
                $('#qtd_disponivel_'+id).html('Máximo!');
                $('#qtd_disponivel_'+id).show();
                setTimeout(function() {
                   $('#qtd_disponivel_'+id).fadeOut('medium');
                   $('#qtd_disponivel_'+id).html('');
                }, 4000);
            }else{
                if (valor<1){
                    $('#qtd_'+id).prop('value', '1');
                }else if (valor<qtd_minimo){
                    $('#qtd_'+id).prop('value', data.qtd_minimo);
                    $('#qtd_disponivel_'+id).html('Mínimo!');
                    $('#qtd_disponivel_'+id).show();
                    setTimeout(function() {
                       $('#qtd_disponivel_'+id).fadeOut('medium');
                       $('#qtd_disponivel_'+id).html('');
                    }, 4000);
                }
            }
        }
    });
    <?php if (isset($_SESSION["usr_id_cliente"]) AND $_SESSION["usr_id_cliente"]>0){?>
        <?php if (isset($vb_catalogo) AND $vb_catalogo!='sim'){?>
        Frete();
    <?}}?>
}
function valida_cupom(){
    var cupom = $('#cupom').prop('value');
    $.ajax({
        type: 'POST',
        url: 'includes/valida_cupom.php',
        data: {
            cupom: cupom,
            soma_carrinho: '<?=$soma_carrinho;?>'
        },
        dataType: 'json',
        success: function (data) {
            if (data.cupom=='nao'){
                $('#msg_cupom').html('Cupom Inválido');
                $('#msg_cupom').addClass('note--error');
                $('#cupom').addClass('error');
                $('#msg_cupom').show();
                setTimeout(function() {
                    $('#msg_cupom').fadeOut('medium');
                    $('#msg_cupom').removeClass('note--error');
                    $('#cupom').removeClass('error');
                }, 4000);
            }else{
                $('#msg_cupom').html('Cupom Aplicado');
                $('#msg_cupom').addClass('note--success');
                $('#cupom').addClass('success');
                $('#msg_cupom').show();
                setTimeout(function() {
                    $('#msg_cupom').fadeOut('medium');
                    $('#msg_cupom').removeClass('note--success');
                    $('#cupom').removeClass('success');
                }, 4000);
                window.location='carrinho';
            }
        }
    });
}
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});

$('.qtd').change(function(){ 
    calculo_carrinho($(this).data('id'));
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