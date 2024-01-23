<div class="row">
      <nav class="navbar navbar-default navbar-static-top" style="margin-bottom: 0">
       <? if ($pag!='home') { ?>
        <a href="<?=$pag;?>" class="dropdown-toggle" title="Voltar P&aacute;gina"><i class="fa fa-arrow-circle-left" style="font-size: 45px; float: left; "></i> </a>
		<? } ?>
        <button class="menubtn pull-left btn "><i class="glyphicon  glyphicon-th"></i></button>
        <ul class="nav navbar-top-links navbar-right">
         
          <li class="dropdown"> <a class="dropdown-toggle userdd" data-toggle="dropdown" href="javascript:void(0)">
            <div class="userprofile small "> <span class="userpic"> <img src="img/funcionario/<?=$usr_foto;?>" alt="<?=$_SESSION["usr_nome"];?>" title="<?=$_SESSION["usr_nome"];?>" class="userpicimg"> </span>
              <div class="textcontainer">
                <h3 class="username"><?=ucwords($_SESSION["usr_nome"]);?></h3>
                <p><?=date("d/m/Y")?></p>
              </div>
            </div>
            <i class="caret"></i> </a>
            <ul class="dropdown-menu dropdown-user">
              <li> <a href="sair" title="Sair do Sistema"><i class="fa fa-sign-out fa-fw"></i> Sair</a> </li>
            </ul>
          </li>
        </ul>
        
      </nav>
    </div>