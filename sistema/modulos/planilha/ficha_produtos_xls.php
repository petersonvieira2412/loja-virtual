<?php
include_once "config.php";
$nome_pag = $_GET['acao'];

// Aqui o codigo que gera o Excel
$file_type = "vnd.ms-excel";
$file_name= "ficha-produtos-".clean($pnome).".xls";
header("Content-Type: application/$file_type");
header("Content-Disposition: attachment; filename=$file_name");
header("Pragma: no-cache");
header("Expires: 0"); 
// Fim do codigo
?>
<html class="no-js supports-no-cookies" lang="pt-br">
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
</head>
<body>
<table width="100%" style="width:100%;">
    <?
    $sql = "Select p.id, p.produto, p.url_amigavel, p.img, p.descricao, c.categoria, p.preco, p.por from produtos AS p INNER JOIN categorias AS c ON (p.categoria=c.id) where p.status='a' ORDER BY p.id ASC";
    $result = mysqli_query($conexao,$sql) or die("Couldn't execute query:<br>" . mysqli_error(). "<br>" . mysqli_errno());
    $names = mysqli_fetch_fields($result);
    
    echo "<tr><td>ID,ID2,Item title,Final URL,Image URL,Item subtitle,Item description,Item category,Price,Sale price,Contextual keywords,Item address,Tracking template,Custom parameter,Final mobile URL,Android app link,iOS app link,iOS app store ID</td></tr>";
    
    while($row = mysqli_fetch_assoc($result)) {?>
        <tr>
            <?
            $id = $row['id'];
            $produto = str_replace(",", ".", $row['produto']);
            $url = $psite."/produto/".$row['url_amigavel'];
            $img = $psite."/assets/img/produtos/".$row['img'];
            $descricao = str_replace(",", ".", strip_tags(html_entity_decode(base64_decode($row['descricao']))));
            $categoria = $row['categoria'];
            $preco = $row['preco'].' BRL';
            $por = $row['por'].' BRL';
            echo "<td>".$id.",,".charset_decode_utf_8($produto).",".$url.",".$img.",,".charset_decode_utf_8($descricao).",".$categoria.",".$preco.",".$por.",,,,,,,</td>";
            ?>
        </tr>
    <?}?>
</table>
</body>
</html>