<div class="popup__body position-relative d-none justify-content-end" data-js-popup-name="account" data-popup-right style="background-color: #000000b5;">
    <div class="popup-account py-25 px-20 js-popup-account" data-popup-content style="background-color: white;">
        <div class="popup-account__login">
            <div class="popup-account__head d-flex align-items-center mb-10">
                <h5 class="m-0">MINHA CONTA</h5>
                <i class="popup-account__close ml-auto cursor-pointer" data-js-popup-close>
                    <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-164" viewBox="0 0 24 24">
                        <path d="M19.583 4.965a.65.65 0 0 1-.176.449l-6.445 6.426 6.445 6.426c.117.131.176.28.176.449a.65.65 0 0 1-.176.449.846.846 0 0 1-.215.127.596.596 0 0 1-.468 0 .846.846 0 0 1-.215-.127l-6.426-6.445-6.426 6.445a.846.846 0 0 1-.215.127.596.596 0 0 1-.468 0 .846.846 0 0 1-.215-.127.65.65 0 0 1-.176-.449c0-.169.059-.318.176-.449l6.445-6.426-6.445-6.426a.65.65 0 0 1-.176-.449c0-.169.059-.318.176-.449a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176l6.426 6.445 6.426-6.445a.652.652 0 0 1 .449-.176c.169 0 .319.059.449.176.117.13.176.28.176.449z"/>
                    </svg>
                </i>
            </div>
            <?if (isset($_SESSION["usr_id_cliente"]) AND $_SESSION["usr_id_cliente"]>0){?>
                <a href="meu_cadastro" title="MEU CADASTRO" class="btn btn--full btn--secondary mt-20">MEU CADASTRO</a>
                <a href="meus_enderecos" title="MEUS ENDEREÇOS" class="btn btn--full btn--secondary mt-10">MEUS ENDEREÇOS</a>
                <a href="meus_pedidos" title="MEUS PEDIDOS" class="btn btn--full btn--secondary mt-10">MEUS PEDIDOS</a>
                <a href="meus_favoritos" title="MEUS FAVORITOS" class="btn btn--full btn--secondary mt-10">MEUS FAVORITOS</a>
                <a href="sair" title="SAIR" class="btn btn--full btn--secondary mt-50">SAIR</a>
            <?}else{?>
                <form method="post" action="entrando" id="popup_customer_login" accept-charset="UTF-8" class="mb-15">
                    <div>
                        <label for="usuario_lateral" class="label-required">E-MAIL</label>
                        <input type="email" name="usuario" id="usuario_lateral" class="" placeholder="EMAIL" spellcheck="false" autocomplete="off" autocapitalize="off" required="required">
                    </div>
                    <div>
                        <label for="senha_lateral" class="label-required">SENHA</label>
                        <input type="password" name="senha" id="senha_lateral" class="" placeholder="SENHA" required="required">
                        <svg aria-hidden="true" onclick="mostraSenha(senha_lateral);" focusable="false" role="presentation" class="icon icon-theme-154" viewBox="0 0 24 24" style="border: none; margin-top: -3.65em; background: transparent; margin-left: 15.5em; position: absolute;">
                            <path d="M8.528 17.238c-1.107-.592-2.074-1.25-2.9-1.973-.827-.723-1.491-1.393-1.992-2.012-.501-.618-.771-.96-.811-1.025a.571.571 0 0 1-.117-.352c0-.13.039-.247.117-.352.039-.064.306-.406.801-1.025.495-.618 1.159-1.289 1.992-2.012.833-.723 1.803-1.38 2.91-1.973a7.424 7.424 0 0 1 3.555-.889c1.263 0 2.448.297 3.555.889 1.106.593 2.073 1.25 2.9 1.973.827.723 1.491 1.394 1.992 2.012.501.619.771.961.811 1.025a.573.573 0 0 1 .117.352.656.656 0 0 1-.117.371c-.039.053-.31.391-.811 1.016-.501.625-1.169 1.296-2.002 2.012-.833.717-1.804 1.371-2.91 1.963a7.375 7.375 0 0 1-3.535.889 7.415 7.415 0 0 1-3.555-.889zm.869-9.746c-.853.41-1.631.889-2.334 1.436s-1.312 1.101-1.826 1.66c-.515.561-.889.99-1.123 1.289.234.3.608.729 1.123 1.289.514.561 1.123 1.113 1.826 1.66s1.484 1.025 2.344 1.436 1.751.615 2.676.615c.924 0 1.813-.205 2.666-.615.853-.41 1.634-.889 2.344-1.436.709-.547 1.318-1.1 1.826-1.66.508-.56.885-.989 1.133-1.289a41.634 41.634 0 0 0-1.133-1.289c-.508-.56-1.113-1.113-1.816-1.66s-1.484-1.025-2.344-1.436-1.751-.615-2.676-.615c-.937 0-1.833.205-2.686.615zm.04 7.031c-.736-.735-1.104-1.617-1.104-2.646 0-1.028.368-1.91 1.104-2.646.735-.735 1.618-1.104 2.646-1.104 1.028 0 1.911.368 2.646 1.104.735.736 1.104 1.618 1.104 2.646 0 1.029-.368 1.911-1.104 2.646-.736.736-1.618 1.104-2.646 1.104-1.029 0-1.911-.367-2.646-1.104zm.878-4.414a2.41 2.41 0 0 0-.732 1.768c0 .69.244 1.279.732 1.768s1.077.732 1.768.732c.69 0 1.279-.244 1.768-.732s.732-1.077.732-1.768c0-.689-.244-1.279-.732-1.768s-1.078-.732-1.768-.732-1.279.244-1.768.732z"></path>
                        </svg>
                    </div>
                    <div class="note note--error" style="display: none;" id="login_incorreto_lateral">E-mail ou senha incorretos, por favor, tente novamente!</div>
                    <input type="button" class="btn btn--full btn--secondary mb-20" value="ENTRAR" onclick="Login('_lateral');">
                    <div class="mb-10">
                        <a href="<?=$url_loja;?>/login#recuperar" title="Esqueci minha senha" class="btn-link js-button-block-visibility" data-block-link="#recover" data-action="open" data-action-close-popup="account">Esqueci minha senha</a>
                    </div>
                </form>
                <hr class="my-15"/>
                <a href="<?=$url_loja;?>/cadastrar" title="CADASTRAR-SE!" class="btn btn--full btn--secondary mb-20">CADASTRAR-SE!</a>
            <?}?>
        </div>
    </div>
</div>
<script>
function Login(local){
    if (local!=''){
        var usuario = $('#usuario'+local).prop('value');
        var senha = $('#senha'+local).prop('value');
    }else{
        var usuario = $('#usuario').prop('value');
        var senha = $('#senha').prop('value');
    }
    $.ajax({
        type: 'POST',
        url: '<?=$url_loja;?>/login.php',
        data: {
            usuario: usuario,
            senha: senha
        },
        dataType: 'json',
        success: function (data) {
            if (data.login=='sucesso'){
                window.location.href=data.pagina;
            }else{
                $('#login_incorreto'+local).show();
                setTimeout(function() {
                   $('#login_incorreto'+local).fadeOut('medium');
                }, 4000);
            }
        }
    });
}
function Recuperar(local){
    var email = $('#recuperar_email').prop('value');
    $.ajax({
        type: 'POST',
        url: '<?=$url_loja;?>/recuperar.php',
        data: {
            email: email
        },
        dataType: 'json',
        success: function (data) {
            if (data.ok=='sucesso'){
                $('#recuperar_senha_'+local).addClass('note--success');
                $('#recuperar_senha_'+local).html('E-mail de recuperação enviado com sucesso!');
                $('#recuperar_senha_'+local).show();
                setTimeout(function() {
                   $('#recuperar_senha_'+local).fadeOut('medium');
                }, 4000);
            }else{
                $('#recuperar_senha_'+local).addClass('note--error');
                $('#recuperar_senha_'+local).html('E-mail inválido, tente novamente!');
                $('#recuperar_senha_'+local).show();
                setTimeout(function() {
                   $('#recuperar_senha_'+local).fadeOut('medium');
                }, 4000);
            }
        }
    });
}
function mostraSenha(id) {
  var x = id;
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>