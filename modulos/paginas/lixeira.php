<?php

  include_once "config.php";
  $pagina_titulo = "produtos";
  $pagina_referencia = "produtos";

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



		$categoria = (int)$_POST['categoria'];

		$produto = trim(addslashes(htmlspecialchars($_POST['produto'])));

		$sub_produto = trim(addslashes(htmlspecialchars($_POST['sub_produto'])));

		$descricao = base64_encode($_POST['descricao']);

		$qtd = trim(addslashes(htmlspecialchars($_POST['qtd'])));

		$qtd_vendido = trim(addslashes(htmlspecialchars($_POST['qtd_vendido'])));

		$qtd_visto = trim(addslashes(htmlspecialchars($_POST['qtd_visto'])));

		$preco = trim(addslashes(htmlspecialchars($_POST['preco'])));

		$por = trim(addslashes(htmlspecialchars($_POST['por'])));

		$forma = trim(addslashes(htmlspecialchars($_POST['forma'])));

		$prazo = trim(addslashes(htmlspecialchars($_POST['prazo'])));

		$regiao = trim(addslashes(htmlspecialchars($_POST['regiao'])));

		$promocao = trim(addslashes(htmlspecialchars($_POST['promocao'])));

		$peso = trim(addslashes(htmlspecialchars($_POST['peso'])));

		$frete = trim(addslashes(htmlspecialchars($_POST['frete'])));

		$pronta = trim(addslashes(htmlspecialchars($_POST['pronta'])));

		$faturamento = trim(addslashes(htmlspecialchars($_POST['faturamento'])));

		$destaque = trim(addslashes(htmlspecialchars($_POST['destaque'])));

		$tamanho = trim(addslashes(htmlspecialchars($_POST['tamanho'])));

		$cor = trim(addslashes(htmlspecialchars($_POST['cor'])));

		$sistema = trim(addslashes(htmlspecialchars($_POST['sistema'])));

		$ofertas = trim(addslashes(htmlspecialchars($_POST['ofertas'])));

	  	$status = strtolower(trim(addslashes(htmlspecialchars($_POST['status']))));



	  	$titulo_seo = strtolower(trim(addslashes(htmlspecialchars($_POST['titulo_seo']))));

	  	$descricao_seo = strtolower(trim(addslashes(htmlspecialchars($_POST['desc_seo']))));

	  	$palavras_seo = strtolower(trim(addslashes(htmlspecialchars($_POST['palavras_seo']))));

		

      $data_cadastro = date('Y-m-d');

      $hora_cadastro = date('H:i:s');

	  	$ip = $_SERVER['REMOTE_ADDR'];

		  $endereco_ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);

	  

		$insere = "INSERT INTO $pagina_referencia (img, categoria, produto, sub_produto, descricao, qtd, qtd_vendido, qtd_visto, preco, por, forma, prazo, regiao, promocao, peso, frete, pronta, faturamento, destaque, tamanho, cor, sistema, ofertas, ip, endereco_ip, data_cadastro, hora_cadastro, status, Titulo_seo, Descricao_seo, palavrasChave_seo) VALUES ('sem_imagem.jpg', '$categoria', '$produto', '$sub_produto', '$descricao', '$qtd', '$qtd_vendido', '$qtd_visto', '$preco', '$por', '$forma', '$prazo', '$regiao', '$promocao', '$peso', '$frete', '$pronta', '$faturamento', '$destaque', '$tamanho', '$cor', '$sistema', '$ofertas', '$ip', '$endereco_ip', '$data_cadastro', '$hora_cadastro', 'a', '$titulo_seo', '$descricao_seo', '$palavras_seo')" or die(mysqli_error());    



		if (!mysqli_query($conexao, $insere)) {  

			die('Erro: '.mysqli_error($conexao)); 

		} else {

					

			if (file_exists($_FILES['destaque']['tmp_name']) || is_uploaded_file($_FILES['destaque']['tmp_name'])) {

				$ultimo_id = mysqli_insert_id($conexao); 



				$nome = UrlAmigavel($categoria);



				if ($nome=="") { $nome="moveis-taubate"; }



				$aleatorio = rand(1,999999);



				$nome = "produto-".$ultimo_id."-".$nome."-".$aleatorio;



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



				$img_produto = $nome.$ext;

				move_uploaded_file($_FILES['destaque']['tmp_name'], "$set_img_path/$img_produto");



				chmod ("$set_img_path/$img_produto", 0755);



				$update = "UPDATE $pagina_referencia SET img='".$img_produto."' WHERE id='".$ultimo_id."' "  or die(mysqli_error());



				if (!mysqli_query($conexao, $update)) { die('Erro: '.mysqli_error($conexao)); }

			}

			

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

              <div class="col-md-12"> </div>

              <div class="col-md-12">

                <div class="form-group">

                  <label >FOTO</label>

                  <input class="form-control" name="destaque" id="destaque" type="file" accept="image/*">

                </div>

              </div>



			  <div class="col-md-12" ></div>

              

              <hr><br><br><br>



              <div class="col-md-12"> 

                <div class="form-group">

              	  <label >CATEGORIA </label>

                    <select class="form-control" name="categoria">

                      <?

                        $sql = "SELECT id, categoria FROM categorias WHERE status='a' ORDER BY categoria ASC";

                        $query = mysqli_query($conexao, $sql);

                                     

                        while ($dados = mysqli_fetch_assoc($query)) {

							if ($categoria==$dados['id']) { $selecao = 'selected'; } else { $selecao = ''; }

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

              	  <label >TÍTULO DO PRODUTO</label>

                  	<input name="produto" type="text" required="required" autofocus class="form-control" id="produto" placeholder="" maxlength="255" value="">

                </div>

              </div>



              <div class="col-md-12"> </div>

                                

              <div class="col-md-12"> 

                <div class="form-group">

              	  <label >SUB TÍTULO DO PRODUTO</label>

                  	<input name="sub_produto" type="text" class="form-control" id="sub_produto" placeholder="" maxlength="255" value="">

                </div>

              </div>

                

              <div class="col-md-12"> </div>



              <div class="col-md-12"> 

                <div class="form-group">

              	  <label >DESCRIÇÃO</label>

                  	<textarea class="form-control" rows="4" name="descricao" id="mytextarea"></textarea>

                </div>

              </div>

                

              <div class="col-md-12"> </div>



              <div class="col-md-4"> 

                <div class="form-group">

              	  <label >QUANTIDADE EM ESTOQUE</label>

                  	<input name="qtd" type="number" required="required" class="form-control" id="qtd" min="0" step="1" value="99999999">

                </div>

              </div>

                

              <div class="col-md-4"> 

                <div class="form-group">

              	  <label >VENDIDOS</label>

                  	<input name="qtd_vendido" type="number" class="form-control" id="qtd_vendido" min="0" step="1" value="0">

                </div>

              </div>

                

              <div class="col-md-4"> 

                <div class="form-group">

              	  <label >VISTO</label>

                  	<input name="qtd_visto" type="number" class="form-control" id="qtd_visto" min="0" step="1" value="0">

                </div>

              </div>

                

              <div class="col-md-12"> </div>

                                

              <div class="col-md-4"> 

                <div class="form-group">

              	  <label >PREÇO</label>

                  	<input name="preco" type="number" required="required" class="form-control" id="preco" min="0" step="0.01" value="0">

                </div>

              </div>



			  <div class="col-md-4"> 

                <div class="form-group">

              	  <label >POR</label>

                  	<input name="por" type="number" class="form-control" id="por" min="0" step="0.01" value="0">

                </div>

              </div>



			  <div class="col-md-4"> 

                <div class="form-group">

              	  <label >PESO</label>

                  	<input name="peso" type="number" class="form-control" id="peso" min="0" step="1" value="0">

                </div>

              </div>

                

              <div class="col-md-12"> </div>



               <div class="col-md-4"> 

                <div class="form-group">

              	  <label >PRONTA ENTREGA</label>

	                <select class="form-control" name="pronta">

                      <option value='sim' >Sim</option>

                      <option value='nao' >Não</option>

                    </select>

                </div>

              </div>



              <div class="col-md-4"> 

                <div class="form-group">

              	  <label >PROMOÇÃO</label>

	                <select class="form-control" name="promocao">

                      <option value='sim' >Sim</option>

                      <option value='nao' >Não</option>

                    </select>

                </div>

              </div>

                

              <div class="col-md-4"> 

                <div class="form-group">

              	  <label >DESTAQUE</label>

	                <select class="form-control" name="destaque">

                      <option value='sim' >Sim</option>

                      <option value='nao' >Não</option>

                    </select>

                </div>

              </div>

                

              <div class="col-md-12"> </div>



			  <div class="col-md-4"> 

                <div class="form-group">

              	  <label >TAMANHO</label>

                  	<input name="tamanho" type="text" class="form-control" id="tamanho" placeholder="Deve ser separado com vírgula" maxlength="255" value="">

                </div>

              </div>



              <div class="col-md-4"> 

                <div class="form-group">

              	  <label >COR</label>

                  	<input name="cor" type="text" class="form-control" id="cor" placeholder="Deve ser separado com vírgula" maxlength="255" value="">

                </div>

              </div>

                

              <div class="col-md-4"> 

                <div class="form-group">

              	  <label >CÓDIGO INTERNO</label>

                  	<input name="sistema" type="text" class="form-control" id="sistema" placeholder="Código de controle interno" maxlength="255" value="">

                </div>

              </div>

                

              <div class="col-md-12"> </div>



              <div class="col-md-4"> 

                <div class="form-group">

              	  <label >FORMA DE PAGAMENTO</label>

                  	<input name="forma" type="text" class="form-control" id="forma" placeholder="Formas de Pagamento" maxlength="255" value="">

                </div>

              </div>



			  <div class="col-md-4"> 

                <div class="form-group">

              	  <label >PRAZO DE ENTREGA</label>

                  	<input name="prazo" type="text" class="form-control" id="prazo" placeholder="Prazo de Entrega" maxlength="255" value="">

                </div>

              </div>

               

			  <div class="col-md-4"> 

                <div class="form-group">

              	  <label >REGIÃO ATENDIDA</label>

                  	<input name="regiao" type="text" class="form-control" id="regiao" placeholder="Região Atendida" maxlength="255" value="">

                </div>

              </div>

               

              <div class="col-md-12"> </div>

                

			  <div class="col-md-4"> 

                <div class="form-group">

              	  <label >FRETE</label>

                  	<input name="frete" type="text" class="form-control" id="frete" placeholder="" maxlength="255" value="">

                </div>

              </div>

               

			  <div class="col-md-4"> 

                <div class="form-group">

              	  <label >FATURAMENTO</label>

                  	<input name="faturamento" type="text" class="form-control" id="faturamento" placeholder="" maxlength="255" value="">

                </div>

              </div>



              <div class="col-md-4"> 

                <div class="form-group">

              	  <label >OFERTA</label>

	                <select class="form-control" name="ofertas">

                      <option value='sim' >Sim</option>

                      <option value='nao' >Não</option>

                    </select>

                </div>

              </div>

                

              <div class="col-md-4"> 

                <div class="form-group">

              	  <label >STATUS</label>

	                <select class="form-control" name="status">

                      <option value='a' >Ativo</option>

                      <option value='d' >Desativado</option>

                    </select>

                </div>

              </div>



 			  <div class="col-md-12"> </div>

 			  <div class="col-md-12"> </div>

              

              <div class="col-md-12"> 

                <div class="form-group">

              	  <label >TÍTULO DO PRODUTO (SEO)</label>

                  	<input name="titulo_seo" type="text"  autofocus class="form-control" id="produto" placeholder="" maxlength="255" value="">

                </div>

              </div>



              <div class="col-md-12"> </div>

              

              <div class="col-md-12"> 

                <div class="form-group">

              	  <label >DESCRIÇÃO DO PRODUTO (SEO)</label>

                  	<input name="desc_seo" type="text"  autofocus class="form-control" id="produto" placeholder="" maxlength="255" value="">

                </div>

              </div>



              <div class="col-md-12"> </div>

              

              <div class="col-md-12"> 

                <div class="form-group">

              	  <label >PALAVRAS CHAVES DO PRODUTO (SEO)</label>

                  	<input name="palavras_seo" type="text"  autofocus class="form-control" id="produto" placeholder="" maxlength="255" value="">

                </div>

              </div>



       <div class="col-md-12"> </div>

               

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



	  	$update = "UPDATE $pagina_referencia SET ip='$ip', endereco_ip='$endereco_ip', data_excluir='$data_excluir', hora_excluir='$hora_excluir', status='d' WHERE id='".$id."' "  or die(mysqli_error());



		if (!mysqli_query($conexao, $update)) {  

			die('Erro: '.mysqli_error($conexao)); 

		} else {

			echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";

		}

  }



  if ($acao=="gravar_editar") { 



		$id = (int)$_POST['id'];

		$categoria = (int)$_POST['categoria'];

		$produto = trim(addslashes(htmlspecialchars($_POST['produto'])));

		$sub_produto = trim(addslashes(htmlspecialchars($_POST['sub_produto'])));

		$descricao = base64_encode($_POST['descricao']);

		$qtd = trim(addslashes(htmlspecialchars($_POST['qtd'])));

		$qtd_vendido = trim(addslashes(htmlspecialchars($_POST['qtd_vendido'])));

		$qtd_visto = trim(addslashes(htmlspecialchars($_POST['qtd_visto'])));

		$preco = trim(addslashes(htmlspecialchars($_POST['preco'])));

		$por = trim(addslashes(htmlspecialchars($_POST['por'])));

		$forma = trim(addslashes(htmlspecialchars($_POST['forma'])));

		$prazo = trim(addslashes(htmlspecialchars($_POST['prazo'])));

		$regiao = trim(addslashes(htmlspecialchars($_POST['regiao'])));

		$promocao = trim(addslashes(htmlspecialchars($_POST['promocao'])));

		$peso = trim(addslashes(htmlspecialchars($_POST['peso'])));

		$frete = trim(addslashes(htmlspecialchars($_POST['frete'])));

		$pronta = trim(addslashes(htmlspecialchars($_POST['pronta'])));

		$faturamento = trim(addslashes(htmlspecialchars($_POST['faturamento'])));

		$destaque = trim(addslashes(htmlspecialchars($_POST['destaque'])));

		$tamanho = trim(addslashes(htmlspecialchars($_POST['tamanho'])));

		$cor = trim(addslashes(htmlspecialchars($_POST['cor'])));

		$sistema = trim(addslashes(htmlspecialchars($_POST['sistema'])));

		$ofertas = trim(addslashes(htmlspecialchars($_POST['ofertas'])));

	  	$status = strtolower(trim(addslashes(htmlspecialchars($_POST['status']))));



	  	$titulo_seo = strtolower(trim(addslashes(htmlspecialchars($_POST['titulo_seo']))));

	  	$desc_seo = strtolower(trim(addslashes(htmlspecialchars($_POST['desc_seo']))));

	  	$palavras_seo = strtolower(trim(addslashes(htmlspecialchars($_POST['palavras_seo']))));

	  

        $data_editar = date('Y-m-d');

        $hora_editar = date('H:i:s');

	  	$ip = $_SERVER['REMOTE_ADDR'];

		$endereco_ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);

		

	  	$update = "UPDATE $pagina_referencia SET categoria='$categoria', produto='$produto', sub_produto='$sub_produto', descricao='$descricao', qtd='$qtd', qtd_vendido='$qtd_vendido', qtd_visto='$qtd_visto', preco='$preco', por='$por', forma='$forma', prazo='$prazo', regiao='$regiao', promocao='$promocao', peso='$peso', frete='$frete', pronta='$pronta', faturamento='$faturamento', destaque='$destaque', tamanho='$tamanho', cor='$cor', sistema='$sistema', ofertas='$ofertas', ip='$ip', endereco_ip='$endereco_ip', data_editar='$data_editar', hora_editar='$hora_editar', status='$status', Titulo_seo='$titulo_seo', Descricao_seo='$desc_seo', palavrasChave_seo='$palavras_seo' WHERE id='".$id."' "  or die(mysqli_error());

	  

		if (!mysqli_query($conexao, $update)) {  

			die('Erro: '.mysqli_error($conexao)); 

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

		$img = $dados['img'];

		$categoria = $dados['categoria'];

		$produto = $dados['produto'];

		$sub_produto = $dados['sub_produto'];

		$descricao = base64_decode($dados['descricao']);

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

		$tamanho = $dados['tamanho'];

		$cor = $dados['cor'];

		$sistema = $dados['sistema'];

		$ofertas = $dados['ofertas'];

		$status = $dados['status'];

		$titulo_seo = $dados['Titulo_seo'];

		$desc_seo = $dados['Descricao_seo'];

		$palavras_seo = $dados['palavrasChave_seo'];

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



			  <div class="col-md-12" ></div>

              

              <hr><br><br><br>



              <div class="col-md-12"> 

                <div class="form-group">

              	  <label >CATEGORIA </label>

                    <select class="form-control" name="categoria">

                      <?

                        $sql = "SELECT id, categoria FROM categorias WHERE status='a' ORDER BY categoria ASC";

                        $query = mysqli_query($conexao, $sql);

                                     

                        while ($dados = mysqli_fetch_assoc($query)) {

							if ($categoria==$dados['id']) { $selecao = 'selected'; } else { $selecao = ''; }

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

              	  <label >TÍTULO DO PRODUTO</label>

                  	<input name="produto" type="text" required="required" autofocus class="form-control" id="produto" placeholder="" maxlength="255" value="<?=$produto;?>">

                </div>

              </div>



              <div class="col-md-12"> </div>

                                

              <div class="col-md-12"> 

                <div class="form-group">

              	  <label >SUB TÍTULO DO PRODUTO</label>

                  	<input name="sub_produto" type="text" class="form-control" id="sub_produto" placeholder="" maxlength="255" value="<?=$sub_produto;?>">

                </div>

              </div>

                

              <div class="col-md-12"> </div>



              <div class="col-md-12"> 

                <div class="form-group">

              	  <label >DESCRIÇÃO</label>

                  	<textarea class="form-control" rows="4" name="descricao" id="mytextarea"><?=$descricao;?></textarea>

                </div>

              </div>

                

              <div class="col-md-12"> </div>



              <div class="col-md-4"> 

                <div class="form-group">

              	  <label >QUANTIDADE EM ESTOQUE</label>

                  	<input name="qtd" type="number" required="required" class="form-control" id="qtd" min="0" step="1" value="<?=$qtd;?>">

                </div>

              </div>

                

              <div class="col-md-4"> 

                <div class="form-group">

              	  <label >VENDIDOS</label>

                  	<input name="qtd_vendido" type="number" class="form-control" id="qtd_vendido" min="0" step="1" value="<?=$qtd_vendido;?>">

                </div>

              </div>

                

              <div class="col-md-4"> 

                <div class="form-group">

              	  <label >VISTO</label>

                  	<input name="qtd_visto" type="number" class="form-control" id="qtd_visto" min="0" step="1" value="<?=$qtd_visto;?>">

                </div>

              </div>

                

              <div class="col-md-12"> </div>

                                

              <div class="col-md-4"> 

                <div class="form-group">

              	  <label >PREÇO</label>

                  	<input name="preco" type="number" required="required" class="form-control" id="preco" min="0" step="0.01" value="<?=$preco;?>">

                </div>

              </div>



			  <div class="col-md-4"> 

                <div class="form-group">

              	  <label >POR</label>

                  	<input name="por" type="number" class="form-control" id="por" min="0" step="0.01" value="<?=$por;?>">

                </div>

              </div>



			  <div class="col-md-4"> 

                <div class="form-group">

              	  <label >PESO</label>

                  	<input name="peso" type="number" class="form-control" id="peso" min="0" step="1" value="<?=$peso;?>">

                </div>

              </div>

                

              <div class="col-md-12"> </div>



               <div class="col-md-4"> 

                <div class="form-group">

              	  <label >PRONTA ENTREGA</label>

	                <select class="form-control" name="pronta">

                      <option value='sim' <? if ($pronta=="sim") { echo 'selected'; } ?>>Sim</option>

                      <option value='nao' <? if ($pronta!="sim") { echo 'selected'; } ?>>Não</option>

                    </select>

                </div>

              </div>



              <div class="col-md-4"> 

                <div class="form-group">

              	  <label >PROMOÇÃO</label>

	                <select class="form-control" name="promocao">

                      <option value='sim' <? if ($promocao=="sim") { echo 'selected'; } ?>>Sim</option>

                      <option value='nao' <? if ($promocao!="sim") { echo 'selected'; } ?>>Não</option>

                    </select>

                </div>

              </div>

                

              <div class="col-md-4"> 

                <div class="form-group">

              	  <label >DESTAQUE</label>

	                <select class="form-control" name="destaque">

                      <option value='sim' <? if ($destaque=="sim") { echo 'selected'; } ?>>Sim</option>

                      <option value='nao' <? if ($destaque!="sim") { echo 'selected'; } ?>>Não</option>

                    </select>

                </div>

              </div>

                

              <div class="col-md-12"> </div>



			  <div class="col-md-4"> 

                <div class="form-group">

              	  <label >TAMANHO</label>

                  	<input name="tamanho" type="text" class="form-control" id="tamanho" placeholder="" maxlength="255" value="<?=$tamanho;?>">

                </div>

              </div>



              <div class="col-md-4"> 

                <div class="form-group">

              	  <label >COR</label>

                  	<input name="cor" type="text" class="form-control" id="cor" placeholder="" maxlength="255" value="<?=$cor;?>">

                </div>

              </div>

                

              <div class="col-md-4"> 

                <div class="form-group">

              	  <label >SISTEMA</label>

                  	<input name="sistema" type="text" class="form-control" id="sistema" placeholder="" maxlength="255" value="<?=$sistema;?>">

                </div>

              </div>

                

              <div class="col-md-12"> </div>



              <div class="col-md-4"> 

                <div class="form-group">

              	  <label >FORMA</label>

                  	<input name="forma" type="text" class="form-control" id="forma" placeholder="" maxlength="255" value="<?=$forma;?>">

                </div>

              </div>



			  <div class="col-md-4"> 

                <div class="form-group">

              	  <label >PRAZO</label>

                  	<input name="prazo" type="text" class="form-control" id="prazo" placeholder="" maxlength="255" value="<?=$prazo;?>">

                </div>

              </div>

               

			  <div class="col-md-4"> 

                <div class="form-group">

              	  <label >REGIÃO</label>

                  	<input name="regiao" type="text" class="form-control" id="regiao" placeholder="" maxlength="255" value="<?=$regiao;?>">

                </div>

              </div>

               

              <div class="col-md-12"> </div>

                

			  <div class="col-md-4"> 

                <div class="form-group">

              	  <label >FRETE</label>

                  	<input name="frete" type="text" class="form-control" id="frete" placeholder="" maxlength="255" value="<?=$frete;?>">

                </div>

              </div>

               

			  <div class="col-md-4"> 

                <div class="form-group">

              	  <label >FATURAMENTO</label>

                  	<input name="faturamento" type="text" class="form-control" id="faturamento" placeholder="" maxlength="255" value="<?=$faturamento;?>">

                </div>

              </div>



              <div class="col-md-4"> 

                <div class="form-group">

              	  <label >OFERTA</label>

	                <select class="form-control" name="ofertas">

                      <option value='sim' <? if ($ofertas=="sim") { echo 'selected'; } ?>>Sim</option>

                      <option value='nao' <? if ($ofertas!="sim") { echo 'selected'; } ?>>Não</option>

                    </select>

                </div>

              </div>

                

              <div class="col-md-4"> 

                <div class="form-group">

              	  <label >STATUS</label>

	                <select class="form-control" name="status">

                      <option value='a' <? if ($status=="a") { echo 'selected'; } ?>>Ativo</option>

                      <option value='d' <? if ($status!="a") { echo 'selected'; } ?>>Desativado</option>

                    </select>

                </div>

              </div>



              <div class="col-md-12"> </div>

              

              <div class="col-md-12"> 

                <div class="form-group">

              	  <label >TÍTULO DO PRODUTO (SEO)</label>

                  	<input name="titulo_seo" type="text" autofocus class="form-control" id="produto" placeholder="" maxlength="255" value="<?=$titulo_seo;?>">

                </div>

              </div>



              <div class="col-md-12"> </div>

              

              <div class="col-md-12"> 

                <div class="form-group">

              	  <label >DESCRIÇÃO DO PRODUTO (SEO)</label>

                  	<input name="desc_seo" type="text"  autofocus class="form-control" id="produto" placeholder="" maxlength="255" value="<?=$desc_seo;?>">

                </div>

              </div>



              <div class="col-md-12"> </div>

              

              <div class="col-md-12"> 

                <div class="form-group">

              	  <label >PALAVRAS CHAVES DO PRODUTO (SEO)</label>

                  	<input name="palavras_seo" type="text"  autofocus class="form-control" id="produto" placeholder="" maxlength="255" value="<?=$palavras_seo;?>">

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

			<? } ?>              



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



  if ($acao=="gravar_imagem") { 



	$produto = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['produto'], MB_CASE_LOWER, "UTF-8"))));

	$nome = UrlAmigavel($produto);

	  

	if ($nome=="") { $nome="moveis-taubate"; }



	$aleatorio = rand(1,999999);



	if (file_exists($_FILES['destaque']['tmp_name']) || is_uploaded_file($_FILES['destaque']['tmp_name'])) {




		$nome_final = "produto-".$id."-".$nome."-".$aleatorio;



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













//multiplos arquivos

    $caminho = "../assets/img/".$pagina_referencia."/".$id."/";



   if (!is_dir($caminho)){ 

        mkdir("$caminho", 0755);

    }

  $numeroCampos = 8;

  $tamanhoMaximo = 1000000;

  $extensoes = array(".png", ".jpg", ".jpeg", ".gif");

  $substituir = false;



  $produto = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['produto'], MB_CASE_LOWER, "UTF-8"))));

  $nome = UrlAmigavel($produto);

    

  if ($nome=="") { $nome="moveis-taubate"; }





  for ($i = 0; $i < $numeroCampos; $i++) {

  



  $nomeArquivo = $_FILES["arquivo"]["name"][$i];

  $tamanhoArquivo = $_FILES["arquivo"]["size"][$i];

  $nomeTemporario = $_FILES["arquivo"]["tmp_name"][$i];

  $extensao = $_FILES["arquivo"]["type"][$i];



  if ($extensao=="image/gif")

    {

        $extensao = ".gif";

    }

    elseif ($extensao=="image/jpeg" || $extensao=="image/pjpeg")

    {

        $extensao = ".jpg";

    }

    elseif ($extensao=="image/png")

    {

        $extensao = ".png";

    }



  $i_temp = $i+1;



  $aleatorio = rand(1,999999);



  $nome_final = $nome."-".$i_temp."-".$aleatorio.$extensao;



  if (!empty($nomeArquivo)) {

  

    $erro = false;

  

    if ($tamanhoArquivo > $tamanhoMaximo) {

      $erro = "O arquivo " . $nomeArquivo . " não deve ultrapassar " . $tamanhoMaximo. " bytes";

    } 

    elseif (!in_array(strrchr($nomeArquivo, "."), $extensoes)) {

      $erro = "A extensão do arquivo <b>" . $nomeArquivo . "</b> não é válida";

    } 

    elseif (file_exists($caminho . $nomeArquivo) and !$substituir) {

      $erro = "O arquivo <b>" . $nomeArquivo . "</b> já existe";

    }



    if (!$erro) {

      move_uploaded_file($nomeTemporario, ($caminho . $nome_final));

    } 

    else {

      echo $erro . "<br />";

    }

  }

}



//fim multiplo







	 echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia"."-imagem_"."$id'>";

  }

  if(isset($_POST['excluir_imagem'])){

    $foto = $_POST['foto_excluir'];

    if(unlink($foto)){

    }

    else{

      echo "<script>alert('Houve um erro ao deletar o arquivo!');</script>";

    }

    $pasta = '../assets/img/produtos/'.$id.'/';

    $arquivos = glob("$pasta{*.jpg,*.png,*.gif,*.bmp}", GLOB_BRACE);


    foreach($arquivos as $img){} 

    $conta = count($arquivos);

    if ($conta<=0) {

      rmdir($pasta);

    }

  }





    if(isset($_POST['excluir_todas_imagens'])){



      $directory = '../assets/img/produtos/'.$id.'/';

      $directory = escapeshellarg($directory);

      exec("rm -rf $directory");



      

  }

		



  if ($acao=="imagem") { 



	$sql = "SELECT * FROM $pagina_referencia WHERE id='$id'";

	$query = mysqli_query($conexao, $sql);

	  

	$condicao = mysqli_num_rows($query);

	

	while ($dados = mysqli_fetch_assoc($query)) {

		$id = $dados['id'];

		$img = $dados['img'];

		$produto = $dados['produto'];



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





              <div class="col-md-1">

                <div class="form-group">

                  <img src="../assets/img/<?=$pagina_referencia;?>/<?=$img;?>" style="max-width: 100%; max-height: 100px;" >

                </div>

              </div>

              <div class="col-md-4">

                <div class="form-group">

                  <label >FOTO DESTAQUE</label>

                  <input class="form-control" name="destaque" id="destaque" type="file" accept="image/*">

                </div>

              </div>

              

              <div class="col-md-1">

                <div class="form-group">

                </div>

              </div>

              

              

              <div class="col-md-4">

                <div class="form-group">

                  <label >FOTO INTERNA <small>(Máximo de 8 fotos)</small></label>

                  <input type="hidden" name="MAX_FILE_SIZE" value="10485760">

                  <input type="file" name="arquivo[]" value="arquivo" class="form-control" multiple />

                </div>

              </div>

              <div class="col-md-12">

                <div class="form-group">

                  <label></label>

                  <input name="acao" id="acao" value="gravar_imagem" type="hidden">

                  <input name="id" id="id" value="<?=$id;?>" type="hidden">

                  <input name="produto" id="categoria" value="<?=$produto;?>" type="hidden">

                  <button type="submit" name="enviar" value="enviar" class="btn btn-success" style="float:right;"><i class="fa fa-check"></i> Atualizar Imagem </button>

                </div>

              </div>

              </div>

              </div>

              </div>

              

        <div class="col-lg-12 ">

          <div class="panel panel-default ">

            <div class="panel-body">

              <div class="col-md-12"> 

                <h3>Imagens já cadastradas</h3>

                <p>Verifique suas imagens já cadastradas para esse produto, caso deseje excluir alguma, basta clicar no botão vermelho.</p><br><br>

                 <?

                $pasta = '../assets/img/produtos/'.$id.'/';

                $arquivos = glob("$pasta{*.jpg,*.png,*.gif,*.bmp}", GLOB_BRACE);

                foreach($arquivos as $img){

                  $aleatorio = rand(1,999999);

                ?>

                <div class="col-md-2">

                 

                 <a class="thumb-image" href="<?=$img;?>" data-index="0" rel="lightbox[plants]">

                  

                  <div class="col-md-2" style="background-image: url(<?=$img;?>); width: 150px; height: 150px; background-size: cover; padding: 15px; margin:15px;"></div>

                

                </a>

                <input type="hidden" name="foto_excluir" value="<?=$img;?>">

                <a href="#" data-toggle="modal" data-target="#myModal<?=$aleatorio;?>">

                   <button type="button" class="btn btn-danger" style="width: 153px; margin-left: 14px;"><i class='fa fa-trash'></i> Excluir</button>

                </a>



                <div class="modal fade" id="myModal<?=$aleatorio;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                  <div class="modal-dialog modal-lg">

                    <div class="modal-content">

                      <div class="modal-header">



                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                      <h4 class="modal-title" id="myModalLabel3">REMOVER ITEM</h4>

                      

                      </div>





                      <div class="modal-body">Confirma a exclusão deste item? Após a confirmação o mesmo não poderá ser desfeito. </div>

                      <div class="modal-footer">



                       <form name="deleta_imagem" method="POST" action="">



                        <input type="hidden" name="foto_excluir" value="<?=$img;?>">



                        <button type="submit" name="excluir_imagem"  class="btn btn-danger" role="button">

                          <i class='fa fa-trash'></i> Sim, desejo excluir

                        </button>



                      </form>



                      <button type="button" class="btn btn-light" data-dismiss="modal">NÃO</button>



                      </div>

                    </div>

                  </div>

                </div>

              </div>

             <?}

              $conta = count($arquivos);

              if ($conta<=0) {

                echo '<h3 style="color:#ccc;">Nenhuma imagem cadastrada no momento.</h3>';

              }

              ?>

              </div>

        </div>

      </div>

    </div>

            <div class="col-lg-12 ">

          <div class="panel panel-default ">

            <div class="panel-body">

              

              <div class="col-md-12"> 

                <h3>Excluir todas as imagens</h3>

                <p>Abaixo você poderá excluir todas as imagens cadastradas desse produto.</p><br><br>

     <div class="col-md-12">

            

                  <a href="#" data-toggle="modal" data-target="#myModal_excluir_todas">

                    <button type="button" class="btn btn-danger" style="float: right;"><i class='fa fa-trash'></i> Excluir todas as imagens</button>

                  </a>

            







            <div class="modal fade" id="myModal_excluir_todas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

            <div class="modal-dialog modal-lg">

            <div class="modal-content">

              <div class="modal-header">

              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

              <h4 class="modal-title" id="myModalLabel3">REMOVER TODOS AS FOTOS</h4>

              </div>

              <div class="modal-body">Confirma a exclusão de todos as fotos desse produto? Após a confirmação o mesmo não poderá ser desfeito. </div>

              <div class="modal-footer">



               <form name="deleta_todas_imagens" method="POST" action="">                  

                <button type="submit" name="excluir_todas_imagens"  class="btn btn-danger" role="button"><i class='fa fa-trash'></i> Sim, desejo excluir</button>

                

              </form>





              <button type="button" class="btn btn-light" data-dismiss="modal">NÃO</button>

              </div>

            </div>

            <!-- /.modal-content --> 

            </div>

            <!-- /.modal-dialog --> 

          </div>

              </div>

              </div>











































<?

if(is_dir("../img/produtos/$id/"))

	if ($handle = opendir("../img/produtos/$id/")) {

		while (false !== ($file = readdir($handle))) {

			if($file == "." || $file == ".." || $file == "index.htm" || $file == "index.html" ){ } else{

	?>

              <div class="col-md-12">

                <div class="form-group">

                  <label></label>

		<?php

			echo "<center><a href='inicial.php?pag=".$nome_pag."_imagem_excluir&id=$id&arquivo=produtos/$id/$file'>";

			echo "<div align='center' style='height:150px'><img src='../img/produtos/$id/$file' style='max-width:220px; max-height:150px;' /></div>";

			echo "<strong>EXCLUIR</strong></a></center>";

		?>

                </div>

              </div>

	<?

			}		

		}

		closedir($handle);

	}

}

?>

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

              <th>FOTO</th>

              <th>PRODUTO</th>

              <th>CATEGORIA</th>

              <th>PREÇO</th>

              <th>QTD</th>

              <th>VENDIDO</th>

              <th>VISTO</th>

              <th>AÇÕES</th>

            </tr>

          </thead>

          <tbody>

	<?

	$sql = "SELECT id, categoria FROM categorias WHERE status='a' ORDER BY categoria ASC";

	$query = mysqli_query($conexao, $sql);

			

	while ($dados = mysqli_fetch_assoc($query)) {

		$id = $dados['id'];

		$categorias[$id] = $dados['categoria'];

	}

	mysqli_free_result($query);

				

	$sql = "SELECT * FROM $pagina_referencia WHERE status='d' ORDER BY categoria ASC";

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

		$tamanho = $dados['tamanho'];

		$cor = $dados['cor'];

		$sistema = $dados['sistema'];

		$ofertas = $dados['ofertas'];

		

		if(file_exists("../assets/img/$pagina_referencia/$img")){ } else{ $img = "sem_imagem.jpg"; }



		if ($classe=="odd") { $classe="even "; } else {$classe="odd"; }

?>



            <tr class="<?=$classe;?>">

              <td class="center"><?=$id;?></td>

              <td class="center"><img src="../assets/img/<?=$pagina_referencia;?>/<?=$img;?>" alt="<?=$categoria;?>" title="<?=$categoria;?>" class="gridpic"></td>

              <td><?=$produto;?></td>

              <td><? if (isset($categorias[$categoria])) { echo $categorias[$categoria]; } else { echo "<span class='status btn-danger'>Não Localizada</span>"; };?></td>

              <td class="center">R$ <? if ($por!='0.00') { echo $por; } else { echo $preco; };?></td>

              <td class="center"><?=$qtd;?></td>

              <td class="center"><?=$qtd_vendido;?></td>

              <td class="center"><?=$qtd_visto;?></td>

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

<script src="../lightbox/js/jquery-1.7.2.min.js"></script>

       <script src="../lightbox/js/lightbox.js"></script>

       <link href="../lightbox/css/lightbox.css" rel="stylesheet" />

     <script type="text/javascript">

       $(function () {

           $('#gallery a').lightBox();

       });

    </script>



<!-- Custom Theme JavaScript --> 

<script src="js/adminnine.js"></script> 

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

