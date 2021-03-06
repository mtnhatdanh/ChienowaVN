<?php
$order        = Order::find($order_id);
$orderDetails = $order->orderDetails;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Order mail</title>

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
        <div class="row">
            <div class="col-sm-12">
                <div class="page-header">
                    <h1>Order <small>remind email</small></h1>
                </div>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-sm-12">
                <p>
                    This is a automatic remind email. Please don't reply this email.
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <strong>User:</strong>
            </div>
            <div class="col-sm-4">
                {{$order->user->name}}
            </div>
            <div class="col-sm-2">
                <strong>Supplier name</strong>
            </div>
            <div class="col-sm-4">
                {{$order->supplier->name}}
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-2">
                <strong>Date</strong>
            </div>
            <div class="col-sm-4">
                {{$order->date}}
            </div>
            <div class="col-sm-2">
                <strong>Due Date</strong>
            </div>
            <div class="col-sm-4">
                {{$order->due_date}}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <strong>Note: </strong>{{$order->note}}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-responsive">
                    <tr>
                        <th>No</th>
                        <th>Order product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Sum</th>
                    </tr>
                    <?php $no = 0; $sum = 0 ?>
                    @foreach ($orderDetails as $orderDetail)
                    <?php $total = $orderDetail->price * $orderDetail->quantity; ?>
                    <tr>
                        <td>{{++$no}}</td>
                        <td>{{$orderDetail->orderProduct->name}}</td>
                        <td>{{number_format($orderDetail->price, 0, '.', ',')}}</td>
                        <td>{{$orderDetail->quantity}}</td>
                        <td>{{number_format($total, 0, '.', ',')}}</td>
                    </tr>
                    <?php $sum+=$total; ?>
                    @endforeach
                    <tr>
                        <td colspan="4"></td>
                        <td>{{number_format($sum, 0, '.', ',')}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
