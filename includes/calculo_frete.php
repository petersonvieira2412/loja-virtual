<?php
	require_once "config.php";
	if (!isset($_POST['numero']) || $_POST['numero']==''){$_POST['numero']='1';}
	if (!isset($_POST['endereco']) || $_POST['endereco']==''){$_POST['endereco']='Nao informado';}
	
	$arrC = array();
	$qr = mysqli_query($conn,"SELECT *, tb1.qtd AS qtd FROM carrinho AS tb1 INNER JOIN produtos AS tb2 ON(tb1.cod=tb2.id) WHERE sessao='".session_id()."'");
	if (mysqli_num_rows($qr)<1){
	    echo "<meta http-equiv='refresh' content='0;URL=$url_loja'>";
        exit();
	}
	while($ln=mysqli_fetch_array($qr)){
		$arrP = array();
		$peso = $ln['peso'];
		$preco_final = $ln['preco'];
		$arrP["id"] = $ln['cod'];
		$arrP["weight"] = $peso;
		$arrP["width"] = $ln['largura'];
		$arrP["height"] = $ln['altura'];
		$arrP["length"] = $ln['comprimento'];
		$arrP["quantity"] = $ln['qtd'];
		$arrP["insurance_value"] = $preco_final;
		
		array_push($arrC, $arrP);
		
	}
	
	$fields = array(
				"from" => array("postal_code" => "$cep_loja", "address" => "$endereco_loja", "number" => "$numero_loja"),
				"to" => array("postal_code" => "".$_POST['cep']."", "address" => "".$_POST['endereco']."", "number" => "".$_POST['numero'].""),
				"products" => $arrC,
				"options" => array("insurance_value" => $arrP["insurance_value"], "receipt" => false, "own_hand" => false, "collect" => false),
				"services" => "1,2"
			);

	$retorno["arrFields"] = $fields;

	$fields = json_encode($fields);
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://www.melhorenvio.com.br/api/v2/me/ecommerce/calculate");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
											   'Accept: application/json',
											   'Authorization: Bearer '.$token_frete.''));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

	$response = curl_exec($ch);
	$err = curl_error($ch);
	curl_close($ch);

	if ($err) {
		$retorno["erro"]  = true;
		$retorno["msg"] = $response;
	} else {	
		$retorno["erro"]  = false;
		$response = json_decode($response);
		$dados = '';
		foreach($response AS $k){
			$erro = property_exists($k, "error");
            if($erro!='1'){
                $dados .= '
    				<tr class="responsive-table-row">
                        <td><img src="'.$k->company->picture.'" width="100px" class="imagem-frete" valin="middle"></td>
                        <td>'.$k->name.'</td>
                        <td>'.$k->delivery_time.' dias</td>
                        <td>R$ '.number_format($k->price,2,',','.').'</td>
                        <td><input type="radio" data-id="'.$k->id.'" data-agency-id="'.$k->company->id.'" data-prazo="'.$k->delivery_time.'" data-empresa="'.$k->company->name.'" value="'.number_format($k->price,2).'" class="rdoFrete" name="radioFrete" onclick="somaFrete(\''.number_format($k->price,2).'\');" required></td>
                    </tr>
				';
			}
		}
		$retorno["dados"] = $dados;
	}
	
echo json_encode($retorno);