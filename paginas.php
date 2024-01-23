<?
ob_start();
require_once "includes/config.php";

$sql_paginas = "SELECT * FROM paginas_site WHERE id='$id' AND status='a' LIMIT 1";
$query_paginas = mysqli_query($conn, $sql_paginas);
$dados_paginas = mysqli_fetch_assoc($query_paginas);

$titulo = $dados_paginas['pagina'];
if (isset($dados_paginas['descricao']) AND $dados_paginas['descricao']!=''){
    $descricao = base64_decode(nl2br($dados_paginas['descricao']));
    $descricao = str_replace('[loja_nome]', $nome_loja, $descricao);
    $descricao = str_replace('[loja_email]', '<a href="'.$email_loja_link.'" target="_blank" rel="noopener">'.$email_loja.'</a>', $descricao);
    $descricao = str_replace('[loja_cnpj]', $cnpj_loja, $descricao);
    $descricao = str_replace('[loja_razao]', $razao_social_loja, $descricao);
    $descricao = str_replace('[loja_telefone]', '<a href="'.$link_telefone_loja1.'" target="_blank" rel="noopener">'.$telefone_loja1.'</a>', $descricao);
    $descricao = str_replace('[loja_whatsapp]', '<a href="'.$link_whats.'" target="_blank" rel="noopener">'.$telefone_loja_whats.'</a>', $descricao);
    $descricao = str_replace('[loja_endereco]', '<a href="'.$link_endereco.'" target="_blank" rel="noopener">'.$endereco_loja_completo.'</a>', $descricao);
}
$onde = clean($titulo);

if (!isset($titulo_site) || $titulo_site==''){$titulo_site = $titulo.' - '.$nome_loja;}
if (!isset($descricao_site) || $descricao_site==''){$descricao_site = $titulo.' - '.$nome_loja;}
if (!isset($meta_site) || $meta_site==''){$meta_site= '';}
?>
<!doctype html>
<html class="no-js supports-no-cookies" lang="pt-br">
<head>
    <?require_once "includes/head.php";?>
    <style>
        .paginas p{
            margin-bottom: 10px !important;
            color: #585858 !important;
        }
        ol:not(.list-unstyled) li{
            padding-left: 40px !important;
        }
        .paginas strong{
            color: #000 !important;
        }
    </style>
</head>
<body id="about-our-store" class="template-page theme-css-animate" data-currency-multiple="true">
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
    <div class="breadcrumbs mt-15">
        <div class="container">
            <ul class="list-unstyled d-flex flex-wrap align-items-center justify-content-start">
                <li><a href="<?=$url_loja;?>" title="Home"><i class="fa-sharp fa-solid fa-house"></i></a></li>
                <li><span><?=$titulo;?></span></li>
            </ul>
        </div>
    </div>
    <div class="container mb-60">
        <h1 class="h3 mt-30 text-left"><?=$titulo;?></h1>
        <div class="rte">
            <div class="mt-40">
                <div class="container container--sm px-0 paginas">
                    <?if (isset($descricao) AND $descricao!=''){
                        echo $descricao;
                    }?>
                </div>
            </div>
        </div>
    </div>
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