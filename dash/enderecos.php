<?
$sql_enderecos = mysqli_query($conn, "SELECT id, endereco, apelido, cep FROM enderecos_entrega WHERE id_cliente='".$_SESSION["usr_id_cliente"]."' AND principal='sim' AND status='a' ORDER BY id DESC");
if (mysqli_num_rows($sql_enderecos)){
?>
    <div class="row d-flex align-items-center m-0 py-20 mb-20" style="border: 1px solid #E5E5E5;">
        <div class="col-md-12">
            <h2 class="h4 mt-0 mb-0 text-center">
                Endereço de Entrega Padrão 
                <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-221" viewBox="0 0 24 24">
                    <path d="M11.123 9.964l2.012-5.762 1.855 5.82 6.074.117-4.941 3.535 1.758 5.84-4.922-3.594-4.961 3.437 1.914-5.762-4.844-3.671 6.055.04z"></path>
                </svg>
            </h2>
        </div>
        <div class="col-md-12">
            <div class="table-wrap mt-20">
                <table class="responsive-table">
                    <thead>
                    <tr>
                        <th>Apelido</th>
                        <th>Endereço</th>
                        <th>CEP</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?
                    while ($dados=mysqli_fetch_assoc($sql_enderecos)){
                        $id_endereco = $dados['id'];
                        $apelido = $dados['apelido'];
                        $endereco = $dados['endereco'];
                        $cep = $dados['cep'];
                    ?>
                        <tr class="responsive-table-row">
                            <td data-label="Apelido"><?=$apelido;?></td>
                            <td data-label="Endereço"><?=$endereco;?></td>
                            <td data-label="CEP"><?=$cep;?></td>
                            <td data-label="Ações">
                                <a href="<?=$url_loja;?>/endereco/<?=$id_endereco;?>" title="Editar Endereço">
                                    <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-080" viewBox="0 0 24 24">
                                        <path d="M2.874 21.283a.614.614 0 0 1-.234-.049.93.93 0 0 1-.215-.127.822.822 0 0 1-.146-.254.572.572 0 0 1-.029-.273l.625-5c0-.013.003-.029.01-.049s.017-.036.029-.049c0-.013.003-.026.01-.039s.01-.026.01-.039a.499.499 0 0 1 .117-.195l12.5-12.5A.652.652 0 0 1 16 2.533c.169 0 .319.059.449.176l4.375 4.375c.117.13.176.28.176.449s-.059.319-.176.449l-12.5 12.5a.553.553 0 0 1-.195.117c-.013.013-.026.02-.039.02h-.039a.125.125 0 0 1-.049.029.151.151 0 0 1-.049.01l-5 .625h-.079zm1.094-4.277l-.371 2.93 2.93-.371-2.559-2.559zm.41-1.348l1.309 1.309 9.121-9.121-1.309-1.309-9.121 9.121zm3.496 3.496l9.121-9.121-1.309-1.309-9.121 9.121 1.309 1.309zm6.504-13.496l3.496 3.496 1.621-1.621-3.496-3.496-1.621 1.621z"></path>
                                    </svg>
                                </a>
                                <form action="" method="POST" style="display: inline-block;">
                                    <input type="hidden" value="<?=$id_endereco;?>" name="id">
                                    <button type="submit" title="Excluir Endereço" value="excluir_endereco" name="excluir_endereco" onmouseenter="$(this).css('cursor', 'pointer')" style="background-color: #fff; padding:0; border:0;">
                                        <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-165" viewBox="0 0 24 24">
                                            <path d="M4.741 21.654a.601.601 0 0 1-.186-.439v-15h-1.25a.598.598 0 0 1-.439-.186.597.597 0 0 1-.186-.439.6.6 0 0 1 .186-.439.604.604 0 0 1 .439-.186h5v-2.5a.6.6 0 0 1 .186-.439.598.598 0 0 1 .439-.186h6.25c.169 0 .315.063.439.186a.601.601 0 0 1 .186.439v2.5h5c.169 0 .315.063.439.186a.601.601 0 0 1 .186.439c0 .17-.062.316-.186.439a.601.601 0 0 1-.439.186h-1.25v15a.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186H5.18a.598.598 0 0 1-.439-.186zM18.305 6.215h-12.5V20.59h12.5V6.215zM9.37 9.525a.601.601 0 0 1 .186.439v6.875c0 .17-.062.316-.186.439a.601.601 0 0 1-.439.186.598.598 0 0 1-.439-.186.598.598 0 0 1-.186-.439V9.965a.6.6 0 0 1 .186-.439.594.594 0 0 1 .438-.186c.169 0 .316.062.44.185zm.185-4.56h5V3.09h-5v1.875zm2.94 4.56a.601.601 0 0 1 .186.439v6.875c0 .17-.062.316-.186.439a.601.601 0 0 1-.439.186.598.598 0 0 1-.439-.186.598.598 0 0 1-.186-.439V9.965a.6.6 0 0 1 .186-.439.604.604 0 0 1 .439-.186c.168 0 .315.062.439.185zm2.246 0a.604.604 0 0 1 .439-.186c.169 0 .315.063.439.186a.601.601 0 0 1 .186.439v6.875c0 .17-.062.316-.186.439a.601.601 0 0 1-.439.186.598.598 0 0 1-.439-.186.598.598 0 0 1-.186-.439V9.965c0-.169.062-.316.186-.44z"></path>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?}?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?}else{?>
    <div class="row d-flex align-items-center m-0 py-20 mb-20" style="border: 1px solid #E5E5E5;">
        <div class="col-md-12">
            <h2 class="h4 mt-0 mb-0 text-center">
                Endereço de Entrega Padrão 
                <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-221" viewBox="0 0 24 24">
                    <path d="M11.123 9.964l2.012-5.762 1.855 5.82 6.074.117-4.941 3.535 1.758 5.84-4.922-3.594-4.961 3.437 1.914-5.762-4.844-3.671 6.055.04z"></path>
                </svg>
            </h2>
        </div>
        <div class="col-md-12">
            <div class="table-wrap mt-20">
                <table class="responsive-table">
                    <thead>
                    <tr>
                        <th>Apelido</th>
                        <th>Endereço</th>
                        <th>CEP</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr class="responsive-table-row">
                            <td data-label="Apelido">Endereço de Cadastro</td>
                            <td data-label="Endereço"><?=$endereco;?></td>
                            <td data-label="CEP"><?=$cep;?></td>
                            <td data-label="Ações">
                                <a href="<?=$url_loja;?>/cadastro" title="Editar Endereço">
                                    <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-080" viewBox="0 0 24 24">
                                        <path d="M2.874 21.283a.614.614 0 0 1-.234-.049.93.93 0 0 1-.215-.127.822.822 0 0 1-.146-.254.572.572 0 0 1-.029-.273l.625-5c0-.013.003-.029.01-.049s.017-.036.029-.049c0-.013.003-.026.01-.039s.01-.026.01-.039a.499.499 0 0 1 .117-.195l12.5-12.5A.652.652 0 0 1 16 2.533c.169 0 .319.059.449.176l4.375 4.375c.117.13.176.28.176.449s-.059.319-.176.449l-12.5 12.5a.553.553 0 0 1-.195.117c-.013.013-.026.02-.039.02h-.039a.125.125 0 0 1-.049.029.151.151 0 0 1-.049.01l-5 .625h-.079zm1.094-4.277l-.371 2.93 2.93-.371-2.559-2.559zm.41-1.348l1.309 1.309 9.121-9.121-1.309-1.309-9.121 9.121zm3.496 3.496l9.121-9.121-1.309-1.309-9.121 9.121 1.309 1.309zm6.504-13.496l3.496 3.496 1.621-1.621-3.496-3.496-1.621 1.621z"></path>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?}mysqli_free_result($sql_enderecos);?>
<?
$sql_enderecos = mysqli_query($conn, "SELECT id, endereco, apelido, cep FROM enderecos_entrega WHERE id_cliente='".$_SESSION["usr_id_cliente"]."' AND principal='nao' AND status='a' ORDER BY id DESC");
if (mysqli_num_rows($sql_enderecos)){
?>
    <hr class="my-30">
    <div class="row d-flex align-items-center m-0 py-20 mb-20" style="border: 1px solid #E5E5E5;">
        <div class="col-md-12">
            <h2 class="h4 mt-0 mb-0 text-center">
                Outros Endereços de Entrega
            </h2>
        </div>
        <div class="col-md-12">
            <div class="table-wrap mt-20">
                <table class="responsive-table">
                    <thead>
                    <tr>
                        <th>Apelido</th>
                        <th>Endereço</th>
                        <th>CEP</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?
                    while ($dados=mysqli_fetch_assoc($sql_enderecos)){
                        $id_endereco = $dados['id'];
                        $apelido = $dados['apelido'];
                        $endereco = $dados['endereco'];
                        $cep = $dados['cep'];
                    ?>
                        <tr class="responsive-table-row">
                            <td data-label="Apelido"><?=$apelido;?></td>
                            <td data-label="Endereço"><?=$endereco;?></td>
                            <td data-label="CEP"><?=$cep;?></td>
                            <td data-label="Ações">
                                <a href="<?=$url_loja;?>/enderecos" class="js-popup-button" data-js-popup-button="tornar_principal" title="Tornar Principal" onclick="tornarPrincipal('<?=$id_endereco;?>');">
                                    <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-223" viewBox="0 0 24 24">
                                        <path d="M12.806 4.026l1.875 5.82 6.055.137-4.941 3.516 1.758 5.859-4.902-3.594-4.961 3.437 1.895-5.762-4.846-3.69 6.074.039 1.993-5.762zm-.039 3.789l-.82 2.363-.293.82-3.32-.02 2.656 2.012-1.035 3.184 2.715-1.895 2.715 1.992-.977-3.242 2.695-1.934-3.301-.059-1.035-3.221z"></path>
                                    </svg>
                                </button>
                                <a href="<?=$url_loja;?>/endereco/<?=$id_endereco;?>" title="Editar Endereço">
                                    <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-080" viewBox="0 0 24 24">
                                        <path d="M2.874 21.283a.614.614 0 0 1-.234-.049.93.93 0 0 1-.215-.127.822.822 0 0 1-.146-.254.572.572 0 0 1-.029-.273l.625-5c0-.013.003-.029.01-.049s.017-.036.029-.049c0-.013.003-.026.01-.039s.01-.026.01-.039a.499.499 0 0 1 .117-.195l12.5-12.5A.652.652 0 0 1 16 2.533c.169 0 .319.059.449.176l4.375 4.375c.117.13.176.28.176.449s-.059.319-.176.449l-12.5 12.5a.553.553 0 0 1-.195.117c-.013.013-.026.02-.039.02h-.039a.125.125 0 0 1-.049.029.151.151 0 0 1-.049.01l-5 .625h-.079zm1.094-4.277l-.371 2.93 2.93-.371-2.559-2.559zm.41-1.348l1.309 1.309 9.121-9.121-1.309-1.309-9.121 9.121zm3.496 3.496l9.121-9.121-1.309-1.309-9.121 9.121 1.309 1.309zm6.504-13.496l3.496 3.496 1.621-1.621-3.496-3.496-1.621 1.621z"></path>
                                    </svg>
                                </a>
                                <form action="" method="POST" style="display: inline-block;">
                                    <input type="hidden" value="<?=$id_endereco;?>" name="id">
                                    <button type="submit" title="Excluir Endereço" value="excluir_endereco" name="excluir_endereco" onmouseenter="$(this).css('cursor', 'pointer')" style="background-color: #fff; padding:0; border:0;">
                                        <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-165" viewBox="0 0 24 24">
                                            <path d="M4.741 21.654a.601.601 0 0 1-.186-.439v-15h-1.25a.598.598 0 0 1-.439-.186.597.597 0 0 1-.186-.439.6.6 0 0 1 .186-.439.604.604 0 0 1 .439-.186h5v-2.5a.6.6 0 0 1 .186-.439.598.598 0 0 1 .439-.186h6.25c.169 0 .315.063.439.186a.601.601 0 0 1 .186.439v2.5h5c.169 0 .315.063.439.186a.601.601 0 0 1 .186.439c0 .17-.062.316-.186.439a.601.601 0 0 1-.439.186h-1.25v15a.6.6 0 0 1-.186.439.601.601 0 0 1-.439.186H5.18a.598.598 0 0 1-.439-.186zM18.305 6.215h-12.5V20.59h12.5V6.215zM9.37 9.525a.601.601 0 0 1 .186.439v6.875c0 .17-.062.316-.186.439a.601.601 0 0 1-.439.186.598.598 0 0 1-.439-.186.598.598 0 0 1-.186-.439V9.965a.6.6 0 0 1 .186-.439.594.594 0 0 1 .438-.186c.169 0 .316.062.44.185zm.185-4.56h5V3.09h-5v1.875zm2.94 4.56a.601.601 0 0 1 .186.439v6.875c0 .17-.062.316-.186.439a.601.601 0 0 1-.439.186.598.598 0 0 1-.439-.186.598.598 0 0 1-.186-.439V9.965a.6.6 0 0 1 .186-.439.604.604 0 0 1 .439-.186c.168 0 .315.062.439.185zm2.246 0a.604.604 0 0 1 .439-.186c.169 0 .315.063.439.186a.601.601 0 0 1 .186.439v6.875c0 .17-.062.316-.186.439a.601.601 0 0 1-.439.186.598.598 0 0 1-.439-.186.598.598 0 0 1-.186-.439V9.965c0-.169.062-.316.186-.44z"></path>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?}?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12 text-center">
            <p style="max-width: 350px; text-align: -webkit-center;"><a href="<?=$url_loja;?>/novo_endereco" title="Novo Endereço" class="btn btn--secondary btn--full">Cadastrar novo endereço</a></p>
        </div>
    </div>
<?}else{?>
    <h2 class="h4 mt-20 mb-30 text-center">Não há endereços de entrega cadastrados!</h2>
    <p style="max-width: 350px; text-align: -webkit-center;"><a href="<?=$url_loja;?>/novo_endereco" title="Novo Endereço" class="btn btn--secondary btn--full">Cadastre já</a></p>
<?}mysqli_free_result($sql_enderecos);?>
<script>
    function tornarPrincipal(id){
        $('#id_endereco').prop('value', id);
    }
</script>