<script src="<?=$url_loja;?>/assets/scripts/bootstrap.bundle.5.2.3.min.js"></script>
<style>
    @media (max-width: 778px){
        .icone-olho-mobile{
            right: 4% !important;   
        }
    }
</style>
<h2 class="h4 mt-20 mb-30 text-center">Alteração Senha</h2>
<form method="post" action="" accept-charset="UTF-8">
    <div class="row">
        <div class="col-md-12 text-left">
            <label for="senha_atual" class="label-required">Confirme a senha atual</label>
            <input type="password" name="senha_atual" id="senha_atual" placeholder="Confirme a senha atual">
            <svg aria-hidden="true" onclick="mostraSenha(senha_atual);" focusable="false" role="presentation" class="icon icon-theme-154 icone-olho-mobile" viewBox="0 0 24 24" style="border: none; background: transparent; position: absolute; top: 40%; right: 2%;">
                <path d="M8.528 17.238c-1.107-.592-2.074-1.25-2.9-1.973-.827-.723-1.491-1.393-1.992-2.012-.501-.618-.771-.96-.811-1.025a.571.571 0 0 1-.117-.352c0-.13.039-.247.117-.352.039-.064.306-.406.801-1.025.495-.618 1.159-1.289 1.992-2.012.833-.723 1.803-1.38 2.91-1.973a7.424 7.424 0 0 1 3.555-.889c1.263 0 2.448.297 3.555.889 1.106.593 2.073 1.25 2.9 1.973.827.723 1.491 1.394 1.992 2.012.501.619.771.961.811 1.025a.573.573 0 0 1 .117.352.656.656 0 0 1-.117.371c-.039.053-.31.391-.811 1.016-.501.625-1.169 1.296-2.002 2.012-.833.717-1.804 1.371-2.91 1.963a7.375 7.375 0 0 1-3.535.889 7.415 7.415 0 0 1-3.555-.889zm.869-9.746c-.853.41-1.631.889-2.334 1.436s-1.312 1.101-1.826 1.66c-.515.561-.889.99-1.123 1.289.234.3.608.729 1.123 1.289.514.561 1.123 1.113 1.826 1.66s1.484 1.025 2.344 1.436 1.751.615 2.676.615c.924 0 1.813-.205 2.666-.615.853-.41 1.634-.889 2.344-1.436.709-.547 1.318-1.1 1.826-1.66.508-.56.885-.989 1.133-1.289a41.634 41.634 0 0 0-1.133-1.289c-.508-.56-1.113-1.113-1.816-1.66s-1.484-1.025-2.344-1.436-1.751-.615-2.676-.615c-.937 0-1.833.205-2.686.615zm.04 7.031c-.736-.735-1.104-1.617-1.104-2.646 0-1.028.368-1.91 1.104-2.646.735-.735 1.618-1.104 2.646-1.104 1.028 0 1.911.368 2.646 1.104.735.736 1.104 1.618 1.104 2.646 0 1.029-.368 1.911-1.104 2.646-.736.736-1.618 1.104-2.646 1.104-1.029 0-1.911-.367-2.646-1.104zm.878-4.414a2.41 2.41 0 0 0-.732 1.768c0 .69.244 1.279.732 1.768s1.077.732 1.768.732c.69 0 1.279-.244 1.768-.732s.732-1.077.732-1.768c0-.689-.244-1.279-.732-1.768s-1.078-.732-1.768-.732-1.279.244-1.768.732z"></path>
            </svg>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 text-left mb-10">
            <label for="senha" class="label-required" id="senha_label">Senha</label>
            <label class="label" style="float:right; padding: 0; margin: 0; height: 17px;"><a href="#" title="Gerar Senha" onclick="gerarSenha();" class="btn-link js-button-block-visibility" tabindex="-1">Gerar Senha</a></label>
            <input type="password" name="nova_senha" id="senha" placeholder="Crie uma senha de acesso" required="required" style="margin-bottom: 5px;" onkeyup="verificaForcaSenha();" maxlength="255" minlength="6">
            <svg aria-hidden="true" onclick="mostraSenha(senha);" focusable="false" role="presentation" class="icon icon-theme-154" viewBox="0 0 24 24" style="border: none; background: transparent; position: absolute; top: 36%; right: 4%;">
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
                    <button type="button" class="button-info btn-shine" data-bs-toggle="popover" data-bs-trigger="hover focus" style="padding: 0 8px;" title="<b style='color: #3e3e3e;'>Dicas para uma senha forte</b>" data-bs-content="• Combine letras maiúsculas e minúsculas, números e caracteres especiais.<br><br>• Não use informações pessoais, como data de nascimento ou CPF.">!</button>
                </div>
            </div>
        </div>
        <div class="col-md-6 text-left">
            <label for="confirma_senha" class="label-required">Confirme a Nova Senha</label>
            <input type="password" class="senha" name="confirma_senha" id="confirma_senha" placeholder="Confirme a nova senha">
            <svg aria-hidden="true" onclick="mostraSenha(confirma_senha);" focusable="false" role="presentation" class="icon icon-theme-154" viewBox="0 0 24 24" style="border: none; background: transparent; position: absolute; top: 33%; right: 4%;">
                <path d="M8.528 17.238c-1.107-.592-2.074-1.25-2.9-1.973-.827-.723-1.491-1.393-1.992-2.012-.501-.618-.771-.96-.811-1.025a.571.571 0 0 1-.117-.352c0-.13.039-.247.117-.352.039-.064.306-.406.801-1.025.495-.618 1.159-1.289 1.992-2.012.833-.723 1.803-1.38 2.91-1.973a7.424 7.424 0 0 1 3.555-.889c1.263 0 2.448.297 3.555.889 1.106.593 2.073 1.25 2.9 1.973.827.723 1.491 1.394 1.992 2.012.501.619.771.961.811 1.025a.573.573 0 0 1 .117.352.656.656 0 0 1-.117.371c-.039.053-.31.391-.811 1.016-.501.625-1.169 1.296-2.002 2.012-.833.717-1.804 1.371-2.91 1.963a7.375 7.375 0 0 1-3.535.889 7.415 7.415 0 0 1-3.555-.889zm.869-9.746c-.853.41-1.631.889-2.334 1.436s-1.312 1.101-1.826 1.66c-.515.561-.889.99-1.123 1.289.234.3.608.729 1.123 1.289.514.561 1.123 1.113 1.826 1.66s1.484 1.025 2.344 1.436 1.751.615 2.676.615c.924 0 1.813-.205 2.666-.615.853-.41 1.634-.889 2.344-1.436.709-.547 1.318-1.1 1.826-1.66.508-.56.885-.989 1.133-1.289a41.634 41.634 0 0 0-1.133-1.289c-.508-.56-1.113-1.113-1.816-1.66s-1.484-1.025-2.344-1.436-1.751-.615-2.676-.615c-.937 0-1.833.205-2.686.615zm.04 7.031c-.736-.735-1.104-1.617-1.104-2.646 0-1.028.368-1.91 1.104-2.646.735-.735 1.618-1.104 2.646-1.104 1.028 0 1.911.368 2.646 1.104.735.736 1.104 1.618 1.104 2.646 0 1.029-.368 1.911-1.104 2.646-.736.736-1.618 1.104-2.646 1.104-1.029 0-1.911-.367-2.646-1.104zm.878-4.414a2.41 2.41 0 0 0-.732 1.768c0 .69.244 1.279.732 1.768s1.077.732 1.768.732c.69 0 1.279-.244 1.768-.732s.732-1.077.732-1.768c0-.689-.244-1.279-.732-1.768s-1.078-.732-1.768-.732-1.279.244-1.768.732z"></path>
            </svg>
        </div>
    </div>
    <br>
    <div class="text-center">
        <button type="submit" value="alterar_senha" name="alterar_senha" class="btn btn--full btn--secondary">ALTERAR!</button>
    </div>
    <?if (isset($alert) AND $alert!=''){echo $alert;}?>
</form>
<script>
$(document).ready(function() {
    $("[data-toggle=popover]").popover();
    $(".button-info").popover({
        html : true
    });
    $('.button-info').html('!');
});
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
	}else {
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
</script>