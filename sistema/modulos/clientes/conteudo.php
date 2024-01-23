<?php
  include_once "config.php";
  $pagina_titulo = "clientes";
  $pagina_referencia = "clientes";
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
        
    function buscaCep(cep){
        var cepOK = cep.replace(/\D/g, '');
        $.getJSON('https://viacep.com.br/ws/'+cepOK+'/json/', function(data){
            $('#logradouro').prop('value',data.logradouro);
            $('#numero').prop('value','');
            $('#bairro').prop('value',data.bairro);
            $('#cidade').prop('value',data.localidade);
            $('#estado').prop('value',data.uf);
            $('#numero').focus();
            $('#logradouro').attr('placeholder','Logradouro');
            $('#numero').attr('placeholder','Numero');
            $('#pto_referencia').attr('placeholder','Ponto de referência');
            $('#bairro').attr('placeholder','Bairro');
            $('#cidade').attr('placeholder','Cidade');
            $('#estado').attr('placeholder','Estado');
        });
        
    }
    
    $(document).ready(function() {
        var CEPoptions =  {
            reverse: true,
            selectOnFocus: true,
            onComplete: function(cep) {
                buscaCep(cep);
            },
            onChange: function(cep){
                if(cep.length == 0){
                    $('#logradouro').prop('value','');
                    $('#numero').prop('value','');
                    $('#pto_referencia').prop('value','');
                    $('#complemento').prop('value','');
                    $('#bairro').prop('value','');
                    $('#cidade').prop('value','');
                    $('#estado').prop('value','');
    
                    $('#logradouro').attr('placeholder','Logradouro');
                    $('#numero').attr('placeholder','Numero');
                    $('#pto_referencia').attr('placeholder','Ponto de referência');
                    $('#complemento').attr('placeholder','Complemento');
                    $('#bairro').attr('placeholder','Bairro');
                    $('#cidade').attr('placeholder','Cidade');
                    $('#estado').attr('placeholder','Estado');
    
                }else{
    
                    if(cep.length < 9){
                        $('#logradouro').attr('placeholder','buscando...');
                        $('#numero').prop('value','');
                        $('#complemento').prop('value','');
                        $('#bairro').attr('placeholder','buscando...');
                        $('#cidade').attr('placeholder','buscando...');
                        $('#estado').attr('placeholder','buscando...');
                    }
                }
            }
        }
        $('.cep').mask('00000-000', CEPoptions);
        $('.tel').mask('(00) 0000-0000');
        $('.cel').mask('(00) 00000-0000');
    });
    
	
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
		$fantasia = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['fantasia'], MB_CASE_TITLE, "UTF-8"))));
		$razao = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['razao'], MB_CASE_TITLE, "UTF-8"))));
		$responsavel = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['responsavel'], MB_CASE_TITLE, "UTF-8"))));
		$cpfcnpj = trim(addslashes(htmlspecialchars($_POST['cpfCnpj'])));
		$rgie = trim(addslashes(htmlspecialchars($_POST['rgie'])));
		$nascimento = trim(addslashes(htmlspecialchars($_POST['nascimento'])));
	    //recupera localidade e contato [localidade]
		$cep = trim(addslashes(htmlspecialchars($_POST['cep'])));
		$endereco = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['rua'], MB_CASE_TITLE, "UTF-8"))));
		$bairro = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['bairro'], MB_CASE_TITLE, "UTF-8"))));
		$cidade = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['cidade'], MB_CASE_TITLE, "UTF-8"))));
		$estado = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['estado'], MB_CASE_UPPER, "UTF-8"))));
		$numero = trim(addslashes(htmlspecialchars($_POST['numero'])));
		$complemento = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['complemento'], MB_CASE_TITLE, "UTF-8"))));
		//[contato]
		$telefone = trim(addslashes(htmlspecialchars($_POST['telefone'])));
		$celular = trim(addslashes(htmlspecialchars($_POST['celular'])));
		$email = trim(addslashes(htmlspecialchars($_POST['email'])));
		$site = trim(addslashes(htmlspecialchars($_POST['site'])));
	    //infomaações complementares
		$sexo = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['sexo'], MB_CASE_TITLE, "UTF-8"))));
		$estadocivil = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['estadocivil'], MB_CASE_TITLE, "UTF-8"))));
	  
        $data_cadastro = date('Y-m-d');
        $hora_cadastro = date('H:i:s');
	  	$ip = $_SERVER['REMOTE_ADDR'];
		$endereco_ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $funcionario_nome = $usr_nome;
        $funcionario_id = $usr_id;

        $insere = "INSERT INTO clientes (nome_fantasia, razao_social, responsavel_nome, cpf_cnpj, rg_ie, data_nascimento, cep, endereco, bairro, cidade, estado, numero, complemento, telefone, celular, whatsapp, email, site, foto, sexo, estado_civil, facebook, instagram, twitter, google, skype, pontuacao, perfil_cor, indicacao, status, comentarios, ip, endereco_ip, data_cadastro, hora_cadastro, funcionario_id_cadastro, funcionario_nome_cadastro) VALUES ('$fantasia', '$razao', '$responsavel', '$cpfcnpj', '$rgie', '$nascimento', '$cep', '$endereco', '$bairro', '$cidade', '$estado', '$numero', '$complemento', '$telefone', '$celular', '$whatsapp', '$email', '$site', 'sem_imagem.jpg', '$sexo', '$estadocivil', '$facebook', '$instagram', '$twitter', '$google', '$skype', '0', '$perfil', '0', 'a', '$comentarios', '$ip', '$endereco_ip', '$data_cadastro', '$hora_cadastro', '$funcionario_id', '$funcionario_nome')" or die(mysql_error());

		if (!mysqli_query($conexao, $insere)) {  
			die('Erro: '.mysqli_error($conexao)); 
		} else {
					
			if (file_exists($_FILES['foto']['tmp_name']) || is_uploaded_file($_FILES['foto']['tmp_name'])) {
				$ultimo_id = mysqli_insert_id($conexao); 

				$nome = UrlAmigavel($responsavel);

				if ($nome=="") { $nome="cliente"; }

				$aleatorio = rand(1,999999);

				$nome = "cliente-".$ultimo_id."-".$nome."-".$aleatorio;

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
			
			echo "<script>alert('Cadastrado com sucesso!');</script>";
			echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia-cadastrar'>";
		}
		
  }

  if ($acao=="cadastrar") { ?>
    <div class="row">
      <div class="col-md-12  header-wrapper" >
        <h1 class="page-header"><?=mb_convert_case("$pagina_titulo", MB_CASE_TITLE, "UTF-8");?> - Cadastrar</h1>
        <p class="page-subtitle">Para cadastrar um novo item, preencha os dados abaixo.</p>
      </div>
    </div>
    
    <form method="post" action="" enctype="multipart/form-data">
      <div class="row ">
        <div class="col-lg-12 ">
          <div class="panel panel-default ">
            <div class="panel-body ">
                <h3>Informações Sociais</h3>
                <p>Preencha os campos abaixo.</p>
                <hr>
                <br>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="fantasia">NOME FANTASIA</label>
                        <input class="form-control" id="fantasia" type="text" placeholder="" name="fantasia">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="razao">RAZÃO SOCIAL</label>
                        <input class="form-control" id="razao" type="text" placeholder="" name="razao">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="responsavel">RESPONSÁVEL/NOME</label>
                        <input class="form-control" type="text" name="responsavel" id="responsavel" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="cpfCnpj">CPF/CNPJ</label>
                        <input class="form-control cpfOuCnpj" id="cpfCnpj" type="text" placeholder="" name='cpfCnpj' onkeyup="mascara(this, cpfcnpj)" maxlength="18">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="rgie">RG/IE</label>
                        <input class="form-control" id="rgie" type="text" placeholder="" name="rgie" maxlength="12" onkeypress="formatar('00.000.000-#', this)">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="nascimento">DATA NASCIMENTO</label>
                        <input class="form-control" type="date" id="nascimento" name="nascimento">
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
              <h3>Informações de localidade e contato</h3>
              <p>Preencha as informaçãs de localidade e contato.</p>
              <hr>
              <br>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label" for="cep">CEP</label>
                        <input class="form-control cep" type="text" id="cep" name="cep" placeholder="00000-000" maxlength="9" OnKeyPress="formatar('#####-###', this)">
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label class="control-label" for="rua">ENDEREÇO</label>
                        <input class="form-control" id="logradouro" name="rua" placeholder="Nome da Rua">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label" for="numero">NÚMERO</label>
                        <input class="form-control" name="numero" id="numero" placeholder="Número do local">
                    </div>
                </div>
              
			    <div class="col-md-12"></DIV>
			    
			    <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="complemento">COMPLEMENTO</label>
                        <input class="form-control" name="complemento" id="complemento">
                    </div>
                </div>
             
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label" for="bairro">BAIRRO</label>
                        <input class="form-control" id="bairro" name="bairro">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label" for="cidade">CIDADE</label>
                        <input class="form-control" id="cidade" name="cidade">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label" for="estado">ESTADO</label>
                        <input class="form-control" id="estado"  name="estado">
                    </div>
                </div>
              
			    <div class="col-md-12"></DIV>
              
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="telefone">TELEFONE</label>
                        <input class="form-control tel" name="telefone" maxlength="12">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="celular">CELULAR</label>
                        <input class="form-control cel" name="celular" maxlength="13">
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
                <h3>Informações Complementares</h3>
                <p>Preencha as informações complementares.</p>
                <hr>
                <br>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label" for="foto">FOTO</label>
                        <input class="form-control" name="foto" id="foto" type="file" accept="image/*">
                    </div>
                </div>

                <div class="col-md-12"></div>
             
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="email">E-MAIL</label>
                        <input class="form-control" name="email" type="email">
                    </div>
                </div>
             
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="sexo">SEXO</label>
                        <select class="form-control" name="sexo">
                        <option value="Masculino">Masculino</option>
                        <option value="Feminino">Feminino</option>
                    </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="estadocivil">ESTADO CIVIL</label>
                        <select class="form-control" name="estadocivil">
                            <option value="solteiro">Solteiro(a)</option>
                            <option value="casado">Casado(a)</option>
                            <option value="divorciado">Divorciado(a)</option>
                            <option value="viuvo">Viúvo(a)</option>
                            <option value="separado">Separado(a)</option>
                            <option value="uniao">União Estável</option>
                        </select>
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

	  	$delete = "DELETE FROM $pagina_referencia WHERE id='".$id."' "  or die(mysqli_error());

		if (!mysqli_query($conexao, $delete)) {  
			die('Error: '.mysqli_error($conexao)); 
		} else {
			
			$_SESSION['alerta_mensagem'] = "Removido com sucesso!";
            $_SESSION['alerta_tipo'] = "green";
            $_SESSION['alerta_icone'] = "fa fa-check";
            echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";
            exit;

		}
		
  }

  if ($acao=="gravar_editar") {

		$fantasia = trim(addslashes(htmlspecialchars($_POST['fantasia'])));
        $razao = trim(addslashes(htmlspecialchars($_POST['razao'])));
        $responsavel = trim(addslashes(htmlspecialchars($_POST['responsavel'])));
        $cpfCnpj = trim(addslashes(htmlspecialchars($_POST['cpfCnpj'])));
        $rgie = trim(addslashes(htmlspecialchars($_POST['rgie'])));
        $nascimento = trim(addslashes(htmlspecialchars($_POST['nascimento'])));
        $cep = trim(addslashes(htmlspecialchars($_POST['cep'])));
        $rua = trim(addslashes(htmlspecialchars($_POST['rua'])));
        $numero = trim(addslashes(htmlspecialchars($_POST['numero'])));
        $complemento = trim(addslashes(htmlspecialchars($_POST['complemento'])));
        $bairro = trim(addslashes(htmlspecialchars($_POST['bairro'])));
        $cidade = trim(addslashes(htmlspecialchars($_POST['cidade'])));
        $estado = trim(addslashes(htmlspecialchars($_POST['estado'])));
        $telefone = trim(addslashes(htmlspecialchars($_POST['telefone'])));
        $celular = trim(addslashes(htmlspecialchars($_POST['celular'])));
        $email = trim(addslashes(htmlspecialchars($_POST['email'])));
        $sexo = trim(addslashes(htmlspecialchars($_POST['sexo'])));
        $estadocivil = trim(addslashes(htmlspecialchars($_POST['estadocivil'])));

        $data_editar = date('Y-m-d');
        $hora_editar = date('H:i:s');
	  	$ip = $_SERVER['REMOTE_ADDR'];
		$endereco_ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		
	  	$update = "UPDATE $pagina_referencia SET nome_fantasia='$fantasia', razao_social='$razao', responsavel_nome='$responsavel', cpf_cnpj='$cpfCnpj', rg_ie='$rgie', data_nascimento='$nascimento', cep='$cep', endereco='$rua', numero='$numero', complemento='$complemento', bairro='$bairro', cidade='$cidade', estado='$estado', telefone='$telefone', celular='$celular', email='$email', sexo='$sexo', estado_civil='$estadocivil', data_editar='".date('Y-m-d')."', hora_editar='".date('H:i:s')."' WHERE id='".$id."' "  or die(mysqli_error());

		if (!mysqli_query($conexao, $update)) {  
			die('Error: '.mysqli_error($conexao)); 
		} else {
		    
		    if (isset($_POST['img']) AND $_POST['img']!=''){
		        $img_nome = 'cliente-'.$id.'-'.clean($responsavel).'.jpg';
    	  	    $img = '../assets/img/'.$pagina_referencia.'/'.$img_nome;
    	  	    $imagem_antiga = substr($_POST['img'], 3);
    	  	    rename($imagem_antiga, $img);
    	  	    mysqli_query($conexao, "UPDATE $pagina_referencia SET foto='$img_nome' WHERE id='$id'");
    	  	}
			
			$_SESSION['alerta_mensagem'] = "Atualizado com sucesso!";
            $_SESSION['alerta_tipo'] = "green";
            $_SESSION['alerta_icone'] = "fa fa-check";
            echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";
            exit;

		}
		
  }

  if ($acao=="editar") { ?>
	<?
	$sql = "SELECT * FROM $pagina_referencia WHERE id='$id'";
	$query = mysqli_query($conexao, $sql);
	  
	$condicao = mysqli_num_rows($query);
	
	while ($dados = mysqli_fetch_assoc($query)) {
		$id = $dados['id'];
		$fantasia = $dados['nome_fantasia'];
        $razao = $dados['razao_social'];
        $responsavel_nome = $dados['responsavel_nome'];
        $cpf_cnpj = $dados['cpf_cnpj'];
        $rg = $dados['rg_ie'];
        $data_nascimento = $dados['data_nascimento'];
        $cep = $dados['cep'];
        $endereco = $dados['endereco'];
        $numero = $dados['numero'];
        $complemento = $dados['complemento'];
        $bairro = $dados['bairro'];
        $cidade = $dados['cidade'];
        $estado = $dados['estado'];
        $telefone = $dados['telefone'];
        $celular = $dados['celular'];
        $email = $dados['email'];
        $sexo = $dados['sexo'];
        $estado_civil = $dados['estado_civil'];
        
        if (isset($dados['foto']) AND file_exists('../assets/img/'.$pagina_referencia.'/'.$dados['foto'])){
            $img = '../../assets/img/'.$pagina_referencia.'/'.$dados['foto'];
        }else{
            $img = '../../assets/img/'.$pagina_referencia.'/sem_imagem.jpg';
        }
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
      <div class="row ">
        <div class="col-lg-12 ">
          <div class="panel panel-default ">
            <div class="panel-body ">
                <h3>Informações Sociais</h3>
                <p>Preencha os campos abaixo.</p>
                <hr>
                <br>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="fantasia">NOME FANTASIA</label>
                        <input class="form-control" type="text" id="fantasia" name="fantasia" value="<?=$fantasia;?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="razao">RAZÃO SOCIAL</label>
                        <input class="form-control" id="razao" type="text" name="razao" value="<?=$razao;?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="responsavel">RESPONSÁVEL/NOME</label>
                        <input class="form-control" type="text" name="responsavel" id="responsavel" required value="<?=$responsavel_nome;?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="cpfCnpj">CPF/CNPJ</label>
                        <input class="form-control cpfOuCnpj" id="cpfCnpj" type="text" name='cpfCnpj' onkeyup="mascara(this, cpfcnpj)" maxlength="18" value="<?=$cpf_cnpj;?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="rgie">RG/IE</label>
                        <input class="form-control" id="rgie" type="text" placeholder="" name="rgie" maxlength="12" onkeypress="formatar('00.000.000-#', this)" value="<?=$rg;?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="nascimento">DATA NASCIMENTO</label>
                        <input class="form-control" type="date" id="nascimento" name="nascimento" value="<?=$data_nascimento;?>">
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
              <h3>Informações de localidade e contato</h3>
              <p>Preencha as informaçãs de localidade e contato.</p>
              <hr>
              <br>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label" for="cep">CEP</label>
                        <input class="form-control cep" type="text" id="cep" name="cep" placeholder="00000-000" maxlength="9" OnKeyPress="formatar('#####-###', this)" value="<?=$cep;?>">
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label class="control-label" for="rua">ENDEREÇO</label>
                        <input class="form-control" id="logradouro" name="rua" placeholder="Nome da Rua" value="<?=$endereco;?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label" for="numero">NÚMERO</label>
                        <input class="form-control" name="numero" id="numero" placeholder="Número do local" value="<?=$numero;?>">
                    </div>
                </div>
              
			    <div class="col-md-12"></DIV>
			    
			    <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="complemento">COMPLEMENTO</label>
                        <input class="form-control" name="complemento" id="complemento" value="<?=$complemento;?>">
                    </div>
                </div>
             
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label" for="bairro">BAIRRO</label>
                        <input class="form-control" id="bairro" name="bairro" value="<?=$bairro;?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label" for="cidade">CIDADE</label>
                        <input class="form-control" id="cidade" name="cidade" value="<?=$cidade;?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label" for="estado">ESTADO</label>
                        <input class="form-control" id="estado"  name="estado" value="<?=$estado;?>">
                    </div>
                </div>
              
			    <div class="col-md-12"></DIV>
              
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="telefone">TELEFONE</label>
                        <input class="form-control tel" name="telefone" maxlength="12" value="<?=$telefone;?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="celular">CELULAR</label>
                        <input class="form-control cel" name="celular" maxlength="13" value="<?=$celular;?>">
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
                <h3>Informações Complementares</h3>
                <p>Preencha as informações complementares.</p>
                <hr>
                <br>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="image_area">
							<label for="upload_destaque" style="width: 100%; display: flex; align-items: center;">
							    <div class="col-md-3">
    								<a href="#" data-toggle="modal" data-target="#modal_excluir_imagem" id="excluir_imagem" class="btn btn-danger settingbtn-trash" <?echo ((isset($img) AND $img=='../../assets/img/'.$pagina_referencia.'/sem_imagem.jpg')?'style="display: none;"':'');?>><i class="fa fa-trash"></i></a>
    								<button type="button" class="btn btn-primary settingbtn" onclick="$('#upload_destaque').click();"><i class="fa fa-upload"></i></button>
    								<img src="<?=$img;?>" id="uploaded_destaque" class="img-responsive" style="border: 1px solid #eee; cursor: pointer;">
    								<input type="file" name="upload_destaque" class="upload_image" id="upload_destaque" data-width="250" data-height="250" style="display:none;">
    								<input type="hidden" id="img" name="img" value="">
							    </div>
							    <div class="col-md-9">
							        <div class="col-md-12">
							            IMAGEM
							        </div>
							        <div class="col-md-12">
							            <button type="button" onclick="$('#upload_destaque').click();" class="btn btn-success" style="line-height: 28px; font-size: 11px;"><i class="fa fa-check" style="font-size: 12px;"></i> Adicionar </button>
							        </div>
							    </div>
							</label>
    					</div>
                    </div>
                </div>
                <input type="hidden" id="imagem" value="">
        		<div class="modal fade" id="nova_imagem_modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="false">
    			  	<div class="modal-dialog modal-lg" role="document">
    			    	<div class="modal-content">
    			      		<div class="modal-header">
    			      		    <div class="row">
    			      		        <div class="col-md-6">
    			        		        <h5 class="modal-title">Recorte sua imagem para fazer o upload</h5>
    			      		        </div>
    			      		        <div class="col-md-6">
            			        		<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: 1;">
            			          			<span aria-hidden="true">×</span>
            			        		</button>
    			      		        </div>
    			      		    </div>
    			      		</div>
    			      		<div class="modal-body">
			            		<div class="row">
			                		<div class="col-md-8">
			                    		<img src="" id="sample_image"/>
			                		</div>
			                		<div class="col-md-4">
			                    		<div class="preview"></div>
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
    			<div class="modal fade" id="modal_excluir_imagem" tabindex="-1" role="dialog" aria-labelledby="modal_excluir_imagem" aria-hidden="false">
    			  	<div class="modal-dialog modal-lg" role="document">
    			    	<div class="modal-content">
    			      		<div class="modal-header">
    			      		    <div class="row">
    			      		        <div class="col-md-12">
            			        		<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: 1;">
            			          			<span aria-hidden="true">×</span>
            			        		</button>
    			      		        </div>
    			      		    </div>
    			      		</div>
    			      		<div class="modal-body">
			            		<div class="row">
			                		<div class="col-md-12">
			                    		<h4>Deseja realmente excluir esta imagem?</h4>
			                		</div>
			            		</div>
    			      		</div>
    			      		<div class="modal-footer" id="modal_rodape">
    			        		<button type="button" class="btn btn-danger" data-dismiss="modal">NÃO</button>
    			      			<button type="button" id="botao_excluir_imagem" class="btn btn-success" onclick"excluir_imagem('', '');">Sim</button>
    			      		</div>
    			    	</div>
    			  	</div>
    			</div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="email">E-MAIL</label>
                        <input class="form-control" name="email" type="email" value="<?=$email;?>">
                    </div>
                </div>

                <div class="col-md-12"></div>
             
             
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="sexo">SEXO</label>
                        <select class="form-control" name="sexo">
                        <option value="Masculino" <?echo ((isset($sexo) AND $sexo=='Masculino')?'selected':'');?>>Masculino</option>
                        <option value="Feminino" <?echo ((isset($sexo) AND $sexo=='Feminino')?'selected':'');?>>Feminino</option>
                    </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="estadocivil">ESTADO CIVIL</label>
                        <select class="form-control" name="estadocivil">
                            <option value="solteiro" <?echo ((isset($estado_civil) AND $estado_civil=='solteiro')?'selected':'');?>>Solteiro(a)</option>
                            <option value="casado" <?echo ((isset($estado_civil) AND $estado_civil=='casado')?'selected':'');?>>Casado(a)</option>
                            <option value="divorciado" <?echo ((isset($estado_civil) AND $estado_civil=='divorciado')?'selected':'');?>>Divorciado(a)</option>
                            <option value="viuvo" <?echo ((isset($estado_civil) AND $estado_civil=='viuvo')?'selected':'');?>>Viúvo(a)</option>
                            <option value="separado" <?echo ((isset($estado_civil) AND $estado_civil=='separado')?'selected':'');?>>Separado(a)</option>
                            <option value="uniao" <?echo ((isset($estado_civil) AND $estado_civil=='uniao')?'selected':'');?>>União Estável</option>
                        </select>
                    </div>
                </div>
              
                <div class="col-md-12"> </div>
              
                <div class="col-md-12">
                    <div class="form-group">
                        <input name="acao" id="acao" value="gravar_editar" type="hidden">
                        <button type="submit" name="enviar" value="enviar" class="btn btn-success" style="float:right;"><i class="fa fa-check"></i> Atualizar </button>
                    </div>
                </div>
              
            </div>
          </div>
        </div>
        <!-- /.col-lg-12 -->
      </div>
      <!-- /.row -->
    </form>
<? }

if (isset($_POST['atualizar_senha'])) {
		
		$id_cliente = $_POST['id'];

		$senha_nova = sha1($_POST['nova_senha']);
		$conf_senha = sha1($_POST['conf_nova_senha']);
		
		$data_editar = date('Y-m-d');
        $hora_editar = date('H:i:s');
	
	if($senha_nova == $conf_senha){

		$update = "UPDATE clientes SET senha='$senha_nova', data_editar='$data_editar', hora_editar='$hora_editar' WHERE id='".$id_cliente."' "  or die(mysqli_error());

		if (!mysqli_query($conexao, $update)) {  
			die('Error: '.mysqli_error($conexao)); 
		} else {
			$_SESSION['alerta_mensagem'] = "Atualizado com sucesso!";
            $_SESSION['alerta_tipo'] = "green";
            $_SESSION['alerta_icone'] = "fa fa-check";
            echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";

		}
	}else{
	    $_SESSION['alerta_mensagem'] = "Senhas são diferentes!";
        $_SESSION['alerta_tipo'] = "red";
        $_SESSION['alerta_icone'] = "fa fa-close";
        echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";
	}
}

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
                    <th>FOTO</th>
                    <th>DADOS</th>
                    <th>AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                	<?
                	$sql = "SELECT * FROM $pagina_referencia WHERE id<>1 AND status='a' ORDER BY responsavel_nome ASC";
                	$query = mysqli_query($conexao, $sql);
                	  
                	$condicao = mysqli_num_rows($query);
                	$classe="even ";
                		
                	while ($dados = mysqli_fetch_assoc($query)) {
                		$id = $dados['id'];
                		$foto = $dados['foto'];
                		$nome = $dados['responsavel_nome'];
                		$telefone = $dados['telefone'];
                		$celular = $dados['celular'];
                		$email = $dados['email'];
                        	
                		if(file_exists("../assets/img/$pagina_referencia/$foto")){ } else{ $foto = "sem_foto.jpg"; }
                
                		if ($classe=="odd") { $classe="even "; } else {$classe="odd"; }
                    ?>
                        <tr class="<?=$classe;?>">
                            <td class="center"><?=$id;?></td>
                            <td class="center"><img src="../assets/img/<?=$pagina_referencia;?>/<?=$foto;?>" alt="<?=$nome;?>" title="<?=$nome;?>" class="gridpic"></td>
                            <td>
                                <b><?=$nome;?></b>
                                <?echo ((isset($celular) AND $celular!='')?'<br><b>Telefone:</b> '.$celular:'');?>
                                <?echo ((isset($email) AND $email!='')?'<br><b>E-mail:</b> '.$email:'');?>
                            </td>
                            <td>
                            	<div class="socials tex-center">
                            		<a href="#" class="btn btn-circle btn-warning " data-toggle="modal" data-target="#senhaModal<?=$id;?>"><i class="fa fa-key"></i></a>  
                            		<a href="<?=$pagina_referencia;?>-editar_<?=$id;?>" class="btn btn-circle btn-primary"><i class="fa fa-pencil"></i></a>
                            		<a href="#" class="btn btn-circle btn-danger " data-toggle="modal" data-target="#excluir_<?=$id;?>"><i class="fa fa-trash"></i></a>  
                            		<div class="modal fade" id="senhaModal<?=$id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            		    <div class="modal-dialog modal-lg">
                            		        <form id="atualizar_senha_<?=$id;?>" action="" method="POST">
                                			    <div class="modal-content">
                                				    <div class="modal-header">
                                				        <h4 class="modal-title" id="myModalLabel3">ALTERAR SENHA DO USUÁRIO - <?=$nome;?></h4>
                                					    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                					</div>
                                                    <div class="modal-body">
                            			                <div class="row" style="margin: 0px 30px;">
                            			                    <div class="col-md-6">
                            			                        <div class="form-group">
                                                                    <label class="control-label" for="nova_senha">NOVA SENHA</label>
                                                                    <input class="form-control width-100" name="nova_senha" id="nova_senha" type="text" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label" for="conf_nova_senha">CONFIRMAR SENHA</label>
                                                                    <input class="form-control width-100" name="conf_nova_senha" id="conf_nova_senha" type="text" required>
                                                                </div>
                                                            </div>
                                	  	                </div>
                                                    </div>
                                        		  	<div class="modal-footer">
                                        		  	    <button type="button" onclick="enviaFormulario('atualizar_senha_<?=$id;?>');" class="btn btn-success" role="button" aria-pressed="true">ATUALIZAR</button>
                                        		  	    <input type="hidden" id="id" name="id" value="<?=$id;?>">
                                        		  	    <input type="hidden" name="atualizar_senha" value="atualizar_senha">
                                        			    <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                                        		  	</div>
                                                </div>
                                            </form>
                            			</div>
                                	</div>
                                	<div class="modal fade" id="excluir_<?=$id;?>" tabindex="-1" role="dialog" aria-labelledby="excluir" aria-hidden="false">
                        			  	<div class="modal-dialog modal-lg" role="document">
                        			    	<div class="modal-content">
                        			      		<div class="modal-header">
                        			      		    <div class="row">
                        			      		        <div class="col-md-12">
                                			        		<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: 1;">
                                			          			<span aria-hidden="true">×</span>
                                			        		</button>
                        			      		        </div>
                        			      		    </div>
                        			      		</div>
                        			      		<div class="modal-body">
                    			            		<div class="row">
                    			                		<div class="col-md-12">
                    			                    		<h4>Deseja realmente excluir este cadastro?</h4>
                    			                		</div>
                    			            		</div>
                        			      		</div>
                        			      		<div class="modal-footer" id="modal_rodape">
                        			        		<button type="button" class="btn btn-danger" data-dismiss="modal">NÃO</button>
                        			      			<a href="<?=$pagina_referencia;?>-excluir_<?=$id;?>" type="button" class="btn btn-success">Sim</a>
                        			      		</div>
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
                order: [ 0, 'desc' ],
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
