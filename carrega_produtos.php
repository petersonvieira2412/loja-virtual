<?php
require_once "config.php";
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value

if($_POST['columns'][$columnIndex]['data']=='acoes'){
    $orderBy = '';
}else{
    if($_POST['columns'][$columnIndex]['data']=='imagem'){
        $coluna = 'img';
    }elseif($_POST['columns'][$columnIndex]['data']=='preço'){
        $coluna = 'preco';
    }else{
        $coluna = $_POST['columns'][$columnIndex]['data'];
    }
    $orderBy = "ORDER BY p.".$coluna." ".$_POST['order'][0]['dir'];    
}

$searchArray = array();
$searchQuery = "";
if($searchValue != ''){
    $searchQuery = " AND (p.id LIKE '%$searchValue%' OR p.produto LIKE '%$searchValue%' OR p.preco LIKE '%$searchValue%' ) ";
}

$stmt = $conexao->query("SELECT COUNT(p.id) AS total FROM produtos AS p INNER JOIN categorias AS c ON (p.categoria=c.id) WHERE p.status='a' ".$searchQuery.$orderBy);
$records = $stmt->fetch_assoc();
$totalRecordwithFilter = $records['total'];
$stmt->free_result();

$query = $conexao->query("SELECT p.id, p.img, p.produto, c.categoria, p.preco, p.por FROM produtos AS p INNER JOIN categorias AS c ON (p.categoria=c.id) WHERE p.status='a' $searchQuery $orderBy LIMIT $row, $rowperpage");
$num_rows = $query->num_rows;
if ($num_rows>0){
    while ($dados = $query->fetch_assoc()){
        $id = $dados['id'];
        $img = $dados['img'];
        $produto = $dados['produto'];
        $categoria = $dados['categoria'];
        
        $pagina_referencia = "produtos";
        if ($img=='') {
            $imagem = '../assets/images/'.$pagina_referencia.'/sem_imagem.jpg';
        } elseif(file_exists('../assets/images/'.$pagina_referencia.'/'.$img.'')){
            $imagem = '../assets/images/'.$pagina_referencia.'/'.$img.'';
        } else {
            $imagem = "../assets/images/$pagina_referencia/sem_imagem.jpg";
        }
        $data[] = array(
            "id"=>$id,
            "imagem"=> '<img src="'.$imagem.'" alt="'.$produto.'" title="'.$produto.'" class="gridpic">',
            "produto"=>$produto,
            "categoria"=>$categoria,
            "preço"=> "R$ ".number_format($dados['preco'], 2, '.', ','),
            "acoes"=> '<div class="socials tex-center"> 
                            <a href="'.$pagina_referencia.'-clonar_'.$id.'" class="btn btn-circle btn-success" title="Clonar"><i class="fa fa-clone"></i></a> 
                            <a href="'.$pagina_referencia.'-editar_'.$id.'" class="btn btn-circle btn-primary" title="Editar"><i class="fa fa-pencil"></i></a> 
                            <a href="#" class="btn btn-circle btn-danger " data-toggle="modal" data-target="#myModal'.$id.'" title="Excluir"><i class="fa fa-close"></i></a> 
                            <div class="modal fade" id="myModal'.$id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel3">REMOVER ITEM</h4>
                                        </div>
                                        <div class="modal-body">Confirma a exclusão deste item? </div>
                                        <div class="modal-footer">
                                            <a href="'.$pagina_referencia.'-excluir_'.$id.'" class="btn btn-danger" role="button" aria-pressed="true">SIM</a>
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">NÃO</button>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>'
        );
    }
    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecordwithFilter,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $data
    );
    echo json_encode($response);
    exit;
}else{
    $data[] = array(
        "id"=> "<h5>Nada encontrado!</h5>",
        "imagem"=> "",
        "produto"=> "",
        "categoria"=> "",
        "preço"=> "",
        "acoes"=> ""
    );
    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecordwithFilter,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $data
    );
    echo json_encode($response);
    exit;
}