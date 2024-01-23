<?php
include_once "config.php";

function convertToEncoding($value, $encoding) {
    return mb_convert_encoding($value, $encoding, 'UTF-8');
}

$file_name = "ficha-produtos-".clean($pnome).".csv";
$encoding = 'ISO-8859-1';

header('Content-Encoding: ' . $encoding);
header("Content-Type: text/csv; charset=$encoding");
header("Content-Disposition: attachment; filename=$file_name");
header("Pragma: no-cache");
header("Expires: 0");

echo convertToEncoding("ID,ID2,Item title,Final URL,Image URL,Item subtitle,Item description,Item category,Price,Sale price,Contextual keywords,Item address,Tracking template,Custom parameter,Final mobile URL,Android app link,iOS app link,iOS app store ID", $encoding)."\r\n";

$sql = "SELECT p.id, p.produto, p.url_amigavel, p.img, p.descricao, c.categoria, p.preco, p.por FROM produtos AS p INNER JOIN categorias AS c ON (p.categoria=c.id) WHERE p.status='a' ORDER BY p.id ASC";
$result = mysqli_query($conexao, $sql) or die("Couldn't execute query:<br>" . mysqli_error() . "<br>" . mysqli_errno());

while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['id'];
    $produto = str_replace(",", ".", $row['produto']);
    $url = $psite . "/produto/" . $row['url_amigavel'];
    $img = $psite . "/assets/img/produtos/" . $row['img'];
    $descricao = str_replace(array(",", "\r", "\n"), array(".", "", ""), strip_tags(html_entity_decode(base64_decode($row['descricao']))));
    $categoria = $row['categoria'];
    $preco = $row['preco'] . ' BRL';
    $por = $row['por'] . ' BRL';
    
    echo convertToEncoding("$id,,\"$produto\",$url,$img,,\"$descricao\",$categoria,$preco,$por,,,,,,", $encoding) . "\r\n";
}

mysqli_free_result($result);
mysqli_close($conexao);
?>