<?php
  include_once "config.php";
  $pagina_titulo = "Relatórios";
  $pagina_referencia = "pedidos";

	setlocale(LC_ALL, 'en_US.UTF8');
	function UrlAmigavel($str, $replace=array(), $delimiter='-') {
		if( !empty($replace) ) {
			$str = str_replace((array)$replace, ' ', $str);
		}

		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
		$clean = substr($clean, 0, 120);

		return $clean;
	}

if ($acao=="") { ?>

<br><br><br>
 <div class="row">
        <div class="col-lg-12 ">
          <div class="panel panel-default ">
            <div class="panel-body ">
              <h3>Relatório</h3>
              <p>Visualize abaixo o relatório gerado pelo sistema. Você poderá alterar os filtros a qualquer momento.</p>
              <hr>
              <br>
              <form name="relatorio" action="" method="POST">
              <div class="col-md-4"> 
                <div class="form-group">
                  <label >TIPO DE RELATÓRIO</label>
                  <select class="form-control" name="tipo_relatorio">
                      <option value='vendas'>Vendas Online</option>
                    </select>
                </div>
              </div>
              <div class="col-md-4"> 
                <div class="form-group">
                  <label >DATA INÍCIO</label>
                  <input type="date" name="data_inicio" value="<?=date('Y');?>-<?=date('m');?>-01" class="form-control" required>
                </div>
              </div>
               <div class="col-md-4"> 
                <div class="form-group">
                  <label >DATA FIM</label>
                  <input type="date" name="data_fim" class="form-control" value="<?=date('Y-m-d');?>" required>
                </div>
              </div>
              <div class="col-md-12"> </div>
                <div class="col-md-12">
                <div class="form-group">
                  <label></label>
                  <button type="submit" name="gerar_relatorio" value="enviar" class="btn btn-success" style="float:right;"><i class="fa fa-check"></i> Gerar Relatório</button>
                </div>
              </div>
            </form>
            </div>
          </div>
        </div>
      </div>

      <?////////////////////////////////////
      //gera o relatório
      //////////////////////////////////////
      if (isset($_POST['gerar_relatorio'])){
            
        $tipo_relatorio = trim(addslashes(htmlspecialchars($_POST['tipo_relatorio'])));
        $data_inicio = trim(addslashes(htmlspecialchars($_POST['data_inicio'])));
        $data_fim = trim(addslashes(htmlspecialchars($_POST['data_fim'])));

        $select_relatorio = "SELECT DISTINCT identificacao_pedido, id, data, valor_pedido, sessao_id, situacao, nome, pagamento, email, hora, datas FROM pedidos WHERE datas BETWEEN '$data_inicio' AND '$data_fim' AND identificacao_pedido != '' ORDER BY identificacao_pedido DESC" ;
        $executa_relatorio = mysqli_query($conexao, $select_relatorio);
        $conta = mysqli_num_rows($executa_relatorio);

        if ($conta>0) {
           echo "<script>chamaToastr('success','<span style=font-family:arial;>SUCESSO!</span>','<span style=font-family:arial;>O Relatório foi gerado com êxito. Veja os detalhes logo abaixo.</span>');</script>";
        ?>
      <div class="row">
        <div class="col-lg-12 ">
          <div class="panel panel-default ">
            <div class="panel-body ">
              <h3>Relatório Gerado</h3>
              <p>Visualize abaixo o relatório gerado pelo sistema. Você poderá alterar os filtros a qualquer momento.</p>
              <hr>
              <br>
              <div class="col-md-12"> 
                <div class="form-group">
                <table class="table table-bordered table-hover" id="dataTables-userlist">
                 <thead>
                    <tr>
                      <th>Pedido</th>
                      <th>Valor </th>
                      <th>Cliente</th>
                      <th>Data</th>
                      <th>Status</th>
                      <th>Ações</th>
                    </tr>
                  </thead>
                  <tbody>
            <?
            $soma = 0;
            while ($dados_cliente = mysqli_fetch_assoc($executa_relatorio)){
              $data = $dados_cliente['data'];
              $sessao_id = $dados_cliente['sessao_id'];
              $id = $dados_cliente['id'];
              $hora = $dados_cliente['hora'];
              $controle = $dados_cliente['identificacao_pedido'];
              $valor_pedido = $dados_cliente['valor_pedido'];
              $situacao = $dados_cliente['situacao'];
              $nome = $dados_cliente['nome'];
              $pagamento = $dados_cliente['pagamento'];
              $email = $dados_cliente['email'];

              $soma += $valor_pedido;

              $valor_total = $valor_pedido;

              $cliente = $nome;

              if ($valor_total=='0.00') {
                $valor_exibe_total_principal ='<strong>Sem informações</strong>';
              }else{
                $valor_exibe_total_principal = number_format($valor_total,2,',','.');
              }

              if ($pagamento=='vista') {
                $pagamento='À vista';
              }elseif ($pagamento=='faturado_15') {
                $pagamento='Faturado 15 dias';
              }elseif($pagamento=='faturado_30'){
                $pagamento='Faturado 30 dias';
              }
              if ($situacao=='ag') {
              $exibir_situacao = '<span class="btn btn-circle btn-warning" style="padding:5px 20px;color:#fff;border-radius:15px; width:130px; border:none;">Aguardando</span>';
              }
              elseif ($situacao=='ft') {
                $exibir_situacao = '<span class="btn btn-circle btn-primary" style="padding:5px 20px;color:#fff;border-radius:15px; width:130px; border:none;">Faturado</span>';
              }
              elseif ($situacao=='cn') {
                $exibir_situacao = '<span class="btn btn-circle btn-danger" style="padding:5px 20px;color:#fff;border-radius:15px; width:130px; border:none;">Cancelado</span>';
              }
              elseif ($situacao=='sp') {
                $exibir_situacao = '<span class="btn btn-circle btn-primary" style="padding:5px 20px;color:#fff;border-radius:15px; width:130px; border:none;">Em separação</span>';
              }
              elseif ($situacao=='tr') {
                $exibir_situacao = '<span class="btn btn-circle btn-primary" style="padding:5px 20px;color:#fff;border-radius:15px; width:130px; border:none;">Em transporte</span>';
              }
              elseif ($situacao=='en') {
                $exibir_situacao = '<span class="btn btn-circle btn-success" style="padding:5px 20px;color:#fff;border-radius:15px; width:130px; border:none;">Entregue</span>';
              }
      ?>
            <tr>
              <td class="center"><?=$controle;?></td>
              <td>R$ <?=$valor_exibe_total_principal;?></td>
              <td class="center"><?=$cliente;?></td>
              <td class="center"><?=$data;?></td>
              <td class="center"><?=$exibir_situacao;?></td>
              <td >
              <div class="socials tex-center"> 
                <a href="#" class="btn btn-circle btn-primary " data-toggle="modal" data-target="#myModal<?=$controle;?>" title="Alterar Status"><i class="fa fa-eye"></i></a>
                <a href="arquivo-<?=$controle;?>" target="_blank" class="btn btn-circle btn-success "  title="Gerar PDF"><i class="fa fa-print"></i></a> 
                <a href="#" onclick="Baixar();" class="btn btn-circle btn-danger" title="Alterar Status"><i class="fa fa-file-pdf-o"></i></a>
              </div>
              <div class="modal fade" id="myModal<?=$controle;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel3">DETALHES DO PEDIDO <strong>#<?=$controle;?></strong> [<?=$exibir_situacao;?>]</h4>
                          </div>
                          <table class="table">
                            <thead>
                              <tr>
                                <th scope="col">Imagem do produto</th>
                                <th scope="col">Id</th>
                                <th scope="col">Nome do Produto</th>
                                <th scope="col">QTD</th>
                                <th scope="col">R$</th>
                              </tr>
                            </thead>
                            <?
                               
                                $sql = "SELECT * FROM pedidos WHERE identificacao_pedido='$controle' ORDER BY identificacao_pedido DESC";
                                $query = mysqli_query($conexao, $sql);
                                if(mysqli_num_rows($query)==0){
                                  echo " Não foi encontrado nenhum detalhe do relatório.";
                                }else{
                                    while ($dados_detalhes = mysqli_fetch_assoc($query)){
                                    $data = $dados_detalhes['data'];
                                    $sistema = $dados_detalhes['sistema'];
                                    $valor_total = $dados_detalhes['valor_pedido'];
                                    $endereco = $dados_detalhes['endereco'];
                                    $numero = $dados_detalhes['numero'];
                                    $bairro = $dados_detalhes['bairro'];
                                    $cep = $dados_detalhes['cep'];
                                    $cidade = $dados_detalhes['cidade'];
                                    $estado = $dados_detalhes['estado'];
                                    $email = $dados_detalhes['email'];
                                    $nome = $dados_detalhes['nome'];
                                    $sobrenome = $dados_detalhes['sobrenome'];
                                    $valor_frete = $dados_detalhes['valor_frete'];
                                    $ddd_celular = $dados_detalhes['celular_ddd'];
                                    $celular = $dados_detalhes['celular'];
                                    $ddd_telefone = $dados_detalhes['telefone_ddd'];
                                    $telefone = $dados_detalhes['telefone'];                                 
                                ?>
                                
                                    <tbody>
                                    <?
                                     $result_detalhes2 = "SELECT * FROM produtos_comprado WHERE id_pedido='$id' ORDER BY produto DESC";
                                     $execute_detalhes2 = mysqli_query($conexao, $result_detalhes2);

                                      while ($dados_detalhes2 = mysqli_fetch_assoc($execute_detalhes2)){
                                        $id_produto = $dados_detalhes2['id_produto'];
                                        $produto = $dados_detalhes2['produto'];
                                        $qtd = $dados_detalhes2['qtd'];
                                        $preco = $dados_detalhes2['preco'];
                                        $img = $dados_detalhes2['img'];

                                        if ($img=='') {
                                          $imagem = '../assets/img/'.$pagina_referencia.'/sem_foto.jpg';
                                          }  
                                          elseif(file_exists('../'.$img)){
                                          $imagem = '../'.$img;
                                          }else {
                                          $imagem = '../assets/img/'.$pagina_referencia.'/sem_foto.jpg';
                                          } 
                                    ?>
                                      <tr>
                                        <td><center><img src="<?=$imagem;?>" title="<?=$produto;?>"></center></td>
                                        <td><?=$id_produto;?></td>                                                      
                                        <td><?=$produto;?></td>
                                        <td><?=$qtd;?></td>
                                        <td><?=number_format($preco,2,',','.');?></td>
                                      </tr>
                                    <?}?>
                                    </tbody>
                                  
                        <?}}?>
                        </table>
                        <div class="row">
                          <div class="col-sm-4"></div>
                          <div class="col-sm-4"></div>
                          <div class="col-sm-4"><p align="right" style="margin-right: 28px;"><strong>Total do pedido: <span style='font-size: 16px;'>R$ <?=number_format($valor_total,2,',','.');?></span></strong></p></div>
                        </div>
                        <div class="row">
                          <div class="col-sm-1" ><p style='margin-left: 28px; margin-top: 1em;'><strong>Endereço:</strong></p></div>
                          <div class="col-sm-10">
                           <p style='margin-left: 12px; margin-top: 1em;'><?=$endereco;?>, <?=$numero;?>, <?=$bairro;?>, <?=$cep;?> - <?=$cidade;?>/<?=$estado;?></p>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-1" ><p style='margin-left: 28px; margin-top: 1em;'><strong>Responsável:</strong></p></div>
                          <div class="col-sm-10">
                           <p style='margin-left: 35px; margin-top: 1em;'><?=$nome;?> <?=$sobrenome;?> -  <?=$celular;?> | <?=$telefone;?> | <?=$email;?></p>
                          </div>
                        </div>
                        <div class="cls" style="width: 100%; height: 2em;"></div>
                        <form name="atualiza pedido" action="" method="POST">
                          <div class="row">
                            <div class="col-sm-4" ><p style='margin-left: 28px; margin-top: 1em;'>Atualize o status do pedido <strong>#<?=$controle;?></strong></p></div>
                            <div class="col-sm-4">
                              <select name="status" class="form-control" style="width: 410px;">
                                <option selected disabled>Selecione uma opção</option>
                                <option value="ap">Pagamento Aprovado</option>
                                <option value="cn">Pagamento Cancelado</option>
                                <option value="sp">Em separação no estoque</option>
                                <option value="tr">Em transporte</option>
                                <option value="en">Entregue</option>
                              </select>
                            </div>
                            <div class="col-sm-4" >
                              <input type="hidden" name="controle" value="<?=$controle;?>">
                              <button type="submit" class="btn btn-primary" name="atualiza_status" style="float: right; margin-right: 28px;">ATUALIZAR</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <div class="cls" style="width: 100%; height: 3em;"></div>
              </td>
            </tr>
          
      <?}?>

      </tbody>
        </table>
         </div>
              </div>
            </div>
          </div>
        </div>
      </div>
       <div class="row">
        <div class="col-lg-12 ">
          <div class="panel panel-default ">
            <div class="panel-body ">
              <h3 style="color:#7ab92d;">RECEITA TOTAL</h3>
              <p>Visualize abaixo a receita total gerada a partir da data escolhida.</p>
              <hr>
              <br>
              <div class="col-md-6"> 
                <div class="form-group">
                  <label >TIPO DE RECEITA</label>
                  <h1>Vendas Online</h1>
                </div>
              </div>
              <div class="col-md-6"> 
                <div class="form-group">
                  <label >VALOR TOTAL DOS PEDIDOS</label>
                  <h1 style="color:#7ab92d;">R$ <?=number_format($soma,2,',','.');?></h1>
                </div>
              </div>
              
            </div>
          </div>
        </div>
      </div>
      <?}else{
         echo "<script>alert('Não foi encontrado nenhum dado para o relatório.');</script>";
         echo "<script>chamaToastr('error','<span style=font-family:arial;>Erro!</span>','<span style=font-family:arial;>Não foi possível gerar o relatório. Não foi encontrado nenhum dado para a data específica.</span>');</script>";
      }}?>  
    <!-- /.row --> 

<? } ?>

<!-- /#wrapper -->
<!-- jQuery --> 
    <!-- Custom Theme JavaScript --> 
      <script src="modulos/relatorios/assets/js/jspdf.min.js"></script>
  <script src="modulos/relatorios/assets/js/html2canvas.min.js"></script>
  <script src="modulos/relatorios/assets/js/main.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/mode/xml/xml.min.js"></script>
    <!-- Include Editor JS files. -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.8.4/js/froala_editor.pkgd.min.js"></script>
    <!-- /#wrapper -->
    <!-- jQuery --> 
    <script src="vendor/jquery/jquery.min.js"></script> 
    <!-- Bootstrap Core JavaScript --> 
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script> 
    <!-- DataTables JavaScript --> 
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script> 
    <script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script> 
    <script src="vendor/datatables-responsive/dataTables.responsive.js"></script> 
    <!-- Custom Theme JavaScript --> 
    <script src="js/adminnine.js"></script> 
    <script>
        function Baixar(){
            $.ajax({
                type: 'POST',
                url: 'https://<?=$_SERVER["HTTP_HOST"];?>/modulos/relatorios/arquivo-1234124',
                data: {
                    tipo: 'pdf'
                },
                dataType: 'json',
                success: function (data) {
                    alert('entrou');
                    var downloadSection = data.conteudo;
                    var cWidth = downloadSection.width();
                    var cHeight = downloadSection.height();
                    var topLeftMargin = 40;
                    var pdfWidth = cWidth + topLeftMargin * 2;
                    var pdfHeight = pdfWidth * 1.5 + topLeftMargin * 2;
                    var canvasImageWidth = cWidth;
                    var canvasImageHeight = cHeight;
                    var totalPDFPages = Math.ceil(cHeight / pdfHeight) - 1;
                
                    html2canvas(downloadSection[0], { allowTaint: true }).then(function (
                      canvas
                    ) {
                      canvas.getContext('2d');
                      var imgData = canvas.toDataURL('image/jpeg', 1.0);
                      var pdf = new jsPDF('p', 'pt', [pdfWidth, pdfHeight]);
                      pdf.addImage(
                        imgData,
                        'JPG',
                        topLeftMargin,
                        topLeftMargin,
                        canvasImageWidth,
                        canvasImageHeight
                      );
                      for (var i = 1; i <= totalPDFPages; i++) {
                        pdf.addPage(pdfWidth, pdfHeight);
                        pdf.addImage(
                          imgData,
                          'JPG',
                          topLeftMargin,
                          -(pdfHeight * i) + topLeftMargin * 0,
                          canvasImageWidth,
                          canvasImageHeight
                        );
                      }
                      pdf.save('ivonne-invoice.pdf');
                    });
                }
            });
        }
          $(document).ready(function() {
          $('#dataTables-userlist').DataTable({
                    responsive: true,
                    pageLength:50,
                    sPaginationType: "full_numbers",
                    oLanguage: {
                        oPaginate: {
                            sFirst: "<<",
                            sPrevious: "<",
                            sNext: ">", 
                            sLast: ">>" 
                        }
                    }
                });
            });
    </script>
