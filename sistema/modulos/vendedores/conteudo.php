<?php
  include_once "config.php";
  $pagina_titulo = "vendedores";
  $pagina_referencia = "vendedores";
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
	$responsavel_nome = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['responsavel_nome'], MB_CASE_TITLE, "UTF-8"))));
	$email = trim(addslashes(htmlspecialchars($_POST['email'])));
	$senha = trim(addslashes(htmlspecialchars($_POST['senha'])));
	$confirma_senha = trim(addslashes(htmlspecialchars($_POST['confirma_senha'])));
	$cpf_cnpj = trim(addslashes(htmlspecialchars($_POST['cpf_cnpj'], MB_CASE_TITLE, "UTF-8")));
	$data_nascimento = trim(addslashes(htmlspecialchars($_POST['data_nascimento'], MB_CASE_TITLE, "UTF-8")));
    $celular = trim(addslashes(htmlspecialchars($_POST['celular'], MB_CASE_TITLE, "UTF-8")));
	$whatsapp = trim(addslashes(htmlspecialchars($_POST['whatsapp'], MB_CASE_TITLE, "UTF-8")));
    $sexo = trim(addslashes(htmlspecialchars($_POST['sexo'], MB_CASE_TITLE, "UTF-8")));
	$estado_civil = trim(addslashes(htmlspecialchars($_POST['estado_civil'], MB_CASE_TITLE, "UTF-8")));
    //recupera localidade e contato [localidade]
	$cep = trim(addslashes(htmlspecialchars($_POST['cep'], MB_CASE_TITLE, "UTF-8")));
	$endereco = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['endereco'], MB_CASE_TITLE, "UTF-8"))));
	$numero = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['numero'], MB_CASE_TITLE, "UTF-8"))));
	$bairro = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['bairro'], MB_CASE_TITLE, "UTF-8"))));
	$cidade = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['cidade'], MB_CASE_TITLE, "UTF-8"))));
	$estado = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['estado'], MB_CASE_TITLE, "UTF-8"))));
	$complemento = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['complemento'], MB_CASE_TITLE, "UTF-8"))));
	$pto_referencia = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['pto_referencia'], MB_CASE_TITLE, "UTF-8"))));

	$tipo = $_POST['tipo'];
	  
    $data_cadastro = date('Y-m-d');
    $hora_cadastro = date('H:i:s');
    $ip = $_SERVER['REMOTE_ADDR'];
    $endereco_ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);

    $query = ("SELECT email FROM $pagina_referencia WHERE email = '".$email."'");
    $resultado = mysqli_query($conexao, $query);
    $total = mysqli_num_rows($resultado);
    if ($total > 0){
      echo '<script>alert("Já possuímos um cadastro com esses dados informados!");</script>';
      echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia-cadastrar'>";
      exit;
    }elseif($senha!==$confirma_senha) {
      echo '<script>alert("As senhas não conferem, por favor, digite senhas iguais.");</script>';
      echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia-cadastrar'>";
      exit;
    }else{

      $insere = "INSERT INTO $pagina_referencia (responsavel_nome, email, senha, cpf_cnpj, data_nascimento, celular, whatsapp, sexo, estado_civil, cep, endereco, numero, bairro, cidade, estado, complemento, pto_referencia, tipo, status, ip, endereco_ip, data_cadastro, hora_cadastro) VALUES ('$responsavel_nome', '$email', '".sha1($senha)."', '$cpf_cnpj', '$data_nascimento', '$celular', '$whatsapp', '$sexo', '$estado_civil', '$cep', '$endereco', '$numero', '$bairro', '$cidade', '$estado', '$complemento', '$pto_referencia', '$tipo', 'a', '$ip', '$endereco_ip', '$data_cadastro', '$hora_cadastro')" or die(mysqli_error());

      if (!mysqli_query($conexao, $insere)) {
        die('Erro: '.mysqli_error($conexao));
      } else {
        $ultimo_id = mysqli_insert_id($conexao);
        if (file_exists($_FILES['foto']['tmp_name']) || is_uploaded_file($_FILES['foto']['tmp_name'])) {

          $nome = UrlAmigavel($responsavel_nome);

          if ($nome=="") { $nome="vendedor"; }

          $aleatorio = rand(1,999999);

          $nome = "vendedor-".$ultimo_id."-".$nome."-".$aleatorio;

          $set_img_path = "../assets/img/".$pagina_referencia;
          $imgarray = array("image/pjpeg", "image/jpeg", "image/gif", "image/png", "image/x-png");

          if (!$_FILES['foto']['size'])
          {
            echo "<p>Foto recusada devido ao tamanho do mesmo.</p>";
            exit;

          }		
          if (!in_array($_FILES['foto']['type'],$imgarray))
          {
            echo "<p>É somente aceito arquivos de imagens (GIF, JPG e PNG).</p>";
            exit;
          }		

          if ($_FILES['foto']['size']>$set_max_bytes_allowed)
          {
            echo "<p>Tamanho do Arquivo é maior que o limite de:</p>". $set_max_bytes_allowed / 1000 ."Kb.";
            exit;
          }		

          if ($_FILES['foto']['type']=="image/gif")
          {
              $ext = ".gif";
          }
          elseif ($_FILES['foto']['type']=="image/jpeg" || $_FILES['foto']['type']=="image/pjpeg")
          {
              $ext = ".jpg";

          }
          elseif ($_FILES['foto']['type']=="image/png")
          {
              $ext = ".png";
          }

          $img_foto = $nome.$ext;
          move_uploaded_file($_FILES['foto']['tmp_name'], "$set_img_path/$img_foto");

          chmod ("$set_img_path/$img_foto", 0755);

          $update = "UPDATE $pagina_referencia SET foto='".$img_foto."' WHERE id='".$ultimo_id."' "  or die(mysqli_error());

          if (!mysqli_query($conexao, $update)) { die('Erro: '.mysqli_error($conexao)); }
        }

        $usuarios = "INSERT INTO usuarios (usuario, senha, email, nivel, funcionario, nome, data_cadastro, hora_cadastro, ativo) VALUES ('$email', '".sha1($senha)."', '$email', '$tipo', '$ultimo_id', '$responsavel_nome', '$data_cadastro', '$hora_cadastro', 'a')" or die(mysqli_error());
        $query_usuarios = mysqli_query($conexao, $usuarios);
        
        echo "<script>alert('Cadastrado com sucesso!');</script>";
        echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";

      }
    }
  }

  if ($acao=="cadastrar") { ?>
    <div class="row">
      <div class="col-md-12  header-wrapper">
        <h1 class="page-header"><?=mb_convert_case("$pagina_titulo", MB_CASE_TITLE, "UTF-8");?> - Cadastrar</h1>
        <p class="page-subtitle">Para cadastrar um novo item, preencha os dados abaixo.</p>
      </div>
    </div>
    
    <form method="post" action="" enctype="multipart/form-data">
      <div class="row">
        <div class="col-lg-12 ">
          <div class="panel panel-default ">
            <div class="panel-body ">
              <h3>Informações Sociais</h3>
              <p>Preencha os campos abaixo.</p>
              <hr>
              <div class="col-md-6">
                <div class="form-group">
                  <label >NOME</label>
                  <input class="form-control" id="responsavel_nome" type="text" placeholder="Nome Completo" name="responsavel_nome" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>E-MAIL</label>
                  <input class="form-control" name="email" type="email" placeholder="E-mail" required>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>SENHA</label>
                  <input class="form-control" name="senha" id="senha" type="password" placeholder="Senha" required>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>CONFIRMAÇÃO DA SENHA</label>
                  <input class="form-control" name="confirma_senha" id="confirma_senha" type="password" placeholder="Confirmação da Senha" onblur="validaSenha();" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>CPF/CNPJ</label>
                  <input class="form-control cpfOuCnpj" id="cpf_cnpj" type="text" placeholder="CPF/CNPJ" name="cpf_cnpj" onkeyup="mascara(this, cpfcnpj)" maxlength="18">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>CELULAR</label>
                  <input class="form-control cel" id="celular" name="celular" placeholder="Celular">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label ><i class="fa fa-warning" style="color:#fd8526;"></i> CELULAR É WHATSAPP?</label>
                  <select class="form-control" name="whatsapp">
                    <option value="sim">Sim</option>
                    <option value="nao">Não</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>DATA NASCIMENTO</label>
                  <input class="form-control data" id="data_nascimento" type="text" placeholder="Data Nascimento" name="data_nascimento">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>SEXO</label>
                  <select class="form-control" name="sexo">
                    <option value="masculino">Masculino</option>
                    <option value="feminino">Feminino</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>ESTADO CIVIL</label>
                  <select class="form-control" name="estado_civil">
                    <option value="solteiro">Solteiro(a)</option>
                    <option value="casado">Casado(a)</option>
                    <option value="divorciado">Divorciado(a)</option>
                    <option value="viuvo">Viúvo(a)</option>
                    <option value="separado">Separado(a)</option>
                    <option value="uniao">União Estável</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.col-lg-12 -->
      </div>
      <!-- /.row -->
      <div class="row ">
        <div class="col-lg-12 ">
          <div class="panel panel-default ">
            <div class="panel-body ">
              <h3>Informações de localidade</h3>
              <p>Preencha as informaçãs de localidade.</p>
              <hr>
              <div class="col-md-2">
                <div class="form-group">
                  <label>CEP</label>
                  <input class="form-control cep" type="text" placeholder="CEP" id="cep" name="cep" maxlength="9">
                </div>
              </div>
              <div class="col-md-8">
                <div class="form-group">
                  <label>ENDEREÇO</label>
                  <input class="form-control" id="logradouro"  name="endereco" placeholder="Endereço">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>NÚMERO</label>
                  <input class="form-control" name="numero" id="numero" placeholder="Número">
                </div>
              </div>
              
			  <div class="col-md-12"></div>
             
              <div class="col-md-4">
                <div class="form-group">
                  <label>BAIRRO</label>
                  <input class="form-control" id="bairro" name="bairro" placeholder="Bairro">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>CIDADE</label>
                  <input class="form-control" id="cidade" name="cidade" placeholder="Cidade">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>ESTADO</label>
                  <input class="form-control" id="estado"  name="estado" placeholder="Estado">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>COMPLEMENTO</label>
                  <input class="form-control" id="complemento" name="complemento" placeholder="Complemento">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>PONTO DE REFERÊNCIA</label>
                  <input class="form-control" id="pto_referencia" name="pto_referencia" placeholder="Ponto de Referencia">
                </div>
              </div>
              
            </div>
          </div>
        </div>
        <!-- /.col-lg-12 -->
      </div>
      <!-- /.row -->
      <div class="row ">
        <div class="col-lg-12 ">
          <div class="panel panel-default">
            <div class="panel-body ">
              <h3>Informações Complementares</h3>
              <p>Preencha as informações complementares.</p>
              <hr>
              <div class="col-md-6">
                <div class="form-group">
                  <label>FOTO</label>
                  <input class="form-control" name="foto" id="foto" type="file" accept="image/*">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>TIPO</label>
                  <select class="form-control" name="tipo">
                    <option value="20">Vendedor</option>
                    <option value="10">Administrador</option>
                  </select>
                </div>
              </div>
              
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

  if ($acao=="gravar_editar") {

    $id = $_POST['id'];
  
    $responsavel_nome = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['responsavel_nome'], MB_CASE_TITLE, "UTF-8"))));
    $email = trim(addslashes(htmlspecialchars($_POST['email'])));
    $senha = trim(addslashes(htmlspecialchars($_POST['senha'])));
    $confirma_senha = trim(addslashes(htmlspecialchars($_POST['confirma_senha'])));
    $cpf_cnpj = trim(addslashes(htmlspecialchars($_POST['cpf_cnpj'])));
    $data_nascimento = trim(addslashes(htmlspecialchars($_POST['data_nascimento'])));
    $celular = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['celular'], MB_CASE_TITLE, "UTF-8"))));
    $whatsapp = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['whatsapp'], MB_CASE_TITLE, "UTF-8"))));
    $sexo = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['sexo'], MB_CASE_TITLE, "UTF-8"))));
    $estado_civil = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['estado_civil'], MB_CASE_TITLE, "UTF-8"))));
    //recupera localidade e contato [localidade]
    $cep = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['cep'], MB_CASE_TITLE, "UTF-8"))));
    $endereco = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['endereco'], MB_CASE_TITLE, "UTF-8"))));
    $numero = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['numero'], MB_CASE_TITLE, "UTF-8"))));
    $bairro = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['bairro'], MB_CASE_TITLE, "UTF-8"))));
    $cidade = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['cidade'], MB_CASE_TITLE, "UTF-8"))));
    $estado = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['estado'], MB_CASE_TITLE, "UTF-8"))));
    $complemento = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['complemento'], MB_CASE_TITLE, "UTF-8"))));
    $pto_referencia = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['pto_referencia'], MB_CASE_TITLE, "UTF-8"))));
  
    $data_editar = date('Y-m-d');
    $hora_editar = date('H:i:s');
  
    if($senha == $confirma_senha){
  
      $update = "UPDATE $pagina_referencia SET responsavel_nome='$responsavel_nome', email='$email', senha='$senha', cpf_cnpj='$cpf_cnpj', data_nascimento='$data_nascimento', celular='$celular', whatsapp='$whatsapp', sexo='$sexo', estado_civil='$estado_civil', cep='$cep', endereco='$endereco', numero='$numero', bairro='$bairro', cidade='$cidade', estado='$estado', complemento='$complemento', pto_referencia='$pto_referencia', data_editar='$data_editar', hora_editar='$hora_editar' WHERE id='".$id."'" or die(mysqli_error());
  
      if (!mysqli_query($conexao, $update)) {
        die('Error: '.mysqli_error($conexao));
      } else {

        $nome = UrlAmigavel($responsavel_nome);
        if ($nome=="") { $nome=$url_amigavel_loja; }
        $aleatorio = rand(1,999999);

        if (file_exists($_FILES['foto']['tmp_name']) || is_uploaded_file($_FILES['foto']['tmp_name'])) {
          $nome_final = "vendedor-".$id."-".$nome."-".$aleatorio;
          $set_img_path = "../assets/img/".$pagina_referencia;
          $imgarray = array("image/pjpeg", "image/jpeg", "image/gif", "image/png", "image/x-png");
          if (!$_FILES['foto']['size'])
          {
            echo "<p>Arquivo recusado devido ao tamanho do mesmo.</p>";
            exit;
          }   
          if (!in_array($_FILES['foto']['type'],$imgarray))
          {
            echo "<p>É somente aceito arquivos de imagens (GIF, JPG e PNG).</p>";
            exit;
          }   
          if ($_FILES['foto']['size']>$set_max_bytes_allowed)
          {
            echo "<p>Tamanho do Arquivo é maior que o limite de:</p>". $set_max_bytes_allowed / 1000 ."Kb.";
            exit;
          }   
          if ($_FILES['foto']['type']=="image/gif")
          {
              $ext = ".gif";
          }
          elseif ($_FILES['foto']['type']=="image/jpeg" || $_FILES['foto']['type']=="image/pjpeg")
          {
              $ext = ".jpg";
          }
          elseif ($_FILES['foto']['type']=="image/png")
          {
              $ext = ".png";
          }
          $img = $nome_final.$ext;
          move_uploaded_file($_FILES['foto']['tmp_name'], "$set_img_path/$img");
          chmod ("$set_img_path/$img", 0755);
          
          $ip = $_SERVER['REMOTE_ADDR'];
          $endereco_ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);

          $update = "UPDATE $pagina_referencia SET foto='".$img."', ip='$ip', endereco_ip='$endereco_ip', data_editar='".date('Y-m-d')."', hora_editar='".date('H:i:s')."' WHERE id='".$id."' "  or die(mysqli_error());
          if (!mysqli_query($conexao, $update)) { die('Erro: '.mysqli_error($conexao)); }
        }
        if($senha!='' AND $confirma_senha!='' AND $senha == $confirma_senha){
          $usuarios = "UPDATE usuarios SET usuario='$email', senha='".sha1($senha)."', email='$email', nivel='20', nome='$responsavel_nome', ativo='a' WHERE funcionario ='$id'" or die(mysqli_error());
          $query_usuarios = mysqli_query($conexao, $usuarios);
        }
  
        echo "<script>alert('Atualizado com sucesso!');</script>";
        echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia-editar_$id'>";
      }
    }else{
      echo "<script>alert('Senhas são diferentes!');</script>";
      echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";
    }
  }

  if ($acao=="editar") { 

	$sql = "SELECT * FROM $pagina_referencia WHERE id='$usr_funcionario'";
	$query = mysqli_query($conexao, $sql);
	  
	$condicao = mysqli_num_rows($query);
	
	while ($dados = mysqli_fetch_assoc($query)) {
	$id = $dados['id'];
	$responsavel_nome = $dados['responsavel_nome'];
	$email = $dados['email'];
	$cpf_cnpj = $dados['cpf_cnpj'];
	$celular = $dados['celular'];
    $whatsapp = $dados['whatsapp'];
    $data_nascimento = $dados['data_nascimento'];
    $sexo = $dados['sexo'];
    $estado_civil = $dados['estado_civil'];
    $cep = $dados['cep'];
    $endereco = $dados['endereco'];
    $numero = $dados['numero'];
    $bairro = $dados['bairro'];
    $cidade = $dados['cidade'];
    $estado = $dados['estado'];
    $complemento = $dados['complemento'];
    $pto_referencia = $dados['pto_referencia'];
    $foto = $dados['foto'];

    if ($dados['foto']=='') {
      $imagem = '../assets/img/'.$pagina_referencia.'/sem_imagem.jpg';
    } elseif(file_exists('../assets/img/'.$pagina_referencia.'/'.$foto.'')){
      $imagem = '../assets/img/'.$pagina_referencia.'/'.$foto.'';
    } else {
      $imagem = "../assets/img/$pagina_referencia/sem_imagem.jpg";
    }

    $tipo = $dados['tipo'];
    $usuarios = explode(",", $tipo);                
    $tipo_arr = array(1 => "Administrador", 2 => "Vendedor");
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
            <div class="panel-body ">
              <h3>Informações Sociais</h3>
              <p>Preencha os campos abaixo.</p>
              <hr>
              <div class="col-md-6">
                <div class="form-group">
                  <label >NOME</label>
                  <input class="form-control" id="responsavel_nome" type="text" placeholder="Nome Completo" name="responsavel_nome" value="<?=$responsavel_nome;?>"required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>E-MAIL</label>
                  <input class="form-control" name="email" type="email" placeholder="E-mail" value="<?=$email;?>"required>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>SENHA</label>
                  <input class="form-control" name="senha" id="senha" type="password" placeholder="Senha">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>CONFIRMAÇÃO DA SENHA</label>
                  <input class="form-control" name="confirma_senha" id="confirma_senha" type="password" placeholder="Confirmação da Senha" onblur="validaSenha();">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>CPF/CNPJ</label>
                  <input class="form-control cpfOuCnpj" id="cpf_cnpj" type="text" placeholder="CPF/CNPJ" name="cpf_cnpj" onkeyup="mascara(this, cpfcnpj)" maxlength="18" value="<?=$cpf_cnpj;?>" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>CELULAR</label>
                  <input class="form-control cel" id="celular" name="celular" placeholder="Celular" value="<?=$celular;?>" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label ><i class="fa fa-warning" style="color:#fd8526;"></i> CELULAR É WHATSAPP?</label>
                  <select class="form-control" name="whatsapp">
                    <option value="sim" <?=(($whatsapp=='sim')?'selected':'')?>>Sim</option>
                    <option value="nao" <?=(($whatsapp=='nao')?'selected':'')?>>Não</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>DATA NASCIMENTO</label>
                  <input class="form-control data" id="data_nascimento" type="text" placeholder="Data Nascimento" name="data_nascimento" value="<?=$data_nascimento;?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>SEXO</label>
                  <select class="form-control" name="sexo">
                    <option value="masculino" <?=(($sexo=='masculino')?'selected':'')?>>Masculino</option>
                    <option value="feminino" <?=(($sexo=='feminino')?'selected':'')?>>Feminino</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>ESTADO CIVIL</label>
                  <select class="form-control" name="estado_civil">
                    <option value="solteiro" <?=(($estado_civil=='solteiro')?'selected':'')?>>Solteiro(a)</option>
                    <option value="casado" <?=(($estado_civil=='casado')?'selected':'')?>>Casado(a)</option>
                    <option value="divorciado" <?=(($estado_civil=='divorciado')?'selected':'')?>>Divorciado(a)</option>
                    <option value="viuvo" <?=(($estado_civil=='viuvo')?'selected':'')?>>Viúvo(a)</option>
                    <option value="separado" <?=(($estado_civil=='separado')?'selected':'')?>>Separado(a)</option>
                    <option value="uniao" <?=(($estado_civil=='uniao')?'selected':'')?>>União Estável</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.col-lg-12 -->
      </div>
      <!-- /.row -->
      <div class="row ">
        <div class="col-lg-12 ">
          <div class="panel panel-default ">
            <div class="panel-body ">
              <h3>Informações de localidade</h3>
              <p>Preencha as informaçãs de localidade.</p>
              <hr>
              <div class="col-md-2">
                <div class="form-group">
                  <label>CEP</label>
                  <input class="form-control cep" type="text" placeholder="CEP" id="cep" name="cep" maxlength="9" value="<?=$cep;?>" required>
                </div>
              </div>
              <div class="col-md-8">
                <div class="form-group">
                  <label>ENDEREÇO</label>
                  <input class="form-control" id="logradouro"  name="endereco" placeholder="Endereço" value="<?=$endereco;?>" required>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>NÚMERO</label>
                  <input class="form-control" name="numero" id="numero" placeholder="Número" value="<?=$numero;?>" required>
                </div>
              </div>
              
			  <div class="col-md-12"></div>
             
              <div class="col-md-4">
                <div class="form-group">
                  <label>BAIRRO</label>
                  <input class="form-control" id="bairro" name="bairro" placeholder="Bairro" value="<?=$bairro;?>" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>CIDADE</label>
                  <input class="form-control" id="cidade" name="cidade" placeholder="Cidade" value="<?=$cidade;?>" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>ESTADO</label>
                  <input class="form-control" id="estado"  name="estado" placeholder="Estado" value="<?=$estado;?>" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>COMPLEMENTO</label>
                  <input class="form-control" id="complemento" name="complemento" placeholder="Complemento" value="<?=$complemento;?>" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>PONTO DE REFERÊNCIA</label>
                  <input class="form-control" id="pto_referencia" name="pto_referencia" placeholder="Ponto de Referencia" value="<?=$pto_referencia;?>" required>
                </div>
              </div>
              
            </div>
          </div>
        </div>
        <!-- /.col-lg-12 -->
      </div>
      <!-- /.row -->
      <div class="row ">
        <div class="col-lg-12 ">
          <div class="panel panel-default">
            <div class="panel-body ">
              <h3>Informações Complementares</h3>
              <p>Preencha as informações complementares.</p>
              <hr>
              <div class="col-md-2">
                <div class="form-group">
                  <img src="<?=$imagem;?>" style="max-width: 100%; max-height: 100px;">
                </div>
              </div>
              <div class="col-md-9">
                <div class="form-group">
                  <label>FOTO</label>
                  <input class="form-control" name="foto" id="foto" type="file" accept="image/*">
                </div>
              </div>
              
              <div class="col-md-12">
                <div class="form-group">
                  <label></label>
                  <input name="id" id="id" value="<?=$id;?>" type="hidden">
                  <input name="acao" id="acao" value="gravar_editar" type="hidden">
                  <button type="submit" name="enviar" value="enviar" class="btn btn-success" style="float:right;"><i class="fa fa-check"></i> Editar </button>
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
if (isset($_POST['atualizar'])) {
		
  $id = $_POST['id'];
  
  $responsavel_nome = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['responsavel_nome'], MB_CASE_TITLE, "UTF-8"))));
  $email = trim(addslashes(htmlspecialchars($_POST['email'])));
  $cpf_cnpj = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['cpf_cnpj'], MB_CASE_TITLE, "UTF-8"))));
  $data_nascimento = date('Y-m-d', strtotime($_POST['data_nascimento']));
  $celular = trim(addslashes(htmlspecialchars($_POST['celular'])));
  $whatsapp = trim(addslashes(htmlspecialchars($_POST['whatsapp'])));
  $sexo = trim(addslashes(htmlspecialchars($_POST['sexo'], MB_CASE_TITLE, "UTF-8")));
  $estado_civil = trim(addslashes(htmlspecialchars($_POST['estado_civil'], MB_CASE_TITLE, "UTF-8")));
  //recupera localidade e contato [localidade]
  $cep = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['cep'], MB_CASE_TITLE, "UTF-8"))));
  $endereco = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['endereco'], MB_CASE_TITLE, "UTF-8"))));
  $numero = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['numero'], MB_CASE_TITLE, "UTF-8"))));
  $bairro = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['bairro'], MB_CASE_TITLE, "UTF-8"))));
  $cidade = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['cidade'], MB_CASE_TITLE, "UTF-8"))));
  $estado = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['estado'], MB_CASE_TITLE, "UTF-8"))));
  $complemento = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['complemento'], MB_CASE_TITLE, "UTF-8"))));
  $pto_referencia = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['pto_referencia'], MB_CASE_TITLE, "UTF-8"))));
  
  $tipo = $_POST['tipo'];

  $data_editar = date('Y-m-d');
  $hora_editar = date('H:i:s');

    $update = "UPDATE $pagina_referencia SET responsavel_nome='$responsavel_nome', email='$email', senha='$senha', cpf_cnpj='$cpf_cnpj', data_nascimento='$data_nascimento', celular='$celular', whatsapp='$whatsapp', sexo='$sexo', estado_civil='$estado_civil', cep='$cep', endereco='$endereco', numero='$numero', bairro='$bairro', cidade='$cidade', estado='$estado', complemento='$complemento', pto_referencia='$pto_referencia', tipo='$tipo', data_editar='$data_editar', hora_editar='$hora_editar' WHERE id='".$id."'" or die(mysqli_error());

    if (!mysqli_query($conexao, $update)) {
      die('Error: '.mysqli_error($conexao));
    } else {

      $nome = UrlAmigavel($responsavel_nome);
      if ($nome=="") { $nome=$url_amigavel_loja; }
      $aleatorio = rand(1,999999);

      if (file_exists($_FILES['foto']['tmp_name']) || is_uploaded_file($_FILES['foto']['tmp_name'])) {
          $nome_final = "vendedor-".$id."-".$nome."-".$aleatorio;
          $set_img_path = "../assets/img/".$pagina_referencia;
          $imgarray = array("image/pjpeg", "image/jpeg", "image/gif", "image/png", "image/x-png");
          if (!$_FILES['foto']['size'])
          {
            echo "<p>Arquivo recusado devido ao tamanho do mesmo.</p>";
            exit;
          }   
          if (!in_array($_FILES['foto']['type'],$imgarray))
          {
            echo "<p>É somente aceito arquivos de imagens (GIF, JPG e PNG).</p>";
            exit;
          }   
          if ($_FILES['foto']['size']>$set_max_bytes_allowed)
          {
            echo "<p>Tamanho do Arquivo é maior que o limite de:</p>". $set_max_bytes_allowed / 1000 ."Kb.";
            exit;
          }   
          if ($_FILES['foto']['type']=="image/gif")
          {
              $ext = ".gif";
          }
          elseif ($_FILES['foto']['type']=="image/jpeg" || $_FILES['foto']['type']=="image/pjpeg")
          {
              $ext = ".jpg";
          }
          elseif ($_FILES['foto']['type']=="image/png")
          {
              $ext = ".png";
          }
          $img = $nome_final.$ext;
          move_uploaded_file($_FILES['foto']['tmp_name'], "$set_img_path/$img");
          chmod ("$set_img_path/$img", 0755);
          
          $ip = $_SERVER['REMOTE_ADDR'];
          $endereco_ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);

          $update = "UPDATE $pagina_referencia SET foto='".$img."', ip='$ip', endereco_ip='$endereco_ip', data_editar='".date('Y-m-d')."', hora_editar='".date('H:i:s')."' WHERE id='".$id."' "  or die(mysqli_error());
          if (!mysqli_query($conexao, $update)) { die('Erro: '.mysqli_error($conexao)); }
      }

      $usuarios = "UPDATE usuarios SET email='$email', nivel='$tipo', nome='$responsavel_nome', ativo='a' WHERE funcionario='$id'" or die(mysqli_error());
      $query_usuarios = mysqli_query($conexao, $usuarios);

      echo "<script>alert('Atualizado com sucesso!');</script>";
      echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";
      exit;
    }
}
if (isset($_POST['atualizar_senha'])) {
		
	$id = $_POST['id'];

	$senha = sha1($_POST['senha']);
	$nova_senha = sha1($_POST['confirma_senha']);
	
	if($senha == $nova_senha){

		$update = "UPDATE usuarios SET senha='$senha' WHERE funcionario='".$id."'"  or die(mysqli_error());

		if (!mysqli_query($conexao, $update)) {
			die('Error: '.mysqli_error($conexao));
		} else {
			echo "<script>alert('Atualizado com sucesso!');</script>";
			echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";
		}
	}else{
		echo "<script>alert('Senhas são diferentes!');</script>";
		echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";
	}
}
if (isset($_POST['remover']) AND $_POST['remover']=='remover') {
    $id = (int)$_POST['id'];

    $update = "UPDATE $pagina_referencia SET status='e', data_editar='".date("Y-m-d")."', hora_editar='".date("H:i:s")."' WHERE id='$id'" or die(mysqli_error());
    if (!mysqli_query($conexao, $update)) {
      die('Erro: '.mysqli_error($conexao));
    }else{
        $update_usr = "UPDATE usuarios SET ativo='d' WHERE funcionario='$id'" or die(mysqli_error());
        if (!mysqli_query($conexao, $update_usr)) {
          die('Erro: '.mysqli_error($conexao));
        }else{
            echo "<script>alert('Excluído com sucesso!');</script>";
            echo "<meta http-equiv='refresh' content='0'>";
            exit();
        }
    }
}
if (isset($_POST['excluir']) AND $_POST['excluir']=='excluir') {
    $id = (int)$_POST['id'];
    
    $update_vendedor = "UPDATE vendedores SET status='d' WHERE id='$id'" or die(mysqli_error());
    if (!mysqli_query($conexao, $update_vendedor)) {
      die('Erro: '.mysqli_error($conexao));
    }else{
        $update_usr = "UPDATE usuarios SET ativo='d' WHERE funcionario='$id'" or die(mysqli_error());
        if (!mysqli_query($conexao, $update_usr)) {
          die('Erro: '.mysqli_error($conexao));
        }else{
            $update = "UPDATE leads SET id_vendedor='2', data_editar='".date("Y-m-d")."', hora_editar='".date("H:i:s")."' WHERE id_vendedor='$id'" or die(mysqli_error());
            if (!mysqli_query($conexao, $update)) {
              die('Erro: '.mysqli_error($conexao));
            }else{
                echo "<script>alert('Vendedor desativado com sucesso!');</script>";
                echo "<meta http-equiv='refresh' content='0'>";
                exit();
            }
        }
    }
}
if (isset($_POST['ativar']) AND $_POST['ativar']=='ativar') {
    $id = (int)$_POST['id'];

    $update = "UPDATE $pagina_referencia SET status='a', data_editar='".date("Y-m-d")."', hora_editar='".date("H:i:s")."' WHERE id='$id'" or die(mysqli_error());
    if (!mysqli_query($conexao, $update)) {
      die('Erro: '.mysqli_error($conexao));
    }else{
        $update_usr = "UPDATE usuarios SET ativo='a' WHERE funcionario='$id'" or die(mysqli_error());
        if (!mysqli_query($conexao, $update_usr)) {
          die('Erro: '.mysqli_error($conexao));
        }else{
            echo "<script>alert('Vendedor ativado com sucesso!');</script>";
            echo "<meta http-equiv='refresh' content='0'>";
            exit();
        }
    }
}
if ($acao=="lixeira") {?>
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
              <th>NOME</th>
              <th>EMAIL</th>
              <?if ($usr_nivel=='10'){?>
                <th>AÇÕES</th>
              <?}?>
            </tr>
          </thead>
          <tbody>
  <?
    $sql = "SELECT * FROM $pagina_referencia WHERE status='d' ORDER BY id DESC";
    $query = mysqli_query($conexao, $sql);
    
    $condicao = mysqli_num_rows($query);
    $classe="even ";
    
      while ($dados = mysqli_fetch_assoc($query)) {
        $id = $dados['id'];
        $img = $dados['foto'];
        $responsavel_nome = $dados['responsavel_nome'];
        $email = $dados['email'];
        
        if ($dados['foto']=='') {
            $imagem = '../assets/img/'.$pagina_referencia.'/sem_imagem.jpg';
        } elseif(file_exists('../assets/img/'.$pagina_referencia.'/'.$img.'')){
            $imagem = '../assets/img/'.$pagina_referencia.'/'.$img.'';
        } else {
            $imagem = "../assets/img/$pagina_referencia/sem_imagem.jpg";
        } 
        if ($classe=="odd") { $classe="even "; } else {$classe="odd"; }
    ?>
            <tr class="<?=$classe;?>">
              <td class="center"><?=$id;?></td>
              <td class="center"><img src="<?=$imagem;?>" alt="<?=$responsavel_nome;?>" title="<?=$responsavel_nome;?>" class="gridpic"></td>
              <td><?=$responsavel_nome;?></td>
              <td><?=$email;?></td>
            <?if ($usr_nivel=='10'){?>
              <td >
                  <div class="socials tex-center">
                        <a href="#" class="btn btn-circle btn-success " data-toggle="modal" data-target="#myModalrecuperar<?=$id;?>"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></a> 
                        <a href="#" class="btn btn-circle btn-danger " data-toggle="modal" data-target="#myModal<?=$id;?>"><i class="fa fa-trash"></i></a> 
                    <div class="modal fade" id="myModalrecuperar<?=$id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form action="" method="POST">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel3">RECUPERAR ITEM</h4>
                                    </div>
                                    <div class="modal-body">Deseja restaurar deste item? </div>
                                    <div class="modal-footer">
                                        <input type="hidden" name="id" value="<?=$id;?>">
                                        <button name="ativar" value="ativar" class="btn btn-success" role="button" aria-pressed="true">SIM</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">NÃO</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="myModal<?=$id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form action="" method="POST">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel3">REMOVER ITEM</h4>
                                    </div>
                                    <div class="modal-body">Confirma a exclusão deste item? </div>
                                    <div class="modal-footer">
                                        <input type="hidden" name="id" value="<?=$id;?>">
                                        <button name="remover" value="remover" class="btn btn-success" role="button" aria-pressed="true">SIM</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">NÃO</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                  </div>
              </td>
            <?}?>
            </tr>
        <?}mysqli_free_result($query);?>
         
          </tbody>
        </table>
      </div>
    </div>
<?
}if ($acao=="") {?>

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
              <th>FOTO</th>
              <th>NOME</th>
              <th>E-MAIL</th>
              <th>CELULAR</th>
              <th>TIPO</th>
              <th>AÇÕES</th>
            </tr>
          </thead>
          <tbody>
          <?
            $sql = "SELECT * FROM $pagina_referencia WHERE id>2 AND status='a' ORDER BY responsavel_nome ASC";
            $query = mysqli_query($conexao, $sql);
              
            $condicao = mysqli_num_rows($query);
            $classe="even ";
              
            while ($dados = mysqli_fetch_assoc($query)) {
              $id = $dados['id'];
              $foto = $dados['foto'];
              $nome = $dados['responsavel_nome'];
              $celular = $dados['celular'];
              $email = $dados['email'];
              $tipo = $dados['tipo'];
              $whatsapp = $dados['whatsapp'];
              $sexo = $dados['sexo'];
              $estado_civil = $dados['estado_civil'];

              $usuarios = explode(",", $tipo);
                    
              $tipo_arr = array(
                10 => "Administrador",
                20 => "Vendedor"
              );

              if(!file_exists("../assets/img/$pagina_referencia/$foto")){ $foto = "sem_imagem.png"; }

              if ($classe=="odd") { $classe="even "; } else {$classe="odd"; }
          ?>
            <tr class="<?=$classe;?>">
              <td class="center"><?=$id;?></td>
              <td class="center"><img src="../assets/img/<?=$pagina_referencia;?>/<?=$foto;?>" alt="<?=$nome;?>" title="<?=$nome;?>" class="gridpic"></td>
              <td><?=$nome;?></td>
              <td><?=$email;?></td>
              <td><?=$celular;?></td>

              <td>
              <?
              foreach ($usuarios as $k => $v) {
              	echo $tipo_arr[$v].'<br>';
              }
              ?>
              </td>
              <td >
            	<div class="socials tex-center">
            		<a href="#" class="btn btn-circle btn-warning " data-toggle="modal" data-target="#senhaModal<?=$id;?>"><i class="fa fa-key"></i></a>  
            		<a href="#" class="btn btn-circle btn-primary " data-toggle="modal" data-target="#myModal<?=$id;?>"><i class="fa fa-pencil"></i></a> 
            		<a href="#" class="btn btn-circle btn-danger " data-toggle="modal" data-target="#excluir<?=$id;?>"><i class="fa fa-close"></i></a> 
            		<div class="modal fade" id="myModal<?=$id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-lg">
						<div class="modal-content">
						  <div class="modal-header">
							  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						  </div>
                          <form name="atualizar_tipo" action="" method="POST" enctype="multipart/form-data">
                            <div class="ajusta_div_mobile_frete">
                              <div class="row" style="margin: 0px 30px;">
                                <h4 class="modal-title" id="myModalLabel3" style="margin-left: 0.8em;"><strong>INFORMAÇÕES DO USUÁRIO</strong></h4>
                                <div class="col-sm-12" style="margin-bottom:20px;">
                                  Nome:<br>
                                  <input name="responsavel_nome" id="responsavel_nome" style="width:100%;padding: 1rem;" class="inputbox form-wrap" type="text" placeholder="Nome" value="<?=$dados['responsavel_nome'];?>" />
                                </div>
                                <div class="col-sm-12" style="margin-bottom:20px;">
                                  E-mail:<br>
                                  <input name="email" id="email" style="width:100%;padding: 1rem;" class="inputbox form-wrap email" type="text" placeholder="E-mail" value="<?=$dados['email'];?>"/>
                                </div>
                                <div class="col-sm-5" style="margin-bottom:20px;">
                                  CPF/CNPJ:<br>
                                  <input name="cpf_cnpj" id="cpf_cnpj" style="width:100%;padding: 1rem;" class="inputbox form-wrap cpfOuCnpj" type="text" placeholder="CPF" onkeyup="mascara(this, cpfcnpj)" maxlength="18" value="<?=$dados['cpf_cnpj'];?>"/>
                                </div>
                                <div class="col-sm-5" style="margin-bottom:20px;">
                                  Celular:<br>
                                  <input name="celular" id="celular" style="width:100%;padding: 1rem;" class="inputbox form-wrap cel" type="text" placeholder="Celular" value="<?=$dados['celular'];?>"/>
                                </div>
                                <div class="col-sm-2" style="margin-bottom:20px;">
                                  <i class="fa fa-warning" style="color:#fd8526;"></i> WhatsApp?
                                  <select name="whatsapp" style="width:100%; padding: 1.7rem 1rem 1.7rem 1rem;" class="inputbox form-wrap">
                                    <option value="sim" <?=((isset($whatsapp) AND $whatsapp=='sim')?'selected':'')?>>Sim</option>
                                    <option value="nao" <?=((isset($whatsapp) AND $whatsapp=='nao')?'selected':'')?>>Não</option>
                                  </select>
                                </div>
                                <div class="col-sm-4" style="margin-bottom:20px;">
                                  Data de Nascimento:<br>
                                  <input name="data_nascimento" id="data_nascimento" style="width:100%;padding: 1rem;" class="inputbox form-wrap data" type="text" placeholder="Data de Nascimento" value="<?=date('d/m/Y', strtotime($dados['data_nascimento']));?>"/>
                                </div>
                                <div class="col-sm-4" style="margin-bottom:20px;">
                                  Sexo
                                  <select name="sexo" style="width:100%; padding: 1.7rem 1rem 1.7rem 1rem;" class="inputbox form-wrap">
                                    <option value="masculino" <?=((isset($sexo) AND $sexo=='masculino')?'selected':'')?>>Masculino</option>
                                    <option value="feminino" <?=((isset($sexo) AND $sexo=='feminino')?'selected':'')?>>Feminino</option>
                                  </select>
                                </div>
                                <div class="col-sm-4" style="margin-bottom:20px;">
                                  Estado Civil
                                  <select name="estado_civil" style="width:100%; padding: 1.7rem 1rem 1.7rem 1rem;" class="inputbox form-wrap">
                                    <option value="solteiro" <?=((isset($estado_civil) AND $estado_civil=='solteiro')?'selected':'')?>>Solteiro(a)</option>
                                    <option value="casado" <?=((isset($estado_civil) AND $estado_civil=='casado')?'selected':'')?>>Casado(a)</option>
                                    <option value="divorciado" <?=((isset($estado_civil) AND $estado_civil=='divorciado')?'selected':'')?>>Divorciado(a)</option>
                                    <option value="viuvo" <?=((isset($estado_civil) AND $estado_civil=='viuvo')?'selected':'')?>>Viúvo(a)</option>
                                    <option value="separado" <?=((isset($estado_civil) AND $estado_civil=='separado')?'selected':'')?>>Separado(a)</option>
                                    <option value="uniao" <?=((isset($estado_civil) AND $estado_civil=='uniao')?'selected':'')?>>União Estável</option>
                                  </select>
                                </div>
                                <div class="col-sm-6" style="margin-bottom:20px;">
                                  Foto:<br>
                                  <input class="form-control" name="foto" id="foto" type="file" accept="image/*">
                                </div>
                              </div>
                            </div>

                            <div class="ajusta_div_mobile_frete">
                              <div class="row" style="margin: 0px 30px;">
                                <h4 class="modal-title" id="myModalLabel3" style="margin-left: 0.8em;"><strong>INFORMAÇÕES DE LOCALIDADE</strong></h4>
                                <div class="col-sm-3" style="margin-bottom:20px;">
                                  Cep:<br>
                                  <input name="cep" id="cep" style="width:100%;padding: 1rem;" class="inputbox form-wrap cep" type="text" placeholder="CEP" value="<?=$dados['cep'];?>" />
                                </div>
                                <div class="col-sm-7" style="margin-bottom:20px;">
                                  Endereço:<br>
                                  <input name="endereco" id="logradouro" style="width:100%;padding: 1rem;" class="inputbox form-wrap" type="text" placeholder="Endereço" value="<?=$dados['endereco'];?>"/>
                                </div>
                                <div class="col-sm-2" style="margin-bottom:20px;">
                                  Número:<br>
                                  <input name="numero" id="numero" style="width:100%;padding: 1rem;" class="inputbox form-wrap" type="text" placeholder="Número" value="<?=$dados['numero'];?>"/>
                                </div>
                                <div class="col-sm-6" style="margin-bottom:20px;">
                                  Bairro:<br>
                                  <input name="bairro" id="bairro" style="width:100%;padding: 1rem;" class="inputbox form-wrap" type="text" placeholder="Bairro" value="<?=$dados['bairro'];?>"/>
                                </div>
                                <div class="col-sm-6" style="margin-bottom:20px;">
                                  Cidade: <br>
                                  <input name="cidade" id="cidade" style="width:100%;padding: 1rem;"class="inputbox form-wrap" type="text" placeholder="Cidade" value="<?=$dados['cidade'];?>"/>
                                </div>
                                <div class="col-sm-6" style="margin-bottom:20px;">
                                  Estado:<br>
                                  <input name="estado" id="estado" style="width:100%;padding: 1rem;" class="inputbox form-wrap" type="text" placeholder="Estado" value="<?=$dados['estado'];?>"/>
                                </div>
                                <div class="col-sm-6" style="margin-bottom:20px;">
                                  Complemento:<br>
                                  <input name="complemento" id="complemento" style="width:100%;padding: 1rem;" class="inputbox form-wrap" type="text" placeholder="Complemento" value="<?=$dados['complemento'];?>"/>
                                </div>
                                <div class="col-sm-12" style="margin-bottom:20px;">
                                  Ponto de referência:<br>
                                  <input name="pto_referencia" id="pto_referencia"  style="width:100%;padding: 1rem;" class="inputbox form-wrap" type="text" placeholder="Ponto de referência" value="<?=$dados['pto_referencia'];?>"/>
                                </div>
                              </div>
                            </div>
            
                            <div class="ajusta_div_mobile_frete">
                              <div class="row" style="margin: 0px 30px;">
                                <h4 class="modal-title" id="myModalLabel3" style="margin-left: 0.8em;"><strong>ATUALIZAÇÃO DE GRUPO PERTENCENTE</strong></h4>
                                <div class="col-sm-12" style="margin-bottom:20px;">
                                  Selecione o grupo que este usuário deverá participar: <br>
                                  <select name="tipo" style="width:100%;padding: 1rem;" class="inputbox form-wrap">
                                    <option value="20"<?=(in_array(2,$usuarios))?' selected':''?>>Vendedor</option>
                                    <option value="10"<?=(in_array(1,$usuarios))?' selected':''?>>Administrador</option>
                                  </select>
                                  <input type="hidden" name="id" value="<?=$id;?>">
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="type" name="atualizar" class="btn btn-success" role="button" aria-pressed="true">ATUALIZAR</button>
                              <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                            </div>
                           </form>
			            </div>
		              </div>
		            </div>

                    <div class="modal fade" id="senhaModal<?=$id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          </div>
            
                          <div class="ajusta_div_mobile_frete">
                            <div class="row" style="margin: 0px 30px;">
                              <h4 class="modal-title" id="myModalLabel3" style="margin-left: 0.8em;">ALTERAR SENHA DO USUÁRIO - <?=$nome;?></h4>
                            </div>
                          </div>
            
                          <form name="atualizar_senha" action="" method="POST">
                            <div class="ajusta_div_mobile_frete">
                              <div class="row" style="margin: 0px 30px;">
                                <div class="col-sm-12" style="margin-bottom:20px;">
                                  <div class="col-sm-6">
                                    <label>Senha:</label>
                                    <input class="form-control" id="senha" type="text" name="senha" placeholder="Senha">
                                  </div>
                                  <div class="col-sm-6">
                                    <label>Corfimação de Senha:</label>
                                    <input class="form-control" id="confirma_senha" type="text" name="confirma_senha" onblur="validaSenha();" placeholder="Corfimação de Senha">
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="submit" name="atualizar_senha" class="btn btn-success" role="button" aria-pressed="true">ATUALIZAR</button>
                              <input type="hidden" id="id" name="id" value="<?=$id;?>">
                              <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                            </div>
                          </form>	
                        </div>
                      </div>
                    </div>

                    <div class="modal fade" id="excluir<?=$id;?>" tabindex="-1" role="dialog" aria-labelledby="excluir" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <form action="" method="POST">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel3">Desativar vendedor</h4>
                                    </div>
                                    <div class="modal-body"><h5>Este vendedor será desativado e seus leads transferidos para o administrador!<h5></div>
                                    <div class="modal-footer">
                                        <input type="hidden" name="id" value="<?=$id;?>">
                                        <button type="submit" name="excluir" value="excluir" class="btn btn-success" role="button" aria-pressed="true" title="CONFIRMAR">CONFIRMAR</a>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button>
                                    </div>
                                </div>
                            </form>
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
 <script src="vendor/jquery/jquery.min.js"></script>  
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>

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
function validaSenha(){
	var senha = document.getElementById("senha").value;
	var confirma_senha = document.getElementById("confirma_senha").value;
	if (confirma_senha!=senha){
		alert('As senhas não conferem');
		$("#senha").prop('value', '');
		$("#confirma_senha").prop('value', '');
    $("#senha").focus();
	}
};
</script>