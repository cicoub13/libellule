<html>
<head>
<meta charset="UTF-8"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script><html>
<!-- Included CSS Files, use foundation.css if you do not want minified code -->
  <link rel="stylesheet" href="css/foundation.min.css">
  <link rel="stylesheet" href="css/app.css">

   
 <!-- HighCharts -->
 <script src="js/highcharts.js"></script>


<script src="js/jquery.foundation.navigation.js"></script>
  <!-- Custom Modernizr for Foundation -->
  <script src="js/modernizr.foundation.js"></script>
</head>
<body>

<?php
require_once('sqlite.php');
require_once('functions.php');
$ask_interval = false;
$option = "Aujourd\'hui";
if (isset($_GET['i'])){
    if ($_GET['i'] == "day"){
        $results = get_day();
    }
    else if ($_GET['i'] == "week"){
        $results = get_week();
	$option = "Semaine";
    }
    else if ($_GET['i'] == "month"){
        $results = get_month();
	$option = "Mois";
    }
    else if ($_GET['i'] == "all"){
        $results = get_all();
	$option = "Tout";
    }
    else if ($_GET['i'] == "int"){
	if (isset($_GET['start'])){
		$start = strtotime($_GET['start']);
		$end = strtotime($_GET['end']);
		if ($start >= $end)
			$results = get_day();
		else
			$results = get_interval($start, $end);
			$option = "Intervalle";
	}
	else{
		$ask_interval = true;
	}
    }
    else {
        $results = get_day();
    }
}
else
    $results = get_day();

if ($ask_interval == false){
$result_ping = $results[0];
$result_download= $results[1];
$result_upload = $results[2];
?>

<script>
$(function () {
    $(document).foundationNavigation();
        $('#container').highcharts({
            chart: {
        zoomType : 'xy'
        },
        title: {
                text: 'Debits Bouygues Telecom <?php echo $option; ?>',
                x: -20 //center
            },
            subtitle: {
                text: 'Source: Libellule',
                x: -20
            },
            xAxis: {
                categories: [<?php
$buffer= "";
foreach ($result_ping as $tmp){
 $buffer .= "'".$tmp['point']."',";
}
echo substr($buffer, 0, -1);
?>]
            },
            yAxis: [ 
{ // Primary yAxis
                labels: {
                    format: '{value} MB/s',
                    style: {
                        color: '#000000'
                    }
                },
                title: {
                    text: 'Debit',
                    style: {
                        color: '#000000'
                    }
                }
            }, { // Secondary yAxis
                title: {
                    text: 'Ping',
                    style: {
                        color: '#2cabe2'
                    }
                },
                labels: {
                    format: '{value} ms',
                    style: {
                        color: '#2cabe2'
                    }
                },
                opposite: true
            }
                ]
            ,
            tooltip: {
                shared: true
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [{
                name: 'Ping',
                yAxis: 1,
                tooltip: {
                    valueSuffix: ' ms'
                },
                color : '#2cabe2',
                data: [<?php
                $buffer= "";
                foreach ($result_ping as $tmp){
                 $buffer .= $tmp['value'].",";
                }
                echo substr($buffer, 0, -1);
                ?>]
            }, {
                name: 'Download',
                yAxis: 0,
                color: '#01a05f',
                tooltip: {
                    valueSuffix: ' MB/s'
                },
                data: [
                <?php
                $buffer= "";
                foreach ($result_download as $tmp){
                 $buffer .= $tmp['value'].",";
                }
                echo substr($buffer, 0, -1);
                ?>]
            }, {
                name: 'Upload',
                yAxis: 0,
                color: '#c0362c',
                tooltip: {
                    valueSuffix: ' MB/s'
                },
                data: [<?php
                $buffer= "";
                foreach ($result_upload as $tmp){
                 $buffer .= $tmp['value'].",";
                }
                echo substr($buffer, 0, -1);
                ?>]
            }]
        });
    });
</script>
<?php
}
?>
<header>
    <ul class="nav-bar">
        <li class="active"><a href="index.php" style="font-weight: bold;">Libellule</a></li> 
        <li <?php if (strpos($_SERVER['REQUEST_URI'], "day") != false) echo 'class="active"'; ?>><a href="index.php?i=day">Jour</a></li>    
        <li <?php if (strpos($_SERVER['REQUEST_URI'], "week") != false) echo 'class="active"'; ?>><a href="index.php?i=week">Semaine</a></li>
        <li <?php if (strpos($_SERVER['REQUEST_URI'], "month") != false) echo 'class="active"'; ?>><a href="index.php?i=month">Mois</a></li>
        <li <?php if (strpos($_SERVER['REQUEST_URI'], "all") != false) echo 'class="active"'; ?>><a href="index.php?i=all">Tout</a></li>
        <li <?php if (strpos($_SERVER['REQUEST_URI'], "int") != false) echo 'class="active"'; ?>><a href="index.php?i=int">Intervalle</a></li>
        
        <li class="has-flyout" style="float: right;">
           <a href="#">A propos</a>
            <a href="#" class="flyout-toggle"><span> </span></a>
            <ul class="flyout right">
              <li><a href="index.php">Libellule</a></li>
              <li><a href="#">GitHub</a></li>
              <li><a href="http://www.fotozik.fr">Blog Fotozik</a></li>
              <li><a href="http://www.fotozik.fr/formulaire-de-contact">Me contacter</a></li>
            </ul>
        </li>
    </ul>
</header>
<main>
<div id="container" class="row" style="width:100%">

<?php
if ($ask_interval){
	?>
<div class="three columns">
<form action="index.php" method="get">
<fieldset>
<legend>Choix de l'intervalle</legend>
<label>Début : </label><input type = "date" name="start"/>
<label>Fin : </label><input type = "date" name="end"/>
<input type="hidden" name="i" value="int"/>
<input type = "submit" class="button right"/>
</fieldset>
</form>
</div>

<?php
}
?>

</div>
</main>
<footer>
</footer>
</body>
</html>
