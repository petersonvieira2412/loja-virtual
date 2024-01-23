<?
ob_start();
require_once "includes/config.php";
$onde = 'cadastrar';

if (!isset($titulo_site) || $titulo_site==''){$titulo_site = 'Cadastro - '.$nome_loja;}
if (!isset($descricao_site) || $descricao_site==''){$descricao_site = '';}
if (!isset($meta_site) || $meta_site==''){$meta_site= '';}
?>
<!doctype html>
<html class="no-js supports-no-cookies" lang="pt-br">
<head>
<?require_once "includes/head.php";?>
<style>
    .container-cadastro{
        max-width: 800px !important;
    }
</style>
<script src="<?=$url_loja;?>/assets/scripts/bootstrap.bundle.5.2.3.min.js"></script>
</head>
<body id="create-account" class="template-register theme-css-animate" data-currency-multiple="true">
<?
if (isset($_SESSION['tag_manager_body']) AND $_SESSION['tag_manager_body']!='') {
	echo $_SESSION['tag_manager_body'];
}
?>
<div id="theme-section-header" class="theme-section">
    <div data-section-id="header" data-section-type="header" >
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
                <li><span>Cadastrar</span></li>
            </ul>
        </div>
    </div>
    <div class="register mb-60">
        <div class="container container-cadastro">
            <h1 class="h3 mt-30 mb-40 text-center">CADASTRAR</h1>
            <form method="post" action="" id="novo_cliente" accept-charset="UTF-8">
                <div class="row">
                    <div class="col-md-12">
                        <label for="nome" class="label-required">Nome Completo</label>
                        <input type="text" name="nome" id="nome" placeholder="Insira seu nome completo" required="required">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="cpf" class="label-required">CPF</label>
                        <input type="text" name="cpf" class="cpf" id="cpf" placeholder="Insira seu CPF" required="required">
                    </div>
                    <div class="col-md-6">
                        <label for="celular" class="label-required">WhatsApp</label>
                        <input type="text" name="celular" class="cel" id="celular" placeholder="Insira seu número de WhatsApp" required="required">
                    </div>
                </div>    
                <div class="border-top border my-15"></div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="email" class="label-required">E-mail</label>
                        <input type="email" name="email" id="email" placeholder="Insira seu endereço de e-mail" spellcheck="false" autocomplete="off" autocapitalize="off" required="required">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-10">
                        <label for="senha" class="label-required" id="senha_label">Senha</label>
                        <label class="label" style="float:right; padding: 0; margin: 0; height: 17px;"><a href="#" title="Gerar Senha" onclick="gerarSenha();" class="btn-link js-button-block-visibility" tabindex="-1">Gerar Senha</a></label>
                        <input type="password" name="senha" id="senha" placeholder="Crie uma senha de acesso" required="required" style="margin-bottom: 5px;" onkeyup="verificaForcaSenha();" maxlength="255" minlength="6">
                        <svg aria-hidden="true" onclick="mostraSenha(senha);" focusable="false" role="presentation" class="icon icon-theme-154" viewBox="0 0 24 24" style="border: none; margin-top: -2.55em; background: transparent; margin-left: 26.5em; position: absolute;">
                            <path d="M8.528 17.238c-1.107-.592-2.074-1.25-2.9-1.973-.827-.723-1.491-1.393-1.992-2.012-.501-.618-.771-.96-.811-1.025a.571.571 0 0 1-.117-.352c0-.13.039-.247.117-.352.039-.064.306-.406.801-1.025.495-.618 1.159-1.289 1.992-2.012.833-.723 1.803-1.38 2.91-1.973a7.424 7.424 0 0 1 3.555-.889c1.263 0 2.448.297 3.555.889 1.106.593 2.073 1.25 2.9 1.973.827.723 1.491 1.394 1.992 2.012.501.619.771.961.811 1.025a.573.573 0 0 1 .117.352.656.656 0 0 1-.117.371c-.039.053-.31.391-.811 1.016-.501.625-1.169 1.296-2.002 2.012-.833.717-1.804 1.371-2.91 1.963a7.375 7.375 0 0 1-3.535.889 7.415 7.415 0 0 1-3.555-.889zm.869-9.746c-.853.41-1.631.889-2.334 1.436s-1.312 1.101-1.826 1.66c-.515.561-.889.99-1.123 1.289.234.3.608.729 1.123 1.289.514.561 1.123 1.113 1.826 1.66s1.484 1.025 2.344 1.436 1.751.615 2.676.615c.924 0 1.813-.205 2.666-.615.853-.41 1.634-.889 2.344-1.436.709-.547 1.318-1.1 1.826-1.66.508-.56.885-.989 1.133-1.289a41.634 41.634 0 0 0-1.133-1.289c-.508-.56-1.113-1.113-1.816-1.66s-1.484-1.025-2.344-1.436-1.751-.615-2.676-.615c-.937 0-1.833.205-2.686.615zm.04 7.031c-.736-.735-1.104-1.617-1.104-2.646 0-1.028.368-1.91 1.104-2.646.735-.735 1.618-1.104 2.646-1.104 1.028 0 1.911.368 2.646 1.104.735.736 1.104 1.618 1.104 2.646 0 1.029-.368 1.911-1.104 2.646-.736.736-1.618 1.104-2.646 1.104-1.029 0-1.911-.367-2.646-1.104zm.878-4.414a2.41 2.41 0 0 0-.732 1.768c0 .69.244 1.279.732 1.768s1.077.732 1.768.732c.69 0 1.279-.244 1.768-.732s.732-1.077.732-1.768c0-.689-.244-1.279-.732-1.768s-1.078-.732-1.768-.732-1.279.244-1.768.732z"></path>
                        </svg>
                        <div class="row" style="display: flex; align-items: center;">
                            <div class="col-md-9 col-9">
                                <div class="progress">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 1%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="col-md-2 col-2" id="senha_status">
                                Fraco
                            </div>
                            <div class="col-md-1 col-1" style="display: contents;">
                                <button type="button" class="button-info btn-shine" data-bs-toggle="popover" data-bs-trigger="hover focus" title="<b style='color: #3e3e3e;'>Dicas para uma senha forte</b>" data-bs-content="• Combine letras maiúsculas e minúsculas, números e caracteres especiais.<br><br>• Não use informações pessoais, como data de nascimento ou CPF.">!</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="confirma_senha" class="label-required">Confirmar Senha</label>
                        <input type="password" name="confirma_senha" id="confirma_senha" placeholder="Confirme sua senha de acesso" required="required">
                        <svg aria-hidden="true" onclick="mostraSenha(confirma_senha);" focusable="false" role="presentation" class="icon icon-theme-154" viewBox="0 0 24 24" style="border: none; margin-top: -3.65em; background: transparent; margin-left: 26.5em; position: absolute;">
                            <path d="M8.528 17.238c-1.107-.592-2.074-1.25-2.9-1.973-.827-.723-1.491-1.393-1.992-2.012-.501-.618-.771-.96-.811-1.025a.571.571 0 0 1-.117-.352c0-.13.039-.247.117-.352.039-.064.306-.406.801-1.025.495-.618 1.159-1.289 1.992-2.012.833-.723 1.803-1.38 2.91-1.973a7.424 7.424 0 0 1 3.555-.889c1.263 0 2.448.297 3.555.889 1.106.593 2.073 1.25 2.9 1.973.827.723 1.491 1.394 1.992 2.012.501.619.771.961.811 1.025a.573.573 0 0 1 .117.352.656.656 0 0 1-.117.371c-.039.053-.31.391-.811 1.016-.501.625-1.169 1.296-2.002 2.012-.833.717-1.804 1.371-2.91 1.963a7.375 7.375 0 0 1-3.535.889 7.415 7.415 0 0 1-3.555-.889zm.869-9.746c-.853.41-1.631.889-2.334 1.436s-1.312 1.101-1.826 1.66c-.515.561-.889.99-1.123 1.289.234.3.608.729 1.123 1.289.514.561 1.123 1.113 1.826 1.66s1.484 1.025 2.344 1.436 1.751.615 2.676.615c.924 0 1.813-.205 2.666-.615.853-.41 1.634-.889 2.344-1.436.709-.547 1.318-1.1 1.826-1.66.508-.56.885-.989 1.133-1.289a41.634 41.634 0 0 0-1.133-1.289c-.508-.56-1.113-1.113-1.816-1.66s-1.484-1.025-2.344-1.436-1.751-.615-2.676-.615c-.937 0-1.833.205-2.686.615zm.04 7.031c-.736-.735-1.104-1.617-1.104-2.646 0-1.028.368-1.91 1.104-2.646.735-.735 1.618-1.104 2.646-1.104 1.028 0 1.911.368 2.646 1.104.735.736 1.104 1.618 1.104 2.646 0 1.029-.368 1.911-1.104 2.646-.736.736-1.618 1.104-2.646 1.104-1.029 0-1.911-.367-2.646-1.104zm.878-4.414a2.41 2.41 0 0 0-.732 1.768c0 .69.244 1.279.732 1.768s1.077.732 1.768.732c.69 0 1.279-.244 1.768-.732s.732-1.077.732-1.768c0-.689-.244-1.279-.732-1.768s-1.078-.732-1.768-.732-1.279.244-1.768.732z"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-center mt-25">
                    <input type="button" value="CADASTRE-SE AGORA!" onclick="Cadastrar();" class="btn btn--full btn--secondary">
                    <a href="login" title="VOLTAR AO LOGIN" class="h6 btn-link mt-20 mb-0">VOLTAR AO LOGIN</a>
                    <div class="note note--error" style="display: none;" id="cadastro_alerta"></div>
                </div>
            </form>
        </div>
    </div>
</main>
<?require_once "includes/footer.php"?>
<script>
$(document).ready(function() {
    $("[data-toggle=popover]").popover();
    $(".button-info").popover({
        html : true
    });
    $('.button-info').html('!');
});
function mostraSenha(id) {
  var x = id;
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
function gerarSenha(){
    const minuscula = 'abcdefghijklmnopqrstuvwxyz';
    const maiuscula = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const numeros = '0123456789';
    const simbolos = '~!@#$%^&*-_+=?><';

    let senha = '';

    senha += minuscula[Math.floor(Math.random() * minuscula.length)];
    senha += maiuscula[Math.floor(Math.random() * maiuscula.length)];
    senha += numeros[Math.floor(Math.random() * numeros.length)];
    senha += simbolos[Math.floor(Math.random() * simbolos.length)];

    const novo_tamanho = length + 6;
    const todos_caracteres = minuscula + maiuscula + numeros + simbolos;

    for (let i = 0; i < novo_tamanho; i++) {
        senha += todos_caracteres[Math.floor(Math.random() * todos_caracteres.length)];
    }

    senha = senha.split('').sort(() => Math.random() - 0.5).join('');
    $('#senha').prop('value', senha);
    $('#senha').prop('type', 'text');
    $('#confirma_senha').prop('value', $('#senha').prop('value'));
    $('#confirma_senha').prop('type', 'text');
    verificaForcaSenha();
}
function verificaForcaSenha(){
	var numeros = /([0-9])/;
	var minusculo = /([a-z])/;
	var maiusculo = /([A-Z])/;
	var chEspeciais = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;

	if($('#senha').val().length<6) {
		$('#senha_status').html("Fraco");
		
		if ($(".progress-bar").hasClass("bg-success")) {
            $('.progress-bar').removeClass("bg-success");
        }
        if ($(".progress-bar").hasClass("bg-warning")) {
            $('.progress-bar').removeClass("bg-warning");
        }
        $('.progress-bar').addClass("bg-danger");
        
		if ($('#senha').val().length<1){
		    $('.progress-bar').width('1%');
		}else{
		    $('.progress-bar').width('20%');
		}
	} else {
	    var soma = 20;
		if($('#senha').val().match(numeros)){
		    soma += 20;
		}
		if($('#senha').val().match(minusculo)){
		    soma += 20;
		}
		if($('#senha').val().match(maiusculo)){
		    soma += 20;
		}
		if($('#senha').val().match(chEspeciais)){
		    soma += 20;
		}
		
	    $('.progress-bar').width(soma+'%');
	    
	    if (soma>40){
	        $('#senha_status').html("Média");
	        if ($(".progress-bar").hasClass("bg-success")) {
	            $('.progress-bar').removeClass("bg-success");
	        }
	        if ($(".progress-bar").hasClass("bg-danger")) {
	            $('.progress-bar').removeClass("bg-danger");
	        }
	        $('.progress-bar').addClass("bg-warning");
	    }
	    if (soma>80){
	        $('#senha_status').html("Forte");
	        if ($(".progress-bar").hasClass("bg-danger")) {
	            $('.progress-bar').removeClass("bg-danger");
	        }
	        if ($(".progress-bar").hasClass("bg-warning")) {
	            $('.progress-bar').removeClass("bg-warning");
	        }
	        $('.progress-bar').addClass("bg-success");
	    }
	}
}
function Cadastrar(){
    var status_senha = $("#senha_status").text();
    if ($(".progress-bar").hasClass("bg-success") || $(".progress-bar").hasClass("bg-warning")){
        var senha_progresso = true;
    }else{
        var senha_progresso = false;
    }
    if ((status_senha=='Média' || status_senha=='Forte') && senha_progresso==true){
        var form = document.getElementById("novo_cliente");
        var formData = new FormData(form);
        $.ajax({
            type: 'POST',
            url: 'includes/cadastrar.php',
            data: formData,
            dataType: 'json',
            success: function (data) {
                if (data.ok=='sucesso'){
                    if ($("#cadastro_alerta").hasClass("note--error")) {
                        $("#cadastro_alerta").removeClass('note--error');
                    }
                    $('#cadastro_alerta').addClass('note--success');
                    $('#cadastro_alerta').html(data.mensagem);
                    $('#cadastro_alerta').show();
                    setTimeout(function() {
                       $('#cadastro_alerta').fadeOut('medium');
                       window.location.href='perfil';
                    }, 3000);
                }else{
                    if ($("#cadastro_alerta").hasClass("note--success")) {
                        $("#cadastro_alerta").removeClass('note--success');
                    }
                    $('#cadastro_alerta').addClass('note--error');
                    $('#cadastro_alerta').html(data.mensagem);
                    $('#cadastro_alerta').show();
                    setTimeout(function() {
                       $('#cadastro_alerta').fadeOut('medium');
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
    }else{
        if ($("#cadastro_alerta").hasClass("note--success")) {
            $("#cadastro_alerta").removeClass('note--success');
        }
        $('#cadastro_alerta').addClass('note--error');
        $('#senha_label').addClass('error');
        $('#senha').addClass('error');
        $('#cadastro_alerta').html('Senha não é forte o suficiente!');
        $('#cadastro_alerta').show();
        setTimeout(function() {
            $('#cadastro_alerta').fadeOut('medium');
            $('#senha_label').removeClass('error');
            $('#senha').removeClass('error');
        }, 4000);
    }
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