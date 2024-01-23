<?
ob_start();
require_once "includes/config.php";
if (isset($_SESSION["usr_id_cliente"]) AND $_SESSION["usr_id_cliente"]!="" AND $_SESSION["usr_id_cliente"]>0) {
    echo '<meta http-equiv="refresh" content=0;url="perfil">';
	exit();
}
$onde = 'login';
if (!isset($titulo_site) || $titulo_site==''){$titulo_site = 'Login do Cliente';}
if (!isset($descricao_site) || $descricao_site==''){$descricao_site = '';}
if (!isset($meta_site) || $meta_site==''){$meta_site= '';}
?>
<!doctype html>
<html class="no-js supports-no-cookies" lang="pt-br">
<head>
<?require_once "includes/head.php";?>
<style>
    .container-login{
        max-width: 370px !important;
    }
</style>
</head>
<body id="account" class="template-account theme-css-animate" data-currency-multiple="true">
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
                <li><span>Login do Cliente</span></li>
            </ul>
        </div>
    </div>
    <div class="login mb-60">
        <div class="container container-login">
            <div id="CustomerLoginForm">
                <h1 class="h3 mt-30 mb-40 text-center">LOGIN DO CLIENTE</h1>
                <form method="post" action="entrando" accept-charset="UTF-8">
                    <label for="usuario" class="label-required">E-mail</label>
                    <input type="email" name="usuario" id="usuario" class="" placeholder="Entre com seu e-mail" spellcheck="false" autocomplete="off" autocapitalize="off" required="required" autofocus>
                    <label for="senha" class="label-required">Senha</label>
                    <label class="label" style="float:right; padding: 0; margin: 0; height: 17px;"><a href="#recuperar" title="Esqueceu a Senha?" class="btn-link js-button-block-visibility" data-block-link="#recuperar" tabindex="-1">Esqueceu?</a></label>
                    <input type="password" name="senha" id="senha" class="" placeholder="Entre com sua senha" required="required">
                    <svg aria-hidden="true" onclick="mostraSenha(senha);" focusable="false" role="presentation" class="icon icon-theme-154" viewBox="0 0 24 24" style="border: none; margin-top: -3.65em; background: transparent; margin-left: 23.5em; position: absolute;">
                        <path d="M8.528 17.238c-1.107-.592-2.074-1.25-2.9-1.973-.827-.723-1.491-1.393-1.992-2.012-.501-.618-.771-.96-.811-1.025a.571.571 0 0 1-.117-.352c0-.13.039-.247.117-.352.039-.064.306-.406.801-1.025.495-.618 1.159-1.289 1.992-2.012.833-.723 1.803-1.38 2.91-1.973a7.424 7.424 0 0 1 3.555-.889c1.263 0 2.448.297 3.555.889 1.106.593 2.073 1.25 2.9 1.973.827.723 1.491 1.394 1.992 2.012.501.619.771.961.811 1.025a.573.573 0 0 1 .117.352.656.656 0 0 1-.117.371c-.039.053-.31.391-.811 1.016-.501.625-1.169 1.296-2.002 2.012-.833.717-1.804 1.371-2.91 1.963a7.375 7.375 0 0 1-3.535.889 7.415 7.415 0 0 1-3.555-.889zm.869-9.746c-.853.41-1.631.889-2.334 1.436s-1.312 1.101-1.826 1.66c-.515.561-.889.99-1.123 1.289.234.3.608.729 1.123 1.289.514.561 1.123 1.113 1.826 1.66s1.484 1.025 2.344 1.436 1.751.615 2.676.615c.924 0 1.813-.205 2.666-.615.853-.41 1.634-.889 2.344-1.436.709-.547 1.318-1.1 1.826-1.66.508-.56.885-.989 1.133-1.289a41.634 41.634 0 0 0-1.133-1.289c-.508-.56-1.113-1.113-1.816-1.66s-1.484-1.025-2.344-1.436-1.751-.615-2.676-.615c-.937 0-1.833.205-2.686.615zm.04 7.031c-.736-.735-1.104-1.617-1.104-2.646 0-1.028.368-1.91 1.104-2.646.735-.735 1.618-1.104 2.646-1.104 1.028 0 1.911.368 2.646 1.104.735.736 1.104 1.618 1.104 2.646 0 1.029-.368 1.911-1.104 2.646-.736.736-1.618 1.104-2.646 1.104-1.029 0-1.911-.367-2.646-1.104zm.878-4.414a2.41 2.41 0 0 0-.732 1.768c0 .69.244 1.279.732 1.768s1.077.732 1.768.732c.69 0 1.279-.244 1.768-.732s.732-1.077.732-1.768c0-.689-.244-1.279-.732-1.768s-1.078-.732-1.768-.732-1.279.244-1.768.732z"></path>
                    </svg>
                    <div class="text-center">
                        <input type="button" class="btn btn--full btn--secondary" value="continuar" id="botao_login" onclick="Login('');">
                        <div class="note note--error mt-10 mb-0" style="display: none;" id="login_incorreto">E-mail ou senha incorretos, por favor, tente novamente!</div>
                        <div>
                            N&atilde;o possui uma conta? <a href="cadastrar" title="Cadastre-se" class="btn-link mt-20 mb-0">Cadastre-se</a>
                        </div>
                        <div class="mt-15">
                            Ao continuar com o acesso, voc&ecirc; concorda com a nossa <a href="<?=$url_loja;?>/politica-de-privacidade" title="Pol&iacute;tica de Privacidade" class="btn-link js-button-block-visibility">Pol&iacute;tica de Privacidade</a>
                        </div>
                    </div>
                </form>
            </div>
            <form method="post" action="recuperar_senha" accept-charset="UTF-8">
                <div id="recuperar_senha" class="pt-35 mt-35 border-top d-none-important" data-block-visibility="#recuperar">
                    <h2 class="h3 text-center">Resetar Senha</h2>
                    <p>Enviaremos um e-mail para redefinir sua senha.</p>
                    <label for="recuperar_email" class="label-required">E-MAIL</label>
                    <input type="email" name="recuperar_email" id="recuperar_email" placeholder="Entre com seu e-mail" spellcheck="false" autocomplete="off" autocapitalize="off" required="required" data-block-visibility-focus>
                    <div class="note" style="display: none;" id="recuperar_senha_pagina"></div>
                    <input type="button" class="btn btn--full" value="RECUPERAR" onclick="Recuperar('pagina');">
                    <div class="mt-15 text-center">
                        <span class="btn-link js-button-block-visibility" data-action="close" data-block-link="#recuperar">Fechar</span>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        Loader.require({
            type: "script",
            name: "buttons_blocks_visibility"
        });
        Loader.require({
            type: "script",
            name: "customers_login"
        });
    </script>
</main>
<?require_once "includes/footer.php"?>
<script>
$(document).keypress(function(e) {
    if(e.which == 13) $('#botao_login').click();
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