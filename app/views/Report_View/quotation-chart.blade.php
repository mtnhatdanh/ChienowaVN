<script type="text/javascript">
  google.setOnLoadCallback(drawChart);
  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Date', 'Price'],
      @foreach ($quotationDetailArray as $quotationDetail_id)
      <?php
      $quotationDetail = QuotationDetail::find($quotationDetail_id);
      ?>
      ['{{date('m-d-Y', strtotime($quotationDetail->quotation->date))}}',  {{$quotationDetail->price}}],
      @endforeach
    ]);

    var options = {
      title: 'Quotation Product Price',
      hAxis: {title: 'Date', titleTextStyle: {color: 'red'}}
    };

    var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
    chart.draw(data, options);
  }
</script>