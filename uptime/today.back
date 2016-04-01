<html>
<head>
  <link rel="stylesheet" type="text/css" href="reset-min.css">
  <link rel="stylesheet" type="text/css" href="main.css">
  <link rel="stylesheet" type="text/css" href="extra.css">
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script type="text/javascript">
    google.charts.load('44', {packages: ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var ninenineuu = $.ajax({
            url: 'http://status.spiralworks-cloud.com/uptime/get_data.php?metric_id=1',
            dataType: 'json',
            async: false
            }).responseText;

      var cms = $.ajax({
            url: 'http://status.spiralworks-cloud.com/uptime/get_data.php?metric_id=6',
            dataType: 'json',
            async: false
            }).responseText;

      var apollo = $.ajax({
            url: 'http://status.spiralworks-cloud.com/uptime/get_data.php?metric_id=10',
            dataType: 'json',
            async: false
            }).responseText;

      var betsoft = $.ajax({
            url: 'http://status.spiralworks-cloud.com/uptime/get_data.php?metric_id=11',
            dataType: 'json',
            async: false
            }).responseText;

      var crescendo = $.ajax({
            url: 'http://status.spiralworks-cloud.com/uptime/get_data.php?metric_id=12',
            dataType: 'json',
            async: false
            }).responseText;

      var gpi = $.ajax({
            url: 'http://status.spiralworks-cloud.com/uptime/get_data.php?metric_id=8',
            dataType: 'json',
            async: false
            }).responseText;

      var massimo = $.ajax({
            url: 'http://status.spiralworks-cloud.com/uptime/get_data.php?metric_id=9',
            dataType: 'json',
            async: false
            }).responseText;

      var palazzo = $.ajax({
            url: 'http://status.spiralworks-cloud.com/uptime/get_data.php?metric_id=7',
            dataType: 'json',
            async: false
            }).responseText;

      var png = $.ajax({
            url: 'http://status.spiralworks-cloud.com/uptime/get_data.php?metric_id=13',
            dataType: 'json',
            async: false
            }).responseText;

      var nineuu_data = new google.visualization.DataTable(ninenineuu);
      var cms_data = new google.visualization.DataTable(cms);
      var apollo_data = new google.visualization.DataTable(apollo);
      var betsoft_data = new google.visualization.DataTable(betsoft);
      var crescendo_data = new google.visualization.DataTable(crescendo);
      var gpi_data = new google.visualization.DataTable(gpi);
      var massimo_data = new google.visualization.DataTable(massimo);
      var palazzo_data = new google.visualization.DataTable(palazzo);
      var png_data = new google.visualization.DataTable(png);

      var options = {
	chartArea: {'left': 40,'right':20,'weight': '100%','height': '70%'},
	pointSize: 2,
	curveType: 'function',
	legend: {position: 'bottom'},
        width: 720,
        height: 200
      };

      var chart = new google.visualization.LineChart(document.getElementById('99uu_chart'));
      var chart2 = new google.visualization.LineChart(document.getElementById('cms_chart'));
      var chart3 = new google.visualization.LineChart(document.getElementById('apollo_chart'));
      var chart4 = new google.visualization.LineChart(document.getElementById('betsoft_chart'));
      var crescendo = new google.visualization.LineChart(document.getElementById('crescendo_chart'));
      var gpi = new google.visualization.LineChart(document.getElementById('gpi_chart'));
      var massimo = new google.visualization.LineChart(document.getElementById('massimo_chart'));
      var palazzo = new google.visualization.LineChart(document.getElementById('palazzo_chart'));
      var png = new google.visualization.LineChart(document.getElementById('png_chart'));

      chart.draw(nineuu_data, options);
      chart2.draw(cms_data, options);
      chart3.draw(apollo_data, options);
      chart4.draw(betsoft_data, options);
      crescendo.draw(crescendo_data, options);
      gpi.draw(gpi_data, options);
      massimo.draw(massimo_data, options);
      palazzo.draw(palazzo_data, options);
      png.draw(png_data, options);
    }
 </script>
</head>
<body>
<div class=metrics>
	<div class=nineuu>
	<table>
	<tr><td class=name>99uu Availability</td></tr>
	<tr><td class=num><?php print file_get_contents('http://status.com/uptime/get_availability.php?operator=99uu'); ?></td></tr>
	<tr><td>Average response time</td></tr>
	<tr><td class=num><?php print file_get_contents('http://status.com/uptime/get_average.php?metric_id=1'); ?></td></tr>	
	</table>
	</div>

	<div class=cms>
	<table>
	<tr><td class=name>CMS Availability</td></tr>
	<tr><td class=num><?php print file_get_contents('http://status.com/uptime/get_availability.php?operator=cms'); ?></td></tr>
	<tr><td>Average response time</td></tr>
	<tr><td class=num><?php print file_get_contents('http://status.com/uptime/get_average.php?metric_id=6'); ?></td></tr>	
	</table>
	</div>

	<div class=apollo>
	<table>
	<tr><td class=name>Apollo Availability</td></tr>
	<tr><td class=num><?php print file_get_contents('http://status.com/uptime/get_availability.php?operator=apollo'); ?></td></tr>
	<tr><td>Average response time</td></tr>
	<tr><td class=num><?php print file_get_contents('http://status.com/uptime/get_average.php?metric_id=10'); ?></td></tr>	
	</table>
	</div>

	<div class=betsoft>
	<table>
	<tr><td class=name>Betsoft Availability</td></tr>
	<tr><td class=num><?php print file_get_contents('http://status.com/uptime/get_availability.php?operator=betsoft'); ?></td></tr>
	<tr><td>Average response time</td></tr>
	<tr><td class=num><?php print file_get_contents('http://status.com/uptime/get_average.php?metric_id=11'); ?></td></tr>	
	</table>
	</div>

	<div class=crescendo>
	<table>
	<tr><td class=name>Crescendo Availability</td></tr>
	<tr><td class=num><?php print file_get_contents('http://status.com/uptime/get_availability.php?operator=crescendo'); ?></td></tr>
	<tr><td>Average response time</td></tr>
	<tr><td class=num><?php print file_get_contents('http://status.com/uptime/get_average.php?metric_id=12'); ?></td></tr>	
	</table>
	</div>

	<div class=gpi>
	<table>
	<tr><td class=name>GPI Availability</td></tr>
	<tr><td class=num><?php print file_get_contents('http://status.com/uptime/get_availability.php?operator=gpi'); ?></td></tr>
	<tr><td>Average response time</td></tr>
	<tr><td class=num><?php print file_get_contents('http://status.com/uptime/get_average.php?metric_id=8'); ?></td></tr>	
	</table>
	</div>

	<div class=massimo>
	<table>
	<tr><td class=name>Massimo Availability</td></tr>
	<tr><td class=num><?php print file_get_contents('http://status.com/uptime/get_availability.php?operator=massimo'); ?></td></tr>
	<tr><td>Average response time</td></tr>
	<tr><td class=num><?php print file_get_contents('http://status.com/uptime/get_average.php?metric_id=9'); ?></td></tr>	
	</table>
	</div>

	<div class=palazzo>
	<table>
	<tr><td class=name>Pallazo Availability</td></tr>
	<tr><td class=num><?php print file_get_contents('http://status.com/uptime/get_availability.php?operator=palazzo'); ?></td></tr>
	<tr><td>Average response time</td></tr>
	<tr><td class=num><?php print file_get_contents('http://status.com/uptime/get_average.php?metric_id=7'); ?></td></tr>	
	</table>
	</div>

	<div class=png>
	<table>
	<tr><td class=name>PNG Availability</td></tr>
	<tr><td class=num><?php print file_get_contents('http://status.com/uptime/get_availability.php?operator=png'); ?></td></tr>
	<tr><td>Average response time</td></tr>
	<tr><td class=num><?php print file_get_contents('http://status.com/uptime/get_average.php?metric_id=13'); ?></td></tr>	
	</table>
	</div>
</div> 
<div class=graphs>
	<div class=graph_nineuu id="99uu_chart"></div>
	<div class=cms_graph id="cms_chart"></div>
	<div class=apollo_graph id="apollo_chart"></div>
	<div class=betsoft_graph id="betsoft_chart"></div>
	<div class=crescendo_graph id="crescendo_chart"></div>
	<div class=gpi_graph id="gpi_chart"></div>
	<div class=massimo_graph id="massimo_chart"></div>
	<div class=palazzo_graph id="palazzo_chart"></div>
	<div class=png_graph id="png_chart"></div>
</div>
</body>
</html>
