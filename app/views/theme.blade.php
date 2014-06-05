<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('title')</title>

    <!-- Bootstrap core CSS -->
    {{HTML::style('bootstrap-3.1.1/dist/css/bootstrap.min.css')}}

    <!-- Custom styles for this template -->
    {{HTML::style('css/custom.css')}}

    <!-- Load CSS for print -->
    <link rel="stylesheet" type="text/css" media="print" href="{{asset('css/print.css')}}" />

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    {{HTML::script('js/jquery-1.11.0.min.js')}}
    {{HTML::script('bootstrap-3.1.1/dist/js/bootstrap.min.js')}}
    {{HTML::script('js/jquery.autocomplete.js')}}
    {{HTML::script('js/function.js')}}
    {{HTML::script('js/jquery-validate/jquery.validate.js')}}

    <!-- Jquery for tab -->
    {{HTML::script('js/jquery.tabbable.min.js')}}

    
  </head>

  <body>

    <!-- Fixed navbar -->

    <div class="navbar navbar-inverse navbar-static-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Chienowa Vietnam</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="dropdown @if(Session::get('active_menu')=='users') active @endif">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Users<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="{{Asset('user/manage-user')}}">Manage Users</a></li>
                <li class="hidden-xs"><a href="{{Asset('user/create-user')}}">Create user</a></li>
                <li class="hidden-xs"><a href="{{Asset('user/staff-rank')}}">Staff Rank</a></li>
              </ul>
            </li>
            <li class="dropdown @if(Session::get('active_menu')=='inventory') active @endif hidden-xs">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Inventory<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li class="dropdown-header">Manage</li>
                <li><a href="{{Asset('category')}}">Categories</a></li>
                <li><a href="{{Asset('attribute')}}">Attributes</a></li>
                <li class="divider"></li>
                <li class="dropdown-header hidden-xs">Inventory</li>
                <li class="hidden-xs"><a href="{{Asset('inventory/create')}}">New Transaction</a></li>
                <li class="hidden-xs"><a href="{{Asset('inventory/manage')}}">Manage Transaction</a></li>
              </ul>
            </li>

            <li class="dropdown @if(Session::get('active_menu')=='expense') active @endif hidden-xs">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Expense<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="{{Asset('expense/create-expense')}}">Create Expense</a></li>
                <li><a href="{{Asset('expense/manage-expense')}}">Manage Expense</a></li>
              </ul>
            </li>

            <li class="dropdown @if(Session::get('active_menu')=='projects') active @endif">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Quality Control<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="{{Asset('quality-control/new-daily-report')}}">New Daily Report</a></li>
                <li><a href="{{Asset('quality-control/manage-daily-report')}}">Manage Daily Report</a></li>
                <li><a href="{{Asset('quality-control/measuring-equipment')}}">Measuring Equipment</a></li>
                <li><a href="{{Asset('quality-control/product-list')}}">Product list</a></li>
                <li><a href="{{Asset('quality-control/product-attributes')}}">Product Attributes</a></li>
                <!-- <li class="divider"></li>
                <li class="dropdown-header">Local Projects</li> -->
              </ul>
            </li>

            <li class="dropdown @if(Session::get('active_menu')=='orders') active @endif">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Orders<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li class="dropdown-header">Quotations</li>
                <li><a href="{{Asset('orders/supplier-manage')}}">Manage Suppliers</a></li>
                <li><a href="{{Asset('orders/quotation-create')}}">Create Quotation</a></li>
                <li><a href="{{Asset('orders/quotation-manage')}}">Manage Quotation</a></li>
                <li class="divider"></li>
                <li class="dropdown-header">Orders</li>
                <li><a href="{{Asset('orders/order-create')}}">Create Orders</a></li>
                <li><a href="{{Asset('orders/order-manage')}}">Manage Orders</a></li>
              </ul>
            </li>

            <li class="dropdown @if(Session::get('active_menu')=='report') active @endif">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Report<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li class="dropdown-header">Inventory</li>
                <li><a href="{{Asset('report/inventory-in-stock')}}">In-Stock</a></li>
                <li><a href="{{Asset('report/inventory-by-day')}}">By Day</a></li>
                <li><a href="{{Asset('report/transactions')}}">Transactions</a></li>
                <li class="divider"></li>
                <li><a href="{{Asset('report/expense')}}">Expense report</a></li>
                <li class="divider"></li>
                <li><a href="{{Asset('report/quality-control')}}">Quality Control Report</a></li>
              </ul>
            </li>

            
          </ul>
          <ul class="nav navbar-nav navbar-right hidden-xs">
              <li><a href="{{Asset('user/modify-user')}}/{{Session::get('user')->id}}"><span class="glyphicon glyphicon-user"></span> {{ucfirst(Session::get('user')->username)}}</a></li>
              <li><a href="{{Asset('user/logout')}}"><span class="glyphicon glyphicon-log-out"></span> Signout</a></li>
            </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <!-- Begin page content -->
    
    @yield('content')

    <div id="footer" class="hidden-print">
      <div class="container">
        <span class="text-muted">Copyright &copy; 2014, Chienowa Co., Ltd</span><br/>
        <span class="text-muted">Design by Minh Giang</span><br/>
        <span class="text-muted">Mail to: <a href="mailto:mtnhatdanh@gmail.com">minh@chienowa.agri-wave.com</a></span>
      </div>
    </div>

    
  </body>
</html>
