<?php
require_once "config.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = ((isset($_POST["nome"]) AND $_POST["nome"]!='')?$_POST["nome"]:'');
    $email = ((isset($_POST["email"]) AND $_POST["email"]!='')?$_POST["email"]:'');
    $pagina = ((isset($_POST["pagina"]) AND $_POST["pagina"]!='')?$_POST["pagina"]:'');
    
    $sql_news = mysqli_query($conn, "SELECT email FROM newsletter WHERE email='$email'");
    
    if (mysqli_num_rows($sql_news)<1){
    
        $sql_newsletter = mysqli_query($conn, "INSERT INTO newsletter (nome, email, data_cadastro, hora_cadastro, status) VALUES ('$nome', '$email', '".date('Y-m-d')."', '".date('H:i:s')."', 'a')");
        
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');   
        date_default_timezone_set('America/Sao_Paulo');
        $data_atual = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
        $dominio = str_replace('www.', '', $_SERVER['HTTP_HOST']);
        
        $email = ((isset($_POST['email']))?strip_tags($_POST['email']):'');
        
        $vb_nome = $nome_loja;
        $vb_email = $email_loja;
        
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: '.$vb_nome.' <'.$vb_email.'>' . "\r\n";
        $headers .= 'Bcc: Virtua Brasil<dev@virtuabrasil.com.br>' . "\r\n";
        $headers .= 'Reply-To: Virtua Brasil<contato@virtuabrasil.com.br>' . "\r\n";
        $headers .= 'X-Mailer: PHP/' . phpversion();
        
        $mensagememail .= '<strong>E-mail:</strong> '.$email.'<br>';
        $mensagememail .= '<strong>Origem:</strong> '.$pagina.'<br><br><br>';
        
        $mensagememail .= '<strong>IP:</strong> '.$_SERVER['REMOTE_ADDR'].'<br>';
        $mensagememail .= '<strong>Endereço IP:</strong> '.gethostbyaddr($_SERVER['REMOTE_ADDR']).'<br>';
        $mensagememail .= ucfirst(IntlDateFormatter::formatObject($data_atual, "eeee, d 'de' MMMM y 'às' HH:mm", 'pt_BR')).'<br>';
        
        $assunto = '*** Newsletter - '.$vb_nome.' ***';
        $email_to = 'Virtua Brasil<contato@virtuabrasil.com.br>';
        $successo = mail(iconv("UTF-8", "ISO-8859-1", $email_to), iconv("UTF-8", "ISO-8859-1", $assunto), iconv("UTF-8", "ISO-8859-1", $mensagememail), iconv("UTF-8", "ISO-8859-1", $headers));
        
        if (!$successo) {
            $retorno["ok"] = 'falha';
        }else{
            $retorno["ok"] = 'sucesso';
        }
        
        if ($sql_newsletter==true){
            $_SESSION['newsletter'] = 'desativado';
        }
        
        $retorno["dados"] = true;
        echo json_encode($retorno);
    }else{
        $retorno["dados"] = false;
        $retorno["mensagem"] = 'E-mail já cadastrado';
        echo json_encode($retorno);
    }
}