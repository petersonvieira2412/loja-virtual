<?
require_once "config.php";
if (!isset($_SESSION['usr_id_cliente'])){$_SESSION['usr_id_cliente'] = '0';}

if(isset($_POST['remover'])){
    $cod = addslashes(htmlentities($_POST['codigo']));
    if (isset($cod) AND $cod !='') {
        if (is_numeric($cod)) {
            $sql_carrinho_excluir = "DELETE FROM carrinho WHERE id = '".$cod."'";
            $exec_carrinho_excluir = mysqli_query($conn, $sql_carrinho_excluir) or die(mysqli_error());
            
            $carZero = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM carrinho WHERE sessao = '".session_id()."' AND id_cliente = '".$_SESSION['usr_id_cliente']."'"));
            
            $qrC = mysqli_query($conn, "SELECT * FROM carrinho WHERE sessao='".session_id()."' AND id_cliente='".$_SESSION['usr_id_cliente']."'");
            $valorTTL = 0;
            while($lnC=mysqli_fetch_array($qrC)){
                $valorTTL += $lnC['preco'] * $lnC['qtd'];
                $_SESSION['total_parcial'] = $valorTTL;
                $retorno["total_parcial"] = $_SESSION['total_parcial'];
            }

            if($carZero==0) {
              unset($_SESSION['cupom_de_desconto']);
              unset($_SESSION['valor_antigo']);
              unset($_SESSION['cupom_exibe']);
              unset($_SESSION['total_parcial']);
              unset($_SESSION['valor_desconto']);
              $retorno["total_parcial"] = 0;
            }
        }
    }
    $retorno["ok"] = true;
    echo json_encode($retorno);
}
?>