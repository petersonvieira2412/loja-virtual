<?php
require_once "config.php";
require_once "funcoes.php";

$id = $_POST["id"];
$valor = $_POST["valor"]; //qtd
$preco_produto = $_POST["preco_produto"];
$total_parcial = $_POST["total_parcial"];
$estoque = $_POST["estoque"];
if ($estoque=='0'){$estoque='';}
$cod = $_POST["cod"];

if ($valor<1){
    $valor=1;
}

$sql_qtd = mysqli_query($conn, "SELECT qtd FROM estoque WHERE id='$estoque' AND status='a' LIMIT 1");
$dados_qtd = mysqli_fetch_assoc($sql_qtd);
if (mysqli_num_rows($sql_qtd)<1){
    $sql_qtd = mysqli_query($conn, "SELECT qtd, qtd_minimo FROM produtos WHERE id='$cod' AND status='a' LIMIT 1");
    $dados_qtd = mysqli_fetch_assoc($sql_qtd);
}

if (isset($dados_qtd['qtd_minimo']) AND $valor<$dados_qtd['qtd_minimo']){
    $valor = $dados_qtd['qtd_minimo'];
    $retorno["qtd_minimo"] = $valor;
}
$qtd_real = $dados_qtd['qtd'];

if ($valor<=$qtd_real){
    $retorno["estoque"] = 'sim';
}else{
    $valor = $qtd_real;
    $retorno["qtd_real"] = $valor;
    $retorno["estoque"] = 'nao';
}

$update_sql = "UPDATE carrinho SET qtd='$valor' WHERE id='$id'";
if(mysqli_query($conn, $update_sql)){
    $preco_final = $preco_produto*$valor;
    $preco_final = 'R$ '.number_format($preco_final, 2, ',', '.');
	$retorno["preco_final"] = $preco_final;
	
	if (isset($_SESSION["usr_id_cliente"]) AND $_SESSION["usr_id_cliente"]>0){
        $qrC = mysqli_query($conn, "SELECT * FROM carrinho WHERE sessao='".session_id()."' AND id_cliente='".$_SESSION['usr_id_cliente']."'");
	}else{
        $qrC = mysqli_query($conn, "SELECT * FROM carrinho WHERE sessao='".session_id()."'");
	}
    $valorTTL = 0;
    while($lnC=mysqli_fetch_array($qrC)){
        $valorTTL += $lnC['preco'] * $lnC['qtd'];
    }
    if(isset($_SESSION['cupom_de_desconto']) AND $_SESSION['cupom_de_desconto']!=''){
        if ($_SESSION['cupom_tipo']=='1') {
            $preco_original = $valorTTL; // Preço Original do produto
            $calculo = ($preco_original)-($_SESSION['valor_desconto']) ; //Subtração do valor
            $valor = $calculo;
            $_SESSION['total_parcial'] = 'R$ '.number_format($valor,2,',','.');
            if ($_SESSION['cupom_de_desconto']=='') {
                $cupom_exibe='';
            }else{
                $cupom_exibe = $_SESSION['cupom_exibe'];
            }
            $valor_antigo = 'R$ '.number_format($preco_original,2,',','.');
        }elseif($_SESSION['cupom_tipo']=='2'){
            $preco_original = $valorTTL; // Preço Original do produto
            $calculo = ($preco_original)*($_SESSION['valor_desconto'])/100 ; //Multiplicação do valor e desconto dividido por 100
            $valor = ($preco_original)-($calculo); // Para não negativar eu fiz essa subtração
            $_SESSION['total_parcial'] = 'R$ '.number_format($valor,2,',','.');
            if ($_SESSION['cupom_de_desconto']=='') {
                $cupom_exibe='';
            }else{
                $cupom_exibe = $_SESSION['cupom_exibe'];
            }
            $valor_antigo = 'R$ '.number_format($preco_original,2,',','.');
        }
        $_SESSION['total_parcial'] = $valor;
        $total_parcial = $valor;
        $retorno["total_parcial"] = $total_parcial;
        $retorno["cupom"] = $preco_original;
    }else{
        $_SESSION['total_parcial'] = $valorTTL;
        $total_parcial = $valorTTL;
        $retorno["total_parcial"] = $total_parcial;
        $retorno["cupom"] = 'nao';
    }
}
echo json_encode($retorno);