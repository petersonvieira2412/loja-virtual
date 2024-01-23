<?
ob_start();
require_once "includes/config.php";
$onde = 'obrigado';

$query_rs_car = "SELECT * FROM carrinho WHERE sessao='".session_id()."' AND id_cliente='".$_SESSION['usr_id_cliente']."'";
$rs_car = mysqli_query($conn,$query_rs_car) or die(mysqli_error());
$totalRows_rs_car = mysqli_num_rows($rs_car);
    
if ($totalRows_rs_car > 0){
    while ($dados = mysqli_fetch_assoc($rs_car)) {
        $cod = $dados['cod'];
        $estoque = $dados['estoque'];
        $qtd = $dados['qtd'];
    
        $sql = "UPDATE produtos SET qtd_vendido=qtd_vendido+".$qtd.", qtd=qtd-".$qtd." WHERE id='".$cod."'";
        $resultado = mysqli_query($conn,$sql) or die ("Não foi possível realizar a consulta ao banco de dados");
        
        if (isset($estoque) AND $estoque>0){
            $sql = "UPDATE estoque SET qtd=qtd-".$qtd." WHERE id='".$estoque."'";
            $resultado = mysqli_query($conn,$sql) or die ("Não foi possível realizar a consulta ao banco de dados");
        }
        
        $sql_carrinho_excluir = "DELETE FROM carrinho WHERE sessao = '".session_id()."' AND id_cliente = '".$_SESSION['usr_id_cliente']."'";   
        $exec_carrinho_excluir = mysqli_query($conn,$sql_carrinho_excluir) or die(mysqli_error());
    }
}
if (isset($_SESSION['pedido'])){
    $pedido = $_SESSION['pedido'];
}else{
    $pedido = '';
}
$sql = "SELECT p.identificacao_pedido, p.valor_pedido, p.valor_frete, pc.produto, pc.id, pc.preco, pc.qtd, p.nome, p.sobrenome, p.celular, p.telefone, p.email, p.cep, p.endereco, p.numero, p.bairro, p.cidade, p.estado, c.sexo, c.data_nascimento FROM pedidos AS p INNER JOIN produtos_comprado AS pc ON (p.id=pc.id_pedido) INNER JOIN clientes AS c ON (p.id_cliente=c.id) WHERE p.identificacao_pedido='$pedido'";
$query = mysqli_query($conn, $sql);
if (mysqli_num_rows($query)>0){
    $item = array();
    while ($dados = mysqli_fetch_assoc($query)){
        $id = $dados['identificacao_pedido'];
        $valor_pedido = $dados['valor_pedido'];
        $valor_frete = $dados['valor_frete'];
        $produto = $dados['produto'];
        $id_produto = $dados['id'];
        $preco = $dados['preco'];
        $qtd = $dados['qtd'];
        
        $nome = $dados['nome'];
        $sobrenome = $dados['sobrenome'];
        if (isset($dados['celular']) AND $dados['celular']!=''){
            $telefone = $dados['celular'];
        }else{
            $telefone = $dados['telefone'];
        }
        $email = $dados['email'];
        $cep = $dados['cep'];
        $endereco = $dados['endereco'];
        $numero = $dados['numero'];
        $bairro = $dados['bairro'];
        $cidade = $dados['cidade'];
        $estado = $dados['estado'];
        $pais = 'Brasil';
        
        $sexo = $dados['sexo'];
        $estado = $dados['estado'];
        
        $array = array(
            "item_nome" => $produto,
            "item_id" => $id_produto,
            "preco"   => $preco,
            "item_marca"  => $nome_loja,
            "quantidade"  => $qtd
        );
        
        array_push($item, $array);
    }
    if (isset($dados['nome']) AND $dados['nome']!=''){
    	$partes_nome = explode(" ", $dados['nome']);
        $nome = $partes_nome[0];
        $sobrenome = implode(" ", array_slice($partes_nome, 1));
    }
    $array_comprador = array(
        "nome"  => $nome,
        "sobrenome"  => $sobrenome,
        "telefone"  => $telefone,
        "email"  => $email,
        "cep"  => $cep,
        "rua"  => $endereco,
        "numero"  => $numero,
        "bairro"  => $bairro,
        "cidade"  => $cidade,
        "estado"  => $estado,
        "pais"  => $pais
    );
    
    
    $array_fb = array(
        'client_ip_address'  => $_SERVER['REMOTE_ADDR'],
        'em' => ((isset($email) AND $email!='')?hash('sha256', $email):''),
        'ph' => ((isset($celular) AND $celular!='')?hash('sha256', clean($celular)):''),
        'fn' => ((isset($nome) AND $nome!='')?hash('sha256', $nome):''),
        'ln' => ((isset($sobrenome) AND $sobrenome!='')?hash('sha256', $sobrenome):''),
        'ge' => ((isset($sexo) AND $sexo!='')?hash('sha256', $sexo):''),
        'db' => ((isset($data_nascimento) AND $data_nascimento!='' AND $data_nascimento!='0000-00-00')?hash('sha256', $data_nascimento):''),
        'zp' => ((isset($cep) AND $cep!='')?hash('sha256', clean($cep)):''),
        'ct' => ((isset($cidade) AND $cidade!='')?hash('sha256', $cidade):''),
        'st' => ((isset($estado) AND $estado!='')?hash('sha256', $estado):'')
    );
    
    // Configuração do evento de Purchase
    $purchaseevent = [
        "event_name" => "Purchase",
        "event_time" => time(),
        "user_data" => $array_fb,
        "custom_data" => [
            "currency" => "BRL",
            "value" => $valor_pedido,
        ],
        'event_source_url' => getEventSourceUrl(),
        "opt_out" => false,
        "event_id" => generateUniqueEventId(),
        "action_source" => "website",
        "data_processing_options" => [],
        "data_processing_options_country" => 0,
        "data_processing_options_state" => 0,
    ];
    $events = [$purchaseevent];
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
    curl_close($ch);
}
    
if(isset($_GET['transaction_id']) AND $_GET['transaction_id']!=''){
    
    $url = 'https://ws.pagseguro.uol.com.br/v3/transactions/'.$_GET['transaction_id'].'?email='.$email_pagseguro.'&token='.$token_pagseguro.'';
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    $xml= curl_exec($curl);
    curl_close($curl);
    $xml= simplexml_load_string($xml);
    $status = $xml -> status;
    
    if ($status=='1'){
        $situacao = 'ag';
        $transaction_situacao = 'Aguardando Pagamento';
    }elseif ($status=='2'){
        $situacao = 'an';
        $transaction_situacao = 'Em Análise';
    }elseif ($status=='3'){
        $situacao = 'pg';
        $transaction_situacao = 'Paga';
    }elseif ($status=='4'){
        $situacao = 'di';
        $transaction_situacao = 'Disponível';
    }elseif ($status=='5'){
        $situacao = 'ed';
        $transaction_situacao = 'Em disputa';
    }elseif ($status=='6'){
        $situacao = 'dv';
        $transaction_situacao = 'Devolvida';
    }elseif ($status=='7'){
        $situacao = 'ca';
        $transaction_situacao = 'Cancelada';
    }elseif ($status=='8'){
        $situacao = 'db';
        $transaction_situacao = 'Debitado';
    }elseif ($status=='9'){
        $situacao = 'rt';
        $transaction_situacao = 'Retenção Temporária';
    }else{
        $situacao = 'ag';
        $transaction_situacao = 'Aguardando Pagamento';
    }
    
    $update = mysqli_query($conn, "UPDATE pedidos SET situacao='$situacao', transaction_status='$status', transaction_situacao='$transaction_situacao' WHERE identificacao_pedido='$pedido'");
}

$vb_titulo_site = 'Obrigado pela Solicitação';
$vb_descricao_site = '';
?>
<!doctype html>
<html class="no-js supports-no-cookies" lang="pt-br"> 
<head>
<?require_once "includes/head.php";?>
<?if (isset($_SESSION['pedido'])){?>
<script>
    window.dataLayer = window.dataLayer || [];
    dataLayer.push({ ecommerce: null });
    dataLayer.push({
      event: "purchase",
      ecommerce: {
          transaction_id: "<?=$id;?>",
          affiliation: "<?=$nome_loja;?>",
          value: "<?=$valor_pedido;?>",
          shipping: "<?=$valor_frete;?>",
          currency: "BRL",
          purchase: <?=json_encode($array_comprador);?>,
          items: <?=json_encode($item);?>
      }
    });
</script>
<?}unset($_SESSION['pedido']);?>
</head>
<body id="faqs" class="template-page theme-css-animate" data-currency-multiple="true">
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
<main id="MainContent" style="padding-bottom: 100px;">
    <div class="breadcrumbs mt-15">
        <div class="container">
            <ul class="list-unstyled d-flex flex-wrap align-items-center justify-content-start">
                <li><a href="<?=$url_loja;?>" title="Home"><i class="fa-sharp fa-solid fa-house"></i></a></li>
                <li><span>Obrigado</span></li>
            </ul>
        </div>
    </div>
    <div class="container mt-60">
        <h1 class="h1 mt-30 text-center">Obrigado pela solicitação!</h1><br>
        <h4 class="h4 mt-30 text-center">Ficamos muitos felizes de você ter escolhido a <strong><?=$nome_loja_completa;?></strong>!</h4>
        <h4 class="h4 mt-30 text-center">Enviamos no seu e-mail um resumo do pedido e algumas informações importantes. Em breve um de nossos consultores irá entrar em contato para finalizar.</h4>
    </div>
</main>
<?require_once "includes/footer.php"?>
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