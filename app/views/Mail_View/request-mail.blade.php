<?php
$request = RequestLC::find($request_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Quotation mail</title>

    <!-- Bootstrap core CSS -->
    {{HTML::style('bootstrap-3.1.1/dist/css/bootstrap.min.css')}}

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- {{HTML::script('js/jquery-1.11.0.min.js')}} -->
    {{HTML::script('bootstrap-3.1.1/dist/js/bootstrap.min.js')}}
    <!-- {{HTML::script('js/jquery.autocomplete.js')}}
    {{HTML::script('js/function.js')}}
    {{HTML::script('js/jquery-validate/jquery.validate.js')}} -->

    <!-- Jquery for tab -->
    <!-- {{HTML::script('js/jquery.tabbable.min.js')}} -->


</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <p>
                    <strong>CHIENOWA VIETNAM LTD.,</strong>
                </p>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-header">
                    <h1>Request <small> remind mail</small></h1>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <p>
                    This is a automatic remind email. Please don't reply this email.
                </p>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-2">
                <strong>Request from:</strong>
            </div>
            <div class="col-sm-4">
                {{$request->user->name}}
            </div>
            <div class="col-sm-2">
                <strong>Incharge Staff</strong>
            </div>
            <div class="col-sm-4">
                {{$request->inchargeStaff->name}}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <strong>Date</strong>
            </div>
            <div class="col-sm-4">
                {{$request->date}}
            </div>
            <div class="col-sm-2">
                <strong>Due Date</strong>
            </div>
            <div class="col-sm-4">
                {{$request->due_date}}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <strong>Date still avaiable</strong>
            </div>
            <div class="col-sm-4">
                {{(strtotime($request->due_date)-strtotime(date('Y-m-d')))/86400;}}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <strong>Request content</strong>
            </div>
            <div class="col-sm-4">
                {{$request->request_content}}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <strong>Note: </strong>{{$request->note}}
            </div>
        </div>
    </div>
</body>
</html>
