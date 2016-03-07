<?php 

$dbserver = "db1";
$dbname = "cachetdb";
$dbpass = "mypass2015";
$dbuser = "cachet";

$con = mysql_connect($dbserver,$dbuser,$dbpass) or die(mysql_error());

mysql_select_db($dbname,$con) or die(mysql_error());

$sql_query = "select value,updated_at from (select * from metric_points where metric_id = 4 and updated_at>=DATE_SUB(NOW(), interval 3 hour) order by id desc) sub order by id asc";

$results = mysql_query($sql_query) or die(mysql_error());

    $table = array();
    $table['cols'] = array(
        array('label' => 'update_at', 'type' => 'datetime'),
        array('label' => 'response time', 'type' => 'number'),
        );
    $rows = array();
    while ($r = mysql_fetch_assoc($results)) {
        $temp = array();

        $DateArr = explode(' ', $r['updated_at']);
        $dateArr = explode('-', $DateArr[0]);
        $timeArr = explode(':', $DateArr[1]);

        $year = (int) $dateArr[0];
        $month = ((int) $dateArr[1]) - 1;
        $day = (int) $dateArr[2];

        $hour = (int) $timeArr[0];
        $minute = (int) $timeArr[1];
        $second = (int) $timeArr[2];

        $date = "Date($year, $month, $day, $hour, $minute, $second)";

        $temp[] = array('v' => $date);
        $temp[] = array('v' => (float) $r['value']);
        $rows[] = array('c' => $temp);

    }
    $table['rows'] = $rows;

    $jsonTable = json_encode($table);


echo $jsonTable;





?>
