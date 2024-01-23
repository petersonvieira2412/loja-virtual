<?
ob_start();
require_once "includes/config.php";
$carrinho_sessao_id = session_id();
$onde='rastreamento';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
if (isset($_POST['acao']) AND $_POST['acao']=='rastrear'){
$nome = $_POST['nome'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$data = $_POST['data'];
$numero_pedido = $_POST['numero_pedido'];
$obs = $_POST['mensagem'];
$obs = nl2br("$obs");
$assunto = '*** CONTATO PELO SITE - RASTREIO ONLINE ***';

$ip       = $_SERVER['REMOTE_ADDR'];
$endereco_server = gethostbyaddr($_SERVER['REMOTE_ADDR']);
  $datas 	  = date('D');
  $mes 	  = date('M');
  $dia 	  = date('d');
  $ano 	  = date('Y');
  $semana   = array("Sun" => "Domingo", "Mon" => "Segunda-Feira", "Tue" => "Terca-Feira", "Wed" => "Quarta-Feira", "Thu" => "Quinta-Feira", "Fri" => "Sexta-Feira", "Sat" => "Sabado");
  $mess = array("Jan" => "Janeiro", "Feb" => "Fevereiro", "Mar" => "Marco", "Apr" => "Abril", "May" => "Maio", "Jun" => "Junho", "Jul" => "Julho", "Aug" => "Agosto", "Sep" => "Setembro", "Oct" => "Outubro", "Nov" => "Novembro", "Dec" => "Dezembro");
  $data 	  = $semana["$datas"].", $dia de ".$mess["$mes"]." de $ano";
  $hora     = date("H:i");										//Hora
  $hora     = $hora.'h';										//Hora
  $psite    = $url_loja;					//Pega o site origem
  $pnome    = $nome_loja_completa;
  $ppara	= $email_loja;						// para varios emails: $to = "email".","."email2";

  if ( empty($nome) OR empty($telefone) OR empty($data) OR empty($numero_pedido) OR empty($obs) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo "<script>alert('Por favor, preencha o formulário e tente novamente.');</script>";
    echo " <meta http-equiv='refresh' content=0;url='rastrear-pedido'>";
  } else {
  // emails para quem será enviado o formulário
  
  $emailenviar = $email_loja;
  $destino = $emailenviar;
  $nome_email = utf8_decode($nome);
  $email_rem = utf8_decode($email);
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
  $headers .= "From: $nome_email <$email_rem>\r\n";
  $headers .= "Bcc: contato@virtuabrasil.com.br\r\n";

  $enviaremail = mail($destino, $assunto, $arquivo, $headers);
  if($enviaremail){
      echo "<script>alert('Mensagem enviada com sucesso!');</script>";
      echo " <meta http-equiv='refresh' content=0;url='".$url_loja."/rastrear-pedido'>";
  } else {
  $mgm = "ERRO AO ENVIAR E-MAIL!";
  echo $mgm;
  }
}
}
}

if (!isset($titulo_site) || $titulo_site==''){$titulo_site = 'Rastrear Pedido';}
$descricao_site = '';
if (!isset($meta_site) || $meta_site==''){$meta_site= '';}
?>
<!doctype html>
<html class="no-js supports-no-cookies" lang="pt-br"> 
<head>
<?require_once "includes/head.php";?>
</head>
<body id="faqs" class="template-page theme-css-animate" data-currency-multiple="true">
<?
if (isset($_SESSION['tag_manager_body']) AND $_SESSION['tag_manager_body']!='') {
	echo $_SESSION['tag_manager_body'];
}
?>
<div id="theme-section-header" class="theme-section">
    <div data-section-id="header" data-section-type="header">
        <header id="header" class="header position-lg-relative js-header-sticky" data-js-sticky="desktop_and_mobile" data-js-desktop-sticky-sidebar="true">
            <?require_once "includes/header.php";?>
        </header>
    </div>

    <script>Loader.require({
        type: "script",
        name: "sticky_header"
    });
    Loader.require({
        type: "script",
        name: "header"
    });
    </script>
</div>
<main id="MainContent">
    <div class="breadcrumbs mt-15">
        <div class="container">
            <ul class="list-unstyled d-flex flex-wrap align-items-center justify-content-start">
                <li><a href="<?=$url_loja;?>" title="Home"><i class="fa-sharp fa-solid fa-house"></i></a></li>
                <li><span>Rastreamento online</span></li>
            </ul>
        </div>
    </div>
    <div class="container mb-60">
        <h1 class="h3 mt-30 text-center">Rastreamento online</h1>
        <div class="container">
            <form method="post" action="" accept-charset="UTF-8" class="contact-form">
                <label  class="label-required" for="nome">NOME</label>
                <input type="text" name="nome" id="nome" value="" required="required">
                <label  class="label-required" for="email">E-MAIL</label>
                <input type="email" name="email" id="email" value="" spellcheck="false" autocomplete="off" autocapitalize="off" required="required">
                <div style="display: flex; align-items: center;">
                    <div class="col-md-6" style="margin-left: -16px;">
                        <label class="label-required" for="numero_pedido">NÚMERO DO PEDIDO OU NOTA FISCAL</label>
                        <input type="text" name="numero_pedido" id="numero_pedido" value="" spellcheck="false" autocomplete="off" autocapitalize="off" required="required">
                    </div>
                    <div class="col-md-6">
                        <label class="label-required" for="data">DATA DA COMPRA</label>
                        <input type="date" name="data" id="data" class="label-required" placeholder="DATA DA COMPRA" style="border: 1px solid #E5E5E5; font-size: 16px;width: 106%;padding: 7px;"/>
                    </div>
                </div>
                <label class="label-required" for="telefone">TELEFONE</label>
                <input type="text" class="form-control" name="telefone" id="telefone" value="" required onkeypress="Mascara(this);" maxlength="15" size="20">
                <label class="label-required" for="mensagem">MENSAGEM</label>
                <textarea rows="8" name="mensagem" id="mensagem" required="required"></textarea>
                <div class="pt-10 text-center">
                    <button type="submit" name="acao" id="acao" value="rastrear"class="btn btn--secondary">
                        <i class="mr-5"></i>REALIZAR CONSULTA
                    </button>
                </div>
            </form>
        </div>

    </div>
</main>
    <?require_once "includes/footer.php"?>
</body>
</html>
<?
$cntACmp =ob_get_contents(); 
ob_end_clean(); 
$cntACmp=str_replace("\n",' ',$cntACmp); 
$cntACmp=preg_replace('/[[:space:]]+/',' ',$cntACmp);
echo $cntACmp; 
ob_end_flush(); 
?>