
<?php
//Login data storage TTN
$appID = "diyconnetwork"; // Application ID thingsnetwork
$authkey = 'ttn-account-v2.GUXFhdizL2eKA2jM6d5oxeHjaaISdfGYiA-qHyoJg80'; // Authorization: key thingsnetwork
$timeframe = "8h"; // set how many hours(h) or days(d) you want to display from the Data Storage TTN
$deviceID = array('dhtsensor01','dhtsensor04','dhtsensor05'); // select the deviceID TTN you want to show in the dashboard

//Fetch Payload data from Data Storrage
$jsonurl = "https://$appID.data.thethingsnetwork.org/api/v2/query?last=$timeframe"; //Link to json file.
$key = array('Accept: application/json', 'Authorization: key '. $authkey . ''); //Authorization key from TheThingsNetwork
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $jsonurl);
curl_setopt($ch, CURLOPT_HTTPHEADER, $key); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result=curl_exec($ch);
curl_close($ch);
$array = json_decode($result, true);

//Sort json by time
function sortArray($t1, $t2){
if ($t1['time'] == $t2['time']) return 0;
return ($t1['time'] > $t2['time']) ? -1 : 1;} 		
usort($array, "sortArray");

//Make for each device-id a new array
foreach($array as $obj) {
	if (in_array($obj['device_id'], $deviceID)) { 
		//edit time format.
			$test = substr($obj['time'], 0, -9);
			$originalTime = strstr($obj['time'], '.', true) ; 
			$newFormat = date("Y-m-d H:i:s", strtotime($originalTime) + 120*60); // 120*60 adjust time to timezone
		//start creating data for each device
      $data[$obj['device_id']][] = array(	  
		  "Device_id"=> $obj['device_id'], // device_id - Default value from TheThingsNetwork.
		  "Raw_Data" => $obj['raw'], //raw - Default value from TheThingsNetwork.
		  "Time" => $newFormat, //time - Default value from TheThingsNetwork. 	
		  "Temperature" => $obj['Temperature'], //Temperature - Custom key + value from Payload functions TheThingsNetwork
		  "Humidity" => $obj['Humidity'] //Humidity - Custom key + value from Payload functions TheThingsNetwork
	  	  );  
     }  
}
// Adding custom keys json output
foreach (array_keys($data) as $id) {
$count_array =  count($data[$id]);
$slice = array_slice($data[$id], 1, $count_array); 
{
$data[$id]['Device_id'] = $data["$id"][0]['Device_id'];
$data[$id]['Current-Time'] = $data["$id"][0]['Time'];
$data[$id]['Current-Temperature'] = $data["$id"][0]['Temperature'];
$data[$id]['Current-Humidity'] = $data["$id"][0]['Humidity'];
} 
// Start calculating max and min values 
$temperature_array = array();
foreach ($slice as $key => $value) {
	$temperature_array[]= $value['Temperature'];
}
{
$data[$id]['Max-Temperature'] = max($temperature_array);
$data[$id]['Min-Temperature'] = min($temperature_array);
} 
$humidity_array = array();
foreach ($slice as $key => $value) {
	$humidity_array[]= $value['Humidity'];
}
{
$data[$id]['Max-Humidity'] = max($humidity_array);
$data[$id]['Min-Humidity'] = min($humidity_array);
} 
// Calculate Dew Point
$Temp = $data[$id]['Current-Temperature'];
$Hum = $data[$id]['Current-Humidity'];
$A = log($Hum / 100) + (17.62 * $Temp / (243.12 + $Temp));
$dpResult = 243.12 * $A / (17.62 - $A);
$dPoint =  round($dpResult);
{
$data[$id]['Dewpoint'] = $dPoint;
} 
}
// End calculating max and min values 

//Sort the new array by key name
ksort($data); 
//echo "<pre>"; // uncomment for debugging
//print_r($data); // uncomment for debugging view the reuild json file
//echo "</pre>"; // uncomment for debugging
?>