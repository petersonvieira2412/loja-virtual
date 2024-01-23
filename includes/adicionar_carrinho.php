<?php
    require_once "config.php";
	$retorno["jatem"] = false;

	if (!isset($_POST['codigo'])){$_POST['codigo'] = '';}
	if (!isset($_POST['nome'])){$_POST['nome'] = '';}
	if (!isset($_POST['qtd'])){$_POST['qtd'] = '1';}
	if (!isset($_POST['imagem'])){$_POST['imagem'] = '';}
	if (!isset($_POST['preco'])){$_POST['preco'] = '';}
	if (!isset($_POST['cor'])){$_POST['cor'] = '';}
	if (!isset($_POST['tamanho'])){$_POST['tamanho'] = '';}
	if (!isset($_SESSION['usr_id_cliente'])){$_SESSION['usr_id_cliente'] = '0';}
	
	$estoque = ((isset($_POST['estoque']) AND $_POST['estoque']!='')?$_POST['estoque']:0);

	$cod = $_POST['codigo'];
    $nome = $_POST['nome'];
    $qtd = $_POST['qtd'];
    $preco = $_POST['preco'];

    $id_p = $cod;

	$tamanho = $_POST['tamanho'];
    $cor = $_POST['cor'];
	
    $imagem = $_POST['imagem'];
    if ($imagem==''){
       $imagem = 'N/I';
    }
    $cod = (int)$cod;
    $qtd = (int)$qtd;
    
    if ($estoque>0){
        $sql_estoque = " AND estoque='$estoque'";
    }else{
        $sql_estoque = "";
    }
    
	$query_rs_carrinho = "SELECT * FROM carrinho WHERE cod='".$id_p."' AND sessao='".session_id()."' AND id_cliente='".$_SESSION['usr_id_cliente']."'$sql_estoque";
	$rs_carrinho = mysqli_query($conn, $query_rs_carrinho);
	$carrinho_dados = mysqli_fetch_array($rs_carrinho);
	$totalRows_rs_carrinho = mysqli_num_rows($rs_carrinho);
	if ($totalRows_rs_carrinho == 0){

		$query_rs_produto = "SELECT p.sku, p.produto, p.url_amigavel, p.img, e.img_ancora, p.qtd_minimo FROM produtos AS p LEFT JOIN estoque AS e ON (p.id=e.produto) WHERE p.id='".$id_p."' limit 1";
		$rs_produto = mysqli_query($conn,$query_rs_produto);
		$row_rs_produto = mysqli_fetch_assoc($rs_produto);
		$totalRows_rs_produto = mysqli_num_rows($rs_produto);

        if (isset($row_rs_produto['img_ancora']))
        $img = $url_loja.'assets/img/produtos/'.$row_rs_produto['img'];
		
		$frete = 0;
		if ($totalRows_rs_produto > 0){

			if ($qtd<$row_rs_produto['qtd_minimo']){
			    $qtd = $row_rs_produto['qtd_minimo'];
			}
			
			$add_sql = "INSERT INTO carrinho (cod, id_cliente, estoque, sku, nome, logo, preco, tamanho, cor, qtd, sessao) VALUES
			('".$cod."','".$_SESSION['usr_id_cliente']."','".$estoque."','".$row_rs_produto['sku']."','".$row_rs_produto['produto']."','".$imagem."','".$preco."','".$tamanho."','".$cor."','".$qtd."','".session_id()."')";
			if(!mysqli_query($conn,$add_sql)){
				$retorno["msgMsg"] = 'Não foi possível adicionar o produto no carrinho!';
			}else{
			    $retorno["msgTipo"] = 'success';
			}
			$retorno["url"] = $row_rs_produto['url_amigavel'];
			$retorno["id"] = mysqli_insert_id($conn);
		}
	} elseif ($estoque>0 AND $estoque!=$carrinho_dados['estoque']){

		$query_rs_produto = "SELECT p.sku, p.produto, p.url_amigavel, p.img, e.img_ancora, p.qtd_minimo FROM produtos AS p LEFT JOIN estoque AS e ON (p.id=e.produto) WHERE p.id='".$id_p."' LIMIT 1";
		$rs_produto = mysqli_query($conn, $query_rs_produto);
		$row_rs_produto = mysqli_fetch_assoc($rs_produto);
		$totalRows_rs_produto = mysqli_num_rows($rs_produto);
		
		$frete = 0;
		if ($totalRows_rs_produto > 0){

			if ($qtd<$row_rs_produto['qtd_minimo']){
			    $qtd = $row_rs_produto['qtd_minimo'];
			}
			
			$add_sql = "INSERT INTO carrinho (cod, id_cliente, estoque, nome, logo, preco, tamanho, cor, qtd, sessao) VALUES
			('".$cod."','".$_SESSION['usr_id_cliente']."','".$estoque."','".$row_rs_produto['produto']."','".$imagem."','".$preco."','".$tamanho."','".$cor."','".$qtd."','".session_id()."')";
			if(!mysqli_query($conn,$add_sql)){
				$retorno["msgTipo"] = 'error';
				$retorno["msgTitulo"] = 'PRODUTO';
				$retorno["msgMsg"] = 'Não foi possível adicionar o produto no carrinho!';
			}else{
				$retorno["msgTipo"] = 'success';
				$retorno["msgTitulo"] = 'PRODUTO';
				$retorno["msgMsg"] = 'Produto adicionado no carrinho com sucesso!';
			 }
			
			$retorno["url"] = $row_rs_produto['url_amigavel'];
			$retorno["id"] = mysqli_insert_id($conn);
				
		}else{
			$retorno["msgTipo"] = 'error';
			$retorno["msgTitulo"] = 'PRODUTO';
			$retorno["msgMsg"] = 'Produto inválido e/ou inexistente.';
		}
	}else{
	   $retorno["jatem"] = true;
	}
	$retorno["estoque"] = ((isset($carrinho_dados['estoque']) AND $carrinho_dados['estoque']!='')?$carrinho_dados['estoque']:'');
	
	if ($retorno["jatem"]!=true AND PIXEL_ID!='' AND ACCESS_TOKEN!=''){
    	$query = mysqli_query($conn, "SELECT email, celular, responsavel_nome, sexo, data_nascimento, cep, cidade, estado FROM clientes WHERE id='".$_SESSION['usr_id_cliente']."' AND status='a' LIMIT 1");
        if (mysqli_num_rows($query)>0){
            $dados = mysqli_fetch_assoc($query);
        }
        $email = ((isset($dados['email']) AND $dados['email']!='')?hash('sha256', $dados['email']):'');
        $celular = ((isset($dados['celular']) AND $dados['celular']!='')?hash('sha256', clean($dados['celular'])):'');
        
        if (isset($dados['responsavel_nome']) AND $dados['responsavel_nome']!=''){
        	$partes_nome = explode(" ", $dados['responsavel_nome']);
            $nome = $partes_nome[0];
            $sobrenome = implode(" ", array_slice($partes_nome, 1));
        }
        $nome = ((isset($nome) AND $nome!='')?hash('sha256', $nome):'');
        $sobrenome = ((isset($sobrenome) AND $sobrenome!='')?hash('sha256', $sobrenome):'');
        $sexo = ((isset($dados['sexo']) AND $dados['sexo']!='')?hash('sha256', $dados['sexo']):'');
        $data_nascimento = ((isset($dados['data_nascimento']) AND $dados['data_nascimento']!='' AND $data_nascimento!='0000-00-00')?hash('sha256', $dados['data_nascimento']):'');
        $cep = ((isset($dados['cep']) AND $dados['cep']!='')?hash('sha256', clean($dados['cep'])):'');
        $cidade = ((isset($dados['cidade']) AND $dados['cidade']!='')?hash('sha256', $dados['cidade']):'');
        $estado = ((isset($dados['estado']) AND $dados['estado']!='')?hash('sha256', $dados['estado']):'');
    	
        $addtocartevent = [
            "event_name" => "AddToCart",
            "event_time" => time(),
            "user_data" => [
                'client_ip_address' => $_SERVER['REMOTE_ADDR'],
                'client_user_agent' => $_SERVER['HTTP_USER_AGENT'],
                'em' => $email,
                'ph' => $celular,
                'fn' => $nome,
                'ln' => $sobrenome,
                'ge' => $sexo,
                'db' => $data_nascimento,
                'zp' => $cep,
                'ct' => $cidade,
                'st' => $estado
            ],
            "custom_data" => [
            "currency" => "BRL",
            "value" => $preco,
            ],
            'event_source_url' => getEventSourceUrl(),
            "opt_out" => false,
            "event_id" => generateUniqueEventId(),
            "action_source" => "website",
            "data_processing_options" => [],
            "data_processing_options_country" => 0,
            "data_processing_options_state" => 0,
        ];
        
        $events = [$addtocartevent];
        $data = [
            'data' => $events,
            'test_event_code' => TEST_EVENT_CODE
        ];
        
        $url = 'https://graph.facebook.com/v16.0/'.PIXEL_ID.'/events?access_token='.ACCESS_TOKEN;
        $post = json_encode($data);
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        
        $response = curl_exec($ch);
        
        if ($response === false) {
            echo 'Error: ' . curl_error($ch);
        } else {
            $response_data = json_decode($response, true);
            if (isset($response_data['error'])) {
                echo 'Error: ' . $response_data['error']['message'];
            } else {
                echo json_encode($retorno);
	            exit;
            }
        }
        
        curl_close($ch);
        ?>
        <script>
            fbq('track', 'AddToCart', {
                content_ids: ['<?=$cod;?>'],
                content_type: 'product'
            });
        </script>
        <?
	}
echo json_encode($retorno);
exit;