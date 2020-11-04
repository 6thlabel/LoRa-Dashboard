<?php
$t= 25; // $t - how may data points you want to show in the chart
$n = 5; // how many last data rows you want to show bottom page
?>

<div class="container-fluid"><!-- /#page-content-wrapper -->
  <div class="row"><div class="col-md-12"><br /></div></div>
    <div class="row justify-content-around">
        <div class="col-md-4 offset-md-2">
            <div class="card text-center text-white bg-danger mb-3" style="width: 19rem; height: 13rem;"> 
                <div class="card-body">
					<h5 class="card-title"><b>Temperature</b></h5>
                    <span class="card-text"><h1><b><i class="fas fa-thermometer-half"></i>&nbsp;<?php echo $data[$sensorID]['Current-Temperature']; ?>&deg;</b></h1></span>
                </div>
                <div class="card-footer"><small class="text">Last updated <?php echo $data[$sensorID]['Current-Time']; ?></small></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center text-white bg-primary mb-3"style="width: 19rem; height: 13rem;">
                <div class="card-body">
					<h5 class="card-title"><b>Humidity</b></h5>
                    <span class="card-text"><h1><b><i class="fas fa-tint"></i>&nbsp;<?php echo $data[$sensorID]['Current-Humidity']; ?>%</b></h1></span>
                </div>
            <div class="card-footer"><small class="text">Last updated  <?php echo $data[$sensorID]['Current-Time']; ?></small></div>
          </div>
      </div>
  </div>    
    <div class="row justify-content-around">
		<div class="col-md-1"></div>
        <div class="col-md-3">
          <div class="card" style="height: 31rem;"> 
			  <div class="card-body">
			  <p class="card-text"><h4>Sensor data</h4>Node id: <?php  echo $data[$sensorID]['Device_id']; ?>
			  <p class="card-text">Max Temperature: <?php  echo $data[$sensorID]['Max-Temperature']; ?><br />
			  Min Temperature: <?php  echo $data[$sensorID]['Min-Temperature']; ?>
			  <br /> .Max Humidity: <?php  echo $data[$sensorID]['Max-Humidity']; ?><br />
			  Min Humidity: <?php  echo $data[$sensorID]['Min-Humidity']; ?>				  
        <br /><h4>Dew point</h4>
  <!-- start building PieChart-->
  <canvas id="myChart" width="200" height="150"></canvas>		  
  <script>
	 Chart.pluginService.register({
		beforeDraw: function (chart) {
			if (chart.config.options.elements.center) {
        //Get ctx from string
        var ctx = chart.chart.ctx;
				//Get options from the center object in options
        var centerConfig = chart.config.options.elements.center;
      	var fontStyle = centerConfig.fontStyle || 'Verdana';
				var txt = centerConfig.text;
        var color = centerConfig.color || '#CCCCCC';
        var sidePadding = centerConfig.sidePadding || 20;
        var sidePaddingCalculated = (sidePadding/100) * (chart.innerRadius * 2)
        //Start with a base font of 30px
        ctx.font = "30px " + fontStyle;     
				//Get the width of the string and also the width of the element minus 10 to give it 5px side padding
        var stringWidth = ctx.measureText(txt).width;
        var elementWidth = (chart.innerRadius * 2) - sidePaddingCalculated;
        // Find out how much the font can grow in width.
        var widthRatio = elementWidth / stringWidth;
        var newFontSize = Math.floor(30 * widthRatio);
        var elementHeight = (chart.innerRadius * 2);

        // Pick a new font size so it will not be larger than the height of label.
        var fontSizeToUse = Math.min(newFontSize, elementHeight);

				//Set font settings to draw it correctly.
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        var centerX = ((chart.chartArea.left + chart.chartArea.right) / 2);
        var centerY = ((chart.chartArea.top + chart.chartArea.bottom) / 2);
        ctx.font = fontSizeToUse+"px " + fontStyle;
        ctx.fillStyle = color;
        
      //Draw text in center
      ctx.fillText(txt, centerX, centerY);
      }
      }
      });
      var config = {
      type: 'doughnut',
      data: {
      labels: ["Temperature", "Humidity"],
      datasets: [{
        backgroundColor: [
          "#dd402b",
          "#3498db"
        ],
        data: [<?php echo $data[$sensorID]['Current-Temperature']; ?>,<?php echo $data[$sensorID]['Current-Humidity']; ?>]
      }]
      },
      options: {
      elements: {
      center: {
      text: '<?php echo $data[$sensorID]['Dewpoint']; ?>\xB0',
      color: '#abb0ac', // Default is #000000
      fontStyle: 'Helvetica', // Default is Arial
      sidePadding: 58 // Defualt is 20 (as a percentage)
      }
      }
      }
      };
    var ctx = document.getElementById("myChart").getContext("2d");
    var myChart = new Chart(ctx, config);
    </script>
    <script> 
    var ctx = document.getElementById("pieChart").getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
      labels: ["Temperature", "Humidity"],
      datasets: [{
      backgroundColor: [
      "#dd402b",
      "#3498db"
      ],
      data: [<?php echo $data[$sensorID]['Current-Temperature']; ?>,<?php echo $data[$sensorID]['Current-Humidity']; ?>]
      }]
      },
        options: {
        responsive: true,
        legend: {
        display: true,
        }
      },					
    });
    </script>
        </div>
		</div>
    </div>
	
    <div class="col-md-7">
        <div class="card" style="width: 52rem; height: 31rem;"> 
            <div class="card-body">
        <p class="card-text"><h4>Sensor chart</h4>
          <!-- start building chart-->
<canvas id="sensor-chart"></canvas>
<script> 
	var ctx = document.getElementById('sensor-chart').getContext('2d');
			var chart = new Chart(ctx, {    	
        type: 'line',   	
        data: {     
        labels: [<?php for($i=$t; $i>=0; $i--){  echo "'" . date('H:i', strtotime($data[$sensorID][$i]['Time'])) . "', "; } ?> ], 
        datasets: [{
        label: 'Temperature',
        yAxisID: 'y-axis-1',
        lineTension : '0',
        borderColor : 'rgb(221, 84, 43)',
        backgroundColor : 'rgba(255, 255, 255, 0)',	
        data: [<?php for($i=$t; $i>=0; $i--){ echo $data[$sensorID][$i]['Temperature'] . ", "; } ?>],
        },
        {
        label: 'Humidity',
        yAxisID: 'y-axis-2',
        lineTension : '0',
        borderColor : 'rgb(43, 180, 221)',
        backgroundColor : 'rgba(255, 255, 255, 0)',	
        data: [<?php for($i=$t; $i>=0; $i--){ echo $data[$sensorID][$i]['Humidity'] . ", "; } ?> ],
        }]
        },
        options: {
            scales: {
            yAxes: [{
            position: 'left',
            id: 'y-axis-1',
            ticks: {stepSize: 1}
            }, 			  
            {
            position: 'right',
            id: 'y-axis-2',
            ticks: {stepSize: 1}
    			  }]
   			 }
		}
});
</script>
            </div>
        </div>
    </div>
		<div class="col-md-1"></div>
</div>
<div class="row"><div class="col-md-12"><br /></div></div>
    <div class="row justify-content-around">
        <div class="col-md-10 col-md-offset-1">
            <div class="card  mb-3"style="height: 30rem;">
                <div class="card-header"><h6>Payload data</h6></div>
                <div class="card-body">
					<table class="table">
					  <thead>
						<tr>
						  <th scope="col">Time</th>
						  <th scope="col">Temperature</th>
						  <th scope="col">Humidity</th>
						</tr>
					  </thead>
						<tbody>
							
					<?php 
							
					for ($x = 0; $x <= $n; $x++) {
						echo "<td>" . $data[$sensorID][$x]['Time'] . "</td><td>". $data[$sensorID][$x]['Temperature'] . "</td><td>". $data[$sensorID][$x]['Humidity'] . "</td></tr>";
							}
						?>
						</tbody>
					</table>
                </div>
            </div>
        </div>
      </div>    
    </div>
    
</div><!-- /#wrapper -->