<?
$pedido = $_GET['pedido'];
$sql_pedidos = mysqli_query($conn, "SELECT pc.id_produto, pc.qtd, pc.por, pc.preco, pc.produto, pc.img, p.valor_pedido, p.valor_frete FROM pedidos AS p INNER JOIN produtos_comprado AS pc ON (p.id=pc.id_pedido) WHERE p.identificacao_pedido='".$pedido."'");
if (mysqli_num_rows($sql_pedidos)){
?>
<div class="row d-flex align-items-center m-0 py-20 mb-20" style="border: 1px solid #E5E5E5;">
    <div class="col-md-6">
        <h2 class="h4 mt-0 mb-0 text-left">Pedido Nº <?=$pedido;?></h2>
    </div>
    <div class="col-md-6 text-right">
        <h4 class="small-title mb-0">
            <a href="<?=$url_loja;?>/pedido/impressao/<?=$pedido;?>" title="Gerar PDF"><i class="fa fa-file-pdf" style="color: white; background-color: red; padding: 10px;border-radius: 100%;font-size: 15px;"></i></a>
            <a href="<?=$url_loja;?>/pedido/planilha/<?=$pedido;?>" target="_blank" rel="noopener" title="Gerar EXCEL"><i class="fa fa-file-excel" style="color: white; background-color: #25D366; padding: 10px;border-radius: 100%;font-size: 15px;"></i></a>
            <a href="<?=$url_loja;?>/pedido/impressao/<?=$pedido;?>" target="_blank" rel="noopener" title="Gerar Impressão"><i class="fa fa-print" style="color: white; background-color: #0076ad; padding: 10px;border-radius: 100%;font-size: 15px;"></i></a>
            <a href="<?=$link_whats;?>" target="_blank" rel="noopener" title="Atendimento"><i class="fa-brands fa-whatsapp" style="color: white; background-color: #25D366; padding: 10px;border-radius: 100%;font-size: 15px;"></i></a>
        </h4>
    </div>
</div>
<div class="table-wrap">
    <table class="responsive-table">
        <thead>
        <tr>
            <th>Imagem</th>
            <th>Produto</th>
            <th>Qtd</th>
            <th>Valor</th>
        </tr>
        </thead>
        <tbody>
            <?
            while ($dados=mysqli_fetch_assoc($sql_pedidos)){
                $id = $dados['id_produto'];
                $produto = $dados['produto'];
                $qtd = $dados['qtd'];
                $img = $dados['img'];
                $por = $dados['por'];
                $preco = $dados['preco'];
                $valor_pedido = $dados['valor_pedido'];
                $valor_frete = $dados['valor_frete'];
                
                if (!file_exists($img) || $img==''){
                    $img = $url_loja."/assets/img/produtos/sem_imagem.jpg";
                }else{
                    $img = $url_loja."/".$img;
                }
    
                if ($por<$preco AND $por>0) {
                    $preco_produto = 'R$ '.number_format($por, 2, ',', '.');
                }else{
                    if ($preco>0) {
                        $preco_produto = 'R$ '.number_format($preco, 2, ',', '.');
                    }else{
                        $preco_produto = 'Consulte-nos';
                    }
                }
                if ($valor_pedido>0) {
                    $valor_pedido = 'R$ '.number_format($valor_pedido, 2, ',', '.');
                }else{
                    $valor_pedido = 'Consulte-nos';
                }
                if ($valor_frete>0) {
                    $valor_frete = 'R$ '.number_format($valor_frete, 2, ',', '.');
                }else{
                    $valor_frete = '';
                }
            ?>
                <tr class="responsive-table-row">
                    <td data-label="Imagem"><img src="<?=$img;?>" alt="<?=$produto;?>" title="<?=$produto;?>" style="max-width: 150px; max-height: 150px;"></td>
                    <td data-label="Produto"><?=$produto;?></td>
                    <td data-label="Qtd"><?=$qtd;?></td>
                    <td data-label="Valor"><?=$preco_produto;?></td>
                </tr>
            <?}?>
        </tbody>
    </table>
    <?if (isset($valor_frete) AND $valor_frete!=''){?>
        <div class="col-md-12">
            <h3 class="h3 mt-20 mb-30 text-right">Valor do Frete: <?=$valor_frete;?></h2>
        </div>
    <?}?>
    <div class="col-md-12">
        <h3 class="h3 mt-20 mb-30 text-right">Valor do Pedido: <?=$valor_pedido;?></h2>
    </div>
</div>
<?}else{?>
    <h2 class="h4 mt-20 mb-30 text-center">Não há pedidos no momento!</h2>
    <p style="max-width: 350px; text-align: -webkit-center;"><a href="<?=$url_loja;?>/produtos" title="Vá as compras!" class="btn btn--secondary btn--full">Vá as compras!</a></p>
<?}
mysqli_free_result($sql_pedidos);
?>