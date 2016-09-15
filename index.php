<?php


 header ("Content-Type: text/html; charset=utf-8");
 echo '<!DOCTYPE html>
 <html>
 <head>
 <meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">
 <title>Open Server</title>
 </head>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
 <link rel="stylesheet" href="https://code.getmdl.io/1.2.1/material.indigo-pink.min.css">
 <script defer src="https://code.getmdl.io/1.2.1/material.min.js"></script>
 <body style=\"background: url(fon.png) top left repeat-x\">
 </body>
 </html>';

$currencyIdsArr = array(
		'EUR'=>array(),
		'RUB'=>array(),
		'USD'=>array(),
		'GBP'=>array(),
		'INR'=>array(),
		'AUD'=>array(),
		'CAD'=>array(),
		'SGD'=>array()
	);

foreach($currencyIdsArr as $currencyId => $rateArr){
	
	$str = "http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.xchange%20where%20pair%20in%20(%22%20".$currencyId."RUB%20%22)&env=store://datatables.org/alltableswithkeys";

	$xml = file_get_contents($str);
	$xmlObj = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
	$rateData = json_decode(json_encode((array)$xmlObj), TRUE);
	$rateData = $rateData['results']['rate'];

	$currencyIdsArr[$currencyId]['rate'] = $rateData['Rate'];
	$currencyIdsArr[$currencyId]['date'] = $rateData['Date'];
	$currencyIdsArr[$currencyId]['ask'] = $rateData['Ask'];
	$currencyIdsArr[$currencyId]['bid'] = $rateData['Bid'];
	
}
// var_dump($currencyIdsArr);

$tableStr = '<table border="1" cellpadding="2" class="mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--2dp">';
$tableStr.=	'
	<tr>
		<th class="mdl-data-table__cell--non-numeric">Currency name
		</th>
		<th class="mdl-data-table__cell--non-numeric">Rate
		</th>
		<th class="mdl-data-table__cell--non-numeric">Ask
		</th>		
		<th class="mdl-data-table__cell--non-numeric">Bid
		</th>			
		<th class="mdl-data-table__cell--non-numeric">Date
		</th>			
	</tr>';
	foreach($currencyIdsArr as $currencyId => $rateArr){
		$tableStr.=	'
			<tr>
				<td class="mdl-data-table__cell--non-numeric">'.$currencyId.'
				</td>
				<td class="mdl-data-table__cell--non-numeric">'.$rateArr["rate"].'
				</td>
				<td class="mdl-data-table__cell--non-numeric">'.$rateArr["ask"].'
				</td>		
				<td class="mdl-data-table__cell--non-numeric">'.$rateArr["bid"].'
				</td>			
				<td class="mdl-data-table__cell--non-numeric">'.$rateArr["date"].'
				</td>			
			</tr>';
	}

$tableStr.='</table>';

echo $tableStr;

?>
