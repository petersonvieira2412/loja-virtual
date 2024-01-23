<?php
  include_once "config.php";
  $pagina_titulo = "banners";
  $pagina_referencia = "banners";

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

		$data = trim(addslashes(htmlspecialchars($_POST['data'])));
		$hora = trim(addslashes(htmlspecialchars($_POST['hora'])));

		$titulo = trim(addslashes(htmlspecialchars($_POST['titulo'])));
	    $link = trim(addslashes($_POST['link']));
		
        $data_cadastro = date('Y-m-d');
        $hora_cadastro = date('H:i:s');
	  	$ip = $_SERVER['REMOTE_ADDR'];
		$ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);

		$insere = "INSERT INTO $pagina_referencia (img, titulo, link, data_postagem, hora_postagem, ip, status) VALUES ('sem_imagem.jpg', '$titulo', '$link', '$data', '$hora', '$ip', 'a')" or die(mysqli_error());    

		if (!mysqli_query($conexao, $insere)) {  
			die('Erro: '.mysqli_error($conexao)); 
		} else {
					
			if (file_exists($_FILES['banner']['tmp_name']) || is_uploaded_file($_FILES['banner']['tmp_name'])) {
				$ultimo_id = mysqli_insert_id($conexao); 

				$nome = UrlAmigavel($titulo);

				if ($nome=="") { $nome=$pagina_referencia; }

				$aleatorio = rand(1,999999);

				$nome = "banners-".$ultimo_id."-".$nome."-".$aleatorio;

				$set_img_path = "../assets/img/banners";
				$imgarray = array("image/pjpeg", "image/jpeg", "image/gif", "image/png", "image/x-png");

				if (!$_FILES['banner']['size'])
				{
					echo "<p>Arquivo de banner recusado devido ao tamanho do mesmo.</p>";
					exit;

				}		
				if (!in_array($_FILES['banner']['type'],$imgarray))
				{
					echo "<p>É somente aceito arquivos de imagens (GIF, JPG e PNG).</p>";
					exit;
				}		

				if ($_FILES['banner']['size']>$set_max_bytes_allowed)
				{
					echo "<p>Tamanho do Arquivo é maior que o limite de:</p>". $set_max_bytes_allowed / 1000 ."Kb.";
					exit;
				}		

				if ($_FILES['banner']['type']=="image/gif")
				{
						$ext = ".gif";
				}
				elseif ($_FILES['banner']['type']=="image/jpeg" || $_FILES['banner']['type']=="image/pjpeg")
				{
						$ext = ".jpg";

				}
				elseif ($_FILES['banner']['type']=="image/png")
				{
						$ext = ".png";
				}

				$img = $nome.$ext;
				move_uploaded_file($_FILES['banner']['tmp_name'], "$set_img_path/$img");

				chmod ("$set_img_path/$img", 0755);

				$update = "UPDATE $pagina_referencia SET img='".$img."' WHERE id='".$ultimo_id."' "  or die(mysqli_error());

				if (!mysqli_query($conexao, $update)) { die('Erro: '.mysqli_error($conexao)); }
			}
			
			echo "<script>alert('Cadastrado com sucesso!');</script>";
			echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia-cadastrar'>";

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
            <div class="panel-body">
              <div class="col-md-12" >
                <h3>Informações Descritivas</h3>
                <p>Atualize as informações descritivas deste item.</p>
              </div>
              <hr>
              <br>
              <div class="col-md-4">
                <div class="form-group">
                  <label >FOTO banner</label>
                  <input class="form-control" name="banner" id="banner" type="file" accept="image/*">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label >DATA</label>
                  <input name="data" type="date" required="required" autofocus class="form-control" id="data" placeholder="" maxlength="255" value="<?=date('Y-m-d');?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label >HORA</label>
                  <input name="hora" type="time" required="required" class="form-control" id="hora" placeholder="" value="<?=date('H:i:s');?>">
                </div>
              </div>              
              <div class="col-md-12"> </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label >TÍTULO</label>
                  <input name="titulo" type="url" class="form-control" id="titulo" placeholder="">
                </div>
              </div>
              <div class="col-md-8">
                <div class="form-group">
                  <label >LINK</label>
                  <input name="link" type="url" class="form-control" id="link" placeholder="" >
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
      </div>

    </form>

<? }

  if ($acao=="excluir") { 

        $data_excluir = date('Y-m-d');
        $hora_excluir = date('H:i:s');
	  	$ip = $_SERVER['REMOTE_ADDR'];
		$ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
    
  $status = trim(addslashes(htmlspecialchars($_POST['status'])));

	  	$update = "UPDATE $pagina_referencia SET ip='$ip', status='d' WHERE id='".$id."' "  or die(mysqli_error());

		if (!mysqli_query($conexao, $update)) {  
			die('Error: '.mysqli_error($conexao)); 
		} else {
			
			echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";

		}
		
  }

  if ($acao=="gravar_editar") { 

		$id = (int)$_POST['id'];
		$data = trim(addslashes(htmlspecialchars($_POST['data'])));
		$hora = trim(addslashes(htmlspecialchars($_POST['hora'])));
    
    $status = trim(addslashes(htmlspecialchars($_POST['status'])));

	    $link = trim(addslashes($_POST['link']));
	  	$titulo = strtolower(trim(addslashes(htmlspecialchars($_POST['titulo']))));
        $data_editar = date('Y-m-d');
        $hora_editar = date('H:i:s');
	  	$ip = $_SERVER['REMOTE_ADDR'];
		$ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);

	  	$update = "UPDATE $pagina_referencia SET titulo='$titulo', link='$link', data_postagem='$data', hora_postagem='$hora', ip='$ip', status='".$status."' WHERE id='".$id."' "  or die(mysqli_error());
	  	if (file_exists($_FILES['banner']['tmp_name']) || is_uploaded_file($_FILES['banner']['tmp_name'])) {
				$ultimo_id = mysqli_insert_id($conexao); 

				$nome = UrlAmigavel($titulo);

				if ($nome=="") { $nome=$pagina_referencia; }

				$aleatorio = rand(1,999999);

				$nome = "banner-".$ultimo_id."-".$nome."-".$aleatorio;

				$set_img_path = "../assets/img/banners";
				$imgarray = array("image/pjpeg", "image/jpeg", "image/gif", "image/png", "image/x-png");

				if (!$_FILES['banner']['size'])
				{
					echo "<p>Arquivo de banner recusado devido ao tamanho do mesmo.</p>";
					exit;

				}		
				if (!in_array($_FILES['banner']['type'],$imgarray))
				{
					echo "<p>É somente aceito arquivos de imagens (GIF, JPG e PNG).</p>";
					exit;
				}		

				if ($_FILES['banner']['size']>$set_max_bytes_allowed)
				{
					echo "<p>Tamanho do Arquivo é maior que o limite de:</p>". $set_max_bytes_allowed / 1000 ."Kb.";
					exit;
				}		

				if ($_FILES['banner']['type']=="image/gif")
				{
						$ext = ".gif";
				}
				elseif ($_FILES['banner']['type']=="image/jpeg" || $_FILES['banner']['type']=="image/pjpeg")
				{
						$ext = ".jpg";

				}
				elseif ($_FILES['banner']['type']=="image/png")
				{
						$ext = ".png";
				}

				$img = $nome.$ext;
				move_uploaded_file($_FILES['banner']['tmp_name'], "$set_img_path/$img");

				chmod ("$set_img_path/$img", 0755);

				$update = "UPDATE $pagina_referencia SET img='".$img."', titulo='".$titulo."', link='".$link."', status='".$status."' WHERE id='".$id."' "  or die(mysqli_error());

				if (!mysqli_query($conexao, $update)) { die('Erro: '.mysqli_error($conexao)); }
			}

		if (!mysqli_query($conexao, $update)) {  
			die('Error: '.mysqli_error($conexao)); 
		} else {
			
			echo "<script>alert('Atualizado com sucesso!');</script>";
			echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";

		}
		
  }

  if ($acao=="editar") { ?>
	<?
	$sql = "SELECT * FROM $pagina_referencia WHERE id='$id'";
	$query = mysqli_query($conexao, $sql);
	  
	$condicao = mysqli_num_rows($query);
	
	while ($dados = mysqli_fetch_assoc($query)) {
		$id = $dados['id'];
		$img = '../assets/img/banners/'.$dados['img'];
		$link = $dados['link'];
		$titulo = $dados['titulo'];
		
	}
	mysqli_free_result($query);
	?>
    <div class="row">
      <div class="col-md-12  header-wrapper" >
        <h1 class="page-header"><?=mb_convert_case("$pagina_titulo", MB_CASE_TITLE, "UTF-8");?> Editar</h1>
        <p class="page-subtitle">Para alterar este item, preencha os dados abaixo.</p>
      </div>
    </div>

	<form method="post" action="" enctype="multipart/form-data">
      <div class="row">
        <div class="col-lg-12 ">
          <div class="panel panel-default ">
            <div class="panel-body">

			<? if ($condicao<=0) { ?>
              <div class="col-md-12"> 
                <div class="form-group">
              	  <h3>NÃO LOCALIZAMOS ESTE REGISTRO</h3>
				  <p>Favor entrar em contato com o seu Administrador</p>
                </div>
              </div>              
            <? } else { ?>


              <div class="col-md-12" >
				  <h3>Informações Descritivas</h3>
				  <p>Atualize as informações descritivas deste item.</p>
			  </div>

              <hr><br>
              <div class="col-md-6"> 
                <div class="form-group">
              	  <img src="<?=$img;?>" style="max-width: 100%; max-height: 200px;" >
                </div>
              </div>              
  			<div class="col-md-6">
                <div class="form-group">
                  <label >NOVA IMAGEM</label>
                  <input name="banner" type="file" autofocus class="form-control" placeholder="" maxlength="255">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label >TÍTULO</label>
                  <input name="titulo" type="text" autofocus class="form-control" id="titulo" placeholder="" maxlength="255" value="<?=$titulo;?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label >LINK (*Nome da página ao clicar)</label>
                  <input name="link" type="text" class="form-control" id="link" placeholder="" value="<?=$link;?>">
                </div>
              </div>
              <div class="col-md-12"> 
                <div class="form-group">
                  <label >STATUS</label>
                  <select class="form-control" name="status">
                      <option value='a' >Ativo</option>
                      <option value='d' >Desativado</option>
                    </select>
                </div>
              </div>
              <div class="col-md-12"> </div>
               
              <div class="col-md-12"> 
                <div class="form-group">
                  <label></label>
                  <input name="acao" id="acao" value="gravar_editar" type="hidden">
                  <input name="id" id="id" value="<?=$id;?>" type="hidden">
                  <button type="submit" name="enviar" value="enviar" class="btn btn-success" style="float:right;"><i class="fa fa-check"></i> Atualizar </button>
                </div>
              </div>
              
              <div class="col-md-12"> </div>
			<? } ?>
            </div>
          </div>
        </div>
      </div>
      
	</form>
<? }

  if ($acao=="gravar_imagem") { 

	$nome = UrlAmigavel($titulo);
	  
	if ($nome=="") { $nome="banner"; }

	$aleatorio = rand(1,999999);

	if (file_exists($_FILES['banner']['tmp_name']) || is_uploaded_file($_FILES['banner']['tmp_name'])) {

		$nome_final = "banners-".$id."-".$nome."-".$aleatorio;

		$set_img_path = "../assets/img/banners";
		$imgarray = array("image/pjpeg", "image/jpeg", "image/gif", "image/png", "image/x-png");

		if (!$_FILES['banner']['size'])
		{
			echo "<p>Arquivo recusado devido ao tamanho do mesmo.</p>";
			exit;

		}		
		if (!in_array($_FILES['banner']['type'],$imgarray))
		{
			echo "<p>É somente aceito arquivos de imagens (GIF, JPG e PNG).</p>";
			exit;
		}		

		if ($_FILES['banner']['size']>$set_max_bytes_allowed)
		{
			echo "<p>Tamanho do Arquivo é maior que o limite de:</p>". $set_max_bytes_allowed / 1000 ."Kb.";
			exit;
		}		

		if ($_FILES['banner']['type']=="image/gif")
		{
				$ext = ".gif";
		}
		elseif ($_FILES['banner']['type']=="image/jpeg" || $_FILES['banner']['type']=="image/pjpeg")
		{
				$ext = ".jpg";

		}
		elseif ($_FILES['banner']['type']=="image/png")
		{
				$ext = ".png";
		}

		$img = $nome_final.$ext;
		move_uploaded_file($_FILES['banner']['tmp_name'], "$set_img_path/$img");

		chmod ("$set_img_path/$img", 0755);

		$data_editar = date('Y-m-d');
        $hora_editar = date('H:i:s');
	  	$ip = $_SERVER['REMOTE_ADDR'];
		$ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		
		$update = "UPDATE $pagina_referencia SET img='".$img."', ip='$ip', WHERE id='".$id."' "  or die(mysqli_error());

		if (!mysqli_query($conexao, $update)) { die('Erro: '.mysqli_error($conexao)); }
	}

	echo "<script>alert('Imagem atualizada com sucesso!');</script>";
	echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";

	}
		

  if ($acao=="imagem") { 

	$sql = "SELECT * FROM $pagina_referencia WHERE id='$id'";
	$query = mysqli_query($conexao, $sql);
	  
	$condicao = mysqli_num_rows($query);
	
	while ($dados = mysqli_fetch_assoc($query)) {
		$id = $dados['id'];
		$img = $dados['img'];
		$link = $dados['link'];
		$status = $dados['status'];

		if(file_exists("../assets/img/banners/$img")){ } else{ $img = "sem_imagem.jpg"; }
		
	}
	mysqli_free_result($query);
	?>
   
    <div class="row">
      <div class="col-md-12  header-wrapper" >
        <h1 class="page-header"><?=mb_convert_case("$pagina_titulo", MB_CASE_TITLE, "UTF-8");?> Alteração de Imagem</h1>
        <p class="page-subtitle">Para alterar as imagens da categoria basta selecionar as novas imagens</p>
      </div>
    </div>

    <form method="post" action="" enctype="multipart/form-data">
      <div class="row">
        <div class="col-lg-12 ">
          <div class="panel panel-default ">
            <div class="panel-body">
			<? if ($condicao<=0) { ?>
              <div class="col-md-12"> 
                <div class="form-group">
              	  <h3>NÃO LOCALIZAMOS ESTE REGISTRO</h3>
				  <p>Favor entrar em contato com o seu Administrador</p>
                </div>
              </div>              
            <? } else { ?>             
              <div class="col-md-12" >
                <h3>Publicação de Novas Imagens</h3>
                <p>Selecione apenas as imagens que deseja alterar.</p>
              </div>
              <hr>
              <br>
              <br>
              <div class="col-md-12"> </div>
				<p>&nbsp;</p>
              <div class="col-md-12"> </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label >IMAGEM NOVA</label>
                  <input class="form-control" name="banner" id="banner" type="file" accept="image/*">
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="form-group">
                  <label></label>
                  <input name="acao" id="acao" value="gravar_imagem" type="hidden">
                  <input name="id" id="id" value="<?=$id;?>" type="hidden">
                  <button type="submit" name="enviar" value="enviar" class="btn btn-success" style="float:right;"><i class="fa fa-check"></i> Atualizar Imagem </button>
                </div>
              </div>

              <br>
              <br>

              <div class="col-md-12"> </div>              

              <div class="col-md-12">
                <div class="form-group">
                  <br>
                  <label >IMAGEM ATUAL</label><br>
                  <img src="../assets/img/banners/<?=$img;?>" style="max-width: 100%; max-height: 200px;" >
                </div>
              </div>


              <? } ?>
            </div>
          </div>
        </div>
      </div>

    </form>

<? }

if ($acao=="") { ?>

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
              <th>BANNER</th>
              <th>TÍTULO</th>
              <th>LINK</th>
              <th>SITUAÇÃO</th>
              <th>AÇÕES</th>
            </tr>
          </thead>
          <tbody>
	<?
	$sql = "SELECT * FROM $pagina_referencia WHERE tipo='lateral'";
	$query = mysqli_query($conexao, $sql);
	  
	$condicao = mysqli_num_rows($query);
	$classe="even ";
		
	while ($dados = mysqli_fetch_assoc($query)) {
		$id = $dados['id'];
		$img = $dados['img'];
		$titulo  = $dados['titulo'];
		$link  = $dados['link'];
		$status  = $dados['status'];

		if(file_exists("../assets/img/banners/$img")){ } else{ $img = "sem_imagem.jpg"; }

		if ($classe=="odd") { $classe="even "; } else {$classe="odd"; }
?>
            <tr class="<?=$classe;?>">
              <td class="center"><?=$id;?></td>
              <td class="center"><img src="../assets/img/banners/<?=$img;?>" alt="<?=$titulo;?>" title="<?=$titulo;?>" style="max-width: 300px; max-height: 150px;"></td>
              <td><?=$titulo;?></td>
              <td><?=$link;?></td>
              <td><?=($status=='a')?'<label class="badge" style="background:green">ativo</label>':'<label class="badge">desativado</label>';?></td>
              <td >
            	<div class="socials tex-center"> 
            		<a href="<?=$pagina_referencia;?>-editar_<?=$id;?>" class="btn btn-circle btn-primary "><i class="fa fa-pencil"></i></a>
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
