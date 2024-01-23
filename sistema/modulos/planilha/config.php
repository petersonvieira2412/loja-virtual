<?
session_start();

setlocale (LC_ALL, 'pt_BR');
date_default_timezone_set('America/Sao_Paulo');

$agora = date('Y-m-d H:i:s');

if((strtotime($agora) - strtotime($_SESSION["controle_vb_painel_tempo"])) / 60 > 60 || $_SESSION['usr_id']==''){

	unset($_SESSION['controle_vb_painel_tempo']);
	unset($_SESSION['usr_id']);
	header('location:../sistema');
    exit();
}else{
	$_SESSION["controle_vb_painel_tempo"] = $agora;
}

$conexao = mysqli_connect("localhost", "graziuniformes_loja", 'gZ$xHFV=fk[8', "graziuniformes_loja");	mysqli_set_charset($conexao, "utf8");
	
if (mysqli_connect_errno()) {
	die("Falha na conexao: %s\n" . mysqli_connect_error());
	exit();
}	


$path = "/home/graziuniformes/public_html/";
$set_max_bytes_allowed = "90000000";

$psite = "https://www.graziuniformes.com.br";
$pnome = "Grazi Uniformes";
$ppara = "contato@graziuniformes.com.br";

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

//perfil
if (!isset($usr_foto)) { $usr_foto = "sem_foto.png"; }
if (!isset($usr_nome)) { $usr_nome = "Seu Nome"; }
if (isset($_POST['acao'])) { $acao = $_POST['acao']; } elseif (isset($_GET['acao'])) { $acao = $_GET['acao']; } else { $acao = ''; }
if (isset($_SESSION['usr_nivel'])) { $usr_nivel = $_SESSION['usr_nivel']; } else { $usr_nivel = ''; }
if (isset($_POST['pag'])) { $pag = $_POST['pag']; } elseif (isset($_GET['pag'])) { $pag = $_GET['pag']; } else { $pag = 'home'; }
if (isset($_POST['id'])) { $id = $_POST['id']; } elseif (isset($_GET['id'])) { $id = $_GET['id']; } else { $id = ''; }
if (isset($_POST['categoria'])) { $categoria = $_POST['categoria']; } elseif (isset($_GET['categoria'])) { $categoria = $_GET['categoria']; } else { $categoria = ''; }
if (isset($_POST['categoria_pai'])) { $categoria_pai = $_POST['categoria_pai']; } elseif (isset($_GET['categoria_pai'])) { $categoria_pai = $_GET['categoria_pai']; } else { $categoria_pai = ''; }

?>