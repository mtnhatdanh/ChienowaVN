<?php

class Rate{
	var $source = "http://www.vietcombank.com.vn/ExchangeRates/ExrateXML.aspx";
	var $mydate;

	function getXML(){
		return file_get_contents($this->source);
	}
	
	function getRate(){
		$xmlData = NULL;
		$p = xml_parser_create();
		xml_parse_into_struct($p,$this->getXML() , $xmlData);
		xml_parser_free($p);
		$this->mydate = $xmlData['1']['value'];
		$data = array();
		if($xmlData){
			foreach($xmlData as $v)
			if(isset($v['attributes']))
				{
					$data[] = $v['attributes'];
				}
			return $data;
		}
		return false;
	}
	function show(){
		$data = $this->getRate();
		print 'Tỷ giá ngoại tệ Vietcombank ngày : '.$this->mydate.'<br />';

		print '<table width=435 class=tbl-01 cellpadding=0 cellspacing=0>';
		print '<tr>';

		print '<th align=center width=35>Mã NT</th><th align=center width=175>Tên ngoại tệ</th><th align=center width=70>Mua tiền mặt</th><th align=center width=70>Chuyển khoản</th><th align=center width=70>Bán</th>';
		print '</tr>';
		print '</table>';


		foreach($data as $k=>$v){
		print '<table width=435 class=tbl-01 cellpadding=0 cellspacing=0>';
		print '<tr >';
		print '<td align=left width=35 class=even>'.$v['CURRENCYCODE'].' </td><td align=left width=175>'.$v['CURRENCYNAME'].' </td><td align=right width=70> '.$v['BUY'].' </td><td align=right width=70> '.$v['TRANSFER'].'</td><td align=right width=70>'.$v['SELL'].'</td>';
		print '</tr>';
		print '</table>';


		}
	}
	function showRateArray() {
		$data = $this->getRate();
		$result = array();
		foreach ($data as $k=>$v) {
			if ($v['CURRENCYCODE'] == 'USD') {
				$result['USD'] = $v['SELL'];
			}
			if ($v['CURRENCYCODE'] == 'JPY') {
				$result['JPY'] = $v['SELL'];
			}
		}
		return $result;
	}
}
?>