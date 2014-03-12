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
    <link href="{{Asset('bootstrap-3.1.1/dist/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{Asset('css/custom.css')}}" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <script src="{{Asset('js/jquery-1.11.0.min.js')}}"></script>
    <script src="{{Asset('js/jquery-validate/jquery.validate.js')}}"></script>
    <script src="{{Asset('bootstrap-3.1.1/dist/js/bootstrap.min.js')}}"></script>
    <script src="{{Asset('js/jquery.autocomplete.js')}}"></script>
    <script src="{{Asset('js/function.js')}}"></script>

    
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
              </ul>
            </li>
            <li class="dropdown @if(Session::get('active_menu')=='inventory') active @endif">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Inventory<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li class="dropdown-header">Manage</li>
                <li><a href="{{Asset('category')}}">Categories</a></li>
                <li><a href="{{Asset('attribute')}}">Attributes</a></li>
                <li class="divider"></li>
                <li class="dropdown-header hidden-xs">Inventory</li>
                <li class="hidden-xs"><a href="{{Asset('inventory/create')}}">New Transaction</a></li>
              </ul>
            </li>

            <li class="dropdown @if(Session::get('active_menu')=='expense') active @endif">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Expense<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="{{Asset('expense/create-expense')}}">Create Expense</a></li>
                <li><a href="{{Asset('expense/manage-expense')}}">Manage Expense</a></li>
              </ul>
            </li>

            <li class="dropdown @if(Session::get('active_menu')=='report') active @endif">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Report<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li class="dropdown-header">Inventory</li>
                <li><a href="{{Asset('report/inventory-in-stock')}}">In-Stock</a></li>
                <li><a href="{{Asset('report/inventory-by-day')}}">By Day</a></li>
                <li><a href="{{Asset('report/transactions')}}">Transactions</a></li>
                <!-- <li class="divider"></li>
                <li class="dropdown-header">Inventory</li>
                <li><a href="{{Asset('inventory/create')}}">New Transaction</a></li> -->
              </ul>
            </li>

            

            <!-- <li><a href="#about">Expense</a></li>
            <li><a href="#contact">Projects</a></li> -->
          </ul>
          <ul class="nav navbar-nav navbar-right">
              <li><a href="{{Asset('user/modify-user')}}/{{Session::get('user')->id}}">{{Session::get('user')->username}}</a></li>
              <li><a href="{{Asset('user/logout')}}">Signout</a></li>
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
