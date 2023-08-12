<?php
ob_start();
  include_once "config.php";
  $pagina_titulo = "leads";
  $pagina_referencia = "leads";
  setlocale(LC_ALL, 'en_US.UTF8');

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

//bliblioteca nova a ser implantada

  function compressImage($source_path, $destination_path, $quality) {
    $info = getimagesize($source_path);

    if ($info['mime'] == 'image/jpeg') {
        $image = imagecreatefromjpeg($source_path);
    } elseif ($info['mime'] == 'image/gif') {
        $image = imagecreatefrompng($source_path);
    } elseif ($info['mime'] == 'image/png') {
        $image = imagecreatefrompng($source_path);
    }

    imagejpeg($image, $destination_path, $quality);
    return $destination_path;
  }

  if ($acao=="gravar") {

    if (file_exists($_FILES['lead']['tmp_name']) || is_uploaded_file($_FILES['lead']['tmp_name'])) {
        
        $aleatorio = rand(1,999999);

        $nome_final = "lead-".$aleatorio;
        $set_img_path = "../assets/img/".$pagina_referencia;
        $imgarray = array("text/csv");

        if (!in_array($_FILES['lead']['type'],$imgarray)) {
          echo "<p>É somente aceito arquivos (CSV).</p>";
          exit;
        }

        if ($_FILES['lead']['type']=="text/csv") {
            $ext = ".csv";
        }

        $img = $nome_final.$ext;
        move_uploaded_file($_FILES['lead']['tmp_name'], "$set_img_path/$img");
        chmod ("$set_img_path/$img", 0755);

        $arquivo = fopen ("$set_img_path/$img", 'r');

        while(!feof($arquivo)){
            // Pega os dados da linha
            $linha = fgets($arquivo, 1024);

            // Divide as Informações das celular para poder salvar
            $dados = explode(';', $linha);

            // Verifica se o Dados Não é o cabeçalho ou não esta em branco
            if($dados[0] != 'id' && !empty($linha)){
                $id = $_POST['id'];
                $codigo = $_POST['codigo'];
                $data_captacao = date("Y-m-d", strtotime($dados[1]));
                
                $sql = mysqli_query($conexao, "SELECT id_plataforma FROM leads WHERE id_plataforma='".trim($dados[0])."' AND id_produto='$id'");
                
                if (mysqli_num_rows($sql)==0){
                    mysqli_query($conexao, 'INSERT INTO leads (id_produto, id_plataforma, plataforma, nome, telefone, email, data_captacao, data, hora, data_editar, hora_editar, status) VALUES ("'.$id.'", "'.trim($dados[0]).'", "'.$dados[11].'", "'.$dados[12].'", "'.$dados[13].'", "'.$dados[14].'", "'.$data_captacao.'", "'.date('Y-m-d').'", "'.date('H:i:s').'", "'.date('Y-m-d').'", "'.date('H:i:s').'", "a")');
                }
            }
        }
        
        unlink("$set_img_path/$img");
        
        echo "<script>alert('Lead cadastrado com sucesso.');</script>";
        echo "<meta http-equiv='refresh' content='0;'>";
        exit();
    }
  }
  if (isset($_POST['acao']) AND $_POST['acao']=="cadastrar") {

    $id = (int)$_POST['id'];
    $comentario = $_POST['comentario'];
    $nome = trim(addslashes(htmlspecialchars($_POST['nome'])));
    $email = trim(addslashes($_POST['email']));
    $celular = trim(addslashes($_POST['celular']));
    $id_vendedor = ((isset($_POST['id_vendedor']) AND $_POST['id_vendedor']!='')?trim(addslashes($_POST['id_vendedor'])):'');
    $id_produto = ((isset($_POST['id_produto']) AND $_POST['id_produto']!='')?trim(addslashes($_POST['id_produto'])):'');
    $data_captacao = date("Y-m-d");
    
    $query = mysqli_query($conexao, 'INSERT INTO leads (id_produto, id_vendedor, plataforma, nome, email, telefone, data_captacao, data, hora, data_editar, hora_editar, status) VALUES ("'.$id_produto.'", "'.$id_vendedor.'", "ma", "'.$nome.'", "'.$email.'", "'.$celular.'", "'.$data_captacao.'", "'.date('Y-m-d').'", "'.date('H:i:s').'", "'.date('Y-m-d').'", "'.date('H:i:s').'", "a")');
    
    $ultimo_id = mysqli_insert_id($conexao);
    if (isset($comentario) AND $comentario!=''){
        $insere = "INSERT INTO atendimento (id_lead, nivel, data, hora, comentario, status) VALUES ('$ultimo_id', '".$_SESSION["usr_nivel"]."', '".date("Y-m-d")."', '".date("H:i:s")."', '$comentario', 'a')" or die(mysqli_error());
        $query = mysqli_query($conexao, $insere);
    }
    
    if ($query==true){
        echo "<script>alert('Lead cadastrado com sucesso.');</script>";
        echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";
        exit();
    }

  }
if ($acao=="cadastrar") {?>
    <style>
        .form-group{
            display: grid !important;
            margin-bottom: 15px !important;
        }
    </style>
    <div class="row">
        <div class="col-md-12  header-wrapper" >
            <h1 class="page-header"><?=mb_convert_case("$pagina_titulo", MB_CASE_TITLE, "UTF-8");?></h1>
            <p class="page-subtitle">Cadastre um novo lead.</p>
        </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default ">
            <div class="panel-body">
                <form action="" method="POST">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>NOME</label>
                            <input name="nome" type="text" class="form-control" id="nome" placeholder="" maxlength="255">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-group">
                                <label>E-MAIL</label>
                                <input name="email" type="text" class="form-control" id="email" maxlength="255">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-group">
                                <label>CELULAR</label>
                                <input name="celular" type="text" class="form-control cel" id="celular" maxlength="255">
                            </div>
                        </div>
                    </div>
                    <?if (isset($usr_nivel) AND $usr_nivel==10){?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>ATRIBUA O LEAD A UM VENDEDOR</label>
                                  <select class="form-control" name="id_vendedor" id="id_vendedor">
                                    <?
                                      $sql_vendedor = "SELECT id, responsavel_nome FROM vendedores WHERE status='a' AND id>1 ORDER BY responsavel_nome ASC";
                                      $query_vendedor = mysqli_query($conexao, $sql_vendedor);
                                      $num_rows_vendedor = mysqli_num_rows($query_vendedor);
                    
                                      while ($dados_vendedor = mysqli_fetch_assoc($query_vendedor)) {
                                        echo "<option value='".$dados_vendedor['id']."'>".$dados_vendedor['responsavel_nome']."</option>";
                                      }
                                      mysqli_free_result($query_vendedor);
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6"> 
                            <div class="form-group" style="width: 100%;">
                                <label>PRODUTO (OPCIONAL)</label>
                                <input type="text" class="form-control" list="itens" name="id_produto" id="id_produto" value="" placeholder="Nenhum" style="width: 100%;">
                                <datalist id="itens">
                                    <?
                                    $query_p = mysqli_query($conexao, "SELECT id, produto, sku FROM produtos WHERE status='a' ORDER BY id DESC");
                                    if (mysqli_num_rows($query_p)>0){
                                        while ($dados_p = mysqli_fetch_assoc($query_p)){
                                    ?>
                                        <option value="<?=$dados_p['id'];?>">ID: <?=$dados_p['id'];?> | <?=$dados_p['produto'];?></option>
                                    <?}}?>
                                </datalist>
                            </div>
                        </div>
                    <?}?>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>DEIXE UM COMENTÁRIO</label>
                            <textarea rows="6" name="comentario"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <input name="acao" id="acao" value="cadastrar" type="hidden">
                        <button type="submit" class="btn btn-success" title="CADASTRAR"style="float:right;">CADASTRAR</button>    
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
<? }
if ($acao=="anexar") {
    ?>
    <div class="row">
        <div class="col-md-12  header-wrapper" >
            <h1 class="page-header"><?=mb_convert_case("$pagina_titulo", MB_CASE_TITLE, "UTF-8");?></h1>
            <p class="page-subtitle">Listagens dos itens cadastrados no sistema.</p>
            <div class="pull-right">
                <a href="#" data-toggle="modal" data-target="#cadastrar" title="Cadastrar" class="btn btn-primary">+ CADASTRAR</a>
                <div class="modal fade" id="cadastrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <form method="post" action="" enctype="multipart/form-data">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="myModalLabel3">ADICIONAR LEAD</h4>
                                </div>
                                <div class="modal-body"><h5>Apenas arquivos .CSV separados por virgula<h5> <br>
                                    <input class="form-control" name="lead" id="lead" type="file" accept="text/csv">
                                </div>
                                <div class="modal-footer">
                                    <input name="acao" id="acao" value="gravar" type="hidden">
                                    <button type="submit" class="btn btn-success" title="CONFIRMAR">CONFIRMAR</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <table class="table table-bordered table-hover" id="dataTables-userlist">
         <thead>
            <tr>
              <th>ID</th>
              <th>IMAGEM</th>
              <th>PRODUTO</th>
              <th>CATEGORIA</th>
              <th>PREÇO</th>
              <th>AÇÕES</th>
            </tr>
          </thead>
          <tbody>
          <?
          $sql = "SELECT id, categoria FROM categorias WHERE status='a' ORDER BY categoria ASC";
          $query = mysqli_query($conexao, $sql);

          while ($dados = mysqli_fetch_assoc($query)) {
            $id = $dados['id'];
            $categorias[$id] = $dados['categoria'];
          }
          mysqli_free_result($query);
                
          $sql = "SELECT id, img, categoria, img, url_amigavel, produto, preco, por, status FROM produtos WHERE status='a' ORDER BY id DESC";
          $query = mysqli_query($conexao, $sql);
            
          $condicao = mysqli_num_rows($query);
          $classe="even ";
            
          while ($dados = mysqli_fetch_assoc($query)) {
            $id = $dados['id'];
            $img = $dados['img'];
            $categoria = $dados['categoria'];
            $produto = $dados['produto'];
            $url_amigavel = $dados['url_amigavel'];
            
            $preco = $dados["preco"];
            $por = $dados["por"];
            
            if ($dados['img']=='') {
                $imagem = '../assets/img/produtos/sem_imagem.jpg';
            } elseif(file_exists('../assets/img/produtos/'.$img.'')){
                $imagem = '../assets/img/produtos/'.$img.'';
            } else {
                $imagem = "../assets/img/produtos/sem_imagem.jpg";
            }
            
            if ($classe=="odd") { $classe="even "; } else {$classe="odd"; }
        ?>
            <tr class="<?=$classe;?>">
              <td class="center"><?=$id;?></td>
              <td class="center"><a href="../produto/<?=$url_amigavel;?>" target="_blank" rel="noopener"><img src="<?=$imagem;?>" alt="<?=$produto;?>" title="<?=$produto;?>" class="gridpic"></a></td>
              <td><?=$produto;?></td>
              <td><? if (isset($categorias[$categoria])) { echo $categorias[$categoria]; } else { echo "<span class='status btn-danger'>Não Localizada</span>"; };?></td>
              <td class="center">R$ <? if ($por!='0.00') { echo $por; } else { echo $preco; };?></td>
              <td>
                  <div class="socials tex-center"> 
                    <a href="#" class="btn btn-circle btn-default" data-toggle="modal" data-target="#myModal<?=$id;?>" title="Adicionar Lead"><i class="fa fa-download"></i></a>
                    <div class="modal fade" id="myModal<?=$id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <form method="post" action="" enctype="multipart/form-data">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel3">ADICIONAR LEAD</h4>
                                    </div>
                                    <div class="modal-body"><h5>Apenas arquivos .CSV separados por virgula<h5> <br>
                                        <input class="form-control" name="lead" id="lead" type="file" accept="text/csv">
                                    </div>
                                    <div class="modal-footer">
                                        <input name="id" type="hidden" value="<?=$id;?>">
                                        <input name="acao" id="acao" value="gravar" type="hidden">
                                        <button type="submit" class="btn btn-success" title="CONFIRMAR">CONFIRMAR</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                  </div>
              </td>
            </tr>
        <?}mysqli_free_result($query);?>
          </tbody>
        </table>
      </div>
    </div>
<? }
if ($acao=="excluir") {
    $update = "UPDATE $pagina_referencia SET data_excluir='".date('Y-m-d')."', hora_excluir='".date('H:i:s')."', status='d' WHERE id='".$id."' " or die(mysqli_error());
    if (!mysqli_query($conexao, $update)) {  
        die('Erro: '.mysqli_error($conexao)); 
    } else {
        echo "<meta http-equiv='refresh' content='0;URL=$pagina_referencia'>";
    }
}
if (isset($_POST['atribuir']) AND $_POST['atribuir']=='atribuir') {
    $id = (int)$_POST['id'];
    $id_vendedor = (int)$_POST['id_vendedor'];
    $id_produto = (int)$_POST['id_produto'];

    $update = "UPDATE $pagina_referencia SET id_produto='$id_produto', id_vendedor='$id_vendedor', data_editar='".date("Y-m-d")."', hora_editar='".date("H:i:s")."', status='a' WHERE id='$id'" or die(mysqli_error());
    if (!mysqli_query($conexao, $update)) {
      die('Erro: '.mysqli_error($conexao));
    }else{
        echo "<script>alert('Lead atribuido com sucesso!');</script>";
        echo "<meta http-equiv='refresh' content='0'>";
        exit();
    }
}
if (isset($_POST['confirmar']) AND $_POST['confirmar']=='confirmar') {
    $id = (int)$_POST['id'];

    $update = "UPDATE $pagina_referencia SET status='f', data_editar='".date("Y-m-d")."', hora_editar='".date("H:i:s")."' WHERE id='$id'" or die(mysqli_error());
    if (!mysqli_query($conexao, $update)) {
      die('Erro: '.mysqli_error($conexao));
    }else{
        echo "<script>alert('Lead atendido com sucesso!');</script>";
        echo "<meta http-equiv='refresh' content='0'>";
        exit();
    }
}
if (isset($_POST['ativar']) AND $_POST['ativar']=='ativar') {
    $id = (int)$_POST['id'];
    $id_produto = (int)$_POST['id_produto'];

    $update = "UPDATE $pagina_referencia SET status='a', data_editar='".date("Y-m-d")."', hora_editar='".date("H:i:s")."' WHERE id='$id'" or die(mysqli_error());
    if (!mysqli_query($conexao, $update)) {
      die('Erro: '.mysqli_error($conexao));
    }else{
        echo "<script>alert('$pagina_titulo ativado com sucesso!');</script>";
        echo "<meta http-equiv='refresh' content='0'>";
        exit();
    }
}
if ($acao=="atendidos") { ?>
    <div class="row">
        <div class="col-md-12  header-wrapper" >
            <h1 class="page-header"><?=mb_convert_case("$pagina_titulo", MB_CASE_TITLE, "UTF-8");?></h1>
            <p class="page-subtitle">Listagens dos leads em andamento do sistema.</p>
        </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <table class="table table-bordered table-hover" id="dataTables-userlist">
         <thead>
            <tr>
              <th>PRODUTO</th>
              <th>INFORMAÇÕES DE CONTATO</th>
              <th>VENDEDOR</th>
              <th>DATA ATRIBUÍÇÃO</th>
              <th>AÇÕES</th>
            </tr>
          </thead>
          <tbody>
          <?
            if (isset($usr_nivel) AND $usr_nivel=='10'){
                $condicao = "";
            }elseif (isset($usr_nivel) AND $usr_nivel=='20'){
                $condicao = "AND l.id_vendedor='".$_SESSION["usr_funcionario"]."'";
            }
            
            $sql = "SELECT l.id, l.nome AS nome, l.telefone, l.email, l.data_editar, l.hora_editar, p.produto, p.img, p.url_amigavel, v.responsavel_nome AS vendedor FROM produtos AS p RIGHT JOIN $pagina_referencia AS l ON (p.id=l.id_produto) LEFT JOIN vendedores AS v ON (l.id_vendedor=v.id) WHERE l.status='f' $condicao ORDER BY l.data_editar DESC";
            $query = mysqli_query($conexao, $sql);
            $classe="even ";

            while ($dados = mysqli_fetch_assoc($query)) {
                $id = $dados['id'];
                $produto = $dados['produto'];
                $url_amigavel = $dados['url_amigavel'];
                $nome = $dados['nome'];
                $vendedor = (($dados['vendedor']=='' OR $dados['vendedor']<1)?'Nenhum vendedor atribuído':$dados['vendedor']);
                $telefone = $dados['telefone'];
                $email = $dados['email'];
                $data_editar = $dados['data_editar'];
                $hora_editar = $dados['hora_editar'];
            
                $data = date("d/m/Y", strtotime($data_editar));
                $hora = date("H:i", strtotime($hora_editar));
                
                if ($dados['img']=='') {
                    $imagem = '../assets/img/produtos/sem_imagem.jpg';
                } elseif(file_exists('../assets/img/produtos/'.$dados['img'].'')){
                    $imagem = '../assets/img/produtos/'.$dados['img'].'';
                } else {
                    $imagem = "../assets/img/produtos/sem_imagem.jpg";
                } 
        ?>
            <tr class="<?=$classe;?>">
                <td style="text-align: -webkit-center;">
                <?echo ((isset($dados['produto']) AND $dados['produto']!='')?'<a href="../produto/'.$url_amigavel.'" target="_blank" rel="noopener" style="color:#000;"><img src="'.$imagem.'" alt="'.$produto.'" title="'.$produto.'" style="max-width: 50px;"><br>
                <h6 style="max-width: 350px;">'.$dados['produto'].'</h6></a>':'Nenhum produto atribuído');?>
                </td>
                <td>
                    <h4><?=$nome;?><h4>
                    <h5><?=$telefone;?><h5>
                    <h5><?=$email;?><h5>
                </td>
                <td class="center"><?=$vendedor;?></td>
                <td>
                    <?=$data;?><br>
                    <?=$hora;?>
                </td>
                <td>
                    <div class="socials tex-center">
                        <a href="atendimento-detalhes_<?=$id;?>" class="btn btn-circle btn-danger" data-toggle="tooltip" data-placement="top" title="Registro de comentários"><i class="fa fa-comments"></i></a>
                    </div>
                </td>
            </tr>
          <?}
          mysqli_free_result($query);?>
          </tbody>
        </table>
      </div>
    </div>
    <!-- /.row --> 
<? } 
if ($acao=="analise") { ?>
    <div class="row">
        <div class="col-md-12  header-wrapper" >
            <h1 class="page-header"><?=mb_convert_case("$pagina_titulo", MB_CASE_TITLE, "UTF-8");?></h1>
            <p class="page-subtitle">Análise detalhada dos leads do sistema.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 ">
          <div class="panel panel-default ">
            <div class="panel-body ">
              <form name="relatorio" action="" method="POST">
              <div class="col-md-4"> 
                <div class="form-group">
                  <label>PRODUTO</label>
                  <select class="form-control" name="id_produto">
                      <option value="">Todos</option>
                      <?
                      $sql_lead = "SELECT p.id, p.produto FROM $pagina_referencia AS l INNER JOIN produtos AS p ON (l.id_produto=p.id) GROUP BY l.id_produto ORDER BY l.id DESC";
                      $query_lead = mysqli_query($conexao, $sql_lead);
                        while ($dados_lead = mysqli_fetch_assoc($query_lead)){
                            if ($_POST['id_produto']==$dados_lead['id']) { $selecao = 'selected'; } else { $selecao = ''; }
                            echo '<option value="'.$dados_lead['id'].'" '.$selecao.'>'.$dados_lead['produto'].'</option>';
                        }
                       mysqli_free_result($query_lead);
                      ?>
                    </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>SITUAÇÃO</label>
                    <select class="form-control" name="status">
                      <option value="todos" <?echo ((isset($_POST['status']) AND $_POST['status']=='todos')?'selected':'');?>>Todas</option>
                      <option value="a" <?echo ((isset($_POST['status']) AND $_POST['status']=='a')?'selected':'');?>>Em Aberto</option>
                      <option value="f" <?echo ((isset($_POST['status']) AND $_POST['status']=='f')?'selected':'');?>>Atendidos</option>
                    </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>PLATAFORMA</label>
                    <select class="form-control" name="plataforma">
                      <option value="" <?echo ((isset($_POST['plataforma']) AND $_POST['plataforma']=='')?'selected':'');?>>Todas</option>
                      <option value="ig" <?echo ((isset($_POST['plataforma']) AND $_POST['plataforma']=='ig')?'selected':'');?>>Instagram</option>
                      <option value="fb" <?echo ((isset($_POST['plataforma']) AND $_POST['plataforma']=='fb')?'selected':'');?>>Facebook</option>
                      <option value="ma" <?echo ((isset($_POST['plataforma']) AND $_POST['plataforma']=='ma')?'selected':'');?>>Manual</option>
                      <option value="si" <?echo ((isset($_POST['plataforma']) AND $_POST['plataforma']=='si')?'selected':'');?>>Site</option>
                    </select>
                </div>
              </div>
              <div class="col-md-2"> 
                <div class="form-group">
                  <label >DATA INÍCIO</label>
                  <input type="date" name="data_inicio" value="<?echo ((isset($_POST['data_inicio']) AND $_POST['data_inicio']!='')?$_POST['data_inicio']:date("Y").'-'.date("m").'-01');?>" class="form-control" required>
                </div>
              </div>
               <div class="col-md-2"> 
                <div class="form-group">
                  <label >DATA FIM</label>
                  <input type="date" name="data_fim" class="form-control" value="<?echo ((isset($_POST['data_fim']) AND $_POST['data_fim']!='')?$_POST['data_fim']:date("Y-m-d"));?>" required>
                </div>
              </div>
              <div class="col-md-12"> </div>
                <div class="col-md-12">
                <div class="form-group">
                  <label></label>
                  <button type="submit" name="gerar_analise" value="enviar" class="btn btn-success" style="float:right;"><i class="fa fa-check"></i> Gerar Análise</button>
                </div>
              </div>
            </form>
            </div>
          </div>
        </div>
    </div>
    <?
    if (isset($_POST['gerar_analise']) AND $_POST['gerar_analise']=='enviar'){

        $id_produto = ((isset($_POST['id_produto']) AND $_POST['id_produto']!='')?$_POST['id_produto']:'');
        $data_inicio = $_POST['data_inicio'];
        $data_fim = $_POST['data_fim'];
        $plataforma = $_POST['plataforma'];
        $status = $_POST['status'];
        
        $tipo = "";
        if (isset($status) AND $status!='' AND $status!='todos'){
            $tipo .= " AND status='$status'";
        }else{
            $tipo .= "";
        }
        if (isset($id_produto) AND $id_produto!=''){
            $tipo .= " AND id_produto='$id_produto'";
        }
        if (isset($plataforma) AND $plataforma!=''){
            $tipo .= " AND plataforma='$plataforma'";
        }
        
        $sql_leads = mysqli_query($conexao, "SELECT plataforma FROM $pagina_referencia WHERE data BETWEEN '$data_inicio' AND '$data_fim'$tipo");
        $rows_leads = mysqli_num_rows($sql_leads);
        if ($rows_leads>0){
    ?>
            <div class="row">
              <div class="flot-chart-content" id="flot-line-chart-plataforma" style="display:none;"></div>
              <div class="col-lg-6">
                <div class="panel panel-default">
                    <?
                    $contador_fb = 0;
                    $contador_insta = 0;
                    $contador_si = 0;
                    $contador_ma = 0;
                    while ($dados_leads = mysqli_fetch_assoc($sql_leads)){
                        if ($dados_leads["plataforma"]=='fb'){
                            $contador_fb++;
                        }elseif($dados_leads["plataforma"]=='ig'){
                            $contador_insta++;
                        }elseif($dados_leads["plataforma"]=='si'){
                            $contador_si++;
                        }elseif($dados_leads["plataforma"]=='ma'){
                            $contador_ma++;
                        }else{
                            $contador_si++;
                        }
                    }
                    ?>
                    <input type="hidden" id="total" value="<?=$rows_leads;?>">
                    <input type="hidden" id="facebook" value="<?=$contador_fb;?>">
                    <input type="hidden" id="instagram" value="<?=$contador_insta;?>">
                    <input type="hidden" id="site" value="<?=$contador_si;?>">
                    <input type="hidden" id="manual" value="<?=$contador_ma;?>">
                    <div class="panel-heading"> Análise das Plataformas (Porcentagem) </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="flot-chart">
                            <div class="flot-chart-content" id="flot-pie-chart-plataforma"></div>
                        </div>
                    </div>
                  <!-- /.panel-body --> 
                </div>
                <!-- /.panel --> 
              </div>
              <div class="col-lg-6">
                <div class="panel panel-default">
                  <div class="panel-heading"> Análise das Plataformas (Total) </div>
                  <!-- /.panel-heading -->
                  <div class="panel-body">
                    <div id="morris-donut-chart"></div>
                  </div>
                  <!-- /.panel-body --> 
                </div>
                <!-- /.panel --> 
              </div>
              <div id="morris-area-chart" style="display: none;"></div>
            </div>
        <?}else{?>
            <div class="row">
                <div class="col-lg-12 ">
                  <div class="panel panel-default ">
                    <div class="panel-body ">
                      <h3 style="color:red;">Não foram encontrados leads de acordo com os dados informados!</h3>
                      <p>Você poderá alterar os filtros a qualquer momento!</p>
                      <hr>
                    </div>
                  </div>
                </div>
            </div>
    <?}}?>
<? }
if ($acao=="") { ?>
    <div class="row">
        <div class="col-md-12  header-wrapper" >
            <h1 class="page-header"><?=mb_convert_case("$pagina_titulo", MB_CASE_TITLE, "UTF-8");?></h1>
            <p class="page-subtitle">Listagens dos leads do empreendimento.</p>
            <div class="pull-right">
                <a href="<?=$pagina_referencia;?>-cadastrar" title="Cadastrar" class="btn btn-primary">+ CADASTRAR</a>
            </div>
        </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <table class="table table-bordered table-hover" id="dataTables-userlist">
         <thead>
            <tr>
              <th>PRODUTO</th>
              <th>INFORMAÇÕES DE CONTATO</th>
              <th>VENDEDOR</th>
              <th>DATA</th>
              <th>AÇÕES</th>
            </tr>
          </thead>
          <tbody>
          <?
          
            if (isset($usr_nivel) AND $usr_nivel=='10'){
                $condicao = "";
            }elseif (isset($usr_nivel) AND $usr_nivel=='20'){
                $condicao = "AND l.id_vendedor='".$_SESSION["usr_funcionario"]."'";
            }

          $sql = "SELECT l.id, l.plataforma, l.nome AS nome, l.telefone, l.email, l.data_captacao, p.produto, p.img, p.url_amigavel, p.id AS id_produto, v.responsavel_nome AS vendedor FROM produtos AS p RIGHT JOIN $pagina_referencia AS l ON (p.id=l.id_produto) LEFT JOIN vendedores AS v ON (l.id_vendedor=v.id) WHERE l.status='a' $condicao ORDER BY l.data_captacao DESC";
          $query = mysqli_query($conexao, $sql);
          $classe="even ";

          while ($dados = mysqli_fetch_assoc($query)) {
            $id = $dados['id'];
            $nome = $dados['nome'];
            $vendedor = (($dados['vendedor']=='' OR $dados['vendedor']<1)?'Nenhum vendedor atribuído':$dados['vendedor']);
            $produto = $dados['produto'];
            $id_produto = $dados['id_produto'];
            $url_amigavel = $dados['url_amigavel'];
            $telefone = $dados['telefone'];
            $email = $dados['email'];
            $data_captacao = $dados['data_captacao'];
            if ($classe=="odd") { $classe="even "; } else {$classe="odd"; }
            
            if ($dados['img']=='') {
                $imagem = '../assets/img/produtos/sem_imagem.jpg';
            } elseif(file_exists('../assets/img/produtos/'.$dados['img'].'')){
                $imagem = '../assets/img/produtos/'.$dados['img'].'';
            } else {
                $imagem = "../assets/img/produtos/sem_imagem.jpg";
            } 
        ?>
            <tr class="<?=$classe;?>">
                <td style="text-align: -webkit-center;">
                <?echo ((isset($dados['produto']) AND $dados['produto']!='')?'<a href="../produto/'.$url_amigavel.'" target="_blank" rel="noopener" style="color:#000;"><img src="'.$imagem.'" alt="'.$produto.'" title="'.$produto.'" style="max-width: 50px;"><br>
                '.$dados['produto'].'</a>':'Nenhum produto atribuído');?>
                </td>
                <td>
                    <h4><?=$nome;?></h4>
                    <h5><?=$telefone;?></h5>
                    <h5><?=$email;?></h5>
                </td>
                <td><?=$vendedor;?></td>
                <td><?=date("d/m/Y", strtotime($data_captacao));?></td>
                <td>
                    <div class="socials tex-center">
                        <a href="#" data-toggle="modal" data-target="#myModal<?=$id;?>" class="btn btn-circle btn-success" title="Dar Baixa"><i class="fa fa-check"></i></a>
                        <div class="modal fade" id="myModal<?=$id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <form action="" method="POST">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel3">Dar Baixa</h4>
                                        </div>
                                        <div class="modal-body"><h5>Este lead será considerado como atendido!<h5></div>
                                        <div class="modal-footer">
                                            <input type="hidden" name="id" value="<?=$id;?>">
                                            <button type="submit" name="confirmar" value="confirmar" class="btn btn-success" role="button" aria-pressed="true" title="CONFIRMAR">CONFIRMAR</a>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?if ($usr_nivel=='10'){?>
                            <a href="#" class="btn btn-circle btn-primary" data-toggle="modal" data-target="#editar<?=$id;?>" title="Editar"><i class="fa fa-pencil"></i></a>
                            <a href="atendimento-detalhes_<?=$id;?>" class="btn btn-circle btn-danger" data-toggle="tooltip" data-placement="top" title="Registro de comentários"><i class="fa fa-comments"></i></a>
                        <?}else{?>
                        <a href="atendimento-detalhes_<?=$id;?>" class="btn btn-circle btn-danger" data-toggle="tooltip" data-placement="top" title="Registro de comentários"><i class="fa fa-comments"></i></a>
                        
                        <?}?>
                    </div>
                </td>
            </tr>
            <div class="modal fade" id="editar<?=$id;?>" tabindex="-1" role="dialog" aria-labelledby="editar" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <form method="POST" action="">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel3">Atribuir lead</h4>
                            </div>
                            <div class="modal-body">
                                <h5 class="modal-title">Escolha qual vendedor irá receber o lead</h5><br>
                                <div class="col-md-6">
                                    <div class="form-group" style="width: 100%;">
                                        <label>VENDEDOR </label>
                                        <?
                                          $sql_vendedor = "SELECT id, responsavel_nome FROM vendedores WHERE status='a' AND id>1 ORDER BY responsavel_nome ASC";
                                          $query_vendedor = mysqli_query($conexao, $sql_vendedor);
                                          $num_rows_vendedor = mysqli_num_rows($query_vendedor);
                                          $opton = '';
                                          while ($dados_vendedor = mysqli_fetch_assoc($query_vendedor)) {
                                           $opton .= '<option value="'.$dados_vendedor['id'].'" '.(($vendedor==$dados_vendedor['responsavel_nome'])?'selected':'').'>'.$dados_vendedor['responsavel_nome'].'</option>';
                                          }
                                        ?>
                                        <select class="form-control" name="id_vendedor" id="id_vendedor" style="width: 100%;">
                                             <?=$opton;?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6"> 
                                    <div class="form-group" style="width: 100%;">
                                        <label>PRODUTO</label>
                                        <input type="text" class="form-control" list="itens" name="id_produto" id="id_produto" placeholder="Nenhum" value="<?=$id_produto;?>" style="width: 100%;">
                                        <datalist id="itens">
                                            <?
                                            $query_p = mysqli_query($conexao, "SELECT id, produto, sku FROM produtos WHERE status='a' ORDER BY id DESC");
                                            if (mysqli_num_rows($query_p)>0){
                                                while ($dados_p = mysqli_fetch_assoc($query_p)){
                                            ?>
                                                <option value="<?=$dados_p['id'];?>">ID: <?=$dados_p['id'];?> | <?=$dados_p['produto'];?></option>
                                            <?}}?>
                                        </datalist>
                                    </div>
                                </div>
                            </div><br><br>
                            <div class="modal-footer">
                                <input type="hidden" name="id" value="<?=$id;?>">
                                <button type="submit" name="atribuir" value="atribuir" class="btn btn-success">CONFIRMAR</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button>
                            </div>
                        </div>
                    </form>
                <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog --> 
            </div>
            <div class="modal fade" id="myModal<?=$id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <form action="" method="POST">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel3">Dar Baixa</h4>
                            </div>
                            <div class="modal-body"><h5>Este lead será considerado como atendido!<h5></div>
                            <div class="modal-footer">
                                <input type="hidden" name="id" value="<?=$id;?>">
                                <button type="submit" name="confirmar" value="confirmar" class="btn btn-success" role="button" aria-pressed="true" title="CONFIRMAR">CONFIRMAR</a>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
          <?}mysqli_free_result($query);?>
          </tbody>
        </table>
      </div>
    </div>
    <!-- /.row --> 
<? } ?>
 
<!-- Include Editor JS files. -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.8.4/js/froala_editor.pkgd.min.js"></script>
<!-- /#wrapper -->
<!-- jQuery --> 
<!-- Bootstrap Core JavaScript --> 
<script src="vendor/bootstrap/js/bootstrap.min.js"></script> 
<!-- DataTables JavaScript --> 
<script src="vendor/datatables/js/jquery.dataTables.min.js"></script> 
<script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script> 
<script src="vendor/datatables-responsive/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.12/sorting/date-eu.js"></script>
<!-- Custom Theme JavaScript --> 
<script src="js/adminnine.js"></script>

<?if ($acao=='analise'){?>

<script src="vendor/flot/excanvas.min.js"></script> 
<script src="vendor/flot/jquery.flot.js"></script> 
<script src="vendor/flot/jquery.flot.pie.js"></script> 
<script src="vendor/flot/jquery.flot.resize.js"></script> 
<script src="vendor/flot/jquery.flot.time.js"></script> 
<script src="vendor/flot-tooltip/jquery.flot.tooltip.min.js"></script> 
<script src="vendor/flot/flot-data.js"></script> 

<script src="vendor/raphael/raphael.js"></script> 
<script src="vendor/morrisjs/morris.min.js"></script> 
<script src="vendor/morrisjs/morris-data.js"></script> 

<?}?>
<script>
<?if ($acao=='anexar'){?>
$(document).ready(function() {
    $('#dataTables-userlist').DataTable({
        responsive: true,
        pageLength:10,
        sPaginationType: "full_numbers",
        oLanguage: {
            oPaginate: {
                sFirst: "<<",
                sPrevious: "<",
                sNext: ">", 
                sLast: ">>" 
            }
        },
        order: [ 0, 'desc' ],
    });
});
<?}else{?>
$(document).ready(function() {
    $('#dataTables-userlist').DataTable({
        responsive: true,
        pageLength:10,
        sPaginationType: "full_numbers",
        oLanguage: {
            oPaginate: {
                sFirst: "<<",
                sPrevious: "<",
                sNext: ">", 
                sLast: ">>" 
            }
        },
        columnDefs: [
            {
                type: 'date-eu', 
                targets: 3
            }
        ],
        order: [ 3, 'desc' ],
    });
});
<?}?>
</script>
<?
$cntACmp = ob_get_contents();
ob_end_clean();
$cntACmp = str_replace("\n", ' ', $cntACmp);
$cntACmp = preg_replace('/[[:space:]]+/', ' ', $cntACmp);
echo $cntACmp;
ob_end_flush();
?>