<?php
require_once "includes/config.php";

if (!isset($_POST['ses']) OR $_POST['ses']==''){
    echo "<meta http-equiv='refresh' content='0;URL=$url_loja'>";
    exit();
}
	
// 	$_POST['uid'] = '1';
// 	$_POST['tipo'] = 'padrao';
// 	$_POST['ses'] = 'f2a8551f3bb70c17a6092c9abedb214e';
// 	$_POST['nomeend'] = 'Escritório';
// 	$_POST['cep'] = '12030-470';
// 	$_POST['logradouro'] = 'Rua Equador';
// 	$_POST['numero'] = '300';
// 	$_POST['complemento'] = 'Sala 1';
// 	$_POST['bairro'] = 'Jardim das Nações';
// 	$_POST['cidade'] = 'Taubaté';
// 	$_POST['estado'] = 'SP';
// 	$_POST['pontoreferencia'] = 'Atrás do Hemonúcleo';
// 	$_POST['frete'] = '13.82';
// 	$_POST['frete_valor'] = '13.82';
// 	$_POST['freteID'] = '2';
// 	$_POST['freteAID'] = '1';
	
	$uid = ((isset($_POST['uid']) AND $_POST['uid']!='')?trim(addslashes(htmlspecialchars($_POST['uid']))):'');
	$tipo = ((isset($_POST['tipo']) AND $_POST['tipo']!='')?trim(addslashes(htmlspecialchars($_POST['tipo']))):'');
	$carrinho_sessao_id = ((isset($_POST['ses']) AND $_POST['ses']!='')?trim(addslashes(htmlspecialchars($_POST['ses']))):'');
	$nomeend = ((isset($_POST['nomeend']) AND $_POST['nomeend']!='')?trim(addslashes(htmlspecialchars($_POST['nomeend']))):'');
	$cep = ((isset($_POST['cep']) AND $_POST['cep']!='')?trim(addslashes(htmlspecialchars($_POST['cep']))):'');
	$logradouro = ((isset($_POST['logradouro']) AND $_POST['logradouro']!='')?trim(addslashes(htmlspecialchars($_POST['logradouro']))):'');
	$numero = ((isset($_POST['numero']) AND $_POST['numero']!='')?trim(addslashes(htmlspecialchars($_POST['numero']))):'');
	$complemento = ((isset($_POST['complemento']) AND $_POST['complemento']!='')?trim(addslashes(htmlspecialchars($_POST['complemento']))):'');
	$bairro = ((isset($_POST['bairro']) AND $_POST['bairro']!='')?trim(addslashes(htmlspecialchars($_POST['bairro']))):'');
	$cidade = ((isset($_POST['cidade']) AND $_POST['cidade']!='')?trim(addslashes(htmlspecialchars($_POST['cidade']))):'');
	$estado = ((isset($_POST['estado']) AND $_POST['estado']!='')?trim(addslashes(htmlspecialchars($_POST['estado']))):'');
	$pontoreferencia = ((isset($_POST['pontoreferencia']) AND $_POST['pontoreferencia']!='')?trim(addslashes(htmlspecialchars($_POST['pontoreferencia']))):'');
	$frete_valor = ((isset($_POST['frete']) AND $_POST['frete']!='')?trim(addslashes(htmlspecialchars($_POST['frete']))):'');
	$frete = ((isset($_POST['frete']) AND $_POST['frete']!='')?trim(addslashes(htmlspecialchars($_POST['frete']))):'');
	$freteID = ((isset($_POST['freteID']) AND $_POST['freteID']!='')?trim(addslashes(htmlspecialchars($_POST['freteID']))):'');
	$freteAID = ((isset($_POST['freteAID']) AND $_POST['freteAID']!='')?trim(addslashes(htmlspecialchars($_POST['freteAID']))):'');
	$freteP = ((isset($_POST['freteP']) AND $_POST['freteP']!='')?trim(addslashes(htmlspecialchars($_POST['freteP']))):'');
	$freteE = ((isset($_POST['freteE']) AND $_POST['freteE']!='')?trim(addslashes(htmlspecialchars($_POST['freteE']))):'');
		
	if($tipo=='novo'){
		mysqli_query($conn,"INSERT INTO enderecos_entrega (id_cliente,apelido,cep,endereco,numero,bairro,cidade,estado,complemento,pto_referencia) VALUES('".$uid."','".$nomeend."','".$cep."','".$logradouro."','".$numero."','".$bairro."','".$cidade."','".$estado."','".$complemento."','".$pontoreferencia."')");
		$tipo = mysqli_insert_id($conn);
	} elseif($tipo=='padrao'){
		$dadosEnd = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM clientes WHERE id='".$uid."' LIMIT 1"));
		$cep=$dadosEnd['cep'];
		$logradouro=$dadosEnd['endereco'];
		$numero=$dadosEnd['numero'];
		$complemento=$dadosEnd['complemento'];
		$bairro=$dadosEnd['bairro'];
		$cidade=$dadosEnd['cidade'];
		$estado=$dadosEnd['estado'];
		$pontoreferencia=$dadosEnd['pto_referencia'];
	}else{
		$dadosEnd = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM enderecos_entrega WHERE id='".$tipo."' LIMIT 1"));
		$cep=$dadosEnd['cep'];
		$logradouro=$dadosEnd['endereco'];
		$numero=$dadosEnd['numero'];
		$complemento=$dadosEnd['complemento'];
		$bairro=$dadosEnd['bairro'];
		$cidade=$dadosEnd['cidade'];
		$estado=$dadosEnd['estado'];
		$pontoreferencia=$dadosEnd['pto_referencia'];
	}
	
	$dataPS = array();
	$dataPS['currency'] = 'BRL';
    $frete = $_POST['frete_valor'];
	
	mysqli_query($conn,"UPDATE carrinho SET frete='".$frete."', frete_id='".$freteID."', frete_agencia_id='".$freteAID."', frete_prazo='".$freteP."', frete_empresa='".$freteE."' WHERE sessao='".$carrinho_sessao_id."'");
	
	$qr = mysqli_query($conn,"SELECT *, tb1.nome AS nome, tb1.cod AS cod, tb1.qtd AS qtd, tb1.preco AS preco, tb1.frete AS frete, tb2.peso AS peso FROM carrinho AS tb1 INNER JOIN produtos AS tb2 ON(tb1.cod=tb2.id) WHERE sessao='".$_POST['ses']."'");
    $j = 0;
    
    
    if (isset($_SESSION['cupom_de_desconto']) AND $_SESSION['cupom_de_desconto']!=''){
        $total_com_desconto = str_replace(",", ".", str_replace(".", "", str_replace("R$ ", "", str_replace("<strong>", "", str_replace("</strong>", "", $_SESSION['total_parcial'])))));
        $total=0;
    }
	while($ln=mysqli_fetch_array($qr)){
		$j++;
	    $peso = str_replace("0.", "", $ln['peso']);
        $peso = str_replace(".", "", $peso);
		if(strlen($ln['nome']) > 100){
			$descri = substr(($ln['nome']),0,97).'...';
		}else{
			$descri = $ln['nome'];
		}
		
        $preco = $ln['preco'];
        
        if (isset($_SESSION['cupom_de_desconto']) AND $_SESSION['cupom_de_desconto']!=''){
            $total += $preco;
        }
        $qtd = $ln['qtd'];
		
		$dataPS["itemId".$j] = $ln['cod'];
		$dataPS["itemDescription".$j] = utf8_decode($descri);
		$dataPS["itemAmount".$j] = $preco;
		$dataPS["itemQuantity".$j] = $ln['qtd'];
		$dataPS["itemWeight".$j] = $peso;
	}
// 	echo $frete.'<br><br>';
    $dataPS["shippingCost"] = number_format($frete_valor, 2, '.', '');
    
	$dC = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM clientes WHERE id='".$uid."' LIMIT 1"));
	
	$cellimpo = str_replace(' ','',$dC['celular']);
	$cellimpo = str_replace('-','',$cellimpo);
	$cellimpo = str_replace('(','',$cellimpo);
	$cellimpo = str_replace(')','',$cellimpo);
	
	$cpflimpo = str_replace('.','',$dC['cpf_cnpj']);
	$cpflimpo = str_replace('-','',$cpflimpo);
	$cpflimpo = str_replace('/','',$cpflimpo);
	
	$ddd = substr($cellimpo,0,2);
	$cell = substr($cellimpo,2,9);
	
	$dataPS['reference'] = $uid.'_0_'.$carrinho_sessao_id;
	$dataPS['senderName'] = utf8_decode($dC['responsavel_nome'].' '.$dC['sobrenome']);
	$dataPS['senderAreaCode'] = $ddd;
	$dataPS['senderPhone'] = $cell;
	$dataPS['senderEmail'] = $dC['email'];
	if (strlen($cpflimpo)==11){
	    $dataPS['senderDocumentsType'] = 'CPF';
	    $dataPS['senderDocumentsvalue'] = $cpflimpo;
	}else{
	    $dataPS['senderDocumentsType'] = 'CNPJ';
	    $dataPS['senderDocumentsvalue'] = $cpflimpo;
	}
	$total = $_SESSION['total_parcial'];
	if (isset($_SESSION['cupom_de_desconto']) AND $_SESSION['cupom_de_desconto']!=''){
	    $total_final = intval($total_com_desconto) - intval($total);
	    $dataPS['extraAmount'] = number_format($total_final, 2, '.', '');
	}
	$url = 'https://ws.pagseguro.uol.com.br/v2/checkout?email='.$email_pagseguro.'&token='.$token_pagseguro.'';
	$dataPSOK = http_build_query($dataPS);
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $dataPSOK);
	curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	$xml= curl_exec($curl);
	curl_close($curl);
	$xml= simplexml_load_string($xml);
// 	 print_r($xml);
// 	 $retorno["simplexml_load_string"] = $xml;
	 $retorno["resposta"] = $xml;
	 $retorno["pscode"] = $xml -> code;
	
	echo json_encode($retorno);