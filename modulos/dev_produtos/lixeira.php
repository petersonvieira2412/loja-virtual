<?php
    include_once "config.php";
    $pagina_titulo = "lixeira";
    $pagina_referencia = "produtos";
    $pagina_referencia_url = "lixeira";

    setlocale(LC_ALL, 'en_US.UTF8');

    if ($acao=="excluir") { 

	  	$update = "UPDATE $pagina_referencia SET ip='".$_SERVER['REMOTE_ADDR']."', endereco_ip='".gethostbyaddr($_SERVER['REMOTE_ADDR'])."', data_excluir='".date('Y-m-d')."', hora_excluir='".date('H:i:s')."', status='e' WHERE id='".$id."' "  or die(mysqli_error());

		if (!mysqli_query($conexao, $update)) {  
			die('Erro: '.mysqli_error($conexao)); 
		} else {
			echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia_url'>";
        }
            
    } elseif ($acao=="ativar") { 

	  	$ip = $_SERVER['REMOTE_ADDR'];
		$endereco_ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	  	$update = "UPDATE $pagina_referencia SET ip='".$_SERVER['REMOTE_ADDR']."', endereco_ip='".gethostbyaddr($_SERVER['REMOTE_ADDR'])."', data_excluir='".date('Y-m-d')."', hora_excluir='".date('H:i:s')."', status='a' WHERE id='".$id."' "  or die(mysqli_error());

		if (!mysqli_query($conexao, $update)) {  
			die('Erro: '.mysqli_error($conexao)); 
		} else {
			echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia_url'>";
		}

    } else { ?>

  <div class="row">
    <div class="col-md-12  header-wrapper" >
        <h1 class="page-header"><?=mb_convert_case("$pagina_titulo", MB_CASE_TITLE, "UTF-8");?></h1>
        <p class="page-subtitle">Listagens dos itens cadastrados no sistema.</p>
    </div>
  </div>
    <div class="row">
      <div class="col-md-12">
        <table class="table table-bordered table-hover" id="dataTables-userlist">
         <thead>
            <tr>
              <th>ID</th>
              <th>FOTO</th>
              <th>PRODUTO</th>
              <th>CATEGORIA</th>
              <th>PREÇO</th>
              <th>AÇÕES</th>
            </tr>
          </thead>
          <tbody>
  <?
  $sql = "SELECT id, categoria FROM categorias ORDER BY categoria ASC";
  $query = mysqli_query($conexao, $sql);
      
  while ($dados = mysqli_fetch_assoc($query)) {
    $id = $dados['id'];
    $categorias[$id] = $dados['categoria'];
  }
  mysqli_free_result($query);
        
  $sql = "SELECT * FROM $pagina_referencia WHERE status='d' ORDER BY id DESC";
  $query = mysqli_query($conexao, $sql);
    
  $condicao = mysqli_num_rows($query);
  $classe="even ";
    
  while ($dados = mysqli_fetch_assoc($query)) {
    $id = $dados['id'];
    $img = $dados['img'];
    $categoria = $dados['categoria'];
    $produto = $dados['produto'];
    $sub_produto = $dados['sub_produto'];
    $descricao = $dados['descricao'];
    $qtd = $dados['qtd'];
    $qtd_vendido = $dados['qtd_vendido'];
    $qtd_visto = $dados['qtd_visto'];
    $preco = $dados['preco'];
    $por = $dados['por'];
    $forma = $dados['forma'];
    $prazo = $dados['prazo'];
    $regiao = $dados['regiao'];
    $promocao = $dados['promocao'];
    $peso = $dados['peso'];
    $frete = $dados['frete'];
    $pronta = $dados['pronta'];
    $faturamento = $dados['faturamento'];
    $destaque = $dados['destaque'];
    $fabricante = $dados['fabricante'];
    $ofertas = $dados['ofertas'];
    
    if ($dados['img']=='') {
        $imagem = '../assets/img/'.$pagina_referencia.'/sem_foto.jpg';
    } elseif(file_exists('../assets/img/'.$pagina_referencia.'/'.$img.'')){
        $imagem = '../assets/img/'.$pagina_referencia.'/'.$img.'';
    } else {
        $imagem = "../assets/img/$pagina_referencia/sem_foto.jpg";
    } 
    if ($classe=="odd") { $classe="even "; } else {$classe="odd"; }
?>
            <tr class="<?=$classe;?>">
              <td class="center"><?=$id;?></td>
              <td class="center"><img src="<?=$imagem;?>" alt="<?=$categoria;?>" title="<?=$categoria;?>" class="gridpic"></td>
              <td><?=$produto;?></td>
              <td><? if (isset($categorias[$categoria])) { echo $categorias[$categoria]; } else { echo "<span class='status btn-danger'>Não Localizada</span>"; };?></td>
              <td class="center">R$ <? if ($por!='0.00') { echo $por; } else { echo $preco; };?></td>
              <td >
                  <div class="socials tex-center">                     
                    <a href="#" class="btn btn-circle btn-success " data-toggle="modal" data-target="#myModalrecuperar<?=$id;?>"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></a> 
                    <div class="modal fade" id="myModalrecuperar<?=$id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="myModalLabel3">RECUPERAR ITEM</h4>
                                </div>
                                <div class="modal-body">Deseja restaurar deste item? </div>
                                <div class="modal-footer">
                                    <a href="<?=$pagina_referencia_url;?>-ativar-<?=$id;?>" class="btn btn-danger" role="button" aria-pressed="true">SIM</a>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">NÃO</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="btn btn-circle btn-danger " data-toggle="modal" data-target="#myModal<?=$id;?>"><i class="fa fa-trash"></i></a> 
                    <div class="modal fade" id="myModal<?=$id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="myModalLabel3">REMOVER ITEM</h4>
                                </div>
                                <div class="modal-body">Confirma a exclusão deste item? </div>
                                <div class="modal-footer">
                                    <a href="<?=$pagina_referencia_url;?>-excluir-<?=$id;?>" class="btn btn-danger" role="button" aria-pressed="true">SIM</a>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">NÃO</button>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
              </td>
            </tr>
<?
  }
  mysqli_free_result($query);
  ?>   
         
          </tbody>
        </table>
      </div>
    </div>
    <!-- /.row --> 
<? } ?>
<!-- /#wrapper -->
<!-- jQuery --> 
<script src="../lightbox/js/jquery-1.7.2.min.js"></script>
<script src="../lightbox/js/lightbox.js"></script>
<link href="../lightbox/css/lightbox.css" rel="stylesheet" />
<script type="text/javascript">
    $(function () {
        $('#gallery a').lightBox();
    });
</script>
<!-- Custom Theme JavaScript --> 
<script src="https://cdn.tiny.cloud/1/7szvkexj6o20oxe9z5jr3j2x4yxckq26idds4hg2uc76nwfs/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
      CKEDITOR.replace( 'descricao' );
</script>
<!-- Include external JS libs. -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
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
        $(document).ready(function() {
			
			tinymce.init({
				
				selector: '.tinymce',
				height: 200,
				menubar: false,
				language: 'pt_BR',
				plugins: [
					'link'
				],

				toolbar: 'bold italic underline | bullist numlist | link',

			});
			
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
