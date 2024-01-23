<?
require_once "config.php";
if(isset($_POST['atualiza_cadastro']) AND $_POST['atualiza_cadastro']=='atualiza_cadastro'){
    $nome = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['nome'], MB_CASE_TITLE, "UTF-8"))));
    $cpf = trim(addslashes($_POST['cpf']));
    $email = trim(addslashes($_POST['email']));
    $celular = trim(addslashes($_POST['celular']));
    $cep = trim(addslashes($_POST['cep']));
    $endereco = trim(addslashes(htmlspecialchars($_POST['endereco'])));
    $numero = trim(addslashes($_POST['numero']));
    $complemento = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['complemento'], MB_CASE_TITLE, "UTF-8"))));
    $bairro = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['bairro'], MB_CASE_TITLE, "UTF-8"))));
    $cidade = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['cidade'], MB_CASE_TITLE, "UTF-8"))));
    $estado = trim(addslashes(htmlspecialchars(mb_convert_case($_POST['estado'], MB_CASE_UPPER, "UTF-8"))));
    
    $update = "UPDATE clientes SET responsavel_nome='$nome', cpf_cnpj='$cpf', email='$email', celular='$celular', cep='$cep', endereco='$endereco', numero='$numero', complemento='$complemento', bairro='$bairro', cidade='$cidade', estado='$estado' WHERE id='".$_SESSION["usr_id_cliente"]."' AND status='a'" or die(mysqli_error());
    $executa = mysqli_query($conn, $update);
    if ($executa) {
        $retorno["ok"] = 'sucesso';
        $retorno["mensagem"] = 'Cadastro Atualizado com Sucesso!';
        echo json_encode($retorno);
        exit();
    }else{
        $retorno["ok"] = 'falha';
        $retorno["mensagem"] = 'Erro ao Atualizar Cadastro, tente novamente!';
        echo json_encode($retorno);
        exit();
    }
}
if(isset($_POST['atualiza_imagem_perfil']) AND $_POST['atualiza_imagem_perfil']=='atualiza_imagem_perfil'){
    if (file_exists($_FILES['imagem_perfil']['tmp_name']) || is_uploaded_file($_FILES['imagem_perfil']['tmp_name'])) {
        $aleatorio = rand(1,999999);
        $nome = "perfil-".$_SESSION['usr_id_cliente']."-".clean($_SESSION["usr_nome_cliente"]).'-'.$aleatorio;
        $pagina_referencia = "clientes";
        $tamanho_maximo = 1048576;
        $set_img_path = "../assets/img/".$pagina_referencia;
        $imgarray = array("image/pjpeg", "image/jpeg", "image/gif", "image/png", "image/x-png");
        if (!in_array($_FILES['imagem_perfil']['type'],$imgarray)){
            $retorno["ok"] = 'falha';
            $retorno["mensagem"] = 'Aceito somente arquivos jpg, jpeg e png.';
            echo json_encode($retorno);
            exit();
        }   
        if ($_FILES['imagem_perfil']['size']>$tamanho_maximo){
          echo "<p>Tamanho do Arquivo é maior que o limite de:</p>". $tamanho_maximo / 1000 ."Kb.";
            $retorno["ok"] = 'falha';
            $retorno["mensagem"] = 'Tamanho do Arquivo é maior que o limite de:</p>'. $tamanho_maximo / 1000 .'Kb';
            echo json_encode($retorno);
            exit();
        }   
        if ($_FILES['imagem_perfil']['type']=="image/gif"){
            $ext = ".gif";
        }
        elseif ($_FILES['imagem_perfil']['type']=="image/jpeg" || $_FILES['imagem_perfil']['type']=="image/pjpeg"){
            $ext = ".jpg";
        }
        elseif ($_FILES['imagem_perfil']['type']=="image/png"){
            $ext = ".png";
        }
        
        $img = $nome.$ext;
        move_uploaded_file($_FILES['imagem_perfil']['tmp_name'], "$set_img_path/$img");
        chmod ("$set_img_path/$img", 0755);
        
        $imagem = $set_img_path.'/'.$img;
        $nome_imagem = explode('.', $img);
        $nova_imagem = $nome_imagem[0].'.webp';
        $dir = $set_img_path.'/';
        
        if ($ext=='.png'){
            $img = imagecreatefrompng($imagem);
        }else{
            $img = imagecreatefromjpeg($imagem);
        }
        imagepalettetotruecolor($img);
        imagealphablending($img, true);
        imagesavealpha($img, true);
        $img = imagewebp($img, $dir.$nova_imagem, 80);
        unlink($imagem);
        
        $update = "UPDATE $pagina_referencia SET foto='".$nova_imagem."' WHERE id='".$_SESSION['usr_id_cliente']."' "  or die(mysqli_error());
        if (!mysqli_query($conn, $update)) { die('Erro: '.mysqli_error($conn)); }else{
            $_SESSION["usr_foto_cliente"] = $nova_imagem;
            $retorno["ok"] = 'sucesso';
            $retorno["img"] = $dir.$nova_imagem;
            $retorno["mensagem"] = 'Upload feito com sucesso!';
            echo json_encode($retorno);
            exit();
        }
    }
}
?>