<?
require_once "includes/config.php";
$email = ((isset($_POST['email']) AND $_POST['email']!='')?$_POST['email']:'');

$sql = "SELECT * FROM clientes WHERE email='$email' AND status='a' LIMIT 1";
$resultado = mysqli_query($conn, $sql) or die(mysqli_error($conn));
if(mysqli_num_rows($resultado)>0){
    function geraTokenRecupera($conn){
        mysqli_set_charset($conn,"utf8");
        if (!$conn) { die("Falha de conexão: " . mysqli_connect_error()); } 
		$possible = '123456789abcdefghijkmnpqrstuvwxyz';
		$code = '';
		$i = 0;
		while ($i < 128) {
			$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
			$i++;
		}
		$temTkn = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM clientes WHERE token='".$code."' limit 1"));
		if($temTkn==0){
			return $code;
		}else{
			geraTokenRecupera();
		}
	}
    $d = mysqli_fetch_array($resultado);
    $tkn = geraTokenRecupera($conn);
    mysqli_query($conn, "UPDATE clientes SET token='".$tkn."' WHERE email='".$email."' AND status='a'");
            
    $psite  = $url_loja;
    $pemail = $email_loja;
    $pnome = $nome_loja_completa;
    $pnome = ucfirst(trim($pnome));
    
    $conteudo = '
    <!DOCTYPE html>
    <html lang="pt-br" >
    <head>
      <meta charset="UTF-8">
      <title>Cadastro</title>  
    </head>
    <body>
      <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
      <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0;">
      <meta name="format-detection" content="telephone=no"/>
    
      <style>
    /* Reset styles */ 
    body { margin: 0; padding: 0; min-width: 100%; width: 100% !important; height: 100% !important;}
    body, table, td, div, p, a { -webkit-font-smoothing: antialiased; text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; line-height: 100%; }
    table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: collapse !important; border-spacing: 0; }
    img { border: 0; line-height: 100%; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; }
    #outlook a { padding: 0; }
    .ReadMsgBody { width: 100%; } .ExternalClass { width: 100%; }
    .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div { line-height: 100%; }
    
    /* Rounded corners for advanced mail clients only */ 
    @media all and (min-width: 560px) {
      .container { border-radius: 8px; -webkit-border-radius: 8px; -moz-border-radius: 8px; -khtml-border-radius: 8px;}
    }
    
    /* Set color for auto links (addresses, dates, etc.) */ 
    a, a:hover {
      color: #127DB3;
    }
    .footer a, .footer a:hover {
      color: #999999;
    }
    
      </style>
    </head>
    
    <!-- BODY -->
    <!-- Set message background color (twice) and text color (twice) -->
    <body topmargin="0" rightmargin="0" bottommargin="0" leftmargin="0" marginwidth="0" marginheight="0" width="100%" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; width: 100%; height: 100%; -webkit-font-smoothing: antialiased; text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; line-height: 100%;
      background-color: #F0F0F0;
      color: #000000;"
      bgcolor="#F0F0F0"
      text="#000000">
    
    <!-- SECTION / BACKGROUND -->
    <!-- Set message background color one again -->
    <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; width: 100%;" class="background"><tr><td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0;"
      bgcolor="#F0F0F0">
    
    <!-- WRAPPER -->
    <!-- Set wrapper width (twice) -->
    <table border="0" cellpadding="0" cellspacing="0" align="center"
      width="560" style="border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit;
      max-width: 560px;" class="wrapper">
    
    
    
    <!-- End of WRAPPER -->
    </table>
    
    <!-- WRAPPER / CONTEINER -->
    <!-- Set conteiner background color -->
    <table border="0" cellpadding="0" cellspacing="0" align="center"
      bgcolor="#FFFFFF"
      width="560" style="border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit;
      max-width: 560px;" class="container">
    
      <!-- HEADER -->
      <!-- Set text color and font family ("sans-serif" or "Georgia, serif") -->
      <tr>
        <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 24px; font-weight: bold; line-height: 130%;
          padding-top: 25px; color: #000000; background-color: '.$cor_header2.'; font-family: sans-serif;" class="header">
          <a href="'.$psite.'" title="'.$nome_loja_completa.'" >
            <img border="0" vspace="0" hspace="0" src="'.$psite.'/assets/img/logo/email.png" height="60" alt="'.$nome_loja_completa.'" title="'.$nome_loja_completa.'" style=" color: #000000; font-size: 10px; margin: 0; padding: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: block;" required />
          </a>
          </td>
          </tr>
          
          <!-- PARAGRAPH -->
          <!-- Set text color and font family ("sans-serif" or "Georgia, serif"). Duplicate all text styles in links, including line-height -->
          <tr>
          <td align="justify" valign="top" style="text-align:justify;border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 17px; font-weight: 400; line-height: 100%;
          padding-top: 25px; 
          color: #000000;
          font-family: sans-serif;" class="paragraph">
            <span><strong>Olá '.ucwords($d['responsavel_nome']).'!</strong></span><br><br>
            Uma redefinição de senha foi solicitada em nosso site. Clique no link abaixo para redefiní-la. Caso não tenha sido você, não se preocupe, apenas ignore este e-mail e sua senha permanecerá a atual já cadastrada e enviada para você anteriormente.
        </td>
      </tr>
    
    
      <!-- LINE -->
      <!-- Set line color -->
      <tr>  
        <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
          padding-top: 25px;" class="line"><hr
          color="#E0E0E0" align="center" width="100%" size="1" noshade style="margin: 0; padding: 0;" required />
        </td>
      </tr>
    
      <!-- LIST -->
      <tr>
        <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%;" class="list-item"><table align="center" border="0" cellspacing="0" cellpadding="0" style="width: inherit; margin: 0; padding: 0; border-collapse: collapse; border-spacing: 0;">
          
          <!-- LIST ITEM -->
          <tr>
    
            <!-- LIST ITEM IMAGE -->
            <!-- Image text color should be opposite to background color. Set your url, image src, alt and title. Alt text should fit the image size. Real image size should be x2 -->
            <td align="left" valign="top" style="border-collapse: collapse; border-spacing: 0; padding-top: 30px; border="0" vspace="0" hspace="0" style="padding: 0; margin: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: block; color: #000000;" src="'.$psite.'/assets/img/email.gif" alt="E agora?" title="E agora?" width="50" height="50"></td>
    
            <!-- LIST ITEM TEXT -->
            <!-- Set text color and font family ("sans-serif" or "Georgia, serif"). Duplicate all text styles in links, including line-height -->
            <td align="left" valign="top" style="font-size: 17px; font-weight: 400; line-height: 100%; border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0;
              padding-top: 25px;
              color: #000000;
              font-family: sans-serif;" class="paragraph">
                <b style="color: #333333;">E agora, o que faço?</b>
                <br>Basta você <a href="'.$psite.'/validar-token/'.$tkn.'" style="text-decoration: none;"><strong>CLICAR AQUI</strong></a> para redefinir sua senha.
            </td>
    
          </tr>
    
    
        </table></td>
      </tr>
    
      <!-- LINE -->
      <!-- Set line color -->
      <tr>
        <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
          padding-top: 25px;" class="line"><hr
          color="#E0E0E0" align="center" width="100%" size="1" noshade style="margin: 0; padding: 0;" required />
        </td>
      </tr>
    
      <!-- PARAGRAPH -->
      <!-- Set text color and font family ("sans-serif" or "Georgia, serif"). Duplicate all text styles in links, including line-height -->
      <tr>
        <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 17px; font-weight: 400; line-height: 100%;
          padding-top: 20px;
          padding-bottom: 25px;
          color: #000000;
          font-family: sans-serif;" class="paragraph">
            <strong>Possui alguma dúvida? Contate-nos.</strong><br><br><strong>E-mail:</strong><br>'.$pemail.'<br><br><strong>Telefone:</strong><br>'.$telefone_loja1.'&nbsp;&nbsp;'.(($telefone_loja2!='')?'|&nbsp;&nbsp;'.$telefone_loja2.'&nbsp;&nbsp;':'').''.(($telefone_loja3!='')?'|&nbsp;&nbsp;'.$telefone_loja3.'&nbsp;&nbsp;':'').'<br><br><strong>WhatsApp:</strong><br>'.$telefone_loja_whats.'<br><br><strong>Agradecemos pela preferência e confiança.</strong>
        </td>
      </tr>
    
    <!-- End of WRAPPER -->
    </table>
    
    <!-- WRAPPER -->
    <!-- Set wrapper width (twice) -->
    <table border="0" cellpadding="0" cellspacing="0" align="center"
      width="560" style="border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit;
      max-width: 560px;" class="wrapper">
    
      <!-- SOCIAL NETWORKS -->
      <!-- Image text color should be opposite to background color. Set your url, image src, alt and title. Alt text should fit the image size. Real image size should be x2 -->
      <tr>
        <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
          padding-top: 25px;" class="social-icons"><table
          width="256" border="0" cellpadding="0" cellspacing="0" align="center" style="border-collapse: collapse; border-spacing: 0; padding: 0;">
          <tr>
    
            <!-- ICON 1 -->
            <td align="right" valign="middle" style="margin: 0; padding: 0; padding-left: 10px; padding-right: 10px; border-collapse: collapse; border-spacing: 0;"><a target="_blank"
              href="'.$facebook.'"
            style="text-decoration: none;"><img border="0" vspace="0" hspace="0" style="padding: 0; margin: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: inline-block;
              color: #000000;"
              alt="F" title="Facebook"
              width="44" height="44"
              src="'.$psite.'/assets/img/facebook.png"></a></td>
    
    
            <!-- ICON 4 -->
            <td align="left" valign="middle" style="margin: 0; padding: 0; padding-left: 10px; padding-right: 10px; border-collapse: collapse; border-spacing: 0;"><a target="_blank"
              href="'.$instagram.'"
            style="text-decoration: none;"><img border="0" vspace="0" hspace="0" style="padding: 0; margin: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: inline-block;
              color: #000000;"
              alt="I" title="Instagram"
              width="44" height="44"
              src="'.$psite.'/assets/img/instagram.png"></a></td>
    
          </tr>
          </table>
        </td>
      </tr>
    
      <!-- FOOTER -->
      <!-- Set text color and font family ("sans-serif" or "Georgia, serif"). Duplicate all text styles in links, including line-height -->
      <tr>
        <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 13px; font-weight: 400; line-height: 150%;
          padding-top: 20px;
          padding-bottom: 20px;
          color: #999999;
          font-family: sans-serif;" class="footer">
            <span style="color:#333; font-weight:bold;">Não responda este email, pois ele é enviado automaticamente.</span>
            
        </td>
      </tr>
      <tr>
        <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 13px; font-weight: 400; line-height: 100%;
          padding-top: 20px;
          padding-bottom: 20px;
          color: #999999;
          font-family: sans-serif;border-top:1px solid #cccccc;" class="footer">
            <span style="color:#333; font-weight:bold;">Sistema Desenvolvido por<br><a href="https://www.virtuabrasil.com.br" title="Virtua Brasil" target="_blank"><img src="'.$psite.'/assets/img/logo-virtua-black.png"></a></span>
        </td>
      </tr>
    
    <!-- End of WRAPPER -->
    </table>
    
    <!-- End of SECTION / BACKGROUND -->
    </td></tr></table>
    
    </body>
    </html>
    
    </body>
    
    </html>
    ';
    
    $email_cliente = $d['email'];
    $nome = $d['responsavel_nome'];
    if ($pnome=='') { $pnome = $nome_loja_completa; }
    if ($pemail=='') { $pemail = "$email_loja"; }

    // $email_cliente = 'dev@virtuabrasil.com.br';
    // $pnome = 'dev@virtuabrasil.com.br';
    // $pemail = 'dev@virtuabrasil.com.br';

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: '.$pnome.' <'.$pemail.'>' . "\r\n";
    $headers .= 'Bcc: Virtua Brasil<contato@virtuabrasil.com.br>' . "\r\n";
    $headers .= 'Reply-To: '.$pnome.' <'.$pemail.'>' . "\r\n";
    $headers .= 'X-Mailer: PHP/' . phpversion();
      
    $assunto ="Recuperação de senha.";
    $email_to = $nome.'<'.$email_cliente.'>';
      
    $enviaremail = mail(iconv("UTF-8", "ISO-8859-1", $email_to), iconv("UTF-8", "ISO-8859-1", $assunto), iconv("UTF-8", "ISO-8859-1", $conteudo), iconv("UTF-8", "ISO-8859-1", $headers));
    
    if($enviaremail){
        $retorno["ok"] = 'sucesso';
    }else{
        $retorno["ok"] = 'falha';
    }

}else{
    $retorno["ok"] = 'falha';
}
echo json_encode($retorno);
?>