<?
require_once "includes/config.php";
$vb_catalogo = 'sim';

if (!isset($_SESSION["usr_id_cliente"]) OR $_SESSION["usr_id_cliente"]=='' OR $_SESSION["usr_id_cliente"]==0){
    echo "<meta http-equiv='refresh' content='0;URL=home'>";
    exit();
}

    $result = "SELECT * FROM clientes WHERE id='".$_SESSION["usr_id_cliente"]."' AND status='a' LIMIT 1";
    $execute = mysqli_query($conn, $result);
    if(mysqli_num_rows($execute)>0){
        $dados_cliente = mysqli_fetch_assoc($execute);
        $nome = $dados_cliente['responsavel_nome'];
        $sobrenome = $dados_cliente['sobrenome'];
        $nome_completo = $nome.' '.$sobrenome;
        $endereco = $dados_cliente['endereco'];
        $numero = $dados_cliente['numero'];
        $bairro = $dados_cliente['bairro'];
        $cidade = $dados_cliente['cidade'];
        $estado = $dados_cliente['estado'];
        $email = $dados_cliente['email'];
        $cpf_cliente = $dados_cliente['cpf_cnpj'];
        $id_cliente = $dados_cliente['id'];
        $cep = $dados_cliente['cep'];
        $celular = $dados_cliente['celular'];
        $complemento = $dados_cliente['complemento'];
        $pto_referencia = $dados_cliente['pto_referencia'];
    }
    
    $sql_meu_carrinho = "SELECT * FROM carrinho WHERE sessao='".session_id()."' AND id_cliente = '".$_SESSION['usr_id_cliente']."' ORDER BY nome ASC";
    $exec_meu_carrinho =  mysqli_query($conn, $sql_meu_carrinho);
    $qtd_meu_carrinho = mysqli_num_rows($exec_meu_carrinho);

    if ($qtd_meu_carrinho<1){
        echo "<meta http-equiv='refresh' content='0;URL=home'>";
        exit();
    }

    $soma_carrinho = 0;
    while ($row_rs_produto_carrinho = mysqli_fetch_assoc($exec_meu_carrinho)){
    
        $url = clean($row_rs_produto_carrinho['nome']);
    
        if ($row_rs_produto_carrinho['preco']=='' || $row_rs_produto_carrinho['preco']<1){$produto_vazio='sim';}
    
        $soma_produto_individual = ($row_rs_produto_carrinho['preco']*$row_rs_produto_carrinho['qtd']);
        $soma_carrinho = $soma_carrinho + $soma_produto_individual;
        if ($soma_carrinho=='0') {
            $_SESSION['total_parcial'] = '<strong>CONSULTE-NOS</strong>';
            $exibe_parcela ='';
        }else{
            if (!isset($_SESSION['cupom_de_desconto']) || $_SESSION['cupom_de_desconto']=='') {
                $_SESSION['total_parcial'] = 'R$ <strong>'.number_format($soma_carrinho,2,',','.').'</strong>';
            }
        }
        
        $produto = $row_rs_produto_carrinho["nome"];
        $qtd = $row_rs_produto_carrinho["qtd"];
        $id_produto = $row_rs_produto_carrinho['cod'];
        $imagem_produto = $row_rs_produto_carrinho['logo'];
        $valor_produto = $row_rs_produto_carrinho['preco'];
        $sku = $row_rs_produto_carrinho['sku'];
        $sistema = $row_rs_produto_carrinho['sistema'];
        $preco_carrinho = $row_rs_produto_carrinho['preco'];

        if (!isset($sku) && $sku==''){
            $sku = $sistema;
            if (!isset($sistema) && $sistema==''){
              $sku = $id_produto;
            }
        }
    }

    if (!isset($_SESSION['cupom_de_desconto']) || $_SESSION['cupom_de_desconto']=='') {
        $cupom_finalizar ='';
    }else{
        $cupom_finalizar = 'Cupom aplicado: '.$_SESSION['cupom_de_desconto'];
    }

    $numero_g = date('Y');
    $mes = date('m');
    $gera = rand(1,999999);
    $controle = $numero_g.$mes.$gera;
    $identificacao_pedido = '';
    $valor_pedido = $soma_carrinho;
    if ($valor_pedido=='0.00') {
        $exibe_pedido='Consulte-nos';
    }else{
        $exibe_pedido = 'R$ '.number_format($valor_pedido,2,',','.');
    }

    if (!isset($_POST['frete']) OR $_POST['frete']==''){$_POST['frete'] = 0;}
    $valor_frete = $_POST['frete'];
    $total = $valor_frete + $soma_carrinho;
    
    if ($valor_frete>0){
        $valor_frete = 'R$ '.number_format($valor_frete,2,',','.');
    }else{
        $valor_frete = '<strong>À CALCULAR</strong>';
    }
    
    if ($total<1 OR $valor_frete=='<strong>À CALCULAR</strong>'){
        $total = '<strong>À CALCULAR</strong>';
    }else{
        $total = 'R$ '.number_format($total,2,',','.').'';
    }

    if (!isset($_POST['freteID']) OR $_POST['freteID']==''){$_POST['freteID'] = '';}
    if (!isset($_POST['freteAID']) OR $_POST['freteAID']==''){$_POST['freteAID'] = '';}
    if (!isset($_POST['freteE']) OR $_POST['freteE']==''){$_POST['freteE'] = '';}
    if (!isset($_POST['freteP']) OR $_POST['freteP']==''){$_POST['freteP'] = '';}
    $frete_id = $_POST['freteID'];
    $agencia_id = $_POST['freteAID'];
    $empresa = $_POST['freteE'];
    $prazo = $_POST['freteP'];

    if (!isset($total) || $total==''){
        $total = $_SESSION['total_parcial'];
    }

    if (isset($produto_vazio) AND $produto_vazio=='sim'){
        $total = '<strong>À CALCULAR</strong>';
    }

    $carrinho_sessao_id = session_id();
    $ip       = $_SERVER['REMOTE_ADDR'];                                //Grava o IP do usuário
    $endereco_ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);                  //Grava o endereço real do IP
    $datas    = date('D');
    $mes      = date('M');
    $dia      = date('d');
    $ano      = date('Y');
    $semana   = array("Sun" => "Domingo", "Mon" => "Segunda-Feira", "Tue" => "Terca-Feira", "Wed" => "Quarta-Feira", "Thu" => "Quinta-Feira", "Fri" => "Sexta", "Sat" => "Sábado");
    $mess = array("Jan" => "Janeiro", "Feb" => "Fevereiro", "Mar" => "Marco", "Apr" => "Abril", "May" => "Maio", "Jun" => "Junho", "Jul" => "Julho", "Aug" => "Agosto", "Sep" => "Setembro", "Oct" => "Outubro", "Nov" => "Novembro", "Dec" => "Dezembro");
    $data     = $semana["$datas"].", $dia de ".$mess["$mes"]." de $ano";
    $tdia = date('d');
    $tmes = date('m');
    $tano = date('Y');
    $tdata = $tano.$tmes.$tdia;
    $data_a = date('Y-m-d');
    $hora     = date("H:i:s");
    $carrinho_sessao_id = session_id();
        
    $cep_novo = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['cep'], MB_CASE_TITLE, "UTF-8"))));
    $cep_informa = $cep_novo;
    $endereco_informa = ucfirst(trim(addslashes(htmlspecialchars(mb_convert_case($_POST['logradouro'], MB_CASE_TITLE, "UTF-8")))));
    $bairro_informa = ucfirst(trim(addslashes(htmlspecialchars(mb_convert_case($_POST['bairro'], MB_CASE_TITLE, "UTF-8")))));
    $cidade_informa = ucfirst(trim(addslashes(htmlspecialchars(mb_convert_case($_POST['cidade'], MB_CASE_TITLE, "UTF-8")))));
    $estado_informa = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['estado'], MB_CASE_TITLE, "UTF-8"))));
    $numero_informa = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['numero'], MB_CASE_TITLE, "UTF-8"))));
    $complemento_informa = ucfirst(trim(addslashes(htmlspecialchars(mb_convert_case($_POST['complemento'], MB_CASE_TITLE, "UTF-8")))));

    if (!isset($cep_informa)){$cep_informa = '';} 
    if (!isset($endereco_informa)){$endereco_informa = '';} 
    if (!isset($bairro_informa)){$bairro_informa = '';} 
    if (!isset($cidade_informa)){$cidade_informa = '';} 
    if (!isset($estado_informa)){$estado_informa = '';} 
    if (!isset($numero_informa)){$numero_informa = '';} 
    if (!isset($complemento_informa)){$complemento_informa = '';} 

    if (!isset($frete_id)){$frete_id = '';} 
    if (!isset($agencia_id)){$agencia_id = '';} 
    if (!isset($prazo)){$prazo = '';} 
    if (!isset($empresa)){$empresa = '';} 

    if (!isset($_POST['selEnderecoN'])){$_POST['selEnderecoN'] = '';} 
    if (!isset($_SESSION['cupom_de_desconto'])){$_SESSION['cupom_de_desconto'] = '';} 
            
    $ident = $_POST['selEnderecoN'];
    if(isset($ident) AND $ident!=''){
        $idEn = mysqli_query($conn,"SELECT id FROM enderecos_entrega WHERE id='".$ident."' AND id_cliente='".$_SESSION["usr_id_cliente"]."' LIMIT 1");
        if(mysqli_num_rows($idEn)>0){
            mysqli_query($conn,"UPDATE enderecos_entrega SET cep='".$cep_informa."',endereco='".$endereco_informa."',numero='".$numero_informa."',bairro='".$bairro_informa."',cidade='".$cidade_informa."',estado='".$estado_informa."',complemento='".$complemento_informa."' WHERE id='".$ident."'"); 
        }else{
            mysqli_query($conn,"INSERT INTO enderecos_entrega (id_cliente,apelido,cep,endereco,numero,bairro,cidade,estado,complemento,pto_referencia) VALUES('".$_SESSION["usr_id_cliente"]."','".$_POST['nomeend']."','".$cep_informa."','".$endereco_informa."','".$numero_informa."','".$bairro_informa."','".$cidade_informa."','".$estado_informa."','".$complemento_informa."')");
        }
    }else{
        mysqli_query($conn,"UPDATE clientes SET cep='".$cep_informa."',endereco='".$endereco_informa."',numero='".$numero_informa."',bairro='".$bairro_informa."',cidade='".$cidade_informa."',estado='".$estado_informa."',complemento='".$complemento_informa."' WHERE id='".$_SESSION["usr_id_cliente"]."' AND status='a'");
    }
    if (!isset($_POST['selFormaPagto'])){$_POST['selFormaPagto'] = '';}
    if (!isset($sku)){$sku = '';}
    
    $transaction_id = ((isset($_POST['transaction_id']) AND $_POST['transaction_id']!='')?$_POST['transaction_id']:'');

    $email_cliente = $email;
    $sql = "INSERT INTO pedidos (forma_pagamento,sessao_id, identificacao_pedido, id_cliente, valor_pedido, cupom_aplicado, valor_frete, frete_id, frete_agencia_id, frete_prazo, frete_empresa, pagamento, cpf, nome, sobrenome, cep, endereco, numero, complemento, bairro, cidade, estado, email, celular, ip, endereco_ip, datas, data, hora, situacao, status, sistema, transaction_id) 
    VALUES ('".$_POST['selFormaPagto']."','".$carrinho_sessao_id."','".$identificacao_pedido."','".$_SESSION["usr_id_cliente"]."','".$soma_carrinho."','".$_SESSION['cupom_de_desconto']."','".$_POST['frete']."','".$frete_id."','".$agencia_id."','".$prazo."','".$empresa."','a definir','".$cpf_cliente."', '".$nome."', '".$sobrenome."','".$cep_informa."', '".$endereco_informa."', '".$numero_informa."', '".$complemento_informa."', '".$bairro_informa."', '".$cidade_informa."', '".$estado_informa."','".$email."','".$celular."','".$ip."','".$endereco_ip."','".$data_a."','".$data."','".$hora."','ag', 'a', '".$sistema."', '".$transaction_id."')";
    $execute = mysqli_query($conn,$sql);

    if ($execute==true) {
        
        $idpedido = mysqli_insert_id($conn);
        $cpedido = date('Ymd').rand(1,99999);        
        $_SESSION['pedido'] = $cpedido;
        
        $tipook = 'Orçamento N° '.$cpedido;
        $tipook2 = 'ORÇAMENTO';
        $tipook3 = 'Orçamento Online';
        
        mysqli_query($conn,"UPDATE pedidos SET identificacao_pedido='".$cpedido."', tipo_operacao='".$tipook3."' WHERE id='".$idpedido."'");

        $psite  = $url_loja;
        $pemail = $email_loja;
        $conteudo = '
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
         <head>
          <meta charset="UTF-8">
          <meta content="width=device-width, initial-scale=1" name="viewport">
          <meta name="x-apple-disable-message-reformatting">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta content="telephone=no" name="format-detection">
          <title>Nova mensagem</title>
         </head>
         <body style="width:100%;font-family:arial, helvetica neue, helvetica, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0">
          <div class="es-wrapper-color" style="background-color:#FFFFFF">
           <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;background-color:#FFFFFF">
             <tr>
              <td valign="top" style="padding:0;Margin:0">
               <table cellpadding="0" cellspacing="0" class="es-header" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top">
                 <tr>
                  <td align="center" style="padding:0;Margin:0">
                   <table bgcolor="#ffffff" class="es-header-body" align="center" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:700px">
                     <tr style="background-color: '.$cor_header2.';">
                      <td class="esdev-adapt-off" align="left" style="padding:20px;Margin:0;">
                       <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                         <tr>
                          <td class="es-m-p0r" valign="top" align="center" style="padding:0;Margin:0;width:660px;background-color:'.$cor_header2.'" bgcolor="'.$cor_header2.'">
                           <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                <tr>
                                    <td align="center" class="es-m-txt-c" style="padding: 15px 0;Margin:0;font-size:0px">
                                        <a href="'.$psite.'" target="_blank" rel="noopener" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#926B4A;font-size:14px; padding: 15px 0;">
                                            <img src="'.$psite.'/assets/img/logo/email.png" alt="'.$nome_loja_completa.'" title="'.$nome_loja_completa.'" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;" width="250">
                                        </a>
                                    </td>
                                </tr>
                           </table></td>
                         </tr>
                       </table></td>
                     </tr>
                     <tr>
                      <td align="left" style="padding:0;Margin:0;padding-top:20px;padding-left:20px;padding-right:20px">
                       <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                         <tr>
                          <td align="center" valign="top" style="padding:0;Margin:0;width:660px">
                           <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                             <tr>
                              <td align="center" style="padding:0;Margin:0"><h1 style="Margin:0;line-height:26px;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif;font-size:22px;font-style:normal;font-weight:bold;color:#333333">Olá,&nbsp;<strong>'.$nome.'!</h1></td>
                             </tr>
                             <tr>
                              <td align="center" style="padding:0;Margin:0;padding-top:5px;padding-bottom:5px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#666666;font-size:14px">Acabamos de receber sua solicitação para '.$tipook3.'.</p></td>
                             </tr>
                           </table></td>
                         </tr>
                       </table></td>
                     </tr>
                   </table></td>
                 </tr>
               </table>
               <table cellpadding="0" cellspacing="0" class="es-content" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
                 <tr>
                  <td align="center" style="padding:0;Margin:0">
                   <table bgcolor="#ffffff" class="es-content-body" align="center" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:700px">
                     <tr>
                      <td align="left" style="padding:0;Margin:0;padding-top:20px;padding-left:20px;padding-right:20px">
                       <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                         <tr>
                          <td align="center" valign="top" style="padding:0;Margin:0;width:660px">
                           <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                             <tr>
                              <td align="center" style="padding:0;Margin:0;font-size:0px"><img class="adapt-img" src="'.$psite.'/assets/img/email/confirmacao_pedido.jpg" alt style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" width="550"></td>
                             </tr>
                           </table></td>
                         </tr>
                       </table></td>
                     </tr>
                     <tr>
                      <td align="left" style="padding:0;Margin:0;padding-top:20px;padding-left:20px;padding-right:20px">
                       <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                         <tr>
                          <td align="center" valign="top" style="padding:0;Margin:0;width:660px">
                           <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                             <tr>
                              <td align="center" style="padding:0;Margin:0"><h2 style="Margin:0;line-height:36px;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif;font-size:24px;font-style:normal;font-weight:bold;color:#333333">'.$tipook2.' Nº '.$cpedido.'<br></h2></td>
                             </tr>
                             <tr>
                              <td align="left" class="es-m-txt-c" style="padding:0;Margin:0;padding-top:20px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:'.$cor_site.';font-size:14px"><strong>ITENS DO PEDIDO</strong></p></td>
                             </tr>
                             <tr>
                              <td align="center" style="padding:0;Margin:0;padding-top:5px;padding-bottom:5px;font-size:0">
                               <table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                 <tr>
                                  <td style="padding:0;Margin:0;border-bottom:1px solid #000000;background:none;height:1px;width:100%;margin:0px"></td>
                                 </tr>
                               </table></td>
                             </tr>
                           </table></td>
                         </tr>
                       </table></td>
                    </tr>
                    <table cellpadding="0" cellspacing="0" style="width:100%;border-collapse:collapse;border-spacing:0;">
                      <tr>
                        <th style="padding:5px;text-align:left;width: 25px;">SKU</th>
                        <th style="padding:5px;text-align:left;width: 250px;">PRODUTO</th>
                        <th style="padding:5px;text-align:left;width: 100px;padding-left:25px;">PREÇO</th>
                        <th style="padding:5px;text-align:left;width: 125px;padding-right:25px;">QUANTIDADE</th>
                        <th style="padding:5px;text-align:right;width: 25px;">TOTAL</th>
                      </tr>
                    </table>
                    ';
                                        
                    $sql_meu_carrinho = "SELECT c.nome, c.preco, c.qtd, c.cod, c.tamanho, c.cor, p.img, p.img_email, e.img_ancora, p.url_amigavel FROM carrinho AS c RIGHT JOIN produtos AS p ON (c.cod=p.id) LEFT JOIN estoque AS e ON(c.estoque=e.id) WHERE c.sessao='".session_id()."' AND c.id_cliente = '".$_SESSION['usr_id_cliente']."' ORDER BY c.nome ASC";
                    $exec_meu_carrinho =  mysqli_query($conn, $sql_meu_carrinho);
                    $qtd_meu_carrinho = mysqli_num_rows($exec_meu_carrinho);
        
                    while ($produto_carrinho = mysqli_fetch_assoc($exec_meu_carrinho)){
                        $id = $produto_carrinho['cod'];
                        $nome_produto = str_replace('–', '-', $produto_carrinho['nome']);
                        $quantidade = $produto_carrinho['qtd'];
                        $tamanho = $produto_carrinho['tamanho'];
                        $cor = $produto_carrinho['cor'];
                        $preco_produto = $produto_carrinho['preco'];
                        $url = $psite."/produto/".$produto_carrinho['url_amigavel'];
                        $img_ancora = "assets/img/produtos/".$id."/".$produto_carrinho['img_ancora'];
                        if ($preco_produto=='0.00' OR $preco_produto<1) {
                            $exibe_preco='Consulte-nos';
                            $sttl = 'Consulte-nos';
                        }else{
                            $exibe_preco = number_format($preco_produto,2,',','.');
                            $sttl = number_format(($preco_produto * $quantidade),2,',','.');
                        }
                        
                        if (file_exists('assets/img/produtos/'.$produto_carrinho['img_email']) AND $produto_carrinho['img_email']!='sem_imagem.jpg'){
                            $foto_produto = $url_loja.'/assets/img/produtos/'.$produto_carrinho['img_email'];
                        }else{
                            if (file_exists('assets/img/produtos/'.$produto_carrinho['img'])){
                                $foto_produto = $url_loja.'/assets/img/produtos/'.$produto_carrinho['img'];
                            }else{
                                $foto_produto = $url_loja.'/assets/img/produtos/sem_imagem.jpg';
                            }
                        }
                        
                        if (isset($row_rs_produto_carrinho['img_ancora']) AND file_exists($img_ancora) AND $row_rs_produto_carrinho['img_ancora']!=''){
                            $imagem = $url_loja.'/'.$img_ancora;
                        }
        
                        if (!isset($sttl) OR $sttl=='') {$sttl='Consulte-nos';}
                        if (!isset($exibe_preco) OR $exibe_preco=='') {$exibe_preco='Consulte-nos';}
                        if (!isset($conteudo2)){$conteudo2 = '';}
        
                        $conteudo2 .= '
                     <tr style="padding-top: 0 !important;">
                      <td class="esdev-adapt-off" align="left" style="padding:0;Margin:0;padding-top:20px;padding-left:20px;padding-right:20px;vertical-align: middle;">
                       <table cellpadding="0" cellspacing="0" class="esdev-mso-table" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:660px">
                         <tr>
                            <td class="esdev-mso-td" valign="top" style="padding:0;Margin:0;vertical-align: middle;width:25px">
                            <table cellpadding="0" cellspacing="0" class="es-left" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
                             <tr>
                              <td align="left" style="padding:0;Margin:0;width:125px;vertical-align: middle;">
                               <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                 <tr>
                                    <td align="center" style="padding:0;Margin:0;padding-bottom:20px;padding-top:20px">
                                        <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#666666;font-size:14px">'.$id.'</p>
                                    </td>
                                 </tr>
                               </table></td>
                             </tr>
                            </table>
                           </td>
                          <td class="esdev-mso-td" valign="top" style="padding:0;Margin:0;vertical-align: middle;">
                           <table cellpadding="0" cellspacing="0" class="es-left" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
                             <tr>
                              <td align="left" style="padding:0;Margin:0;width:89px;vertical-align: middle;">
                               <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                 <tr>
                                    <td align="center" style="padding:0;Margin:0;font-size:0px">
                                        <a href="'.$url.'" target="_blank" rel="noopener" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#926B4A;font-size:14px">
                                            <img class="adapt-img p_image" src="'.$foto_produto.'" alt="'.$nome_produto.'" title="'.$nome_produto.'" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" width="80">
                                        </a>
                                    </td>
                                 </tr>
                               </table></td>
                             </tr>
                           </table></td>
                          
                          <td class="esdev-mso-td" valign="top" style="padding:0;Margin:0;vertical-align: middle;">
                           <table cellpadding="0" cellspacing="0" class="es-left" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left;vertical-align: middle;">
                             <tr style="vertical-align: middle;">
                              <td align="left" style="padding:0;Margin:0;width:217px;vertical-align: middle;">
                               <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;vertical-align: middle;">
                                 <tr>
                                    <td align="left" style="padding:0;Margin:0;padding-top:20px;padding-bottom:20px;vertical-align: middle;">
                                        <h3 style="Margin:0;line-height:11px;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif;font-size:9px;font-style:normal;font-weight:bold;color:#333333"><span style="font-size:12px;line-height:14px">'.$nome_produto.'</span></h3>
                                        '.(((isset($tamanho) AND $tamanho!='') OR (isset($cor) AND $cor!=''))?'<p style="Margin:0;line-height:11px;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif;font-size:9px;font-style:normal;font-weight:bold;color:#858585;margin-top: 5px;"><span style="font-size:12px;line-height:14px">
                                            '.((isset($tamanho) AND $tamanho!='')?$tamanho:'').'
                                            '.((isset($tamanho) AND $tamanho!='' AND isset($cor) AND $cor!='')?' / ':'').'
                                            '.((isset($cor) AND $cor!='')?$cor:'').'
                                        </p>':'').'
                                    </td>
                                 </tr>
                               </table></td>
                             </tr>
                           </table></td>
                          
                          <td class="esdev-mso-td" valign="top" style="padding:0;Margin:0;vertical-align: middle;">
                           <table cellpadding="0" cellspacing="0" class="es-left" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
                             <tr>
                              <td align="left" style="padding:0;Margin:0;width:125px;vertical-align: middle;">
                               <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                 <tr>
                                    <td align="center" style="padding:0;Margin:0;padding-bottom:20px;padding-top:20px">
                                        <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#666666;font-size:14px">'.(($exibe_preco!='Consulte-nos')?'R$ '.$exibe_preco:'-').'</p>
                                    </td>
                                 </tr>
                               </table></td>
                             </tr>
                           </table></td>
                           
                           <td class="esdev-mso-td" valign="top" style="padding:0;Margin:0;vertical-align: middle;">
                           <table cellpadding="0" cellspacing="0" class="es-left" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
                             <tr>
                              <td align="left" style="padding:0;Margin:0;width:125px;vertical-align: middle;">
                               <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                 <tr>
                                    <td align="center" style="padding:0;Margin:0;padding-bottom:20px;padding-top:20px">
                                        <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#666666;font-size:14px">'.$quantidade.'</p>
                                    </td>
                                 </tr>
                               </table></td>
                             </tr>
                           </table></td>
                           
                           <td class="esdev-mso-td" valign="top" style="padding:0;Margin:0;vertical-align: middle;">
                           <table cellpadding="0" cellspacing="0" class="es-right" align="right" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right">
                             <tr>
                              <td align="right" style="padding:0;Margin:0;width:125px;vertical-align: middle;">
                               <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                 <tr>
                                    <td align="center" style="padding:0;Margin:0;padding-bottom:20px;padding-top:20px">
                                        <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#666666;font-size:14px; text-align:right;">'.(($sttl!='Consulte-nos')?'R$ '.$sttl:'-').'</p>
                                    </td>
                                 </tr>
                               </table></td>
                             </tr>
                           </table></td>
                         </tr>
                       </table></td>
                     </tr>

                     ';
                     }
                     $conteudo3 ='
                     <tr>
                      <td align="left" style="padding:0;Margin:0;padding-left:20px;padding-right:20px">
                       <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                         <tr>
                          <td align="center" valign="top" style="padding:0;Margin:0;width:660px">
                           <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                             <tr>
                              <td align="center" style="padding:0;Margin:0;padding-top:5px;padding-bottom:5px;font-size:0">
                               <table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                 <tr>
                                  <td style="padding:0;Margin:0;border-bottom:1px solid #000000;background:none;height:1px;width:100%;margin:0px"></td>
                                 </tr>
                               </table></td>
                             </tr>
                           </table></td>
                         </tr>
                       </table></td>
                     </tr>
                     <tr>
                      <td class="esdev-adapt-off" align="left" style="padding:0;Margin:0;padding-left:20px;padding-right:20px">
                       <table cellpadding="0" cellspacing="0" class="esdev-mso-table" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:660px">
                         <tr>
                          <td class="esdev-mso-td" valign="top" style="padding:0;Margin:0">
                           <table cellpadding="0" cellspacing="0" class="es-left" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
                             <tr>
                              <td align="left" style="padding:0;Margin:0;width:516px">
                               <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                 <tr>
                                  <td align="left" style="padding:0;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#000000;font-size:14px"><strong>SUBTOTAL<br>FRETE<br>TOTAL&nbsp;</strong></p></td>
                                 </tr>
                               </table></td>
                             </tr>
                           </table></td>
                          
                          <td class="esdev-mso-td" valign="top" style="padding:0;Margin:0">
                           <table cellpadding="0" cellspacing="0" class="es-right" align="right" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right">
                             <tr>
                              <td align="left" style="padding:0;Margin:0;width:124px">
                               <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                 <tr>
                                  <td align="right" style="padding:0;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#000000;font-size:14px"><strong>'.$_SESSION['total_parcial'].'</strong><br>&nbsp;<strong> '.$valor_frete.'</strong><br><strong>'.$total.'</strong></p></td>
                                 </tr>
                               </table></td>
                             </tr>
                           </table></td>
                         </tr>
                       </table></td>
                     </tr>
                     <tr>
                      <td align="left" style="padding:0;Margin:0;padding-left:20px;padding-right:20px">
                       <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                         <tr>
                          <td align="center" valign="top" style="padding:0;Margin:0;width:660px">
                           <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                             <tr>
                              <td align="center" style="padding:0;Margin:0;padding-top:5px;padding-bottom:5px;font-size:0">
                               <table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                 <tr>
                                  <td style="padding:0;Margin:0;border-bottom:1px solid #000000;background:none;height:1px;width:100%;margin:0px"></td>
                                 </tr>
                               </table></td>
                             </tr>
                             <tr>
                              <td align="left" class="es-m-txt-c" style="padding:0;Margin:0;padding-top:20px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:24px;color:'.$cor_site.';font-size:16px"><strong>ENDEREÇO DE ENTREGA</strong></p></td>
                             </tr>
                             <tr>
                              <td align="center" style="padding:0;Margin:0;padding-top:5px;padding-bottom:5px;font-size:0">
                               <table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                 <tr>
                                  <td style="padding:0;Margin:0;border-bottom:1px solid #000000;background:none;height:1px;width:100%;margin:0px"></td>
                                 </tr>
                               </table></td>
                             </tr>
                             <tr>
                                <td align="left" style="padding:0;Margin:0">
                                    <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#666666;font-size:14px">
                                        '.((isset($cep_informa) AND $cep_informa!="")?'<strong style="color: #000;">CEP:</strong> '.$cep_informa.'<br>':'').'
                                        '.((isset($endereco_informa) AND $endereco_informa!="")?'<strong style="color: #000;">Endereço:</strong> '.$endereco_informa.', '.$numero_informa.((isset($complemento_informa) AND $complemento_informa!='')?' - '.$complemento_informa:'').'<br>':'').'
                                        '.((isset($bairro_informa) AND $bairro_informa!="")?'<strong style="color: #000;">Bairro:</strong> '.$bairro_informa.'<br>':'').'
                                        '.((isset($cidade_informa) AND $cidade_informa!="")?'<strong style="color: #000;">Cidade:</strong> '.$cidade_informa.'<br>':'').'
                                        '.((isset($estado_informa) AND $estado_informa!="")?'<strong style="color: #000;">Estado:</strong> '.strtoupper($estado_informa).'<br>':'').'
                                    </p>
                                </td>
                             </tr>
                           </table></td>
                         </tr>
                       </table></td>
                     </tr>
                     <tr>
                      <td align="left" style="padding:0;Margin:0;padding-left:20px;padding-right:20px">
                       <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                         <tr>
                          <td align="center" valign="top" style="padding:0;Margin:0;width:660px">
                           <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                             <tr>
                              <td align="left" class="es-m-txt-c" style="padding:0;Margin:0;padding-top:20px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:24px;color:'.$cor_site.';font-size:16px"><strong>AOS CUIDADOS DE</strong></p></td>
                             </tr>
                             <tr>
                              <td align="center" style="padding:0;Margin:0;padding-top:5px;padding-bottom:5px;font-size:0">
                               <table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                 <tr>
                                  <td style="padding:0;Margin:0;border-bottom:1px solid #000000;background:none;height:1px;width:100%;margin:0px"></td>
                                 </tr>
                               </table></td>
                             </tr>
                             <tr>
                                <td align="left" style="padding:0;Margin:0">
                                    <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#666666 !important;font-size:14px">
                                        '.((isset($nome) AND $nome!="")?'<strong style="color: #000;">Nome:</strong> '.$nome.'<br>':'').'
                                        '.((isset($cpf_cliente) AND $cpf_cliente!="")?'<strong style="color: #000;">CPF:</strong> '.$cpf_cliente.'<br>':'').'
                                        '.((isset($celular) AND $celular!="")?'<strong style="color: #000;">Telefone:</strong> '.$celular.'<br>':'').'
                                        '.((isset($email) AND $email!="")?'<strong style="color: #000;">E-mail:</strong> <a href="'.$email.'" target="_blank" rel="noopener" style="color: #666666;">'.$email.'</a><br>':'').'
                                    </p>
                                </td>
                             </tr>
                           </table></td>
                         </tr>
                       </table></td>
                     </tr>
                   </table></td>
                 </tr>
               </table>
               <table cellpadding="0" cellspacing="0" class="es-content" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
                 <tr>
                  <td align="center" style="padding:0;Margin:0">
                   <table bgcolor="#ffffff" class="es-content-body" align="center" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:700px">
                     <tr>
                      <td align="left" style="padding:0;Margin:0;padding-left:20px;padding-right:20px">
                       <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                         <tr>
                          <td align="center" valign="top" style="padding:0;Margin:0;width:660px">
                           <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                             <tr>
                              <td align="left" class="es-m-txt-c" style="padding:0;Margin:0;padding-top:20px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:24px;color:'.$cor_site.';font-size:16px"><strong>LEMBRE-SE</strong></p></td>
                             </tr>
                             <tr>
                              <td align="center" style="padding:0;Margin:0;padding-top:5px;padding-bottom:5px;font-size:0">
                               <table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                 <tr>
                                  <td style="padding:0;Margin:0;border-bottom:1px solid #000000;background:none;height:1px;width:100%;margin:0px"></td>
                                 </tr>
                               </table></td>
                             </tr>
                             <tr>
                                <td align="left" style="padding:0;Margin:0;padding-top:5px;padding-bottom:5px">
                                    <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#666666;font-size:14px">
                                        A partir de agora para incluir ou excluir itens ou alterar o endereço de entrega você deverá entrar em contato com nosso suporte através do e-mail: <a href="'.$email_loja_link.'" target="_blank" rel="noopener" style="color: #666666;">'.$email_loja.'</a><br><br>
                                        Para sua segurança, podemos realizar a análise de dados cadastrais e confirmar por telefone. Portanto, sempre informe seus dados de contato atualizados.<br><br>O prazo de entrega é sempre calculado em dias úteis e começa a ser contado a partir da data de confirmação do pedido.
                                    </p>
                                </td>
                             </tr>
                           </table></td>
                         </tr>
                       </table></td>
                     </tr>
                     <tr>
                      <td align="left" style="padding:0;Margin:0;padding-bottom:20px;padding-top:20px;padding-left:20px;padding-right:20px"><!--[if mso]><table style="width:660px" cellpadding="0" cellspacing="0"><tr><td style="width:227px" valign="top"><![endif]-->
                       <table cellpadding="0" cellspacing="0" class="es-left" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
                         <tr>
                          <td class="es-m-p0r es-m-p20b" align="center" style="padding:0;Margin:0;width:207px">
                           <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                             <tr>
                                <td align="center" style="padding:0;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#000000;font-size:14px"><strong>E-MAIL</strong></p></td>
                             </tr>
                             <tr>
                                <td align="center" style="padding:0;Margin:0">
                                    <a href="'.$email_loja_link.'" target="_blank" rel="noopener">
                                        <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#666666;font-size:14px;">'.$pemail.'</p>
                                    </a>
                                </td>
                             </tr>
                           </table></td>
                          <td class="es-hidden" style="padding:0;Margin:0;width:20px"></td>
                         </tr>
                       </table><!--[if mso]></td><td style="width:207px" valign="top"><![endif]-->
                       <table cellpadding="0" cellspacing="0" class="es-left" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
                         <tr>
                          <td class="es-m-p20b" align="center" style="padding:0;Margin:0;width:207px">
                           <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                             <tr>
                                <td align="center" style="padding:0;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#000000;font-size:14px"><strong>WHATSAPP</strong></p></td>
                             </tr>
                             <tr>
                                <td align="center" style="padding:0;Margin:0">
                                    <a href="'.$link_whats.'" target="_blank" rel="noopener">
                                        <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#666666;font-size:14px">'.$telefone_loja_whats.'</p>
                                    </a>
                                </td>
                             </tr>
                           </table></td>
                         </tr>
                       </table><!--[if mso]></td><td style="width:20px"></td><td style="width:206px" valign="top"><![endif]-->
                       <table cellpadding="0" cellspacing="0" class="es-right" align="right" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right">
                         <tr>
                          <td align="center" style="padding:0;Margin:0;width:206px">
                           <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                             <tr>
                                <td align="center" style="padding:0;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#000000;font-size:14px"><strong>TELEFONE</strong></p></td>
                             </tr>
                             <tr>
                                <td align="center" style="padding:0;Margin:0">
                                    <a href="'.$link_telefone_loja1.'" target="_blank" rel="noopener">
                                        <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#666666;font-size:14px">'.$telefone_loja1.'</p>
                                    </a>
                                </td>
                             </tr>
                           </table></td>
                         </tr>
                       </table><!--[if mso]></td></tr></table><![endif]--></td>
                     </tr>
                   </table></td>
                 </tr>
               </table>
               <table cellpadding="0" cellspacing="0" class="es-footer" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:#E3CDC1;background-repeat:repeat;background-position:center top">
                 <tr>
                  <td align="center" bgcolor="#ffffff" style="padding-top:10px;Margin:0;background-color:#ffffff">
                   <table class="es-footer-body" align="center" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:700px">
                     <tr>
                      <td align="left" style="padding:0;Margin:0;padding-left:20px;padding-right:20px">
                       <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                         <tr>
                          <td align="left" style="padding:0;Margin:0;width:660px">
                           <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                             <tr>
                              <td align="center" style="padding:0;Margin:0;padding-top:10px;padding-bottom:10px;font-size:0px;background-color:'.$cor_site.'" bgcolor="'.$cor_site.'">
                               <table cellpadding="0" cellspacing="0" class="es-table-not-adapt es-social" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                    <tr>
                                        '.((isset($facebook) AND $facebook!="")?'<td align="center" valign="top" style="Margin:0;padding-right:10px;padding-left:10px"><a href="'.$facebook.'" target="_blank" rel="noopener" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#926B4A;font-size:14px"><img src="'.$psite.'/assets/img/email/facebook.png" alt="Facebook" title="Facebook" width="32" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic"></a></td>':'').'
                                        '.((isset($instagram) AND $instagram!="")?'<td align="center" valign="top" style="Margin:0;padding-right:10px;padding-left:10px"><a href="'.$instagram.'" target="_blank" rel="noopener" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#926B4A;font-size:14px"><img src="'.$psite.'/assets/img/email/instagram.png" alt="Instagram" title="Instagram" width="32" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic"></a></td>':'').'
                                        '.((isset($tiktok) AND $tiktok!="")?'<td align="center" valign="top" style="Margin:0;padding-right:10px;padding-left:10px"><a href="'.$tiktok.'" target="_blank" rel="noopener" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#926B4A;font-size:14px"><img src="'.$psite.'/assets/img/email/tiktok.png" alt="Tiktok" title="Tiktok" width="32" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic"></a></td>':'').'
                                        '.((isset($linkedin) AND $linkedin!="")?'<td align="center" valign="top" style="Margin:0;padding-right:10px;padding-left:10px"><a href="'.$linkedin.'" target="_blank" rel="noopener" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#926B4A;font-size:14px"><img src="'.$psite.'/assets/img/email/linkedin.png" alt="Linkedin" title="Linkedin" width="32" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic"></a></td>':'').'
                                        '.((isset($twitter) AND $twitter!="")?'<td align="center" valign="top" style="Margin:0;padding-right:10px;padding-left:10px"><a href="'.$twitter.'" target="_blank" rel="noopener" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#926B4A;font-size:14px"><img src="'.$psite.'/assets/img/email/twitter.png" alt="Twitter" title="Twitter" width="32" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic"></a></td>':'').'
                                        '.((isset($youtube) AND $youtube!="")?'<td align="center" valign="top" style="Margin:0;padding-right:10px;padding-left:10px"><a href="'.$youtube.'" target="_blank" rel="noopener" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#926B4A;font-size:14px"><img src="'.$psite.'/assets/img/email/youtube.png" alt="Youtube" title="Youtube" width="32" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic"></a></td>':'').'
                                    </tr>
                               </table></td>
                             </tr>
                           </table></td>
                         </tr>
                       </table></td>
                     </tr>
                     <tr>
                      <td align="left" style="padding:0;Margin:0;padding-top:15px;padding-left:20px;padding-right:20px">
                       <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                         <tr>
                          <td align="center" valign="top" style="padding:0;Margin:0;width:660px">
                           <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                             <tr>
                              <td align="center" style="padding:0;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, helvetica neue, helvetica, sans-serif;line-height:21px;color:#010101;font-size:14px"><strong>Sistema desenvolvido por</strong></p></td>
                             </tr>
                             <tr>
                                <td align="center" style="padding:0;Margin:0;font-size:0px">
                                    <a href="https://www.virtuabrasil.com.br" target="_blank" rel="noopener">
                                        <img class="adapt-img" src="'.$psite.'/assets/img/logo-virtua-black.png" alt="Virtua Brasil" title="Virtua Brasil" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" width="153">
                                    </a>
                                </td>
                             </tr>
                           </table></td>
                         </tr>
                       </table></td>
                     </tr>
                   </table></td>
                 </tr>
               </table></td>
             </tr>
           </table>
          </div>
         </body>
        </html>
        ';
    
        $sql= "SELECT *, car.nome, car.qtd, car.cod, car.logo, car.preco, car.sku, car.sistema, car.tamanho, car.cor, car.frete FROM carrinho AS car INNER JOIN produtos AS pro ON car.cod = pro.id WHERE sessao = '".session_id()."' AND id_cliente = '".$_SESSION['usr_id_cliente']."'";
        $resultado_sql = mysqli_query($conn,$sql);

        while ($coluna = mysqli_fetch_array($resultado_sql)) {
            $produto = $coluna["nome"];
            $qtd = $coluna["qtd"];
            $id_produto = $coluna['cod'];
            $imagem_produto = $coluna['logo'];
            $valor_produto = $coluna['preco'];
            $sku = $coluna['sku'];
            $sistema = $coluna['sistema'];
            $tamanho = $coluna['tamanho'];
            $cor = $coluna['cor'];
            $peso = $coluna['peso'];
            $frete = $coluna['frete'];
            $estoque = $coluna['estoque'];

            $categoria = $coluna['categoria'];
            $descricao = $coluna['descricao'];
            $sub_titulo = $coluna['sub_titulo'];
            $qtd_vendido = $coluna['qtd_vendido'];
            $qtd_visto = $coluna['qtd_visto'];
            $por = $coluna['por'];
            $forma = $coluna['forma'];
            $prazo = $coluna['prazo'];
            $regiao = $coluna['regiao'];
            $promocao = $coluna['promocao'];
            $destaque = $coluna['destaque'];
            $pronta = $coluna['pronta'];
            $faturamento = $coluna['faturamento'];
            $data_cadastro = $coluna['data_cadastro'];
            $hora_cadastro = $coluna['hora_cadastro'];
            $qtd_parcela = $coluna['qtd_parcela'];
            $valor_parcela = $coluna['valor_parcela'];
            $valor_parcela_juros = $coluna['valor_parcela_juros'];
            $comprimento = $coluna['comprimento'];
            $largura = $coluna['largura'];
            $altura = $coluna['altura'];
            $ordem = $coluna['ordem'];
            $link_compra = $coluna['link_compra'];
            $link_youtube = $coluna['link_youtube'];
            $informacoes_adicionais = $coluna['informacoes_adicionais'];
            $fabricante = $coluna['fabricante'];
            $ip = $coluna['ip'];
            $Titulo_seo = $coluna['Titulo_seo'];
            $Descricao_seo = $coluna['Descricao_seo'];
            $palavrasChave_seo = $coluna['palavrasChave_seo'];
            $endereco_ip = $coluna['endereco_ip'];
            $data_editar = $coluna['data_editar'];
            $hora_editar = $coluna['hora_editar'];
            $data_excluir = $coluna['data_excluir'];
            $estrelas_soma = $coluna['estrelas_soma'];
            $avaliacao_qtd = $coluna['avaliacao_qtd'];
            
            $sql_compra = "INSERT INTO produtos_comprado (id_produto, id_pedido, estoque, sku, produto, img, tamanho, cor, preco, qtd, peso, frete, categoria, sub_titulo, descricao, qtd_vendido, qtd_visto, por, forma, prazo, regiao, promocao, destaque, pronta, faturamento, data_cadastro, hora_cadastro, qtd_parcela, valor_parcela, valor_parcela_juros, comprimento, largura, altura, ordem, link_compra, link_youtube, informacoes_adicionais, fabricante, ip, Titulo_seo, Descricao_seo, palavrasChave_seo, endereco_ip, data_editar, hora_editar, data_excluir, estrelas_soma, avaliacao_qtd) VALUES
            ('$id_produto','$idpedido','$estoque','$sku','$produto','$imagem_produto','$tamanho','$cor','$valor_produto','$qtd','$peso','$frete','$categoria','$sub_titulo','$descricao','$qtd_vendido','$qtd_visto','$por','$forma','$prazo','$regiao','$promocao','$destaque','$pronta','$faturamento','$data_cadastro','$hora_cadastro','$qtd_parcela','$valor_parcela','$valor_parcela_juros','$comprimento','$largura','$altura','$ordem','$link_compra','$link_youtube','$informacoes_adicionais','$fabricante','$ip','$Titulo_seo','$Descricao_seo','$palavrasChave_seo','$endereco_ip','$data_editar','$hora_editar','$data_excluir','$estrelas_soma','$avaliacao_qtd')";
            $query_compra = mysqli_query($conn,$sql_compra) or die(mysqli_error($conn));
        }
    

    $nome_exibe = ucfirst(trim($nome));
    $conteudo = $conteudo;
    $conteudo2 = $conteudo2;
    $conteudo3 = $conteudo3;
    $msg = $conteudo.$conteudo2.$conteudo3;
    if (!isset($pnome) OR $pnome=='') { $pnome = $nome_loja_completa; }
    if (!isset($pemail) OR $pemail=='') { $pemail = $email_loja; }

    $pnome = ucfirst(trim($pnome));
    
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: '.$pnome.' <'.$pemail.'>' . "\r\n";
    $headers .= 'Bcc: Virtua Brasil<contato@virtuabrasil.com.br>, '.ucwords($pnome).'<'.strtolower($pemail).'>, Dev Virtua Brasil <dev@virtuabrasil.com.br>' . "\r\n";
    $headers .= 'Reply-To: '.$nome_exibe.' <'.$email_cliente.'>' . "\r\n";
    $headers .= 'X-Mailer: PHP/' . phpversion();
            
    $assunto = $tipook;
    $email_to = $nome_exibe.'<'.$email_cliente.'>';

    mail(iconv("UTF-8", "ISO-8859-1", $email_to), iconv("UTF-8", "ISO-8859-1", ucwords($assunto)), iconv("UTF-8", "ISO-8859-1", $msg), iconv("UTF-8", "ISO-8859-1", $headers));

    $retorno["OK"] = true;
	echo json_encode($retorno);
	exit();
    
}else{
    $retorno["OK"] = false;
    echo json_encode($retorno);
    echo "<meta http-equiv='refresh' content='0;URL=carrinho'>";
    exit();
}
?>