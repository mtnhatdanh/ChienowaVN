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

  
  <style>
        .fullscreen-cont,
    .fullscreen-img {
        display:block;
        position:relative;
        min-width:100%;
        min-height:100%;
    }
    .fullscreen-img {
        display:block;
        position:absolute;
        z-index:1;
        min-width:100%;
        min-height:100%;
        /* background position when .fullscreen-img overflows */
        background:transparent url('{{Asset('img/test.jpg')}}') center center no-repeat;
        background-size:cover;
    }
    .content {
        display:block;
        position:relative;
        z-index:2;
    }

  </style>  
  </head>


  <body>

  <div class="fullscreen-cont">
    <div class="fullscreen-img"></div>
</div>
<div class="fullscreen-cont">
    <div class="fullscreen-img"></div>
</div>
<div class="fullscreen-cont">
    <div class="fullscreen-img"></div>
    <div class="content">
        <br><br><br>Example content<br><br><br>Example content<br><br><br>Example content<br><br><br>Example content<br><br/><br>Example content<br><br><br>
        <br><br><br>Example content<br><br><br>Example content<br><br><br>Example content<br><br><br>Example content<br><br/><br>Example content<br><br><br>
        <br><br><br>Example content<br><br><br>Example content<br><br><br>Example content<br><br><br>Example content<br><br/><br>Example content<br><br><br>
        <br><br><br>Example content<br><br><br>Example content<br><br><br>Example content<br><br><br>Example content<br><br/><br>Example content<br><br><br>
        <br><br><br>Example content<br><br><br>Example content<br><br><br>Example content<br><br><br>Example content<br><br/><br>Example content<br><br><br>
        <br><br><br>Example content<br><br><br>Example content<br><br><br>Example content<br><br><br>Example content<br><br/><br>Example content<br><br><br>
        <br><br><br>Example content<br><br><br>Example content<br><br><br>Example content<br><br><br>Example content<br><br/><br>Example content<br><br><br>
        <br><br><br>Example content<br><br><br>Example content<br><br><br>Example content<br><br><br>Example content<br><br/><br>Example content<br><br><br>
        <br><br><br>Example content<br><br><br>Example content<br><br><br>Example content<br><br><br>Example content<br><br/><br>Example content<br><br><br>
        <br><br><br>Example content<br><br><br>Example content<br><br><br>Example content<br><br><br>Example content<br><br/><br>Example content<br><br><br>
        <br><br><br>Example content<br><br><br>Example content<br><br><br>Example content<br><br><br>Example content<br><br/><br>Example content<br><br><br>
        <br><br><br>Example content<br><br><br>Example content<br><br><br>Example content<br><br><br>Example content<br><br/><br>Example content<br><br><br>
        
    </div>
</div>
  
  
    
  </body>
</html>
