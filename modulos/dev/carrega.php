<?php
require_once("../../config.php");

$params = $columns = $totalRecords = $data = array();

$params = $_REQUEST;

$columns = array(
	0 => 'id',
	1 => 'produto', 
	2 => 'categoria',
	3 => 'preco',
	4 => 'acoes'
);

$where_condition = $sqlTot = $sqlRec = "";

if(!empty($params['search']['value'])) {
	$where_condition .=	" WHERE ";
	$where_condition .= " ( produto LIKE '%".$params['search']['value']."%' ";    
	$where_condition .= " OR id LIKE '%".$params['search']['value']."%' )";
}

$sql_query = " SELECT * FROM produtos ";
$sqlTot .= $sql_query;
$sqlRec .= $sql_query;

if(isset($where_condition) && $where_condition != '') {

	$sqlTot .= $where_condition;
	$sqlRec .= $where_condition;
}

 $sqlRec .=  " ORDER BY ". $columns[$params['order'][0]['column']]."   ".$params['order'][0]['dir']."  LIMIT ".$params['start']." ,".$params['length']." ";

$queryTot = mysqli_query($conexao, $sqlTot) or die("Database Error:". mysqli_error($conexao));

$totalRecords = mysqli_num_rows($queryTot);

$queryRecords = mysqli_query($conexao, $sqlRec) or die("Error to Get the Post details.");

while( $row = mysqli_fetch_row($queryRecords) ) { 
	$data[] = $row;
}	

$json_data = array(
	"draw"            => intval( $params['draw'] ),   
	"recordsTotal"    => intval( $totalRecords ),  
	"recordsFiltered" => intval($totalRecords),
	"data"            => $data
);

echo json_encode($json_data);
?>