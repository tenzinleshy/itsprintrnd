<?php


// header ("Content-Type: text/html; charset=utf-8");
// echo "<!DOCTYPE html>
// <html>
// <head>
// <meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">
// <title>Open Server</title>
// </head>
// <body style=\"background: url(fon.png) top left repeat-x\">
// <center>
// <br><br><br><div style=\"width: 600px;\"><span style=\"font-size: 32px; color: green; font-family: Arial, Verdana; text-shadow: 0 1px 0 #fff\">Добро пожаловать в Open Server!</span>
// <br><br><br><span style=\"font-size: 32px; color: #333; font-family: Verdana, Arial;\">Он работает ;-)</span>
// <br><img src=\"st.png\" style=\"margin: 40px 0\"><br><a href=\"http://open-server.ru/docs/\" style=\"font-size: 24px; color: #048acd; font-family: Arial;\">Руководство пользователя</a></span><br><br><br></div>
// </center>
// </body>
// </html>";

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

$tableStr = '<table border="1" cellpadding="2">';
$tableStr.=	'
	<tr>
		<th>Currency name
		</th>
		<th>Rate
		</th>
		<th>Ask
		</th>		
		<th>Bid
		</th>			
		<th>Date
		</th>			
	</tr>';
	foreach($currencyIdsArr as $currencyId => $rateArr){
		$tableStr.=	'
			<tr>
				<td>'.$currencyId.'
				</td>
				<td>'.$rateArr["rate"].'
				</td>
				<td>'.$rateArr["ask"].'
				</td>		
				<td>'.$rateArr["bid"].'
				</td>			
				<td>'.$rateArr["date"].'
				</td>			
			</tr>';
	}

$tableStr.='</table>';

echo $tableStr;

?>
