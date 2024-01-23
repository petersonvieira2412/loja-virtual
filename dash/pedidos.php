<?
$sql_pedidos = mysqli_query($conn, "SELECT * FROM pedidos WHERE id_cliente='".$_SESSION["usr_id_cliente"]."' ORDER BY id DESC");
if (mysqli_num_rows($sql_pedidos)){
?>
<div class="table-wrap">
    <table class="responsive-table">
        <thead>
        <tr>
            <th>Pedido</th>
            <th>Data</th>
            <th>Valor</th>
            <th>Situação</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
            <?
            while ($dados=mysqli_fetch_assoc($sql_pedidos)){
                $id = $dados['id'];
                $identificacao_pedido = $dados['identificacao_pedido'];
                $data = $dados['data'];
                $valor_pedido = $dados['valor_pedido'];
                $valor_frete = $dados['valor_frete'];
                $preco = $valor_pedido + $valor_frete;
                $preco = 'R$ '.number_format($preco, 2, ',', '.');
                
                $situacao = $dados['situacao'];
    
                if ($preco=='' || $preco=='0.00') {
                    $preco = 'Consulte-nos';
                }
                
                if ($situacao=='ag') {
                    $exibir_situacao = 'Aguardando Pagamento';
                }
                elseif ($situacao=='ap') {
                    $exibir_situacao = 'Pagamento Aprovado';
                }
                elseif ($situacao=='cn') {
                    $exibir_situacao = 'Pagamento Cancelado';
                }
                elseif ($situacao=='sp') {
                    $exibir_situacao = 'Em separação';
                }
                elseif ($situacao=='tr') {
                    $exibir_situacao = 'Em transporte';
                }
                elseif ($situacao=='en') {
                    $exibir_situacao = 'Pedido Entregue';
                }
            ?>
                <tr class="responsive-table-row">
                    <td data-label="Pedido"><?=$identificacao_pedido;?></td>
                    <td data-label="Data"><?=$data;?></td>
                    <td data-label="Valor"><?=$preco;?></td>
                    <td data-label="Situação"><?=$exibir_situacao;?></td>
                    <td data-label="Ações">
                        <a href="<?=$url_loja;?>/pedido/<?=$identificacao_pedido;?>" title="Ver Detalhes" class="btn btn--secondary">Ver Detalhes</a>
                    </td>
                </tr>
            <?}?>
        </tbody>
    </table>
</div>
<?}else{?>
    <h2 class="h4 mt-20 mb-30 text-center">Não há pedidos no momento!</h2>
    <p style="max-width: 350px; text-align: -webkit-center;"><a href="<?=$url_loja;?>/produtos" title="Vá as compras!" class="btn btn--secondary btn--full">Vá as compras!</a></p>
<?}
mysqli_free_result($sql_pedidos);
?>