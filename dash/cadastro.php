<?
$sql_cliente = mysqli_query($conn, "SELECT * FROM clientes WHERE id='".$_SESSION["usr_id_cliente"]."' AND status='a' LIMIT 1");

if(mysqli_num_rows($sql_cliente)>0) {
    $dados_cliente = mysqli_fetch_assoc($sql_cliente);
    
    $responsavel_nome = $dados_cliente['responsavel_nome'];
    $cpf = $dados_cliente['cpf_cnpj'];
    $email = $dados_cliente['email'];
    $celular = $dados_cliente['celular'];
    $cep = $dados_cliente['cep'];
    $endereco = $dados_cliente['endereco'];
    $numero = $dados_cliente['numero'];
    $bairro = $dados_cliente['bairro'];
    $cidade = $dados_cliente['cidade'];
    $estado = (($dados_cliente['estado']!='')?strtoupper($dados_cliente['estado']):'');
    $complemento = $dados_cliente['complemento'];
}
?>
<div class="row d-flex align-items-center m-0 py-20 mb-20" style="border: 1px solid #E5E5E5;">
    <div class="col-md-4">
        <div class="userprofile text-center">
            <div class="userpic">
                <img src="<?=$url_loja;?>/assets/img/clientes/<?=((file_exists('assets/img/clientes/'.$_SESSION["usr_foto_cliente"]) AND $_SESSION["usr_foto_cliente"]!='')?$_SESSION["usr_foto_cliente"]:'sem_imagem.jpg');?>" id="img_perfil" alt="<?=$_SESSION["usr_nome_cliente"];?>" title="<?=$_SESSION["usr_nome_cliente"];?>" class="userpicimg js-popup-button" data-js-popup-button="imagem_perfil" style="cursor: pointer;">
                <button type="button" class="btn btn-primary settingbtn js-popup-button" data-js-popup-button="imagem_perfil"><i class="fa fa-upload"></i></button>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <h2 class="h4 m-0 text-center">Atualize suas informações de Cadastro!</h2>
    </div>
    <div class="col-md-4 text-center">
        <a href="alterar_senha" title="ALTERAR SENHA" class="btn btn--secondary">ALTERAR SENHA</a>
    </div>
</div>
<form method="post" action="" accept-charset="UTF-8">
    <div class="row">
        <div class="col-md-9">
            <label for="nome" class="label-required">Nome Completo</label>
            <input type="text" name="nome" id="nome" placeholder="Insira seu nome completo" value="<?=$responsavel_nome;?>">
        </div>
        <div class="col-md-3">
            <label for="cpf" class="label-required">CPF</label>
            <input type="text" name="cpf" class="cpf" id="cpf" placeholder="Insira seu CPF" value="<?=$cpf;?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="email" class="label-required">E-mail</label>
            <input type="text" name="email" id="email" placeholder="Insira seu endereço de e-mail" value="<?=$email;?>">
        </div>
        <div class="col-md-6">
            <label for="celular" class="label-required">WhatsApp</label>
            <input type="text" name="celular" class="cel" id="celular" placeholder="Insira seu número de WhatsApp" value="<?=$celular;?>">
        </div>
    </div>    
    <div class="border-top border my-15"></div>
    <div class="row">
        <div class="col-md-3">
            <label for="cep" class="label-required">CEP</label>
            <input type="text" class="cep" name="cep" id="cep" placeholder="Insira seu cep" value="<?=$cep;?>">
        </div>
        <div class="col-md-9">
            <label for="endereco" class="label-required">Endereço</label>
            <input type="text" name="endereco" id="logradouro" placeholder="Insira sua rua" value="<?=$endereco;?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <label for="numero" class="label-required">Número</label>
            <input type="text" name="numero" id="numero" placeholder="Insira seu numero" value="<?=$numero;?>">
        </div>
        <div class="col-md-9">
            <label for="complemento">Complemento</label>
            <input type="text" name="complemento" id="complemento" placeholder="Insira um complemento" value="<?=$complemento;?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label for="bairro" class="label-required">Bairro</label>
            <input type="text" name="bairro" id="bairro" placeholder="Insira seu bairro" value="<?=$bairro;?>">
        </div>
        <div class="col-md-4">
            <label for="cidade" class="label-required">Cidade</label>
            <input type="text" name="cidade" id="cidade" placeholder="Insira sua cidade" value="<?=$cidade;?>">
        </div>
        <div class="col-md-4">
            <label for="estado" class="label-required">Estado</label>
            <input type="text" name="estado" id="estado" placeholder="Insira seu estado" value="<?=$estado;?>">
        </div>
    </div><br>
    <div class="text-center">
        <input type="button" value="ATUALIZAR!" onclick="Atualizar();" class="btn btn--full btn--secondary">
    </div>
    <div class="text-center">
        <div class="note note--error" style="margin-top: 15px;display: none;" id="cadastro_alerta"></div>
    </div>
</form>
<script>
$(document).ready(function() {
    var label = document.getElementsByClassName("imagem_perfil")[0];
    var input = document.getElementById("imagem_perfil");
    input.addEventListener("change", function(){
        var nome = "Não há arquivo selecionado. Selecionar arquivo...";
        if(input.files.length > 0) nome = input.files[0].name;
        $('#imagem_selecionada').html(nome);
        $('#imagem_selecionada').show();
        $('#imagem_perfil_salvar').show();
    });
});
function atualizaImagem(){
    var form = document.getElementById("atualizaImagem");
    var formData = new FormData(form);
    $.ajax({
        type: 'POST',
        url: '<?=$url_loja;?>/includes/atualiza_dados.php',
        data: formData,
        dataType: 'json',
        success: function (data) {
            if (data.ok=='sucesso'){
                $('#fechar_imagem_perfil').click();
                $('#img_perfil').attr('src', '<?=$url_loja;?>/'+data.img);
                $('#img_perfil_header').attr('src', '<?=$url_loja;?>/'+data.img);
                $('#alerta_imagem_perfil').html();
                $('#alerta_imagem_perfil').hide();
            }else{
                $('#alerta_imagem_perfil').html(data.mensagem);
                $('#alerta_imagem_perfil').show();
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
function Atualizar(){
    var flag = true;
    if ($('#nome').prop('value')==''){$('#nome').addClass('error'); flag = false;}
    if ($('#cpf').prop('value')==''){$('#cpf').addClass('error'); flag = false;}
    if ($('#email').prop('value')==''){$('#email').addClass('error'); flag = false;}
    if ($('#celular').prop('value')==''){$('#celular').addClass('error'); flag = false;}
    if ($('#cep').prop('value')==''){$('#cep').addClass('error'); flag = false;}
    if ($('#logradouro').prop('value')==''){$('#logradouro').addClass('error'); flag = false;}
    if ($('#numero').prop('value')==''){$('#numero').addClass('error'); flag = false;}
    if ($('#bairro').prop('value')==''){$('#bairro').addClass('error'); flag = false;}
    if ($('#cidade').prop('value')==''){$('#cidade').addClass('error'); flag = false;}
    if ($('#estado').prop('value')==''){$('#estado').addClass('error'); flag = false;}
    if (flag==true){
        $.ajax({
            type: 'POST',
            url: 'includes/atualiza_dados.php',
            data: {
                atualiza_cadastro: 'atualiza_cadastro',
                nome: $('#nome').prop('value'),
                cpf: $('#cpf').prop('value'),
                email: $('#email').prop('value'),
                celular: $('#celular').prop('value'),
                cep: $('#cep').prop('value'),
                endereco: $('#logradouro').prop('value'),
                numero: $('#numero').prop('value'),
                bairro: $('#bairro').prop('value'),
                cidade: $('#cidade').prop('value'),
                estado: $('#estado').prop('value'),
                complemento: $('#complemento').prop('value')
            },
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
                       window.location.href='meu_cadastro';
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
            }
        });
    }
}
</script>