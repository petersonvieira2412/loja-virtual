<?php
  include_once "config.php";
  $pagina_titulo = "Cores";
  $pagina_referencia = "cores";
  $pagina_link = "cores";

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

  if ($acao=="gravar") { 
	  	$cor = trim(addslashes(mb_convert_case($_POST['cor'], MB_CASE_TITLE, "UTF-8")));
	  	$rgb = trim(addslashes($_POST['rgb']));
	  	$data_cadastro = date('Y-m-d');
        $hora_cadastro = date('H:i:s');

		$insere = "INSERT INTO $pagina_referencia (cor, rgb, data_cadastro, hora_cadastro, status) VALUES ('$cor', '$rgb', '$data_cadastro', '$hora_cadastro', 'a')" or die(mysqli_error());    

		if (!mysqli_query($conexao, $insere)) {  
			die('Erro: '.mysqli_error($conexao)); 
		} else {
			echo "<script>alert('Cadastrado com sucesso!');</script>";
			echo "<meta http-equiv='refresh' content='0;'>";

		}
		
  }

  if ($acao=="cadastrar") { ?>
    <div class="row">
      <div class="col-md-12  header-wrapper" >
        <h1 class="page-header"><?=mb_convert_case("$pagina_titulo", MB_CASE_TITLE, "UTF-8");?> Adicionar</h1>
        <p class="page-subtitle">Para cadastrar um novo item, preencha os dados abaixo.</p>
      </div>
    </div>

    <form method="post" action="" enctype="multipart/form-data">
      <div class="row">
        <div class="col-lg-12 ">
          <div class="panel panel-default ">
            <div class="panel-body ">
              <div class="col-md-6">
                <div class="form-group">
                  <label>NOME DA COR</label>
                  <input name="cor" type="text" required="required" class="form-control" id="cor" placeholder="Ex: Amarelo">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>RGB DA COR</label>
                  <input name="rgb" type="color" required="required" class="form-control" id="rgb" style="height: 55px;">
                </div>
              </div>
              <div class="col-md-12"> </div>
              <div class="col-md-12">
                <div class="form-group">
                  <input name="acao" id="acao" value="gravar" type="hidden">
                  <button type="submit" name="enviar" value="enviar" class="btn btn-success" style="float:right;"><i class="fa fa-check"></i> Adicionar </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>

<? }

  if (isset($_POST['excluir'])) { 

		$id = $_POST['id'];

	  	$update = "DELETE FROM $pagina_referencia WHERE id='$id' "  or die(mysqli_error());

		if (!mysqli_query($conexao, $update)) {  
			die('Erro: '.mysqli_error($conexao)); 
		} else{
		    $update = "DELETE FROM estoque WHERE id_cor='$id' "  or die(mysqli_error());
    
    		if (!mysqli_query($conexao, $update)) {  
    			die('Erro: '.mysqli_error($conexao)); 
    		} else{
    		    echo "<script>alert('Excluído com sucesso!');</script>";
    		    echo "<meta http-equiv='refresh' content='0;'>";   
    		}
		}
  }
  if (isset($_POST['editar'])) { 

		$id = addslashes(ltrim($_POST['id']));
		$cor = addslashes(ltrim($_POST['cor']));
		$rgb = addslashes(ltrim($_POST['rgb']));

	  	$update = "UPDATE $pagina_referencia SET cor='$cor', rgb='$rgb' WHERE id='$id' "  or die(mysqli_error());

		if (!mysqli_query($conexao, $update)) {  
			die('Erro: '.mysqli_error($conexao)); 
		} else{
		    echo "<script>alert('Editado com sucesso!');</script>";
		    echo "<meta http-equiv='refresh' content='0;'>";   
		}
  }

if ($acao=="") { ?>
			
	<div class="row">
		<div class="col-md-12  header-wrapper" >
			<h1 class="page-header"><?=mb_convert_case("$pagina_titulo", MB_CASE_TITLE, "UTF-8");?></h1>
			<p class="page-subtitle">Listagens dos itens cadastrados no sistema.</p>
			<div class="pull-right">
				<a href="<?=$pagina_link;?>-cadastrar" title="CADASTRAR" class="btn btn-primary">+ CADASTRAR</a>
			</div>
		</div>
	</div>

    <div class="row">
      <div class="col-md-12">
        <table class="table table-bordered table-hover" id="dataTables-userlist">
         <thead>
            <tr>
              <th>COR</th>
              <th>RGB</th>
              <th>AÇÕES</th>
            </tr>
          </thead>
          <tbody>
	<?
	$sql = "SELECT * FROM $pagina_referencia WHERE status='a' ORDER BY cor ASC";
	$query = mysqli_query($conexao, $sql);
	  
	$condicao = mysqli_num_rows($query);
	$classe="even ";
		
	while ($dados = mysqli_fetch_assoc($query)) {
		$id = $dados['id'];
        $cor = $dados['cor'];
        $rgb = $dados['rgb'];
    ?>
            <tr id="cor_<?=$id;?>">
                <td class="center"><?=$cor;?></td>
                <td class="center"><span class="status active" style="background-color:<?=$rgb;?> !important; border: #000 solid 1px;">&nbsp;</span></td>
                <td>
                    <div class="socials tex-center">
                        <a href="#" class="btn btn-circle btn-primary" data-toggle="modal" data-target="#editar_cor_<?=$id;?>" title="Editar"><i class="fa fa-pencil"></i></a> 
                        <a href="#" class="btn btn-circle btn-danger" data-toggle="modal" data-target="#remover_cor_<?=$id;?>" title="Excluir"><i class="fa fa-close"></i></a> 
                        <div class="modal fade" id="editar_cor_<?=$id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form method="POST" action="">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            <h4 class="modal-title">Editar Cor</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                  <div class="form-group" style="width: 100%;">
                                                    <label>Nome da Cor</label>
                                                    <input type="text" id="cor" name="cor" value="<?=$cor;?>" class="form-control" placeholder="Ex: Amarelo" style="width: 100%;">
                                                  </div>
                                                </div>
                                                <div class="col-md-12">
                                                  <div class="form-group">
                                                    <label>RGB da Cor</label>
                                                    <input type="color" class="form-control" id="rgb" name="rgb" value="<?=$rgb;?>" style="width: 100px; max-width: 100px; height: 55px;">
                                                  </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                                            <input type="hidden" name="id" value="<?=$id;?>">
                                            <button type="submit" name="editar" class="btn btn-success">Editar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="remover_cor_<?=$id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="POST" action="">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel3">REMOVER ITEM</h4>
                                        </div>
                                        <div class="modal-body">
                                            <h5>A exclusão deste item irá remover esta cor de todos produtos que a utilizam!</h5>
                                            <h5>Deseja continuar?</h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">NÃO</button>
                                            <input type="hidden" name="id" value="<?=$id;?>">
                                            <button type="submit" name="excluir" class="btn btn-success">SIM</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <?}mysqli_free_result($query);?>
          </tbody>
        </table>
      </div>
    </div>
<? } ?>

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
        $(document).ready(function() {
            $('#dataTables-userlist').DataTable({
                responsive: true,
                pageLength:10,
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
