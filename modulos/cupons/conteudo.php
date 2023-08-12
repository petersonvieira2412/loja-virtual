<?php
  include_once "config.php";
  $pagina_titulo = "Cupons de desconto";
  $pagina_referencia = "cupons";
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
if (isset($_POST['cadastrar_cupom'])) {
    $codigo_cupom = trim(addslashes(htmlspecialchars($_POST['codigo_cupom'])));
    $tipo_cupom = trim(addslashes(htmlspecialchars($_POST['tipo_cupom'])));
    $desconto_cupom = trim(addslashes(htmlspecialchars($_POST['desconto'])));
	$qtd = trim(addslashes(htmlspecialchars($_POST['qtd'])));
	$validade_inicio = trim(addslashes(htmlspecialchars($_POST['validade_inicio'])));
	$validade_fim = trim(addslashes(htmlspecialchars($_POST['validade_termino'])));
    $insere_cupom = "INSERT INTO cupons (cupom, cupom_desconto, cupom_tipo, qtd, validade_inicio, validade_fim, status) VALUES ('$codigo_cupom', '$desconto_cupom', '$tipo_cupom', '$qtd', '$validade_inicio', '$validade_fim', 'a')";
    $executa = mysqli_query($conexao,$insere_cupom);
    if ($executa) {
      echo "<script>alert('Cupom cadastrado com sucesso.');</script>";
      echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";
      exit();
    }else{
      echo "<script>alert('Erro ao cadastrar o cupom.');</script>";
    }
  
}

if (!isset($_POST['editarcupom'])){$_POST['editarcupom'] = '';}

if ($_POST['editarcupom']=='editarcupom') {
	$idcupom = trim(addslashes(htmlspecialchars($_POST['id_cupom'])));
    $codigo_cupom = trim(addslashes(htmlspecialchars($_POST['codigo_cupom'])));
    $tipo_cupom = trim(addslashes(htmlspecialchars($_POST['tipo_cupom'])));
    $desconto_cupom = trim(addslashes(htmlspecialchars($_POST['desconto'])));
	$qtd = trim(addslashes(htmlspecialchars($_POST['qtd'])));
	$validade_inicio = trim(addslashes(htmlspecialchars($_POST['validade_inicio'])));
	$validade_fim = trim(addslashes(htmlspecialchars($_POST['validade_termino'])));
    $editar_cupom = "UPDATE cupons SET cupom='".$codigo_cupom."', cupom_desconto='".$desconto_cupom."', cupom_tipo='".$tipo_cupom."', qtd='".$qtd."', validade_inicio='".$validade_inicio."', validade_fim='".$validade_fim."' WHERE id='".$idcupom."'";
    $executa = mysqli_query($conexao,$editar_cupom);
    if ($executa) {
      echo "<script>alert('Cupom editado com sucesso.');</script>";
      echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";
      exit();
    }else{
      echo "<script>alert('Erro ao editar o cupom.');</script>";
    }
  
}

if (isset($_POST['excluir'])) {
      $id_cupom = trim(addslashes(htmlspecialchars($_POST['id_cupom'])));
      $update = "UPDATE cupons SET status='d' WHERE id='".$id_cupom."' "  or die(mysqli_error());
      $executa = mysqli_query($conexao,$update);
    if ($executa) {
      //echo "<script>alert('Cupom desativado com sucesso.');</script>";
      echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";
      exit();
    }else{
      echo "<script>alert('Erro ao cadastrar o cupom.');</script>";
    }
   
  }
  if (isset($_POST['reativar'])) {
      $id_cupom = trim(addslashes(htmlspecialchars($_POST['id_cupom'])));
      $update = "UPDATE cupons SET status='a' WHERE id='".$id_cupom."' "  or die(mysqli_error());
      $executa = mysqli_query($conexao,$update);
    if ($executa) {
      //echo "<script>alert('Cupom desativado com sucesso.');</script>";
      echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";
      exit();
    }else{
      echo "<script>alert('Erro ao cadastrar o cupom.');</script>";
    }
   
  }
if ($acao=="cadastrar") { ?>
<br><br><br>
 <div class="row">
        <div class="col-lg-12 ">
          <div class="panel panel-default ">
            <div class="panel-body ">
              <h3>Cupons de desconto</h3>
              <p>Cadastre um novo cupom de desconto abaixo</p>
              <hr>
              <br>
              <form name="relatorio" action="" method="POST">
              <div class="col-md-4"> 
                <div class="form-group">
                  <label >CÓDIGO DO CUPOM</label>
                  <input type="text" name="codigo_cupom" class="form-control" required>
                </div>
              </div>
              <div class="col-md-4"> 
                <div class="form-group">
                  <label >TIPO DE CUPOM</label>
                  <select class="form-control" name="tipo_cupom">
                      <option value="1">Real (R$)</option>
                      <option value="2">Porcentagem (%)</option>
                    </select>
                </div>
              </div>
              <div class="col-md-4"> 
                <div class="form-group">
                  <label>DESCONTO APLICADO</label>
                  <input type="number" name="desconto" class="form-control" required>
                </div>
              </div>
			  
			  <div class="col-md-4"> 
                <div class="form-group">
                  <label >QUANTIDADE DISPONÍVEL</label>
                  <input type="number" name="qtd" min="1" value="1" class="form-control" required>
                </div>
              </div>
			  
			  <div class="col-md-4"> 
                <div class="form-group">
                  <label >VIGÊNCIA (INÍCIO)</label>
                  <input type="date" name="validade_inicio" placeholder="dd/mm/aaaa" class="form-control" required>
                </div>
              </div>
			  
			  <div class="col-md-4"> 
                <div class="form-group">
                  <label >VIGÊNCIA TÉRMINO</label>
                  <input type="date" name="validade_termino" placeholder="dd/mm/aaaa" class="form-control" required>
                </div>
              </div>
             
              <div class="col-md-12"> </div>
                <div class="col-md-12">
                <div class="form-group">
                  <label></label>
                  <button type="submit" name="cadastrar_cupom" value="enviar" class="btn btn-success" style="float:right;"><i class="fa fa-check"></i> Cadastrar Cupom</button>
                </div>
              </div>
            </form>
            </div>
          </div>
        </div>
      </div>
       <div class="row">
        <div class="col-lg-12 ">
          <div class="panel panel-default ">
            <div class="panel-body ">
              <h3>Cupons cadastrados</h3>
              <p>Veja a lista de cupons cadastrados no seu site.</p>
              <hr>
              <br>
              <div class="col-md-12"> 
                
              <table class="table table-bordered table-hover" id="dataTables-userlist">
         <thead>
            <tr>
              <th>Cupom</th>
              <th>Valor Desconto</th>
              <th>Tipo do desconto</th>
              <th>Quantidade</th>
			  <th>Vigência</th>
			  <th>Status</th>
			  <th width="120px">Ação</th>
            </tr>
          </thead>
          <tbody>
          <?
          $result = ("SELECT * FROM cupons ORDER BY id DESC");
          $execute = mysqli_query($conexao, $result);
          if(mysqli_num_rows ($execute) > 0 )
          {
              while ($dados_cliente = mysqli_fetch_assoc($execute)){
                $cupom = $dados_cliente['cupom'];
                $valor_desconto = $dados_cliente['cupom_desconto'];
                $tipo_desconto = $dados_cliente['cupom_tipo'];
                $status_cupom = $dados_cliente['status'];
                $id_cupom = $dados_cliente['id'];
				$qtde = $dados_cliente['qtd'];
				$dataini = $dados_cliente['validade_inicio'];
				$datafim = $dados_cliente['validade_fim'];
            
        ?>
            <tr>
              <td class="center"><?=$cupom;?></td>
              <td class="center"><strong><?=$valor_desconto;?><?=($tipo_desconto=='porcentagem')?"% de desconto</strong> ao final do valor.":" Reais de desconto</strong> ao final do valor.";?></td>
              <td class="center"><?=($tipo_desconto=='porcentagem')?"<span class='status btn-primary'>%</span>":"<span class='status btn-success'>R$</span>";?></td>
              <td class="center"><?=($qtde=='')?0:$qtde;?></td>
			  <td class="center"><?=($dataini!='' && $datafim!='')?$dataini.'<br>~<br>'.$datafim:'-';?></td>
			  <td class="center"><?=($status_cupom=='a')?"<span class='status btn-success'>Ativo</span>":"<span class='status btn-danger'>Desativado</span>";?></td>
              <td  width="120px" class="center">
			  <a href="#" class="btn btn-circle btn-primary " title="Editar cupom" data-toggle="modal" data-target="#myModalE<?=$id_cupom?>"><i class="fa fa-pencil"></i></a>
			  <?=($status_cupom=='a')?'
              <a href="#" class="btn btn-circle btn-danger " title="Desativar cupom" data-toggle="modal" data-target="#myModal'.$id_cupom.'"><i class="fa fa-lock"></i></a>':
              '<a href="#" class="btn btn-circle btn-success " data-toggle="modal" data-target="#myModal_reativar'.$id_cupom.'" title="Reativar Cupom"><i class="fa fa-check"></i></a>';?>

			<div class="modal fade" id="myModalE<?=$id_cupom;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <form action="" method="POST">
				  <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="myModalLabel3">EDITAR O CUPOM</h4>
                  </div>
                  <div class="modal-body">
				  <div class="col-md-12">
              <div class="col-md-4"> 
                <div class="form-group">
                  <label >CÓDIGO DO CUPOM</label>
                  <input type="text" name="codigo_cupom" style="width:100%;" class="form-control" required value="<?=$cupom?>">
                </div>
              </div>
              <div class="col-md-4"> 
                <div class="form-group">
                  <label >TIPO DE CUPOM</label>
                  <select class="form-control" style="width:100%;" name="tipo_cupom">
                      <option value="1" <?=(($tipo_desconto=='1')?'selected':'');?>>Real (R$)</option>
                      <option value="porcentagem" <?=(($tipo_desconto=='2')?'selected':'');?>>Porcentagem (%)</option>
                    </select>
                </div>
              </div>
              <div class="col-md-4"> 
                <div class="form-group">
                  <label >DESCONTO APLICADO</label>
                  <input type="number" name="desconto" style="width:100%;" class="form-control" required value="<?=$dados_cliente['cupom_desconto'];?>">
                </div>
              </div>
			  
			  <div class="col-md-4"> 
                <div class="form-group">
                  <label >QUANTIDADE DISPONÍVEL</label>
                  <input type="number" name="qtd" min="1" style="width:100%;" class="form-control" required value="<?=$qtde?>">
                </div>
              </div>
			  
			  <div class="col-md-4"> 
                <div class="form-group">
                  <label >VIGÊNCIA (INÍCIO)</label>
                  <input type="date" name="validade_inicio" style="width:100%;" placeholder="dd/mm/aaaa" class="form-control" required  value="<?=$dataini?>">
                </div>
              </div>
			  
			  <div class="col-md-4"> 
                <div class="form-group">
                  <label >VIGÊNCIA TÉRMINO</label>
                  <input type="date" name="validade_termino" style="width:100%;" placeholder="dd/mm/aaaa" class="form-control" required  value="<?=$datafim?>">
                </div>
              </div>
			  <div class="col-md-12"><br><br></div>
             </div>
				  </div>
                  <div class="modal-footer">
					<div class="col-md-12">
                       <input type='hidden' name="id_cupom" value="<?=$id_cupom;?>">
                       <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>                  
                       <button type="submit" name="editarcupom" style="margin-right:20px;" value="editarcupom" class="btn btn-success">Salvar</button>
					</div>
				  </div>
				  </form>
                </div>
                <!-- /.modal-content --> 
              </div>
          </div>

            <div class="modal fade" id="myModal<?=$id_cupom;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="myModalLabel3">DESATIVAR O CUPOM: <strong><?=$cupom;?></strong></h4>
                  </div>
                  <div class="modal-body">Confirma a desativação deste item? </div>
                  <div class="modal-footer">
                    <form name="excluir" method="POST" action="">
                       <input type='hidden' name="id_cupom" value="<?=$id_cupom;?>">
                       <button type="submit" name="excluir" class="btn btn-success">SIM</button>
                       <button type="button" class="btn btn-danger" data-dismiss="modal">NÃO</button>
                    </form>
                  
                  </div>
                </div>
                <!-- /.modal-content --> 
              </div>
          </div>

          <!-- reativação do cupom-->
          <div class="modal fade" id="myModal_reativar<?=$id_cupom;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="myModalLabel3">REATIVAR O CUPOM: <strong><?=$cupom;?></strong></h4>
                  </div>
                  <div class="modal-body">Confirma a reativação deste item? </div>
                  <div class="modal-footer">
                    <form name="reativar" method="POST" action="">
                       <input type='hidden' name="id_cupom" value="<?=$id_cupom;?>">
                       <button type="submit" name="reativar" class="btn btn-success">SIM</button>
                       <button type="button" class="btn btn-danger" data-dismiss="modal">NÃO</button>
                    </form>
                  
                  </div>
                </div>
                <!-- /.modal-content --> 
              </div>
          </div>

            </td>
            </tr>
            <?}}?>
          </tbody>
        </table>
              </div>
            </div>
          </div>
        </div>
      </div>
     
<? } 
  if ($acao=="") { ?>
    <div class="row">
      <div class="col-md-12  header-wrapper" >
          <h1 class="page-header"><?=mb_convert_case("$pagina_titulo", MB_CASE_TITLE, "UTF-8");?></h1>
          <p class="page-subtitle">Listagens dos cupons no sistema.</p>
      </div>
    </div>
      <div class="row">
        <div class="col-md-12">
          <table class="table table-bordered table-hover" id="dataTables-userlist">
           <thead>
              <tr>
                <th>Cupom</th>
                <th>Desconto</th>
                <th>Tipo</th>
                <th>Quantidade</th>
                <th>Validade Início</th>
                <th>Validade Término</th>
                <th>Status</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
            <?
            $result = ("SELECT * FROM cupons ORDER BY id DESC ");
            $execute = mysqli_query($conexao, $result);
            if(mysqli_num_rows ($execute) > 0 )
            {
                while ($dados_cliente = mysqli_fetch_assoc($execute)){
                $id = $dados_cliente['id'];
                $cupom = $dados_cliente['cupom'];
                $cupom_desconto = $dados_cliente['cupom_desconto'];
                $cupom_tipo = $dados_cliente['cupom_tipo'];
                $qtd = $dados_cliente['qtd'];
                $validade_inicio = $dados_cliente['validade_inicio'];
                $validade_fim = $dados_cliente['validade_fim'];
                $status = $dados_cliente['status'];
                if ($status == 'a'){
                  $status = 'ativo';
                }else{
                  $status = 'desativado';
                }
              }
  
              
          ?>
              <tr>
                <td class="center"><?=$cupom;?></td>
                <td class="center"><?=$cupom_desconto;?></td>
                <td class="center"><?=$cupom_tipo;?></td>
                <td class="center"><?=$qtd;?></td>
                <td class="center"><?=$validade_inicio;?></td>
                <td class="center"><?=$validade_fim;?></td>
                <td class="center"><?=$status;?></td>
              <td>
              <div class="socials tex-center"> 
                <a href="#" class="btn btn-circle btn-primary " data-toggle="modal" data-target="#myModal<?=$id;?>" title="Alterar Status"><i class="fa fa-eye"></i></a>
              </div> 
              <div class="modal fade" id="myModal<?=$id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel3">PEDIDOS COM CUPOM APLICADO (<?=$cupom;?>)</h4>
                    </div>
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">Número Pedido</th>
                          <th scope="col">Valor Pedido</th>
                          <th scope="col">Valor Desconto</th>
                          <th scope="col">Tipo</th>
                          <th scope="col">QTD</th>
                        </tr>
                      </thead>
                      <?
                          $result_detalhes = "SELECT identificacao_pedido, valor_pedido FROM pedidos WHERE cupom_aplicado='$cupom' ORDER BY id DESC";
                          $execute_detalhes = mysqli_query($conexao, $result_detalhes);
                          if(mysqli_num_rows ($execute_detalhes) > 0 )
                          {
                              while ($dados_detalhes = mysqli_fetch_assoc($execute_detalhes)){
                              $numero_pedido = $dados_detalhes['identificacao_pedido'];
                              $valor_pedido = $dados_detalhes['valor_pedido'];
                          ?>
                              <tbody>
                                <tr>
                                  <td><?=$numero_pedido;?></td>
                                  <td><?=$valor_pedido;?></td>                                                      
                                  <td><?=$cupom_desconto;?></td>
                                  <td><?=$cupom_tipo;?></td>
                                </tr>
                              </tbody>
                              <?}}?>
                  </table>
                  <?if (mysqli_num_rows($execute_detalhes)>0){?>
                    <div class="cls" style="width: 100%; height: 2em;"></div>
                    <div class="row">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4"></div>
                      <div class="col-sm-4">
                        <input type="hidden" name="controle" value="<?=$controle;?>">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true" style="float: right; margin-right: 28px;">Fechar</button>
                      </div>
                    </div>
                    <div class="cls" style="width: 100%; height: 2em;"></div>
                  <?}else{?>
                    <div class="cls" style="width: 100%; height: 2em;"></div>
                    <div class="row">
                      <div class="col-sm-4"></div>
                      <div class="col-sm-4"><p align="right" style="margin-right: 28px;"><strong>ESTE CUPOM NÃO FOI APLICADO!</strong></p></div>
                      <div class="col-sm-4"></div>
                    </div>
                    <div class="cls" style="width: 100%; height: 2em;"></div>
                    <div class="row">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4"></div>
                      <div class="col-sm-4" >
                        <input type="hidden" name="controle" value="<?=$controle;?>">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true" style="float: right; margin-right: 28px;">Fechar</button>
                      </div>
                    </div>
                    <div class="cls" style="width: 100%; height: 2em;"></div>
                  <?}?>
                </div>
              </div>
            </div>
              <div class="cls" style="width: 100%; height: 3em;"></div>  
  <?
    }
  }
    mysqli_free_result($execute);
    ?>   
           
            </tbody>
          </table>
        </div>
      </div>
<!-- /#wrapper -->
<!-- jQuery --> 
    <!-- Include external JS libs. -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/mode/xml/xml.min.js"></script>
    <!-- Include Editor JS files. -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.8.4/js/froala_editor.pkgd.min.js"></script>
    <!-- /#wrapper -->
    <!-- Bootstrap Core JavaScript --> 
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script> 
    <!-- DataTables JavaScript --> 
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script> 
    <script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script> 
    <script src="vendor/datatables-responsive/dataTables.responsive.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/i18n/pt-BR.js"></script>
    <!-- Custom Theme JavaScript --> 
    <script src="js/adminnine.js"></script> 
    <script>
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
