<?php
require_once "config.php";

$sql = mysqli_query($conn, "SELECT id, tamanho, qtd FROM produtos WHERE status='a' AND cor!=''");
while ($dados = mysqli_fetch_assoc($sql)){
    $tamanho = $dados['tamanho'];
    echo $tamanho;
}

/*$sql = mysqli_query($conn, "SELECT variacao, id FROM variacoes WHERE titulo='Cor'");
while ($dados = mysqli_fetch_assoc($sql)){
    $id = $dados['id'];
    $titulo = ltrim($dados['variacao']);
    $matriz[$titulo] = $id;
}

$sql = mysqli_query($conn, "SELECT id, cor, qtd FROM produtos WHERE status='a' AND cor!=''");
while ($dados = mysqli_fetch_assoc($sql)){
    $id = $dados['id'];
    $qtd = $dados['qtd'];
    $cores = explode(',', $dados['cor']);
    foreach($cores as $cor){
        $sql_variacao = mysqli_query($conn, "SELECT id, variacao, rgb FROM variacoes WHERE titulo='Cor' AND variacao='$cor'");
        $dados_variacao = mysqli_fetch_assoc($sql_variacao);
        $id_variacao = $dados_variacao['id'];
        $rgb = $dados_variacao['rgb'];
        
        $insere = mysqli_query($conn, "INSERT INTO estoque (id_variacao, id_pai, id_produto, qtd, rgb, status) VALUES ('$id_variacao', '0', '$id', '$qtd', '$rgb', 'a')");
        if ($insere){
            echo "Estoque atualizado com sucesso";
        }else{
            echo "Erro ao atualizar o estoque";
        }
        mysqli_free_result($sql_variacao);
    }
}*/