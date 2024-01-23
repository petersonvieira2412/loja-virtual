<?
ob_start();
require_once "includes/config.php";
$onde = 'contato';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["contato"]) && $_POST["contato"]=="gravar") {
        if (isset($_POST['g-recaptcha-response']) AND $_POST['g-recaptcha-response']!=''){
            $recaptcha = $_POST['g-recaptcha-response'];
        }else{
            $recaptcha = '';
        }
        if(!empty($recaptcha)){
        function getCurlData($url){
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_TIMEOUT, 120);
            $curlData = curl_exec($curl);
            curl_close($curl);
            return $curlData;
        }
            $google_url="https://www.google.com/recaptcha/api/siteverify";
            $secret=$google_secret_key;
            $ip=$_SERVER['REMOTE_ADDR'];
            $url=$google_url."?secret=".$secret."&response=".$recaptcha."&remoteip=".$ip;
            $res=getCurlData($url);
            $res= json_decode($res, true);
            //reCaptcha success check 
            if($res['success']){
                $liberado="sim";
            } else {
                $liberado="nao";
            }
        } else {
            $liberado="nao";
        }
    }
    if($liberado=='nao'){
        $retorno["ok"] = 'falha';
        $retorno["mensagem"] = 'RECAPTCHA NECESSÁRIO!';
        echo json_encode($retorno);
        exit();
    } else {

        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');   
        date_default_timezone_set('America/Sao_Paulo');
        $data_atual = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
        $dominio = str_replace('www.', '', $_SERVER['HTTP_HOST']);

        $nome = ((isset($_POST['nome']))?strip_tags($_POST['nome']):'');
        if ($nome==''){
            $retorno["ok"] = 'falha';
            $retorno["mensagem"] = 'Preencha o campo nome';
            echo json_encode($retorno);
            exit();
        }
        $email = ((isset($_POST['email']))?strip_tags($_POST['email']):'');
        if ($email==''){
            $retorno["ok"] = 'falha';
            $retorno["mensagem"] = 'Preencha o campo e-mail';
            echo json_encode($retorno);
            exit();
        }
        $whatsapp = ((isset($_POST['whatsapp']))?strip_tags($_POST['whatsapp']):'');
        if ($whatsapp==''){
            $retorno["ok"] = 'falha';
            $retorno["mensagem"] = 'Preencha o campo whatsapp';
            echo json_encode($retorno);
            exit();
        }
        $mensagem = ((isset($_POST['mensagem']))?strip_tags($_POST['mensagem']):'');
        if ($mensagem==''){
            $retorno["ok"] = 'falha';
            $retorno["mensagem"] = 'Preencha o campo mensagem';
            echo json_encode($retorno);
            exit();
        }

        $vb_nome = $nome_loja;
        $vb_email = $email_loja;

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: '.$vb_nome.' <'.$vb_email.'>' . "\r\n";
        $headers .= 'Bcc: Virtua Brasil<contato@virtuabrasil.com.br>' . "\r\n";
        $headers .= 'Reply-To: '.$nome.' <'.$email.'>' . "\r\n";
        $headers .= 'X-Mailer: PHP/' . phpversion();

        $mensagememail  = '<strong>Nome:</strong> '.$nome.'<br><br>';
        $mensagememail .= '<strong>WhatsApp:</strong> '.$whatsapp.'<br><br>';
        $mensagememail .= '<strong>E-mail:</strong> '.$email.'<br><br>';
        $mensagememail .= '<strong>Mensagem:</strong> '.$mensagem.'<br><br>';

        $mensagememail .= '<strong>IP:</strong> '.$_SERVER['REMOTE_ADDR'].'<br>';
        $mensagememail .= '<strong>Endereço IP:</strong> '.gethostbyaddr($_SERVER['REMOTE_ADDR']).'<br>';
        $mensagememail .= ucfirst(IntlDateFormatter::formatObject($data_atual, "eeee, d 'de' MMMM y 'às' HH:mm", 'pt_BR')).'<br>';

        $assunto = '*** '.$vb_nome.' - Formulário de Contato ***';
        $email_to = $vb_nome.'<'.$vb_email.'>';
        $successo = mail(iconv("UTF-8", "ISO-8859-1", $email_to), iconv("UTF-8", "ISO-8859-1", $assunto), iconv("UTF-8", "ISO-8859-1", $mensagememail), iconv("UTF-8", "ISO-8859-1", $headers));

        if (!$successo) {
            $retorno["ok"] = 'falha';
            $retorno["mensagem"] = 'Falha ao enviar a mensagem, tente novamente!';
            echo json_encode($retorno);
            exit();
        }else{
            $retorno["ok"] = 'sucesso';
            $retorno["mensagem"] = 'Mensagem enviada com sucesso!';
            echo json_encode($retorno);
			exit();
        }
    }
}
if (!isset($titulo_site) || $titulo_site==''){$titulo_site = 'Entre em contato conosco';}
if (!isset($descricao_site) || $descricao_site==''){$descricao_site = '';}
if (!isset($meta_site) || $meta_site==''){$meta_site= '';}
?>
<!doctype html>
<html class="no-js supports-no-cookies" lang="pt-br"> 
<head>
    <?require_once "includes/head.php";?>
	<script src="https://www.google.com/recaptcha/api.js?hl=pt-BR" async defer></script>
</head>
<body id="contact" class="template-page theme-css-animate" data-currency-multiple="true">
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
    <script>
    Loader.require({
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
            <ul class="list-unstyled d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <li><a href="<?=$url_loja;?>" title="Home"><i class="fa-sharp fa-solid fa-house"></i></a></li>
                <li><span>Contato</span></li>
            </ul>
        </div>
    </div>
    <div class="container mb-60">
        <div class="row mt-30">
            <?if (isset($endereco_loja_completo_2) AND $endereco_loja_completo_2!=""){?>
                <div class="col-12 col-md-12">
                    <h2 class="h3 text-center">Entre em Contato</h2>
                    <form method="post" action="" id="contact_form" accept-charset="UTF-8" class="contact-form">
                        <input type="hidden" name="form_type" value="contact"/><input type="hidden"name="utf8" value="✓"/>
                        <label for="ContactFormName" class="label-required">NOME</label>
                        <input type="text" name="nome" id="nome" value="" required="required">
                        <label for="ContactFormEmail" class="label-required">E-MAIL</label>
                        <input type="email" name="email" id="email" value="" spellcheck="false" autocomplete="off" autocapitalize="off" required="required">
                        <label for="ContactFormPhone" class="label-required">WHATSAPP</label>
                        <input type="text" class="form-control cel" name="whatsapp" id="whatsapp" value="" required maxlength="15" size="20">
                        <label for="ContactFormMessage" class="label-required">MENSAGEM</label>
                        <textarea rows="8" name="mensagem" id="mensagem" required="required"></textarea>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="pt-10 d-flex align-items-center" style="justify-content: space-between;">
                                    <div style="height: 50px;">
                                        <div class="g-recaptcha" data-sitekey="<?=$google_site_key;?>" data-theme="light" style="transform:scale(0.65);-webkit-transform:scale(0.65);transform-origin:0 0;-webkit-transform-origin:0 0; margin: 0 !important;"></div>
                                        <input type="hidden" name="acao" id="acao" value="cmentrar"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6" style="display: flex; justify-content: flex-end;">  
                                <input type="hidden" name="contato" value="gravar">
                                <button type="button" onclick="Contato();" class="btn btn--secondary">
                                    <i class="mr-5">
                                        <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-196" viewBox="0 0 24 24"> <path d="M21.842 2.54a.601.601 0 0 1 .186.439v12.5c0 .169-.062.315-.186.439s-.271.186-.439.186h-8.535l-5.449 4.238c-.065.052-.13.088-.195.107s-.13.029-.195.029c-.052 0-.101-.007-.146-.02l-.127-.039c-.104-.052-.188-.13-.254-.234s-.098-.215-.098-.332v-3.75h-3.75c-.169 0-.315-.062-.439-.186s-.186-.271-.186-.439v-12.5c0-.169.062-.315.186-.439s.271-.186.439-.186h18.75a.606.606 0 0 1 .438.187zm-1.065 1.064h-17.5v11.25h3.75c.169 0 .315.062.439.186s.186.271.186.439v3.105l4.609-3.594c.065-.052.13-.088.195-.107s.13-.029.195-.029h8.125V3.604z"/></svg>
                                    </i>ENVIAR
                                </button>
                            </div>
                        </div>
                    </form>
                    <div id="contato_popup" class="d-none guias btn-link h6 mb-10 px-15 px-lg-10 js-popup-button d-flex align-items-center" data-js-popup-button="contato"></div>
                </div>
                <div class="col-12 col-md-12 mb-30 text-center">
                    <h1 class="h3 mb-30">Unidades</h1>
                </div>
                <div class="col-12 col-md-6 mb-30">
                    <div class="rte">
                        <h5><a href="<?=$email_loja_link;?>" target="_blank" rel="noopener"><i style="color:#141414" class="fa fa-envelope"></i> <?=$email_loja;?></a></h5>
                        <h5><a href="<?=$link_telefone_loja3;?>" target="_blank" rel="noopener"><i style="color:#141414" class="fa-solid fa-phone"></i> <?=$telefone_loja3;?></a> | <a href="<?=$link_telefone_loja4;?>" target="_blank" rel="noopener"><i style="color:#141414" class="fa-solid fa-phone"></i> <?=$telefone_loja4;?></a><br></h5>
                        <h5><a href="<?=$link_whats_2;?>" target="_blank" rel="noopener"><i style="color:#141414" class="fa-brands fa-square-whatsapp"></i> <?=$telefone_loja_whats2;?></a><br></h5>
                        <h5><a href="<?=$link_meu_negocio;?>" target="_blank" rel="noopener"><i style="color:#141414" class="fa fa-location-dot"></i> <?=$endereco_loja_completo;?></a></h5>
                        <h5 class="h4 mb-5"><i style="color:#141414" class="fa fa-clock"></i> Horário de Funcionamento</h5>
                        <h5><a href="#"> <?=$horario_funcionamento;?></a></h5>
                    </div>
                    <div class="mt-30">
                        <div id="theme-section-contact-map" class="theme-section">
                            <div class="contact-map position-relative">
                                <?=$google_meu_negocio;?> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-30">
                    <div class="rte">
                        <h5><a href="<?=$email_loja_link;?>" target="_blank" rel="noopener"><i style="color:#141414" class="fa fa-envelope"></i> <?=$email_loja;?></a></h5>
                        <h5><a href="<?=$link_telefone_loja1;?>" target="_blank" rel="noopener"><i style="color:#141414" class="fa-solid fa-phone"></i> <?=$telefone_loja1;?></a> | <a href="<?=$link_telefone_loja2;?>" target="_blank" rel="noopener"><i style="color:#141414" class="fa-solid fa-phone"></i> <?=$telefone_loja2;?></a><br></h5>
                        <h5><a href="<?=$link_whats;?>" target="_blank" rel="noopener"><i style="color:#141414" class="fa-brands fa-square-whatsapp"></i> <?=$telefone_loja_whats;?></a><br></h5>
                        <h5><a href="<?=$link_meu_negocio_2;?>" target="_blank" rel="noopener"><i style="color:#141414" class="fa fa-location-dot"></i> <?=$endereco_loja_completo_2;?></a></h5>
                        <h5 class="h4 mb-5"><i style="color:#141414" class="fa fa-clock"></i> Horário de Funcionamento</h5>
                        <h5><a href="#"> <?=$horario_funcionamento2;?></a></h5>
                    </div>
                    <div class="mt-30">
                        <div id="theme-section-contact-map" class="theme-section">
                            <div class="contact-map position-relative">
                                <?=$google_meu_negocio_2;?> 
                            </div>
                        </div>
                    </div>
                </div>
            <?}else{?>
                <div class="col-12 col-md-4 mb-30">
                    <div class="rte">
                        <h1 class="h3 mb-30">Informações</h1>
                        <h5><a href="<?=$link_whats;?>" target="_blank" rel="noopener"><i style="color:#141414" class="fa-brands fa-square-whatsapp"></i> <?=$telefone_loja_whats;?></a><br></h5>
                        <h5><a href="<?=$email_loja_link;?>" target="_blank" rel="noopener"><i style="color:#141414" class="fa fa-envelope"></i> <?=$email_loja;?></a></h5>
                        <h5><a href="<?=$link_endereco;?>" target="_blank" rel="noopener"><i style="color:#141414" class="fa fa-location-dot"></i> <?=$endereco_loja_completo;?></a></h5>
                    </div>
                    <div class="mt-30">
                        <div id="theme-section-contact-map" class="theme-section">
                            <div class="contact-map position-relative">
                                <?=$google_meu_negocio;?> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-7">
                    <h2 class="h3 text-center">Entre em Contato</h2>
                    <form method="post" action="" id="contact_form" accept-charset="UTF-8" class="contact-form">
                        <input type="hidden" name="form_type" value="contact"/><input type="hidden"name="utf8" value="✓"/>
                        <label for="ContactFormName" class="label-required">NOME</label>
                        <input type="text" name="nome" id="nome" value="" required="required">
                        <label for="ContactFormEmail" class="label-required">E-MAIL</label>
                        <input type="email" name="email" id="email" value="" spellcheck="false" autocomplete="off" autocapitalize="off" required="required">
                        <label for="ContactFormPhone" class="label-required">WHATSAPP</label>
                        <input type="text" class="form-control cel" name="whatsapp" id="whatsapp" value="" required maxlength="15" size="20">
                        <label for="ContactFormMessage" class="label-required">MENSAGEM</label>
                        <textarea rows="8" name="mensagem" id="mensagem" required="required"></textarea>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="pt-10 d-flex align-items-center" style="justify-content: space-between;">
                                    <div style="height: 50px;">
                                        <div class="g-recaptcha" data-sitekey="<?=$google_site_key;?>" data-theme="light" style="transform:scale(0.65);-webkit-transform:scale(0.65);transform-origin:0 0;-webkit-transform-origin:0 0; margin: 0 !important;"></div>
                                        <input type="hidden" name="acao" id="acao" value="cmentrar"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6" style="display: flex; justify-content: flex-end;">  
                                <input type="hidden" name="contato" value="gravar">
                                <button type="button" onclick="Contato();" class="btn btn--secondary">
                                    <i class="mr-5">
                                        <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-196" viewBox="0 0 24 24"> <path d="M21.842 2.54a.601.601 0 0 1 .186.439v12.5c0 .169-.062.315-.186.439s-.271.186-.439.186h-8.535l-5.449 4.238c-.065.052-.13.088-.195.107s-.13.029-.195.029c-.052 0-.101-.007-.146-.02l-.127-.039c-.104-.052-.188-.13-.254-.234s-.098-.215-.098-.332v-3.75h-3.75c-.169 0-.315-.062-.439-.186s-.186-.271-.186-.439v-12.5c0-.169.062-.315.186-.439s.271-.186.439-.186h18.75a.606.606 0 0 1 .438.187zm-1.065 1.064h-17.5v11.25h3.75c.169 0 .315.062.439.186s.186.271.186.439v3.105l4.609-3.594c.065-.052.13-.088.195-.107s.13-.029.195-.029h8.125V3.604z"/></svg>
                                    </i>ENVIAR
                                </button>
                            </div>
                        </div>
                    </form>
                    <div id="contato_popup" class="d-none guias btn-link h6 mb-10 px-15 px-lg-10 js-popup-button d-flex align-items-center" data-js-popup-button="contato"></div>
                </div>
            <?}?>
        </div>
    </div>
</main>
<?require_once "includes/footer.php"?>
<script>
function Contato(){
    var form = document.getElementById("contact_form");
    var formData = new FormData(form);
    $.ajax({
        type: 'POST',
        url: 'https://<?=$_SERVER['HTTP_HOST']?><?=$_SERVER['REQUEST_URI'];?>',
        data: formData,
        dataType: 'json',
        success: function (data) {
            if (data.ok=='sucesso'){
                $('#mensagem_contato').html(data.mensagem);
                $('#contato_popup').click();
                setTimeout(function() {
                    $('#popup_contato').fadeOut('medium');
                    window.location.href='contato';
                }, 4000);
            }else{
                $('#mensagem_contato').html(data.mensagem);
                $('#contato_popup').click();
                setTimeout(function() {
                    $('#fecha_contato').click();
                }, 4000);
            }
        },
        cache: false,
        contentType: false,
        processData: false,
        xhr: function() {
            var myXhr = $.ajaxSettings.xhr();
            if (myXhr.upload) {
                myXhr.upload.addEventListener('progress', function() {
                }, false);
            }
            return myXhr;
        }
    });
}
</script>
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