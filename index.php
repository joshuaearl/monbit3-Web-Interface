<?php
if(isset($_GET['start'])){
	$start = $_GET["start"];
}else{
	$start = 0;
}
if(isset($_GET['end'])){
	$end = $_GET["end"];
}else{
	$end = 0;
}

if(isset($_GET["t1"]) && isset($_GET["t2"])){
	$t1 = $_GET["t1"];
	$t2 = $_GET["t2"];
}else{
	$t1 = Null;
	$t2 = Null;
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
	<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
	<meta content="utf-8" http-equiv="encoding">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
	<link rel="stylesheet" type="text/css" href="css/style.css"/>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
	<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="js/jquery.canvasjs.min.js"></script>
	<script type="text/javascript" src="js/tabs.js"></script>	
	<script>
	$(document).ready(function()
		{
			homepage = "balance";
			updateChart(homepage,0,0);
			
			var lookup = $.parseJSON($.ajax({
				url:  'api.php?show=addressbook',
				type: "GET",
				dataType: "json", 
				async: false
			}).responseText);
			
			
			$.ajax({
				url: "table.php?column=transactions_rx&round=1", 
				type: "GET",    
				dataType:"json",   
				success: function (response) 
				{
				  var trHTML = '';
				  $.each(response, function (key,value) {
					  var walletid = value.id
					  var address = lookup[walletid].address;
					  
					 trHTML +=  
						'<tr><td>' + address.substr(0,10) + 
						'</td><td>' + value.transactions_rx + 
						'</td><td>' + value.funds_rx + 
						'</td><td>' + value.transactions_tx + 
						'</td><td>' + value.funds_tx + 
						'</td><td>' + value.tx_count + 
						'</td><td>' + value.balance + 
						'</td><td>' + value.change + 
						'</td><td>' + value.percentage + 
						'</td></tr>';     
				  });

					$('#most_transactions_rx_table').append(trHTML);
				}   
			});
			
			$.ajax({
				url: "table.php?column=funds_rx&round=1", 
				type: "GET",    
				dataType:"json",   
				success: function (response) 
				{
				  var trHTML = '';
				  $.each(response, function (key,value) {
					  var walletid = value.id
					  var address = lookup[walletid].address;
					  
					 trHTML +=  
						'<tr><td>' + address.substr(0,10) + 
						'</td><td>' + value.transactions_rx + 
						'</td><td>' + value.funds_rx + 
						'</td><td>' + value.transactions_tx + 
						'</td><td>' + value.funds_tx + 
						'</td><td>' + value.tx_count + 
						'</td><td>' + value.balance + 
						'</td><td>' + Math.ceil(value.change/1000000) + 
						'</td><td>' + value.percentage + 
						'</td></tr>';     
				  });

					$('#most_funds_rx_table').append(trHTML);
				}   
			});
			
			$.ajax({
				url: "table.php?column=transactions_tx&round=1", 
				type: "GET",    
				dataType:"json",   
				success: function (response) 
				{
				  var trHTML = '';
				  $.each(response, function (key,value) {
					  var walletid = value.id
					  var address = lookup[walletid].address;
					  
					 trHTML +=  
						'<tr><td>' + address.substr(0,10) + 
						'</td><td>' + value.transactions_rx + 
						'</td><td>' + value.funds_rx + 
						'</td><td>' + value.transactions_tx + 
						'</td><td>' + value.funds_tx + 
						'</td><td>' + value.tx_count + 
						'</td><td>' + value.balance + 
						'</td><td>' + value.change + 
						'</td><td>' + value.percentage + 
						'</td></tr>';     
				  });

					$('#most_transactions_tx_table').append(trHTML);
				}   
			});
			
			$.ajax({
				url: "table.php?column=funds_tx&round=1", 
				type: "GET",    
				dataType:"json",   
				success: function (response) 
				{
				  var trHTML = '';
				  $.each(response, function (key,value) {
					  var walletid = value.id
					  var address = lookup[walletid].address;
					  
					 trHTML +=  
						'<tr><td>' + address.substr(0,10) + 
						'</td><td>' + value.transactions_rx + 
						'</td><td>' + value.funds_rx + 
						'</td><td>' + value.transactions_tx + 
						'</td><td>' + value.funds_tx + 
						'</td><td>' + value.tx_count + 
						'</td><td>' + value.balance + 
						'</td><td>' + Math.ceil(value.change/1000000) + 
						'</td><td>' + value.percentage + 
						'</td></tr>';     
				  });

					$('#most_funds_tx_table').append(trHTML);
				}   
			});
			
			$.ajax({
				url: "table.php?column=tx_count&round=1", 
				type: "GET",    
				dataType:"json",   
				success: function (response) 
				{
				  var trHTML = '';
				  $.each(response, function (key,value) {
					  var walletid = value.id
					  var address = lookup[walletid].address;
					  
					 trHTML +=  
						'<tr><td>' + address.substr(0,10) + 
						'</td><td>' + value.transactions_rx + 
						'</td><td>' + value.funds_rx + 
						'</td><td>' + value.transactions_tx + 
						'</td><td>' + value.funds_tx + 
						'</td><td>' + value.tx_count + 
						'</td><td>' + value.balance + 
						'</td><td>' + value.change + 
						'</td><td>' + value.percentage + 
						'</td></tr>';     
				  });

					$('#most_tx_count_table').append(trHTML);
				}   
			});
			
			$.ajax({
				url: "table.php?column=balance&round=1", 
				type: "GET",    
				dataType:"json",   
				success: function (response) 
				{
				  var trHTML = '';
				  $.each(response, function (key,value) {
					  var walletid = value.id
					  var address = lookup[walletid].address;
					  
					 trHTML +=  
						'<tr><td>' + address.substr(0,10) + 
						'</td><td>' + value.transactions_rx + 
						'</td><td>' + value.funds_rx + 
						'</td><td>' + value.transactions_tx + 
						'</td><td>' + value.funds_tx + 
						'</td><td>' + value.tx_count + 
						'</td><td>' + value.balance + 
						'</td><td>' + Math.ceil(value.change/1000000) + 
						'</td><td>' + value.percentage + 
						'</td></tr>';     
				  });

					$('#most_balance_table').append(trHTML);
				}   
			});
			
			$.ajax({
				url: "api.php?show=recent&start=0&end=1", 
				type: "GET",    
				dataType:"json",   
				success: function (response) 
				{
				  var trHTML = '';
				  $.each(response, function (key,value) {
					  var walletid = value.id
					  var address = lookup[walletid].address;
					  
					 trHTML += 
						'<tr><td>' + value.id + 
						'</td><td>' + address + 
						'</td><td>' + value.timestamp + 
						'</td><td>' + value.transactions_rx + 
						'</td><td>' + value.funds_rx + 
						'</td><td>' + value.transactions_tx + 
						'</td><td>' + value.funds_tx + 
						'</td><td>' + value.tx_count + 
						'</td><td>' + value.balance + 
						'</td></tr>';     
				  });

					$('#most_recent').append(trHTML);
				}   
			});
			document.getElementById("defaultOpen").click();
		});
	
	// Old data series visibility, individual hide
	
	function itemclick(e) {
	  if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	  } else {
		e.dataSeries.visible = true;
	  }
	  e.chart.render();
	}
	
	// function addCountToSeries(chart){
		// for(var i = 0; i < chart.options.data.length; i++) {
		  // chart.options.data[i].clickCount = 0;
		// }
	// }

	// function itemclick(e) {    
			// ++e.dataSeries.clickCount;
		// for(var i = 0; i < e.chart.options.data.length; i++) {
						
				// if (e.dataSeries.clickCount % 2 === 0){
					// e.chart.options.data[i].visible = true;           
			// }
				// else {
				// if (e.dataSeries !== e.chart.options.data[i]) {        		
					// e.chart.options.data[i].visible = false;
					// e.chart.options.data[i].clickCount = 0;
				// }
				// else{
					// e.dataSeries.visible = true;            
				// }
			// }
		// }
		// e.chart.render();
	// }
	
	function updateChart(show, t1, t2) {
		var date;
		var dps = [];
		var dataSeries = [];
		
		if(show == "balance"){
			var graphTitle = "Balance";
			var yAxisLabel = "Bitcoin";
			var tooltipYLabel = "Bitcoin";
		}
		if(show == "tx_count"){
			var graphTitle = "Transaction count";
			var yAxisLabel = "Transactions";
			var tooltipYLabel = "Transactions";
		}
		if(show == "funds_rx"){
			var graphTitle = "Funds received";
			var yAxisLabel = "Bitcoin";
			var tooltipYLabel = "Bitcoin";
		}
		if(show == "funds_tx"){
			var graphTitle = "Funds sent";
			var yAxisLabel = "Bitcoin";
			var tooltipYLabel = "Bitcoin";
		}
		
		var chart = new CanvasJS.Chart("chartContainer", {
			title:{
				text: graphTitle,
				fontSize: 30,
				fontFamily: "calibri",
			},
			zoomEnabled: true,
			toolTip: {
				content:"ID: {name}, Date: {x}, " + tooltipYLabel + ": {y}" ,
				// animationEnabled: true,
				shared: false,
			},
			axisX:{
				title:"Timestamp",
				titleFontSize: 18,
				labelFontSize: 16,
				// intervalType: "day",
				// interval: 1,
			},
			axisY:{
				title: yAxisLabel,
				titleFontSize: 18,
				labelFontSize: 16,
				// logarithmic:  true
			},
			legend: {
				cursor: "pointer",
				verticalAlign: "top",
				horizontalAlign: "top",
				fontSize: 16,
				fontFamily: "calibri",
				fontColor: "dimGrey",
				itemclick: itemclick
		  },
		  data: dataSeries
		});
		var url = 'api.php?show=' + show + '&start=<?php echo $start;?>&end=<?php echo $end;?>&t1=' + t1 + '&t2=' + t2 +'';
	   $.getJSON(url, function(data) {
		$.each(data, function(i) {
		  dps = [];
		  $.each(data[i], function(key, val) {
			date = val[0] * 1000;
			balance = parseInt(val[1]);
			dps.push({
			  x: date,
			  y: balance
			});
		  });
		  dataSeries.push({
			name: "wallet" + i,
			type: "line",
			xValueType: "dateTime",
			xValueFormatString: "DD MMM YYYY HH:mm:ss",
			showInLegend: true,
			dataPoints: dps
		  });
		});
		  chart.render();
	   });
	}
	// # ?start=0&end=100&t1=1591713889&t2=1591713972		
	$(function() {
	  $('input[name="datetimes"]').daterangepicker({
		timePicker: true,
		opens: 'left'
	  }, function(start, end, label) {
		console.log("A new date/time selection was made: " + start.format('DD-MM-YYYY hh:mm A') + ' to ' + end.format('DD-MM-YYYY hh:mm A'));
		
		var t1 = start.unix();
		var t2 = end.unix();
		updateChart(t1, t2);
	  });
	});
	</script>
</head>
<body>
<h1>monbit3</h1>
<div id="navbar">
	<div class="row">
		<div class="column">
			Quick Info
		</div>
		<div class="column">
			<label for="show">View:</label>
			<select name="show" id="show" onchange="updateChart(this.options[this.selectedIndex].value, 0, 0)">
				<option value="balance">Balance</option>
				<option value="tx_count">Tx Count</option>
				<option value="funds_rx">Funds Received</option>
				<option value="funds_tx">Funds Sent</option>
			</select>
			<label for="datepicker">Date range:</label>
			<input type="text" name="datetimes" id="datepicker" />
		</div>
	</div>
</div>
<div class="row" style="background-color: white;color: black;width: 100%;">
	<div class="column">
		<div class="quick_content" style="padding: 1rem;">
			<div class="tab">
			  <button class="tablinks" onclick="openTab(event, 'most_transactions_rx')" id="defaultOpen">Most Transactions Received</button>
			  <button class="tablinks" onclick="openTab(event, 'most_funds_rx')">Most Funds Received</button>
			  <button class="tablinks" onclick="openTab(event, 'most_transactions_tx')">Most Transactions Sent</button>
			  <button class="tablinks" onclick="openTab(event, 'most_funds_tx')">Most Funds Sent</button>
			  <button class="tablinks" onclick="openTab(event, 'most_tx_count')">Most Transactions Combined</button>
			  <button class="tablinks" onclick="openTab(event, 'most_balance')">Largest Balance Change</button>
			</div>
			<div id="most_transactions_rx" class="tabcontent">
				<h4>Most Transactions Received</h4>
				<table id="most_transactions_rx_table">
					<tr>
						<th align="center" style="width:12%;">Address</th>
						<th align="center" style="width:11%;">Tx Rx</th>
						<th align="center" style="width:11%;">Funds Rx</th>
						<th align="center" style="width:11%;">Tx Tx</th>
						<th align="center" style="width:11%;">Funds Tx</th>
						<th align="center" style="width:11%;">Tx Count</th>
						<th align="center" style="width:11%;">Bal</th>
						<th align="center" style="width:11%;">Change</th>
						<th align="center" style="width:11%;">Percent</th>
					</tr>
				</table>
			</div>
			<div id="most_funds_rx" class="tabcontent">
				<h4>Most Funds Received</h4>
				<table id="most_funds_rx_table">
					<tr>
						<th align="center" style="width:12%;">Address</th>
						<th align="center" style="width:11%;">Tx Rx</th>
						<th align="center" style="width:11%;">Funds Rx</th>
						<th align="center" style="width:11%;">Tx Tx</th>
						<th align="center" style="width:11%;">Funds Tx</th>
						<th align="center" style="width:11%;">Tx Count</th>
						<th align="center" style="width:11%;">Bal</th>
						<th align="center" style="width:11%;">Change</th>
						<th align="center" style="width:11%;">Percent</th>
					</tr>
				</table>
			</div>
			
			<div id="most_transactions_tx" class="tabcontent">
				<h4>Most Transactions Sent</h4>
				<table id="most_transactions_tx_table">
					<tr>
						<th align="center" style="width:12%;">Address</th>
						<th align="center" style="width:11%;">Tx Rx</th>
						<th align="center" style="width:11%;">Funds Rx</th>
						<th align="center" style="width:11%;">Tx Tx</th>
						<th align="center" style="width:11%;">Funds Tx</th>
						<th align="center" style="width:11%;">Tx Count</th>
						<th align="center" style="width:11%;">Bal</th>
						<th align="center" style="width:11%;">Change</th>
						<th align="center" style="width:11%;">Percent</th>
					</tr>
				</table>
			</div>
			
			<div id="most_funds_tx" class="tabcontent">
				<h4>Most Funds Sent</h4>
				<table id="most_funds_tx_table">
					<tr>
						<th align="center" style="width:12%;">Address</th>
						<th align="center" style="width:11%;">Tx Rx</th>
						<th align="center" style="width:11%;">Funds Rx</th>
						<th align="center" style="width:11%;">Tx Tx</th>
						<th align="center" style="width:11%;">Funds Tx</th>
						<th align="center" style="width:11%;">Tx Count</th>
						<th align="center" style="width:11%;">Bal</th>
						<th align="center" style="width:11%;">Change</th>
						<th align="center" style="width:11%;">Percent</th>
					</tr>
				</table>
			</div>
			
			<div id="most_tx_count" class="tabcontent">
				<h4>Most Transactions Combined</h4>
				<table id="most_tx_count_table">
					<tr>
						<th align="center" style="width:12%;">Address</th>
						<th align="center" style="width:11%;">Tx Rx</th>
						<th align="center" style="width:11%;">Funds Rx</th>
						<th align="center" style="width:11%;">Tx Tx</th>
						<th align="center" style="width:11%;">Funds Tx</th>
						<th align="center" style="width:11%;">Tx Count</th>
						<th align="center" style="width:11%;">Bal</th>
						<th align="center" style="width:11%;">Change</th>
						<th align="center" style="width:11%;">Percent</th>
					</tr>
				</table>
			</div>
			
			<div id="most_balance" class="tabcontent">
				<h4>Largest Balance Change</h4>
				<table id="most_balance_table">
					<tr>
						<th align="center" style="width:12%;">Address</th>
						<th align="center" style="width:11%;">Tx Rx</th>
						<th align="center" style="width:11%;">Funds Rx</th>
						<th align="center" style="width:11%;">Tx Tx</th>
						<th align="center" style="width:11%;">Funds Tx</th>
						<th align="center" style="width:11%;">Tx Count</th>
						<th align="center" style="width:11%;">Bal</th>
						<th align="center" style="width:11%;">Change</th>
						<th align="center" style="width:11%;">Percent</th>
					</tr>
				</table>
			</div>
			
		</div>
	</div>
	<div class="column" style="background-color: white;">
		<div id="chartContainer" style="height: 600px; width: 100%;"></div>
	</div>
</div>
<div class="most_recent" style="height:800px;">
	<h2 style="text-align:center;">Most Recent</h2>
	<table id="most_recent" style="margin-top:1rem;">
		<tr>
			<th align="center">Id</th>
			<th align="center">Address</th>
			<th align="center">Timestamp</th>
			<th align="center">Transactions Received</th>
			<th align="center">Funds Received</th>
			<th align="center">Transactions Sent</th>
			<th align="center">Funds Sent</th>
			<th align="center">Transaction Count</th>
			<th align="center">Balance</th>
		</tr>
	</table>
</div>
</body>
</html>