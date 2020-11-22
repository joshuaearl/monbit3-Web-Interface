<?php

header('Content-Type: application/json');

$con = mysqli_connect("127.0.0.1","databaseUsername","databasePassword","databaseName");

$array_limit = 10;

if(isset($_GET['limit']) && filter_var($_GET['limit'], FILTER_VALIDATE_INT)){
	$array_limit = $_GET['limit'];
}

if(isset($_GET['round']) && filter_var($_GET['round'], FILTER_VALIDATE_INT)){
	if($_GET['round'] == 1){
		$round = 1;
	}
}

// /data.php?column=transactions_rx&start=0&end=5&t1=1592157835&t2=1592153509&round=1&limit=10


if(isset($_GET['column']) && $_GET['column'] != null){
	if($_GET['column'] == 'transactions_rx'){
		$column = 'transactions_rx';
	}
	if($_GET['column'] == 'funds_rx'){
		$column = 'funds_rx';
	}
	if($_GET['column'] == 'transactions_tx'){
		$column = 'transactions_tx';
	}
	if($_GET['column'] == 'funds_tx'){
		$column = 'funds_tx';
	}
	if($_GET['column'] == 'tx_count'){
		$column = 'tx_count';
	}
	if($_GET['column'] == 'balance'){
		$column = 'balance';
	}
}

if(isset($column)){
	// Check connection
	if (mysqli_connect_errno($con)){
		echo "Failed to connect to database: " . mysqli_connect_error();
	}else{
		$data_points = array();
		$result = mysqli_query($con, "SELECT id, timestamp, transactions_rx, funds_rx, transactions_tx, funds_tx, tx_count, balance FROM data WHERE id BETWEEN 0 AND 20 AND timestamp ='1606076171'");
		while($row = mysqli_fetch_array($result)){
			$point = array("id" => $row['id'], "timestamp" => $row['timestamp'], "transactions_rx" => $row['transactions_rx'], "funds_rx" => $row['funds_rx'], "transactions_tx" => $row['transactions_tx'], "funds_tx" => $row['funds_tx'],  "tx_count" => $row['tx_count'], "balance" => $row['balance']);
			array_push($data_points, $point);        
		}	
		$present_dataset = $data_points;

		$data_points = array();
		$result = mysqli_query($con, "SELECT id, timestamp, transactions_rx, funds_rx, transactions_tx, funds_tx, tx_count, balance FROM data WHERE id BETWEEN 0 AND 20 AND timestamp ='1606076472'");
		while($row = mysqli_fetch_array($result)){  
			$point = array("id" => $row['id'], "timestamp" => $row['timestamp'], "transactions_rx" => $row['transactions_rx'], "funds_rx" => $row['funds_rx'], "transactions_tx" => $row['transactions_tx'], "funds_tx" => $row['funds_tx'],  "tx_count" => $row['tx_count'], "balance" => $row['balance']);
			array_push($data_points, $point);        
		}	
		$onehr_dataset = $data_points;
		
		$temp_dataset = $present_dataset;
		for($i = 0;$i < count($temp_dataset);$i++){
			$present_var = $temp_dataset[$i][$column];
			$onehr_var = $onehr_dataset[$i][$column];
			
			$change = $present_var - $onehr_var;
			$percentage = $change / $onehr_var * 100;
			$percentage = number_format($percentage, 4);
			
			$funds_rx = $temp_dataset[$i]['funds_rx']/100000000;
			$funds_tx = $temp_dataset[$i]['funds_tx']/100000000;
			$balance = $temp_dataset[$i]['balance']/100000000;			
			if(isset($round) && $round == 1){
				$funds_rx = ceil($funds_rx);
				$funds_tx = ceil($funds_tx);
				$balance = ceil($balance);
			}
			$temp_dataset[$i]['funds_rx'] = $funds_rx;
			$temp_dataset[$i]['funds_tx'] = $funds_tx;
			$temp_dataset[$i]['balance'] = $balance;
			$temp_dataset[$i]['change'] = $change;
			$temp_dataset[$i]['percentage'] = $percentage;
		}
		
		usort($temp_dataset, function($a, $b) {
		return $b['change'] <=> $a['change'];
		});	
		$response = array_slice($temp_dataset, 0, $array_limit);
		
		// echo json_encode($data_points, JSON_NUMERIC_CHECK);
		echo json_encode($response, JSON_PRETTY_PRINT);

		// print("<pre>".print_r($response,true)."</pre>");

	}
	mysqli_close($con);
}
?>