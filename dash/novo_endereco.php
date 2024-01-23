<h2 class="h4 mt-20 mb-30 text-center">Novo Endereço de Entrega</h2>
<form method="post" action="" accept-charset="UTF-8">
    <div class="row">
        <div class="col-md-12 text-left">
            <label for="apelido" class="label-required">Apelido</label>
            <input type="text" name="apelido" id="apelidoC" placeholder="Insira um apelido para seu endereço" value="" required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 text-left">
            <label for="cep" class="label-required">CEP</label>
            <input type="text" class="cepC" name="cep" id="cepC" placeholder="Insira seu cep" value="" required>
        </div>
        <div class="col-md-9 text-left">
            <label for="endereco" class="label-required">Endereço</label>
            <input type="text" name="endereco" id="logradouroC" placeholder="Insira sua rua" value="" required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 text-left">
            <label for="numero" class="label-required">Número</label>
            <input type="text" name="numero" id="numeroC" placeholder="Insira seu numero" value="" required>
        </div>
        <div class="col-md-9 text-left">
            <label for="complemento">Complemento</label>
            <input type="text" name="complemento" id="complementoC" placeholder="Insira um complemento" value="">
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 text-left">
            <label for="bairro" class="label-required">Bairro</label>
            <input type="text" name="bairro" id="bairroC" placeholder="Insira seu bairro" value="" required>
        </div>
        <div class="col-md-4 text-left">
            <label for="cidade" class="label-required">Cidade</label>
            <input type="text" name="cidade" id="cidadeC" placeholder="Insira sua cidade" value="" required>
        </div>
        <div class="col-md-4 text-left">
            <label for="estado" class="label-required">Estado</label>
            <input type="text" name="estado" id="estadoC" placeholder="Insira seu estado" value="" required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-left">
            <label for="principal" class="label-required">Deseja tornar este endereço padrão?</label>
            <select id="principal" name="principal">
                <option value="nao">Não</option>
                <option value="sim">Sim</option>
            </select>
        </div>
    </div><br>
    <div class="text-center">
        <button type="submit" value="novo_endereco" name="novo_endereco" class="btn btn--full btn--secondary">CADASTRAR!</button>
    </div>
</form>