<?
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["nova_senha"]) && $_POST["nova_senha"]=="nova_senha") {
        $senha = ((isset($_POST["senha"]))?sha1($_POST["senha"]):'');
        $confirma_senha = ((isset($_POST["confirma_senha"]))?sha1($_POST["confirma_senha"]):'');

        if($senha!=$confirma_senha){
            $retorno["ok"] = 'falha';
            $retorno["mensagem"] = 'As senhas não conferem!';
            echo json_encode($retorno);
            exit;
        }else{
            
            mysqli_query($conn,"UPDATE clientes SET senha='".sha1($senha)."', token='".$token_loja."' WHERE id='".$_SESSION["_browser_nav_cache_id_"]."'") or die(mysqli_error($conn));

            $_SESSION["usr_id_cliente"] = $_SESSION["_browser_nav_cache_id_"];
            $_SESSION["controle_vb_cliente"] = "vb_cliente";
            $_SESSION["controle_vb_tempo"] = date('Y-m-d H:i:s');
            $usr_id_cliente = $_SESSION["usr_id_cliente"];

            unset($_SESSION["_browser_nav_cache_token_"]);
            unset($_SESSION["_browser_nav_cache_id_"]);

            $dados = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id, email, responsavel_nome FROM clientes WHERE id='".$usr_id_cliente."' limit 1"));

            $psite    = $url_loja;
            $pnome    = $nome_loja_completa;
            $ptelefone = $telefone_loja1;
            $pemail = $email_loja;
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
                    padding-top: 25px;
                    color: #000000; background-color: '.$cor_header2.' font-family: sans-serif;" class="header">
                    <a href="'.$psite.'" title="'.$nome_loja_completa.'" >
                        <img border="0" vspace="0" hspace="0" src="'.$psite.'/assets/img/logo/email.png" height="60" alt="'.$nome_loja_completa.'" title="'.$nome_loja_completa.'" style="color: #000000; font-size: 10px; margin: 0; padding: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: block;" required />
                    </a>
                </td>
                </tr>
                
                <!-- PARAGRAPH -->
                <!-- Set text color and font family ("sans-serif" or "Georgia, serif"). Duplicate all text styles in links, including line-height -->
                <tr>
                <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 17px; font-weight: 400; line-height: 100%;
                    padding-top: 25px; 
                    color: #000000;
                    font-family: sans-serif;" class="paragraph">
                    <span><strong>Olá '.ucwords($dados['responsavel_nome']).'!</strong></span><br><br>
                    Sua senha foi redefinida com sucesso.
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
                    <td align="left" valign="top" style="border-collapse: collapse; border-spacing: 0; padding-top: 30px; padding-right: 20px;">
                        <img border="0" vspace="0" hspace="0" style="padding: 0; margin: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: block; color: #000000;" src="'.$psite.'/assets/img/key.png" alt="H" title="E agora?" width="50" height="50"></td>

                    <!-- LIST ITEM TEXT -->
                    <!-- Set text color and font family ("sans-serif" or "Georgia, serif"). Duplicate all text styles in links, including line-height -->
                    <td align="left" valign="top" style="font-size: 17px; font-weight: 400; line-height: 100%; border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0;
                        padding-top: 25px;
                        color: #000000;
                        font-family: sans-serif;" class="paragraph">
                        <b style="color: #333333;">Informações de acesso!</b>
                    <br><br>Nosso site:<br><a href="'.$psite.'" target="_blank" style="color:#000000;font-weight:600;text-decoration:none;">'.$psite.'</a><br><br>E-mail:<br><span style="color:#000000;font-weight:600;text-decoration:none;">'.strtolower($dados['email']).'</span><br><br>Nova Senha:<br><span style="color:#000000;font-weight:600;text-decoration:none;">'.$_POST['senha'].'</span>
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
            $nome_exibe = ucfirst(trim($dados['responsavel_nome']));
            if ($pnome=='') { $pnome = $nome_loja_completa; }
            if ($pemail=='') { $pemail = $email_loja; }

            $pnome = ucfirst(trim($pnome));
            
            // $pemail = 'dev@virtuabrasil.com.br';
            // $email = 'dev@virtuabrasil.com.br';
            
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From: '.$pnome.' <'.$pemail.'>' . "\r\n";
            $headers .= 'Bcc: Virtua Brasil <contato@virtuabrasil.com.br>' . "\r\n";
            $headers .= 'Reply-To: '.$pnome.' <'.$pemail.'>' . "\r\n";
            $headers .= 'X-Mailer: PHP/' . phpversion();

            $assunto ="Oi, ".ucwords($nome_exibe)."! Senha redefinida com sucesso.";
            $email_to = $nome_exibe.'<'.$dados['email'].'>';
      
            $enviaremail = mail(iconv("UTF-8", "ISO-8859-1", $email_to), iconv("UTF-8", "ISO-8859-1", $assunto), iconv("UTF-8", "ISO-8859-1", $conteudo), iconv("UTF-8", "ISO-8859-1", $headers));

            $retorno["ok"] = 'sucesso';
            $retorno["mensagem"] = 'Senha redefinida com sucesso!';
            echo json_encode($retorno);
            exit;
        }
    }
}
?>