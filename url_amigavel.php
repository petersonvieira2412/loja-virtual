<?php
require_once "config.php";
if (isset($_POST['url_amigavel']) AND $_POST['url_amigavel']=='url_amigavel'){
    function UrlAmigavel($str, $replace=array(), $delimiter='-') {
        if( !empty($replace) ) {
          $str = str_replace((array)$replace, ' ', $str);
        }
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
        $clean = substr($clean, 0, 120);
        return $clean;
    }
    $valor = ((isset($_POST['valor']))?UrlAmigavel($_POST['valor']):'');
    $tabela = ((isset($_POST['tabela']))?$_POST['tabela']:'');
    $id = ((isset($_POST['id']))?$_POST['id']:'');
    $query = $conexao->query("SELECT url_amigavel, id FROM $tabela WHERE url_amigavel='$valor' AND status='a'");
    if ($query->num_rows>0){
        $row = $query->fetch_assoc();
        if ($row['id']==$id){
            $retorno["ok"] = 'sucesso';
            $retorno["mensagem"] = '';
        }else{
            $retorno["ok"] = 'falha';
            $retorno["mensagem"] = 'Indisponível!';
        }
        $retorno["conteudo"] = $valor;
        echo json_encode($retorno);
        exit;
    }else{
        $retorno["ok"] = 'sucesso';
        if ($valor!=''){
            $retorno["mensagem"] = 'Disponível!';
        }else{
            $retorno["mensagem"] = 'Indisponível!';
        }
        $retorno["conteudo"] = $valor;
        echo json_encode($retorno);
        exit;
    }
    $conexao->close();
}else{
    function UrlAmigavel($str, $replace=array(), $delimiter='-') {
        if( !empty($replace) ) {
          $str = str_replace((array)$replace, ' ', $str);
        }
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
        $clean = substr($clean, 0, 120);
        return $clean;
    }
    $valor = ((isset($_POST['valor']))?UrlAmigavel($_POST['valor']):'');
    $retorno["ok"] = 'sucesso';
    $retorno["mensagem"] = UrlAmigavel($valor);
    echo json_encode($retorno);
    exit;
}
echo json_encode($retorno);