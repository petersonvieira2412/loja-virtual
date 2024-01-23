<?php
require_once "config.php";
$usr_id = $_SESSION["usr_id_cliente"];
// $usr_id='1';

$usr_id = trim(addslashes(htmlspecialchars($_POST['id'])));
((isset($_POST['nomeend']))?$nomeend = trim(addslashes(htmlspecialchars($_POST['nomeend']))):$nomeend = 'padrao');
$cep = trim(addslashes(htmlspecialchars($_POST['cep'])));
$logradouro = trim(addslashes(htmlspecialchars($_POST['logradouro'])));
$numero = trim(addslashes(htmlspecialchars($_POST['numero'])));
$complemento = trim(addslashes(htmlspecialchars($_POST['complemento'])));
$bairro = trim(addslashes(htmlspecialchars($_POST['bairro'])));
$cidade = trim(addslashes(htmlspecialchars($_POST['cidade'])));
$estado = trim(addslashes(htmlspecialchars($_POST['estado'])));
$pontoreferencia = trim(addslashes(htmlspecialchars($_POST['pontoreferencia'])));
$freteID=trim(addslashes(htmlspecialchars($_POST['freteID'])));
$freteAID=trim(addslashes(htmlspecialchars($_POST['freteAID'])));

// $nomeend = 'Rua Equador';
// $cep = '12030-470';
// $logradouro = 'Rua Equador';
// $numero = '300';
// $complemento = '';
// $bairro = 'Jardim das Nações';
// $cidade = 'Taubaté';
// $estado = 'SP';
// $pontoreferencia = '';
// $freteID='1';
// $freteAID='1';
	
$sql = "SELECT * FROM clientes WHERE id = '".$usr_id."' AND status='a'";
$query = mysqli_query($conn, $sql);
if($query>0){
  while($valor=mysqli_fetch_array($query)){
    $id = $valor['id'];
    $responsavel_nome = $valor['responsavel_nome'];
    $sobrenome = $valor['sobrenome'];
    $celular = $valor['celular'];
    $email = $valor['email'];
    $cpf_cnpj = $valor['cpf_cnpj'];
	}
}
$sql2 = "SELECT *, carrinho.preco, carrinho.qtd AS qtd FROM carrinho AS carrinho INNER JOIN produtos AS produtos ON (carrinho.cod = produtos.id) WHERE carrinho.sessao = '".session_id()."'";
$retorno["sql"] = $sql2;
	$qr = mysqli_query($conn,$sql2);
if ($qr > 0) {
  while($valor = mysqli_fetch_assoc($qr)){
    $produto_id = $valor['id'];
    $produto_nome = $valor['nome'];
    $produto_qtd = $valor['qtd'];
    $preco = $valor['preco'];
    $preco_final = $preco * $produto_qtd;
    $produto_altura = $valor['altura'];
    $produto_largura = $valor['largura'];
    $produto_comprimento = $valor['comprimento'];
    $produto_peso = $valor['peso'];
  }
}

$arrC = array();
$qr = mysqli_query($conn,"SELECT *, tb1.qtd AS qtd FROM carrinho AS tb1 INNER JOIN produtos AS tb2 ON(tb1.cod=tb2.id) WHERE tb1.sessao='".session_id()."'");
while($ln=mysqli_fetch_array($qr)){
    $peso = $ln['peso'];
    $arrP = array();
    $arrP["name"] = $ln['nome'];
    $arrP["quantity"] = $ln['qtd'];
    $arrP["unitary_value"] = $ln['preco'];
    
    array_push($arrC, $arrP);
}

$arrV = array();
$qr = mysqli_query($conn, "SELECT *, tb1.qtd AS qtd FROM carrinho AS tb1 INNER JOIN produtos AS tb2 ON(tb1.cod=tb2.id) WHERE tb1.sessao='".session_id()."'");
while($ln=mysqli_fetch_array($qr)){
    $peso = $ln['peso'];
    $arrL = array();
    $arrL["height"] = $ln['altura'];
    $arrL["width"] = $ln['largura'];
    $arrL["length"] = $ln['comprimento'];
    $arrL["weight"] = $peso;
    
    array_push($arrV, $arrL);
}

$validacao = strpos($cpf_cnpj, '/');
if ($validacao == false){
    $cpf = clean($cpf_cnpj);
    $cnpj = '';
    $company = 'document';
    $company_document = $cpf;
}else{
    $cpf = '';
    $cnpj = clean($cpf_cnpj);
    $company = 'company_document';
    $company_document = $cnpj;
}

$fields = array(
  "service" => $freteID,
  "agency" => $freteAID,
  "from" => array("name" => "$nome_loja_completa", "phone" => "$telefone_loja_whats", "email" => "$email_loja", "document" => "", "company_document" => "$cnpj_loja", "state_register" => "", "address" => "$endereco_loja", "complement" => "", "number" => "$numero_loja", "district" => "", "city" => "$cidade_loja", "country_id" => "BR", "postal_code" => "$cep_loja", "note" => ""),
  "to" => array("name" => "$responsavel_nome $sobrenome", "phone" => "$celular", "email" => "$email", "$company" => "$company_document", "state_register" => "", "address" => "$logradouro", "complement" => "$complemento", "number" => "$numero", "district" => "$bairro", "city" => "$cidade", "state_abbr" => "$estado", "country_id" => "BR", "postal_code" => "$cep", "note" => "" ),
  "products" => $arrC,
  "volumes" => $arrL,
  "options" => array("insurance_value" => $preco_final, "receipt" => false, "own_hand" => false, "reverse" => false, "non_commercial" => false, "invoice" => array("key" => "31190307586261000184550010000092481404848162"), "platform" => "", "tags" => array(array("tag" => "x", "url" => "$url_loja")))
);
  $retorno["arrFields"] = $fields;

	$fields = json_encode($fields);
	

$curl = curl_init();

  curl_setopt($curl, CURLOPT_URL, 'https://melhorenvio.com.br/api/v2/me/cart');
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_ENCODING, '');
  curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
  curl_setopt($curl, CURLOPT_TIMEOUT, 0);
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
  curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Accept: application/json',
    'Content-Type: application/json',
    'Authorization: Bearer '.$token_frete.'',
    'User-Agent: Aplicação (email para contato técnico)'
  ));

$response = curl_exec($curl);

curl_close($curl);
// echo $response;
?>