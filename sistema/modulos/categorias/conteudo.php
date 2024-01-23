<?php
  include_once "config.php";
  $pagina_titulo = "categorias";
  $pagina_referencia = "categorias";

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
	function comprimirImagem($diretorio, $diretorio_final, $qualidade) {
        $info = getimagesize($diretorio);
        if ($info['mime'] == 'image/jpeg') {
            $image = imagecreatefromjpeg($diretorio);
        } elseif ($info['mime'] == 'image/gif') {
            $image = imagecreatefrompng($diretorio);
        } elseif ($info['mime'] == 'image/png') {
            $image = imagecreatefrompng($diretorio);
        }
        imagejpeg($image, $diretorio_final, $qualidade);
        return $diretorio_final;
    }

  if ($acao=="gravar") { 

		$categoria_pai = (int)$_POST['pai'];

	  	$categoria = trim(addslashes(htmlspecialchars($_POST['categoria'])));
	  	$url_amigavel = trim(addslashes(htmlspecialchars($_POST['url_amigavel'])));
		$ordem = (int)$_POST['ordem'];

		$titulo_seo = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['titulo_seo'], MB_CASE_TITLE, "UTF-8"))));
		$desc_seo = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['desc_seo'], MB_CASE_TITLE, "UTF-8"))));
		$palavras_seo = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['palavras_seo'], MB_CASE_TITLE, "UTF-8"))));
		
        $data_cadastro = date('Y-m-d');
        $hora_cadastro = date('H:i:s');
	  	$ip = $_SERVER['REMOTE_ADDR'];
		$endereco_ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		
		$query = $conexao->query("SELECT url_amigavel FROM $pagina_referencia WHERE url_amigavel LIKE '%".$url_amigavel."%' AND id!='$id' AND status='a'");
        $num_rows = $query->num_rows;
        if ($num_rows>0){
          $contador = $num_rows+1;
          $url_amigavel = $url_amigavel.'-'.$contador;
        }

		$insere = "INSERT INTO $pagina_referencia (img, img_topo, categoria, url_amigavel, categoria_pai, ordem, titulo_site, descricao_site, meta_site, ip, endereco_ip, data_cadastro, hora_cadastro, status) VALUES ('sem_imagem.jpg', 'sem_imagem.jpg', '$categoria', '$url_amigavel', '$categoria_pai', '$ordem', '$titulo_seo', '$desc_seo', '$palavras_seo', '$ip', '$endereco_ip', '$data_cadastro', '$hora_cadastro', 'a')" or die(mysqli_error());    

		if (!mysqli_query($conexao, $insere)) {  
			die('Erro: '.mysqli_error($conexao)); 
		} else {
			$ultimo_id = mysqli_insert_id($conexao);
			mysqli_query($conexao,"UPDATE $pagina_referencia SET sub_categoria='sim' WHERE id='$categoria_pai'");
			
			if (file_exists($_FILES['destaque']['tmp_name']) || is_uploaded_file($_FILES['destaque']['tmp_name'])) {
				 

				$nome = UrlAmigavel($categoria);

				if ($nome=="") { $nome=""; }

				$aleatorio = rand(1,999999);

				$nome = "categoria-".$ultimo_id."-".$nome."-".$aleatorio;

				$set_img_path = "../assets/img/".$pagina_referencia;
				$imgarray = array("image/pjpeg", "image/jpeg", "image/gif", "image/png", "image/x-png");

				if (!$_FILES['destaque']['size'])
				{
					echo "<p>Arquivo de destaque recusado devido ao tamanho do mesmo.</p>";
					exit;

				}		
				if (!in_array($_FILES['destaque']['type'],$imgarray))
				{
					echo "<p>É somente aceito arquivos de imagens (GIF, JPG e PNG).</p>";
					exit;
				}		

				if ($_FILES['destaque']['size']>$set_max_bytes_allowed)
				{
					echo "<p>Tamanho do Arquivo é maior que o limite de:</p>". $set_max_bytes_allowed / 1000 ."Kb.";
					exit;
				}		

				if ($_FILES['destaque']['type']=="image/gif")
				{
						$ext = ".gif";
				}
				elseif ($_FILES['destaque']['type']=="image/jpeg" || $_FILES['destaque']['type']=="image/pjpeg")
				{
						$ext = ".jpg";

				}
				elseif ($_FILES['destaque']['type']=="image/png")
				{
						$ext = ".png";
				}

				$img_categoria = $nome.$ext;
				move_uploaded_file($_FILES['destaque']['tmp_name'], "$set_img_path/$img_categoria");

				chmod ("$set_img_path/$img_categoria", 0755);
				comprimirImagem("$set_img_path/$img_categoria", "$set_img_path/$img_categoria", 70);

				$update = "UPDATE $pagina_referencia SET img='".$img_categoria."' WHERE id='".$ultimo_id."' "  or die(mysqli_error());

				if (!mysqli_query($conexao, $update)) { die('Erro: '.mysqli_error($conexao)); }
			}
			
			echo "<script>alert('Cadastrado com sucesso!');</script>";
			echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";

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
              <div class="col-md-12">
                <div class="form-group">
                  <label >CATEGORIA PAI</label>
                  <select class="form-control" name="pai">
                    <option value='0'>PRINCIPAL</option>
                    <?
                        $sql = "SELECT id, categoria FROM $pagina_referencia WHERE status='a' ORDER BY categoria ASC";
                        $query = mysqli_query($conexao, $sql);
                                     
                        while ($dados = mysqli_fetch_assoc($query)) {
							if ($categoria_pai==$dados['id']) { $selecao = 'selected'; } else { $selecao = ''; }
                        	echo "<option value='".$dados['id']."' $selecao>".$dados['categoria']."</option>";
                        }
	  					mysqli_free_result($query);
                      ?>
                  </select>
                </div>
              </div>
              <div class="col-md-12"> </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label >FOTO DESTAQUE</label>
                  <input class="form-control" name="destaque" id="destaque" type="file" accept="image/*">
                </div>
              </div>
              <div class="col-md-12"> </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label>TÍTULO</label>
                  <input name="categoria" type="text" required="required" autofocus class="form-control" id="categoria" placeholder="" maxlength="255" onkeyup="UrlAmigavel(this.value, this.id, '2')">
                  <input type="hidden" id="tabela" value="<?=$pagina_referencia;?>">
                </div>
              </div>
              <div class="col-md-8">
                <div class="form-group" id="form_url_amigavel">
                  <label>URL AMIGÁVEL</label>
                  <label class="control-label" for="url_amigavel" style="display:none;" id="label_url_amigavel">URL amigável indisponível</label>
                  <input name="url_amigavel" type="text" required="required" class="form-control" id="url_amigavel" placeholder="Ex: nome-da-categoria" maxlength="255" onkeyup="UrlAmigavel(this.value, 'url_amigavel', '1')">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label >ORDEM</label>
                  <input name="ordem" type="number" required="required" class="form-control" id="ordem" placeholder="" min="0" step="10" value="100" >
                </div>
              </div>
              <div class="col-md-12"> </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12 ">
          <div class="panel panel-default ">
            <div class="panel-body ">
              <h3>SEO - Otimização do Site</h3>
              <p>Preencha as informações abaixo para melhorar o seu posicionamento nos buscadores.</p>
              <hr>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>TÍTULO (SEO)</label>
                        &nbsp;<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="top" data-content="Títulos curtos com até 60 caracteres tem um melhor posicionamento no Google" data-title="Título SEO" data-original-title="" title="" aria-describedby="popover260526" style="line-height: normal; padding: 3px 7px 3px 7px;"> ? </button>
                        &nbsp;<button class="btn btn-danger caracteres" id="caracteres_titulo_seo">0 Caracteres</button>
                        <input name="titulo_seo" type="text" autofocus class="form-control" id="titulo_seo" placeholder="Títulos com até 60 caracteres tem um melhor posicionamento" maxlength="255" value="<?=$titulo_seo;?>">
                    </div>
                </div>  
                <div class="col-md-12"> 
                    <div class="form-group">
                        <label>DESCRIÇÃO (SEO)</label>
                        &nbsp;<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="top" data-content="Sugerimos no máximo 156 caracteres sendo os 50 primeiros mais importantes, para um melhor posicionamento no Google" data-title="Descrição SEO" data-original-title="" title="" aria-describedby="popover260526" style="line-height: normal; padding: 3px 7px 3px 7px;"> ? </button>
                        &nbsp;<button class="btn btn-danger caracteres" id="caracteres_descricao_seo">0 Caracteres</button>
                        <input name="desc_seo" type="text" autofocus class="form-control" id="descricao_seo" placeholder="Sugerimos no máximo 156 caracteres sendo os 50 primeiros mais importantes" maxlength="255" value="<?=$desc_seo;?>">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>PALAVRAS CHAVES (SEO)</label>
                        &nbsp;<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="top" data-content="Palavras relevantes separadas por vírgula, máximo de 200 caracteres, para um melhor posicionamento no Google (Algo que você pesquisaria para encontrar o produto em questão)" data-title="Palavras SEO" data-original-title="" title="" aria-describedby="popover260526" style="line-height: normal; padding: 3px 7px 3px 7px;"> ? </button>
                        &nbsp;<button class="btn btn-danger caracteres" id="caracteres_palavras_seo">0 Caracteres</button>
                        <input name="palavras_seo" type="text"  autofocus class="form-control" id="palavras_seo" placeholder="Palavras relevantes separadas por vírgula, máximo de 200 caracteres" maxlength="255" value="<?=$palavras_seo;?>">
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
		$endereco_ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);

	  	$update = "UPDATE categorias SET ip='$ip', endereco_ip='$endereco_ip', data_excluir='$data_excluir', hora_excluir='$hora_excluir', status='d' WHERE id='$id' "  or die(mysqli_error());
		
		if (!mysqli_query($conexao, $update)) {  
			die('Error: '.mysqli_error($conexao)); 
			echo "<script>alert('Erro ao exluir item')</script>";
		} else {
			echo "<script>alert('Item excluido com sucesso')</script>";
			echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";
		}
  }

  if ($acao=="gravar_editar") { 

		$id = (int)$_POST['id'];
		$categoria_pai = (int)$_POST['pai'];
		$categoria = trim(addslashes(htmlspecialchars($_POST['categoria'])));
		$ordem = (int)$_POST['ordem'];

		$url_amigavel = trim(addslashes(htmlspecialchars($_POST['url_amigavel'])));
		$titulo_seo = trim(addslashes(htmlspecialchars($_POST['titulo_seo'])));
		$desc_seo = trim(addslashes(htmlspecialchars($_POST['desc_seo'])));
		$palavras_seo = strtolower(trim(addslashes(htmlspecialchars($_POST['palavras_seo']))));

	  	$status = $_POST['status'];

        $data_editar = date('Y-m-d');
        $hora_editar = date('H:i:s');
	  	$ip = $_SERVER['REMOTE_ADDR'];
		$endereco_ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		
		$catAnt = mysqli_query($conexao,"SELECT categoria_pai FROM $pagina_referencia WHERE id='".$id."' LIMIT 1");
		
		$query = $conexao->query("SELECT url_amigavel FROM $pagina_referencia WHERE url_amigavel LIKE '%".$url_amigavel."%' AND id!='$id' AND status='a'");
        $num_rows = $query->num_rows;
        if ($num_rows>0){
          $contador = $num_rows+1;
          $url_amigavel = $url_amigavel.'-'.$contador;
        }
		
	  	$update = "UPDATE $pagina_referencia SET categoria='$categoria', categoria_pai='$categoria_pai', url_amigavel='$url_amigavel', titulo_site='$titulo_seo', descricao_site='$desc_seo', meta_site='$palavras_seo', ordem='$ordem', ip='$ip', endereco_ip='$endereco_ip', data_editar='$data_editar', hora_editar='$hora_editar', status='$status' WHERE id='".$id."' "  or die(mysqli_error());
	  	if (!mysqli_query($conexao, $update)) {  
			die('Error: '.mysqli_error($conexao)); 
		} else {
			
			echo "<script>alert('Atualizado com sucesso!');</script>";
			echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";

		}
		if($catAnt['categoria_pai']!=$categoria_pai){
			$temMais = mysqli_num_rows(mysqli_query($conexao,"SELECT id FROM $pagina_referencia WHERE categoria_pai='".$catAnt['categoria_pai']."' AND status='a'"));
			if($temMais==0){
				mysqli_query($conexao,"UPDATE $pagina_referencia SET sub_categoria='nao' WHERE id='".$catAnt['categoria_pai']."'");
			}else{
				mysqli_query($conexao,"UPDATE $pagina_referencia SET sub_categoria='sim' WHERE id='".$catAnt['categoria_pai']."'");
			}
		}	
		
  }

  if ($acao=="editar") { ?>
	<?
	$sql = "SELECT * FROM $pagina_referencia WHERE id='$id'";
	$query = mysqli_query($conexao, $sql);
	  
	$condicao = mysqli_num_rows($query);
	
	while ($dados = mysqli_fetch_assoc($query)) {
		$id = $dados['id'];
		$categoria = $dados['categoria'];
		$categoria_pai = $dados['categoria_pai'];
		$url_amigavel = $dados['url_amigavel'];
		$ordem = $dados['ordem'];
		$titulo_site = $dados['titulo_site'];
		$descricao_site = $dados['descricao_site'];
		$meta_site = $dados['meta_site'];
		$status = $dados['status'];
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

              <div class="col-md-12"> 
                <div class="form-group">
              	  <label >CATEGORIA PAI</label>
                    <select class="form-control" name="pai">
                      <option value='0'>PRINCIPAL</option>
                      <?
                        $sql = "SELECT id, categoria FROM $pagina_referencia WHERE status='a' ORDER BY categoria ASC";
                        $query = mysqli_query($conexao, $sql);
                                     
                        while ($dados = mysqli_fetch_assoc($query)) {
							if ($categoria_pai==$dados['id']) { $selecao = 'selected'; } else { $selecao = ''; }
                        	echo "<option value='".$dados['id']."' $selecao>".$dados['categoria']."</option>";
                        }
	  					mysqli_free_result($query);
                      ?>
                  </select>
                </div>
              </div>
                
              <div class="col-md-12"> </div>
              
              <div class="col-md-12">
                <div class="form-group">
                  <label>TÍTULO</label>
                  <input name="categoria" type="text" required="required" autofocus class="form-control" id="categoria" placeholder="" maxlength="255" value="<?=$categoria;?>">
                  <input type="hidden" id="tabela" value="<?=$pagina_referencia;?>">
                </div>
              </div>
              
              <div class="col-md-8">
                <div class="form-group" id="form_url_amigavel">
                  <label>URL AMIGÁVEL</label>
                  <label class="control-label" for="url_amigavel" style="display:none;" id="label_url_amigavel">URL amigável indisponível</label>
                  <input name="url_amigavel" type="text" required="required" class="form-control" id="url_amigavel" placeholder="Ex: nome-da-categoria" maxlength="255" value="<?=$url_amigavel;?>" onkeyup="UrlAmigavel(this.value, 'url_amigavel', '1')">
                </div>
              </div>
                
              <div class="col-md-4"> 
                <div class="form-group">
              	  <label >ORDEM</label>
                  	<input name="ordem" type="number" required="required" class="form-control" id="ordem" placeholder="" min="1" step="1" value="<?=$ordem;?>">
                </div>
              </div>
                
              <div class="col-md-12"> </div>

            </div>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-lg-12 ">
          <div class="panel panel-default ">
            <div class="panel-body ">
                <h3>SEO - Otimização do Site</h3>
                <p>Preencha as informações abaixo para melhorar o seu posicionamento nos buscadores.</p>
                <hr>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>TÍTULO (SEO)</label>
                        &nbsp;<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="top" data-content="Títulos curtos com até 60 caracteres tem um melhor posicionamento no Google" data-title="Título SEO" data-original-title="" title="" aria-describedby="popover260526" style="line-height: normal; padding: 3px 7px 3px 7px;"> ? </button>
                        &nbsp;<button class="btn btn-danger caracteres" id="caracteres_titulo_seo">0 Caracteres</button>
                        <input name="titulo_seo" type="text" autofocus class="form-control" id="titulo_seo" placeholder="Títulos com até 60 caracteres tem um melhor posicionamento" maxlength="255" value="<?=$titulo_seo;?>">
                    </div>
                </div>  
                <div class="col-md-12"> 
                    <div class="form-group">
                        <label>DESCRIÇÃO (SEO)</label>
                        &nbsp;<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="top" data-content="Sugerimos no máximo 156 caracteres sendo os 50 primeiros mais importantes, para um melhor posicionamento no Google" data-title="Descrição SEO" data-original-title="" title="" aria-describedby="popover260526" style="line-height: normal; padding: 3px 7px 3px 7px;"> ? </button>
                        &nbsp;<button class="btn btn-danger caracteres" id="caracteres_descricao_seo">0 Caracteres</button>
                        <input name="desc_seo" type="text" autofocus class="form-control" id="descricao_seo" placeholder="Sugerimos no máximo 156 caracteres sendo os 50 primeiros mais importantes" maxlength="255" value="<?=$desc_seo;?>">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>PALAVRAS CHAVES (SEO)</label>
                        &nbsp;<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="top" data-content="Palavras relevantes separadas por vírgula, máximo de 200 caracteres, para um melhor posicionamento no Google (Algo que você pesquisaria para encontrar o produto em questão)" data-title="Palavras SEO" data-original-title="" title="" aria-describedby="popover260526" style="line-height: normal; padding: 3px 7px 3px 7px;"> ? </button>
                        &nbsp;<button class="btn btn-danger caracteres" id="caracteres_palavras_seo">0 Caracteres</button>
                        <input name="palavras_seo" type="text"  autofocus class="form-control" id="palavras_seo" placeholder="Palavras relevantes separadas por vírgula, máximo de 200 caracteres" maxlength="255" value="<?=$palavras_seo;?>">
                    </div>
                </div>
                
                <div class="col-md-12"> 
                    <div class="form-group">
                  	  <label>STATUS</label>
    	                <select class="form-control" name="status">
                          <option value='a' <? if ($status=="a") { echo 'selected'; } ?>>Ativo</option>
                          <option value='d' <? if ($status!="a") { echo 'selected'; } ?>>Desativado</option>
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
			<?}?>
            </div>
          </div>
        </div>
      </div>

	</form>
<? }
  if ($acao=="gravar_migrar") { 

		$atual = (int)$_POST['atual'];
		$destino = (int)$_POST['destino'];

	  	$update = "UPDATE produtos SET categoria='$destino' WHERE categoria='$atual' "  or die(mysqli_error());

		if (!mysqli_query($conexao, $update)) {  
			die('Erro: '.mysqli_error($conexao)); 
		} 
	  
	  	$update = "UPDATE $pagina_referencia SET categoria_pai='$destino' WHERE categoria_pai='$atual' "  or die(mysqli_error());

		if (!mysqli_query($conexao, $update)) {  
			die('Erro: '.mysqli_error($conexao)); 
		} 
	  
		mysqli_query($conexao,"UPDATE $pagina_referencia SET sub_categoria='nao' WHERE id='".$atual."'");
	  
		echo "<script>alert('$pagina_titulo migradas com sucesso!');</script>";
		echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia-migrar'>";
		
  }

  if ($acao=="migrar") { ?>
    <div class="row">
      <div class="col-md-12  header-wrapper" >
        <h1 class="page-header"><?=mb_convert_case("$pagina_titulo", MB_CASE_TITLE, "UTF-8");?> Migrar</h1>
        <p class="page-subtitle">Para migrar itens de uma categoria para outra, preencha os dados abaixo.</p>
      </div>
    </div>

	<form method="post" action="" enctype="multipart/form-data">
      <div class="row">
        <div class="col-lg-12 ">
          <div class="panel panel-default ">
            <div class="panel-body">

              <div class="col-md-12" >
				  <h3>Miração de <?=$pagina_titulo;?></h3>
				  <p>Selecione a categoria atual e a destino para que o sistema realize a migração de produtos e subcategorias.</p>
			  </div>

              <hr><br>

              <div class="col-md-6"> 
                <div class="form-group">
              	  <label >CATEGORIA</label>
                    <select class="form-control" name="atual">
                      <?
                        $sql = "SELECT id, categoria FROM $pagina_referencia WHERE status='a' ORDER BY categoria ASC";
                        $query = mysqli_query($conexao, $sql);
                                     
                        while ($dados = mysqli_fetch_assoc($query)) {
                        	echo "<option value='".$dados['id']."' >".$dados['categoria']."</option>";
                        }
	  					mysqli_free_result($query);
                      ?>
                  </select>
                </div>
              </div>
                
              <div class="col-md-6"> 
                <div class="form-group">
              	  <label >CATEGORIA DESTINO</label>
                    <select class="form-control" name="destino">
                      <?
                        $sql = "SELECT id, categoria FROM $pagina_referencia WHERE status='a' ORDER BY categoria ASC";
                        $query = mysqli_query($conexao, $sql);
                                     
                        while ($dados = mysqli_fetch_assoc($query)) {
                        	echo "<option value='".$dados['id']."' >".$dados['categoria']."</option>";
                        }
	  					mysqli_free_result($query);
                      ?>
                  </select>
                </div>
              </div>
                
              <div class="col-md-12"> </div>
              <input name="acao" id="acao" value="gravar_migrar" type="hidden">
              <input name="id" id="id" value="<?=$id;?>" type="hidden">
              <button type="submit" name="enviar" value="enviar" class="btn btn-success" style="float:right;"><i class="fa fa-check"></i> Migrar Categoria </button>

            </div>
          </div>
        </div>
      </div>

	</form>
<? }
  if ($acao=="gravar_reajustar") { 
?>
    <div class="row">
      <div class="col-md-12  header-wrapper" >
        <h1 class="page-header"><?=mb_convert_case("$pagina_titulo", MB_CASE_TITLE, "UTF-8");?> Reajustar</h1>
        <p class="page-subtitle">Para reajustar valores em lote de uma categoria, preencha os dados abaixo.</p>
      </div>
    </div>

	<form method="post" action="" enctype="multipart/form-data">
      <div class="row">
        <div class="col-lg-12 ">
          <div class="panel panel-default ">
            <div class="panel-body">

              <div class="col-md-12" >
				  <h3>Reajustando a Categoria</h3>
<?
		$categoria = (int)$_POST['categoria'];
		$operacao = $_POST['operacao'];
		$tipo = $_POST['tipo'];
		$porcentagem = $_POST['valor'];

		$sql = "SELECT id, categoria FROM categorias WHERE id='$categoria' AND status='a' ORDER BY categoria ASC";
		$query = mysqli_query($conexao, $sql);

		while ($dados = mysqli_fetch_assoc($query)) {
			$nome_categoria = $dados["categoria"];
		}
		mysqli_free_result($query);

		if($tipo=='valor'){
			$pre0 = 'R$ ';
			$pos0  ='';
		}else{
			$pre0 = '';
			$pos0  =' %';
		}

		echo "<h4><br>Processando os produtos da categoria <b>$nome_categoria</b> para <b>$operacao $pre0 $porcentagem $pos0</b><br><br></h4>";

 		$sql = "SELECT id, categoria, produto, preco, por, status FROM produtos WHERE categoria='$categoria' AND status='a' ORDER BY produto ASC, id ASC";
		$query = mysqli_query($conexao, $sql);
                                     
		while ($dados = mysqli_fetch_assoc($query)) {
			$temp_id = $dados["id"];
			$temp_produto = $dados["produto"];
			$temp_preco = $dados["preco"];
			$temp_por = $dados["por"];

			if ($temp_preco!=0.00) {
				
				if($tipo=='valor'){
					$resulporc = $porcentagem;
					$resulpor = $porcentagem;
					$pre = 'R$ ';
					$pos  ='';
				}else{
					$resulporc = $temp_preco*($porcentagem/100);
					$resulpor = $temp_por*($porcentagem/100);
					$pre = '';
					$pos  =' %';
				}
				
				if ($operacao=='+') {
					$resultado = $temp_preco + $resulporc;
					if ($temp_por!=0.00) { $resultado_por = $temp_por + $resulpor; } else {$resultado_por=0.00;}
				} else {
					$resultado = $temp_preco - $resulporc;
					if ($temp_por!=0.00) { $resultado_por = $temp_por - $resulpor; } else {$resultado_por=0.00;}
				}
				$resultado = round($resultado, 2);
				$resultado_por = round($resultado_por, 2);
				if ($resultado <= 0 ) { $resultado = 0; }
				if ($resultado_por <= 0 ) { $resultado_por = 0; }
				echo "<p>$temp_id - $temp_produto - R$ ".number_format($temp_preco,2,',','.')." $operacao $pre $porcentagem $pos = <font color='#900'><strong> R$ ".number_format($resultado,2,',','.')."</strong></font> </p>";
			} else {
				echo "<p>$temp_id - $temp_produto - <font color='#900'><strong>Produto Zerado</strong></font> </p>";
			}

			$update = "UPDATE produtos SET preco='$resultado', por='$resultado_por' WHERE id='$temp_id' "  or die(mysqli_error());

			if (!mysqli_query($conexao, $update)) {  
				die('Erro: '.mysqli_error($conexao)); 
			} 

		}
		mysqli_free_result($query);	  

		echo "<h2><br>Todas os produtos da categoria <b>$nome_categoria</b> foram processados para <b>$operacao $pre $porcentagem $pos</b>!<br></h2>";
?>
				<br><br><br>
	  			<a href="<?=$pagina_referencia;?>-reajustar" class="btn btn-primary btn-lg btn-block" role="button" aria-pressed="true">REAJUSTAR OUTRA CATEGORIA</a>		  
				<br><br><br>
		  
			  </div>

              <hr><br>

	<?
		
  }

  if ($acao=="reajustar") { ?>
    <div class="row">
      <div class="col-md-12  header-wrapper" >
        <h1 class="page-header"><?=mb_convert_case("$pagina_titulo", MB_CASE_TITLE, "UTF-8");?> Reajustar</h1>
        <p class="page-subtitle">Para reajustar valores em lote de uma categoria, preencha os dados abaixo.</p>
      </div>
    </div>

	<form method="post" action="" enctype="multipart/form-data">
      <div class="row">
        <div class="col-lg-12 ">
          <div class="panel panel-default ">
            <div class="panel-body">

              <div class="col-md-12" >
				  <h3>Reajustar <?=$pagina_titulo;?></h3>
				  <p>Selecione a categoria que deseja reajustar os valores.</p>
			  </div>

              <hr><br><br><br>

              <div class="col-md-5"> 
                <div class="form-group">
              	  <label >CATEGORIA</label>
                    <select class="form-control" name="categoria">
                      <?
                        $sql = "SELECT id, categoria FROM $pagina_referencia WHERE status='a' ORDER BY categoria ASC";
                        $query = mysqli_query($conexao, $sql);
                                     
                        while ($dados = mysqli_fetch_assoc($query)) {
                        	echo "<option value='".$dados['id']."' >".$dados['categoria']."</option>";
                        }
	  					mysqli_free_result($query);
						  if (!isset($ordem)){$ordem = '';}
                      ?>
                  </select>
                </div>
              </div>
                
              <div class="col-md-3"> 
                <div class="form-group">
              	  <label >OPERAÇÃO</label>
                    <select class="form-control" name="operacao">
						<option value='+' >(+) Acrescentar</option>
               			<option value='-' >(-) Subtrair</option>
                    </select>
                </div>
              </div>
			  
			  <div class="col-md-2"> 
                <div class="form-group">
              	  <label >TIPO</label>
                    <select class="form-control" name="tipo">
						<option value='valor' >R$</option>
               			<option value='porcentagem' >%</option>
                    </select>
                </div>
              </div>
                
              <div class="col-md-2"> 
                <div class="form-group">
              	  <label >VALOR</label>
				   <input name="valor" type="number" required="required" class="form-control" id="valor" placeholder="" min="0" step="00.01" value="<?=$ordem;?>">
                </div>
              </div>
                
              <div class="col-md-12"> </div>

              <input name="acao" id="acao" value="gravar_reajustar" type="hidden">
              <input name="id" id="id" value="<?=$id;?>" type="hidden"> 
              <button type="submit" name="enviar" value="enviar" class="btn btn-success" style="float:right;"><i class="fa fa-check"></i> Reajustar Categoria </button>

            </div>
          </div>
        </div>
      </div>

	</form>
<? }
  if ($acao=="gravar_imagem") { 

	$categoria = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['categoria'], MB_CASE_LOWER, "UTF-8"))));
	$nome = UrlAmigavel($categoria);
	  
	if ($nome=="") { $nome=""; }

	$aleatorio = rand(1,999999);

	if (file_exists($_FILES['destaque']['tmp_name']) || is_uploaded_file($_FILES['destaque']['tmp_name'])) {

		$nome_final = "categoria-".$id."-".$nome."-".$aleatorio;

		$set_img_path = "../assets/img/".$pagina_referencia;
		$imgarray = array("image/pjpeg", "image/jpeg", "image/gif", "image/png", "image/x-png");

		if (!$_FILES['destaque']['size'])
		{
			echo "<p>Arquivo recusado devido ao tamanho do mesmo.</p>";
			exit;

		}		
		if (!in_array($_FILES['destaque']['type'],$imgarray))
		{
			echo "<p>É somente aceito arquivos de imagens (GIF, JPG e PNG).</p>";
			exit;
		}		

		if ($_FILES['destaque']['size']>$set_max_bytes_allowed)
		{
			echo "<p>Tamanho do Arquivo é maior que o limite de:</p>". $set_max_bytes_allowed / 1000 ."Kb.";
			exit;
		}		

		if ($_FILES['destaque']['type']=="image/gif")
		{
				$ext = ".gif";
		}
		elseif ($_FILES['destaque']['type']=="image/jpeg" || $_FILES['destaque']['type']=="image/pjpeg")
		{
				$ext = ".jpg";

		}
		elseif ($_FILES['destaque']['type']=="image/png")
		{
				$ext = ".png";
		}

		$img = $nome_final.$ext;
		move_uploaded_file($_FILES['destaque']['tmp_name'], "$set_img_path/$img");

		chmod ("$set_img_path/$img", 0755);

		$data_editar = date('Y-m-d');
        $hora_editar = date('H:i:s');
	  	$ip = $_SERVER['REMOTE_ADDR'];
		$endereco_ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		
		$update = "UPDATE $pagina_referencia SET img='".$img."', ip='$ip', endereco_ip='$endereco_ip', data_editar='$data_editar', hora_editar='$hora_editar' WHERE id='".$id."' "  or die(mysqli_error());

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
		$categoria = $dados['categoria'];
		$img = $dados['img'];
		$status = $dados['status'];

		if(file_exists("../assets/img/$pagina_referencia/$img")){ } else{ $img = "sem_imagem.jpg"; }
		
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


              <div class="col-md-2">
                <div class="form-group">
                  <img src="../assets/img/<?=$pagina_referencia;?>/<?=$img;?>" style="max-width: 100%; max-height: 100px;" >
                </div>
              </div>
              <div class="col-md-9">
                <div class="form-group">
                  <label >FOTO DESTAQUE</label>
                  <input class="form-control" name="destaque" id="destaque" type="file" accept="image/*">
                </div>
              </div>
              <br>
              <br>

              <div class="col-md-12"> </div>
				<p>&nbsp;</p>
				<p>&nbsp;</p>
				<p>&nbsp;</p>
              <div class="col-md-12"> </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label></label>
                  <input name="acao" id="acao" value="gravar_imagem" type="hidden">
                  <input name="id" id="id" value="<?=$id;?>" type="hidden">
                  <input name="categoria" id="categoria" value="<?=$categoria;?>" type="hidden">
                  <button type="submit" name="enviar" value="enviar" class="btn btn-success" style="float:right;"><i class="fa fa-check"></i> Atualizar Imagem </button>
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
			<div class="pull-right">
				<a href="<?=$pagina_referencia;?>-cadastrar" title="CADASTRAR" class="btn btn-primary">+ CADASTRAR</a>
			</div>
		</div>
	</div>

    <div class="row">
      <div class="col-md-12">
        <table class="table table-bordered table-hover" id="dataTables-userlist">
         <thead>
            <tr>
              <th>ID</th>
              <th>DESTAQUE</th>
              <th>CATEGORIA</th>
              <th>CATEGORIA PAI</th>
              <th>ORDEM</th>
              <th>AÇÕES</th>
            </tr>
          </thead>
          <tbody>
	<?
	$sql = "SELECT id, categoria FROM $pagina_referencia WHERE status='a' ORDER BY categoria ASC";
	$query = mysqli_query($conexao, $sql);
			
	$categorias['0'] = "PRINCIPAL";
	while ($dados = mysqli_fetch_assoc($query)) {
		$id = $dados['id'];
		$categorias[$id] = $dados['categoria'];
	}
	mysqli_free_result($query);
				
	$sql = "SELECT * FROM $pagina_referencia WHERE status='a' ORDER BY categoria ASC";
	$query = mysqli_query($conexao, $sql);
	  
	$condicao = mysqli_num_rows($query);
	$classe="even ";
		
	while ($dados = mysqli_fetch_assoc($query)) {
		$id = $dados['id'];
		$img = $dados['img'];
		$categoria_pai = $dados['categoria_pai'];
		$ordem = $dados['ordem'];
		
		if(file_exists("../assets/img/$pagina_referencia/$img")){ } else{ $img = "sem_imagem.jpg"; }

		if ($classe=="odd") { $classe="even "; } else {$classe="odd"; }
?>
            <tr class="<?=$classe;?>">
              <td class="center"><?=$id;?></td>
              <td class="center"><img src="../assets/img/<?=$pagina_referencia;?>/<?=$img;?>" alt="<?=$categorias[$id];?>" title="<?=$categorias[$id];?>" class="gridpic"></td>
              <td><?=$categorias[$id];?></td>
              <td><? if (isset($categorias[$categoria_pai])) { echo $categorias[$categoria_pai]; } else { echo "<span class='status btn-danger'>Não Localizada</span>"; };?></td>
              <td class="center"><span class="status active"><?=$ordem;?></span></td>
              <td >
            	<div class="socials tex-center"> 
            		<a href="<?=$pagina_referencia;?>-imagem_<?=$id;?>" class="btn btn-circle btn-warning "><i class="fa fa-camera"></i></a> 
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
function UrlAmigavel(valor, tipo, flag){
    var tabela = $('#tabela').prop('value');
    $.ajax({
        type: "POST",
        url: "url_amigavel.php",
        data: {
          url_amigavel: tipo,
          valor: valor,
          tabela: tabela
        },
        dataType: "json",
        success: function (dataOK) {
          if (tipo=='url_amigavel'){
            if (dataOK.ok=='sucesso' && dataOK.conteudo!=''){
              $('#form_url_amigavel').removeClass('has-error');
              $('#form_url_amigavel').addClass('has-success');
              $('#label_url_amigavel').html(dataOK.mensagem);
              $('#label_url_amigavel').show();
              $('#url_amigavel').prop('value', dataOK.conteudo);
              if (flag==1){
                $('#url_amigavel').focus();
              }
            }else{
              $('#form_url_amigavel').removeClass('has-success');
              $('#form_url_amigavel').addClass('has-error');
              $('#label_url_amigavel').html(dataOK.mensagem);
              $('#label_url_amigavel').show();
              $('#url_amigavel').prop('value', dataOK.conteudo);
              if (flag==1){
                $('#url_amigavel').focus();
              }
            }
          }else{
            if (dataOK.ok=='sucesso'){
              $('#url_amigavel').prop('value', dataOK.mensagem);
              UrlAmigavel(dataOK.mensagem, 'url_amigavel', 2);
            }
          }
        }
    });
}
</script>