<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDirectory = '../../'.$_POST['diretorio']; // Diretório onde as imagens serão salvas
    $img_secundaria = $uploadDirectory.$_POST['img_secundaria'];
    $produto = $_POST['produto'];
    $arquivos = glob("$uploadDirectory{*.jpg,*.png,*.gif,*.bmp,*.webp}", GLOB_BRACE);
    $conta = count($arquivos);
    $totalFiles = count($_FILES['imagens']['name']);
    if ($img_secundaria!='' AND file_exists($img_secundaria) AND $_POST['img_secundaria']!='sem_imagem.jpg'){
        $conta -= 1;
    }
    
    if ($conta+$totalFiles>8){
        $uploadedFiles[] = array('resultado' => 'erro', 'mensagem' => 'Máximo de 8 arquivos!');
        echo json_encode($uploadedFiles);
        exit;
    }else{

        // Verifica se o diretório de upload existe e, se não existir, tenta criá-lo
        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }
    
        // Verifica se alguma imagem foi enviada
        if (isset($_FILES['imagens']) && !empty($_FILES['imagens']['name'][0])) {
            $uploadedFiles = array();
    
            // Loop para processar cada imagem enviada
            for ($i = 0; $i < $totalFiles; $i++) {
                $fileName = $_FILES['imagens']['name'][$i];
                $tmpName = $_FILES['imagens']['tmp_name'][$i];
                $fileSize = $_FILES['imagens']['size'][$i];
                $fileError = $_FILES['imagens']['error'][$i];
                $fileType = $_FILES['imagens']['type'][$i];
    
                // Verifica se houve erro no upload
                if ($fileError !== UPLOAD_ERR_OK) {
                    $uploadedFiles[] = array('resultado' => 'erro', 'mensagem' => 'Erro no upload: ' . $fileError);
                    echo json_encode($uploadedFiles);
                    exit;
                }
    
                // Move a imagem para o diretório de upload
                $destination = $uploadDirectory.$fileName;
                if (move_uploaded_file($tmpName, $destination)) {
                    $i_temp = $i+1;
                    $aleatorio = rand(1,999999);
                    $nome_final = $produto."-".$i_temp."-".$aleatorio;
                    $nova_imagem = $nome_final.'.webp';
                    if ($fileType=="image/png"){
                        $img = imagecreatefrompng($destination);
                        imagepalettetotruecolor($img);
                        imagealphablending($img, true);
                        imagesavealpha($img, true);
                        $img_produto = imagewebp($img, $uploadDirectory.$nova_imagem, 80);
                        unlink($destination);
                    }elseif($fileType=="image/jpg" || $fileType=="image/jpeg"){
                        $img = imagecreatefromjpeg($destination);
                        imagepalettetotruecolor($img);
                        imagealphablending($img, true);
                        imagesavealpha($img, true);
                        $img_produto = imagewebp($img, $uploadDirectory.$nova_imagem, 80);
                        unlink($destination);
                    }elseif($fileType=="image/webp"){
                        rename($_FILES['destaque']['tmp_name'], $uploadDirectory.$nova_imagem);
                    }
                    
                    $uploadedFiles[] = array('resultado' => 'sucesso', 'mensagem' => 'Upload realizado com sucesso');
                } else {
                    $uploadedFiles[] = array('resultado' => 'erro', 'mensagem' => 'Falha ao mover o arquivo para o diretório de upload');
                }
            }
    
            // Retornar a mensagem de sucesso ou falha
            echo json_encode($uploadedFiles);
        } else {
            echo json_encode(array('resultado' => 'erro', 'mensagem' => 'Nenhuma imagem foi enviada.'));
        }
    }
} else {
    echo json_encode(array('resultado' => 'erro', 'mensagem' => 'Método de requisição inválido.'));
}
?>