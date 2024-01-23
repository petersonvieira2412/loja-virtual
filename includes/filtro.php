<?php
require_once "config.php";
((isset($_POST["id"]) AND $_POST["id"])?$id = $_POST["id"]:$id = '');
((isset($_POST["marcado"]) AND $_POST["marcado"])?$marcado = $_POST["marcado"]:$marcado = '');

if (isset($id) AND $id!=''){
    if (isset($_SESSION['filtro']) AND is_array($_SESSION['filtro'])){
        if ($marcado=='sim'){
            array_push($_SESSION['filtro'], $id);
        }else{
            $remover = array_search($id, $_SESSION['filtro']);
            if($remover!==false){
                unset($_SESSION['filtro'][$remover]);
                $num = count($_SESSION['filtro']);
                if ($num==0){
                    unset($_SESSION['filtro']);
                }
            }
        }
    }else{
        $_SESSION['filtro'] = array("$id");
    }
    
    if (isset($_SESSION['filtro'])){
        $retorno['conteudo'] = $_SESSION['filtro'];
    }else{
        $retorno['conteudo'] = false;
    }
}

((isset($_POST["preco"]) AND $_POST["preco"])?$preco = $_POST["preco"]:$preco = '');

if (isset($preco) AND $preco=='preco'){
    $_SESSION['preco'] = array($_POST["min"], $_POST["max"]);
    $retorno['conteudo'] = $_SESSION['preco'];
}

echo json_encode($retorno);