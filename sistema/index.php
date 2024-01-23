<?php
ob_start();
session_cache_limiter('private');
$cache_limiter = session_cache_limiter();
session_cache_expire(30);
session_start();
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');   
date_default_timezone_set('America/Sao_Paulo');
$data_atual = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
if (date('w') >= 0 and date('w') <= 7) {
	if (date("G") >= 0 and date("G") <= 24) {
	} else {
		session_destroy();
		header('location:../');
		exit;
	}
} else {
	session_destroy();
	header('location:../');
	exit;
}
$conexao = mysqli_connect("localhost", "graziuniformes_loja", 'gZ$xHFV=fk[8', "graziuniformes_loja");
mysqli_set_charset($conexao, "utf8");
if (!$conexao) {
	die("Falha na conexao: " . mysqli_connect_error());
}
function preconj($string){	
    $table = array(
        ' De '=>' de ', ' Da '=>' da ', ' Do '=>' do ',
		' Por '=>' por ', ' Com '=>' com ', ' Em '=>' em ', ' Para '=>' para ',
		' A '=>' a ', ' E '=>' e ', ' O '=>' o ',
		' Á '=>' á ', ' É '=>' é ', ' Ó '=>' ó ',
		' À '=>' à ', ' Ás '=>' ás ', ' Às '=>' às ',
    );
    $string = strtr($string, $table);
    return $string;
}
$psite    = "https://www.graziuniformes.com.br";
$pnome    =  "Grazi Uniformes";
$ppara	  = "contato@graziuniformes.com.br";
$sessao_id = "grazi-uniformes";
$google_site_key = "6Lc7vZMnAAAAABYyFHWWf5W-Vra25U5YHWJW7zcr";
$google_secret_key = "6Lc7vZMnAAAAAP0deWU0Axxy7Gp0DeDny7oiVwM4";
if (isset($_POST['acao'])) {
	$acao = $_POST['acao'];
} else {
	$acao = '';
}
if (isset($_POST['usuario'])) {
	$usuario = $_POST['usuario'];
} else {
	$usuario = '';
}
if (isset($_POST['senha'])) {
	$senha = $_POST['senha'];
} else {
	$senha = '';
}
if (!isset($res)) {
	$res["success"] = '0';
}
if (!isset($msg)) {
	$msg = '';
}
if (!isset($liberado)) {
	$liberado = "";
}
if ($acao == 'cmentrar') {
	$ip = $_SERVER['REMOTE_ADDR'];
	$ip_endereco = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	$data_busca = date("Y-m-d");
	$hora_busca = date("H:i:s");
	function getBrowser()
	{
		$u_agent = $_SERVER['HTTP_USER_AGENT'];
		$bname = 'Unknown';
		$platform = 'Unknown';
		$version = "";
		//First get the platform?
		if (preg_match('/linux/i', $u_agent)) {
			$platform = 'linux';
		} elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
			$platform = 'mac';
		} elseif (preg_match('/windows|win32/i', $u_agent)) {
			$platform = 'windows';
		}
		// Next get the name of the useragent yes seperately and for good reason
		if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
			$bname = 'Internet Explorer';
			$ub = "MSIE";
		} elseif (preg_match('/Firefox/i', $u_agent)) {
			$bname = 'Mozilla Firefox';
			$ub = "Firefox";
		} elseif (preg_match('/Chrome/i', $u_agent)) {
			$bname = 'Google Chrome';
			$ub = "Chrome";
		} elseif (preg_match('/Safari/i', $u_agent)) {
			$bname = 'Apple Safari';
			$ub = "Safari";
		} elseif (preg_match('/Opera/i', $u_agent)) {
			$bname = 'Opera';
			$ub = "Opera";
		} elseif (preg_match('/Netscape/i', $u_agent)) {
			$bname = 'Netscape';
			$ub = "Netscape";
		}
		// finally get the correct version number
		$known = array('Version', $ub, 'other');
		$pattern = '#(?<browser>' . join('|', $known) .
			')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
		if (!preg_match_all($pattern, $u_agent, $matches)) {
			// we have no matching number just continue
		}
		// see how many we have
		$i = count($matches['browser']);
		if ($i != 1) {
			//we will have two since we are not using 'other' argument yet
			//see if version is before or after the name
			if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
				$version = $matches['version'][0];
			} else {
				$version = $matches['version'][1];
			}
		} else {
			$version = $matches['version'][0];
		}
		// check if we have a number
		if ($version == null || $version == "") {
			$version = "?";
		}
		return array(
			'userAgent' => $u_agent,
			'name'      => $bname,
			'version'   => $version,
			'platform'  => $platform,
			'pattern'   => $pattern
		);
	}
	$ua = getBrowser();
	$data = preconj(mb_convert_case(IntlDateFormatter::formatObject($data_atual, "eeee, d 'de' MMMM y 'às' HH:mm", 'pt_BR'), MB_CASE_TITLE));
	$assunto  = "Tentativa de Acesso";
	$usuario = mysqli_real_escape_string($conexao, $usuario);
	$usuario = addslashes($usuario);
	$senha = mysqli_real_escape_string($conexao, $senha);
	$senha = addslashes($senha);
	$senha = sha1($senha);
	$sql = "SELECT * FROM usuarios WHERE usuario='$usuario' && senha='$senha' && ativo='a' LIMIT 1";
	$resultado = mysqli_query($conexao, $sql);
	$usr_autorizado = mysqli_num_rows($resultado);
	while ($user_info = mysqli_fetch_array($resultado)) {
		$usr_id = $user_info['id'];
		$usr_nome = $user_info['nome'];
		$usr_login = $user_info['usuario'];
		$usr_senha = $user_info['senha'];
		$usr_nivel = $user_info['nivel'];
		$usr_funcionario = $user_info['funcionario'];
		$usr_autorizado = 1;
	}
	$resultado->close();
	if ($usr_autorizado == 1) {
		$_SESSION["usr_id"] = $usr_id;
		$_SESSION["usr_nome"] = $usr_nome;
		$_SESSION["usr_login"] = $usr_login;
		$_SESSION["usr_senha"] = $usr_senha;
		$_SESSION["usr_nivel"] = $usr_nivel;
		$_SESSION["usr_funcionario"] = $usr_funcionario;
		$_SESSION["usr_autorizado"] = $usr_autorizado;
		$_SESSION["controle"] = "vb";
		$_SESSION["controle_vb_painel_tempo"] = date('Y-m-d H:i:s');
		$msg = "
        <!doctype html>
        <html>
        <head>
        <meta charset='iso-8859-1'>
        <title>Tentativa Acesso</title>
		<link href='$psite/css/email.css' rel='stylesheet'>
        </head>
        <body>
              <table width='90%' style='max-width: 700px;' cellpadding='0' cellspacing='5' align='center' valign='middle' bordercolor='#999999' border='1'>
                  <tr>
                    <td align='center' valign='middle' bgcolor='#E8E8E8' class='link' height='50px'><h2>ACESSO PERMITIDO</h2></td>
                  </tr>
                  <tr>
                    <td align='center' valign='middle' bgcolor='#F3F3F3' height='50'>
                        $data <br/>
                        <strong>IP:</strong> $ip - <strong>Endere&ccedil;o:</strong> $ip_endereco
                    </td>
                 </tr>
                  <tr>
                    <td>
                    	<br>
                        <strong>&nbsp;&nbsp;&nbsp; Tentativa de Acesso:</strong> ACESSO PERMITIDO<br><br>
                        <strong>&nbsp;&nbsp;&nbsp; Login:</strong> " . $usuario . "<br>
                        <strong>&nbsp;&nbsp;&nbsp; Senha:</strong> ************<br><br>
					</td>
                  </tr>
                  <tr>
                    <td align='right' bgcolor='#F3F3F3' class='link' height='25'><strong>Origem:</strong> <a href='$psite' target='_blank' class='link'> $psite </a>&nbsp;&nbsp;&nbsp;</td>
                  </tr>
                  <tr>
                    <td align='justify' bgcolor='#E8E8E8' style='padding:10px;'>
                      <strong><font size='4' color='#990000'>Informa&ccedil;&otilde;es sobre o sistema:</font></strong><br>
                      <strong>&nbsp;&nbsp;&nbsp; Virtua Brasil</strong> <br>
                      <strong>&nbsp;&nbsp;&nbsp; Telefone:</strong> (12) 3025-4112 |
                      <strong> WhatsApp:</strong> (12) 99773-2010 <br />
                      <strong>&nbsp;&nbsp;&nbsp; Site:</strong> <a href='http://www.virtuabrasil.com.br' target='_blank' class='link_preto'> www.virtuabrasil.com.br</a><br />
                    </td>
                  </tr>
                </table>
	</body>
	</html>
 	";
		//			$pnome = utf8_decode(utf8_encode(html_entity_decode($pnome)));  ----> usamos no servidor antigo
		$pnome = ucfirst(trim(iconv("UTF-8", "ISO-8859-1", $pnome)));
		$headers  = 'MIME-Version: 1.1' . " \r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . " \r\n";
		$headers .= "From: $pnome <$ppara> \r\n";
		//			$headers .= "To: $pnome <$ppara> \r\n";
		$headers .= "Return-Path: $pnome <$ppara> \r\n";
		$headers .= "Bcc: Virtua Brasil <contato@virtuabrasil.com.br> \r\n";
		$headers .= "Reply-To: $pnome <$ppara> \r\n";
		if (mail("Virtua Brasil<contato@virtuabrasil.com.br>", "$assunto - " . $usuario, iconv("UTF-8", "ISO-8859-1", $msg), $headers)) {
			$insere = "INSERT INTO log (id_usuario, usuario, senha, funcionario, nivel, resultado, ip, ip_endereco, navegador, versao, plataforma, agente, data, hora) VALUES ('$usr_id','$usuario','$senha','$usr_funcionario','$usr_nivel','LOGADO','$ip','$ip_endereco','" . $ua['name'] . "','" . $ua['version'] . "','" . $ua['platform'] . "','" . $ua['userAgent'] . "','" . date('Y-m-d') . "','" . date('G:i:s') . "')";
			if (!mysqli_query($conexao, $insere)) {
				die('Erro: ' . mysqli_error($conexao));
			} else {
				echo "<meta http-equiv='refresh' content='0;URL=home'>";
			}
			exit;
		}
	} else {
		$msg = "
        <!doctype html>
        <html>
        <head>
        <meta charset='iso-8859-1'>
        <title>Tentativa Acesso</title>
		<link href='$psite/css/email.css' rel='stylesheet'>
        </head>
        <body>
              <table width='700' cellpadding='0' cellspacing='5' align='center' valign='middle' bordercolor='#999999' border='1'>
                  <tr>
                    <td align='center' valign='middle' bgcolor='#E8E8E8' class='link' height='50px'><h2>ACESSO NEGADO</h2></td>
                  </tr>
                  <tr>
                    <td align='center' valign='middle' bgcolor='#F3F3F3' height='50'>
                        $data <br/>
                        <strong>IP:</strong> $ip - <strong>Endere&ccedil;o:</strong> $ip_endereco 
                    </td>
                  </tr>
                  <tr>
                    <td>
                    	<br>
                        <strong>&nbsp;&nbsp;&nbsp; Tentativa de Acesso:</strong> ACESSO NEGADO<br><br>
                        <strong>&nbsp;&nbsp;&nbsp; Login:</strong> " . $_POST['usuario'] . "<br>
                        <strong>&nbsp;&nbsp;&nbsp; Senha:</strong> " . $_POST['senha'] . "<br><br>
					</td>
                  </tr>
                  <tr>
                    <td align='right' bgcolor='#F3F3F3' class='link' height='25'><strong>Origem:</strong> <a href='$psite' target='_blank' class='link'> $psite </a>&nbsp;&nbsp;&nbsp;</td>
                  </tr>
                  <tr>
                    <td align='justify' bgcolor='#E8E8E8' style='padding:10px;'>
                      <strong><font size='4' color='#990000'>Informa&ccedil;&otilde;es sobre o sistema:</font></strong><br>
                      <strong>&nbsp;&nbsp;&nbsp; Virtua Brasil</strong> <br>
                      <strong>&nbsp;&nbsp;&nbsp; Telefone:</strong> (12) 3025-4112 |
                      <strong> WhatsApp:</strong> (12) 99773-2010 <br />
                      <strong>&nbsp;&nbsp;&nbsp; Site:</strong> <a href='http://www.virtuabrasil.com.br' target='_blank' class='link_preto'> www.virtuabrasil.com.br</a><br />
                    </td>
                  </tr>
                </table>
	</body>
	</html>
		";
		//			$pnome = utf8_decode(utf8_encode(html_entity_decode($pnome)));  ----> usamos no servidor antigo
		$pnome = ucfirst(trim(iconv("UTF-8", "ISO-8859-1", $pnome)));
		$headers  = 'MIME-Version: 1.1' . " \r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . " \r\n";
		$headers .= "From: $pnome <$ppara> \r\n";
		//			$headers .= "To: $pnome <$ppara> \r\n";
		$headers .= "Return-Path: $pnome <$ppara> \r\n";
		$headers .= "Bcc: Virtua Brasil <contato@virtuabrasil.com> \r\n";
		$headers .= "Reply-To: $pnome <$ppara> \r\n";
		$insere = "INSERT INTO log (id_usuario, usuario, senha, funcionario, nivel, resultado, ip, ip_endereco, navegador, versao, plataforma, agente, data, hora) VALUES ('0','$usuario','$senha','0','0','FALHA','" . $ip . "','" . $ip_endereco . "','" . $ua['name'] . "','" . $ua['version'] . "','" . $ua['platform'] . "','" . $ua['userAgent'] . "','" . date('Y-m-d') . "','" . date('G:i:s') . "')";
		if (!mysqli_query($conexao, $insere)) {
			die('Error: ' . mysqli_error($conexao));
		}
		if (mail("Virtua Brasil<contato@virtuabrasil.com.br>", "$assunto - NEGADO - " . $usuario, iconv("UTF-8", "ISO-8859-1", $msg), $headers)) {
			$acao = "erro";
		}
		echo "<script>alert('ACESSO NEGADO!');</script>";
	}
}
mysqli_close($conexao);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta name="description" content="Painel Administrativo">
	<meta name="author" content="Virtua Brasil">
	<title>Painel de Controle</title>
	<!-- Bootstrap Core CSS -->
	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<!-- Custom CSS -->
	<link href="css/adminnine.css" rel="stylesheet">
	<!-- Custom Fonts -->
	<link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<script>
		grecaptcha.execute();
	</script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<style type="text/css" media="screen">
		#input .btn:focus {
			outline: thin dotted;
			outline: 0px auto -webkit-focus-ring-color;
			outline-offset: 0px;
		}
		iframe {
			margin: 0 !important;
		}
	</style>
	<link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link rel="apple-touch-icon" sizes="57x57" href="favicon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="favicon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="favicon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="favicon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="favicon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="favicon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="favicon/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="favicon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192" href="favicon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="favicon//ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
</head>
<body class="loginpages">
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="login-panel panel panel-default">
					<div class="userpic"><img src="img/perfil.png" alt=""></div>
					<div class="panel-body">
						<h2 class="text-center">PAINEL DE ACESSO</h2>
						<form action="index.php" method="post">
							<fieldset>
								<div class="form-group">
									<div class="col-md-10">
										<input class="form-control" placeholder="Usuário" name="usuario" type="text" autofocus style="width: 100%;">
									</div>
								</div>
								<br><br>
								<div class="form-group">
									<div class="col-md-10" style="display: flex;">
										<input class="form-control" id="senha" placeholder="Senha" name="senha" type="password" value="" style="width: 100%;">
										<button type="button" class="btn" onclick="mostraSenha();" style="padding: 3px; border:none; background: transparent; margin-left: -1em;">
											<i class="fas fa-eye" style="font-size: 16px; margin-top: -5px!important;"></i>
										</button>
									</div>
									<div class="col-md-1" id="input">
									</div>
									<br><br>
								</div>
								<div id='recaptcha' class="g-recaptcha" data-sitekey="<?= $google_site_key; ?>" data-callback="onSubmit" data-size="invisible"></div>
								<input type="hidden" name="acao" id="acao" value="cmentrar" />
								<br>
								<button type="submit" class="btn btn-lg btn-primary btn-block">Acessar</button>
								<br><br>
								<center><strong>Desenvolvido por:</strong></center>
								<a href="https://www.virtuabrasil.com.br" target="_blank" title="Desenvolvido por Virtua Brasil">
									<center><img src="img/logo-virtua-black.png" alt="Desenvolvido por Virtua Brasil" title="Desenvolvido por Virtua Brasil" style="max-height: 15px;"></center>
								</a>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- jQuery -->
	<script src="vendor/jquery/jquery.min.js"></script>
	<!-- Bootstrap Core JavaScript -->
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<!-- Custom Theme JavaScript -->
	<script src="assets/js/adminnine.js"></script>
	<script>
		function mostraSenha() {
			var x = document.getElementById("senha");
			if (x.type === "password") {
				x.type = "text";
			} else {
				x.type = "password";
			}
		}
	</script>
</body>
</html>