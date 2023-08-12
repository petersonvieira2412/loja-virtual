<?php
  include_once "config.php";
  $pagina_titulo = "fabricante";
  $pagina_referencia = "fabricante";
?>
<script type="text/javascript" >
	function formatar(mascara, documento){
	  var i = documento.value.length;
	  var saida = mascara.substring(0,1);
	  var texto = mascara.substring(i)
	  if (texto.substring(0,1) != saida){
				documento.value += texto.substring(0,1);
	  }
	}
    function limpa_formulario_cep() {
            document.getElementById('rua').value=("");
            document.getElementById('bairro').value=("");
            document.getElementById('cidade').value=("");
            document.getElementById('uf').value=("");
    }
    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('rua').value=(conteudo.logradouro);
            document.getElementById('bairro').value=(conteudo.bairro);
            document.getElementById('cidade').value=(conteudo.localidade);
            document.getElementById('uf').value=(conteudo.uf);
        } //end if.
        else {
            //CEP nĂŁo Encontrado.
            limpa_formulario_cep();
            alert("CEP não encontrado!");
        }
    }
        
    function pesquisacep(valor) {
        var cep = valor.replace(/\D/g, '');
        if (cep != "") {
            var validacep = /^[0-9]{8}$/;
            if(validacep.test(cep)) {
                document.getElementById('rua').value="pesquisando...";
                document.getElementById('bairro').value="pesquisando...";
                document.getElementById('cidade').value="pesquisando...";
                document.getElementById('uf').value="pesquisando...";
                var script = document.createElement('script');
                script.src = '//viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';
                document.body.appendChild(script);
            } 
            else {
                limpa_formulario_cep();
                alert("Formato de CEP inválido!");
            }
        } 
        else {
            limpa_formulario_cep();
        }
    };
	
	function mascaraMutuario(o, f) {
        v_obj = o
        v_fun = f
        setTimeout('execmascara()', 1)
    }
	
    function execmascara() {
		v_obj.value = v_fun(v_obj.value)
	}
	function cpfCnpj(v) {
		v = v.replace(/\D/g, "")
		if (v.length <= 14) { //CPF
			v = v.replace(/(\d{3})(\d)/, "$1.$2")
			v = v.replace(/(\d{3})(\d)/, "$1.$2")
			v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2")
		} else { //CNPJ
			v = v.replace(/^(\d{2})(\d)/, "$1.$2")
			v = v.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3")
			v = v.replace(/\.(\d{3})(\d)/, ".$1/$2")
			v = v.replace(/(\d{4})(\d)/, "$1-$2")
		}
		return v
	}
	function mascara(o,f){
		v_obj=o
		v_fun=f
		setTimeout("execmascara()",1)
	}
	function execmascara(){
		v_obj.value=v_fun(v_obj.value)
	}
	function soNumeros(v){
		return v.replace(/\D/g,"")
	}
	function telefone(v){
		v=v.replace(/\D/g,"")
		v=v.replace(/^(\d\d)(\d)/g,"($1)$2")
		v=v.replace(/(\d{4})(\d)/,"$1-$2")
		return v
	}
	function data(v) {
		v=v.replace(/\D/g,"")
		v=v.replace(/^(\d{2})(\d)/, "$1/$2")
		v=v.replace(/(\d{2})(\d)/,"$1/$2")
		v=v.replace(/(\d{4})(\d)/,"$1")
		v=v.replace(/(\d{9})(\d)/,"")
		return v
	}
	function cpf(v){
		v=v.replace(/\D/g,"")
		v=v.replace(/(\d{3})(\d)/,"$1.$2")
		v=v.replace(/(\d{3})(\d)/,"$1.$2")
		v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2")
		return v
	}
	function cep(v){
		v=v.replace(/\D/g,"")
		v=v.replace(/^(\d{5})(\d)/,"$1-$2")
		return v
	}
	function cnpj(v){
		v=v.replace(/\D/g,"")
		v=v.replace(/^(\d{2})(\d)/,"$1.$2")
		v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3")
		v=v.replace(/\.(\d{3})(\d)/,".$1/$2")
		v=v.replace(/(\d{4})(\d)/,"$1-$2")
		return v
	}
	function cpfcnpj(v) {
		if (v_obj.value.length <= 14) {
			v=v.replace(/\D/g,"")
			v=v.replace(/(\d{3})(\d)/,"$1.$2")
			v=v.replace(/(\d{3})(\d)/,"$1.$2")
			v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2")
			return v
		} else {
			v=v.replace(/\D/g,"")
			v=v.replace(/^(\d{2})(\d)/,"$1.$2")
			v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3")
			v=v.replace(/\.(\d{3})(\d)/,".$1/$2")
			v=v.replace(/(\d{4})(\d)/,"$1-$2")
			return v
		}
		return null;
	}
</script>
<?
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
	  
	  //recupera informações sociais
		$titulo = trim(addslashes(htmlspecialchars($_POST['titulo'])));
		
		$temU = mysqli_num_rows(mysqli_query($conexao,"SELECT id FROM fabricante WHERE titulo='".$titulo."' AND status<>'d'"));
		
		if($temU>0){
			echo "<script>alert('Este nome de fabricante já existe.');</script>";
			echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia-cadastrar'>";
		}else{
		
			$dadosC = mysqli_fetch_array(mysqli_query($conexao,"SELECT * FROM fabricante WHERE id='".$titulo."'"));
			
			mysqli_query($conexao,"INSERT INTO fabricante (titulo, status) VALUES ('".$titulo."', 'a')");
			echo "<script>alert('Cadastrado com sucesso!');</script>";
			echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia-cadastrar'>";
		}
  }
  if ($acao=="cadastrar") { ?>
    <div class="row">
      <div class="col-md-12  header-wrapper" >
        <h1 class="page-header"><?=mb_convert_case("$pagina_titulo", MB_CASE_TITLE, "UTF-8");?> - Cadastrar</h1>
        <p class="page-subtitle">Para cadastrar um novo Fabricante, preencha os dados abaixo.</p>
      </div>
    </div>
    
    <form method="post" action="" enctype="multipart/form-data">
      <div class="row ">
        <div class="col-lg-12 ">
          <div class="panel panel-default ">
            <div class="panel-body ">
              <h3>Fabricantes</h3>
              <hr>
              <br>
              <div class="col-md-12">
                <div class="form-group">
                  <label >NOME DO FABRICANTE</label>
                  <input class="form-control" required type="text" placeholder="" name="titulo">
                </div>
              </div>
			  
			  <div class="col-md-12"> </div>
              
              <div class="col-md-12">
                <div class="form-group">
                  <label></label>
                  <input name="acao" id="acao" value="gravar" type="hidden">
                  <button type="submit" name="enviar" value="enviar" class="btn btn-success" style="float:right;"><i class="fa fa-check"></i> Adicionar </button>
                </div>
              </div>
              
              <div class="col-md-12"> </div>
			  
            </div>
          </div>
        </div>
        <!-- /.col-lg-12 -->
      </div>      
      <!-- /.row -->
    </form>
    <? }
  if ($acao=="excluir") { 
        $data_excluir = date('Y-m-d');
        $hora_excluir = date('H:i:s');
	  	$ip = $_SERVER['REMOTE_ADDR'];
		$endereco_ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	  	$update = "UPDATE fabricante SET status='d' WHERE id='".$id."' "  or die(mysqli_error());
		if (!mysqli_query($conexao, $update)) {  
			die('Error: '.mysqli_error($conexao)); 
		} else {
			echo "<script>alert('Removido com sucesso!');</script>";
			echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";
		}
		
  }
  if ($acao=="gravar_editar") { 

	  	//recupera POST
	  	$id = (int)$_POST['id'];
		$titulo = trim(addslashes(htmlspecialchars($_POST['titulo'])));
	  	$status = trim(addslashes(htmlspecialchars($_POST['status'])));
		
				
		$editar = "UPDATE fabricante SET status='$status', titulo='$titulo' WHERE id='$id'" or die(mysql_error());
		if (!mysqli_query($conexao, $editar)) {  
			die('Erro: '.mysqli_error($conexao)); 
		} else {
			
			echo "<script>alert('Atualizado com sucesso!');</script>";
			echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";
			exit();
		}
		
  }
  if ($acao=="editar") { ?>
	<?
	$sql = mysqli_query($conexao,"SELECT * FROM fabricante WHERE id='$id'") or die(mysqli_error($conexao));
	$dados = mysqli_fetch_array($sql);	
	?>
    <div class="row">
      <div class="col-md-12  header-wrapper" >
        <h1 class="page-header"><?=mb_convert_case("$pagina_titulo", MB_CASE_TITLE, "UTF-8");?> Editar</h1>
        <p class="page-subtitle">Para alterar este item, preencha os dados abaixo.</p>
      </div>
    </div>
	<form method="post" action="" enctype="multipart/form-data">
      <div class="row ">
        <div class="col-lg-12 ">
          <div class="panel panel-default ">
            <div class="panel-body ">
              <h3>Dados de Acesso</h3>
              <p>Preencha os campos abaixo.</p>
              <hr>
              <br>
              <div class="col-md-6">
                <div class="form-group">
                  <label >FABRICANTE</label>
                  <input class="form-control" readonly type="text" placeholder="" value="<?=$dados['titulo']?>" style="background:#fff;">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label >NOVO FABRICANTE <i>*Deixar em branco para não alterar</i></label>
                  <input class="form-control" type="text" placeholder="" name="titulo" value="">
                </div>
              </div>
			  
			  <div class="col-md-12"> </div>
              
			  <div class="col-md-12">
                <div class="form-group">
                  <label >SITUAÇÃO</label>
                  <select class="form-control" name="status">
                    <option value="a" <?=($dados['ativo']=='a')?'selected':''?>>Ativo</option>
                    <option value="i" <?=($dados['ativo']=='i')?'selected':''?>>Inativo</option>
                  </select>
                </div>
              </div>
			  
			  <div class="col-md-12"> </div>
			  
              <div class="col-md-12">
                <div class="form-group">
                  <label></label>
                  <input name="acao" id="acao" value="gravar_editar" type="hidden">
                  <input name="id" id="id" value="<?=$dados['id']?>" type="hidden">
                  <button type="submit" name="enviar" value="enviar" class="btn btn-success" style="float:right;"><i class="fa fa-check"></i> ATUALIZAR </button>
                </div>
              </div>
              
              <div class="col-md-12"> </div>
			  
            </div>
          </div>
        </div>
        <!-- /.col-lg-12 -->
      </div>
      <!-- /.row -->
    </form>
<? }
if ($acao=="") { ?>
  <div class="row">
    <div class="col-md-12  header-wrapper" >
        <h1 class="page-header"><?=mb_convert_case("$pagina_titulo", MB_CASE_TITLE, "UTF-8");?> <a href="<?=$pagina_referencia?>-cadastrar" class="btn btn-success">CADASTRAR NOVO</a></h1>
        <p class="page-subtitle">Listagens dos fabricantes cadastrados no sistema.</p>
    </div>
  </div>
    <div class="row">
      <div class="col-md-12">
        <table class="table table-bordered table-hover" id="dataTables-userlist">
         <thead>
            <tr>
              <th>ID</th>
              <th>FABRICANTE</th>
			        <th>SITUAÇÃO</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
	<?
	$sql = "SELECT * FROM fabricante WHERE status='a' ORDER BY id ASC";
	$query = mysqli_query($conexao, $sql);
	  
	$condicao = mysqli_num_rows($query);
	$classe="even ";
		
	while ($dados = mysqli_fetch_assoc($query)) {
		$id = $dados['id'];
		$titulo = $dados['titulo'];
		$status = $dados['status'];
		
?>
            <tr class="<?=$classe;?>">
              <td class="center"><?=$id;?></td>
              <td><?=$titulo;?></td>
			  <td><?=($status=='a')?'<label class="badge" style="background:green">ativo</label>':'<label class="badge">inativo</label>';?></td>
              <td >
            	<div class="socials tex-center"> 
            		<a href="<?=$pagina_referencia;?>-editar_<?=$id;?>" class="btn btn-circle btn-primary "><i class="fa fa-pencil"></i></a> 
            		<a href="#" class="btn btn-circle btn-danger " data-toggle="modal" data-target="#myModal<?=$id;?>"><i class="fa fa-close"></i></a> 
            		<div class="modal fade" id="myModal<?=$id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-lg">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title" id="myModalLabel3">REMOVER ITEM</h4>
						  </div>
						  <div class="modal-body">Confirma a exclusão deste item? </div>
						  <div class="modal-footer">
						  	<a href="<?=$pagina_referencia;?>-excluir_<?=$id;?>" class="btn btn-danger" role="button" aria-pressed="true">SIM</a>
							<button type="button" class="btn btn-primary" data-dismiss="modal">NÃO</button>
						  </div>
						</div>
						<!-- /.modal-content --> 
					  </div>
					  <!-- /.modal-dialog --> 
					</div>
            	</div>
              </td>
            </tr>
<?
	}
	?>   
         
          </tbody>
        </table>
      </div>
    </div>
    <!-- /.row --> 
<? } ?>
<!-- /#wrapper -->
<!-- jQuery --> 
<script src="vendor/jquery/jquery.min.js"></script> 
<!-- Bootstrap Core JavaScript --> 
<script src="vendor/bootstrap/js/bootstrap.min.js"></script> 
<!-- DataTables JavaScript --> 
<script src="vendor/datatables/js/jquery.dataTables.min.js"></script> 
<script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script> 
<script src="vendor/datatables-responsive/dataTables.responsive.js"></script>
<script src="https://www.pizzariadoconde.com.br/atendimento/assets/plugins/jquery-mask/jquery.mask.min.js"></script>
<!-- Custom Theme JavaScript --> 
<script src="js/adminnine.js"></script> 
<script>
        $(document).ready(function() {
			
			$('.telefone').mask('(00) 0000-0000', {selectOnFocus: true});
		
		$('.celular').mask('(00) 00000-0000', {selectOnFocus: true});
			
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
