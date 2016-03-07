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
      var json = $.ajax({
            url: 'get_99uu.php',
            dataType: 'json',
            async: false
            }).responseText;

      var cms = $.ajax({
            url: 'get_cms.php',
            dataType: 'json',
            async: false
            }).responseText;

      var data = new google.visualization.DataTable(json);
      var cms_data = new google.visualization.DataTable(cms);
      var options = {
	chartArea: {'left': 40,'right':20,'weight': '100%','height': '70%'},
	pointSize: 3,
	curveType: 'function',
	legend: {position: 'bottom'},
        width: 720,
        height: 200
      };

      var chart = new google.visualization.LineChart(document.getElementById('99uu_chart'));
      var chart2 = new google.visualization.LineChart(document.getElementById('cms_chart'));

      chart.draw(data, options);
      chart2.draw(cms_data, options);
    }
 </script>
</head>
<body>
<div class=metrics>
<table>
	<tr>
	<td class=name>99uu Availability</td>
	</tr>
	<tr>
	<td class=num><?php print file_get_contents('http://status.spiralworks-cloud.com/uptime/get_availability.php?operator=99uu'); ?></td>
	</tr>	
	<tr>
	<td>Average response time</td>
	</tr>
	<tr>
	<td class=num><?php print file_get_contents('http://status.spiralworks-cloud.com/uptime/get_average.php?metric_id=1'); ?></td>
	</tr>	
</table>
</div>
<div class=graph id="99uu_chart"></div>
<div class=metrics2>
<table>
	<tr>
	<td class=name>CMS Availability</td>
	</tr>
	<tr>
	<td class=num><?php print file_get_contents('http://status.spiralworks-cloud.com/uptime/get_availability.php?operator=cms'); ?></td>
	</tr>	
	<tr>
	<td>Average response time</td>
	</tr>
	<tr>
	<td class=num><?php print file_get_contents('http://status.spiralworks-cloud.com/uptime/get_average.php?metric_id=6'); ?></td>
	</tr>	
</table>
</div>
<div class=cms_graph id="cms_chart"></div>
</body>
</html>
