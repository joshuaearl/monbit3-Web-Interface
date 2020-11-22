<?php

header('Content-Type: application/json');

if(isset($_GET["start"])){
	$start = $_GET["start"];
}else{
	$start = 0;
}

if(isset($_GET["end"])){
	$end = $_GET["end"];
}else{
	$end = 0;
}


$out = null;
$timerange = null;
if(isset($_GET["t1"]) && isset($_GET["t2"])){
	$t1 = $_GET["t1"];
	$t2 = $_GET["t2"];
	if($t1 && $t2 !== null){
		$format = " AND timestamp BETWEEN '%d' AND '%d'";
		$timerange = sprintf($format, $t1, $t2);
	}
}

# ?start=0&end=100&t1=1591713889&t2=1591713972

$con = mysqli_connect("127.0.0.1","databaseUsername","databasePassword","databaseName");

// Check connection
if (mysqli_connect_errno($con)){
    echo "Failed to connect to DataBase: " . mysqli_connect_error();
}else{
    $data_points = array();


	if(isset($_GET["show"]) && $_GET["show"] == "balance"){
		$result = mysqli_query($con, "SELECT id, timestamp, balance FROM data WHERE id BETWEEN '$start' AND '$end'$timerange");
		while($row = mysqli_fetch_array($result)){        
			$balance = $row['balance']/100000000;
			$point = array("id" => $row['id'], "x" => $row['timestamp'] , "y" => $balance);
			array_push($data_points, $point);        
		}
		foreach($data_points as $element){
			$out[$element['id']][] = ['id' => $element['id'], '0' => $element['x'], '1' => $element['y']];
		}
	}

	if(isset($_GET["show"]) && $_GET["show"] == "tx_count"){
		$result = mysqli_query($con, "SELECT id, timestamp, tx_count FROM data WHERE id BETWEEN '$start' AND '$end'$timerange");
		while($row = mysqli_fetch_array($result)){        
			$point = array("id" => $row['id'], "x" => $row['timestamp'] , "y" => $row['tx_count']);
			array_push($data_points, $point);        
		}
		foreach($data_points as $element){
			$out[$element['id']][] = ['id' => $element['id'], '0' => $element['x'], '1' => $element['y']];
		}
	}
	
	if(isset($_GET["show"]) && $_GET["show"] == "funds_rx"){
		$result = mysqli_query($con, "SELECT id, timestamp, funds_rx FROM data WHERE id BETWEEN '$start' AND '$end'$timerange");
		while($row = mysqli_fetch_array($result)){
			$funds_rx = $row['funds_rx']/100000000;        
			$point = array("id" => $row['id'], "x" => $row['timestamp'] , "y" => $funds_rx);
			array_push($data_points, $point);        
		}
		foreach($data_points as $element){
			$out[$element['id']][] = ['id' => $element['id'], '0' => $element['x'], '1' => $element['y']];
		}
	}
	
	if(isset($_GET["show"]) && $_GET["show"] == "funds_tx"){
		$result = mysqli_query($con, "SELECT id, timestamp, funds_tx FROM data WHERE id BETWEEN '$start' AND '$end'$timerange");
		while($row = mysqli_fetch_array($result)){
			$funds_tx = $row['funds_tx']/100000000;
			$point = array("id" => $row['id'], "x" => $row['timestamp'] , "y" => $funds_tx);
			array_push($data_points, $point);        
		}
		foreach($data_points as $element){
			$out[$element['id']][] = ['id' => $element['id'], '0' => $element['x'], '1' => $element['y']];
		}
	}


	if(isset($_GET["show"]) && $_GET["show"] == "recent"){
		$result = mysqli_query($con, "SELECT id, timestamp, transactions_rx, funds_rx, transactions_tx, funds_tx, tx_count, balance FROM data WHERE timestamp IN (SELECT max(timestamp) FROM data)");
		while($row = mysqli_fetch_array($result)){
			$funds_rx = $row['funds_rx']/100000000;
			$funds_tx = $row['funds_tx']/100000000;
			$balance = $row['balance']/100000000;
			$point = array("id" => $row['id'], "timestamp" => $row['timestamp'], "transactions_rx" => $row['transactions_rx'], "funds_rx" => $funds_rx, "transactions_tx" => $row['transactions_tx'], "funds_tx" => $funds_tx,  "tx_count" => $row['tx_count'], "balance" => $balance);
			array_push($data_points, $point);        
		}
		$out = $data_points;
	}
	
	
	if(isset($_GET["show"]) && $_GET["show"] == "addressbook"){
		$result = mysqli_query($con, "SELECT id, address FROM addresses");
		while($row = mysqli_fetch_array($result)){
			$point = array("id" => $row['id'], "address" => $row['address']);
			array_push($data_points, $point);        
		}
		foreach($data_points as $element){
			$out[$element['id']] = ['id' => $element['id'], 'address' => $element['address']];
		}
	}
	

    echo json_encode($out, JSON_PRETTY_PRINT);
    // echo json_encode($data_points, JSON_NUMERIC_CHECK);
}
mysqli_close($con);

?>