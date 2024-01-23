<?
ob_start();
require_once "includes/config.php";
require_once "dash/check_login.php";
$onde = 'perfil';

if(isset($_POST['novo_endereco'])){
    $apelido = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['apelido'], MB_CASE_TITLE, "UTF-8"))));
    $cep = trim(addslashes(htmlspecialchars($_POST['cep'])));
    $endereco = ucfirst(trim(addslashes(htmlspecialchars(mb_convert_case($_POST['endereco'], MB_CASE_TITLE, "UTF-8")))));
    $bairro = ucfirst(trim(addslashes(htmlspecialchars(mb_convert_case($_POST['bairro'], MB_CASE_TITLE, "UTF-8")))));
    $cidade = ucfirst(trim(addslashes(htmlspecialchars(mb_convert_case($_POST['cidade'], MB_CASE_TITLE, "UTF-8")))));
    $estado = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['estado'], MB_CASE_UPPER, "UTF-8"))));
    $numero = trim(addslashes(htmlspecialchars($_POST['numero'])));
    $complemento = ucfirst(trim(addslashes(htmlspecialchars(mb_convert_case($_POST['complemento'], MB_CASE_TITLE, "UTF-8")))));
    $principal = trim(addslashes(htmlspecialchars($_POST['principal'])));
    
    $data_cadastro = date('Y-m-d');
    $hora_cadastro = date('H:i:s');
    
    if (isset($principal) AND $principal=='sim'){
        $update = "UPDATE enderecos_entrega SET principal='nao' WHERE principal='sim' AND id_cliente='".$_SESSION["usr_id_cliente"]."'";
        $executa = mysqli_query($conn, $update);
    }

    $insere = "INSERT INTO enderecos_entrega (id_cliente, apelido, cep, endereco, bairro, cidade, estado, numero, complemento, principal, data_cadastro, hora_cadastro) VALUES ('".$_SESSION["usr_id_cliente"]."', '$apelido', '$cep', '$endereco', '$bairro', '$cidade', '$estado', '$numero', '$complemento', '$principal', '$data_cadastro', '$hora_cadastro')" or die(mysqli_error());
    $executa = mysqli_query($conn, $insere);

    if ($executa) {
        echo "<meta http-equiv='refresh' content='0;URL=".$url_loja."/enderecos'>";
        exit;
    }
}
if(isset($_POST['atualizar_endereco'])){
    $apelido = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['apelido'], MB_CASE_TITLE, "UTF-8"))));
    $cep = trim(addslashes(htmlspecialchars($_POST['cep'], MB_CASE_TITLE, "UTF-8")));
    $endereco = ucfirst(trim(addslashes(htmlspecialchars(mb_convert_case($_POST['endereco'], MB_CASE_TITLE, "UTF-8")))));
    $bairro = ucfirst(trim(addslashes(htmlspecialchars(mb_convert_case($_POST['bairro'], MB_CASE_TITLE, "UTF-8")))));
    $cidade = ucfirst(trim(addslashes(htmlspecialchars(mb_convert_case($_POST['cidade'], MB_CASE_TITLE, "UTF-8")))));
    $estado = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['estado'], MB_CASE_UPPER, "UTF-8"))));
    $numero = trim(addslashes(htmlspecialchars($_POST['numero'], MB_CASE_TITLE, "UTF-8")));
    $complemento = ucfirst(trim(addslashes(htmlspecialchars(mb_convert_case($_POST['complemento'], MB_CASE_TITLE, "UTF-8")))));

    $update = ("UPDATE enderecos_entrega SET apelido='$apelido', endereco='$endereco', numero='$numero', bairro='$bairro', cep='$cep', cidade='$cidade', estado='$estado', complemento='$complemento' WHERE id='".$_GET["id"]."' AND id_cliente='".$_SESSION["usr_id_cliente"]."' ");
    $executa = mysqli_query($conn, $update);

    if ($executa) {
        echo "<meta http-equiv='refresh' content='0;URL=".$url_loja."/enderecos'>";
        exit;
    }
}
if(isset($_POST['alterar_senha'])){
    
    $senha_atual = ((isset($_POST['senha_atual']) AND $_POST['senha_atual']!='')?sha1(trim(addslashes($_POST['senha_atual']))):'');
    $nova_senha = ((isset($_POST['nova_senha']) AND $_POST['nova_senha']!='')?sha1(trim(addslashes($_POST['nova_senha']))):'');
    $confirma_senha = ((isset($_POST['confirma_senha']) AND $_POST['confirma_senha']!='')?sha1(trim(addslashes($_POST['confirma_senha']))):'');
    
    if ($nova_senha!='' AND $confirma_senha!='' AND $senha_atual!=''){
        if ($nova_senha==$confirma_senha){
            $verifica = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM clientes WHERE senha='$senha_atual' AND id='".$_SESSION["usr_id_cliente"]."' AND status='a' LIMIT 1"));
            
            if ($verifica>0){
                $update = "UPDATE clientes SET senha='$nova_senha' WHERE id='".$_SESSION["usr_id_cliente"]."'";
                $executa = mysqli_query($conn, $update);
                
                $alert = '
                <div class="note note--success mt-10">
                    <h4 class="mb-0">Senha alterada com sucesso!</h4>
                </div>';
                
            }else{
                $alert = '
                <div class="note note--error mt-10">
                    <h4 class="mb-0">Senha atual não coincide!</h4>
                </div>';
            }
            
        }else{
            $alert = '
            <div class="note note--error mt-10">
                <h4 class="mb-0">As senhas não coincidem, tente novamente!</h4>
            </div>';
        }
    }else{
        $alert = '
        <div class="note note--error mt-10">
            <h4 class="mb-0">Preencha todo o formulário!</h4>
        </div>';
    }
}
if(isset($_POST['excluir_endereco']) AND $_POST['excluir_endereco']=='excluir_endereco'){
    $id = (int)$_POST['id'];
    $update = $conn->query("DELETE FROM enderecos_entrega WHERE id='".$id."' AND id_cliente='".$_SESSION["usr_id_cliente"]."'");

    if ($update) {
        echo "<meta http-equiv='refresh' content='0;URL=enderecos'>";
        exit;
    }
}
if(isset($_POST['atualizar_principal'])){
    $id = (Int)$_POST['id'];
    $data = date('Y-m-d');
    $hora = date('H:i:s');
    
    $update = "UPDATE enderecos_entrega SET principal='nao' WHERE principal='sim' AND id_cliente='".$_SESSION["usr_id_cliente"]."'";
    $executa = mysqli_query($conn, $update);

    $update = "UPDATE enderecos_entrega SET principal='sim', data_editar='$data', hora_editar='$hora' WHERE id='".$id."' AND id_cliente='".$_SESSION["usr_id_cliente"]."'";
    $executa = mysqli_query($conn, $update);

    if ($executa) {
       echo "<meta http-equiv='refresh' content='0;URL=".$url_loja."/enderecos'>";
       exit();
    }
}
if(isset($_POST['excluir_favorito']) AND $_POST['excluir_favorito']=='excluir_favorito'){
    $id = (int)$_POST['id'];
    $update = $conn->query("DELETE FROM favoritos WHERE id='".$id."' AND usuario='".$_SESSION["usr_id_cliente"]."'");

    if ($update) {
        echo "<meta http-equiv='refresh' content='0;URL=favoritos'>";
        exit;
    }
}
if(isset($_POST['remover_favoritos']) AND $_POST['remover_favoritos']=='remover_favoritos'){
    $update = $conn->query("DELETE FROM favoritos WHERE usuario='".$_SESSION["usr_id_cliente"]."'");

    if ($update) {
        echo "<meta http-equiv='refresh' content='0;URL=favoritos'>";
        exit;
    }
}

if (!isset($_GET['pagina'])){$_GET['pagina']='';}

if (!isset($titulo_site) || $titulo_site==''){
    if ($_GET['pagina']=='enderecos'){
        $titulo_site = 'Endereços de Entrega';
    }elseif ($_GET['pagina']=='pedidos'){
        $titulo_site = 'Pedidos do Cliente';
    }elseif ($_GET['pagina']=='favoritos'){
        $titulo_site = 'Produtos Favoritos';
    }elseif ($_GET['pagina']=='novo_endereco'){
        $titulo_site = 'Novo Endereço de Entrega';
    }elseif ($_GET['pagina']=='editar_endereco'){
        $titulo_site = 'Editar Endereço de Entrega';
    }elseif ($_GET['pagina']=='detalhe_pedido'){
        $titulo_site = 'Detalhes do Pedido Nº '.$_GET['pedido'];
    }else{
        $titulo_site = 'Perfil do Cliente';
    }
}
if (!isset($descricao_site) || $descricao_site==''){$descricao_site = '';}
if (!isset($meta_site) || $meta_site==''){$meta_site= '';}
?>
<!doctype html>
<html class="no-js supports-no-cookies" lang="pt-br">
<head>
<?require_once "includes/head.php";?>
<script>
$(document).ready(function() {
    var CEPoptionsC =  {
        reverse: true,
        selectOnFocus: true,
        onComplete: function(cep) {
            buscaCepC(cep);
        },
        onChange: function(cep){
            if(cep.length == 0){
                $('#logradouroC').prop('value','');
                $('#numeroC').prop('value','');
                $('#pto_referenciaC').prop('value','');
                $('#complementoC').prop('value','');
                $('#bairroC').prop('value','');
                $('#cidadeC').prop('value','');
                $('#estadoC').prop('value','');

                $('#logradouroC').attr('placeholder','Logradouro');
                $('#numeroC').attr('placeholder','Numero');
                $('#pto_referenciaC').attr('placeholder','Ponto de referência');
                $('#complementoC').attr('placeholder','Complemento');
                $('#bairroC').attr('placeholder','Bairro');
                $('#cidadeC').attr('placeholder','Cidade');
                $('#estadoC').attr('placeholder','Estado');

            }else{

                if(cep.length < 9){
                    $('#logradouroC').attr('placeholder','buscando...');
                    $('#numeroC').prop('value','');
                    $('#complementoC').prop('value','');
                    $('#bairroC').attr('placeholder','buscando...');
                    $('#cidadeC').attr('placeholder','buscando...');
                    $('#estadoC').attr('placeholder','buscando...');
                }
            }
        }
    };
    
    $('.cepC').mask('00000-000', CEPoptionsC);
    function buscaCepC(cep){
        var cepOK = cep.replace(/\D/g, '');
        $.getJSON('https://viacep.com.br/ws/'+cepOK+'/json/', function(data){
            $('#logradouroC').prop('value',data.logradouro);
            $('#numeroC').prop('value','');
            $('#bairroC').prop('value',data.bairro);
            $('#cidadeC').prop('value',data.localidade);
            $('#estadoC').prop('value',data.uf);
            $('#numeroC').focus();
            $('#logradouroC').attr('placeholder','Logradouro');
            $('#numeroC').attr('placeholder','Numero');
            $('#pto_referenciaC').attr('placeholder','Ponto de referência');
            $('#bairroC').attr('placeholder','Bairro');
            $('#cidadeC').attr('placeholder','Cidade');
            $('#estadoC').attr('placeholder','Estado');
        });
    }
});
</script>
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
                <li><a href="<?=$url_loja;?>/perfil" title="Perfil do Cliente"><span>Perfil do Cliente</span></a></li>
                <?if ($_GET['pagina']=='enderecos'){
                    echo '<li><span>Endereços</span></li>';
                }elseif ($_GET['pagina']=='pedidos'){
                    echo '<li><span>Pedidos</span></li>';
                }elseif ($_GET['pagina']=='favoritos'){
                    echo '<li><span>Favoritos</span></li>';
                }elseif ($_GET['pagina']=='novo_endereco'){
                    echo '<li><span>Novo Endereço</span></li>';
                }elseif ($_GET['pagina']=='editar_endereco'){
                    echo '<li><span>Editar Endereço</span></li>';
                }elseif ($_GET['pagina']=='detalhe_pedido'){
                    echo '<li><span>Pedido Nº '.$_GET['pedido'].'</span></li>';
                }?>
            </ul>
        </div>
    </div>
    <div class="account mb-60">
        <div class="container">
            <h1 class="h3 mt-30 mb-40 text-center">PERFIL DO CLIENTE</h1>
            <div class="tabs js-tabs" data-type="horizontal">
                <div class="tabs__head" data-js-tabs-head>
                    <div class="tabs__slider justify-content-lg-center" data-js-tabs-slider>
                        <div class="tabs__btn" data-js-tabs-btn <?echo (($_GET['pagina']=='cadastro' || $_GET['pagina']=='perfil' || $_GET['pagina']=='')?'data-active="true"':'');?>>Cadastro</div>
                        <div class="tabs__btn" data-js-tabs-btn <?echo (($_GET['pagina']=='enderecos')?'data-active="true"':'');?>>Endereços</div>
                        <div class="tabs__btn" data-js-tabs-btn <?echo (($_GET['pagina']=='pedidos')?'data-active="true"':'');?>>Pedidos</div>
                        <div class="tabs__btn" data-js-tabs-btn <?echo (($_GET['pagina']=='favoritos')?'data-active="true"':'');?>>Favoritos</div>
                        <?if ($_GET['pagina']=='novo_endereco'){?>
                            <div class="tabs__btn d-none" data-js-tabs-btn <?echo (($_GET['pagina']=='novo_endereco')?'data-active="true"':'');?>>Novo Endereço</div>
                        <?}?>
                        <?if ($_GET['pagina']=='editar_endereco'){?>
                            <div class="tabs__btn d-none" data-js-tabs-btn <?echo (($_GET['pagina']=='editar_endereco')?'data-active="true"':'');?>>Editar Endereço</div>
                        <?}?>
                        <?if ($_GET['pagina']=='alterar_senha'){?>
                            <div class="tabs__btn d-none" data-js-tabs-btn <?echo (($_GET['pagina']=='alterar_senha')?'data-active="true"':'');?>>Alterar Senha</div>
                        <?}?>
                        <?if ($_GET['pagina']=='detalhe_pedido'){?>
                            <div class="tabs__btn d-none" data-js-tabs-btn <?echo (($_GET['pagina']=='detalhe_pedido')?'data-active="true"':'');?>>Detalhe Pedido</div>
                        <?}?>
                        <div class="tabs__btn" data-js-tabs-btn>
                            <a href="sair" title="Sair">Sair</a>
                        </div>
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
                        <span data-js-tabs-btn-mobile>Cadastro
                            <i>
                                <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-188" d="M7.158 12.206a.598.598 0 0 1-.186-.439.6.6 0 0 1 .186-.439.602.602 0 0 1 .439-.186h3.75v-3.75a.6.6 0 0 1 .186-.439.602.602 0 0 1 .439-.186c.169 0 .315.063.439.186a.605.605 0 0 1 .186.439v3.75h3.75c.169 0 .315.063.439.186a.605.605 0 0 1 .186.439.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186h-3.75v3.75a.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186.597.597 0 0 1-.439-.186.598.598 0 0 1-.186-.439v-3.75h-3.75a.598.598 0 0 1-.439-.186z"/></svg>
                            </i>
                        </span>
                        <div class="tabs__content rte overflow-hidden" data-js-tabs-content>
                            <?require_once "dash/cadastro.php"?>
                        </div>
                    </div>
                    <div data-js-tabs-tab>
                        <span data-js-tabs-btn-mobile>Endereços
                            <i>
                                <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-188" d="M7.158 12.206a.598.598 0 0 1-.186-.439.6.6 0 0 1 .186-.439.602.602 0 0 1 .439-.186h3.75v-3.75a.6.6 0 0 1 .186-.439.602.602 0 0 1 .439-.186c.169 0 .315.063.439.186a.605.605 0 0 1 .186.439v3.75h3.75c.169 0 .315.063.439.186a.605.605 0 0 1 .186.439.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186h-3.75v3.75a.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186.597.597 0 0 1-.439-.186.598.598 0 0 1-.186-.439v-3.75h-3.75a.598.598 0 0 1-.439-.186z"/></svg>
                            </i>
                        </span>
                        <div class="tabs__content rte overflow-hidden text-center" data-js-tabs-content>
                            <?require_once "dash/enderecos.php"?>
                        </div>
                    </div>
                    <div data-js-tabs-tab>
                        <span data-js-tabs-btn-mobile>Pedidos
                            <i>
                                <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-188" d="M7.158 12.206a.598.598 0 0 1-.186-.439.6.6 0 0 1 .186-.439.602.602 0 0 1 .439-.186h3.75v-3.75a.6.6 0 0 1 .186-.439.602.602 0 0 1 .439-.186c.169 0 .315.063.439.186a.605.605 0 0 1 .186.439v3.75h3.75c.169 0 .315.063.439.186a.605.605 0 0 1 .186.439.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186h-3.75v3.75a.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186.597.597 0 0 1-.439-.186.598.598 0 0 1-.186-.439v-3.75h-3.75a.598.598 0 0 1-.439-.186z"/></svg>
                            </i>
                        </span>
                        <div class="tabs__content rte overflow-hidden text-center" data-js-tabs-content>
                            <?require_once "dash/pedidos.php"?>
                        </div>
                    </div>
                    <div data-js-tabs-tab>
                        <span data-js-tabs-btn-mobile>Favoritos
                            <i>
                                <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-188" d="M7.158 12.206a.598.598 0 0 1-.186-.439.6.6 0 0 1 .186-.439.602.602 0 0 1 .439-.186h3.75v-3.75a.6.6 0 0 1 .186-.439.602.602 0 0 1 .439-.186c.169 0 .315.063.439.186a.605.605 0 0 1 .186.439v3.75h3.75c.169 0 .315.063.439.186a.605.605 0 0 1 .186.439.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186h-3.75v3.75a.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186.597.597 0 0 1-.439-.186.598.598 0 0 1-.186-.439v-3.75h-3.75a.598.598 0 0 1-.439-.186z"/></svg>
                            </i>
                        </span>
                        <div class="tabs__content rte overflow-hidden text-center" data-js-tabs-content>
                            <?require_once "dash/favoritos.php"?>
                        </div>
                    </div>
                    <?if ($_GET['pagina']=='novo_endereco'){?>
                    <div data-js-tabs-tab>
                        <span data-js-tabs-btn-mobile>Novo Endereço
                            <i>
                                <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-188" d="M7.158 12.206a.598.598 0 0 1-.186-.439.6.6 0 0 1 .186-.439.602.602 0 0 1 .439-.186h3.75v-3.75a.6.6 0 0 1 .186-.439.602.602 0 0 1 .439-.186c.169 0 .315.063.439.186a.605.605 0 0 1 .186.439v3.75h3.75c.169 0 .315.063.439.186a.605.605 0 0 1 .186.439.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186h-3.75v3.75a.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186.597.597 0 0 1-.439-.186.598.598 0 0 1-.186-.439v-3.75h-3.75a.598.598 0 0 1-.439-.186z"/></svg>
                            </i>
                        </span>
                        <div class="tabs__content overflow-hidden rte text-center" data-js-tabs-content>
                            <?require_once "dash/novo_endereco.php"?>
                        </div>
                    </div>
                    <?}?>
                    <?if ($_GET['pagina']=='editar_endereco'){?>
                    <div data-js-tabs-tab>
                        <span data-js-tabs-btn-mobile>Editar Endereço
                            <i>
                                <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-188" d="M7.158 12.206a.598.598 0 0 1-.186-.439.6.6 0 0 1 .186-.439.602.602 0 0 1 .439-.186h3.75v-3.75a.6.6 0 0 1 .186-.439.602.602 0 0 1 .439-.186c.169 0 .315.063.439.186a.605.605 0 0 1 .186.439v3.75h3.75c.169 0 .315.063.439.186a.605.605 0 0 1 .186.439.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186h-3.75v3.75a.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186.597.597 0 0 1-.439-.186.598.598 0 0 1-.186-.439v-3.75h-3.75a.598.598 0 0 1-.439-.186z"/></svg>
                            </i>
                        </span>
                        <div class="tabs__content overflow-hidden rte text-center" data-js-tabs-content>
                            <?require_once "dash/editar_endereco.php"?>
                        </div>
                    </div>
                    <?}?>
                    <?if ($_GET['pagina']=='alterar_senha'){?>
                    <div data-js-tabs-tab>
                        <span data-js-tabs-btn-mobile>Alterar Senha
                            <i>
                                <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-188" d="M7.158 12.206a.598.598 0 0 1-.186-.439.6.6 0 0 1 .186-.439.602.602 0 0 1 .439-.186h3.75v-3.75a.6.6 0 0 1 .186-.439.602.602 0 0 1 .439-.186c.169 0 .315.063.439.186a.605.605 0 0 1 .186.439v3.75h3.75c.169 0 .315.063.439.186a.605.605 0 0 1 .186.439.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186h-3.75v3.75a.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186.597.597 0 0 1-.439-.186.598.598 0 0 1-.186-.439v-3.75h-3.75a.598.598 0 0 1-.439-.186z"/></svg>
                            </i>
                        </span>
                        <div class="tabs__content overflow-hidden rte text-center" data-js-tabs-content>
                            <?require_once "dash/alterar_senha.php"?>
                        </div>
                    </div>
                    <?}?>
                    <?if ($_GET['pagina']=='detalhe_pedido'){?>
                    <div data-js-tabs-tab>
                        <span data-js-tabs-btn-mobile>Editar Endereço
                            <i>
                                <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-188" d="M7.158 12.206a.598.598 0 0 1-.186-.439.6.6 0 0 1 .186-.439.602.602 0 0 1 .439-.186h3.75v-3.75a.6.6 0 0 1 .186-.439.602.602 0 0 1 .439-.186c.169 0 .315.063.439.186a.605.605 0 0 1 .186.439v3.75h3.75c.169 0 .315.063.439.186a.605.605 0 0 1 .186.439.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186h-3.75v3.75a.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186.597.597 0 0 1-.439-.186.598.598 0 0 1-.186-.439v-3.75h-3.75a.598.598 0 0 1-.439-.186z"/></svg>
                            </i>
                        </span>
                        <div class="tabs__content overflow-hidden rte text-center" data-js-tabs-content>
                            <?require_once "dash/detalhe_pedido.php"?>
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
</main>
<?require_once "includes/footer.php"?>
<script>
function atualizaDados(id_form){
    var form = document.getElementById(id_form);
    var formData = new FormData(form);
    $.ajax({
        type: 'POST',
        url: 'includes/cadastrar.php',
        data: formData,
        dataType: 'json',
        success: function (data) {
            if (data.ok=='sucesso'){
                if ($('#'+id_form+'_alerta').hasClass("note--error")) {
                    $('#'+id_form+'_alerta').removeClass('note--error');
                }
                $('#'+id_form+'_alerta').addClass('note--success');
                $('#'+id_form+'_alerta').html(data.mensagem);
                $('#'+id_form+'_alerta').show();
                setTimeout(function() {
                   $('#'+id_form+'_alerta').fadeOut('medium');
                   window.location.href='perfil';
                }, 3000);
            }else{
                if ($('#'+id_form+'_alerta').hasClass('note--success')) {
                    $('#'+id_form+'_alerta').removeClass('note--success');
                }
                $('#'+id_form+'_alerta').addClass('note--error');
                $('#'+id_form+'_alerta').html(data.mensagem);
                $('#'+id_form+'_alerta').show();
                setTimeout(function() {
                   $('#'+id_form+'_alerta').fadeOut('medium');
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
$cntACmp =ob_get_contents(); 
ob_end_clean(); 
$cntACmp=str_replace("\n",' ',$cntACmp); 
$cntACmp=preg_replace('/[[:space:]]+/',' ',$cntACmp);
echo $cntACmp; 
ob_end_flush(); 
?>