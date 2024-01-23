<?
if(isset($_POST['excluir_imagem']) AND $_POST['excluir_imagem']=='excluir_imagem'){
    $arquivo = $_POST['arquivo'];
  
    $directory = $arquivo;
    unlink($arquivo);
    $dados = true;
    $retorno["dados"] = $dados;

  echo json_encode($retorno);
}
?>