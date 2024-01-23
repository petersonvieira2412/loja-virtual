<?
$sql_endereco = mysqli_query($conn, "SELECT * FROM enderecos_entrega WHERE id='".$_GET['id']."' AND id_cliente='".$_SESSION["usr_id_cliente"]."' LIMIT 1");

if(mysqli_num_rows($sql_endereco)>0) {
    $dados_endereco = mysqli_fetch_assoc($sql_endereco);
    
    $apelido = $dados_endereco['apelido'];
    $cep = $dados_endereco['cep'];
    $endereco = $dados_endereco['endereco'];
    $numero = $dados_endereco['numero'];
    $bairro = $dados_endereco['bairro'];
    $cidade = $dados_endereco['cidade'];
    $estado = strtoupper($dados_endereco['estado']);
    $complemento = $dados_endereco['complemento'];
}
?>
<h2 class="h4 mt-20 mb-30 text-center">Editar Endereço de Entrega</h2>
<form method="post" action="" accept-charset="UTF-8" id="editar_endereco">
    <div class="row">
        <div class="col-md-12 text-left">
            <label for="apelido" class="label-required">Apelido</label>
            <input type="text" name="apelido" id="apelido" placeholder="Insira um apelido para seu endereço" value="<?=$apelido;?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 text-left">
            <label for="cep" class="label-required">CEP</label>
            <input type="text" class="cep" name="cep" id="cep" placeholder="Insira seu cep" value="<?=$cep;?>">
        </div>
        <div class="col-md-9 text-left">
            <label for="endereco" class="label-required">Endereço</label>
            <input type="text" name="endereco" id="logradouro" placeholder="Insira sua rua" value="<?=$endereco;?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 text-left">
            <label for="numero" class="label-required">Número</label>
            <input type="text" name="numero" id="numero" placeholder="Insira seu numero" value="<?=$numero;?>">
        </div>
        <div class="col-md-9 text-left">
            <label for="complemento">Complemento</label>
            <input type="text" name="complemento" id="complemento" placeholder="Insira um complemento" value="<?=$complemento;?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 text-left">
            <label for="bairro" class="label-required">Bairro</label>
            <input type="text" name="bairro" id="bairro" placeholder="Insira seu bairro" value="<?=$bairro;?>">
        </div>
        <div class="col-md-4 text-left">
            <label for="cidade" class="label-required">Cidade</label>
            <input type="text" name="cidade" id="cidade" placeholder="Insira sua cidade" value="<?=$cidade;?>">
        </div>
        <div class="col-md-4 text-left">
            <label for="estado" class="label-required">Estado</label>
            <input type="text" name="estado" id="estado" placeholder="Insira seu estado" value="<?=$estado;?>">
        </div>
    </div><br>
    <div class="text-center">
        <button type="button" value="editar_endereco" name="editar_endereco" onclick="atualizaDados('editar');" class="btn btn--full btn--secondary">EDITAR!</button>
        <div class="note note--error" style="display: none;" id="editar_alerta"></div>
    </div>
</form>