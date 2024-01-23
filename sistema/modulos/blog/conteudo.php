<?php
  include_once "config.php";
  $pagina_titulo = "blog";
  $pagina_referencia = "blog";
  
  setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

  if ($acao=="gravar") { 
      
	$titulo = trim(addslashes(htmlspecialchars($_POST['titulo'])));
	$categoria = trim(addslashes(htmlspecialchars($_POST['categoria'])));
	$url_amigavel = trim(addslashes(htmlspecialchars($_POST['url_amigavel'])));
    $descricao = $_POST['descricao'];

  	$titulo_seo = strtolower(trim(addslashes(htmlspecialchars($_POST['titulo_seo']))));
  	$descricao_seo = strtolower(trim(addslashes(htmlspecialchars($_POST['desc_seo']))));
  	$palavras_seo = strtolower(trim(addslashes(htmlspecialchars($_POST['palavras_seo']))));

    $data_cadastro = date('Y-m-d');
    $hora_cadastro = date('H:i:s');
  	$ip = $_SERVER['REMOTE_ADDR'];

	$endereco_ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	  
    $query = $conexao->query("SELECT url_amigavel FROM blog WHERE url_amigavel LIKE '%".$url_amigavel."%' AND status='a'");
    $num_rows = $query->num_rows;
    if ($num_rows>0){
      $contador = $num_rows+1;
      $url_amigavel = $url_amigavel.'-'.$contador;
    }
  
	$insere = "INSERT INTO blog (titulo, url_amigavel, categoria, descricao, img, autor, data_cadastro, hora_cadastro, status, titulo_site, descricao_site, meta_site) VALUES ('$titulo', '$url_amigavel', '$categoria', '$descricao', 'sem_imagem', '$usr_nome','$data_cadastro', '$hora_cadastro', 'a','$titulo_seo','$descricao_seo','$palavras_seo')" or die(mysqli_error());

	if (!mysqli_query($conexao, $insere)) {  
		die('Erro: '.mysqli_error($conexao)); 
	} else {
		
		$ultimo_id = mysqli_insert_id($conexao);
		
		if (isset($_POST['img_destaque']) AND $_POST['img_destaque']!=''){
            $nome = clean($titulo);
            if ($nome=="") { $nome=$purl_amigavel; }
            $aleatorio = rand(1,999999);
            $nome = "blog-".$ultimo_id."-".$titulo."-".$aleatorio;
            $caminho = "../assets/img/".$pagina_referencia;
            
            $imagem = $_POST['img_destaque'];
        	$imagem_array_1 = explode(";", $imagem);
        	$imagem_array_2 = explode(",", $imagem_array_1[1]);
        	$imagem = base64_decode($imagem_array_2[1]);
        	$imagem_nome = $caminho.'/'.$nome.'.png';
        	$nova_imagem = $nome.'.webp';
        	$nova_imagem_email = $nome.'.jpg';
        
        	file_put_contents($imagem_nome, $imagem);
        	
        	$img = imagecreatefrompng($imagem_nome);
            imagepalettetotruecolor($img);
            imagealphablending($img, true);
            imagesavealpha($img, true);
            $img_blog = imagewebp($img, $caminho.'/'.$nova_imagem, 80);
            unlink($imagem_nome);
            
            $update = "UPDATE $pagina_referencia SET img='$nova_imagem' WHERE id='".$ultimo_id."' "  or die(mysqli_error());
            if (!mysqli_query($conexao, $update)) { die('Erro: '.mysqli_error($conexao)); }
            
        }
        
        if (isset($_POST['img_interna']) AND $_POST['img_interna']!=''){
            $nome = clean($titulo);
            if ($nome=="") { $nome=$purl_amigavel; }
            $aleatorio = rand(1,999999);
            $nome = "blog-".$ultimo_id."-".$titulo."-interna-".$aleatorio;
            $caminho = "../assets/img/".$pagina_referencia."/".$ultimo_id;
            
            if (!is_dir($caminho)) {
                mkdir($caminho, 0777, true);
            }
            
            $imagem = $_POST['img_interna'];
        	$imagem_array_1 = explode(";", $imagem);
        	$imagem_array_2 = explode(",", $imagem_array_1[1]);
        	$imagem = base64_decode($imagem_array_2[1]);
        	$imagem_nome = $caminho.'/'.$nome.'.png';
        	$nova_imagem = $nome.'.webp';
            
        	file_put_contents($imagem_nome, $imagem);
        	
        	$img = imagecreatefrompng($imagem_nome);
            imagepalettetotruecolor($img);
            imagealphablending($img, true);
            imagesavealpha($img, true);
            $img_blog = imagewebp($img, $caminho.'/'.$nova_imagem, 80);
            unlink($imagem_nome);
            
            $update = "UPDATE $pagina_referencia SET img_interna='$nova_imagem' WHERE id='".$ultimo_id."' "  or die(mysqli_error());
            if (!mysqli_query($conexao, $update)) { die('Erro: '.mysqli_error($conexao)); }
            
        }
		
	}
	
    $_SESSION['alerta_mensagem'] = "Blog cadastrado com sucesso!";
    $_SESSION['alerta_tipo'] = "green";
    echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";
    
  }

  if ($acao=="cadastrar") { ?>
    <div class="row">
      <div class="col-md-12  header-wrapper" >
        <h1 class="page-header">Adicionar Post</h1>
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
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="image_area">
					        <label for="upload_destaque" style="width: 100%; display: flex; align-items: center;align-items: flex-start;">
						        <div class="col-md-4 padding-img-upload">
							        <a href="#" data-toggle="modal" data-target="#excluir_destaque" style="position: absolute; left:0; z-index:99;">
                                        <button type="button" class="btn btn-danger" style="float: right;height: 24px; width: 24px; display: flex; justify-content: center; align-items: center;"><i class='fa fa-trash'></i></button>
                                    </a>
                                    <div class="modal fade" id="excluir_destaque" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                      <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel3">REMOVER IMAGEM DESTAQUE</h4>
                                            </div>
                                            <div class="modal-body">Confirma a exclusão da foto desse produto? Após a confirmação o mesmo não poderá ser desfeito. </div>
                                            <div class="modal-footer">
                                                <button type="button" name="excluir_todas_imagens" onclick="$('#uploaded_destaque').attr('src', '../assets/img/<?=$pagina_referencia;?>/sem_imagem.jpg');$('#img_destaque').prop('value', '');$('#upload_destaque').val('');" class="btn btn-danger" data-dismiss="modal" role="button"><i class='fa fa-trash'></i> Sim, desejo excluir</button>
                                                <button type="button" class="btn btn-light" data-dismiss="modal">NÃO</button>
                                            </div>
                                        </div>
                                      </div>
                                    </div>
								    <img src="../assets/img/<?=$pagina_referencia;?>/sem_imagem.jpg" id="uploaded_destaque" class="img-responsive" style="border: 1px solid #eee; max-height: 130px;"/>
								    <input type="file" name="upload_destaque" class="upload_image" id="upload_destaque" data-width="1000" data-height="1000" style="display:none;">
								    <input type="hidden" name="img_destaque" id="img_destaque" value=""/>
								</div>
								<div class="col-md-8">
						            <label>DESTAQUE (1000x1000 pixels)</label>
						            <button type="button" onclick="$('#upload_destaque').click();" class="btn btn-success btn-upload">Adicionar </button>
						        </div>
					        </label>
    					</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="image_area">
					        <label for="upload_interna" style="width: 100%; display: flex; align-items: center;align-items: flex-start;">
						        <div class="col-md-4 padding-img-upload">
							        <a href="#" data-toggle="modal" data-target="#excluir_interna" style="position: absolute; left:0; z-index:99;">
                                        <button type="button" class="btn btn-danger" style="float: right;height: 24px; width: 24px; display: flex; justify-content: center; align-items: center;"><i class='fa fa-trash'></i></button>
                                    </a>
                                    <div class="modal fade" id="excluir_interna" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                      <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel3">REMOVER IMAGEM interna</h4>
                                            </div>
                                            <div class="modal-body">Confirma a exclusão da foto desse produto? Após a confirmação o mesmo não poderá ser desfeito. </div>
                                            <div class="modal-footer">
                                                <button type="button" name="excluir_todas_imagens" onclick="$('#uploaded_interna').attr('src', '../assets/img/<?=$pagina_referencia;?>/sem_imagem.jpg');$('#img_interna').prop('value', '');$('#upload_interna').val('');" class="btn btn-danger" data-dismiss="modal" role="button"><i class='fa fa-trash'></i> Sim, desejo excluir</button>
                                                <button type="button" class="btn btn-light" data-dismiss="modal">NÃO</button>
                                            </div>
                                        </div>
                                      </div>
                                    </div>
								    <img src="../assets/img/<?=$pagina_referencia;?>/sem_imagem.jpg" id="uploaded_interna" class="img-responsive" style="border: 1px solid #eee; max-height: 130px;"/>
								    <input type="file" name="upload_interna" class="upload_image" id="upload_interna" data-width="900" data-height="500" style="display:none;">
								    <input type="hidden" name="img_interna" id="img_interna" value=""/>
								</div>
								<div class="col-md-8">
						            <label>INTERNA (900x500 pixels)</label>
						            <button type="button" onclick="$('#upload_interna').click();" class="btn btn-success btn-upload">Adicionar </button>
						        </div>
					        </label>
    					</div>
                    </div>
                </div>
                <input type="hidden" id="imagem" value="">
        		<div class="modal fade" id="nova_imagem_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    			  	<div class="modal-dialog modal-lg" role="document">
    			    	<div class="modal-content">
    			      		<div class="modal-header">
    			        		<h5 class="modal-title">Recorte sua imagem para fazer o upload</h5>
    			        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    			          			<span aria-hidden="true">×</span>
    			        		</button>
    			      		</div>
    			      		<div class="modal-body">
    			        		<div class="img-container">
    			            		<div class="row">
    			                		<div class="col-md-8">
    			                    		<img src="" id="sample_image"/>
    			                		</div>
    			                		<div class="col-md-4">
    			                    		<div class="preview"></div>
    			                		</div>
    			            		</div>
    			        		</div>
    			      		</div>
    			      		<div class="modal-footer" id="modal_rodape">
    			      			<button type="button" id="crop" class="btn btn-primary">Enviar</button>
    			        		<button type="button" class="btn btn-default" id="enviando" style="display:none;">Enviando...</button>
    			        		<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
    			      		</div>
    			    	</div>
    			  	</div>
    			</div>
    		    
			  <div class="col-md-12">
			      <hr>
			  </div>
                <div class="col-md-12"> 
                    <div class="form-group">
                      <label>CATEGORIA DO POST</label>
                        <select class="form-control" name="categoria">
                          <?
                            $sql = "SELECT id, categoria FROM categorias_blog WHERE status='a' ORDER BY categoria ASC";
                            $query = mysqli_query($conexao, $sql);
                            $num_rows = mysqli_num_rows($query);
                            if ($num_rows<1){
                              echo "<script>alert('Cadastre uma categoria para o blog!');
                              location.href='blog-categorias-cadastrar';</script>";
                            }                                     
                            while ($dados = mysqli_fetch_assoc($query)) {
                                if ($categoria==$dados['id']) { $selecao = 'selected'; } else { $selecao = ''; }
                                echo "<option value='".$dados['id']."' $selecao>".$dados['categoria']."</option>";
                            }
                            mysqli_free_result($query);
                          ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-12"> 
                    <div class="form-group">
                  	  <label >TÍTULO DO POST</label>
                      	<input name="titulo" type="text" required="required" autofocus class="form-control" id="produto" placeholder="Titulo do Post" maxlength="255" value="" onkeyup="UrlAmigavel(this.value, this.id, '2')">
                      	<input type="hidden" id="tabela" value="blog">
                    </div>
                </div>
			  
                <div class="col-md-12"> 
                    <div class="form-group" id="form_url_amigavel">
                      <label>URL AMIGÁVEL</label>
                      <label class="control-label" for="url_amigavel" style="display:none;" id="label_url_amigavel">Url amigável indisponível</label>
                      <input name="url_amigavel" type="text" required="required" class="form-control" id="url_amigavel" placeholder="Ex: nome-do-produto" maxlength="255" onkeyup="UrlAmigavel(this.value, 'url_amigavel', '1')">
                    </div>
                </div>
                <div class="col-md-12"> </div>
        
                <div class="col-md-12"> 
                    <div class="form-group">
                      <label >DESCRIÇÃO</label>
                        <textarea class="form-control" rows="4" name="descricao" id="descricao"></textarea>
                    </div>
                </div>
              
                <div class="col-md-12">
                    <div class="form-group">
                        <label>TÍTULO (SEO)</label>
                        &nbsp;<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="top" data-content="Títulos curtos com até 60 caracteres tem um melhor posicionamento no Google" data-title="Título SEO" data-original-title="" title="" aria-describedby="popover260526" style="line-height: normal; padding: 3px 7px 3px 7px;"> ? </button>
                        &nbsp;<button class="btn btn-danger caracteres" id="caracteres_titulo_seo">0 Caracteres</button>
                        <input name="titulo_seo" type="text" autofocus class="form-control" id="titulo_seo" placeholder="Títulos com até 60 caracteres tem um melhor posicionamento" maxlength="255">
                    </div>
                </div>  
                <div class="col-md-12"> 
                    <div class="form-group">
                        <label>DESCRIÇÃO (SEO)</label>
                        &nbsp;<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="top" data-content="Sugerimos no máximo 156 caracteres sendo os 50 primeiros mais importantes, para um melhor posicionamento no Google" data-title="Descrição SEO" data-original-title="" title="" aria-describedby="popover260526" style="line-height: normal; padding: 3px 7px 3px 7px;"> ? </button>
                        &nbsp;<button class="btn btn-danger caracteres" id="caracteres_descricao_seo">0 Caracteres</button>
                        <input name="desc_seo" type="text" autofocus class="form-control" id="descricao_seo" placeholder="Sugerimos no máximo 156 caracteres sendo os 50 primeiros mais importantes" maxlength="255">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>PALAVRAS CHAVES (SEO)</label>
                        &nbsp;<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="top" data-content="Palavras relevantes separadas por vírgula, máximo de 200 caracteres, para um melhor posicionamento no Google (Algo que você pesquisaria para encontrar o produto em questão)" data-title="Palavras SEO" data-original-title="" title="" aria-describedby="popover260526" style="line-height: normal; padding: 3px 7px 3px 7px;"> ? </button>
                        &nbsp;<button class="btn btn-danger caracteres" id="caracteres_palavras_seo">0 Caracteres</button>
                        <input name="palavras_seo" type="text"  autofocus class="form-control" id="palavras_seo" placeholder="Palavras relevantes separadas por vírgula, máximo de 200 caracteres" maxlength="255">
                    </div>
                </div>
               
                <div class="col-md-12"> 
                    <div class="form-group">
                      <label></label>
                      <input name="acao" id="acao" value="gravar" type="hidden">
                      <button type="submit" name="enviar" value="enviar" class="btn btn-success" style="float:right;"><i class="fa fa-check"></i> Cadastrar </button>
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

  	$update = "UPDATE blog SET status ='d' WHERE id='".$id."' "  or die(mysqli_error());

	if (!mysqli_query($conexao, $update)) {  
		die('Erro: '.mysqli_error($conexao)); 
	} else {
		echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";
	}
}
  
if ($acao=="excluir-categorias") { 

        $data_excluir = date('Y-m-d');
        $hora_excluir = date('H:i:s');
	  	$ip = $_SERVER['REMOTE_ADDR'];
		$endereco_ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);

	  	$update = "UPDATE categorias_blog SET status ='d' WHERE id='".$id."' "  or die(mysqli_error());

		if (!mysqli_query($conexao, $update)) {  
			die('Erro: '.mysqli_error($conexao)); 
		} else {
		    mysqli_query($conexao, "UPDATE blog SET categoria='0' WHERE categoria='".$id."' ") or die(mysqli_error());
			echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia-categorias'>";
			exit;
		}
}

if ($acao=="gravar_editar") { 

	$id = $_POST['id'];

    $titulo = trim(addslashes(htmlspecialchars($_POST['titulo'])));
    $categoria = trim(addslashes(htmlspecialchars($_POST['categoria'])));
    $url_amigavel = trim(addslashes(htmlspecialchars($_POST['url_amigavel'])));
    $descricao = $_POST['descricao'];
      
	$titulo_seo = strtolower(trim(addslashes(htmlspecialchars($_POST['titulo_seo']))));
	$desc_seo = strtolower(trim(addslashes(htmlspecialchars($_POST['desc_seo']))));
	$palavras_seo = strtolower(trim(addslashes(htmlspecialchars($_POST['palavras_seo']))));
	  
    $data_editar = date('Y-m-d');
    $hora_editar = date('H:i:s');
	$ip = $_SERVER['REMOTE_ADDR'];
	$endereco_ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	
	$query = $conexao->query("SELECT url_amigavel FROM blog WHERE url_amigavel LIKE '%".$url_amigavel."%' AND id!='$id' AND status='a'");
    $num_rows = $query->num_rows;
    if ($num_rows>0){
      $contador = $num_rows+1;
      $url_amigavel = $url_amigavel.'-'.$contador;
    }
		
  	$update = "UPDATE blog SET titulo='$titulo', categoria='$categoria', url_amigavel='$url_amigavel', descricao='$descricao', autor='$usr_nome', data_editar='$data_editar', hora_editar='$hora_editar', titulo_site='$titulo_seo', descricao_site='$desc_seo', meta_site='$palavras_seo'  WHERE id='".$id."' "  or die(mysqli_error());
  
	if (!mysqli_query($conexao, $update)) {  
		die('Erro: '.mysqli_error($conexao));			
	} else {

        $query_imagens = mysqli_query($conexao, "SELECT img, img_interna FROM $pagina_referencia WHERE id='$id' AND status='a' LIMIT 1");
        $dados_imagens = mysqli_fetch_assoc($query_imagens);
        
        if (isset($_POST['img_destaque']) AND $_POST['img_destaque']!='' AND $_POST['img_destaque']!=$dados_imagens['img']){
            $nome = clean($titulo);
            if ($nome=="") { $nome=$purl_amigavel; }
            $aleatorio = rand(1,999999);
            $nome = "blog-".$id."-".$nome."-".$aleatorio;
            $caminho = "../assets/img/".$pagina_referencia;
            
            $imagem = $_POST['img_destaque'];
        	$imagem_array_1 = explode(";", $imagem);
        	$imagem_array_2 = explode(",", $imagem_array_1[1]);
        	$imagem = base64_decode($imagem_array_2[1]);
        	$imagem_nome = $caminho.'/'.$nome.'.png';
        	$nova_imagem = $nome.'.webp';
        	$nova_imagem_email = $nome.'.jpg';
        
        	file_put_contents($imagem_nome, $imagem);
        	
        	$img = imagecreatefrompng($imagem_nome);
            imagepalettetotruecolor($img);
            imagealphablending($img, true);
            imagesavealpha($img, true);
            $img_blog = imagewebp($img, $caminho.'/'.$nova_imagem, 80);
            unlink($imagem_nome);
            
            $update = "UPDATE $pagina_referencia SET img='$nova_imagem' WHERE id='".$id."' "  or die(mysqli_error());
            if (!mysqli_query($conexao, $update)) { die('Erro: '.mysqli_error($conexao)); }
            
            unlink($caminho.'/'.$dados_imagens['img']);
            
        }elseif(isset($_POST['img_destaque']) AND $_POST['img_destaque']==''){
            $nova_imagem = 'sem_imagem.jpg';
            $update = "UPDATE $pagina_referencia SET img='$nova_imagem' WHERE id='".$id."' "  or die(mysqli_error());
            if (!mysqli_query($conexao, $update)) { die('Erro: '.mysqli_error($conexao)); }
            $caminho = "../assets/img/".$pagina_referencia;
            if ($dados_imagens['img']!=$nova_imagem){
                unlink($caminho.'/'.$dados_imagens['img']);
            }
        }
        
        if (isset($_POST['img_interna']) AND $_POST['img_interna']!='' AND $_POST['img_interna']!=$dados_imagens['img_interna']){
            $nome = clean($titulo);
            if ($nome=="") { $nome=$purl_amigavel; }
            $aleatorio = rand(1,999999);
            $nome = "blog-".$id."-".$nome."-interna-".$aleatorio;
            $caminho = "../assets/img/".$pagina_referencia."/".$id;
            
            if (!is_dir($caminho)) {
                mkdir($caminho, 0777, true);
            }
            
            $imagem = $_POST['img_interna'];
        	$imagem_array_1 = explode(";", $imagem);
        	$imagem_array_2 = explode(",", $imagem_array_1[1]);
        	$imagem = base64_decode($imagem_array_2[1]);
        	$imagem_nome = $caminho.'/'.$nome.'.png';
        	$nova_imagem = $nome.'.webp';
        
        	file_put_contents($imagem_nome, $imagem);
        	
        	$img = imagecreatefrompng($imagem_nome);
            imagepalettetotruecolor($img);
            imagealphablending($img, true);
            imagesavealpha($img, true);
            $img_produto = imagewebp($img, $caminho.'/'.$nova_imagem, 80);
            unlink($imagem_nome);
            
            $update = "UPDATE $pagina_referencia SET img_interna='$nova_imagem' WHERE id='".$id."' "  or die(mysqli_error());
            if (!mysqli_query($conexao, $update)) { die('Erro: '.mysqli_error($conexao)); }
            unlink($caminho.'/'.$dados_imagens['img_interna']);
            
        }elseif(isset($_POST['img_interna']) AND $_POST['img_interna']==''){
            $nova_imagem = 'sem_imagem.jpg';
            $caminho = "../assets/img/".$pagina_referencia."/".$id;
            
            if (!is_dir($caminho)) {
                mkdir($caminho, 0777, true);
            }
            
            $update = "UPDATE $pagina_referencia SET img_interna='$nova_imagem' WHERE id='".$id."' "  or die(mysqli_error());
            if (!mysqli_query($conexao, $update)) { die('Erro: '.mysqli_error($conexao)); }
            if ($dados_imagens['img_interna']!=$nova_imagem){
                unlink($caminho.'/'.$dados_imagens['img_interna']);
            }
        }
        
    	$_SESSION['alerta_mensagem'] = "Blog cadastrado com sucesso!";
        $_SESSION['alerta_tipo'] = "green";
        echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";
        
	}
}

  if ($acao=="editar") {
      
	$sql = "SELECT * FROM blog WHERE id='$id'";
	$query = mysqli_query($conexao, $sql);
	  
	$condicao = mysqli_num_rows($query);
	
	while ($dados = mysqli_fetch_assoc($query)) {
    	$id = $dados['id'];
        $titulo = $dados['titulo'];
        $categoria = $dados['categoria'];
        $data_cadastro = $dados['data_editar'];
        $chamada = $dados['chamada'];
        $autor = $dados['autor'];
        $url_amigavel = $dados['url_amigavel'];
        $descricao = $dados['descricao'];
    	$titulo_seo = $dados['titulo_site'];
    	$desc_seo = $dados['descricao_site'];
    	$palavras_seo = $dados['meta_site'];
        $img = $dados['img'];
        $img_interna = $dados['img_interna'];
    
        if(file_exists("../assets/img/blog/$img")){ 
            $imagem_exibe = "../assets/img/blog/$img";
        } elseif ($img=='') {
            $imagem_exibe ="../assets/img/blog/sem_imagem.jpg";
        } else{ $imagem_exibe = "../assets/img/blog/sem_imagem.jpg"; }
        
        if(file_exists("../assets/img/blog/$id/$img_interna")){ 
            $imagem_interna = "../assets/img/blog/$id/$img_interna";
        } elseif ($img_interna=='') {
            $imagem_interna ="../assets/img/blog/sem_imagem.jpg";
        } else{ $imagem_interna = "../assets/img/blog/sem_imagem.jpg"; }
	}
	mysqli_free_result($query);

	?>
    <div class="row">
      <div class="col-md-12  header-wrapper" >
        <h1 class="page-header">Editar Post</h1>
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

			  <div class="col-md-12" ></div>
              
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="image_area">
					        <label for="upload_destaque" style="width: 100%; display: flex; align-items: center;align-items: flex-start;">
						        <div class="col-md-4 padding-img-upload">
							        <a href="#" data-toggle="modal" data-target="#excluir_destaque" style="position: absolute; left:0; z-index:99;">
                                        <button type="button" class="btn btn-danger" style="float: right;height: 24px; width: 24px; display: flex; justify-content: center; align-items: center;"><i class='fa fa-trash'></i></button>
                                    </a>
                                    <div class="modal fade" id="excluir_destaque" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                      <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel3">REMOVER IMAGEM DESTAQUE</h4>
                                            </div>
                                            <div class="modal-body">Confirma a exclusão da foto desse produto? Após a confirmação o mesmo não poderá ser desfeito. </div>
                                            <div class="modal-footer">
                                                <button type="button" name="excluir_todas_imagens" onclick="$('#uploaded_destaque').attr('src', '../assets/img/<?=$pagina_referencia;?>/sem_imagem.jpg');$('#img_destaque').prop('value', '');$('#upload_destaque').val('');" class="btn btn-danger" data-dismiss="modal" role="button"><i class='fa fa-trash'></i> Sim, desejo excluir</button>
                                                <button type="button" class="btn btn-light" data-dismiss="modal">NÃO</button>
                                            </div>
                                        </div>
                                      </div>
                                    </div>
								    <img src="<?=$imagem_exibe;?>" id="uploaded_destaque" class="img-responsive" style="border: 1px solid #eee; max-height: 130px;"/>
								    <input type="file" name="upload_destaque" class="upload_image" id="upload_destaque" data-width="1000" data-height="1000" style="display:none;">
								    <input type="hidden" name="img_destaque" id="img_destaque" value="<?=$img;?>"/>
								</div>
								<div class="col-md-8">
						            <label>DESTAQUE (1000x1000 pixels)</label>
						            <button type="button" onclick="$('#upload_destaque').click();" class="btn btn-success btn-upload">Adicionar </button>
						        </div>
					        </label>
    					</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="image_area">
					        <label for="upload_interna" style="width: 100%; display: flex; align-items: center;align-items: flex-start;">
						        <div class="col-md-4 padding-img-upload">
							        <a href="#" data-toggle="modal" data-target="#excluir_interna" style="position: absolute; left:0; z-index:99;">
                                        <button type="button" class="btn btn-danger" style="float: right;height: 24px; width: 24px; display: flex; justify-content: center; align-items: center;"><i class='fa fa-trash'></i></button>
                                    </a>
                                    <div class="modal fade" id="excluir_interna" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                      <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel3">REMOVER IMAGEM interna</h4>
                                            </div>
                                            <div class="modal-body">Confirma a exclusão da foto desse produto? Após a confirmação o mesmo não poderá ser desfeito. </div>
                                            <div class="modal-footer">
                                                <button type="button" name="excluir_todas_imagens" onclick="$('#uploaded_interna').attr('src', '../assets/img/<?=$pagina_referencia;?>/sem_imagem.jpg');$('#img_interna').prop('value', '');$('#upload_interna').val('');" class="btn btn-danger" data-dismiss="modal" role="button"><i class='fa fa-trash'></i> Sim, desejo excluir</button>
                                                <button type="button" class="btn btn-light" data-dismiss="modal">NÃO</button>
                                            </div>
                                        </div>
                                      </div>
                                    </div>
								    <img src="<?=$imagem_interna;?>" id="uploaded_interna" class="img-responsive" style="border: 1px solid #eee; max-height: 130px;"/>
								    <input type="file" name="upload_interna" class="upload_image" id="upload_interna" data-width="900" data-height="500" style="display:none;">
								    <input type="hidden" name="img_interna" id="img_interna" value="<?=$img_interna;?>"/>
								</div>
								<div class="col-md-8">
						            <label>INTERNA (900x500 pixels)</label>
						            <button type="button" onclick="$('#upload_interna').click();" class="btn btn-success btn-upload">Adicionar </button>
						        </div>
					        </label>
    					</div>
                    </div>
                </div>
                <input type="hidden" id="imagem" value="">
        		<div class="modal fade" id="nova_imagem_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    			  	<div class="modal-dialog modal-lg" role="document">
    			    	<div class="modal-content">
    			      		<div class="modal-header">
    			        		<h5 class="modal-title">Recorte sua imagem para fazer o upload</h5>
    			        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    			          			<span aria-hidden="true">×</span>
    			        		</button>
    			      		</div>
    			      		<div class="modal-body">
    			        		<div class="img-container">
    			            		<div class="row">
    			                		<div class="col-md-8">
    			                    		<img src="" id="sample_image"/>
    			                		</div>
    			                		<div class="col-md-4">
    			                    		<div class="preview"></div>
    			                		</div>
    			            		</div>
    			        		</div>
    			      		</div>
    			      		<div class="modal-footer" id="modal_rodape">
    			      			<button type="button" id="crop" class="btn btn-primary">Enviar</button>
    			        		<button type="button" class="btn btn-default" id="enviando" style="display:none;">Enviando...</button>
    			        		<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
    			      		</div>
    			    	</div>
    			  	</div>
    			</div>
    			<div class="col-md-12">
    			    <hr>
    			</div>
                <div class="col-md-12"> 
                    <div class="form-group">
                      <label>CATEGORIA </label>
                        <select class="form-control" name="categoria">
                          <?
                            $sql = "SELECT id, categoria FROM categorias_blog WHERE status='a' ORDER BY categoria ASC";
                            $query = mysqli_query($conexao, $sql);
                            $num_rows = mysqli_num_rows($query);
                            if ($num_rows<1){
                              echo "<script>alert('Cadastre uma categoria para o blog!');
                              location.href='blog-categorias-cadastrar';</script>";
                            }                                     
                            while ($dados = mysqli_fetch_assoc($query)) {
                                if ($categoria==$dados['id']) { $selecao = 'selected'; } else { $selecao = ''; }
                                echo "<option value='".$dados['id']."' $selecao>".$dados['categoria']."</option>";
                            }
                            mysqli_free_result($query);
                          ?>
                        </select>
                    </div>
                </div>
              <div class="col-md-12"> 
                <div class="form-group">
              	  <label>TÍTULO DO POST</label>
                  	<input name="titulo" type="text" required="required" autofocus class="form-control" id="produto" placeholder="" maxlength="255" value="<?=$titulo;?>">
                  	<input type="hidden" id="tabela" value="blog">
                </div>
              </div>                                
             <div class="col-md-12"> </div>
              
              <div class="col-md-12"> 
                <div class="form-group" id="form_url_amigavel">
                  <label>URL AMIGÁVEL</label><br>
                  <label class="control-label" for="url_amigavel" style="display:none;" id="label_url_amigavel">Url amigável indisponível</label>
                  <input name="url_amigavel" type="text" required="required" value="<?=$url_amigavel;?>" class="form-control" id="url_amigavel" placeholder="Ex: nome-do-produto" maxlength="255" onkeyup="UrlAmigavel(this.value, 'url_amigavel', '1')">
                </div>
              </div>

              <div class="col-md-12"> </div>
              
           
                <div class="col-md-12"> 
                    <div class="form-group">
                      <label >DESCRIÇÃO</label>
                        <textarea class="form-control" rows="4" name="descricao" id="descricao"><?=$descricao;?></textarea>
                    </div>
                </div>

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
	  
		echo "<script>alert('$pagina_titulo migradas com sucesso!');</script>";
		echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia-migrar'>";
		
  }

if (isset($_POST['delete'])){
  $id = $_POST['id'];
  $delete = "DELETE FROM $pagina_referencia WHERE status='d' AND id='".$id."'";
  if (!mysqli_query($conexao, $delete)) {  
      die('Error: '.mysqli_error($conexao)); 
  } else {
      echo "<script>alert('Blog excluido com sucesso!')</script>";
      echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";
  }
}

if ($acao=="recuperar") { //ANCHOR exluir
    $destaque = explode('/',$_SERVER['HTTP_REFERER']);
    $destaque = $destaque[4];    

        //DELETE FROM  WHERE (`id` = '1');
        $update = "UPDATE $pagina_referencia SET status='a' WHERE id='".$id."' " or die(mysqli_error()); 
        if (!mysqli_query($conexao, $update)) {  
			die('Error: '.mysqli_error($conexao)); 
		} else {
			echo "<script>alert('Blog recuperado com sucesso!')</script>";
			echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";
        }
}	

if ($acao=="lixeira") { //ANCHOR Lixeira ?>
  
    <div class="row">
    <div class="col-md-12  header-wrapper">
        <h1 class="page-header">Lixeira</h1>
        <p class="page-subtitle">Listagens dos itens excluídos no sistema.</p>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-hover" id="dataTables-userlist">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>BLOG</th>
                    <th>TÍTULO</th>
                    <th>DESCRIÇÃO</th>
                    <th style="width: 250px;">AÇÕES</th>
                </tr>
            </thead>
            <tbody>
                <?
                	$sql = "SELECT * FROM $pagina_referencia WHERE status!='a' ORDER BY id DESC";
                	$query = mysqli_query($conexao, $sql);
                	  
                	$condicao = mysqli_num_rows($query);
                	$classe="even ";
                		
                	while ($dados = mysqli_fetch_assoc($query)) {
                	    $id = $dados['id'];
                		$img = $dados['img'];
                		$titulo  = $dados['titulo'];
                        $url  = $dados['url'];
                        $data_cadastro = $dados['data_cadastro'];
                        $hora_cadastro = $dados['hora_cadastro'];
    
                		if ($classe=="odd") { $classe="even "; } else {$classe="odd"; }
                ?>
                <tr class="<?=$classe;?>">
                    <td class="center"><?=$id;?></td>
                    <td class="center">
                    <?
                    if(file_exists("../assets/img/blog/$img")){
                       echo '<img src="../assets/img/blog/'.$img.'" alt="'.$titulo.'" title="'.$titulo.'" style="max-width: 300px; max-height: 150px;">';
                    } elseif (file_exists("../assets/img/blog/$img")) {   
                       echo '<video width="300" height="150" autoplay controls loop muted> <source src="../assets/img/blog/'.$img.'" type="video/mp4"> Seu navegador não suporta video. </video>';
                    } else{ 
                       echo '<img src="../assets/img/blog/sem_imagem.jpg" alt="'.$titulo.'" title="'.$titulo.'" style="max-width: 300px; max-height: 150px;">';
                    }
                    ?>
                    </td>
                    <td><?=$titulo;?></td>
                    <td><?=$url;?></td>
                    <td>
                        <div class="socials tex-center">
                        <a href="<?=$pagina_referencia;?>-recuperar_<?=$id;?>" class="btn btn-circle btn-warning"><i class="fa fa-undo"></i></a>
                            <a href="#" class="btn btn-circle btn-danger " data-toggle="modal" data-target="#myModal<?=$id;?>"><i class="fa fa-close"></i></a>
                            <div class="modal fade" id="myModal<?=$id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel3">REMOVER ITEM PERMANENTEMENTE</h4>
                                        </div>
                                        <div class="modal-body">Confirma a exclusão permanentemente deste item? </div>
                                        <div class="modal-footer">
                                        <form method="POST" action="" style="display: contents;">
                                            <input type="hidden" name="id" value="<?=$id;?>">
                                            <button type="submit" name="delete" class="btn btn-danger" role="button" aria-pressed="true" style="margin-right: 5px;">SIM</button>
                                        </form>
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

<? }
if ($acao=="gravar-categorias") { 
    
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
    
    $query = $conexao->query("SELECT url_amigavel FROM categorias_$pagina_referencia WHERE url_amigavel LIKE '%".$url_amigavel."%' AND status='a'");
    $num_rows = $query->num_rows;
    if ($num_rows>0){
      $contador = $num_rows+1;
      $url_amigavel = $url_amigavel.'-'.$contador;
    }
    
    $insere = "INSERT INTO categorias_$pagina_referencia (img, img_topo, categoria, url_amigavel, categoria_pai, ordem, titulo_site, descricao_site, meta_site, ip, endereco_ip, data_cadastro, hora_cadastro, status) VALUES ('sem_imagem.jpg', 'sem_imagem.jpg', '$categoria', '$url_amigavel', '$categoria_pai', '$ordem', '$titulo_seo', '$desc_seo', '$palavras_seo', '$ip', '$endereco_ip', '$data_cadastro', '$hora_cadastro', 'a')" or die(mysqli_error());    
    
    if (!mysqli_query($conexao, $insere)) {  
    	die('Erro: '.mysqli_error($conexao)); 
    } else {
    	
    	echo "<script>alert('Cadastrado com sucesso!');</script>";
    	echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia-categorias'>";
    
    }
}
if ($acao=="categorias-cadastrar") { ?>
    <div class="row">
      <div class="col-md-12  header-wrapper" >
        <h1 class="page-header">Categorias Blog Adicionar</h1>
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
                        $sql = "SELECT id, categoria FROM categorias_$pagina_referencia WHERE status='a' ORDER BY categoria ASC";
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
                  <input name="categoria" type="text" required="required" autofocus class="form-control" id="categoria" placeholder="Nome da Categoria" maxlength="255" onkeyup="UrlAmigavel(this.value, this.id, '2')">
                  <input type="hidden" id="tabela" value="categorias_<?=$pagina_referencia;?>">
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
                  <input name="ordem" type="number" required="required" class="form-control" id="ordem" placeholder="" min="0" step="1" value="100" >
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
                        <input name="titulo_seo" type="text" autofocus class="form-control" id="titulo_seo" placeholder="Títulos com até 60 caracteres tem um melhor posicionamento" maxlength="255">
                    </div>
                </div>  
                <div class="col-md-12"> 
                    <div class="form-group">
                        <label>DESCRIÇÃO (SEO)</label>
                        &nbsp;<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="top" data-content="Sugerimos no máximo 156 caracteres sendo os 50 primeiros mais importantes, para um melhor posicionamento no Google" data-title="Descrição SEO" data-original-title="" title="" aria-describedby="popover260526" style="line-height: normal; padding: 3px 7px 3px 7px;"> ? </button>
                        &nbsp;<button class="btn btn-danger caracteres" id="caracteres_descricao_seo">0 Caracteres</button>
                        <input name="desc_seo" type="text" autofocus class="form-control" id="descricao_seo" placeholder="Sugerimos no máximo 156 caracteres sendo os 50 primeiros mais importantes" maxlength="255">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>PALAVRAS CHAVES (SEO)</label>
                        &nbsp;<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="top" data-content="Palavras relevantes separadas por vírgula, máximo de 200 caracteres, para um melhor posicionamento no Google (Algo que você pesquisaria para encontrar o produto em questão)" data-title="Palavras SEO" data-original-title="" title="" aria-describedby="popover260526" style="line-height: normal; padding: 3px 7px 3px 7px;"> ? </button>
                        &nbsp;<button class="btn btn-danger caracteres" id="caracteres_palavras_seo">0 Caracteres</button>
                        <input name="palavras_seo" type="text"  autofocus class="form-control" id="palavras_seo" placeholder="Palavras relevantes separadas por vírgula, máximo de 200 caracteres" maxlength="255">
                    </div>
                </div>
                <div class="col-md-12"> </div>
                <div class="col-md-12">
                    <div class="form-group">
                      <label></label>
                      <input name="acao" id="acao" value="gravar-categorias" type="hidden">
                      <button type="submit" name="enviar" value="enviar" class="btn btn-success" style="float:right;"><i class="fa fa-check"></i> Adicionar </button>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </form>
<? }
if ($acao=="gravar_editar-categorias") { 

	$id = (int)$_POST['id'];
	$categoria_pai = (int)$_POST['pai'];
	$categoria = trim(addslashes(htmlspecialchars($_POST['categoria'])));
	$url_amigavel = trim(addslashes(htmlspecialchars($_POST['url_amigavel'])));
	$ordem = (int)$_POST['ordem'];

	$titulo_seo = trim(addslashes(htmlspecialchars($_POST['titulo_seo'])));
	$desc_seo = trim(addslashes(htmlspecialchars($_POST['desc_seo'])));
	$palavras_seo = strtolower(trim(addslashes(htmlspecialchars($_POST['palavras_seo']))));

    $data_editar = date('Y-m-d');
    $hora_editar = date('H:i:s');
  	$ip = $_SERVER['REMOTE_ADDR'];
	$endereco_ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	
	$query = $conexao->query("SELECT url_amigavel FROM categorias_$pagina_referencia WHERE url_amigavel LIKE '%".$url_amigavel."%' AND id!='$id' AND status='a'");
    $num_rows = $query->num_rows;
    if ($num_rows>0){
        $contador = $num_rows+1;
        $url_amigavel = $url_amigavel.'-'.$contador;
    }
	
  	$update = "UPDATE categorias_$pagina_referencia SET categoria='$categoria', categoria_pai='$categoria_pai', titulo_site='$titulo_seo', descricao_site='$desc_seo', meta_site='$palavras_seo', ordem='$ordem', ip='$ip', endereco_ip='$endereco_ip', data_editar='$data_editar', hora_editar='$hora_editar', status='a' WHERE id='".$id."' "  or die(mysqli_error());
  	if (!mysqli_query($conexao, $update)) {  
		die('Error: '.mysqli_error($conexao)); 
	} else {
		echo "<script>alert('Atualizado com sucesso!');</script>";
		echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia-categorias-editar_$id'>";
	}
}
if ($acao=="categorias-editar") {
    $sql = "SELECT * FROM categorias_$pagina_referencia WHERE id='$id'";
	$query = mysqli_query($conexao, $sql);
	  
	$condicao = mysqli_num_rows($query);
	
	while ($dados = mysqli_fetch_assoc($query)) {
		$id = $dados['id'];
		$categoria = $dados['categoria'];
		$categoria_pai = $dados['categoria_pai'];
		$url_amigavel = $dados['url_amigavel'];
		$ordem = $dados['ordem'];
		$titulo_seo = $dados['titulo_site'];
		$desc_seo = $dados['descricao_site'];
		$palavras_seo = $dados['meta_site'];
		$status = $dados['status'];
	}
	mysqli_free_result($query);
?>
    <div class="row">
      <div class="col-md-12  header-wrapper" >
        <h1 class="page-header">Categorias Blog Adicionar</h1>
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
                        $sql = "SELECT id, categoria FROM categorias_$pagina_referencia WHERE status='a' ORDER BY categoria ASC";
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
                  <input name="categoria" type="text" required="required" autofocus class="form-control" id="categoria" placeholder="Nome da Categoria" maxlength="255" value="<?=$categoria;?>">
                  <input type="hidden" id="tabela" value="categorias_<?=$pagina_referencia;?>">
                </div>
              </div>
              <div class="col-md-8">
                <div class="form-group" id="form_url_amigavel">
                  <label>URL AMIGÁVEL</label>
                  <label class="control-label" for="url_amigavel" style="display:none;" id="label_url_amigavel">URL amigável indisponível</label>
                  <input name="url_amigavel" type="text" required="required" class="form-control" id="url_amigavel" placeholder="Ex: nome-da-categoria" value="<?=$url_amigavel;?>" maxlength="255" onkeyup="UrlAmigavel(this.value, 'url_amigavel', '1')">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label >ORDEM</label>
                  <input name="ordem" type="number" required="required" class="form-control" id="ordem" placeholder="" min="0" step="1" value="<?=$ordem;?>">
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
                      <label></label>
                      <input name="acao" id="acao" value="gravar_editar-categorias" type="hidden">
                      <input name="id" id="id" value="<?=$id;?>" type="hidden">
                      <button type="submit" name="enviar" value="enviar" class="btn btn-success" style="float:right;"><i class="fa fa-check"></i> Atualizar </button>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </form>

<? }
if ($acao=="categorias") { ?>
  <div class="row">
    <div class="col-md-12  header-wrapper" >
        <h1 class="page-header">Blog Categorias <a href="<?=$pagina_referencia?>-categorias-cadastrar" class="btn btn-success">CADASTRAR NOVO</a></h1>
        <p class="page-subtitle">Listagens dos itens cadastrados no sistema.</p>
    </div>
  </div>

    <div class="row">
      <div class="col-md-12">
        <table class="table table-bordered table-hover" id="dataTables-userlist">
         <thead>
            <tr>
                <th>CÓDIGO</th>
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
        	
        	$sql = "SELECT id, categoria, categoria_pai, url_amigavel, ordem FROM categorias_blog WHERE status='a' ORDER BY data_cadastro ASC";
        	$query = mysqli_query($conexao, $sql);
        	  
        	$condicao = mysqli_num_rows($query);
        	$classe="even ";
        		
        	while ($dados = mysqli_fetch_assoc($query)) {
        		$id = $dados['id'];
        		$categoria = $dados['categoria'];
                $descricao = $dados['descricao'];
        		$categoria_pai = $dados['categoria_pai'];
        		$ordem = $dados['ordem'];

                $url_amigavel = $dados['url_amigavel'];
        ?>

            <tr class="<?=$classe;?>">
              <td class="center">#<?=$id;?></td>
              <td><?=ucwords($categoria);?></td>
              <td><?if (isset($categorias[$categoria_pai])) { echo $categorias[$categoria_pai]; } else { echo "<span class='status btn-danger'>Não Localizada</span>"; };?></td>
              <td class="center"><span class="status active"><?=$ordem;?></span></td>
              <td>
            	<div class="socials tex-center"> 
            		<a href="../../blog/categoria/<?=$url_amigavel;?>" target="_blank" class="btn btn-circle btn-warning "><i class="fa fa-eye"></i></a> 
            		<a href="<?=$pagina_referencia;?>-categorias-editar_<?=$id;?>" class="btn btn-circle btn-primary "><i class="fa fa-pencil"></i></a> 
            		<a href="#" class="btn btn-circle btn-danger " data-toggle="modal" data-target="#myModal<?=$id;?>"><i class="fa fa-close"></i></a> 
            		<div class="modal fade" id="myModal<?=$id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-lg">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title" id="myModalLabel3">REMOVER ITEM</h4>
						  </div>
						  <div class="modal-body">Confirma a exclusão deste item? Essa categoria será removida de todos os posts que á pertencem!</div>
						  <div class="modal-footer">
						  	<a href="<?=$pagina_referencia;?>-excluir-categorias_<?=$id;?>" class="btn btn-danger" role="button" aria-pressed="true">SIM</a>
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
        <?}mysqli_free_result($query);?>   
         
          </tbody>
        </table>
      </div>
    </div>
    <!-- /.row --> 

<? }
if ($acao=="") { ?>
  <div class="row">
    <div class="col-md-12  header-wrapper" >
        <h1 class="page-header">Blog <a href="<?=$pagina_referencia?>-cadastrar" class="btn btn-success">CADASTRAR NOVO</a></h1>
        <p class="page-subtitle">Listagens dos posts cadastrados no sistema.</p>
    </div>
  </div>

    <div class="row">
      <div class="col-md-12">
        <table class="table table-bordered table-hover" id="dataTables-userlist">
         <thead>
            <tr>
                <th>CÓDIGO</th>
                <th>FOTO</th>
                <th>TITULO</th>
                <th>DATA</th>
			    <th>AÇÕES</th>
            </tr>
          </thead>
          <tbody>
        	<?		
        	$sql = "SELECT id, titulo, descricao, img, url_amigavel, autor, data_cadastro FROM blog WHERE status='a' ORDER BY data_cadastro ASC";
        	$query = mysqli_query($conexao, $sql);
        	  
        	$condicao = mysqli_num_rows($query);
        	$classe="even ";
        		
        	while ($dados = mysqli_fetch_assoc($query)) {
        		$id = $dados['id'];
        		$img = $dados['img'];
        		$titulo = $dados['titulo'];
                $descricao = $dados['descricao'];
                $data = DateTime::createFromFormat('Y-m-d', $dados['data_cadastro']);
                $data_formatar = new IntlDateFormatter('pt_BR', IntlDateFormatter::FULL, IntlDateFormatter::FULL, 'America/Sao_Paulo', IntlDateFormatter::GREGORIAN, "d 'de' MMMM 'de' YYYY");

                $url_amigavel = $dados['url_amigavel'];
        		
        		if(file_exists("../assets/img/blog/$img")){ 
                    $imagem_exibe = "../assets/img/blog/$img";
                } elseif ($img=='') {
                   $imagem_exibe ="../assets/img/blog/sem_imagem.jpg";
                } else{ $imagem_exibe = "../assets/img/blog/sem_imagem.jpg"; }

        		if ($classe=="odd") { $classe="even "; } else {$classe="odd"; }
        ?>

            <tr class="<?=$classe;?>">
              <td class="center">#<?=$id;?></td>
              <td class="center"><img src="<?=$imagem_exibe;?>" alt="<?=$titulo;?>" title="<?=$titulo;?>" class="gridpic"></td>
              <td><?=ucwords($titulo);?></td>
              <td class="center"><?=preconj(ucwords($data_formatar->format($data)));?></td>
              <td >
            	<div class="socials tex-center"> 
            		<a href="../../blog/<?=$url_amigavel;?>" target="_blank" class="btn btn-circle btn-warning "><i class="fa fa-eye"></i></a> 
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
        <?}mysqli_free_result($query);?>   
         
          </tbody>
        </table>
      </div>
    </div>
    <!-- /.row --> 

<? } ?>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/mode/xml/xml.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.8.4/js/froala_editor.pkgd.min.js"></script>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- DataTables JavaScript --> 
<script src="vendor/datatables/js/jquery.dataTables.min.js"></script> 
<script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script> 
<script src="vendor/datatables-responsive/dataTables.responsive.js"></script> 
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/super-build/ckeditor.js"></script>
<!-- Custom Theme JavaScript --> 
<script src="js/adminnine.js"></script>
<script>
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
CKEDITOR.ClassicEditor.create(document.getElementById("descricao"),{
    toolbar: {
        items: [
            'exportPDF','exportWord', '|',
            'findAndReplace', 'selectAll', '|',
            'heading', '|',
            'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
            'bulletedList', 'numberedList', 'todoList', '|',
            'outdent', 'indent', '|',
            'undo', 'redo',
            '-',
            'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
            'alignment', '|',
            'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
            'specialCharacters', 'horizontalLine', 'pageBreak', '|',
            'textPartLanguage', '|',
            'sourceEditing'
        ],
        shouldNotGroupWhenFull: true
    },
    list: {
        properties: {
            styles: true,
            startIndex: true,
            reversed: true
        }
    },
    heading: {
        options: [
            { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
            { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
            { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
            { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
            { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
            { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
            { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
        ]
    },
    placeholder: 'Digite aqui!',
    fontFamily: {
        options: [
            'default',
            'Arial, Helvetica, sans-serif',
            'Courier New, Courier, monospace',
            'Georgia, serif',
            'Lucida Sans Unicode, Lucida Grande, sans-serif',
            'Tahoma, Geneva, sans-serif',
            'Times New Roman, Times, serif',
            'Trebuchet MS, Helvetica, sans-serif',
            'Verdana, Geneva, sans-serif'
        ],
        supportAllValues: true
    },
    fontSize: {
        options: [ 10, 12, 14, 'default', 18, 20, 22 ],
        supportAllValues: true
    },
    htmlSupport: {
        allow: [
            {
                name: /.*/,
                attributes: true,
                classes: true,
                styles: true
            }
        ]
    },
    htmlEmbed: {
        showPreviews: true
    },
    link: {
        decorators: {
            addTargetToExternalLinks: true,
            defaultProtocol: 'https://',
            toggleDownloadable: {
                mode: 'manual',
                label: 'Downloadable',
                attributes: {
                    download: 'file'
                }
            }
        }
    },
    mention: {
        feeds: [
            {
                marker: '@',
                feed: [
                    '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                    '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                    '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                    '@sugar', '@sweet', '@topping', '@wafer'
                ],
                minimumCharacters: 1
            }
        ]
    },
    removePlugins: [
        'CKBox',
        'CKFinder',
        'EasyImage',
        'RealTimeCollaborativeComments',
        'RealTimeCollaborativeTrackChanges',
        'RealTimeCollaborativeRevisionHistory',
        'PresenceList',
        'Comments',
        'TrackChanges',
        'TrackChangesData',
        'RevisionHistory',
        'Pagination',
        'WProofreader',
        'MathType'
    ]
});
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
