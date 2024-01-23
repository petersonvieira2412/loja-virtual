<?php
  include_once "config.php";
  $pagina_titulo = "pedidos";
  $pagina_referencia = "pedidos";
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

  if(isset($_POST['atualiza_status'])){
        $psite    = $url_loja;
        $pnome    = $nome_loja_completa;
        $ptelefone = "<b>".$telefone_loja1."</b>";
        $pemail = $email_loja;
    $controle = $_POST['controle'];
    $status = $_POST['status'];
    $sql = "UPDATE pedidos SET situacao='$status' WHERE identificacao_pedido='$controle'";
    $resultado = mysqli_query($conexao,$sql) or die ("Não foi possível realizar a consulta ao banco de dados");
    $sql_usuario = "SELECT * FROM pedidos WHERE identificacao_pedido='$controle' LIMIT 1";
    $query_usuario = mysqli_query($conexao, $sql_usuario);
        
    while ($dados = mysqli_fetch_assoc($query_usuario)) {
      $id = $dados['id'];
      $controle = $dados['identificacao_pedido'];
      $valor = $dados['valor_pedido'];
      $frete = $dados['valor_frete'];
      $valor_total = $valor+$frete;
      $pagamento = $dados['pagamento'];
      $nome = $dados['nome'];
      $sobrenome = $dados['sobrenome'];
      $cliente = $nome.' '.$sobrenome;
      $data = $dados['data'];
      $situacao = $dados['situacao'];
      $email_cliente = $dados['email'];
    }
      if ($status=='ag') {
      $exibir_situacao = '<span style="color:#CCC;">Aguardando pagamento</span>';
    }
    elseif ($status=='ap') {
      $exibir_situacao = '<span style="color:#2ecc71;">Pagamento aprovado</span>';
    }
    elseif ($status=='cn') {
      $exibir_situacao = '<span style="color:#e74c3c;">Pagamento cancelado</span>';
    }
    elseif ($status=='sp') {
      $exibir_situacao = '<span style="color:#ff6600;">Em separação no estoque</span>';
    }
    elseif ($status=='tr') {
      $exibir_situacao = '<span style="color:#ff6600;">Em transporte</span>';
    }
    elseif ($status=='en') {
      $exibir_situacao = '<span style="color:#2ecc71;">Entregue</span>';
    }
     $conteudo = '
     <!DOCTYPE html>
<html lang="pt-br" >
<head>
  <meta charset="UTF-8">
  <title>Atualização de pedido</title>  
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
  <!-- MESSAGE SUBJECT -->
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
  <tr>
    <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
      padding-top: 20px;
      padding-bottom: 20px;">
      <!-- PREHEADER -->
      <!-- Set text color to background color -->
      <div style="display: none; visibility: hidden; overflow: hidden; opacity: 0; font-size: 1px; line-height: 1px; height: 0; max-height: 0; max-width: 0;
      color: #F0F0F0;" class="preheader">Possuímos uma novidade para o seu pedido. Ele acaba de ser atualizado, abra este e-mail para verificar.</div>
      <!-- LOGO -->
      <a href="'.$psite.'" title="'.$nome_loja_completa.'" >
      <img border="0" vspace="0" hspace="0"
        src="'.$psite.'/img/logo.png"
        height="60"
        alt="'.$nome_loja_completa.'" title="'.$nome_loja_completa.'" style="
        color: #000000;
        font-size: 10px; margin: 0; padding: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: block;" />
        </a>
    </td>
  </tr>
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
      color: #000000;
      font-family: sans-serif;" class="header">
        Atualização do pedido # <span style="color:#ff6600">'.$controle.'</span>
    </td>
  </tr>
  
  <!-- SUBHEADER -->
  <!-- Set text color and font family ("sans-serif" or "Georgia, serif") -->
  <tr>
    <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-bottom: 3px; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 18px; font-weight: 300; line-height: 150%;
      padding-top: 5px;
      color: #000000;
      font-family: sans-serif;" class="subheader">
        Olá, '.$nome.'! Temos uma novidade para você.
    </td>
  </tr>
  
  <tr>
    <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0;
      padding-top: 20px;" class="hero"><img border="0" vspace="0" hspace="0"
      src="'.$psite.'/img/bg_pedido.jpg"
      alt="'.$nome_loja_completa.'" title="'.$nome_loja_completa.'"
      width="560" style="
      width: 100%;
      max-width: 560px;
      color: #000000; font-size: 13px; margin: 0; padding: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: block;"/></td>
  </tr>
  <!-- PARAGRAPH -->
  <!-- Set text color and font family ("sans-serif" or "Georgia, serif"). Duplicate all text styles in links, including line-height -->
  <tr>
    <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 17px; font-weight: 400; line-height: 160%;
      padding-top: 25px; 
      color: #000000;
      font-family: sans-serif;" class="paragraph">
        Possuímos uma novidade para o seu pedido. Ele acaba de ser atualizado, agora o status dele é: <b>'.$exibir_situacao.'</b>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
      padding-top: 25px;
      padding-bottom: 5px;" class="button"><a
      href="#" target="_blank" style="text-decoration: underline;">
    </td>
  </tr>
  <!-- LINE -->
  <!-- Set line color -->
  <tr>  
    <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
      padding-top: 25px;" class="line"><hr
      color="#E0E0E0" align="center" width="100%" size="1" noshade style="margin: 0; padding: 0;" />
    </td>
  </tr>
  <!-- LIST -->
  <tr>
    <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%;" class="list-item"><table align="center" border="0" cellspacing="0" cellpadding="0" style="width: inherit; margin: 0; padding: 0; border-collapse: collapse; border-spacing: 0;">
      
      <!-- LIST ITEM -->
      <tr>
        <!-- LIST ITEM IMAGE -->
        <!-- Image text color should be opposite to background color. Set your url, image src, alt and title. Alt text should fit the image size. Real image size should be x2 -->
        <td align="left" valign="top" style="border-collapse: collapse; border-spacing: 0;
          padding-top: 30px;
          padding-right: 20px;"><img
        border="0" vspace="0" hspace="0" style="padding: 0; margin: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: block;
          color: #000000;"
          src="'.$psite.'/img/interrogacao.jpg"
          alt="H" title="E agora?"
          width="50" height="50"></td>
        <!-- LIST ITEM TEXT -->
        <!-- Set text color and font family ("sans-serif" or "Georgia, serif"). Duplicate all text styles in links, including line-height -->
        <td align="left" valign="top" style="font-size: 17px; font-weight: 400; line-height: 160%; border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0;
          padding-top: 25px;
          color: #000000;
          font-family: sans-serif;" class="paragraph">
            <b style="color: #333333;">E agora, o que faço?</b><br/>
            Basta esperar que o seu pedido terá novas atualizações, os passos seguintes serão enviados neste mesmo e-mail. Caso seja necessário, um de nossos consultores entrará em contato com você.
        </td>
      </tr>
    </table></td>
  </tr>
  <!-- LINE -->
  <!-- Set line color -->
  <tr>
    <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
      padding-top: 25px;" class="line"><hr
      color="#E0E0E0" align="center" width="100%" size="1" noshade style="margin: 0; padding: 0;" />
    </td>
  </tr>
  <!-- PARAGRAPH -->
  <!-- Set text color and font family ("sans-serif" or "Georgia, serif"). Duplicate all text styles in links, including line-height -->
  <tr>
    <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 17px; font-weight: 400; line-height: 160%;
      padding-top: 20px;
      padding-bottom: 25px;
      color: #000000;
      font-family: sans-serif;" class="paragraph">
        Possui alguma dúvida? '.$email_loja.'
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
        <td align="center" valign="middle" style="margin: 0; padding: 0; padding-left: 10px; padding-right: 10px; border-collapse: collapse; border-spacing: 0;"><a target="_blank"
          href="'.$facebook.'"
        style="text-decoration: none;"><img border="0" vspace="0" hspace="0" style="padding: 0; margin: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: inline-block;
          color: #000000;"
          alt="F" title="Facebook"
          width="44" height="44"
          src="'.$psite.'/img/social/facebook.png"></a></td>
        <!-- ICON 2 -->
        <td align="center" valign="middle" style="margin: 0; padding: 0; padding-left: 10px; padding-right: 10px; border-collapse: collapse; border-spacing: 0;"><a target="_blank"
          href="'.$twitter.'"
        style="text-decoration: none;"><img border="0" vspace="0" hspace="0" style="padding: 0; margin: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: inline-block;
          color: #000000;"
          alt="T" title="Twitter"
          width="44" height="44"
          src="'.$psite.'/img/social/twitter.png"></a></td>       
        <!-- ICON 4 -->
        <td align="center" valign="middle" style="margin: 0; padding: 0; padding-left: 10px; padding-right: 10px; border-collapse: collapse; border-spacing: 0;"><a target="_blank"
          href="'.$instagram.'"
        style="text-decoration: none;"><img border="0" vspace="0" hspace="0" style="padding: 0; margin: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: inline-block;
          color: #000000;"
          alt="I" title="Instagram"
          width="44" height="44"
          src="'.$psite.'/img/social/instagram.png"></a></td>
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
        Este e-mail foi enviado para atualização de status de pedido de número #'.$controle.' <br>da '.$nome_loja_completa.'<br><br>
        <span style="color:#333; font-weight:bold;">Não responda este email, pois ele é enviado automaticamente a cada atualização de status.</span>
        
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
        $msg = utf8_decode($conteudo);
        if ($pnome=='') { $pnome = $nome_loja_completa; }
        if ($pemail=='') { $pemail = $email_loja; }
    
        $headers  = 'MIME-Version: 1.1' . " \r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . " \r\n";
        $headers .= "From: $pnome <$pemail> \r\n";
        $headers .= "Return-Path: $pnome <$pemail> \r\n";
        $headers .= "To: $nome <$email_cliente> \r\n";
        //$headers .= "Bcc: Virtua Brasil<contato@virtuabrasil.com.br> \r\n";
        $headers .= "Reply-To: $nome <$email_cliente> \r\n";
        $assunto = utf8_decode("Atualização do pedido #".$controle);
         
        mail("$pnome<$pemail>", "$assunto", $msg, $headers, "-r". $pemail);
  }
  if ($acao=="cadastrar") { ?>
    <div class="row">
      <div class="col-md-12  header-wrapper" >
        <h1 class="page-header"><?=mb_convert_case("$pagina_titulo", MB_CASE_TITLE, "UTF-8");?> Adicionar</h1>
        <p class="page-subtitle">Para cadastrar um novo item, preencha os dados abaixo.</p>
      </div>
    </div>
    <form method="post" action="" enctype="multipart/form-data">
      <div class="row">
        <div class="col-lg-12 ">
          <div class="panel panel-default ">
            <div class="panel-body">
              <div class="col-md-12" >
                <h3>Informações Descritivas</h3>
                <p>Atualize as informações descritivas deste item.</p>
              </div>
              <hr>
              <br>
              <div class="col-md-12"> </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label >FOTO</label>
                  <input class="form-control" name="destaque" id="destaque" type="file" accept="image/*">
                </div>
              </div>
			  <div class="col-md-12" ></div>
              
              <hr><br><br><br>
              <div class="col-md-12"> 
                <div class="form-group">
              	  <label >CATEGORIA </label>
                    <select class="form-control" name="categoria">
                      <?
                        $sql = "SELECT id, categoria FROM categorias WHERE status='a' ORDER BY categoria ASC";
                        $query = mysqli_query($conexao, $sql);
                                     
                        while ($dados = mysqli_fetch_assoc($query)) {
							if ($categoria==$dados['id']) { $selecao = 'selected'; } else { $selecao = ''; }
                        	echo "<option value='".$dados['id']."' $selecao>".$dados['categoria']."</option>";
                        }
	  					mysqli_free_result($query);
                      ?>
                  </select>
                </div>
              </div>
                
              <div class="col-md-12"> </div>
              
              <div class="col-md-12"> 
                <div class="form-group">
              	  <label >TÍTULO DO PRODUTO</label>
                  	<input name="produto" type="text" required="required" autofocus class="form-control" id="produto" placeholder="" maxlength="255" value="">
                </div>
              </div>
              <div class="col-md-12"> </div>
                                
              <div class="col-md-12"> 
                <div class="form-group">
              	  <label >SUB TÍTULO DO PRODUTO</label>
                  	<input name="sub_produto" type="text" class="form-control" id="sub_produto" placeholder="" maxlength="255" value="">
                </div>
              </div>
                
              <div class="col-md-12"> </div>
              <div class="col-md-12"> 
                <div class="form-group">
              	  <label >DESCRIÇÃO</label>
                  	<textarea class="form-control" rows="4" name="descricao" id="descricao"></textarea>
                </div>
              </div>
                
              <div class="col-md-12"> </div>
              <div class="col-md-4"> 
                <div class="form-group">
              	  <label >QUANTIDADE EM ESTOQUE</label>
                  	<input name="qtd" type="number" required="required" class="form-control" id="qtd" min="0" step="1" value="99999999">
                </div>
              </div>
                
              <div class="col-md-4"> 
                <div class="form-group">
              	  <label >VENDIDOS</label>
                  	<input name="qtd_vendido" type="number" class="form-control" id="qtd_vendido" min="0" step="1" value="0">
                </div>
              </div>
                
              <div class="col-md-4"> 
                <div class="form-group">
              	  <label >VISTO</label>
                  	<input name="qtd_visto" type="number" class="form-control" id="qtd_visto" min="0" step="1" value="0">
                </div>
              </div>
                
              <div class="col-md-12"> </div>
                                
              <div class="col-md-4"> 
                <div class="form-group">
              	  <label >PREÇO</label>
                  	<input name="preco" type="number" required="required" class="form-control" id="preco" min="0" step="0.01" value="0">
                </div>
              </div>
			  <div class="col-md-4"> 
                <div class="form-group">
              	  <label >POR</label>
                  	<input name="por" type="number" class="form-control" id="por" min="0" step="0.01" value="0">
                </div>
              </div>
			  <div class="col-md-4"> 
                <div class="form-group">
              	  <label >PESO</label>
                  	<input name="peso" type="number" class="form-control" id="peso" min="0" step="1" value="0">
                </div>
              </div>
                
              <div class="col-md-12"> </div>
               <div class="col-md-4"> 
                <div class="form-group">
              	  <label >PRONTA ENTREGA</label>
	                <select class="form-control" name="pronta">
                      <option value='sim' >Sim</option>
                      <option value='nao' >Não</option>
                    </select>
                </div>
              </div>
              <div class="col-md-4"> 
                <div class="form-group">
              	  <label >PROMOÇÃO</label>
	                <select class="form-control" name="promocao">
                      <option value='sim' >Sim</option>
                      <option value='nao' >Não</option>
                    </select>
                </div>
              </div>
                
              <div class="col-md-4"> 
                <div class="form-group">
              	  <label >DESTAQUE</label>
	                <select class="form-control" name="destaque">
                      <option value='sim' >Sim</option>
                      <option value='nao' >Não</option>
                    </select>
                </div>
              </div>
                
              <div class="col-md-12"> </div>
			  <div class="col-md-4"> 
                <div class="form-group">
              	  <label >TAMANHO</label>
                  	<input name="tamanho" type="text" class="form-control" id="tamanho" placeholder="Deve ser separado com vírgula" maxlength="255" value="">
                </div>
              </div>
              <div class="col-md-4"> 
                <div class="form-group">
              	  <label >COR</label>
                  	<input name="cor" type="text" class="form-control" id="cor" placeholder="Deve ser separado com vírgula" maxlength="255" value="">
                </div>
              </div>
                
              <div class="col-md-4"> 
                <div class="form-group">
              	  <label >CÓDIGO INTERNO</label>
                  	<input name="sistema" type="text" class="form-control" id="sistema" placeholder="Código de controle interno" maxlength="255" value="">
                </div>
              </div>
                
              <div class="col-md-12"> </div>
              <div class="col-md-4"> 
                <div class="form-group">
              	  <label >FORMA DE PAGAMENTO</label>
                  	<input name="forma" type="text" class="form-control" id="forma" placeholder="Formas de Pagamento" maxlength="255" value="">
                </div>
              </div>
			  <div class="col-md-4"> 
                <div class="form-group">
              	  <label >PRAZO DE ENTREGA</label>
                  	<input name="prazo" type="text" class="form-control" id="prazo" placeholder="Prazo de Entrega" maxlength="255" value="">
                </div>
              </div>
               
			  <div class="col-md-4"> 
                <div class="form-group">
              	  <label >REGIÃO ATENDIDA</label>
                  	<input name="regiao" type="text" class="form-control" id="regiao" placeholder="Região Atendida" maxlength="255" value="">
                </div>
              </div>
               
              <div class="col-md-12"> </div>
                
			  <div class="col-md-4"> 
                <div class="form-group">
              	  <label >FRETE</label>
                  	<input name="frete" type="text" class="form-control" id="frete" placeholder="" maxlength="255" value="">
                </div>
              </div>
               
			  <div class="col-md-4"> 
                <div class="form-group">
              	  <label >FATURAMENTO</label>
                  	<input name="faturamento" type="text" class="form-control" id="faturamento" placeholder="" maxlength="255" value="">
                </div>
              </div>
              <div class="col-md-4"> 
                <div class="form-group">
              	  <label >OFERTA</label>
	                <select class="form-control" name="ofertas">
                      <option value='sim' >Sim</option>
                      <option value='nao' >Não</option>
                    </select>
                </div>
              </div>
                
              <div class="col-md-4"> 
                <div class="form-group">
              	  <label >STATUS</label>
	                <select class="form-control" name="status">
                      <option value='a' >Ativo</option>
                      <option value='d' >Desativado</option>
                    </select>
                </div>
              </div>
 			  <div class="col-md-12"> </div>
 			  <div class="col-md-12"> </div>
              
              <div class="col-md-12"> 
                <div class="form-group">
              	  <label >TÍTULO DO PRODUTO (SEO)</label>
                  	<input name="titulo_seo" type="text"  autofocus class="form-control" id="produto" placeholder="" maxlength="255" value="">
                </div>
              </div>
              <div class="col-md-12"> </div>
              
              <div class="col-md-12"> 
                <div class="form-group">
              	  <label >DESCRIÇÃO DO PRODUTO (SEO)</label>
                  	<input name="desc_seo" type="text"  autofocus class="form-control" id="produto" placeholder="" maxlength="255" value="">
                </div>
              </div>
              <div class="col-md-12"> </div>
              
              <div class="col-md-12"> 
                <div class="form-group">
              	  <label >PALAVRAS CHAVES DO PRODUTO (SEO)</label>
                  	<input name="palavras_seo" type="text"  autofocus class="form-control" id="produto" placeholder="" maxlength="255" value="">
                </div>
              </div>
       <div class="col-md-12"> </div>
               
              <div class="col-md-12"> 
                <div class="form-group">
                  <label></label>
                  <input name="acao" id="acao" value="gravar" type="hidden">
                  <button type="submit" name="enviar" value="enviar" class="btn btn-success" style="float:right;"><i class="fa fa-check"></i> Cadastrar </button>
                </div>
              </div>              
              
            </div>
          </div>
        </div>
      </div>
    </form>
<? }
  if ($acao=="excluir") { 
        $data_excluir = date('Y-m-d');
        $hora_excluir = date('H:i:s');
	  	$ip = $_SERVER['REMOTE_ADDR'];
		$endereco_ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	  	$update = "UPDATE $pagina_referencia SET ip='$ip', endereco_ip='$endereco_ip', data_excluir='$data_excluir', hora_excluir='$hora_excluir', status='d' WHERE id='".$id."' "  or die(mysqli_error());
		if (!mysqli_query($conexao, $update)) {  
			die('Erro: '.mysqli_error($conexao)); 
		} else {
			echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";
		}
  }
  if ($acao=="gravar_editar") { 
		$id = (int)$_POST['id'];
		$categoria = (int)$_POST['categoria'];
		$produto = trim(addslashes(htmlspecialchars($_POST['produto'])));
		$sub_produto = trim(addslashes(htmlspecialchars($_POST['sub_produto'])));
		$descricao = trim(addslashes(htmlspecialchars($_POST['descricao'])));
		$qtd = trim(addslashes(htmlspecialchars($_POST['qtd'])));
		$qtd_vendido = trim(addslashes(htmlspecialchars($_POST['qtd_vendido'])));
		$qtd_visto = trim(addslashes(htmlspecialchars($_POST['qtd_visto'])));
		$preco = trim(addslashes(htmlspecialchars($_POST['preco'])));
		$por = trim(addslashes(htmlspecialchars($_POST['por'])));
		$forma = trim(addslashes(htmlspecialchars($_POST['forma'])));
		$prazo = trim(addslashes(htmlspecialchars($_POST['prazo'])));
		$regiao = trim(addslashes(htmlspecialchars($_POST['regiao'])));
		$promocao = trim(addslashes(htmlspecialchars($_POST['promocao'])));
		$peso = trim(addslashes(htmlspecialchars($_POST['peso'])));
		$frete = trim(addslashes(htmlspecialchars($_POST['frete'])));
		$pronta = trim(addslashes(htmlspecialchars($_POST['pronta'])));
		$faturamento = trim(addslashes(htmlspecialchars($_POST['faturamento'])));
		$destaque = trim(addslashes(htmlspecialchars($_POST['destaque'])));
		$tamanho = trim(addslashes(htmlspecialchars($_POST['tamanho'])));
		$cor = trim(addslashes(htmlspecialchars($_POST['cor'])));
		$sistema = trim(addslashes(htmlspecialchars($_POST['sistema'])));
		$ofertas = trim(addslashes(htmlspecialchars($_POST['ofertas'])));
	  	$status = strtolower(trim(addslashes(htmlspecialchars($_POST['status']))));
	  	$titulo_seo = strtolower(trim(addslashes(htmlspecialchars($_POST['titulo_seo']))));
	  	$desc_seo = strtolower(trim(addslashes(htmlspecialchars($_POST['desc_seo']))));
	  	$palavras_seo = strtolower(trim(addslashes(htmlspecialchars($_POST['palavras_seo']))));
	  
        $data_editar = date('Y-m-d');
        $hora_editar = date('H:i:s');
	  	$ip = $_SERVER['REMOTE_ADDR'];
		$endereco_ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		
	  	$update = "UPDATE $pagina_referencia SET categoria='$categoria', produto='$produto', sub_produto='$sub_produto', descricao='$descricao', qtd='$qtd', qtd_vendido='$qtd_vendido', qtd_visto='$qtd_visto', preco='$preco', por='$por', forma='$forma', prazo='$prazo', regiao='$regiao', promocao='$promocao', peso='$peso', frete='$frete', pronta='$pronta', faturamento='$faturamento', destaque='$destaque', tamanho='$tamanho', cor='$cor', sistema='$sistema', ofertas='$ofertas', ip='$ip', endereco_ip='$endereco_ip', data_editar='$data_editar', hora_editar='$hora_editar', status='$status', Titulo_seo='$titulo_seo', Descricao_seo='$desc_seo', palavrasChave_seo='$palavras_seo' WHERE id='".$id."' "  or die(mysqli_error());
	  
		if (!mysqli_query($conexao, $update)) {  
			die('Erro: '.mysqli_error($conexao)); 
		} else {
			echo "<script>alert('Atualizado com sucesso!');</script>";
			echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";
		}
  }
  if ($acao=="editar") { ?>
	<?
	$sql = "SELECT * FROM $pagina_referencia WHERE id='$id'";
	$query = mysqli_query($conexao, $sql);
	  
	$condicao = mysqli_num_rows($query);
	
	while ($dados = mysqli_fetch_assoc($query)) {
		$id = $dados['id'];
		$img = $dados['img'];
		$categoria = $dados['categoria'];
		$produto = $dados['produto'];
		$sub_produto = $dados['sub_produto'];
		$descricao = $dados['descricao'];
		$qtd = $dados['qtd'];
		$qtd_vendido = $dados['qtd_vendido'];
		$qtd_visto = $dados['qtd_visto'];
		$preco = $dados['preco'];
		$por = $dados['por'];
		$forma = $dados['forma'];
		$prazo = $dados['prazo'];
		$regiao = $dados['regiao'];
		$promocao = $dados['promocao'];
		$peso = $dados['peso'];
		$frete = $dados['frete'];
		$pronta = $dados['pronta'];
		$faturamento = $dados['faturamento'];
		$destaque = $dados['destaque'];
		$tamanho = $dados['tamanho'];
		$cor = $dados['cor'];
		$sistema = $dados['sistema'];
		$ofertas = $dados['ofertas'];
		$status = $dados['status'];
		$titulo_seo = $dados['Titulo_seo'];
		$desc_seo = $dados['Descricao_seo'];
		$palavras_seo = $dados['palavrasChave_seo'];
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
      <div class="row">
        <div class="col-lg-12 ">
          <div class="panel panel-default ">
            <div class="panel-body">
			<? if ($condicao<=0) { ?>
              <div class="col-md-12"> 
                <div class="form-group">
              	  <h3>NÃO LOCALIZAMOS ESTE REGISTRO</h3>
				  <p>Favor entrar em contato com o seu Administrador</p>
                </div>
              </div>              
            <? } else { ?>
              <div class="col-md-12" >
				  <h3>Informações Descritivas</h3>
				  <p>Atualize as informações descritivas deste item.</p>
			  </div>
			  <div class="col-md-12" ></div>
              
              <hr><br><br><br>
              <div class="col-md-12"> 
                <div class="form-group">
              	  <label >CATEGORIA </label>
                    <select class="form-control" name="categoria">
                      <?
                        $sql = "SELECT id, categoria FROM categorias WHERE status='a' ORDER BY categoria ASC";
                        $query = mysqli_query($conexao, $sql);
                                     
                        while ($dados = mysqli_fetch_assoc($query)) {
							if ($categoria==$dados['id']) { $selecao = 'selected'; } else { $selecao = ''; }
                        	echo "<option value='".$dados['id']."' $selecao>".$dados['categoria']."</option>";
                        }
	  					mysqli_free_result($query);
                      ?>
                  </select>
                </div>
              </div>
                
              <div class="col-md-12"> </div>
              
              <div class="col-md-12"> 
                <div class="form-group">
              	  <label >TÍTULO DO PRODUTO</label>
                  	<input name="produto" type="text" required="required" autofocus class="form-control" id="produto" placeholder="" maxlength="255" value="<?=$produto;?>">
                </div>
              </div>
              <div class="col-md-12"> </div>
                                
              <div class="col-md-12"> 
                <div class="form-group">
              	  <label >SUB TÍTULO DO PRODUTO</label>
                  	<input name="sub_produto" type="text" class="form-control" id="sub_produto" placeholder="" maxlength="255" value="<?=$sub_produto;?>">
                </div>
              </div>
                
              <div class="col-md-12"> </div>
              <div class="col-md-12"> 
                <div class="form-group">
              	  <label >DESCRIÇÃO</label>
                  	<textarea class="form-control" rows="4" name="descricao" id="descricao"><?=$descricao;?></textarea>
                </div>
              </div>
                
              <div class="col-md-12"> </div>
              <div class="col-md-4"> 
                <div class="form-group">
              	  <label >QUANTIDADE EM ESTOQUE</label>
                  	<input name="qtd" type="number" required="required" class="form-control" id="qtd" min="0" step="1" value="<?=$qtd;?>">
                </div>
              </div>
                
              <div class="col-md-4"> 
                <div class="form-group">
              	  <label >VENDIDOS</label>
                  	<input name="qtd_vendido" type="number" class="form-control" id="qtd_vendido" min="0" step="1" value="<?=$qtd_vendido;?>">
                </div>
              </div>
                
              <div class="col-md-4"> 
                <div class="form-group">
              	  <label >VISTO</label>
                  	<input name="qtd_visto" type="number" class="form-control" id="qtd_visto" min="0" step="1" value="<?=$qtd_visto;?>">
                </div>
              </div>
                
              <div class="col-md-12"> </div>
                                
              <div class="col-md-4"> 
                <div class="form-group">
              	  <label >PREÇO</label>
                  	<input name="preco" type="number" required="required" class="form-control" id="preco" min="0" step="0.01" value="<?=$preco;?>">
                </div>
              </div>
			  <div class="col-md-4"> 
                <div class="form-group">
              	  <label >POR</label>
                  	<input name="por" type="number" class="form-control" id="por" min="0" step="0.01" value="<?=$por;?>">
                </div>
              </div>
			  <div class="col-md-4"> 
                <div class="form-group">
              	  <label >PESO</label>
                  	<input name="peso" type="number" class="form-control" id="peso" min="0" step="1" value="<?=$peso;?>">
                </div>
              </div>
                
              <div class="col-md-12"> </div>
               <div class="col-md-4"> 
                <div class="form-group">
              	  <label >PRONTA ENTREGA</label>
	                <select class="form-control" name="pronta">
                      <option value='sim' <? if ($pronta=="sim") { echo 'selected'; } ?>>Sim</option>
                      <option value='nao' <? if ($pronta!="sim") { echo 'selected'; } ?>>Não</option>
                    </select>
                </div>
              </div>
              <div class="col-md-4"> 
                <div class="form-group">
              	  <label >PROMOÇÃO</label>
	                <select class="form-control" name="promocao">
                      <option value='sim' <? if ($promocao=="sim") { echo 'selected'; } ?>>Sim</option>
                      <option value='nao' <? if ($promocao!="sim") { echo 'selected'; } ?>>Não</option>
                    </select>
                </div>
              </div>
                
              <div class="col-md-4"> 
                <div class="form-group">
              	  <label >DESTAQUE</label>
	                <select class="form-control" name="destaque">
                      <option value='sim' <? if ($destaque=="sim") { echo 'selected'; } ?>>Sim</option>
                      <option value='nao' <? if ($destaque!="sim") { echo 'selected'; } ?>>Não</option>
                    </select>
                </div>
              </div>
                
              <div class="col-md-12"> </div>
			  <div class="col-md-4"> 
                <div class="form-group">
              	  <label >TAMANHO</label>
                  	<input name="tamanho" type="text" class="form-control" id="tamanho" placeholder="" maxlength="255" value="<?=$tamanho;?>">
                </div>
              </div>
              <div class="col-md-4"> 
                <div class="form-group">
              	  <label >COR</label>
                  	<input name="cor" type="text" class="form-control" id="cor" placeholder="" maxlength="255" value="<?=$cor;?>">
                </div>
              </div>
                
              <div class="col-md-4"> 
                <div class="form-group">
              	  <label >SISTEMA</label>
                  	<input name="sistema" type="text" class="form-control" id="sistema" placeholder="" maxlength="255" value="<?=$sistema;?>">
                </div>
              </div>
                
              <div class="col-md-12"> </div>
              <div class="col-md-4"> 
                <div class="form-group">
              	  <label >FORMA</label>
                  	<input name="forma" type="text" class="form-control" id="forma" placeholder="" maxlength="255" value="<?=$forma;?>">
                </div>
              </div>
			  <div class="col-md-4"> 
                <div class="form-group">
              	  <label >PRAZO</label>
                  	<input name="prazo" type="text" class="form-control" id="prazo" placeholder="" maxlength="255" value="<?=$prazo;?>">
                </div>
              </div>
               
			  <div class="col-md-4"> 
                <div class="form-group">
              	  <label >REGIÃO</label>
                  	<input name="regiao" type="text" class="form-control" id="regiao" placeholder="" maxlength="255" value="<?=$regiao;?>">
                </div>
              </div>
               
              <div class="col-md-12"> </div>
                
			  <div class="col-md-4"> 
                <div class="form-group">
              	  <label >FRETE</label>
                  	<input name="frete" type="text" class="form-control" id="frete" placeholder="" maxlength="255" value="<?=$frete;?>">
                </div>
              </div>
               
			  <div class="col-md-4"> 
                <div class="form-group">
              	  <label >FATURAMENTO</label>
                  	<input name="faturamento" type="text" class="form-control" id="faturamento" placeholder="" maxlength="255" value="<?=$faturamento;?>">
                </div>
              </div>
              <div class="col-md-4"> 
                <div class="form-group">
              	  <label >OFERTA</label>
	                <select class="form-control" name="ofertas">
                      <option value='sim' <? if ($ofertas=="sim") { echo 'selected'; } ?>>Sim</option>
                      <option value='nao' <? if ($ofertas!="sim") { echo 'selected'; } ?>>Não</option>
                    </select>
                </div>
              </div>
                
              <div class="col-md-4"> 
                <div class="form-group">
              	  <label >STATUS</label>
	                <select class="form-control" name="status">
                      <option value='a' <? if ($status=="a") { echo 'selected'; } ?>>Ativo</option>
                      <option value='d' <? if ($status!="a") { echo 'selected'; } ?>>Desativado</option>
                    </select>
                </div>
              </div>
              <div class="col-md-12"> </div>
              
              <div class="col-md-12"> 
                <div class="form-group">
              	  <label >TÍTULO DO PRODUTO (SEO)</label>
                  	<input name="titulo_seo" type="text" autofocus class="form-control" id="produto" placeholder="" maxlength="255" value="<?=$titulo_seo;?>">
                </div>
              </div>
              <div class="col-md-12"> </div>
              
              <div class="col-md-12"> 
                <div class="form-group">
              	  <label >DESCRIÇÃO DO PRODUTO (SEO)</label>
                  	<input name="desc_seo" type="text"  autofocus class="form-control" id="produto" placeholder="" maxlength="255" value="<?=$desc_seo;?>">
                </div>
              </div>
              <div class="col-md-12"> </div>
              
              <div class="col-md-12"> 
                <div class="form-group">
              	  <label >PALAVRAS CHAVES DO PRODUTO (SEO)</label>
                  	<input name="palavras_seo" type="text"  autofocus class="form-control" id="produto" placeholder="" maxlength="255" value="<?=$palavras_seo;?>">
                </div>
              </div>
                
              <div class="col-md-12"> </div>
               
              <div class="col-md-12"> 
                <div class="form-group">
                  <label></label>
                  <input name="acao" id="acao" value="gravar_editar" type="hidden">
                  <input name="id" id="id" value="<?=$id;?>" type="hidden">
                  <button type="submit" name="enviar" value="enviar" class="btn btn-success" style="float:right;"><i class="fa fa-check"></i> Atualizar </button>
                </div>
              </div>
			<? } ?>              
            </div>
          </div>
        </div>
      </div>
	</form>
<? }
  if ($acao=="gravar_migrar") { 
		$atual = (int)$_POST['atual'];
		$destino = (int)$_POST['destino'];
	  	$update = "UPDATE produtos SET categoria='$destino' WHERE categoria='$atual' "  or die(mysqli_error());
		if (!mysqli_query($conexao, $update)) {  
			die('Erro: '.mysqli_error($conexao)); 
		} 
	  
	  	$update = "UPDATE $pagina_referencia SET categoria_pai='$destino' WHERE categoria_pai='$atual' "  or die(mysqli_error());
		if (!mysqli_query($conexao, $update)) {  
			die('Erro: '.mysqli_error($conexao)); 
		} 
	  
		echo "<script>alert('$pagina_titulo migradas com sucesso!');</script>";
		echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia-migrar'>";
		
  }
  if ($acao=="gravar_imagem") { 
	$produto = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['produto'], MB_CASE_LOWER, "UTF-8"))));
	$nome = UrlAmigavel($produto);
	  
	if ($nome=="") { $nome="moveis-para-escritorio"; }
	$aleatorio = rand(1,999999);
	if (file_exists($_FILES['destaque']['tmp_name']) || is_uploaded_file($_FILES['destaque']['tmp_name'])) {
		$nome_final = "produto-".$id."-".$nome."-".$aleatorio;
		$set_img_path = "../assets/img/".$pagina_referencia;
		$imgarray = array("image/pjpeg", "image/jpeg", "image/gif", "image/png", "image/x-png");
		if (!$_FILES['destaque']['size'])
		{
			echo "<p>Arquivo recusado devido ao tamanho do mesmo.</p>";
			exit;
		}		
		if (!in_array($_FILES['destaque']['type'],$imgarray))
		{
			echo "<p>É somente aceito arquivos de imagens (GIF, JPG e PNG).</p>";
			exit;
		}		
		if ($_FILES['destaque']['size']>$set_max_bytes_allowed)
		{
			echo "<p>Tamanho do Arquivo é maior que o limite de:</p>". $set_max_bytes_allowed / 1000 ."Kb.";
			exit;
		}		
		if ($_FILES['destaque']['type']=="image/gif")
		{
				$ext = ".gif";
		}
		elseif ($_FILES['destaque']['type']=="image/jpeg" || $_FILES['destaque']['type']=="image/pjpeg")
		{
				$ext = ".jpg";
		}
		elseif ($_FILES['destaque']['type']=="image/png")
		{
				$ext = ".png";
		}
		$img = $nome_final.$ext;
		move_uploaded_file($_FILES['destaque']['tmp_name'], "$set_img_path/$img");
		chmod ("$set_img_path/$img", 0755);
		$data_editar = date('Y-m-d');
        $hora_editar = date('H:i:s');
	  	$ip = $_SERVER['REMOTE_ADDR'];
		$endereco_ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		
		$update = "UPDATE $pagina_referencia SET img='".$img."', ip='$ip', endereco_ip='$endereco_ip', data_editar='$data_editar', hora_editar='$hora_editar' WHERE id='".$id."' "  or die(mysqli_error());
		if (!mysqli_query($conexao, $update)) { die('Erro: '.mysqli_error($conexao)); }
	}
	if (file_exists($_FILES['topo']['tmp_name']) || is_uploaded_file($_FILES['topo']['tmp_name'])) {
		$nome_final = $id."-".$nome."-".$aleatorio;
		$set_img_path = "../assets/img/".$pagina_referencia."/".$id;
		$imgarray = array("image/pjpeg", "image/jpeg", "image/gif", "image/png", "image/x-png");
		if (!$_FILES['topo']['size'])
		{
			echo "<p>Arquivo recusado devido ao tamanho do mesmo.</p>";
			exit;
		}		
		if (!in_array($_FILES['topo']['type'],$imgarray))
		{
			echo "<p>É somente aceito arquivos de imagens (GIF, JPG e PNG).</p>";
			exit;
		}		
		if ($_FILES['topo']['size']>$set_max_bytes_allowed)
		{
			echo "<p>Tamanho do Arquivo é maior que o limite de:</p>". $set_max_bytes_allowed / 1000 ."Kb.";
			exit;
		}		
		if ($_FILES['topo']['type']=="image/gif")
		{
				$ext = ".gif";
		}
		elseif ($_FILES['topo']['type']=="image/jpeg" || $_FILES['topo']['type']=="image/pjpeg")
		{
				$ext = ".jpg";
		}
		elseif ($_FILES['topo']['type']=="image/png")
		{
				$ext = ".png";
		}
		$img = $nome_final.$ext;
		if (is_dir("$set_img_path")) { } else {
			mkdir("$set_img_path", 0755);
		}
		move_uploaded_file($_FILES['topo']['tmp_name'], "$set_img_path/$img");
		chmod ("$set_img_path/$img", 0755);
	}
	echo "<script>alert('Imagem atualizada com sucesso!');</script>";
	//echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia"."-imagem_"."$id'>";
	}
		
  if ($acao=="imagem") { 
	$sql = "SELECT * FROM $pagina_referencia WHERE id='$id'";
	$query = mysqli_query($conexao, $sql);
	  
	$condicao = mysqli_num_rows($query);
	
	while ($dados = mysqli_fetch_assoc($query)) {
		$id = $dados['id'];
		$img = $dados['img'];
		$produto = $dados['produto'];
		if(file_exists("../assets/img/$pagina_referencia/$img")){ } else{ $img = "sem_imagem.jpg"; }
		
	}
	mysqli_free_result($query);
	?>
   
    <div class="row">
      <div class="col-md-12  header-wrapper" >
        <h1 class="page-header"><?=mb_convert_case("$pagina_titulo", MB_CASE_TITLE, "UTF-8");?> Alteração de Imagem</h1>
        <p class="page-subtitle">Para alterar as imagens da categoria basta selecionar as novas imagens</p>
      </div>
    </div>
    <form method="post" action="" enctype="multipart/form-data">
      <div class="row">
        <div class="col-lg-12 ">
          <div class="panel panel-default ">
            <div class="panel-body">
			<? if ($condicao<=0) { ?>
              <div class="col-md-12"> 
                <div class="form-group">
              	  <h3>NÃO LOCALIZAMOS ESTE REGISTRO</h3>
				  <p>Favor entrar em contato com o seu Administrador</p>
                </div>
              </div>              
            <? } else { ?>             
              <div class="col-md-12" >
                <h3>Publicação de Novas Imagens</h3>
                <p>Selecione apenas as imagens que deseja alterar.</p>
              </div>
              <hr>
              <br>
              <br>
              <div class="col-md-12"> </div>
				<p>&nbsp;</p>
              <div class="col-md-12"> </div>
              <div class="col-md-1">
                <div class="form-group">
                  <img src="../assets/img/<?=$pagina_referencia;?>/<?=$img;?>" style="max-width: 100%; max-height: 100px;" >
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label >FOTO DESTAQUE</label>
                  <input class="form-control" name="destaque" id="destaque" type="file" accept="image/*">
                </div>
              </div>
              
              <div class="col-md-1">
                <div class="form-group">
                </div>
              </div>
              
              
              <div class="col-md-4">
                <div class="form-group">
                  <label >FOTO INTERNA</label>
                  <input class="form-control" name="topo" id="topo" type="file" accept="image/*">
                </div>
              </div>
              <br>
              <br>
              <div class="col-md-12"> </div>
				<p>&nbsp;</p>
				<p>&nbsp;</p>
				<p>&nbsp;</p>
              <div class="col-md-12"> </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label></label>
                  <input name="acao" id="acao" value="gravar_imagem" type="hidden">
                  <input name="id" id="id" value="<?=$id;?>" type="hidden">
                  <input name="produto" id="categoria" value="<?=$produto;?>" type="hidden">
                  <button type="submit" name="enviar" value="enviar" class="btn btn-success" style="float:right;"><i class="fa fa-check"></i> Atualizar Imagem </button>
                </div>
              </div>
              
              <div class="col-md-12"> </div>
				<p>&nbsp;</p>
				<p>&nbsp;</p>
				<p>&nbsp;</p>
<?
if(is_dir("../img/produtos/$id/"))
	if ($handle = opendir("../img/produtos/$id/")) {
		while (false !== ($file = readdir($handle))) {
			if($file == "." || $file == ".." || $file == "index.htm" || $file == "index.html" ){ } else{
	?>
              <div class="col-md-12">
                <div class="form-group">
                  <label></label>
		<?php
			echo "<center><a href='inicial.php?pag=".$nome_pag."_imagem_excluir&id=$id&arquivo=produtos/$id/$file'>";
			echo "<div align='center' style='height:150px'><img src='../img/produtos/$id/$file' style='max-width:220px; max-height:150px;' /></div>";
			echo "<strong>EXCLUIR</strong></a></center>";
		?>
                </div>
              </div>
	<?
			}		
		}
		closedir($handle);
	}
}
?>
            </div>
          </div>
        </div>
      </div>
    </form>
<? }
if ($acao=="") { ?>
  <div class="row">
    <div class="col-md-12  header-wrapper" >
        <h1 class="page-header"><?=mb_convert_case("$pagina_titulo", MB_CASE_TITLE, "UTF-8");?></h1>
        <p class="page-subtitle">Listagens dos pedidos no sistema.</p>
    </div>
  </div>
    <div class="row">
      <div class="col-md-12">
        <table class="table table-bordered table-hover" id="dataTables-userlist">
         <thead>
            <tr>
              <th>Número pedido</th>
              <th>Valor pedido</th>
              <th>Cliente</th>
              <th>E-mail</th>
              <th>Data</th>
              <th>Hora</th>
              <th>Status</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
          <?
          $result = ("SELECT identificacao_pedido,id, data, valor_pedido, sessao_id, valor_frete, situacao, nome, sobrenome, pagamento, email, hora FROM pedidos WHERE identificacao_pedido != '' ORDER BY id DESC ");
          $execute = mysqli_query($conexao, $result);
          if(mysqli_num_rows ($execute) > 0 )
          {
              while ($dados_cliente = mysqli_fetch_assoc($execute)){
              $id = $dados_cliente['id'];
              $data = $dados_cliente['data'];
              $sessao_id = $dados_cliente['sessao_id'];
              $hora = $dados_cliente['hora'];
              $controle = $dados_cliente['identificacao_pedido'];
              $valor_pedido = $dados_cliente['valor_pedido'];
              $valor_frete = $dados_cliente['valor_frete'];
              $situacao = $dados_cliente['situacao'];
              $nome = $dados_cliente['nome'];
              $sobrenome = $dados_cliente['sobrenome'];
              $pagamento = $dados_cliente['pagamento'];
              $email = $dados_cliente['email'];
              $valor_total = $valor_pedido+$valor_frete;
              $cliente = $nome.' '.$sobrenome;
            
              if ($situacao=='ag') {
                $exibir_situacao = 'Aguardando Pagamento';
                $exibir_situacao_tabela = '<td class="center">Aguardando Pagamento</td>';
              }
              elseif ($situacao=='ap') {
                $exibir_situacao = 'Pagamento Aprovado';
                $exibir_situacao_tabela = '<td class="center">Pagamento Aprovado</td>';
              }
              elseif ($situacao=='cn') {
                $exibir_situacao = 'Pagamento Cancelado';
                $exibir_situacao_tabela = '<td class="center">Pagamento Cancelado</td>';
              }
              elseif ($situacao=='sp') {
                $exibir_situacao = 'Em separação no estoque';
                $exibir_situacao_tabela = '<td class="center">Em separação no estoque</td>';
              }
              elseif ($situacao=='tr') {
                $exibir_situacao = 'Em transporte';
                $exibir_situacao_tabela = '<td class="center">Em transporte</td>';
              }
              elseif ($situacao=='en') {
                $exibir_situacao = 'Entregue';
                $exibir_situacao_tabela = '<td class="center">Entregue</td>';
              }
  
              if (!isset($valor_frete) || $valor_frete=='0.00'){
                $exibir_situacao = 'Módulo Catálogo';
                $exibir_situacao_tabela = '<td class="center" style="color: red;">Módulo Catálogo</td>';
              }

            //$id = "2020031117";
            
        ?>
            <tr>
              <td class="center"><?=$controle;?></td>
              <td class="center">R$ <?=number_format($valor_total,2,',','.');?></td>
              <td class="center"><?=$cliente;?></td>
              <td class="center"><?=$email;?></td>
              <td class="center"><?=$data;?></td>
              <td class="center"><?=$hora;?></td>
              <?=$exibir_situacao_tabela;?>
              <td >
              <div class="socials tex-center"> 
                <a href="#" class="btn btn-circle btn-primary " data-toggle="modal" data-target="#myModal<?=$id;?>" title="Alterar Status"><i class="fa fa-pencil"></i></a>
              </div> 
              <div class="modal fade" id="myModal<?=$id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel3">DETALHES DO PEDIDO <strong>#<?=$controle;?></strong> [<?=$exibir_situacao;?>]</h4>
                    </div>
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">Imagem do produto</th>
                          <th scope="col">SKU</th>
                          <th scope="col">Nome do Produto</th>
                          <th scope="col">QTD</th>
                          <th scope="col">R$</th>
                        </tr>
                      </thead>
                      <?
                         
                          $result_detalhes = "SELECT * FROM pedidos WHERE identificacao_pedido='$controle' ORDER BY id DESC";
                          $execute_detalhes = mysqli_query($conexao, $result_detalhes);
                          if(mysqli_num_rows ($execute) > 0 )
                          {
                              while ($dados_detalhes = mysqli_fetch_assoc($execute_detalhes)){
                              $data = $dados_detalhes['data'];
                              $valor_total = $dados_detalhes['valor_pedido'];
                              $endereco = $dados_detalhes['endereco'];
                              $numero = $dados_detalhes['numero'];
                              $bairro = $dados_detalhes['bairro'];
                              $cep = $dados_detalhes['cep'];
                              $cidade = $dados_detalhes['cidade'];
                              $estado = mb_convert_case($dados_detalhes['estado'], MB_CASE_UPPER, "UTF-8");
                              $email = $dados_detalhes['email'];
                              $nome = $dados_detalhes['nome'];
                              $sobrenome = $dados_detalhes['sobrenome'];
                              $valor_frete = $dados_detalhes['valor_frete'];
                              $ddd_celular = $dados_detalhes['celular_ddd'];
                              $celular = $dados_detalhes['celular'];
                              $ddd_telefone = $dados_detalhes['telefone_ddd'];
                              $telefone = $dados_detalhes['telefone'];
                              
                             $result_detalhes2 = "SELECT id_produto, sku, produto, qtd, preco, img, tamanho, cor FROM produtos_comprado WHERE id_pedido='$id' ORDER BY id DESC";
                             $execute_detalhes2 = mysqli_query($conexao, $result_detalhes2);
                          ?>
                          
                              <tbody>

                              <?
                              while ($dados_detalhes2 = mysqli_fetch_assoc($execute_detalhes2)){
                                $id_produto = $dados_detalhes2['id_produto'];
                                $sku = $dados_detalhes2['sku'];
                                $produto = $dados_detalhes2['produto'];
                                $qtd = $dados_detalhes2['qtd'];
                                $preco = $dados_detalhes2['preco'];
                                $img = $dados_detalhes2['img'];
                                $tamanho = $dados_detalhes2['tamanho'];
                                $cor = $dados_detalhes2['cor'];

                                if (!isset($sku) || $sku=='0' || $sku==''){
                                  $sku = $id_produto;
                                }
                             ?>
                                <tr>
                                    <td><center><img src="<?=$img;?>" title="<?=$produto;?>"></center></td>
                                    <td><?=$sku;?></td>                                                      
                                    <td>
                                        <?=$produto;?>
                                        <?if ((isset($tamanho) AND $tamanho!='') OR (isset($cor) AND $cor!='')){?>
                                            <p class="mb-0">
                                                <?if (isset($tamanho) AND $tamanho!=''){?>
                                                    <?=$tamanho;?> 
                                                <?}?>
                                                <?if (isset($tamanho) AND $tamanho!=''AND isset($cor) AND $cor!=''){?>
                                                    /
                                                <?}?>
                                                <?if (isset($cor) AND $cor!=''){?>
                                                    <?=$cor;?>
                                                <?}?>
                                            </p>
                                        <?}?>
                                    </td>
                                    <td><?=$qtd;?></td>
                                    <td><?=number_format($preco,2,',','.');?></td>
                                </tr>
                              <?}?>
                              </tbody>
                            
                  
                    <?}}?>
                    </table>
                    <div class="row">
                      <div class="col-sm-4"></div>
                      <div class="col-sm-4"></div>
                      <div class="col-sm-4"><p align="right" style="margin-right: 28px;"><strong>Total do pedido: <span style='font-size: 16px;'>R$ <?=number_format($valor_total,2,',','.');?></span></strong></p></div>
                    </div>
                    <div class="row">
                      <div class="col-sm-1" ><p style='margin-left: 28px; margin-top: 1em;'><strong>Endereço:</strong></p></div>
                      <div class="col-sm-10">
                      <p style='margin-left: 12px; margin-top: 1em;'><?=$endereco;?>, <?=$numero;?>, <?=$bairro;?>, <?=$cep;?> - <?=$cidade;?>/<?=$estado;?></p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-1" ><p style='margin-left: 28px; margin-top: 1em;'><strong>Responsável:</strong></p></div>
                      <div class="col-sm-10">
                      <p style='margin-left: 35px; margin-top: 1em;'><?=$nome;?> <?=$sobrenome;?> -  <?=$celular;?> | <?=$telefone;?> | <?=$email;?></p>
                      </div>
                    </div>
                    <div class="cls" style="width: 100%; height: 2em;"></div>
                    <form name="atualiza pedido" action="" method="POST">
                      <div class="row">
                        <div class="col-sm-4" ><p style='margin-left: 28px; margin-top: 1em;'>Atualize o status do pedido <strong>#<?=$controle;?></strong></p></div>
                        <div class="col-sm-4">
                          <select name="status" class="form-control" style="width: 410px;">
                            <option selected disabled>Selecione uma opção</option>
                            <option value="ap">Pagamento Aprovado</option>
                            <option value="cn">Pagamento Cancelado</option>
                            <option value="sp">Em separação no estoque</option>
                            <option value="tr">Em transporte</option>
                            <option value="en">Entregue</option>
                          </select>
                        </div>
                        <div class="col-sm-4" >
                          <input type="hidden" name="controle" value="<?=$controle;?>">
                          <button type="submit" class="btn btn-primary" name="atualiza_status" style="float: right; margin-right: 28px;">ATUALIZAR</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            <div class="cls" style="width: 100%; height: 3em;"></div>
          
            
<?
  }
}
  mysqli_free_result($execute);
  ?>   
         
          </tbody>
        </table>
      </div>
    </div>
    <!-- /.row --> 
<? } ?>
<!-- Include external JS libs. -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/mode/xml/xml.min.js"></script>
 
    <!-- Include Editor JS files. -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.8.4/js/froala_editor.pkgd.min.js"></script>
<!-- /#wrapper -->
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
