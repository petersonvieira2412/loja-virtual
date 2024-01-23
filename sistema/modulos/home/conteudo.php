<?php
  include_once "config.php";
  $pagina_titulo = "home";
  $pagina_referencia = "home";
?>
    <div class="row">
      <div class="col-md-12  header-wrapper" >
        <h1 class="page-header">Painel de Controle</h1>
        <p class="page-subtitle">Estamos reformulando nosso painel.</p>
      </div>
      <!-- /.col-lg-12 --> 
    </div>
    <!-- /.row -->
    
    <ol class="breadcrumb">
      <li><a href="javascript:void(0)">Sistema</a></li>
      <li class="active">Painel de Controle</li>
    </ol>
    
    <!-- /.row -->
    
    <div class="row">
      <div class="col-lg-3 col-sm-6">
        <div class="panel panel-blue">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-6">
                <div id="morris-bar-chart2" ></div>
              </div>
              <div class="col-xs-6 text-right">
                <div class="huge">26</div>
                <div>Comments!</div>
              </div>
            </div>
          </div>
          <a href="javascript:void(0)">
          <div class="panel-footer"> <span class="pull-left">View Details</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
            <div class="clearfix"></div>
          </div>
          </a> </div>
      </div>
      <div class="col-lg-3 col-sm-6">
        <div class="panel panel-green">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-3"> <i class="fa fa-tasks fa-2x"></i> </div>
              <div class="col-xs-9 text-right">
                <div class="huge">12</div>
                <div>New Tasks!</div>
              </div>
            </div>
          </div>
          <a href="javascript:void(0)">
          <div class="panel-footer"> <span class="pull-left">View Details</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
            <div class="clearfix"></div>
          </div>
          </a> </div>
      </div>
      <div class="col-lg-3 col-sm-6">
        <div class="panel panel-yellow">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-3"> <i class="fa fa-shopping-cart fa-2x"></i> </div>
              <div class="col-xs-9 text-right">
                <div class="huge">124</div>
                <div>New Orders!</div>
              </div>
            </div>
          </div>
          <a href="javascript:void(0)">
          <div class="panel-footer"> <span class="pull-left">View Details</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
            <div class="clearfix"></div>
          </div>
          </a> </div>
      </div>
      <div class="col-lg-3 col-sm-6">
        <div class="panel panel-red">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-3"> <i class="fa fa-support fa-2x"></i> </div>
              <div class="col-xs-9 text-right">
                <div class="huge">113</div>
                <div>Raised issue!</div>
              </div>
            </div>
          </div>
          <a href="javascript:void(0)">
          <div class="panel-footer"> <span class="pull-left">View Details</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
            <div class="clearfix"></div>
          </div>
          </a> </div>
      </div>
    </div>
    <!-- /.row -->
    <div class="row">
      <div class="col-md-12">
        <table class="table " id="dataTables-userlist">
          <thead>
            <tr>
              <th>User </th>
              <th>Email</th>
              <th>Phone</th>
              <th>Project</th>
              <th>status</th>
              <th>socials</th>
            </tr>
          </thead>
          <tbody>
            <tr class="odd">
              <td><img src="http://placehold.it/100x100" alt="" class="gridpic">John Doe</td>
              <td>info@maxartkiller.in</td>
              <td>+91 000 000 0000</td>
              <td class="center">40</td>
              <td class="center"><span class="status active">Active</span></td>
              <td class="center"><a href="" class="btn btn-circle btn-primary "><i class="fa fa-facebook"></i></a> <a href="" class="btn btn-circle btn-danger "><i class="fa fa-google-plus"></i></a> <a href="" class="btn btn-circle btn-info "><i class="fa fa-twitter"></i></a> <a href="" class="btn btn-circle btn-warning "><i class="fa fa-envelope"></i></a></td>
            </tr>
            <tr class="even ">
              <td><img src="http://placehold.it/100x100" alt="" class="gridpic">Alone Guy</td>
              <td>info@maxartkiller.in</td>
              <td>+91 000 000 0000</td>
              <td class="center">18</td>
              <td class="center"><span class="status active">Active</span></td>
              <td class="center"><a href="" class="btn btn-circle btn-primary "><i class="fa fa-facebook"></i></a> <a href="" class="btn btn-circle btn-danger "><i class="fa fa-google-plus"></i></a> <a href="" class="btn btn-circle btn-info "><i class="fa fa-twitter"></i></a> <a href="" class="btn btn-circle btn-warning "><i class="fa fa-envelope"></i></a></td>
            </tr>
            <tr class="odd">
              <td><img src="http://placehold.it/100x100" alt="" class="gridpic">Astha Smith</td>
              <td>info@maxartkiller.in</td>
              <td>+91 000 000 0000</td>
              <td class="center">10</td>
              <td class="center"><span class="status active">Active</span></td>
              <td class="center"><a href="" class="btn btn-circle btn-primary "><i class="fa fa-facebook"></i></a> <a href="" class="btn btn-circle btn-danger "><i class="fa fa-google-plus"></i></a> <a href="" class="btn btn-circle btn-info "><i class="fa fa-twitter"></i></a> <a href="" class="btn btn-circle btn-warning "><i class="fa fa-envelope"></i></a></td>
            </tr>
            <tr class="even ">
              <td><img src="http://placehold.it/100x100" alt="" class="gridpic">Lucky Sans</td>
              <td>info@maxartkiller.in</td>
              <td>+91 000 000 0000</td>
              <td class="center">19</td>
              <td class="center"><span class="status active">Active</span></td>
              <td class="center"><a href="" class="btn btn-circle btn-primary "><i class="fa fa-facebook"></i></a> <a href="" class="btn btn-circle btn-danger "><i class="fa fa-google-plus"></i></a> <a href="" class="btn btn-circle btn-info "><i class="fa fa-twitter"></i></a> <a href="" class="btn btn-circle btn-warning "><i class="fa fa-envelope"></i></a></td>
            </tr>
            <tr class="odd">
              <td><img src="http://placehold.it/100x100" alt="" class="gridpic">John Doe</td>
              <td>info@maxartkiller.in</td>
              <td>+91 000 000 0000</td>
              <td class="center">40</td>
              <td class="center"><span class="status active">Active</span></td>
              <td class="center"><a href="" class="btn btn-circle btn-primary "><i class="fa fa-facebook"></i></a> <a href="" class="btn btn-circle btn-danger "><i class="fa fa-google-plus"></i></a> <a href="" class="btn btn-circle btn-info "><i class="fa fa-twitter"></i></a> <a href="" class="btn btn-circle btn-warning "><i class="fa fa-envelope"></i></a></td>
            </tr>
            <tr class="even ">
              <td><img src="http://placehold.it/100x100" alt="" class="gridpic">Alone Guy</td>
              <td>info@maxartkiller.in</td>
              <td>+91 000 000 0000</td>
              <td class="center">18</td>
              <td class="center"><span class="status inactive">Inactive</span></td>
              <td class="center"><a href="" class="btn btn-circle btn-primary "><i class="fa fa-facebook"></i></a> <a href="" class="btn btn-circle btn-danger "><i class="fa fa-google-plus"></i></a> <a href="" class="btn btn-circle btn-info "><i class="fa fa-twitter"></i></a> <a href="" class="btn btn-circle btn-warning "><i class="fa fa-envelope"></i></a></td>
            </tr>
            <tr class="odd">
              <td><img src="http://placehold.it/100x100" alt="" class="gridpic">Astha Smith</td>
              <td>info@maxartkiller.in</td>
              <td>+91 000 000 0000</td>
              <td class="center">17</td>
              <td class="center"><span class="status inactive">Inactive</span></td>
              <td class="center"><a href="" class="btn btn-circle btn-primary "><i class="fa fa-facebook"></i></a> <a href="" class="btn btn-circle btn-danger "><i class="fa fa-google-plus"></i></a> <a href="" class="btn btn-circle btn-info "><i class="fa fa-twitter"></i></a> <a href="" class="btn btn-circle btn-warning "><i class="fa fa-envelope"></i></a></td>
            </tr>
            <tr class="even ">
              <td><img src="http://placehold.it/100x100" alt="" class="gridpic">John Doe</td>
              <td>info@maxartkiller.in</td>
              <td>+91 000 000 0000</td>
              <td class="center">50</td>
              <td class="center"><span class="status active">Active</span></td>
              <td class="center"><a href="" class="btn btn-circle btn-primary "><i class="fa fa-facebook"></i></a> <a href="" class="btn btn-circle btn-danger "><i class="fa fa-google-plus"></i></a> <a href="" class="btn btn-circle btn-info "><i class="fa fa-twitter"></i></a> <a href="" class="btn btn-circle btn-warning "><i class="fa fa-envelope"></i></a></td>
            </tr>
            <tr class="odd">
              <td><img src="http://placehold.it/100x100" alt="" class="gridpic">Alone Guy</td>
              <td>info@maxartkiller.in</td>
              <td>+91 000 000 0000</td>
              <td class="center">20</td>
              <td class="center"><span class="status inactive">Inactive</span></td>
              <td class="center"><a href="" class="btn btn-circle btn-primary "><i class="fa fa-facebook"></i></a> <a href="" class="btn btn-circle btn-danger "><i class="fa fa-google-plus"></i></a> <a href="" class="btn btn-circle btn-info "><i class="fa fa-twitter"></i></a> <a href="" class="btn btn-circle btn-warning "><i class="fa fa-envelope"></i></a></td>
            </tr>
            <tr class="even ">
              <td><img src="http://placehold.it/100x100" alt="" class="gridpic">Astha Smith</td>
              <td>info@maxartkiller.in</td>
              <td>+91 000 000 0000</td>
              <td class="center">15</td>
              <td class="center"><span class="status active">Active</span></td>
              <td class="center"><a href="" class="btn btn-circle btn-primary "><i class="fa fa-facebook"></i></a> <a href="" class="btn btn-circle btn-danger "><i class="fa fa-google-plus"></i></a> <a href="" class="btn btn-circle btn-info "><i class="fa fa-twitter"></i></a> <a href="" class="btn btn-circle btn-warning "><i class="fa fa-envelope"></i></a></td>
            </tr>
            <tr class="odd">
              <td><img src="http://placehold.it/100x100" alt="" class="gridpic">Lucky Sans</td>
              <td>info@maxartkiller.in</td>
              <td>+91 000 000 0000</td>
              <td class="center">15</td>
              <td class="center"><span class="status inactive">Inactive</span></td>
              <td class="center"><a href="" class="btn btn-circle btn-primary "><i class="fa fa-facebook"></i></a> <a href="" class="btn btn-circle btn-danger "><i class="fa fa-google-plus"></i></a> <a href="" class="btn btn-circle btn-info "><i class="fa fa-twitter"></i></a> <a href="" class="btn btn-circle btn-warning "><i class="fa fa-envelope"></i></a></td>
            </tr>
            <tr class="even ">
              <td><img src="http://placehold.it/100x100" alt="" class="gridpic">John Doe</td>
              <td>info@maxartkiller.in</td>
              <td>+91 000 000 0000</td>
              <td class="center">50</td>
              <td class="center"><span class="status active">Active</span></td>
              <td class="center"><a href="" class="btn btn-circle btn-primary "><i class="fa fa-facebook"></i></a> <a href="" class="btn btn-circle btn-danger "><i class="fa fa-google-plus"></i></a> <a href="" class="btn btn-circle btn-info "><i class="fa fa-twitter"></i></a> <a href="" class="btn btn-circle btn-warning "><i class="fa fa-envelope"></i></a></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <!-- /.row -->
    <br>
    <br>
    <div class="row blockspanel">
      <div class="col-lg-3 col-md-6">
        <div class="panel ">
          <div class="panel-body">
            <div class="row">
              <div class="col-xs-12 text-left">
                <div class="colorlight">Best Achieved</div>
                <div class="huge">London</div>
                <div class="colorlight">Sales growth 50% highter!</div>
                <br>
              </div>
              <div class="col-xs-12 text-center"> <img src="http://placehold.it/200x200" alt="" class="responsiveimg"> </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="panel ">
          <div class="panel-body">
            <div class="row">
              <div class="col-xs-12 text-left">
                <div class="colorlight">Global Reach</div>
                <div class="huge">Switzerland</div>
                <div class="colorlight">Market growth 50% highter!</div>
                <br>
              </div>
              <div class="col-xs-12 text-center"> <img src="http://placehold.it/200x200" alt="" class="responsiveimg"> </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="panel ">
          <div class="panel-body">
            <div class="row">
              <div class="col-xs-12 text-left">
                <div class="colorlight">Best Prices</div>
                <div class="huge">+ 3652 up</div>
                <div class="colorlight">Covered All over</div>
                <br>
              </div>
              <div class="col-xs-12 text-center"> <img src="http://placehold.it/200x200" alt="" class="responsiveimg"> </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="panel ">
          <div class="panel-body">
            <div class="row">
              <div class="col-xs-12 text-left">
                <div class="colorlight">What our customers say</div>
                <div  class="huge">Clientele</div>
                <br>
              </div>
              <div class="col-xs-12 text-center">
                <div id="carousel-example-generic" class="carousel slide tsetimonialslide" data-ride="carousel"> 
                  <!-- Indicators -->
                  <ol class="carousel-indicators">
                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                  </ol>
                  
                  <!-- Wrapper for slides -->
                  <div class="carousel-inner" role="listbox">
                    <div class="item active">
                      <p class=" ">"I can't wait to test this out. <span class="glyphicon glyphicon-thumbs-up"></span> This is a testimonial window. Feedback of user can be displayed here."</p>
                      <img class="img-responsive media-object" src="http://placehold.it/100x100" alt="">
                      <h4>John Doe</h4>
                      <div>UX/UI designer</div>
                    </div>
                    <div class="item">
                      <p class=" ">"I can't wait to test this out. <span class="glyphicon glyphicon-thumbs-up"></span> This is a testimonial window. Feedback of user can be displayed here."</p>
                      <img class="img-responsive media-object" src="http://placehold.it/100x100" alt="">
                      <h4>Astha Smith</h4>
                      <div>Frontend developer</div>
                    </div>
                  </div>
                  
                  <!-- Controls --> 
                  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> <span class="sr-only">Next</span> </a> </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.row -->
    <div class="row">
      <div class="col-lg-8">
        <div class="panel panel-default">
          <div class="panel-heading"> <i class="fa fa-bar-chart-o fa-fw"></i> Area Chart Example
            <div class="pull-right">
              <div class="btn-group">
                <button type="button" class="dotbtn dropdown-toggle" data-toggle="dropdown"> <span class="dots"></span> </button>
                <ul class="dropdown-menu pull-right" role="menu">
                  <li><a href="javascript:void(0)">Action</a> </li>
                  <li><a href="javascript:void(0)">Another action</a> </li>
                  <li><a href="javascript:void(0)">Something else here</a> </li>
                  <li><a href="javascript:void(0)">Separated link</a> </li>
                </ul>
              </div>
            </div>
          </div>
          <!-- /.panel-heading -->
          <div class="panel-body">
            <div id="morris-area-chart"></div>
          </div>
          <!-- /.panel-body --> 
        </div>
        <!-- /.panel -->
        <div class="panel panel-default">
          <div class="panel-heading"> <i class="fa fa-bar-chart-o fa-fw"></i> Bar Chart Example
            <div class="pull-right">
              <div class="btn-group">
                <button type="button" class="dotbtn dropdown-toggle" data-toggle="dropdown"> <span class="dots"></span> </button>
                <ul class="dropdown-menu pull-right" role="menu">
                  <li><a href="javascript:void(0)">Action</a> </li>
                  <li><a href="javascript:void(0)">Another action</a> </li>
                  <li><a href="javascript:void(0)">Something else here</a> </li>
                  <li><a href="javascript:void(0)">Separated link</a> </li>
                </ul>
              </div>
            </div>
          </div>
          <!-- /.panel-heading -->
          <div class="panel-body">
            <div class="row">
              <div class="col-lg-12">
                <div id="morris-bar-chart"></div>
              </div>
              <!-- /.col-lg-12 (nested) --> 
            </div>
            <!-- /.row --> 
          </div>
          <!-- /.panel-body --> 
        </div>
      </div>
      <!-- /.col-lg-8 -->
      <div class="col-lg-4">
        <div class="panel panel-default">
          <div class="panel-heading"> <i class="fa fa-bell fa-fw"></i> Notifications Panel </div>
          <!-- /.panel-heading -->
          <div class="panel-body">
            <div class="list-group"> <a href="javascript:void(0)" class="list-group-item"> <i class="fa fa-comment fa-fw"></i> New Comment <span class="pull-right text-muted small"><em>4 minutes ago</em> </span> </a> <a href="javascript:void(0)" class="list-group-item"> <i class="fa fa-twitter fa-fw"></i> 3 New Followers <span class="pull-right text-muted small"><em>12 minutes ago</em> </span> </a> <a href="javascript:void(0)" class="list-group-item"> <i class="fa fa-envelope fa-fw"></i> Message Sent <span class="pull-right text-muted small"><em>27 minutes ago</em> </span> </a> <a href="javascript:void(0)" class="list-group-item"> <i class="fa fa-tasks fa-fw"></i> New Task <span class="pull-right text-muted small"><em>43 minutes ago</em> </span> </a> <a href="javascript:void(0)" class="list-group-item"> <i class="fa fa-upload fa-fw"></i> Server Rebooted <span class="pull-right text-muted small"><em>11:32 AM</em> </span> </a> <a href="javascript:void(0)" class="list-group-item"> <i class="fa fa-bolt fa-fw"></i> Server Crashed! <span class="pull-right text-muted small"><em>11:13 AM</em> </span> </a> <a href="javascript:void(0)" class="list-group-item"> <i class="fa fa-shopping-cart fa-fw"></i> New Order Placed <span class="pull-right text-muted small"><em>9:49 AM</em> </span> </a> <a href="javascript:void(0)" class="list-group-item"> <i class="fa fa-money fa-fw"></i> Payment Received <span class="pull-right text-muted small"><em>Yesterday</em> </span> </a> </div>
            <!-- /.list-group --> 
            
          </div>
          <!-- /.panel-body --> 
        </div>
        <!-- /.panel -->
        <div class="panel panel-default">
          <div class="panel-heading"> <i class="fa fa-bar-chart-o fa-fw"></i> Donut Chart Example </div>
          <div class="panel-body">
            <div id="morris-donut-chart"></div>
          </div>
          <!-- /.panel-body --> 
        </div>
        <!-- /.panel --> 
        
      </div>
      <!-- /.col-lg-4 --> 
        
        <div class="col-xs-12">
        <div class="panel panel-default">
          <div class="panel-heading"> Line Chart Example </div>
          <!-- /.panel-heading -->
          <div class="panel-body">
            <div id="morris-line-chart"></div>
          </div>
          <!-- /.panel-body --> 
        </div>
        <!-- /.panel --> 
      </div>
        
    </div>
    <!-- /.row -->
    <div class="row">
      <div class="col-sm-6 ">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h1 class="page-header small">Today's Task
              <button type="button" class="btn btn-default pull-right"><span class="fa fa-plus" aria-hidden="true"></span> Add</button>
            </h1>
            <p class="page-subtitle small">15 of 10 Task completed</p>
          </div>
          <div class="todolist">
            <table class=" table">
              <tbody>
                <tr>
                  <td class="primary statusmail"><input type="checkbox" id="check6" class="checkbox" checked="">
                    <label for="check6"></label>
                    <div class="textmail"> <strong><s>Collect Data</s></strong> <span class="pull-right text-muted"> <a href="javascript:void(0)" data-toggle="modal" data-target="#addtodo" class="btn btn-link"><i class="fa fa-edit"></i></a> <a href="" class="btn btn-link"><i class="fa fa-trash"></i></a> </span>
                      <p>12 Jul 16 | 11:00 am </p>
                    </div></td>
                </tr>
                <tr>
                  <td class="important statusmail"><input type="checkbox" id="check4" class="checkbox">
                    <label for="check4"></label>
                    <div class="textmail"> <strong>Send Salery</strong> <span class="pull-right text-muted"> <a href="javascript:void(0)" data-toggle="modal" data-target="#addtodo" class="btn btn-link"><i class="fa fa-edit"></i></a> <a href="" class="btn btn-link"><i class="fa fa-trash"></i></a> </span>
                      <p>12 Jul 16 | 11:00 am </p>
                    </div></td>
                </tr>
                <tr>
                  <td class="low statusmail"><input type="checkbox" id="check2" class="checkbox">
                    <label for="check2"></label>
                    <div class="textmail"> <strong>Interview taking</strong> <span class="pull-right text-muted"> <a href="javascript:void(0)" data-toggle="modal" data-target="#addtodo" class="btn btn-link"><i class="fa fa-edit"></i></a> <a href="" class="btn btn-link"><i class="fa fa-trash"></i></a> </span>
                      <p>12 Jul 16 | 11:00 am </p>
                    </div></td>
                </tr>
                <tr>
                  <td class="low statusmail "><input type="checkbox" id="check7" class="checkbox">
                    <label for="check7"></label>
                    <div class="textmail"> <strong>John Smith</strong> <span class="pull-right text-muted"> <a href="javascript:void(0)" data-toggle="modal" data-target="#addtodo" class="btn btn-link"><i class="fa fa-edit"></i></a> <a href="" class="btn btn-link"><i class="fa fa-trash"></i></a> </span>
                      <p>12 Jul 16 | 11:00 am </p>
                    </div></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="panel panel-default">
              <div class="panel-heading">
                <h1 class="page-header small">My Publications</h1>
                <p class="page-subtitle small">Limited information is visible</p>
              </div>
              <div class="col-md-12">
                <dl class="border-bottom">
                  <dt>Book of Eye</dt>
                  <dd>A description list is perfect for defining terms.<br>
                    <span class="text-muted">January 2001</span> </dd>
                </dl>
                <dl class="border-bottom">
                  <dt>Creative fire wings</dt>
                  <dd>A description list is perfect for defining terms.<br>
                    <span class="text-muted">January 2001</span> </dd>
                </dl>
                <dl class="">
                  <dt>My lost art</dt>
                  <dd>A description list is perfect for defining terms.<br>
                    <span class="text-muted">January 2001</span> </dd>
                </dl>
              </div>
              <div class="clearfix"></div>
        </div>
      </div>
    </div>
    <div class="row blockspanel">
      <div class="col-lg-3 col-md-6">
        <div class="panel panel-blue">
          <div class="panel-body">
            <div class="row">
              <div class="col-xs-12 text-left">
                <div class="colorlight">Best Achieved</div>
                <div class="huge">London</div>
                <div class="colorlight">Sales growth 50% highter!</div>
                <br>
              </div>
              <div class="col-xs-12 text-center"> <img src="http://placehold.it/200x200" alt="" class="responsiveimg"> </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6">
        <div class="panel panel-yellow">
          <div class="panel-body">
            <div class="row">
              <div class="col-xs-12 text-left">
                <div class="colorlight">World Growth</div>
                <div class="huge">+ 25 million</div>
                <div class="colorlight">jVectormap-paid</div>
                <br>
              </div>
              <div class="col-xs-12 text-center">
                <div class="worldmap" id="mapwrap" ></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="panel  panel-red">
          <div class="panel-body">
            <div class="row">
              <div class="col-xs-12 text-left">
                <div class="colorlight">What our customers say</div>
                <div  class="huge">Clientele</div>
                <br>
              </div>
              <div class="col-xs-12 text-center">
                <div id="mycarousal" class="carousel slide tsetimonialslide" data-ride="carousel"> 
                  <!-- Indicators -->
                  <ol class="carousel-indicators">
                    <li data-target="#mycarousal" data-slide-to="0" class="active"></li>
                    <li data-target="#mycarousal" data-slide-to="1"></li>
                    <li data-target="#mycarousal" data-slide-to="2"></li>
                  </ol>
                  
                  <!-- Wrapper for slides -->
                  <div class="carousel-inner" role="listbox">
                    <div class="item active">
                      <p class=" ">"I can't wait to test this out. <span class="glyphicon glyphicon-thumbs-up"></span> This is a testimonial window. Feedback of user can be displayed here."</p>
                      <img class="img-responsive media-object" src="http://placehold.it/100x100" alt="">
                      <h4>John Doe</h4>
                      <div>UX/UI designer</div>
                    </div>
                    <div class="item">
                      <p class=" ">"I can't wait to test this out. <span class="glyphicon glyphicon-thumbs-up"></span> This is a testimonial window. Feedback of user can be displayed here."</p>
                      <img class="img-responsive media-object" src="http://placehold.it/100x100" alt="">
                      <h4>Asths Smith</h4>
                      <div>Frontend developer</div>
                    </div>
                  </div>
                  
                  <!-- Controls --> 
                  <a class="left carousel-control" href="#mycarousal" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="right carousel-control" href="#mycarousal" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> <span class="sr-only">Next</span> </a> </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.row --> 
    
   <!-- jQuery --> 
<script src="vendor/jquery/jquery.min.js"></script> 

<!-- Bootstrap Core JavaScript --> 
<script src="vendor/bootstrap/js/bootstrap.min.js"></script> 

<!-- DataTables JavaScript --> 
<script src="vendor/datatables/js/jquery.dataTables.min.js"></script> 
<script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script> 
<script src="vendor/datatables-responsive/dataTables.responsive.js"></script> 

<!-- Morris Charts JavaScript --> 
<script src="vendor/raphael/raphael.js"></script> 
<script src="vendor/morrisjs/morris.min.js"></script> 
<script src="vendor/morrisjs/morris-data.js"></script> 

<!-- jvectormap JavaScript --> 
<script src="vendor/jquery-jvectormap/jquery-jvectormap.js"></script> 
<script src="vendor/jquery-jvectormap/jquery-jvectormap-world-mill-en.js"></script> 

<!-- Custom Theme JavaScript --> 
<script src="js/adminnine.js"></script> 

<!-- Page-Level Demo Scripts - Tables - Use for reference --> 
<script>
    $(document).ready(function(){
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
                }
            });
            
             Morris.Bar({
            element: 'morris-bar-chart2',
              data: [
                { y: '2006', a: 100, b: 100},
                { y: '2007', a: 75,  b: 75 },
                { y: '2008', a: 60 , b: 60 },
                { y: '2009', a: 75 , b: 75 },
                { y: '2006', a: 100, b: 100},
                { y: '2007', a: 75,  b: 75 },
                { y: '2008', a: 40,  b: 40 },
                { y: '2009', a: 25,  b: 25 },
                { y: '2006', a: 110, b: 110},
                { y: '2007', a: 75,  b: 75 },
                { y: '2008', a: 60,  b: 60 },
                { y: '2009', a: 75,  b: 75 },
                { y: '2012', a: 100, b: 100}
              ],
               resize: true,
                 axes:'',
                 hideHover: 'auto',
              xkey: 'y',
              padding:1,
              ykeys: ['a', 'b'],
              labels: ['Series A'],
              barColors: ["#ffffff", "#cfdfed"]
            });
            
              $('#mapwrap').vectorMap({map: 'world_mill'});              
                  
    
        $(window).resize(function(){
            
            $('#dataTables-userlist').DataTable();
            
        });
        
    });
    </script>

