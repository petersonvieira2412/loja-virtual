<?php

include_once "config.php";

$nome_pag = $_GET['acao'];

// Aqui o codigo que gera o Excel
$file_type = "csv";
$file_name= "catalogo-".$nome_pag."-".clean($pnome).".csv";
header("Content-Type: application/$file_type");
header("Content-Disposition: attachment; filename=$file_name");
header("Pragma: no-cache");
header("Expires: 0"); 
// Fim do codigo
?>

<style type="text/css">
.style1 {
    color: #000;
    font-size: 13pt;
}
</style>

<table width="1600" border="1" cellspacing="2" cellpadding="1">
  <tr>
    <?
    if ($nome_pag=='produtos'){
        $sql = "Select id, produto, preco, por, descricao from $nome_pag where status='a'";
    }else{
        $sql = "Select id, categoria, titulo_site, descricao_site, meta_site from $nome_pag where status='a'";
    }
    $result = mysqli_query($conexao,$sql) or die("Couldn't execute query:<br>" . mysqli_error(). "<br>" . mysqli_errno());
    $names = mysqli_fetch_fields($result);
    foreach($names as $name){?>
        <td style="width: max-content;" bgcolor="#fff"><div align="center" class="style1"><b><?=$name->name;?></b></div></td>
    <?}?>
  </tr>
  
  <?while($row = mysqli_fetch_row($result)) {?>
    <tr style="vertical-align: middle; text-align: center;">
        <?for($j=0; $j<mysqli_num_fields($result); $j++) {
            if($nome_pag=='produtos'){
                if($j==4){
                    $row[$j] = strip_tags(html_entity_decode(base64_decode($row[$j])));
                }
            }
            echo "<td>".$row[$j]."</td>";
        }?>
    </tr>
  <?}?>
</table>