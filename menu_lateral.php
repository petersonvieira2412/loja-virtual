  <div class="navbar-default sidebar" >
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" > <span class="sr-only">Alternar de navega&ccedil;&atilde;o</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <a class="navbar-brand" href="home">Painel de Controle</a> </div>
    <div class="clearfix"></div>
    <div class="sidebar-nav navbar-collapse"> 
      
      <!-- user profile pic -->
      <div class="userprofile text-center">
        <div class="userpic"> <img src="img/funcionario/<?=$usr_foto;?>" alt="<?=$_SESSION["usr_nome"];?>" title="<?=$_SESSION["usr_nome"];?>" class="userpicimg"></div>
        <h3 class="username"><?=ucwords($_SESSION["usr_nome"]);?></h3>
      </div>
      <div class="clearfix"></div>
      <!-- user profile pic -->
      
      <ul class="nav" id="side-menu">
        <li> <a href="home" title="P&aacute;gina Inicial"><i class="fa fa-home" aria-hidden="true"></i> P&aacute;gina Inicial</a> </li>     
        <li> <a href="clientes" title="P&aacute;gina Inicial"><i class="fa fa-users fa-fw"></i> Clientes</a> </li>
        
        <li> <a href="javascript:void(0)" class="menudropdown" title="Categorias"><i class="fa fa-folder" aria-hidden="true"></i> Categorias <span class="fa arrow"></span></a>
          <ul class="nav nav-second-level">
            <li> <a href="categorias" title="Listar Categorias">Listar</a> </li>
            <li> <a href="categorias-cadastrar" title="Adicionar Categoria">Cadastrar</a> </li>
            <li> <a href="categorias-migrar" title="Migrar Categoria">Migrar</a> </li>
            <li> <a href="categorias-reajustar" title="Reajustar Valor da Categoria">Reajustar R$</a> </li>
          </ul>
        </li>

        <li> <a href="javascript:void(0)" class="menudropdown"><i class="fa fa-shopping-cart"></i> Produtos <span class="fa arrow"></span></a>
          <ul class="nav nav-second-level">
            <li> <a href="produtos" title="Listar Produtos">Listar</a> </li>
            <li> <a href="produtos-cadastrar" title="Adicionar Produtos">Cadastrar</a></li>
            <li> <a href="lixeira" title="Restaurar Produtos">Lixeira</a></li>
          </ul>
        </li>
        
        <li> <a  href="javascript:void(0)" class="menudropdown"><i class="fa fa-dollar"></i> Pedidos <span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
                <li> <a href="pedidos" title="Listar">Listar</a> </li>
            </ul>
        </li>

        <li> <a href="javascript:void(0)" class="menudropdown" title="Destaque"><i class="fa fa-picture-o"></i> Destaque <span class="fa arrow"></span></a>
		    <ul class="nav nav-second-level">
                <li> <a href="destaque" title="Listar Destaques">Listar Destaques</a> </li>
                <li> <a href="destaque-cadastrar" title="Adicionar Foto">Adicionar Foto</a> </li>
                <li> <a href="destaque-video" title="Adicionar Video">Adicionar Video</a> </li>
                <li> <a href="destaque-lixeira" title="Lixeira">Lixeira</a> </li>
            </ul>
		</li>
		
		<li> <a href="javascript:void(0)" class="menudropdown" title="Blog"><i class="fa fa-pencil"></i> Blog <span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
                <li> <a href="blog" title="Listar Post">Listar Posts</a> </li>
                <li> <a href="blog-cadastrar" title="Adicionar Post">Cadastrar Post</a> </li>
                <li> <a href="blog-categorias" title="Categorias de Post">Categorias de Post</a> </li>
    			<li> <a href="blog-lixeira" title="Lixeira">Lixeira</a> </li>
            </ul>
        </li>
        
        <li> <a href="javascript:void(0)" class="menudropdown" title="Banner"><i class="fa fa-picture-o"></i> Banner <span class="fa arrow"></span></a>
		    <ul class="nav nav-second-level">
                <li> <a href="banners" title="Listar Banners">Listar Banner</a> </li>
            </ul>
		</li>
		
		
        <li> <a href="javascript:void(0)" class="menudropdown"><i class="fa fa-tasks icon"></i> Cores <span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
                <li> <a href="cores" title="Listar Cores">Listar</a> </li>
                <li> <a href="cores-cadastrar" title="Adicionar Cores">Cadastrar</a></li>
            </ul>
        </li>     
        
        <li> <a href="javascript:void(0)" class="menudropdown"><i class="fa fa-tasks icon"></i> Tamanhos <span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
                <li> <a href="tamanhos" title="Listar Tamanhos">Listar</a> </li>
                <li> <a href="tamanhos-cadastrar" title="Adicionar Tamanhos">Cadastrar</a></li>
            </ul>
        </li>
        
        <li> <a  href="javascript:void(0)" class="menudropdown"><i class="fa fa-table"></i> Planilhas <span class="fa arrow"></span></a>
          <ul class="nav nav-second-level">
            <li><a href="planilha-categorias" target="_blank" title="Gerar Planilha das Categorias">Categorias</a></li>
            <li><a href="planilha-produtos" target="_blank" title="Gerar Planilha dos Produtos">Produtos</a></li>
          </ul>
        </li>          
        <li> <a href="javascript:void(0)" class="menudropdown"><i class="fa fa-tags fa-fw"></i> Cupons de Desconto <span class="fa arrow"></span></a>
          <ul class="nav nav-second-level">
            <li> <a href="cupons" title="Listar Cupons">Listar</a> </li>
            <li> <a href="cupons-cadastrar" title="Cadastrar Cupons">Cadastrar</a></li>
          </ul>
        </li>   
        <li> <a href="relatorio" title="Relatórios"><i class="fa fa-line-chart fa-fw"></i> Relatórios</a> </li>     
        <li> <a id="lnkXml" href="javascript:void(0)" class="menudropdown"><i class="fa fa-file-code-o"></i> XML <span class="fa arrow"></span></a>
          <ul class="nav nav-second-level">
            <li><a href="javascript:void(0);" onclick="$('#xmlverModal').modal()">Visualizar</a></li>
			<li><a href="javascript:void(0);" onclick="$('#xmlModal').modal()">Gerar</a></li>
          </ul>
        </li>   
 		<li> <a href="javascript:void(0)" class="menudropdown"><i class="fa fa-user"></i> Usuários <span class="fa arrow"></span></a>
          <ul class="nav nav-second-level">
            <li> <a href="usuarios" title="Listar Usuários">Listar</a> </li>
            <li> <a href="usuarios-cadastrar" title="Cadastrar Usuários">Cadastrar</a></li>
          </ul>
        </li>
 		<li> <a href="javascript:void(0)" class="menudropdown"><i class="fa fa-user"></i> Fabricantes <span class="fa arrow"></span></a>
          <ul class="nav nav-second-level">
            <li> <a href="fabricante" title="Listar Fabricantes">Listar</a> </li>
            <li> <a href="fabricante-cadastrar" title="Cadastrar Fabricantes">Cadastrar</a></li>
          </ul>
        </li>
		<li> <a  href="javascript:void(0)" class="menudropdown"><i class="fa fa-cog"></i> Configura&ccedil;&otilde;es <span class="fa arrow"></span></a>
          <ul class="nav nav-second-level">
            <li><a href="paginas">Páginas</a></li>
			<li><a href="<?=$psite;?>" target="_blank">Site</a></li>
            <li><a href="sair">Sair</a></li>
          </ul>
        </li>          
        
      </ul>
    </div>
    <!-- /.sidebar-collapse --> 
  </div>
  <!-- /.navbar-static-side -->
  

	<div class="modal fade" id="xmlverModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel3">Visualizar XML</h4>
		  </div>
		  <div class="modal-body">

				<div class="col-md-12 form-group">
				  <label>Selecione o domínio</label>
				  <select id="selDominioXml" class="form-control" name="dominios" style="width:100%;">
					<optgroup label="Principal">
					<?php
						$qrD = mysqli_query($conexao,"SELECT * FROM dominios WHERE principal='sim'");
						while($lnD=mysqli_fetch_array($qrD)){
					?>
					<option value="<?=str_replace('.','-',$lnD['dominio'])?>" data-principal="<?=$lnD['principal']?>"><?=$lnD['dominio']?></option>
					<?php
						}
					?>
					</optgroup>
					<optgroup label="Adicionais">
					<?php
						$qrD = mysqli_query($conexao,"SELECT * FROM dominios WHERE principal='nao'");
						while($lnD=mysqli_fetch_array($qrD)){
					?>
					<option value="<?=str_replace('.','-',$lnD['dominio'])?>" data-principal="<?=$lnD['principal']?>"><?=$lnD['dominio']?></option>
					<?php
						}
					?>
					</optgroup>
				  </select>
				</div>

				<div class="col-md-12"></div>

				<div class="col-md-6 form-group">
				  <label>Visualizar XML gerado</label>
				  <a id="lnkVerXmlSitemap" href="<?=$psite?>/sitemap.xml" target="_blank" class="btn btn-primary" style="width:100%;">SITEMAP</a>
				</div>

			
				<div class="col-md-6">
				  <label>&nbsp;</label>
				  <a id="lnkVerXmlGoogleShopping" href="<?=$psite?>/xml-google-shopping.xml" target="_blank" class="btn btn-primary" style="width:100%;">Google Shopping</a>
				</div>
				
		  </div>
		  <div class="modal-footer">
			<div class="col-md-12">
				<br><br>
				<button type="button" class="btn btn-default" onclick="$('#xmlverModal').modal('hide');">FECHAR</button>
			</div>
		  </div>
		</div>
		<!-- /.modal-content --> 
	  </div>
	  <!-- /.modal-dialog --> 
	</div>
	
	<div class="modal fade" id="xmlModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
			<form id="frmXML" method="post" action="">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel3">Gerar sitemap.xml e google-shopping.xml</h4>
			  </div>
			  <div class="modal-body">
				<div class="col-md-12">
					<div class="form-group">
					  <div><label>Selecione o(s) domínio(s)</label></div>
						<?php
							$qrD = mysqli_query($conexao,"SELECT * FROM dominios");
							while($lnD=mysqli_fetch_array($qrD)){
						?>
						<div class="form-check">
						  <input class="form-check-input" type="checkbox" name="dominios[]" value="<?=$lnD['dominio']?>" id="defaultCheck<?=$lnD['id']?>">
						  <label class="form-check-label" for="defaultCheck<?=$lnD['id']?>">
							<?=$lnD['dominio']?>
						  </label>
						</div>
						<?php
							}
						?>
					</div>
				</div>
			  </div>
			  <div class="modal-footer">
				<div class="col-md-12">
			  <br><br>
					<input type="hidden" name="acao" value="gerarxml">
					<button type="button" class="btn btn-default" onclick="$('#xmlModal').modal('hide');">FECHAR</button>
					<button type="button" class="btn btn-success" onclick="gerarXML();">GERAR</button>
				</div>
			  </div>
			</form>
		</div>
		<!-- /.modal-content --> 
	  </div>
	  <!-- /.modal-dialog --> 
	</div>

	<div id="pnlFundo" style="position: fixed;z-index:99999999999;cursor:progress;display:none;top:0px;left:0px;width:100%;height:100%;background:rgba(0,0,0,.8);">
		<div style="position:absolute;top:50%;margin-top:-15px;width:100%;text-align:center;height:30px;line-height:30px;font-size:30px;color:#fff;font-weight:600;">GERANDO XML AGUARDE...</div>
	</div>