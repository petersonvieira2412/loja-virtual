<?
require_once "config.php";
if (!isset($_SESSION['usr_id_cliente'])){$_SESSION['usr_id_cliente'] = '0';}
$id = ((isset($_POST['id']) AND  $_POST['id']!='')?$_POST['id']:'');
$efav = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM favoritos WHERE produto_id='".$id."' AND usuario='".$_SESSION["usr_id_cliente"]."' LIMIT 1"));
if($efav==0){
    mysqli_query($conn,"INSERT INTO favoritos (usuario, produto_id, data, hora, status) VALUES('".$_SESSION["usr_id_cliente"]."','".$id."','".date('Y-m-d')."','".date('H:i:s')."', 'a')");
    $retorno["dados"] = true;
} else {
    mysqli_query($conn,"DELETE FROM favoritos WHERE produto_id='".$id."' AND usuario='".$_SESSION["usr_id_cliente"]."'");
    $retorno["dados"] = false;
}
$total = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM favoritos WHERE usuario='".$_SESSION["usr_id_cliente"]."' AND status='a'"));
$retorno["total"] = $total;
echo json_encode($retorno);