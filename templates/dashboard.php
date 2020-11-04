<?php 
$i = 1;
foreach (array_keys($data) as $id) { 
// build the cards for each deviceID payload.php line: 6 
$html = "  <div class='col-sm-4'>
    <div class='card'>
      <div class='card-body'>
        <h5 class='card-title'><b><a href='index.php?page=sensor&id=". $id . "'>". $id . "</a></b></h5>
        <p class='card-text'>
		Temperature: ". $data[$id]['Current-Temperature'] . "&deg;<br /> 
		Humidity: ". round($data[$id]['Current-Humidity'], 1, PHP_ROUND_HALF_UP) . "&#37;<br />
		Update: ". $data[$id]['Current-Time'] . "</p>
      </div>
    </div>
  </div>";

	if($i == 1 || $i == 4 || $i == 7 || $i == 10 ) { // start new ro w cards with sensor data
		$i++; 
		echo "<div class='row'>";
		echo $html;
	} elseif ($i == 2 ) { 
		$i++;	
		echo $html;		
	} elseif ($i == 3 ) { // close row
		$i++;
		echo $html;		
		echo "</div>";
	} elseif ($i == 5 ) {
		$i++;	
		echo $html;		
	} elseif ($i == 6 ) { // close row
		$i++;
		echo $html;		
		echo "</div>";
	} elseif ($i == 8 ) {
		$i++;	
		echo $html;		
	} elseif ($i == 9 ) { // close row
		$i++;
		echo $html;		
		echo "</div>";
	} else { // close row
		$i++;
		echo $html;
		echo "</div>";	
	}
}
?> 