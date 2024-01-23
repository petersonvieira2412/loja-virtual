<?php
require_once "config.php";

$cupom = $_POST["cupom"];
$soma_carrinho = $_POST["soma_carrinho"];

$select_cupom = "SELECT * FROM cupons WHERE cupom='$cupom' AND validade_inicio<='".date("Y-m-d")."' AND validade_fim>='".date("Y-m-d")."' AND qtd>0 AND status='a' LIMIT 1";
$executa_cupom = mysqli_query($conn, $select_cupom);
$qtd_cupons = mysqli_num_rows($executa_cupom);
if ($qtd_cupons>0){
   if($cupom!=''){
		$_SESSION['cupom_de_desconto'] = $cupom;
        while ($dados_cupom = mysqli_fetch_assoc($executa_cupom)) {
            $cupom = $dados_cupom['cupom'];
            $desconto = $dados_cupom['cupom_desconto'];
            $tipo_desconto = $dados_cupom['cupom_tipo'];

            if ($tipo_desconto=='1') {
                $preco_original = $soma_carrinho; // Preço Original do produto
                $calculo = ($preco_original)-($desconto) ; //Subtração do valor
                $valor = $calculo;
                 $_SESSION['total_parcial'] = 'R$ '.number_format($valor,2,',','.');
                if ($cupom=='') {
                    $cupom_exibe='';
                }else{
                    $cupom_exibe = 'CUPOM APLICADO: <button type="submit" name="remover_cupom" class="btn">'.$cupom.' X</button>';
                    $_SESSION['cupom_exibe'] = $cupom_exibe;
                }
                $valor_antigo = 'R$ '.number_format($preco_original,2,',','.');
                $_SESSION['valor_antigo'] = $valor_antigo;
                $_SESSION['valor_desconto'] = $desconto;
                $_SESSION['cupom_tipo'] = $tipo_desconto;
            }elseif($tipo_desconto=='2'){
                $preco_original = $soma_carrinho; // Preço Original do produto
                $calculo = ($preco_original)*($desconto)/100 ; //Multiplicação do valor e desconto dividido por 100
                $valor = ($preco_original)-($calculo); // Para não negativar eu fiz essa subtração
                $_SESSION['total_parcial'] = 'R$ '.number_format($valor,2,',','.');
                if ($cupom=='') {
                    $cupom_exibe='';
                }else{
                    $cupom_exibe = 'CUPOM APLICADO: <button type="submit" name="remover_cupom" class="btn">'.$cupom.' X</button>';
                    $_SESSION['cupom_exibe'] = $cupom_exibe;
                }
                $valor_antigo = 'R$ '.number_format($preco_original,2,',','.');
                $_SESSION['valor_antigo'] = $valor_antigo;
                $_SESSION['valor_desconto'] = $desconto;
                $_SESSION['cupom_tipo'] = $tipo_desconto;
            }else{
                if (!isset($exibe_preco)){$exibe_preco='';}
                $_SESSION['total_parcial'] = $exibe_preco;
            }
        }
    }else{
        if (!isset($exibe_preco)){$exibe_preco='';}
        unset($_SESSION['cupom_de_desconto']);
    }
    $retorno["cupom"] = 'sim';
    $retorno["valor_antigo"] = $_SESSION['valor_antigo'];
    $retorno["valor_desconto"] = $_SESSION['valor_desconto'];
    $retorno["cupom_tipo"] = $_SESSION['cupom_tipo'];
}else{
    $retorno["cupom"] = 'nao';
}
$retorno["sql"] = $select_cupom;
echo json_encode($retorno);