<?php
session_start();
setlocale (LC_ALL, 'pt_BR');
date_default_timezone_set('America/Sao_Paulo');

$agora = date('Y-m-d H:i:s');
if (!isset($_SESSION["controle_vb_painel_tempo"]) || $_SESSION["controle_vb_painel_tempo"]==''){
    $_SESSION["controle_vb_painel_tempo"] = $agora;
}
if (!isset($_SESSION['usr_id']) || $_SESSION['usr_id']==''){
    $_SESSION['usr_id'] = '';
}

if((strtotime($agora) - strtotime($_SESSION["controle_vb_painel_tempo"])) / 60 > 60 || $_SESSION['usr_id']==''){
	unset($_SESSION['controle_vb_painel_tempo']);
	unset($_SESSION['usr_id']);
	header('location:../sistema');
	exit();
}else{
	$_SESSION["controle_vb_painel_tempo"] = $agora;
}

$conexao = mysqli_connect("localhost", "graziuniformes_loja", 'gZ$xHFV=fk[8', "graziuniformes_loja");
mysqli_set_charset($conexao,"utf8");
if (!$conexao) { die("Falha na conexao: " . mysqli_connect_error()); }

$path = "/home/graziuniformes/public_html/";
$set_max_bytes_allowed = "90000000";

$psite = "https://www.graziuniformes.com.br";
$sitenome = explode('.', $psite);
$sitenome = $sitenome[1];
$pnome = "Grazi Uniformes";
$ppara = "contato@graziuniformes.com.br";
$pdescricao = "Entregamos em todo Vale do Paraíba com pagamento em até 10x no cartão - ".$pnome;
$purl_amigavel = 'grazi-uniformes';

$google_site_key = "6LciS7wlAAAAABfEMLmXuIjuWpFHSA-pX6WHvQ7T";
$google_secret_key = "6LciS7wlAAAAACkZrpsKt7V18O83PtA0r33xTKNw";

function clean($string){
    $table = array(
        'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z',
        'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
        'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
        'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
        'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
        'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
        'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
        'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
        'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
        'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
        'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
        'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r', '-'=>'',
    );
    // Traduz os caracteres em $string, baseado no vetor $table
    $string = trim($string);
    $string = strtr($string, $table);
    // converte para minúsculo
    $string = strtolower($string);
    // remove caracteres indesejáveis (que não estão no padrão)
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    // Remove múltiplas ocorrências de hífens ou espaços
    $string = preg_replace("/[\s-]+/", " ", $string);
    // Transforma espaços e underscores em hífens
    $string = preg_replace("/[\s_]/", "-", $string);
    if (substr($string, -1) == '-') $string = substr($string, 0, -1);
    // retorna a string
    return $string;
}
function minusculo($string){
    $table = array(
        'Š'=>'š', 'Đ'=>'dj', 'Ž'=>'ž',
        'Č'=>'č', 'Ć'=>'ć', 'À'=>'à', 'Á'=>'á', 'Â'=>'â', 'Ã'=>'ã', 'Ä'=>'ä', 'Å'=>'å', 'Æ'=>'æ', 
		'Ç'=>'ç', 
		'È'=>'è', 'É'=>'é', 'Ê'=>'ê', 'Ë'=>'ë',
		'Ì'=>'ì', 'Í'=>'í', 'Î'=>'î', 'Ï'=>'ï',
		'Ñ'=>'ñ',
		'Ò'=>'ò', 'Ó'=>'ó', 'Ô'=>'ô', 'Õ'=>'õ', 'Ö'=>'ö', 'Ø'=>'ø',
		'Ù'=>'ù', 'Ú'=>'ú', 'Û'=>'û', 'Ü'=>'ü',
		'Ý'=>'ý', 'Þ'=>'þ', 'ß'=>'ß',
		'Ŕ'=>'ŕ',
    );
    // Traduz os caracteres em $string, baseado no vetor $table
    $string = trim($string);
    $string = strtr($string, $table);
    // converte para minúsculo
    $string = strtolower($string);
    // remove caracteres indesejáveis (que não estão no padrão)
    // retorna a string
    return $string;
}
function preconj($string){	
    $table = array(
        ' De '=>' de ', ' Da '=>' da ', ' Do '=>' do ',
		' Por '=>' por ', ' Com '=>' com ', ' Em '=>' em ', ' Para '=>' para ',
		' A '=>' a ', ' E '=>' e ', ' O '=>' o ',
		' Á '=>' á ', ' É '=>' é ', ' Ó '=>' ó ',
		' À '=>' à ',
    );
    $string = strtr($string, $table);
    return $string;
}

//perfil
if (!isset($usr_foto)) { $usr_foto = "sem_foto.png"; }
if (!isset($usr_nome)) { $usr_nome = "Seu Nome"; }
if (isset($_POST['acao'])) { $acao = $_POST['acao']; } elseif (isset($_GET['acao'])) { $acao = $_GET['acao']; } else { $acao = ''; }
if (isset($_SESSION['usr_nivel'])) { $usr_nivel = $_SESSION['usr_nivel']; } else { $usr_nivel = ''; }
if (isset($_SESSION["usr_funcionario"])) { $usr_funcionario = $_SESSION["usr_funcionario"]; } else { $usr_funcionario = ''; }
if (isset($_POST['pag'])) { $pag = $_POST['pag']; } elseif (isset($_GET['pag'])) { $pag = $_GET['pag']; } else { $pag = 'home'; }
if (isset($_POST['id'])) { $id = $_POST['id']; } elseif (isset($_GET['id'])) { $id = $_GET['id']; } else { $id = ''; }
if (isset($_POST['categoria'])) { $categoria = $_POST['categoria']; } elseif (isset($_GET['categoria'])) { $categoria = $_GET['categoria']; } else { $categoria = ''; }
if (isset($_POST['categoria_pai'])) { $categoria_pai = $_POST['categoria_pai']; } elseif (isset($_GET['categoria_pai'])) { $categoria_pai = $_GET['categoria_pai']; } else { $categoria_pai = ''; }
?>