<?
require_once "includes/config.php";
$onde = 'recuperar_senha';
if (!isset($titulo_site) || $titulo_site == '') {
    $titulo_site = 'Recuperar Senha';
}
if (!isset($descricao_site) || $descricao_site == '') {
    $descricao_site = '';
}
if (!isset($meta_site) || $meta_site == '') {
    $meta_site = '';
}

$token = ((isset($_SESSION["_browser_nav_cache_token_"]))?$_SESSION["_browser_nav_cache_token_"]:'');
  
if($token!=''){
  $temCod = mysqli_query($conn,"SELECT * FROM clientes WHERE token='$token' limit 1") or die(mysqli_error($conn));
  if(mysqli_num_rows($temCod)==0){
    echo "<script>alert('Token invalido!');</script>";
    echo "<meta http-equiv='refresh' content=0;url='login'>";
    exit(); 
  }else{
    $d = mysqli_fetch_array($temCod);
    $_SESSION["_browser_nav_cache_id_"] = $d['id'];
  }
}else{
  echo "<script>alert('Token invalido!');</script>";
  echo "<meta http-equiv='refresh' content=0;url='".$url_loja."/login'>";
  exit();
}
?>
<!doctype html>
<html class="no-js supports-no-cookies" lang="pt-br">
<head>
    <? require_once "includes/head.php"; ?>
</head>
<body id="account" class="template-account theme-css-animate" data-currency-multiple="true">
    <?
    if (isset($_SESSION['tag_manager_body']) and $_SESSION['tag_manager_body'] != '') {
        echo $_SESSION['tag_manager_body'];
    }
    ?>
    <div id="theme-section-header" class="theme-section">
        <div data-section-id="header" data-section-type="header">
            <header id="header" class="header position-lg-relative js-header-sticky" data-js-sticky="desktop_and_mobile" data-js-desktop-sticky-sidebar="true">
                <? require_once "includes/header.php"; ?>
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
                    <li><span>Recuperação de Senha</span></li>
                </ul>
            </div>
        </div>
        <div class="login mb-60">
            <div class="container">
                <div id="CustomerLoginForm">
                    <h1 class="h3 mt-30 mb-40 text-center">Recuperação de Senha</h1>
                    <form method="post" action="" accept-charset="UTF-8" id="nova_senha">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="senha" class="label-required">NOVA SENHA</label>
                                <input type="password" name="senha" id="senha" placeholder="Entre com a nova senha" required>
                            </div>
                            <div class="col-md-6">
                                <label for="confirma_senha" class="label-required">CONFIRMAR NOVA SENHA</label>
                                <input type="password" name="confirma_senha" id="confirma_senha" placeholder="Confirme a nova senha" required>
                            </div>
                        </div>
                        <div class="text-center">
                            <input type="hidden" value="nova_senha" name="nova_senha">
                            <input type="button" class="btn btn--full btn--secondary" onclick="NovaSenha();" value="Redefinir">
                            <div class="note note--error" style="display: none;" id="nova_senha_alerta"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <? require_once "includes/footer.php" ?>
    <script>
        function NovaSenha(){
            var form = document.getElementById("nova_senha");
            var formData = new FormData(form);
            $.ajax({
                type: 'POST',
                url: 'includes/nova_senha.php',
                data: formData,
                dataType: 'json',
                success: function (data) {
                    if (data.ok=='sucesso'){
                        if ($("#nova_senha_alerta").hasClass("note--error")) {
                            $("#nova_senha_alerta").removeClass('note--error');
                        }
                        $('#nova_senha_alerta').addClass('note--success');
                        $('#nova_senha_alerta').html(data.mensagem);
                        $('#nova_senha_alerta').show();
                        setTimeout(function() {
                        $('#nova_senha_alerta').fadeOut('medium');
                        window.location.href='minha_conta';
                        }, 3000);
                    }else{
                        if ($("#nova_senha_alerta").hasClass("note--success")) {
                            $("#nova_senha_alerta").removeClass('note--success');
                        }
                        $('#nova_senha_alerta').addClass('note--error');
                        $('#nova_senha_alerta').html(data.mensagem);
                        $('#nova_senha_alerta').show();
                        setTimeout(function() {
                        $('#nova_senha_alerta').fadeOut('medium');
                        }, 4000);
                    }
                },
                cache: false,
                contentType: false,
                processData: false,
                xhr: function() {
                    var myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) {
                        myXhr.upload.addEventListener('progress', function() {
                        }, false);
                    }
                    return myXhr;
                }
            });
        }
    </script>
</body>
</html>
<?
$cntACmp = ob_get_contents();
ob_end_clean();
$cntACmp = str_replace("\n", ' ', $cntACmp);
$cntACmp = preg_replace('/[[:space:]]+/', ' ', $cntACmp);
echo $cntACmp;
ob_end_flush();
?>