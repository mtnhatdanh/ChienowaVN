<style>
    td {
        vertical-align: middle!important;
    }
</style>
<?php
$projectDetail = ProjectDetail::find($projectDetail_id);
$quotationDetails = DB::table('quotation_details')
                            ->join('quotation', 'quotation.id', '=', 'quotation_details.quotation_id')
                            ->select('quotation.date', 'quotation.supplier_id','quotation.note' ,'quotation.project_id', 'quotation_details.id', 'quotation_details.order_product_id', 'quotation_details.price', 'quotation_details.quantity', 'quotation_details.price_usd', 'quotation_details.price_jpy')
                            ->where('quotation.project_id', '=', $projectDetail->project_id)
                            ->where('quotation_details.order_product_id', '=', $projectDetail->order_product_id)
                            ->orderBy('quotation.date', 'desc')
                            ->get();
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
                <strong>CHIENOWA VIETNAM LTD.,</strong>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="page-header">
                    <h1>Quotation <small>remind email</small></h1>
                    <h3>Project <small>{{$projectDetail->project->name}}</small></h3>
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
            <div class="col-sm-12">
                <strong>Project Item Name:</strong> <span class="label label-info">{{$projectDetail->orderProduct->name}}</span><br/>
                <?php
                $sg_quotation_detail = QuotationDetail::find($projectDetail->sg_quotation_detail_id);
                ?>
                <strong>Suggest supplier:</strong> {{$sg_quotation_detail->quotation->supplier->name}}<br/>
                <strong>Suggest price:</strong> {{number_format($sg_quotation_detail->price, 0, '.', ',')}} VND - {{number_format($sg_quotation_detail->price_usd, 4, '.', ',')}} USD - {{number_format($sg_quotation_detail->price_jpy, 2, '.', ',')}} JPY<br/>
                <strong>Quotation date: </strong>{{date('m/d/Y', strtotime($sg_quotation_detail->quotation->date))}}<br/>
                <strong>Suggest note:</strong> {{$projectDetail->sg_note}}<br/>
            </div>
            <br/>
            <div class="col-sm-12">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>Supplier</th>
                            <th>Date</th>
                            <th>Price</th>
                            <th class="text-center">Quantity</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($quotationDetails as $quotationDetail)
                        <tr @if($projectDetail->sg_quotation_detail_id == $quotationDetail->id) class="success" @endif>
                            <td>
                                {{Supplier::find($quotationDetail->supplier_id)->name}}
                                <button type="button" id="{{$quotationDetail->supplier_id}}" class="btn btn-link info-button"><span class='glyphicon glyphicon-info-sign'></span></button>
                            </td>
                            <td>{{date('m/d/Y', strtotime($quotationDetail->date))}}</td>
                            <td>{{number_format($quotationDetail->price, 0, '.', ',')}} VND - {{number_format($quotationDetail->price_usd, 4, '.', ',')}} USD - {{number_format($quotationDetail->price_jpy, 2, '.', ',')}} JPY</td>
                            <td class="text-center">{{$quotationDetail->quantity}}</td>
                            <td>{{$quotationDetail->note}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-1">
                <button type="button" class="btn btn-default">Finish</button>
            </div>
            <div class="col-sm-1">
                <button type="button" class="btn btn-default">Again</button>
            </div>
        </div>
    </div>
</body>
</html>
