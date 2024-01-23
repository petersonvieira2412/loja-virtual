  <div class="navbar-default sidebar" >
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" > <span class="sr-only">Alternar de navegação</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <a class="navbar-brand" href="home">Painel de Controle</a> </div>
    <div class="clearfix"></div>
    <div class="sidebar-nav navbar-collapse"> 
      
      <!-- user profile pic -->
      <div class="userprofile text-center">
        <div class="userpic"> <img src="img/funcionario/profile.png" alt="<?=$nome_funcionario;?>" title="<?=$nome_funcionario;?>" class="userpicimg"> <a href="perfil" class="btn btn-primary settingbtn" title="<?=$nome_funcionario;?>"><i class="fa fa-gear"></i></a> </div>
        <h3 class="username"><?=$nome_funcionario;?></h3>
      </div>
      <div class="clearfix"></div>
      <!-- user profile pic -->
      
      <ul class="nav" id="side-menu">
        <li> <a href="home" title="Página Inicial"><i class="fa fa-dashboard fa-fw"></i> Home</a> </li>
        <li> <a href="javascript:void(0)" class="menudropdown" title="Categorias"><i class="fa fa-folder-open-o"></i> Categorias <span class="fa arrow"></span></a>
          <ul class="nav nav-second-level">
            <li> <a href="categoria" title="Listar Categoria">Listar</a> </li>
            <li> <a href="categoria-adicionar" title="Adicionar Categoria">Adicionar</a> </li>
            <li> <a href="categoria-migrar" title="Migrar Categoria">Migrar</a> </li>
            <li> <a href="categoria-reajustar" title="Reajustar Valor da Categoria">Reajustar R$</a> </li>
          </ul>
        </li>

        <li> <a href="javascript:void(0)" class="menudropdown"><i class="fa fa-shopping-cart"></i> Produtos <span class="fa arrow"></span></a>
          <ul class="nav nav-second-level">
            <li> <a href="produtos" title="Listar Produtos">Listar</a> </li>
            <li> <a href="produtos-adicionar" title="Adicionar Produtos">Adicionar</a> </li>
            <li> <a href="produtos-vendidos" title="Mais Vendidos">Mais Vendidos <span class="badge red">10</span></a> </li>
            <li> <a href="produtos-vistos" title="Mais Visualizados">Mais Visualizados <span class="badge blue">10</span></a> </li>
          </ul>
        </li>

        <li> <a href="javascript:void(0)" class="menudropdown"><i class="fa fa-cubes"></i> App Pages <span class="badge">12</span><span class="fa arrow"></span></a>
          <ul class="nav nav-second-level">
            <li><a href="mail.html">Mailbox</a></li>
            <li><a href="user_list.html">User List</a></li>
            <li><a href="user_records.html">User Record</a></li>
            <li><a href="socialprofile.html">Social Profile</a></li>
            <li><a href="calendar.html">Calendar</a></li>
            <li><a href="timeline.html">Timeline</a></li>
            <li><a href="pricing.html">Pricing</a></li>
            <li><a href="services.html">Services</a></li>
            <li><a href="invoice.html">Invoice</a></li>
            <li><a href="gallery.html">Gallery</a></li>
            <li><a href="aboutus.html">About</a></li>
            <li><a href="contact.html">Contact</a></li>
          </ul>
          <!-- /.nav-second-level --> 
        </li>
        <li> <a href="javascript:void(0)" class="menudropdown"><i class="fa fa-bar-chart-o fa-fw"></i> Charts & Maps<span class="badge red">6</span><span class="fa arrow"></span></a>
          <ul class="nav nav-second-level">
            <li> <a href="flot.html">Flot Charts</a> </li>
            <li> <a href="morris.html">Morris.js Charts</a> </li>
            <li> <a href="chartjs.html">Chart.js Charts</a> </li>
            <li> <a href="jvectormap.html">jVectormap</a> </li>
            <li> <a href="googlemap.html">Google map</a> </li>
            <li> <a href="googlemapfull.html">Google map full</a> </li>
          </ul>
          <!-- /.nav-second-level --> 
        </li>
        <li> <a  href="javascript:void(0)" class="menudropdown"><i class="fa fa-files-o fa-fw"></i> Sample Pages <span class="badge green">10</span><span class="fa arrow"></span></a>
          <ul class="nav nav-second-level">
            <li><a href="blank.html">Blank Page</a></li>
            <li> <a href="login.html">Login</a></li>
            <li><a href="register.html">Sign up</a></li>
            <li><a href="forgotpassword.html">Forgot password</a></li>
            <li><a href="lock.html">Lock</a></li>
            <li><a href="404.html">404</a></li>
            <li><a href="500.html">500</a></li>
            <li><a href="searchresult.html">Search Result</a></li>
            <li><a href="FAQs.html">FAQs</a></li>
            <li><a href="commingsoon.html">Coming Soon...</a></li>
          </ul>
          <!-- /.nav-second-level --> 
        </li>
        <li> <a href="tables.html"><i class="fa fa-table fa-fw"></i> Tables</a> </li>
        <li> <a href="forms.html"><i class="fa fa-edit fa-fw"></i> Forms</a> </li>
        <li> <a  href="javascript:void(0)" class="menudropdown"><i class="fa fa-wrench fa-fw"></i> UI Elements <span class="badge yellow">12</span> <span class="fa arrow"></span></a>
          <ul class="nav nav-second-level">
            <li><a href="panels-wells.html">Panels and Wells</a></li>
            <li><a href="accordion.html">Accordion</a></li>
            <li><a href="Tabs.html">Tabs</a></li>
            <li><a href="buttons.html">Buttons</a></li>
            <li><a href="notifications.html">Notifications</a></li>
            <li><a href="modal.html">Modal</a></li>
            <li><a href="popover.html">Popover</a></li>
            <li><a href="typography.html">Typography</a></li>
            <li><a href="icons.html"> Icons</a></li>
            <li><a href="grid.html">Grid</a></li>
            <li><a href="progressbar.html">Progress bar</a></li>
            <li><a href="rangeslider.html">Range Slider</a></li>
          </ul>
          <!-- /.nav-second-level --> 
        </li>
        <li> <a  href="javascript:void(0)" class="menudropdown"><i class="fa  fa-shopping-cart fa-fw"></i>eCommerce<span class="badge blue">3</span> <span class="fa arrow"></span></a>
          <ul class="nav nav-second-level">
            <li><a href="products.html">Products</a></li>
            <li><a href="product_details.html">Product Details</a></li>
            <li><a href="products_orderstatus.html">Order status</a></li>
          </ul>
          <!-- /.nav-second-level --> 
        </li>          
        <li> <a  href="javascript:void(0)" class="menudropdown"><i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
          <ul class="nav nav-second-level">
            <li> <a href="javascript:void(0)">Second Level Item</a> </li>
            <li> <a href="javascript:void(0)">Second Level Item</a> </li>
              <!-- .nav-third-level menudropdown2 --> 
            <li> <a href="javascript:void(0)" class="menudropdown2">Third Level <span class="fa arrow"></span></a>
              <ul class="nav nav-third-level" >
                <li> <a href="javascript:void(0)">Third Level Item</a> </li>
                <li> <a href="javascript:void(0)">Third Level Item</a> </li>
                <li> <a href="javascript:void(0)">Third Level Item</a> </li>
                <li> <a href="javascript:void(0)">Third Level Item</a> </li>
              </ul>
              <!-- /.nav-third-level --> 
            </li>
          </ul>
          <!-- /.nav-second-level --> 
        </li>
        
      </ul>
    </div>
    <!-- /.sidebar-collapse --> 
  </div>
  <!-- /.navbar-static-side -->
