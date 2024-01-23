<?php
require_once "config.php";

if (!isset($_POST['acao'])) {
	$_POST['acao'] = '';
}

if($_POST['acao']=='gerarxml'){
	
	set_time_limit(300);
	ini_set('memory_limit', '1024M');
	
	$_SESSION['loja_xml_modal'] = true;
	
	$_SESSION['loja_dados_xml_site_nome'] = $pnome;
	$_SESSION['loja_dados_xml_site_titulo'] = $pnome;
	$_SESSION['loja_dados_xml_site_descricao'] = $pdescricao;
		
	$arrD = array();
	$qrD = mysqli_query($conexao,"SELECT * FROM dominios");
	while($lnD=mysqli_fetch_array($qrD)){
		$arrD[$lnD['dominio']]['principal'] = $lnD['principal'];
	}
	
	$last = date('c');

	$priority = "0.8";
	
	$changefreq = "daily";
			
	function XmlFacebook($start_url){
		global $arrFinal, $conexao;
		/* dados do site */
		$empresa   = $_SESSION['loja_dados_xml_site_nome'];
		$titulo	   = $_SESSION['loja_dados_xml_site_titulo'];
		$url   	   = 'https://www.'.$start_url;
		$descricao = $_SESSION['loja_dados_xml_site_descricao'];
				
		/* monta array das categorias */
		$camposBDC = '*'; // usar * para todos os campos
		$tabelaBDC = 'categorias';
		$arrCat = array();
		$qrCat = mysqli_query($conexao,"SELECT * FROM categorias WHERE status='a'");
		$xmlC = '';
		while($lnCat=mysqli_fetch_array($qrCat)){
			$arrCat[$lnCat['id']]['id'] = $lnCat['id'];
			$arrCat[$lnCat['id']]['categoria'] = $lnCat['categoria'];
			$tagC = clean($lnCat['categoria']);
			$itmLinkCat = $url .'/categoria/'.$lnCat['url_amigavel'];
			if(!in_array($itmLinkCat,$arrFinal)){
				array_push($arrFinal,$itmLinkCat);
			}
		}
		
		/* início do banco de dados MySQL */
		$camposBD = '*'; // usar * para todos os campos
		$tabelaBD = 'produtos';
		$qr = mysqli_query($conexao,"SELECT * FROM produtos WHERE status='a'");
		if(mysqli_num_rows($qr)>0){
			$temDados = true;
		}else{
			$temDados = false;
		}
		
		if($temDados){
	
			/* dados do arquivo XML */
			$pathXML = '../'; //caminho onde ficará o arquivo XML (vazio para raiz)
			$arqXML  = $_SESSION['loja_arquivo_f']; //nome do arquivo XML "sem" extensão
				
			/* craiação e abertura do arquivo para escrita */
			$criaXML = fopen($pathXML.$arqXML,"w+");
					
			$xml  = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n
					<rss xmlns:c=\"http://base.google.com/cns/1.0\" xmlns:g=\"http://base.google.com/ns/1.0\" version=\"2.0\">\n
					<channel>\n
						<title>".$titulo."</title>\n
						<link>".$url."</link>\n
						<description><![CDATA[".$descricao."]]></description>\n
					";
						
			/* percorre a consulta do bancod e dados e monta o XML */
			while($ln=mysqli_fetch_array($qr)){
				
				$itmId = $ln['id'];
				$itmTitulo = $ln['produto'];
				$itmTitulo = ($itmTitulo!=' - ')?$itmTitulo:$_SESSION['loja_dados_xml_site_titulo'];			
				$tag = clean($ln['produto']);
				$tag = ($tag=='')?$_SESSION['loja_dados_xml_tag']:$tag;
				$itmLink = $url .'/produto/'.$ln['url_amigavel'];
				$itmValor = ($ln['por']>0 AND $ln['preco']<1)?$ln['por']:$ln['preco'];
				$itmValorDesconto = ($ln['por']>0 AND $ln['por']<$ln['preco'])?$ln['por']:$ln['preco'];
				$itmDescricao = (strip_tags(html_entity_decode(base64_decode($ln['descricao']))));
				$itmDescricao = str_replace("\n", ' ', $itmDescricao);
				$itmDescricao = str_replace("\r", ' ', $itmDescricao);
				$img = explode('.', $ln['img']);
				if ($img[1]!='jpg' || $img[1]!='png'){
				    $img[1]= '.jpg';
				}else{
				    $img[1] = '.'.$img[1];
				}
				if(file_exists('../assets/img/produtos/'.$img[0].$img[1]) && $img[0].$img[1]!=''){
					$itmImg = $url.'/assets/img/produtos/'.$img[0].$img[1];
				}else{
					$itmImg = $url.'/assets/img/produtos/sem_imagem.jpg';
				}
				if($ln['qtd']<=0){
					$itmStock = 'out of stock';
				}else{
					$itmStock = 'in stock';
				}
				$itmParcelas = 4;
				$itmParcela = $itmValor / $itmParcelas;
				$itmParcela = number_format($itmParcela,2);
				$itmEmpresa = $empresa;
				
				$itmTitulo = trim($itmTitulo);
				
				$xml .="
					<item>\n
						<id>".$itmId."</id>\n
						<title><![CDATA[".$itmTitulo."]]></title>\n
						<link>".$itmLink."</link>\n
						<price><![CDATA[".$itmValor." BRL]]></price>\n
						<description><![CDATA[".$itmDescricao."]]></description>\n
						<identifier_exists>yes</identifier_exists>\n
						<image_link>".$itmImg."</image_link>\n
						<additional_image_link>".$itmImg."</additional_image_link>\n
						<availability><![CDATA[".$itmStock."]]></availability>\n
						<sale_price><![CDATA[".$itmValorDesconto." BRL]]></sale_price>\n
						<condition><![CDATA[new]]></condition>\n
						<brand><![CDATA[".$itmEmpresa."]]></brand>\n
						<google_product_category><![CDATA[460]]></google_product_category>\n
						<gender><![CDATA[unisex]]></gender>\n
						<age_group><![CDATA[adult]]></age_group>\n
						<item_group_id><![CDATA[".$itmId."]]></item_group_id>\n
					</item>\n
				";
				if(!in_array($itmLink,$arrFinal)){
					array_push($arrFinal,$itmLink);
				}
			}
			
			$xml .= "</channel>\n
					</rss>";
					
			@fwrite($criaXML,$xml);
			
		}
		
	}
	
	function ScanDBplusGoogleShopping($start_url){
		global $arrFinal, $conexao;
		/* dados do site */
		$empresa   = $_SESSION['loja_dados_xml_site_nome'];
		$titulo	   = $_SESSION['loja_dados_xml_site_titulo'];
		$url   	   = 'https://www.'.$start_url;
		$descricao = $_SESSION['loja_dados_xml_site_descricao'];
				
		/* monta array das categorias */
		$camposBDC = '*'; // usar * para todos os campos
		$tabelaBDC = 'categorias';
		$arrCat = array();
		$qrCat = mysqli_query($conexao,"SELECT * FROM categorias WHERE status='a'");
		$xmlC = '';
		while($lnCat=mysqli_fetch_array($qrCat)){
			$arrCat[$lnCat['id']]['id'] = $lnCat['id'];
			$arrCat[$lnCat['id']]['categoria'] = $lnCat['categoria'];
			$tagC = clean($lnCat['categoria']);
			$itmLinkCat = $url .'/categoria/'.$lnCat['url_amigavel'];
			if(!in_array($itmLinkCat,$arrFinal)){
				array_push($arrFinal,$itmLinkCat);
			}
		}
		
		/* início do banco de dados MySQL */
		$camposBD = '*'; // usar * para todos os campos
		$tabelaBD = 'produtos';
		$qr = mysqli_query($conexao,"SELECT * FROM produtos WHERE status='a'");
		if(mysqli_num_rows($qr)>0){
			$temDados = true;
		}else{
			$temDados = false;
		}
		
		if($temDados){
	
			/* dados do arquivo XML */
			$pathXML = '../'; //caminho onde ficará o arquivo XML (vazio para raiz)
			$arqXML  = $_SESSION['loja_arquivo_g']; //nome do arquivo XML "sem" extensão
				
			/* craiação e abertura do arquivo para escrita */
			$criaXML = fopen($pathXML.$arqXML,"w+");
					
			$xml  = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n
					<rss xmlns:c=\"http://base.google.com/cns/1.0\" xmlns:g=\"http://base.google.com/ns/1.0\" version=\"2.0\">\n
					<channel>\n
						<title>".$titulo."</title>\n
						<link>".$url."</link>\n
						<description><![CDATA[".$descricao."]]></description>\n
					";
						
			/* percorre a consulta do bancod e dados e monta o XML */
			while($ln=mysqli_fetch_array($qr)){
				
				$itmId = $ln['id'];
				$itmTitulo = $ln['produto'].' - '.$arrCat[$ln['categoria']]['categoria'];
				$itmTitulo = ($itmTitulo!=' - ')?$itmTitulo:$_SESSION['loja_dados_xml_site_titulo'];			
				$tag = clean($ln['produto']);
				$tag = ($tag=='')?$_SESSION['loja_dados_xml_tag']:$tag;
				$itmLink = $url .'/produto/'.$ln['url_amigavel'];
				$itmValor = ($ln['por']>0 AND $ln['preco']<1)?$ln['por']:$ln['preco'];
				$itmValorDesconto = ($ln['por']>0 AND $ln['por']<$ln['preco'])?$ln['por']:$ln['preco'];
				$itmDescricao = (strip_tags(html_entity_decode(base64_decode($ln['descricao']))));
				$itmDescricao = str_replace("\n", ' ', $itmDescricao);
				$itmDescricao = str_replace("\r", ' ', $itmDescricao);
				if(file_exists('../assets/img/produtos/'.$ln['img']) && $ln['img']!=''){
					$itmImg = $url.'/assets/img/produtos/'.$ln['img'];
				}else{
					$itmImg = $url.'/assets/img/produtos/sem_imagem.jpg';
				}
				if($ln['qtd']<=0){
					$itmStock = 'out of stock';
				}else{
					$itmStock = 'in stock';
				}
				$itmParcelas = 4;
				$itmParcela = $itmValor / $itmParcelas;
				$itmParcela = number_format($itmParcela,2);
				$itmEmpresa = $empresa;
				
				$itmTitulo = trim($itmTitulo);
				
				$xml .="
					<item>\n
						<g:id>".$itmId."</g:id>\n
						<title><![CDATA[".$itmTitulo."]]></title>\n
						<link>".$itmLink."</link>\n
						<g:price><![CDATA[".$itmValor." BRL]]></g:price>\n
						<description><![CDATA[".$itmDescricao."]]></description>\n
						<g:identifier_exists>yes</g:identifier_exists>\n
						<g:image_link>".$itmImg."</g:image_link>\n
						<g:additional_image_link>".$itmImg."</g:additional_image_link>\n
						<g:availability><![CDATA[".$itmStock."]]></g:availability>\n
						<g:sale_price><![CDATA[".$itmValorDesconto." BRL]]></g:sale_price>\n
						<g:installment>\n
							<g:months><![CDATA[".$itmParcelas."]]></g:months>\n
							<g:amount><![CDATA[".$itmParcela." BRL]]></g:amount>\n
						</g:installment>\n
						<g:condition><![CDATA[new]]></g:condition>\n
						<g:brand><![CDATA[".$itmEmpresa."]]></g:brand>\n
						<g:gender><![CDATA[unisex]]></g:gender>\n
						<g:age_group><![CDATA[adult]]></g:age_group>\n
						<g:item_group_id><![CDATA[".$itmId."]]></g:item_group_id>\n
					</item>\n
				";
				if(!in_array($itmLink,$arrFinal)){
					array_push($arrFinal,$itmLink);
				}
			}
			
			$xml .= "</channel>\n
					</rss>";
					
			@fwrite($criaXML,$xml);
			
		}
		
		$camposBDC = '*'; // usar * para todos os campos
		$tabelaBDC = 'blog';
		$arrBlog = array();
		$qrBlog = mysqli_query($conexao,"SELECT * FROM $tabelaBDC WHERE status='a'");
		$xmlC = '';
		if (mysqli_num_rows($qrBlog)>0){
    		while($lnBlog=mysqli_fetch_array($qrBlog)){
    			$arrBlog[$lnBlog['id']]['id'] = $lnBlog['id'];
    			$arrBlog[$lnBlog['id']]['titulo'] = $lnBlog['titulo'];
    			$tagB = clean($lnBlog['titulo']);
    			$itmLinkBlog = $url .'/blog/'.$lnBlog['url_amigavel'];
    			if(!in_array($itmLinkBlog, $arrFinal)){
    				array_push($arrFinal, $itmLinkBlog);
    			}
    		}
		}
		
	}
	
	foreach($_POST['dominios'] AS $k => $v){
		$_SESSION['loja_site'] = $v;
		if($arrD[$v]['principal']=='sim'){
			$_SESSION['loja_arquivo_s'] = 'sitemap.xml';
			$_SESSION['loja_arquivo_g'] = 'xml-google-shopping.xml';
			$_SESSION['loja_arquivo_f'] = 'xml-facebook.xml';
		}else{
			$_SESSION['loja_arquivo_s'] = 'sitemap-'.str_replace('.','-',$v).'.xml';
			$_SESSION['loja_arquivo_g'] = 'xml-google-shopping-'.str_replace('.','-',$v).'.xml';
			$_SESSION['loja_arquivo_f'] = 'xml-facebook-'.str_replace('.','-',$v).'.xml';
		}
		
		$file = $_SESSION['loja_arquivo_s'];
		
		$start_url = $_SESSION['loja_site'];
		
		$start_url = filter_var ($start_url, FILTER_SANITIZE_URL);
		
		$start_url = $start_url;
		
		$arrFinal = array();
		$scanned = array ();
				
		$pf = fopen ('../'.$file, "w+");

		@fwrite ($pf, "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" .
					 "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"\n" .
					 "        xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"\n" .
					 "        xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9\n" .
					 "        http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">\n" .
					 "  <url>\n" .
					 "    <loc>https://www." . htmlentities ($start_url) ."</loc>\n" .
					 "    <lastmod>$last</lastmod>\n" .
					 "    <changefreq>$changefreq</changefreq>\n" .
					 "    <priority>$priority</priority>\n" .
					 "  </url>\n");
		$xmlOK = '';

		$arrPaginaPadrao = array(
			"sobre",
			"produtos",
			"blog",
			"contato",
			"rastreamento",
			"faq",
			"condicoes-gerais-de-fornecimento",
			"assistencia-tecnica",
			"politica-de-privacidade",
			"politica-de-devolucao"
		);
		
		foreach($arrPaginaPadrao AS $p => $r){
			$urlp = 'https://www.'.$start_url.'/'.$r;
			$xmlOK .= "
				<url>\n
					<loc>".$urlp."</loc>\n
					 <lastmod>".$last."</lastmod>\n
					 <changefreq>".$changefreq."</changefreq>\n
					 <priority>0.9</priority>\n
				</url>\n
			";
		}
		
		ScanDBplusGoogleShopping($start_url);
		XmlFacebook($start_url);

		foreach($arrFinal AS $k => $v){
			$xmlOK .= "
				<url>\n
					<loc>".$v."</loc>\n
					 <lastmod>".$last."</lastmod>\n
					 <changefreq>".$changefreq."</changefreq>\n
					 <priority>".$priority."</priority>\n
				</url>\n
			";
		}
		
		@fwrite ($pf, $xmlOK."</urlset>\n");
		fclose ($pf);
	}
	
	echo "<script>alert('XML gerado com sucesso.');</script>";
    echo "<meta http-equiv='refresh' content='0;URL=".$_SERVER['REQUEST_URI']."'>";
	exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<meta name="description" content="">
<meta name="author" content="">
<title>Painel Administrativo - Virtua Brasil</title>

<?if($pag=="produtos" || $pag=="blog" || $pag=="clientes" || $pag=="dev"){?>
    <script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>
	<script>
	tinymce.init({
		selector: '#mytextarea'
	});
	</script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>        -->
	<link rel="stylesheet" href="https://unpkg.com/dropzone/dist/dropzone.css" />
	<link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet"/>
	<script src="https://unpkg.com/dropzone"></script>
	<script src="https://unpkg.com/cropperjs"></script>
	<link href="vendor/masonry_swipebox/swipebox.min.css" rel="stylesheet">
	
	<style>

	.image_area {
	  position: relative;
	}

	img {
	  	display: block;
	  	max-width: 100%;
	}

	.preview {
  		overflow: hidden;
  		width: 160px; 
  		height: 160px;
  		margin: 10px;
  		border: 1px solid red;
	}

	.modal-lg{
  		max-width: 1000px !important;
	}

	.overlay {
	  position: absolute;
	  bottom: 0;
	  left: 0;
	  right: 0;
	  background-color: rgba(255, 255, 255, 0.5);
	  overflow: hidden;
	  height: 0;
	  transition: .5s ease;
	  width: 100%;
	}

	.image_area:hover .overlay {
	  height: 100%;
	  cursor: pointer;
	}

	.text {
	  color: #333;
	  font-size: 20px;
	  position: absolute;
	  top: 50%;
	  left: 50%;
	  -webkit-transform: translate(-50%, -50%);
	  -ms-transform: translate(-50%, -50%);
	  transform: translate(-50%, -50%);
	  text-align: center;
	}
	
	</style>
	
<?}?>
<!-- font link  -->
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,700" rel="stylesheet">

<!-- jvectormap CSS -->
<link href="vendor/jquery-jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet">

<!-- Bootstrap Core CSS -->
<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- Cropper -->
<link href="vendor/cropper/css/cropper.css" rel="stylesheet">
<link href="vendor/cropper/css/main_destaque.css" rel="stylesheet">

<script src="js/jquery-3.6.3.min.js"></script>

<!-- Custom CSS -->
<link href="css/adminnine.css" rel="stylesheet">

<!-- Custom Fonts -->
<link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="apple-touch-icon" sizes="57x57" href="favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="favicon//ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
<script>
    $(document).ready(function() {
    	var CEPoptions =  {
    		reverse: true,
    		selectOnFocus: true,
    		onComplete: function(cep) {
    			buscaCep(cep);
    		},
    
    		onChange: function(cep){
    
    			if(cep.length == 0){
    				$('#logradouro').prop('value','');
    				$('#numero').prop('value','');
    				$('#pto_referencia').prop('value','');
    				$('#complemento').prop('value','');
    				$('#bairro').prop('value','');
    				$('#cidade').prop('value','');
    				$('#estado').prop('value','');
    
    				$('#logradouro').attr('placeholder','Logradouro');
    				$('#numero').attr('placeholder','Numero');
    				$('#pto_referencia').attr('placeholder','Ponto de referência');
    				$('#complemento').attr('placeholder','Complemento');
    				$('#bairro').attr('placeholder','Bairro');
    				$('#cidade').attr('placeholder','Cidade');
    				$('#estado').attr('placeholder','Estado');
    
    			}else{
    
    				if(cep.length < 9){
    					$('#logradouro').attr('placeholder','buscando...');
    					$('#numero').prop('value','');
    					$('#complemento').prop('value','');
    					$('#bairro').attr('placeholder','buscando...');
    					$('#cidade').attr('placeholder','buscando...');
    					$('#estado').attr('placeholder','buscando...');
    				}
    			}
    		}
    	};
    		
    	$('.cep').mask('00000-000', CEPoptions);
    	$('.tel').mask('(00) 0000-0000');
    	$('.cel').mask('(00) 00000-0000');
    	$('.cpf').mask('000.000.000-00');
    	if ($('.rg').length > 7){
    		$('.rg').mask('000.000-#', {reverse: true});
    	}else{
    		$('.rg').mask('00.000.000-0', {reverse: true});
    	}
    
    	$('.data').mask('00/00/0000');
    	$('.data_ano').mask('0000');
    	$('.dinheiro').mask("#.##0,00", {reverse: true});
    	$('.numero').mask("000000");
    	$('.area').mask("#.##0,00 m²", {reverse: true});
    
    	function buscaCep(cep){
    
    		var cepOK = cep.replace(/\D/g, '');
    		$.getJSON('https://viacep.com.br/ws/'+cepOK+'/json/', function(data){
    		$('#logradouro').prop('value',data.logradouro);
    		$('#numero').prop('value','');
    		$('#bairro').prop('value',data.bairro);
    		$('#cidade').prop('value',data.localidade);
    		$('#estado').prop('value',data.uf);
    		$('#numero').focus();
    		$('#logradouro').attr('placeholder','Logradouro');
    		$('#numero').attr('placeholder','Numero');
    		$('#pto_referencia').attr('placeholder','Ponto de referência');
    		$('#bairro').attr('placeholder','Bairro');
    		$('#cidade').attr('placeholder','Cidade');
    		$('#estado').attr('placeholder','Estado');
    		});
    	}
    });
</script>
</head>

<body>
    
<div id="wrapper">

  <?php 
  	if($pag!="arquivo") { 
			require_once "menu_lateral.php"; 
		}
  	
  ?>

  <div id="page-wrapper">
    <?if (isset($_SESSION['alerta_mensagem']) AND $_SESSION['alerta_mensagem']!='' AND isset($_SESSION['alerta_tipo']) AND $_SESSION['alerta_tipo']!=''AND isset($_SESSION['alerta_icone']) AND $_SESSION['alerta_icone']!=''){
        $alerta = '
        <div class="panel alerta panel-'.$_SESSION['alerta_tipo'].'" id="alerta" style="display:none;">
            <div class="panel-heading"><p class="'.$_SESSION['alerta_icone'].'"></p> '.$_SESSION['alerta_mensagem'].'</div>
        </div>';
        echo $alerta;
    }
    ?>

    <?php 
    	if($pag!="arquivo") { 
			require_once "menu_topo.php";
		}
    ?>
    <input type="hidden" id="pagina_referencia" value="<?=$pag;?>">
	<?
	if($usr_nivel=='10') {
		if($pag=="" or $pag=="incial" or $pag=="home") {
			require_once "modulos/relatorios/conteudo.php";
		}	

		//destaque
		elseif($pag=="destaque"){
			require_once "modulos/destaque/conteudo.php";
		}
		//destaque
		elseif($pag=="banners"){
			require_once "modulos/banners/conteudo.php";
		}

		//categorias
		elseif($pag=="categorias"){
			require_once "modulos/categorias/conteudo.php";
		}

		//preco
		elseif($pag=="preco"){
			require_once "modulos/preco/conteudo.php";
		}

		//migracao
		elseif($pag=="migrar"){
			require_once "modulos/migrar/conteudo.php";
		}
		elseif($pag=="usuarios") { 
			require_once "modulos/usuarios/conteudo.php";
		}
		elseif($pag=="fabricante") { 
			require_once "modulos/fabricante/conteudo.php";
		}
		//produtos
		elseif($pag=="produtos"){
			require_once "modulos/produtos/conteudo.php";
		}
		elseif($pag=="dev"){
			require_once "modulos/dev/conteudo.php";
		}
		elseif($pag=="cores"){
			require_once "modulos/cores/conteudo.php";
		}
		elseif($pag=="tamanhos"){
			require_once "modulos/tamanhos/conteudo.php";
		}
		elseif($pag=="lixeira"){
			require_once "modulos/produtos/lixeira.php";
		}
		//blog
		elseif($pag=="blog"){
			require_once "modulos/blog/conteudo.php";
		}

		//newsletter
		elseif($pag=="newsletter"){
			require_once "modulos/newsletter/conteudo.php";
		}
		//pedidos
		elseif($pag=="pedidos"){
			require_once "modulos/pedidos/conteudo.php";
		}

		//planilha
		elseif($pag=="planilha"){
			require_once "modulos/planilha/conteudo.php";
		}

		//clientes
		elseif($pag=="clientes") { 
			require_once "modulos/clientes/conteudo.php";
		}

		//prestador
		elseif($pag=="colaboradores") { 
			require_once "modulos/colaboradores/conteudo.php";
		}

		//fornecedor
		elseif($pag=="fornecedores") { 
			require_once "modulos/fornecedores/conteudo.php";
		}
		
		//paginas
		elseif($pag=="paginas") { 
			require_once "modulos/paginas/conteudo.php";
		}

		//planilha
		elseif($pag=="planilhas") { 
			require_once "modulos/planilhas/conteudo.php"; 
		}
		elseif($pag=="relatorio") { 
			require_once "modulos/relatorios/conteudo.php"; 
		}
		elseif($pag=="arquivo") { 
			require_once "modulos/relatorios/arquivo.php"; 
		}
		elseif($pag=="pdf") { 
			require_once "modulos/relatorios/pdf.php"; 
		}
		elseif($pag=="cupons") { 
			require_once "modulos/cupons/conteudo.php"; 
		}
	}
	?>
    
  </div>
  <!-- /#page-wrapper --> 
  
</div>
<!-- /#wrapper -->

<? mysqli_close($conexao); ?>
<script src="js/jquery.mask.min.js"></script>
<script src="js/cropper.js"></script>
<script>const pagina = '<?=$pag;?>';</script>
<script src="js/acoes.js"></script>
<script>
    function titulo_seo(){
        let limite = 255;
        let caracteresDigitados = $('#titulo_seo').val().length;
        $('#titulo_seo').attr('maxlength', '255');
        if (caracteresDigitados>20 & caracteresDigitados<=50){
            $("#caracteres_titulo_seo").removeClass('btn-danger');
            $("#caracteres_titulo_seo").removeClass('btn-success');
            $("#caracteres_titulo_seo").addClass('btn-warning');
        }else if (caracteresDigitados>50 & caracteresDigitados<=60){
            $("#caracteres_titulo_seo").removeClass('btn-danger');
            $("#caracteres_titulo_seo").removeClass('btn-warning');
            $("#caracteres_titulo_seo").addClass('btn-success');
        }else if (caracteresDigitados>60){
            $("#caracteres_titulo_seo").removeClass('btn-success');
            $("#caracteres_titulo_seo").removeClass('btn-warning');
            $("#caracteres_titulo_seo").addClass('btn-danger');
        }else{
            $("#caracteres_titulo_seo").removeClass('btn-warning');
            $("#caracteres_titulo_seo").removeClass('btn-success');
            $("#caracteres_titulo_seo").addClass('btn-danger');
        }
        let caracteresRestantes = caracteresDigitados + " Caracteres";
        $("#caracteres_titulo_seo").text(caracteresRestantes);
    }
    function descricao_seo(){
        let limite = 255;
        let caracteresDigitados = $('#descricao_seo').val().length;
        $('#descricao_seo').attr('maxlength', '255');
        if (caracteresDigitados>40 & caracteresDigitados<=70){
            $("#caracteres_descricao_seo").removeClass('btn-danger');
            $("#caracteres_descricao_seo").removeClass('btn-success');
            $("#caracteres_descricao_seo").addClass('btn-warning');
        }else if (caracteresDigitados>=70 & caracteresDigitados<=156){
            $("#caracteres_descricao_seo").removeClass('btn-danger');
            $("#caracteres_descricao_seo").removeClass('btn-warning');
            $("#caracteres_descricao_seo").addClass('btn-success');
        }else if (caracteresDigitados>156){
            $("#caracteres_descricao_seo").removeClass('btn-success');
            $("#caracteres_descricao_seo").removeClass('btn-warning');
            $("#caracteres_descricao_seo").addClass('btn-danger');
        }else{
            $("#caracteres_descricao_seo").removeClass('btn-warning');
            $("#caracteres_descricao_seo").removeClass('btn-success');
            $("#caracteres_descricao_seo").addClass('btn-danger');
        }
        let caracteresRestantes = caracteresDigitados + " Caracteres";
        $("#caracteres_descricao_seo").text(caracteresRestantes);
    }
    function palavras_seo(){
        let limite = 255;
        let caracteresDigitados = $('#palavras_seo').val().length;
        $('#palavras_seo').attr('maxlength', '255');
        if (caracteresDigitados>40 & caracteresDigitados<=70){
            $("#caracteres_palavras_seo").removeClass('btn-danger');
            $("#caracteres_palavras_seo").removeClass('btn-success');
            $("#caracteres_palavras_seo").addClass('btn-warning');
        }else if (caracteresDigitados>=70 & caracteresDigitados<=200){
            $("#caracteres_palavras_seo").removeClass('btn-danger');
            $("#caracteres_palavras_seo").removeClass('btn-warning');
            $("#caracteres_palavras_seo").addClass('btn-success');
        }else if (caracteresDigitados>200){
            $("#caracteres_palavras_seo").removeClass('btn-success');
            $("#caracteres_palavras_seo").removeClass('btn-warning');
            $("#caracteres_palavras_seo").addClass('btn-danger');
        }else{
            $("#caracteres_palavras_seo").removeClass('btn-warning');
            $("#caracteres_palavras_seo").removeClass('btn-success');
            $("#caracteres_palavras_seo").addClass('btn-danger');
        }
        let caracteresRestantes = caracteresDigitados + " Caracteres";
        $("#caracteres_palavras_seo").text(caracteresRestantes);
    }
    $(document).on("input", "#titulo_seo", function () { 
        titulo_seo();
    });
    $(document).on("input", "#descricao_seo", function () { 
        descricao_seo();
    });
    $(document).on("input", "#palavras_seo", function () { 
        palavras_seo();
    });
	$(document).ready(function() {
	    <?if (isset($alerta)){?>
	        $("#alerta").fadeIn(800, function(){
                window.setTimeout(function(){
                    $('#alerta').fadeOut();
                }, 5000);
            });
            <?
            unset($_SESSION['alerta_mensagem']);
            unset($_SESSION['alerta_tipo']);
            ?>
	    <?}?>
		
		<?if ($pag=="produtos" || $pag=="categorias" || $pag=="blog"){?>
    	    titulo_seo();
    	    descricao_seo();
    	    palavras_seo();
    	    
    	    
	    <?}?>
	    
		$('#selDominioXml').change(function(){
			var dm = $(this).val();
			var ep = $(this).find(':selected').attr('data-principal');
			var site = '<?=$psite?>/';
			
			var urlS = site + 'sitemap';
			var urlG = site + 'xml-google-shopping';
			
			if(ep=='nao'){
				urlS = urlS + '-' + dm;
				urlG = urlG + '-' + dm;
			}
			
			$('#lnkVerXmlSitemap').attr('href',urlS + '.xml');
			$('#lnkVerXmlGoogleShopping').attr('href',urlG + '.xml');
			
		});
		
		<?php
			if(isset($_SESSION['loja_xml_modal']) AND $_SESSION['loja_xml_modal']==true){
				$_SESSION['loja_xml_modal'] = false;
				unset($_SESSION['loja_dados_xml_site_nome']);
                unset($_SESSION['loja_dados_xml_site_titulo']);
                unset($_SESSION['loja_dados_xml_site_descricao']);
		?>
		$('#lnkXml').trigger("click");
		$('#xmlModal').modal();
		<?php
			}
		?>
	});
	function ExcluirImagem(flag, img, id, excessao=''){
		$.ajax({
			type: "POST",
			url: "acao.php",
			data: {
				excluir: 'excluir',
				flag: flag,
				foto_excluir: img,
				id: id,
				excessao: excessao
			},
			dataType: "json",
			success: function (dataOK) {
			    if (dataOK.dados && flag=='excluir_destaque'){
			        $('#img_destaque').attr('src', dataOK.conteudo);
			    } else if (dataOK.dados && flag=='excluir_secundaria') {
			        $('#img_secundaria').attr('src', dataOK.conteudo);
			    } else if (dataOK.dados && flag=='excluir_todas_imagens') {
					$('#imagens_internas_produto').html('');
					$('#excluir_todas_imagens').hide();
			    } else if (dataOK.dados && flag=='excluir_imagem') {
					$('#'+dataOK.conteudo).remove();
					let imagensJavascript = $('img[src*="'+img+'"]');
					imagensJavascript.each(function() {
                        let divPai = $(this).parent();
                        let contador = divPai.data('contador');
                        divPai.attr('src', '');
                        divPai.hide();
                        $('#icone_imagem_ancora_'+contador).show();
                    });
				}else{
				    alert("Houve um erro ao deletar o arquivo!");
				}
			},
			error: function(xhr, textStatus, errorThrown){
			var erro = JSON.parse(xhr.responseText);
			console.log(erro.Message);
			}
		});
	}
	function gerarXML(){
		$('#pnlFundo').show();
		$('#frmXML').submit();
	}
	function funcao(acao, parametro, id=0) {
        $.ajax({
            url: 'modulos/<?=$pagina_referencia;?>/funcoes.php',
            method: 'POST',
            data: {
                acao: acao,
                parametro: parametro,
                id: id
            },
            success: function(resposta) {
                $('#'+id).html(resposta);
            },
            error: function() {
                alert('Erro ao chamar a função PHP.');
            }
        });
    }
</script>
</body>
</html>
