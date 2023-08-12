<?php
  include_once "config.php";
  $pagina_titulo = "Atendimento";
  $pagina_referencia = "atendimento";
  $pagina_link = "atendimento";
	setlocale(LC_ALL, 'pt_BR');
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
if ($acao=="detalhes"){
?>
  <div class="row">
    <div class="col-md-12 header-wrapper">
        <h1 class="page-header"><?=mb_convert_case("$pagina_titulo", MB_CASE_TITLE, "UTF-8");?></h1>
        <p class="page-subtitle">Listagens dos itens no sistema.</p>
        <div class="pull-right">
  		    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#comentar" title="COMENTAR" onclick="novoComentario();">+ COMENTAR</a>
	    </div>
    </div>
  </div>
    <div class="container-fluid">
        <div class="row">
            <ul class="timeline">
                <?
                $comentarios = mysqli_query($conexao, "SELECT a.comentario, a.id_lead, a.resposta, a.nivel, a.data, a.hora, v.responsavel_nome FROM leads AS l RIGHT JOIN atendimento AS a ON (l.id=a.id_lead) LEFT JOIN vendedores AS v ON (l.id_vendedor=v.id) WHERE a.id_lead='$id' AND a.status='a' ORDER BY a.data DESC, a.hora DESC");
                $num_rows = mysqli_num_rows($comentarios);
                if ($num_rows>0){
                while($dados=mysqli_fetch_assoc($comentarios)){
                    $comentario = $dados['comentario'];
                    $id_lead = $dados['id_lead'];
                    $resposta = $dados['resposta'];
                    $nivel = $dados['nivel'];
                    $data = $dados['data'];
                    $hora = $dados['hora'];
                    
                    if ($nivel==10){
                        $classe = 'class="timeline-inverted"';
                        $cor = 'success';
                        $responsavel_nome = "ADM";
                    }else{
                        $classe = '';
                        $cor = '';
                        $responsavel_nome = $dados['responsavel_nome'];
                    }
                ?>
                    <li <?=$classe;?>>
                        <div class="timeline-badge <?=$cor;?>"><i class="fa fa-check"></i> </div>
                        <div class="timeline-panel">
                          <div class="timeline-heading">
                            <h4 class="timeline-title"><?=$responsavel_nome;?></h4>
                            <p><small class="text-muted"><i class="fa fa-clock-o"></i> <?=date("d/m/Y", strtotime($data));?> às <?=date("H:i", strtotime($hora));?></small> </p>
                          </div>
                          <div class="timeline-body">
                            <p><?=$comentario;?></p>
                          </div>
                        </div>
                    </li>
                <?}}else{
                    $comentarios = mysqli_query($conexao, "SELECT id FROM leads WHERE id='$id' AND status='a' LIMIT 1");
                    $dados = mysqli_fetch_assoc($comentarios);
                    $comentario = $dados['comentario'];
                    $id_lead = $dados['id'];
                ?>
                    <li id="sem_comentario">
                        <div class="timeline-badge"><i class="fa fa-check"></i> </div>
                        <div class="timeline-panel">
                          <div class="timeline-heading">
                            <h4 class="timeline-title">Este item ainda não possui comentários!</h4>
                          </div>
                          <div class="timeline-body">
                            <p>Faça ou aguarde novos comentários.</p>
                          </div>
                        </div>
                    </li>
                <?}?>
            </ul>
            <br>
            <br>
        </div>
      <!-- /.row --> 
    </div>
    <div class="modal fade" id="comentar" tabindex="-1" role="dialog" aria-labelledby="comentar" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <form method="POST" action="">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel3">FAZER UM COMENTÁRIO</h4>
                </div>
                <div class="modal-body">
                    <h5 class="modal-title">Deixe um comentário!</h5><br>
                        <input type="hidden" name="id" value="<?=$id;?>">
                        <input type="hidden" name="cadastrar" value="cadastrar">
                        <textarea name="comentario" id="comentario" style="width: 100%; height: 150px;"></textarea>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="Comentar();">COMENTAR</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog --> 
    </div>
    <!-- /.row --> 
    <script>
        function novoComentario(){
            $('#comentario').focus();
        }
        function Comentar(){
        var id_lead =  "<?=$id;?>";
        var id_vendedor =  "<?=$id_vendedor;?>";
        var nivel =  "<?=$usr_nivel;?>";
        var nome =  "<?=$_SESSION["usr_nome"];?>";
        var comentario =  document.getElementById("comentario").value;
        if(comentario!==""){
            $.ajax({
                type: "POST",
                url: "comentar.php",
                data: {
                    id_lead: id_lead,
                    nivel: nivel,
                    nome: nome,
                    comentario: comentario
                },
                dataType: "json",
                success: function (dataOK) {
                    if (dataOK.dados=='verdadeiro'){
                        var atual = $('.timeline').html();
                        $('.timeline').html('');
                        $('.timeline').append(dataOK.conteudo);
                        $('.timeline').append(atual);
                        $('#comentario').prop('value', '');
                        $('#sem_comentario').html('');
                        $('#comentar').modal('toggle');
                    }
                },
                error: function(xhr, textStatus, errorThrown){
                    var erro = JSON.parse(xhr.responseText);
                    console.log(erro.Message);
                }
            });
        }else{
            $('#comentario').attr("placeholder", "Escreva um comentário");
        }
    }
    </script>
<? }
if ($acao=="") {
?>
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
              <th>CORRETOR</th>
              <th>DATA</th>
              <th>STATUS</th>
              <th>AÇÕES</th>
            </tr>
          </thead>
          <tbody>
          <?
          $sql = "SELECT atendimento.id, atendimento.comentario, atendimento.id_lead, atendimento.data, atendimento.hora FROM $pagina_referencia INNER JOIN leads ON (atendimento.id_lead=leads.id) ORDER BY pedidos.id DESC";
          $query = mysqli_query($conexao, $sql);
          $classe="even ";

          while ($dados = mysqli_fetch_assoc($query)) {
            $id = $dados['id'];
            $data = $dados['data'];
            $situacao = $dados['situacao'];

            
            if ($classe=="odd") { $classe="even "; } else {$classe="odd"; }
        ?>
            <tr class="<?=$classe;?>">
              <td class="center"><?=$identificacao_pedido;?></td>
              <td>R$ <?=number_format($valor_pedido, 2, ',', '.');?></td>
              <td class="center"><?=$responsavel_nome;?></td>
              <td><?=utf8_encode(strftime('%d de %B de %Y', strtotime($data)));?></td>
              <td class="center"><?=$exibir_situacao;?></td>
              <td>
                  <div class="socials tex-center">
                    <a href="<?=$pagina_referencia;?>-detalhes_<?=$id_lead;?>" class="btn btn-circle btn-danger" data-toggle="tooltip" data-placement="top" title="Registro de comentários"><i class="fa fa-comments"></i></a>
                  </div>
              </td>
            </tr>
          <?}mysqli_free_result($query);?>
          </tbody>
        </table>
      </div>
    </div>
    <!-- /.row --> 
<? }?>
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