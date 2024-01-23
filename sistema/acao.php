<?
require_once "config.php";
if(isset($_POST['excluir'])){
    $flag = $_POST['flag'];
    $foto = $_POST['foto_excluir'];
    $id = $_POST['id'];
    $excessao = ((isset($_POST['excessao']) AND $_POST['excessao']!='')?$_POST['excessao']:'');
    if ($flag=='excluir_todas_imagens'){
        $diretorio = '../assets/img/produtos/'.$id.'/';
        
        if (is_dir($diretorio)) {
            $files = scandir($diretorio);
            $files = array_diff($files, array('.', '..'));
           
            foreach ($files as $file) {
               
                $fileToDelete = $diretorio.$file;
        
                if (is_file($fileToDelete) AND $file!==$excessao AND $excessao!='sem_imagem.jpg') {
                    unlink($fileToDelete);
                }
            }
            if (count(scandir($diretorio)) < 1) {
                rmdir($diretorio);
            }
        }
        $dados = true;
        $retorno["dados"] = $dados;
 
        $img = "";
        $sql_estoque = mysqli_query($conexao, "UPDATE estoque SET img_ancora='' WHERE produto='$id'");
    }elseif ($flag=='excluir_destaque'){
        if(unlink($foto)){
            $dados = true;
            $retorno["dados"] = $dados;
            $retorno["conteudo"] = "../assets/img/produtos/sem_imagem.jpg";
            $nome_foto = end(explode('/', $foto));
            $sql_estoque = mysqli_query($conexao, "UPDATE estoque SET img_ancora='' WHERE img_ancora='$nome_foto' AND produto='$id'");
        } else{
            echo "<script>alert('Houve um erro ao deletar o arquivo!');</script>";
            $dados = false;
            $retorno["dados"] = $dados;
        }
    }elseif ($flag=='excluir_secundaria'){
        if(unlink($foto)){
            $dados = true;
            $retorno["dados"] = $dados;
            $retorno["conteudo"] = "../assets/img/produtos/sem_imagem.jpg";
            $nome_foto = end(explode('/', $foto));
            $sql_estoque = mysqli_query($conexao, "UPDATE estoque SET img_ancora='' WHERE img_ancora='$nome_foto' AND produto='$id'");
        } else{
            echo "<script>alert('Houve um erro ao deletar o arquivo!');</script>";
            $dados = false;
            $retorno["dados"] = $dados;
        }
    }elseif ($flag=='excluir_imagem'){
        if(unlink($foto)){
            $dados = true;
            $retorno["dados"] = $dados;
            $conteudo = explode('-', $foto);
            $conteudo = end($conteudo);
            $conteudo = explode('.', $conteudo);
            $retorno["conteudo"] = $conteudo[0];
            $nome_foto = end(explode('/', $foto));
            $sql_estoque = mysqli_query($conexao, "UPDATE estoque SET img_ancora='' WHERE img_ancora='$nome_foto' AND produto='$id'");
        } else{
            $dados = false;
            $retorno["dados"] = $dados;
        }
    }
  echo json_encode($retorno);
  exit();
}
?>