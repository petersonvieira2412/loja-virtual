<?
require_once("../includes/config.php");
if (!isset($_GET['acao'])){
    $_GET['acao'] = '';
}
if ($_GET['acao']=='impressao' || $_GET['acao']=='pdf'){
?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>PEDIDO: <?=$_GET["pedido"];?></title>
    	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    	<style>
            #page-wrapper {
    	        margin: 0;
    	    }
    	    .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th{
    	        border: 1px solid #000000 !important;
    	    }
    	    th, td{
    	        font-size: 15px !important;
    	    }
    	</style>
    </head>
    <body>
    
    	<section style="width: 100%;">
    	    <div class='container' style='margin-top: 1em; width: 100%; max-width: none;' width='100%'>
    	        <div class='row' style='display: flex; justify-content: space-between;'>
        	        <div style='text-align: -webkit-center; width: 100%'>
            	        <center><img src="<?=$url_loja;?>/assets/img/logo/logo.webp" alt="<?=$nome_loja;?>" title="<?=$nome_loja;?>" width="250px"></center>
            	    </div>
        	    </div><br><br>
        	    <div class='row'>
            	    <div class='col-md-12'>
                         <?
                          $classe="even ";
                          $sql = "SELECT pr.id, pr.id_pedido, pr.preco, pr.preco, pr.qtd, pr.img, pr.produto, pe.data, pe.valor_pedido, pe.identificacao_pedido, pe.cep, pe.endereco, pe.numero, pe.bairro, pe.cidade, pe.estado FROM pedidos AS pe INNER JOIN produtos_comprado AS pr ON (pe.id=pr.id_pedido) WHERE pe.identificacao_pedido='".$_GET["pedido"]."' AND pe.id_cliente = '".$_SESSION["usr_id_cliente"]."' ORDER BY pe.id DESC LIMIT 1";
                          $query = mysqli_query($conn, $sql);
                          $contador=1;
                          while ($dados = mysqli_fetch_assoc($query)) {
                            $data = $dados['data'];
                            $cep = $dados['cep'];
                            $endereco = $dados['endereco'];
                            $numero = $dados['numero'];
                            $bairro = $dados['bairro'];
                            $cidade = $dados['cidade'];
                            $estado = $dados['estado'];
                            $estado = mb_strtoupper($estado);
                            $nome_produto = $dados['produto'];
                            $controle = $dados['identificacao_pedido'];
                            $preco = $dados['preco'];
                            $preco_uni ='R$ '.number_format($preco,2,',','.');
                            
                            if ($classe=="odd") { $classe="even "; } else {$classe="odd";}
                        ?>
                        <h6>Nº PEDIDO: <span style="color: #000000a3;"><?=$_GET["pedido"];?></span></h6>
                        <h6>DATA: <span style="color: #000000a3;"><?=$data;?></span></h6>
                        <h6>ENDEREÇO: <span  style="color: #000000a3;"><?=$endereco;?>, <?=$numero;?> - <?=$bairro;?> - <?=$cidade;?>/<?=$estado;?></span></h6>
                        <?}?>
                    </div>
                </div>
            </div><br>
    	<br>
    	    <div width="100%" class="container" style="width: 100%; max-width: none;">
                <div class="row">
                    <table class="table table-bordered table-hover" id="dataTables-userlist" style="margin-bottom: 50px;">
                        <thead>
                            <tr>
                            <th style="margin-left: 25px;">IMAGEM</th>
                            <th>PRODUTO</th>
                            <th>PREÇO</th>
                            <th>QTD</th>
                            <th>TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?
                          $classe="even ";
                          $sql = "SELECT pr.id, pr.id_pedido, pr.preco, pr.preco, pr.qtd, pr.img, pr.produto, pe.data, pe.valor_pedido, pe.situacao, pe.identificacao_pedido, pe.cupom_aplicado FROM pedidos AS pe INNER JOIN produtos_comprado AS pr ON (pe.id=pr.id_pedido) WHERE pe.identificacao_pedido='".$_GET["pedido"]."' AND pe.id_cliente = '".$_SESSION["usr_id_cliente"]."' ORDER BY pe.id DESC";
                          $query = mysqli_query($conn, $sql);
                          $contador=1;
                          $qtd_total = 0;
                          while ($dados = mysqli_fetch_assoc($query)) {
                            $data = $dados['data'];
                            $nome_produto = $dados['produto'];
                            $controle = $dados['identificacao_pedido'];
                            $preco = $dados['preco'];
                            $preco_uni ='R$ '.number_format($preco,2,',','.');
                            
                            // Preço Total 
                            if ($preco=='0.00') {
                            $exibe_preco = 'CONSULTE-NOS';
                            }
                            else{
                              $exibe_preco ='R$ '.number_format($preco,2,',','.');
                            }
                            $valor_total = $dados['valor_pedido'];
                            if ($valor_total=='0.00') {
                            $exibe_total = 'CONSULTE-NOS';
                            }
                            else{
                              $exibe_total = 'R$ '.number_format($valor_total,2,',','.');
                            }
                            
                            // Preço Unitário
                            if ($preco=='0.00') {
                            $preco_uni = 'CONSULTE-NOS';
                            }
                            else{
                              $preco_uni ='R$ '.number_format($preco,2,',','.');
                            }
                            $valor_total = $dados['valor_pedido'];
                            if ($valor_total=='0.00') {
                            $exibe_uni = 'CONSULTE-NOS';
                            }
                            else{
                              $exibe_uni = 'R$ '.number_format($valor_total,2,',','.');
                            }
                            
                            $situacao = $dados['situacao'];
                            $quantidade = $dados['qtd'];
                            $qtd_total += $quantidade;
                            $nome_produto = $dados['produto'];
                            $nome_produto = ucwords($nome_produto);
                            $imagem_produto = $dados['img'];
                            
                            if ($classe=="odd") { $classe="even "; } else {$classe="odd";}
                        ?>
                            <tr class="<?=$classe;?>">
                                <td><img src="<?=$url_loja;?>/<?=$imagem_produto;?>" class="img" style="margin-left: 25px;max-width:80px; max-height:65px;"></td>
                                <td style="font-size: 15px; padding-top: 35px;padding-left: 30px;"><?=$nome_produto;?></td>
                                <td style="font-size: 15px; padding-top: 35px;padding-left: 30px;"><?=$exibe_preco;?></td>
                                <td style="font-size: 15px; padding-top: 35px;padding-left: 30px;"><?=$quantidade;?></td>
                                <td style="font-size: 15px; padding-top: 35px;padding-left: 30px;"><?=$exibe_uni;?></td
                            </tr>
                        <?
                        $contador++;
                        }mysqli_free_result($query);
                        ?>
                        </tbody>
                    </table>
                    <div class="row" style="display: contents;">
                        <div class="col-md-12">
                            <h6 style="text-align: right; padding-right: 5px;">QUANTIDADE TOTAL DE PRODUTOS: <?=$qtd_total;?></h6>
                        </div>
                        <div class="col-md-12">
                            <h6 style="text-align: right; padding-right: 5px;">TOTAL DO PEDIDO: <?=$exibe_total;?></h6>
                        </div>
                    </div>
                </div>
            </div><br><br>
    	    <div class='row' style="justify-content: space-evenly;">
            </div><br><br>
            <center><p>Sistema desenvolvido pela www.virtuabrasil.com.br</p></center><br><br>
    </section>
    <?if ($_GET['acao']=='impressao'){?>
        <script type="text/javascript">print();</script>
    <?}?>
    </body>
    </html>
<?exit();}elseif (isset($_GET['acao']) AND $_GET['acao']=='planilha'){
    $file_ending = "xls";
    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename=pedido-".$_GET['pedido'].".xls");
    header("Pragma: no-cache"); 
    header("Expires: 0");
    $sep = "\t";
    if (isset($id) AND $id!=''){
        $sql = "SELECT pe.identificacao_pedido, pr.produto, pr.qtd, pe.valor_pedido FROM pedidos AS pe INNER JOIN produtos_comprado AS pr ON (pe.id=pr.id_pedido) WHERE pe.identificacao_pedido='".$_GET["pedido"]."' AND pe.id_cliente = '".$_SESSION["usr_id_cliente"]."' ORDER BY pe.id DESC";
    }else{
        $sql = "SELECT pe.identificacao_pedido, pr.produto, pr.qtd, pe.valor_pedido FROM pedidos AS pe INNER JOIN produtos_comprado AS pr ON (pe.id=pr.id_pedido) WHERE pe.identificacao_pedido='".$_GET["pedido"]."' AND pe.id_cliente = '".$_SESSION["usr_id_cliente"]."' ORDER BY pe.id DESC";
    }
    $result = mysqli_query($conn,$sql) or die("Couldn't execute query:<br>" . mysqli_error(). "<br>" . mysqli_errno()); 
    
    $names = mysqli_fetch_fields($result) ;
    foreach($names as $name){
        print ($name->name . $sep);
    }
    print("\n");
    
    while($row = mysqli_fetch_row($result)) {
        $schema_insert = "";
        for($j=0; $j<mysqli_num_fields($result);$j++) {
            if(!isset($row[$j]))
                $schema_insert .= "NULL".$sep;
            elseif ($row[$j] != "")
                $schema_insert .= "$row[$j]".$sep;
            else
                $schema_insert .= "".$sep;
        }
    	$schema_insert = utf8_decode($schema_insert);
        $schema_insert = str_replace($sep."$", "", $schema_insert);
        $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
        $schema_insert .= "\t";
        print(trim($schema_insert));
        print "\n";
    }
    exit();
}
?>