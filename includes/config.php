<?
session_start();
setlocale (LC_ALL, 'pt_BR');
date_default_timezone_set('America/Sao_Paulo');

$conn = mysqli_connect("localhost", "graziuniformes_loja", 'gZ$xHFV=fk[8', "graziuniformes_loja");
mysqli_set_charset($conn,"utf8");
if (!$conn) { die("Falha de conexão: " . mysqli_connect_error()); } 

$dominio = str_replace('www.', '', $_SERVER['HTTP_HOST']);
$nome_loja = 'Grazi Uniformes';
$nome_loja_completa = 'Grazi Uniformes';

$vb_titulo_site = $nome_loja_completa;
$vb_descricao_site = 'Precisando encontrar alguém que atue no ramo de Uniformes em Taubaté/SP? A solução está aqui! '.$nome_loja.' quer servi-lo!';
$vb_meta_site = $nome_loja.', endereco de grazi uniformes, telefone de grazi uniformes em Taubaté, telefone de grazi uniformes em Vila Jaboticabeira, Uniformes em Vila Jaboticabeira, grazi uniformes em Vila Jaboticabeira, grazi uniformes em Taubaté, melhor Uniformes em Taubaté, empresa de Uniformes em Taubaté, empresa de Uniformes';

$tipo_loja = 'Business';
$telefone_loja1 = '(12) 3424-5565';
$telefone_loja2 = '';
$telefone_loja3 = '';
$telefone_loja4 = '';
$telefone_loja_whats ='(12) 3424-5565';
$telefone_loja_whats2 ='';
$link_telefone_loja1 = 'callto:+551234245565';
$link_telefone_loja2 = '';
$link_telefone_loja3 = '';
$link_telefone_loja4 = '';
$link_whats = 'https://whatsapp.graziuniformes.com.br';
$link_whats_2 = '';
$whats_quero_desconto = $link_whats;
$email_loja = 'contato@graziuniformes.com.br';
$email_loja_link = 'mailto:'.$email_loja.'';
$link_endereco = 'https://endereco.graziuniformes.com.br';
$pagseguro = 'contato@graziuniformes.com.br';
$url_loja = 'https://www.'.$dominio;
$url_amigavel_loja = 'grazi-uniformes';
$sessao_loja = 'graziuniformes';
$token_loja = '@'.$sessao_loja.'#'.date('Y');
$razao_social_loja ='<strong style="text-transform: uppercase;">Grazi Uniformes</strong>';
$vb_url_amigavel = "grazi-uniformes";
$cnpj_loja = '12.557.511/0001-98';

$endereco_rodape = 'Rua Santa Isabel de Portugal, 36 - Vila Jaboticabeira - Taubaté/SP';
$endereco_loja_completo = 'Rua Santa Isabel de Portugal, 36 - Vila Jaboticabeira - Taubaté/SP - 12030-640';
$endereco_loja_completo_2 = "";
$endereco_loja = 'Rua Santa Isabel de Portugal';
$numero_loja = '36';
$complemento_loja = '';
$bairro_loja = 'Vila Jaboticabeira';
$cidade_loja = 'Taubaté';
$estado_loja = 'SP';
$cep_loja = '12030-640';

$horario_funcionamento = "";

$horario_funcionamento2 = "";

$google_meu_negocio = '<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14686.542031524024!2d-45.5683061!3d-23.0371516!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ccf8e418f09da5%3A0x1dd1416abfe96d09!2sGrazi%20Uniformes!5e0!3m2!1sen!2sbr!4v1691616435303!5m2!1sen!2sbr" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>'; //iframe do mapa
$link_meu_negocio = $link_endereco;
$google_meu_negocio_2 = ''; //iframe do mapa
$link_meu_negocio_2 = '';

$home_banner = 'off';
$categoria_banner = 'off';

$token_frete = '';
$email_pagseguro = "";
$token_pagseguro = "";

$vb_catalogo = 'nao';
$vb_newsletter = 'nao';

$google_site_key = "6Lc4vZMnAAAAAFtiJtpaGwBw89Rf0Gje86dw-eiZ";
$google_secret_key = "6Lc4vZMnAAAAAA8sr9-fw_Kkx8Lh4K2sUIbpGbnq";
    
//****************** CORES ************************

$cor_preco = "#e41f24";
$cor_site = "#e30613";

$cor_header1 = "#e30613";
$cor_header1_texto = "#fff";

$cor_header2 = "#fff";
$cor_header2_texto = "#000";

$cor_header3 = "#e30613";
$cor_header3_texto = "#fff";

$cor_rodape1 = '#e30613';
$cor_rodape1_texto = '#fff';

$cor_rodape2 = '#222222';
$cor_rodape2_texto = '#fff';

$cor_escuro = "#b9040e";

//****************** REDES SOCIAIS ************************

$facebook = 'https://www.facebook.com/GraziUniformes/';
$instagram = 'https://www.instagram.com/grazi.uniformes/';
$twitter ='';
$youtube ='';
$linkedin = '';
$tiktok = '';

//****************** LINK  ************************

$link_cor_borda = '#e30613';
$link_site = 'https://www.graziuniformes.com.br';
$link_logo = $link_site.'/assets/img/logo_link.webp';
$link_fundo = $link_site.'/assets/img/fundo_link.webp';
$link_ogimg = $link_site.'/assets/img/og.webp';

$link_facebook = $facebook;
$link_instagram = $instagram;
$link_youtube = "";
$link_tiktok = "";
$link_trinks = "";

if (!isset($_SESSION['dominio']) OR $_SESSION['dominio']!=$_SERVER['HTTP_HOST'] OR !isset($_SESSION['google_analytics']) or !isset($_SESSION['pixel'])){

	$sql = "SELECT * FROM dominios WHERE dominio='".str_replace('www.', '', $_SERVER['HTTP_HOST'])."' AND status='a' limit 1";
	$query = mysqli_query($conn, $sql);
	$dados = mysqli_fetch_assoc($query);
    if (isset($dados['dominio']) AND $dados['dominio']!=''){
        $_SESSION['dominio'] =  $dados['dominio']; 
    }
    if (isset($dados['analytics']) AND $dados['analytics']!=''){
        $_SESSION['google_analytics'] =  $dados['analytics'];
    }
    if (isset($dados['pixel']) AND $dados['pixel']!=''){
        $_SESSION['pixel'] =  $dados['pixel']; 
    }
    if (isset($dados['facebook']) AND $dados['facebook']!=''){
        $_SESSION['facebook'] =  $dados['facebook']; 
    }
    if (isset($dados['clarity']) AND $dados['clarity']!=''){
        $_SESSION['clarity'] =  $dados['clarity']; 
    }
    if (isset($dados['tag_manager_head']) AND $dados['tag_manager_head']!=''){
        $_SESSION['tag_manager_head'] =  $dados['tag_manager_head']; 
    }
    if (isset($dados['tag_manager_body']) AND $dados['tag_manager_body']!=''){
        $_SESSION['tag_manager_body'] =  $dados['tag_manager_body']; 
    }
    if (isset($dados['scripts']) AND $dados['scripts']!=''){
        $_SESSION['scripts'] =  $dados['scripts']; 
    }
}

const PIXEL_ID = '';
const ACCESS_TOKEN = '';
const TEST_EVENT_CODE = '';

// Função para gerar o event_id 
function generateUniqueEventId() {
    return uniqid();
}

// Funcão para obter o event_source_url
function getEventSourceUrl() {
    return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
}

$path_loja = "/home/graziuniformes/public_html/";

if (!isset($_SESSION['popup'])) { $_SESSION['popup'] = 'ativado'; }
$popup_img = ""; // diretório completo | vazio para cancelar popup

if (!isset($_SESSION['cookies_loja_lgpb_google'])) { $_SESSION['cookies_loja_lgpb_google'] = 'ativado'; }
if (!isset($_SESSION['cookies_loja_lgpb_facebook'])) { $_SESSION['cookies_loja_lgpb_facebook'] = 'ativado'; }
if (!isset($_SESSION['cookies_loja_lgpb_desempenho'])) { $_SESSION['cookies_loja_lgpb_desempenho'] = 'ativado'; }
if (!isset($_SESSION['cookies_loja_lgpb_publicidade'])) { $_SESSION['cookies_loja_lgpb_publicidade'] = 'ativado'; }
if ($vb_newsletter=='sim'){
    if (!isset($_SESSION['newsletter'])) {$_SESSION['newsletter'] = 'ativado';}
}else{
    if (!isset($_SESSION['newsletter'])) {$_SESSION['newsletter'] = 'desativado';}
}

if (!isset($_SESSION['usr_id_cliente'])) { $_SESSION['usr_id_cliente'] = '0'; }
if (!isset($_SESSION['usr_nome_cliente'])) { $_SESSION['usr_nome_cliente'] = ''; }
if (!isset($_SESSION['usr_foto_cliente'])) { $_SESSION['usr_foto_cliente'] = ''; }
if (!isset($usr_id_cliente)) { $usr_id_cliente = '0'; } else { $usr_id_cliente = $_SESSION["usr_id_cliente"]; }
if (isset($_POST['categoria'])) { $categoria = $_POST['categoria']; } elseif (isset($_GET['categoria'])) { $categoria = $_GET['categoria']; } else { $categoria = ''; }
if (isset($_POST['ordenar'])) { $ordenar = $_POST['ordenar']; } elseif (isset($_GET['ordenar'])) { $ordenar = $_GET['ordenar']; } else { $ordenar = '0'; }
if (isset($_POST['pagina'])) { $pagina = $_POST['pagina']; } elseif (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina = '1'; }
if (isset($_POST['produtos'])) { $produtos = $_POST['produtos']; } elseif (isset($_GET['produtos'])) { $produtos = $_GET['produtos']; } else { $produtos = ''; }
if (isset($_POST['id'])) { $id = (int)$_POST['id']; } elseif (isset($_GET['id'])) { $id = (int)$_GET['id']; } else { $id = '1'; }
$id = (int)$id;
if (isset($_POST['acao'])) { $acao = $_POST['acao']; } elseif (isset($_GET['acao'])) { $acao = $_GET['acao']; } else { $acao = ''; }
if (isset($_POST['url_amigavel'])) { $url_amigavel = $_POST['url_amigavel']; } elseif (isset($_GET['url_amigavel'])) { $url_amigavel = $_GET['url_amigavel']; } else { $url_amigavel = 'grazi-uniformes'; }

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