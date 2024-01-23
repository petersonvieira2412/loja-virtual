<?
ob_start();
require_once "includes/config.php";
$onde = 'blog';

if (isset($_GET['url_amigavel']) AND $_GET['url_amigavel']!='') {
$url_amigavel = $_GET['url_amigavel'];
$sql = "SELECT b.id, b.url_amigavel, b.img, b.img_interna, b.titulo, b.descricao, b.qtd_visto, b.categoria AS categoria_id, b.data_cadastro, b.titulo_site, b.descricao_site, b.meta_site, b.status, c.categoria_pai, c.url_amigavel AS url_amigavel_cat, c.categoria FROM blog AS b INNER JOIN categorias_blog AS c ON(b.categoria=c.id) WHERE b.url_amigavel='$url_amigavel' AND b.status='a' ORDER BY b.id DESC LIMIT 1";
$query = mysqli_query($conn, $sql);

	if(mysqli_num_rows($query)>0){
		$dados = mysqli_fetch_assoc($query);
		$id = $dados['id'];
		$img = 'assets/img/blog/'.$dados['img'];
		$img_interna = 'assets/img/blog/'.$id.'/'.$dados['img_interna'];
		$titulo = preconj($dados['titulo']);
		$descricao = $dados['descricao'];
		$data_cadastro = date('d/m/Y', strtotime($dados['data_cadastro']));
		$titulo_site = $dados['titulo_site'];
		$descricao_site = $dados['descricao_site'];
		$qtd_visto = $dados['qtd_visto'];
		$meta_site = $dados['meta_site'];
		
		$categoria_pai = $dados['categoria_pai'];
		$categoria_url_amigavel = $dados['url_amigavel_cat'];
		$categoria = $dados['categoria'];
		$categoria_id = $dados['categoria_id'];

		if (file_exists($img_interna) AND $dados['img_interna']!='sem_imagem.jpg'){
		    $img = $url_loja."/".$img_interna;
            $img_og = "/assets/img/blog/".$id."/".$dados['img'];
		}else {
		    if (file_exists($img)){
                $img = $url_loja."/".$img;
		    }else{
                $img = $url_loja."/assets/img/blog/sem_imagem.jpg";
		    }
        }

		if ($titulo_site=='') { $titulo_site = $titulo;}
		if ($descricao_site=='') { $descricao_site = $descricao;}

		$titulo_site = $titulo_site;
		$descricao_site = $descricao_site;
		$meta_site = $meta_site;
		
		mysqli_query($conn, "UPDATE blog SET qtd_visto=$qtd_visto+1 WHERE id='$id'");
		

	}else{
		echo '<meta http-equiv="refresh" content="0;URL='.$url_loja.'/blog">';
        exit;
	}
}

if(isset($_POST['pesquisa_blog'])){
    $_SESSION['pesquisa'] = $_POST['pesquisa_blog'];
    echo "<meta http-equiv='refresh' content='0;URL=".$url_loja."/blog/pesquisa/".mb_convert_case(str_replace(' ','-',clean($_POST['pesquisa_blog'])),MB_CASE_LOWER)."'>";
    exit();
}

$valor_pesquisar = ((isset($_GET['pesquisa']) AND $_GET['pesquisa']!='')?$_GET['pesquisa']:'');
$valor_pesquisar = str_replace('-',' ',$valor_pesquisar);

if (!isset($_GET['pesquisa']) OR $_GET['pesquisa']==''){
    if (isset($_SESSION['pesquisa'])){
        unset($_SESSION['pesquisa']);
    }
}else{
    $titulo_site = 'Blog - '.$_SESSION['pesquisa'];
}

if (isset($_GET['categoria']) AND $_GET['categoria']!='') {
    $query_categoria = mysqli_query($conn, "SELECT id, url_amigavel, categoria, categoria_pai, qtd_visto FROM categorias_blog WHERE url_amigavel='".$_GET['categoria']."' AND status='a' LIMIT 1");
    
    if (mysqli_num_rows($query_categoria)>0){
        $dados_categoria = mysqli_fetch_assoc($query_categoria);
        $categoria_id = $dados_categoria['id'];
        $categoria = $dados_categoria['categoria'];
        $categoria_pai = $dados_categoria['categoria_pai'];
        $categoria_url_amigavel = $dados_categoria['url_amigavel'];
        $categoria_qtd_visto = $dados_categoria['qtd_visto'];
        
        $_SESSION['categorias'] = array($categoria_id);
        
        mysqli_query($conn, "UPDATE categorias_blog SET qtd_visto=$categoria_qtd_visto+1 WHERE id='$categoria_id'");
        
        $titulo_site = 'Blog - '.$categoria;
    }
}

$categorias_pai = array();
function DescobrePai($categorias_pai, $conn, $id, $url_loja){
    $sql_cat = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id, categoria, url_amigavel, categoria_pai FROM categorias_blog WHERE id='$id' AND status='a' LIMIT 1"));
    
    array_push($categorias_pai, '<li><a href="'.$url_loja.'/blog/categoria/'.$sql_cat['url_amigavel'].'" title="'.preconj(ucwords($sql_cat['categoria'])).'">'.preconj(ucwords($sql_cat['categoria'])).'</a></li>');
    array_push($_SESSION['categorias'], $sql_cat['id']);
    $categorias_pai = array_reverse($categorias_pai);
    
    if ($sql_cat['categoria_pai']>0){
        return DescobrePai($categorias_pai, $conn, $sql_cat['categoria_pai'], $url_loja);
    }else{
        return $categorias_pai;
    }
}

if (!isset($_GET['pagina']) OR $_GET['pagina']<0){
    $pagina = 1;
}

if (!isset($_GET['ordenar']) || $_GET['ordenar']==''){
    $_GET['ordenar'] = 0;
}
$ordenar = $_GET['ordenar'];
if ($ordenar=='0') {
	$order=" ORDER BY b.data_cadastro DESC, b.destaque DESC, b.ordem ASC ";
}elseif ($ordenar=='1') {
    $order=" ORDER BY b.data_cadastro ASC, b.destaque DESC, b.ordem ASC ";
}elseif ($ordenar=='2') {
    $order=" ORDER BY b.titulo ASC, b.destaque DESC, b.ordem ASC ";
}elseif ($ordenar=='3') {
    $order=" ORDER BY b.titulo DESC, b.destaque DESC, b.ordem ASC ";
}elseif ($ordenar=='4') {
    $order=" ORDER BY b.qtd_visto DESC, b.destaque DESC, b.ordem ASC ";
}else{
	$ordenar='0';
	$order=" ORDER BY b.data_cadastro DESC, b.destaque DESC, b.ordem ASC ";
}

if (!isset($titulo_site) || $titulo_site==''){$titulo_site = 'Blog';}
if (!isset($descricao_site) || $descricao_site==''){$descricao_site = '';}
if (!isset($meta_site) || $meta_site==''){$meta_site= '';}
?>
<!doctype html>
<html class="no-js supports-no-cookies" lang="pt-br"> 
<head>
<?require_once "includes/head.php";?>
</head>
<body id="news-blog" class="template-blog theme-css-animate" data-currency-multiple="true">
<?
if (isset($_SESSION['tag_manager_body']) AND $_SESSION['tag_manager_body']!='') {
	echo $_SESSION['tag_manager_body'];
}
?>
<div id="theme-section-header" class="theme-section">
    <div data-section-id="header" data-section-type="header">
        <header id="header" class="header position-lg-relative js-header-sticky" data-js-sticky="desktop_and_mobile"data-js-desktop-sticky-sidebar="true">
            <?require_once "includes/header.php";?>
        </header>
    </div>
    <script>Loader.require({
        type: "script",
        name: "sticky_header"
    });
    Loader.require({
        type: "script",
        name: "header"
    });
    </script>
</div>
<main id="MainContent">
    <div class="breadcrumbs mt-10">
        <div class="container">
            <ul class="list-unstyled d-flex flex-wrap align-items-center justify-content-start">
                <li><a href="<?=$url_loja;?>" title="Home"><i class="fa-sharp fa-solid fa-house"></i></a></li>
                <li><a href="<?=$url_loja;?>/blog" title="Blog">Blog</a></li>
                <?if (isset($categoria) AND $categoria>0){?>
                <li><a href="<?=$url_loja;?>/blog/categoria<?=((isset($categoria_url_amigavel) AND $categoria_url_amigavel!='')?'/'.$categoria_url_amigavel:'');?>" title="<?=$categoria;?>"><?=preconj($categoria);?></a></li>
                <?}?>
                <?if (isset($categoria_pai) AND $categoria_pai>0){
                    foreach(DescobrePai($categorias_pai, $conn, $categoria_pai, $url_loja) as $item){
                        echo $item;
                    }
                }?>
                <?if (isset($_GET['url_amigavel']) AND $_GET['url_amigavel']!=''){?>
                    <li><span><?=preconj($titulo);?></span></li>
                <?}?>
            </ul>
        </div>
    </div>
    <?if (isset($_GET['url_amigavel']) AND $_GET['url_amigavel']!='' AND mysqli_num_rows($query)>0) {?>
    <div class="blogs pb-1">
        <div class="container">
            <div class="row mb-60 mt-30">
                <?require_once "includes/sidebar_blog.php";?>
                <div class="blogs__body col">
                    <div id="theme-section-blog-body" class="theme-section">
                        <div data-section-id="blog-body" data-section-type="blog-body">
                            <div class="blog-body">
                                <div class="post mb-40 text-center">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <img src="<?=$img;?>" class="rimage__img--fade-in lazyload" data-master="<?=$img;?>" data-aspect-ratio="1.3701067615658362" data-srcset="<?=$img;?>" alt="<?=$titulo;?>" title="<?=$titulo;?>" style="max-height: 500px; width: auto;">
                                        </div>
                                        <div class="col-md-12">
                                            <h1 class="h3 mt-15 mb-5">
                                                <?=preconj($titulo);?>
                                            </h1>
                                        </div>
                                        <div class="col-md-12 rte p-15" style="text-align: justify;">
                                            <?=$descricao;?>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex flex-column flex-lg-row flex-left position-relative">
                                                <a href="<?=$url_loja;?>/blog" title="VOLTAR" class="btn">VOLTAR</a>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="blog-sidebar__tags d-flex flex-wrap flex-right">
                                                <a href="whatsapp://send?text=Compartilhado de <?=$nome_loja_completa;?>%0a%0ahttps://<?=$_SERVER['HTTP_HOST'];?><?=$_SERVER['REQUEST_URI'];?>" title="Compartilhar no WhatsApp" target="_blank" rel="noopener" class="btn link-revert py-4 px-10 mr-10 border border-hover" style="background-color: #25d366; color: #fff; white-space: pre-wrap;"><i style="font-size: 13px; color:#fff; " class="fa-brands fa-whatsapp"></i> WhatsApp</a>
                                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?=$_SERVER['HTTP_HOST'];?><?=$_SERVER['REQUEST_URI'];?>" title="Compartilhar no Facebook" target="_blank" rel="noopener" class="btn link-revert py-4 px-10 mr-10 border border-hover" style="background-color: #3b5998; color: #fff; white-space: pre-wrap;"><i style="font-size: 13px; color:#fff; " class="fa-brands fa-facebook"></i> Facebook</a>
                                                <a href="https://t.me/share/url?url=https://<?=$_SERVER['HTTP_HOST'];?><?=$_SERVER['REQUEST_URI'];?>" title="Compartilhar no Telegram" target="_blank" rel="noopener" class="btn link-revert py-4 px-10 mr-10 border border-hover" style="background-color: #1c93e3; color: #fff; white-space: pre-wrap;"><i style="font-size: 13px; color:#fff; " class="fa-brands fa-telegram"></i> Telegram</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            Loader.require({
                                type: "script",
                                name: "blog_body"
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?}else{?>
        <div class="blogs pb-1">
            <div class="container mt-20">
                <div class="row">
                    <?$query_blog = mysqli_query($conn, "SELECT id FROM blog WHERE status='a' LIMIT 1");
                    $rows_blog = mysqli_num_rows($query_blog);
                    mysqli_free_result($query_blog);
                    if ($rows_blog>0){?>
                        <?require_once "includes/sidebar_blog.php";?>
                        <div class="blogs__body col">
                            <div id="theme-section-blog-body" class="theme-section">
                                <div data-section-id="blog-body" data-section-type="blog-body">
                                    <div class="blog-body">
                                        <div class="row">
                                            <div class="col-8 col-lg d-flex d-lg-flex align-items-center">
                                                <div class="collection-control__sort-by d-none d-lg-flex align-items-center mr-20" data-js-collection-sort-by>
                                                    <i class="fa-solid fa-chevron-right"></i>&nbsp;<h1 class="titulo_categoria"><?=((isset($categoria) AND $categoria!='')?$categoria:'Blog');?></h1>
                                                </div>
                                            </div>
                                            <div class="col-4 col-lg d-flex justify-content-lg-end align-items-center">
                                                <div class="collection-control__sort-by d-none d-lg-block mr-20" data-js-collection-sort-by>
                                                    <div class="select position-relative js-dropdown js-select">
                                                        <div class="d-flex align-items-center" data-js-dropdown-button>
                                                            <label for="SortBy" class="mb-0 mr-3">Filtrar:</label>
                                                            <select name="ordenar" class="p-0 pr-25 mb-0 border-0 cursor-pointer" id="ordenar" style="min-width: 100px;">
                                                                <option value="manual" <?echo (($ordenar=='0')?'selected':'');?>>Mais Recentes</option>
                                                                <option value="best-selling" <?echo (($ordenar=='1')?'selected':'');?>>Mais Antigos</option>
                                                                <option value="price-ascending" <?echo (($ordenar=='2')?'selected':'');?>>Nome A-Z</option>
                                                                <option value="price-descending" <?echo (($ordenar=='3')?'selected':'');?>>Nome Z-A</option>
                                                                <option value="created-ascending" <?echo (($ordenar=='4')?'selected':'');?>>Mais Vistos</option>
                                                            </select>
                                                            <i class="position-absolute right-0">
                                                                <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-229" viewBox="0 0 24 24">
                                                                    <path d="M11.783 14.088l-3.75-3.75a.652.652 0 0 1-.176-.449c0-.169.059-.319.176-.449a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176l3.301 3.32 3.301-3.32a.65.65 0 0 1 .449-.176c.169 0 .318.059.449.176.117.13.176.28.176.449a.652.652 0 0 1-.176.449l-3.75 3.75a.877.877 0 0 1-.215.127.596.596 0 0 1-.468 0 .841.841 0 0 1-.215-.127z"/>
                                                                </svg>
                                                            </i>
                                                        </div>
                                                        <div class="select__dropdown dropdown d-none position-lg-absolute top-lg-100 left-lg-0" data-js-dropdown data-js-select-dropdown>
                                                            <div class="px-15 pb-30 py-lg-15">
                                                                <a href="<?=$url_loja;?>/blog<?=((isset($categoria_url_amigavel) AND $categoria_url_amigavel!='')?'/categoria/'.$categoria_url_amigavel:'');?><?=((isset($_GET['pesquisa']) AND $_GET['pesquisa']!='')?'/pesquisa/'.$valor_pesquisar:'');?>/<?=$pagina;?>/0" title="Mais Recentes"><span data-value="Mais Recentes" <?echo (($ordenar=='0')?'class="selected"':'');?>>Mais Recentes</span></a>
                                                                <a href="<?=$url_loja;?>/blog<?=((isset($categoria_url_amigavel) AND $categoria_url_amigavel!='')?'/categoria/'.$categoria_url_amigavel:'');?><?=((isset($_GET['pesquisa']) AND $_GET['pesquisa']!='')?'/pesquisa/'.$valor_pesquisar:'');?>/<?=$pagina;?>/1" title="Mais Antigos"><span data-value="Mais Antigos" <?echo (($ordenar=='1')?'class="selected"':'');?>>Mais Antigos</span></a>
                                                                <a href="<?=$url_loja;?>/blog<?=((isset($categoria_url_amigavel) AND $categoria_url_amigavel!='')?'/categoria/'.$categoria_url_amigavel:'');?><?=((isset($_GET['pesquisa']) AND $_GET['pesquisa']!='')?'/pesquisa/'.$valor_pesquisar:'');?>/<?=$pagina;?>/2" title="Nome A-Z"><span data-value="Nome A-Z" <?echo (($ordenar=='2')?'class="selected"':'');?>>Nome A-Z</span></a>
                                                                <a href="<?=$url_loja;?>/blog<?=((isset($categoria_url_amigavel) AND $categoria_url_amigavel!='')?'/categoria/'.$categoria_url_amigavel:'');?><?=((isset($_GET['pesquisa']) AND $_GET['pesquisa']!='')?'/pesquisa/'.$valor_pesquisar:'');?>/<?=$pagina;?>/3" title="Nome Z-A"><span data-value="Nome Z-A" <?echo (($ordenar=='3')?'class="selected"':'');?>>Nome Z-A</span></a>
                                                                <a href="<?=$url_loja;?>/blog<?=((isset($categoria_url_amigavel) AND $categoria_url_amigavel!='')?'/categoria/'.$categoria_url_amigavel:'');?><?=((isset($_GET['pesquisa']) AND $_GET['pesquisa']!='')?'/pesquisa/'.$valor_pesquisar:'');?>/<?=$pagina;?>/4" title="Mais Vistos"><span data-value="Mais Vistos" <?echo (($ordenar=='4')?'class="selected"':'');?>>Mais Vistos</span></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="collection-control__view-length d-none d-lg-block" data-js-collection-view-length>
                                                    <div class="select position-relative js-dropdown js-select">
                                                        <div class="d-flex align-items-center" data-js-dropdown-button>
                                                            <label for="ViewLength" class="mb-0 mr-5">Página:</label>
                                                            <select name="view_length" class="p-0 pr-25 mb-0 border-0 cursor-pointer" id="ViewLength">
                                                                <option value="<?=$pagina;?>"><?=$pagina;?></option>
                                                            </select>
                                                        </div>
                                                        <div class="select__dropdown dropdown d-none position-lg-absolute top-lg-100 left-lg-0">
                                                            <div class="px-15 pb-30 py-lg-15">
                                                                <span data-value="<?=$pagina;?>"><?=$pagina;?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <?
                                            ((isset($_GET['categoria']) AND $_GET['categoria']!='')?$categoria = "AND c.url_amigavel='".$_GET['categoria']."'":$categoria = "");
                                            ((isset($_GET['pesquisa']) AND $_GET['pesquisa']!='')?$pesquisa = "AND (b.titulo LIKE '%".$valor_pesquisar."%' OR c.categoria LIKE '%".$valor_pesquisar."%')":$pesquisa = "");
                                            
                                            $query_blog = "SELECT b.id, b.url_amigavel, b.titulo, b.img, b.chamada FROM blog AS b INNER JOIN categorias_blog AS c ON(b.categoria=c.id) WHERE b.status='a' $categoria $pesquisa ORDER BY b.id DESC";
                                            $resultado = mysqli_query($conn, $query_blog);
                                            //Contar o total de cursos
                                            $total = mysqli_num_rows($resultado);
                                            //Seta a quantidade de cursos por pagina
                                            $quantidade_pg = 9;
                                            //calcular o número de pagina necessárias para apresentar os cursos
                                            $num_pagina = ceil($total/$quantidade_pg);
                                            
                                            $incio = ($quantidade_pg*$pagina)-$quantidade_pg;
                                            if ($incio<0){$incio=0;}
                                            
                                            mysqli_free_result($resultado);
                                            $query_blog = mysqli_query($conn, "SELECT b.id, b.url_amigavel, b.titulo, b.img, b.chamada FROM blog AS b INNER JOIN categorias_blog AS c ON(b.categoria=c.id) WHERE b.status='a' $categoria $pesquisa $order limit $incio, $quantidade_pg");
                                            $rows_blog = mysqli_num_rows($query_blog);
                                            if ($rows_blog>0){
                        
                                            while ($dados_blog = mysqli_fetch_assoc($query_blog)) {
                                                $id_blog = $dados_blog['id'];
                                                $chamada_blog = $dados_blog['chamada'];
                                                $url_amigavel_blog = $dados_blog['url_amigavel'];
                                                $titulo_blog = preconj($dados_blog['titulo']);
                                                $img_blog = 'assets/img/blog/'.$dados_blog['img'];
                                                $url_blog = $url_loja."/blog/".$url_amigavel_blog;
                        
                                                if (file_exists($img_blog) AND $img_blog!='assets/img/blog/'){
                                                    $img_blog = $url_loja."/assets/img/blog/".$dados_blog['img'];
                                                }else{
                                                    $img_blog = $url_loja."/assets/img/blog/sem_imagem.jpg";
                                                }
                                            ?>
                                                <div class="col-12 col-md-4">
                                                    <div class="post mb-15 text-center">
                                                        <a href="<?=$url_blog;?>" title="<?=$titulo_blog;?>" class="d-block overflow-hidden">
                                                            <div class="rimage" style="padding-top:100%;">
                                                                <img src="<?=$img_blog;?>" class="rimage__img rimage__img--fade-in lazyload" data-master="<?=$img_blog;?>" data-aspect-ratio="1.3701067615658362" data-srcset="<?=$img_blog;?>" alt="<?=$titulo_blog;?>" title="<?=$titulo_blog;?>" style="width: 100%; height: auto;">
                                                            </div>
                                                        </a>
                                                        <div class="d-none position-relative">
                                                            <div class="position-absolute top-0 left-0 right-0 pb-15">
                                                                <div class="d-flex flex-column align-items-center position-relative">
                                                                    <h5 class="h5 mt-15">
                                                                        <a href="<?=$url_blog;?>" title="<?=$titulo_blog;?>"><?=$titulo_blog;?></a>
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <h5 class="h5 mt-15">
                                                            <a href="<?=$url_blog;?>" title="<?=$titulo_blog;?>"><?=$titulo_blog;?></a>
                                                        </h5>
                                                    </div>
                                                </div>
                                            <?}}else{?>
                                                <?if (isset($_GET['pesquisa']) AND $_GET['pesquisa']!=''){?>
                                                <div class="col-12 col-md-12">
                                                    <h4 class="my-25 text-center">
                                                        Não encontramos nada relacionado à '<?=$_SESSION['pesquisa'];?>'<br>
                                                        Confira os mais acessados.
                                                    </h4>
                                                    <hr>
                                                </div>
                                                <?
                                                $query_blog = mysqli_query($conn, "SELECT b.id, b.url_amigavel, b.titulo, b.img, b.chamada FROM blog AS b INNER JOIN categorias_blog AS c ON(b.categoria=c.id) WHERE b.status='a' ORDER BY b.qtd_visto, b.id DESC LIMIT 3");
                                                $rows_blog = mysqli_num_rows($query_blog);
                                                if ($rows_blog>0){
                        
                                                while ($dados_blog = mysqli_fetch_assoc($query_blog)) {
                                                    $id_blog = $dados_blog['id'];
                                                    $chamada_blog = $dados_blog['chamada'];
                                                    $url_amigavel_blog = $dados_blog['url_amigavel'];
                                                    $titulo_blog = preconj(ucwords($dados_blog['titulo']));
                                                    $img_blog = 'assets/img/blog/'.$dados_blog['img'];
                                                    $url_blog = $url_loja."/blog/".$url_amigavel_blog;
                            
                                                    if (file_exists($img_blog) AND $img_blog!='assets/img/blog/'){
                                                        $img_blog = $url_loja."/assets/img/blog/".$dados_blog['img'];
                                                    }else{
                                                        $img_blog = $url_loja."/assets/img/blog/sem_imagem.jpg";
                                                    }
                                                ?>
                                                    <div class="col-12 col-md-4">
                                                        <div class="post mb-15 text-center">
                                                            <a href="<?=$url_blog;?>" title="<?=$titulo_blog;?>" class="d-block overflow-hidden">
                                                                <div class="rimage" style="padding-top:100%;">
                                                                    <img src="<?=$img_blog;?>" class="rimage__img rimage__img--fade-in lazyload" data-master="<?=$img_blog;?>" data-aspect-ratio="1.3701067615658362" data-srcset="<?=$img_blog;?>" alt="<?=$titulo_blog;?>" title="<?=$titulo_blog;?>" style="width: 100%; height: auto;">
                                                                </div>
                                                            </a>
                                                            <div class="d-none position-relative">
                                                                <div class="position-absolute top-0 left-0 right-0 pb-15">
                                                                    <div class="d-flex flex-column align-items-center position-relative">
                                                                        <h5 class="h5 mt-15">
                                                                            <a href="<?=$url_blog;?>" title="<?=$titulo_blog;?>"><?=$titulo_blog;?></a>
                                                                        </h5>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <h5 class="h5 mt-15">
                                                                <a href="<?=$url_blog;?>" title="<?=$titulo_blog;?>"><?=$titulo_blog;?></a>
                                                            </h5>
                                                        </div>
                                                    </div>
                                                <?}}}else{?>
                                                    <div class="col-12 col-md-12">
                                                        <h4 class="my-15 text-center">
                                                            Não há blogs no momento!
                                                        </h4>
                                                    </div>
                                                <?}?>
                                            <?}?>
                                        </div>
                                    </div>
                                    <?if ($total>0){
                                    $pagina_anterior = $pagina - 1;
                                    $pagina_posterior = $pagina + 1;
                                    $diferenca_anterior = $pagina - 1;
                                    ?>
                                        <div data-js-collection-pagination data-pagination-type="button_load_more" data-js-collection-replace="pagination">
                                            <style>
                                                ul:not(.list-unstyled) li::before {
                                                    background-color: #fff;
                                                    display: none;
                                                }
                                                .page-link:hover {
                                                    color: #fff;
                                                    background-color: <?=$cor_site;?>;
                                                }
                                                .page-item.active .page-link{
                                                    background-color: <?=$cor_site;?>;
                                                    border-color: <?=$cor_site;?>;
                                                }
                                            </style>
                                            <div class="pagination justify-content-center">
                                                <div class="d-flex justify-content-center mt-35">
                                                    <nav aria-label="Navegação de página exemplo">
                                                        <ul class="pagination">
                                                            <?
                                                                if($pagina_anterior!=0){ ?>
                                                                    <li class="page-item" style="padding:0;">
                                                                        <a class="page-link" href="<?=$url_loja;?>/blog<?=((isset($categoria_url_amigavel) AND $categoria_url_amigavel!='')?'/categoria/'.$categoria_url_amigavel:'');?><?=((isset($_GET['pesquisa']) AND $_GET['pesquisa']!='')?'/pesquisa/'.$valor_pesquisar:'');?>/<?=$pagina_anterior;?>" title="Anterior">Anterior</a>
                                                                    </li>
                                                                    <?if($diferenca_anterior>2){?>
                                                                        <li class="page-item" style="padding:0;">
                                                                            <a class="page-link" href="<?=$url_loja;?>/blog<?=((isset($categoria_url_amigavel) AND $categoria_url_amigavel!='')?'/categoria/'.$categoria_url_amigavel:'');?><?=((isset($_GET['pesquisa']) AND $_GET['pesquisa']!='')?'/pesquisa/'.$valor_pesquisar:'');?>/<?=$pagina_anterior;?>" title="Página 1">1</a>
                                                                        </li>
                                                                        <li class="page-item disabled" style="padding:0;">
                                                                            <a class="page-link" disabled>...</a>
                                                                        </li>
                                                                    <?}?>
                                                                <?}
                                                                if (!isset($num_pagina) || $num_pagina==0){$num_pagina=1;}
                                                                if (!isset($pagina) || $pagina==0){$pagina=1;}
                
                                                                for($i=1; $i<$num_pagina+1; $i++){ 
                
                                                                    if ($i==$pagina) {
                                                                        $class='active';
                                                                    }
                                                                    else{
                                                                        $class='';
                                                                    }
                                                                    $minimo = $pagina-3;
                                                                    $maximo = $pagina+3;
                                                                    $diferenca_posterior = $num_pagina - $pagina_posterior;
                                                                    
                                                                    if ($i>$minimo AND $i<$maximo){
                                                                        if ($num_pagina>1){
                                                                ?>
                                                                    <li class="page-item <?=$class?>" style="padding:0;">
                                                                        <a class="page-link" href="<?=$url_loja;?>/blog<?=((isset($categoria_url_amigavel) AND $categoria_url_amigavel!='')?'/categoria/'.$categoria_url_amigavel:'');?><?=((isset($_GET['pesquisa']) AND $_GET['pesquisa']!='')?'/pesquisa/'.$valor_pesquisar:'');?>/<?=$i;?>" title="Página <?=$i;?>"><?=$i;?></a>
                                                                    </li>
                                                                <?}}}
                                                                if($pagina_posterior<=$num_pagina){?>
                                                                    <?if($diferenca_posterior>1){?>
                                                                        <li class="page-item disabled" style="padding:0;">
                                                                            <a class="page-link" disabled>...</a>
                                                                        </li>
                                                                        <li class="page-item" style="padding:0;">
                                                                            <a class="page-link" href="<?=$url_loja;?>/blog<?=((isset($categoria_url_amigavel) AND $categoria_url_amigavel!='')?'/categoria/'.$categoria_url_amigavel:'');?><?=((isset($_GET['pesquisa']) AND $_GET['pesquisa']!='')?'/pesquisa/'.$valor_pesquisar:'');?>/<?=$num_pagina;?>" title="Página <?=$num_pagina;?>"><?=$num_pagina;?></a>
                                                                        </li>
                                                                    <?}?>
                                                                    <li class="page-item" style="padding:0;">
                                                                        <a class="page-link" href="<?=$url_loja;?>/blog<?=((isset($categoria_url_amigavel) AND $categoria_url_amigavel!='')?'/categoria/'.$categoria_url_amigavel:'');?><?=((isset($_GET['pesquisa']) AND $_GET['pesquisa']!='')?'/pesquisa/'.$valor_pesquisar:'');?>/<?=$pagina_posterior;?>" title="Próximo">Próximo</a>
                                                                    </li>
                                                                <?}
                                                            ?>
                                                        </ul>
                                                    </nav>
                                                </div>
                                            </div>
                                            <input type="hidden" name="page" value="1">
                                        </div>
                                    <?}?>
                                </div>
                            </div>
                        </div>
                    <?}else{?>
                        <div class="col-12 col-md-12">
                            <h1 class="h2 my-55 text-center">
                                Não há blogs no momento!
                            </h1>
                        </div>
                    <?}?>
                </div>
            </div>
        </div>
    <?}?>
</main>
<?require_once "includes/footer.php";?>
</body>
</html>
<script>
$('#newsletter_email').on('keydown', function (e) {
    if (e.keyCode === 13) {
        $('#newsletter_botao').click();
    }
})
</script>
<?
$cntACmp =ob_get_contents(); 
ob_end_clean(); 
$cntACmp=str_replace("\n",' ',$cntACmp); 
$cntACmp=preg_replace('/[[:space:]]+/',' ',$cntACmp);
echo $cntACmp; 
ob_end_flush(); 
?>