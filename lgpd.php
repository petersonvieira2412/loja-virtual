<? 
ob_start();
require_once "includes/config.php";
$onde = 'lgpd';

if(isset($_POST["lgpd"]) AND $_POST["lgpd"]=="divcookie") {
    $_SESSION['cookies_loja_lgpb']='ativado';
    $_SESSION['cookies_loja_lgpb_desempenho']='ativado';
    $_SESSION['cookies_loja_lgpb_publicidade']='ativado';
    $_SESSION['cookies_loja_lgpb_google']='ativado';
    $_SESSION['cookies_loja_lgpb_facebook']='ativado';

} elseif (isset($_GET["cookie"]) and $_GET["cookie"]=="alerta") {
  	$_SESSION['cookies_loja_alerta']='ativado';
}

if(isset($_POST["action"]) && addslashes(htmlspecialchars($_POST["action"]))=="cookies") {

	$cookies_desempenho = ((isset($_POST['cookies_desempenho']) AND $_POST['cookies_desempenho']!='')?addslashes(htmlspecialchars($_POST['cookies_desempenho'])):$_POST['cookies_desempenho']='');
	$cookies_publicidade = ((isset($_POST['cookies_publicidade']) AND $_POST['cookies_publicidade']!='')?addslashes(htmlspecialchars($_POST['cookies_publicidade'])):$_POST['cookies_publicidade']='');
	$cookies_google = ((isset($_POST['cookies_google']) AND $_POST['cookies_google']!='')?addslashes(htmlspecialchars($_POST['cookies_google'])):$_POST['cookies_google']='');
	$cookies_facebook = ((isset($_POST['cookies_facebook']) AND $_POST['cookies_facebook']!='')?addslashes(htmlspecialchars($_POST['cookies_facebook'])):$_POST['cookies_facebook']='');

	$_SESSION['cookies_loja_lgpb']='ativado';

	if ($cookies_desempenho != "cookies_ativado") {	$_SESSION['cookies_loja_lgpb_desempenho'] = "desativado";} else { $_SESSION['cookies_loja_lgpb_desempenho'] = "ativado";} 
	if ($cookies_publicidade != "cookies_ativado") { $_SESSION['cookies_loja_lgpb_publicidade'] = "desativado";} else { $_SESSION['cookies_loja_lgpb_publicidade'] = "ativado";} 
	if ($cookies_google != "cookies_ativado") {	$_SESSION['cookies_loja_lgpb_google'] = "desativado";} else { $_SESSION['cookies_loja_lgpb_google'] = "ativado";} 
    if ($cookies_facebook != "cookies_ativado") { $_SESSION['cookies_loja_lgpb_facebook'] = "desativado";} else { $_SESSION['cookies_loja_lgpb_facebook'] = "ativado";} 

}
if (!isset($titulo_site) || $titulo_site==''){$titulo_site = 'Lei Geral de Proteção de Dados - '.$nome_loja;}
$descricao_site = 'Lei Geral de Proteção de Dados - '.$nome_loja;
if (!isset($meta_site) || $meta_site==''){$meta_site= '';}
?>
<!doctype html>
<html class="no-js supports-no-cookies" lang="pt-br">
<head>
    <?require_once "includes/head.php";?>
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
                <li><span>Lei Geral de Proteção de Dados</span></li>
            </ul>
        </div>
    </div>
    <div class="container mb-60">
        <h1 class="h3 mt-30 text-center">Lei Geral de Proteção de Dados</h1>
        <div class="rte">
            <div class="container container--sm px-0">
                <form method="post" action="">
                    <p class="mb-25 text-center">Esta política de privacidade se aplica entre você, o usuário deste site e <?=$nome_loja_completa;?>, o proprietário e provedor deste site. A <?=$nome_loja_completa;?> leva muito a sério a privacidade de suas informações. Esta política de privacidade se aplica ao nosso uso de todos e quaisquer dados coletados por nós ou fornecidos por você em relação ao seu uso do site.</p>
                    <div class="d-flex align-items-center">
                        <h5 class="mt-5 mb-0">ESSENCIAL</h5>
                    </div>
                    <div class="mt-15 d-flex align-items-center">
                        <input type="checkbox" id="essencial" class="mr-15" checked>
                        <label for="essencial" class="inline" style="color: #858585;">Esses cookies são necessários para o funcionamento do site e não podem ser desligados em nossos sistemas. Normalmente, eles são definidos apenas em resposta a ações feitas por você que equivalem a uma solicitação de serviços, como definir suas preferências de privacidade, fazer login ou preencher formulários. Você pode configurar seu navegador para bloquear ou alertá-lo sobre esses cookies, mas algumas partes do site não funcionarão. Esses cookies não armazenam nenhuma informação pessoalmente identificável.</label></li>
                    </div>
                    <div class="d-flex align-items-center mt-15">
                        <h5 class="mt-5 mb-0">COOKIES DE DESEMPENHO</h5>
                    </div>
                    <div class="mt-15 d-flex align-items-center">
                        <input type="checkbox" id="cookies_desempenho" class="mr-15" name="cookies_desempenho" value="cookies_ativado" <?if ($_SESSION['cookies_loja_lgpb_desempenho']!='desativado'){echo "checked";}?> >
                        <label for="cookies_desempenho" class="inline" style="color: #858585;">Esses cookies nos permitem contar visitas e fontes de tráfego, para que possamos medir e melhorar o desempenho do nosso site. Eles nos ajudam a saber quais páginas são as mais e menos populares e a ver como os visitantes se movem no site. Todas as informações que esses cookies coletam são agregadas e, portanto, anônimas. Se você não permitir esses cookies, não saberemos quando você visitou nosso site.</label></li>
                    </div>
                    <div class="d-flex align-items-center mt-15">
                        <h5 class="mt-5 mb-0">COOKIES DE SEGMENTAÇÃO</h5>
                    </div>
                    <div class="mt-15 d-flex align-items-center">
                        <input type="checkbox" id="cookies_publicidade" class="mr-15" name="cookies_publicidade" value="cookies_ativado" <?if ($_SESSION['cookies_loja_lgpb_publicidade']!='desativado'){echo "checked";}?> >
                        <label for="cookies_publicidade" class="inline" style="color: #858585;">Esses cookies podem ser definidos em nosso site por nossos parceiros de publicidade. Eles podem ser usados por essas empresas para construir um perfil de seus interesses e mostrar anúncios relevantes em outros sites. Eles não armazenam informações pessoais diretamente, mas se baseiam na identificação exclusiva de seu navegador e dispositivo de Internet. Se você não permitir esses cookies, terá publicidade menos direcionada.</label></li>
                    </div>
                    <div class="d-flex align-items-center mt-15">
                        <h5 class="mt-5 mb-0">GOOGLE ANALYTICS</h5>
                    </div>
                    <div class="mt-15 d-flex align-items-center">
                        <input type="checkbox" id="cookies_google" class="mr-15" name="cookies_google" value="cookies_ativado" <?if ($_SESSION['cookies_loja_lgpb_google']!='desativado'){echo "checked";}?> >
                        <label for="cookies_google" class="inline" style="color: #858585;">Esses cookies permitem o uso da ferramenta Google Analytics no site.</label></li>
                    </div>
                    <div class="d-flex align-items-center mt-15">
                        <h5 class="mt-5 mb-0">FACEBOOK PIXEL</h5>
                    </div>
                    <div class="mt-15 d-flex align-items-center">
                        <input type="checkbox" id="cookies_facebook" class="mr-15" name="cookies_facebook" value="cookies_ativado" <?if ($_SESSION['cookies_loja_lgpb_facebook']!='desativado'){echo "checked";}?> >
                        <label for="cookies_facebook" class="inline" style="color: #858585;">Esses cookies permitem o uso da ferramenta Facebook Pixel para rastreio no site.</label></li>
                    </div>
                    <p class="my-40 mt-40 text-center">
                        <input type="hidden" name="action" value="cookies">
                        <button class="btn btn--secondary" type="submit" id="submit" name="cookies">CONFIRMAR ALTERAÇÕES</button>
                    </p>
                </form>
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