<?php 
require('db_konektatu.php');
$query = "SELECT * FROM korridorea ORDER BY id DESC limit 60";
$query1 = "SELECT * FROM berogailua ORDER BY id DESC limit 60";
$query2 = "SELECT * FROM ikasgela ORDER BY id DESC limit 60";
$result = mysqli_query($conn, $query);
$result1 = mysqli_query($conn, $query1);
$result2 = mysqli_query($conn, $query2);
$chart_data = '';
$chart_data1 = '';
$chart_data2 = '';

while($row = mysqli_fetch_array($result))
{
 $chart_data .= "{ ldrBalioa:".$row["ldrBalioa"].", tentsioa:".$row["tentsioa"].", data:'".$row["data"]."'}, ";
}
$chart_data = substr($chart_data, 0, -2);

while($row = mysqli_fetch_array($result1))
{
 $chart_data1 .= "{ tenperatura:".$row["tenperatura"].", hezetasuna:".$row["hezetasuna"].", balbula:".$row["balbula"].", data:'".$row["data"]."'}, ";
}
$chart_data1 = substr($chart_data1, 0, -2);

while($row = mysqli_fetch_array($result2))
{
 $chart_data2 .= "{ argia:".$row["argia"].", data:'".$row["data"]."'}, ";
}
$chart_data2 = substr($chart_data2, 0, -2);
?>


<!DOCTYPE html>
<html>
 <head>
  <title>GRAFIKOAK</title>
  
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

  <script src="https://code.jquery.com/jquery-3.4.0.js"></script>
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

  
 </head>
 <body>
  <br /><br />
  <div class="container" style="width:900px;">
   <h2 class="text-center">DATU TAULEN GRAFIKOAK</h2> 
   <h6 class="text-center">(azken 60 datuak erakusten dira)</h6> 
   <br /><br />
   <h3 class="text-center">KORRIDOREKO ARGIAK JASOTZEN ARI DEN TENTSIOAREN GRAFIKA</h3> 
   <div id="chart" style="height: 250px;"></div>
   <br /><br />
   <h3 class="text-center">SOLAIRUAN DAGOEN TENPERATURAREN GRAFIKA</h3> 
   <div id="chart1" style="height: 250px;"></div>
   <br /><br />
   <h3 class="text-center">SOLAIRUAN DAGOEN HEZETASUNAREN GRAFIKA</h3> 
   <div id="chart2" style="height: 250px;"></div>
   <br /><br />
   <h3 class="text-center">BALBULAREN EGOERAREN GRAFIKA</h3> 
   <div id="chart3" style="height: 250px;"></div>
   <br /><br />
   <h3 class="text-center">IKASGELAKO ARGIEN MOMENTUKO EGOERA</h3> 
   <div id="chart4" style="height: 250px;"></div>
   <br/><br />
  </div>

  <div class = "container">
  <button class = "btn btn-warning btn-sm"><a href = "taulak.php" style = "text-decoration: none; color: #333;">Datuetara bueltatu</a></button>
</div>

 </body>
</html>

<script>
Morris.Line({
 element : 'chart',
 data:[<?php echo $chart_data; ?>],
 xkey:'data',
 ykeys:['tentsioa'],
 labels:['Tentsioa'],
 hideHover: true,
 stacked:true,
 pointSize:0
});

Morris.Line({
 element : 'chart1',
 data:[<?php echo $chart_data1; ?>],
 xkey:'data',
 ykeys:['tenperatura'],
 labels:['Tenperatura'],
 hideHover: true,
 ymax: 'auto 50',
 ymin: 'auto 10',
 stacked:true,
 pointSize:0
});

Morris.Line({
 element : 'chart2',
 data:[<?php echo $chart_data1; ?>],
 xkey:'data',
 ykeys:['hezetasuna'],
 labels:['Hezetasuna'],
 hideHover: true,
 ymax: 'auto',
 ymin: 'auto',
 stacked:true,
 pointSize:0
});

Morris.Area({
 element : 'chart3',
 data:[<?php echo $chart_data1; ?>],
 xkey:'data',
 ykeys:['balbula'],
 labels:['Balbularen egoera'],
 hideHover: true,
 stacked:true,
 pointSize:0
});

Morris.Area({
 element : 'chart4',
 data:[<?php echo $chart_data2; ?>],
 xkey:'data',
 ykeys:['argia'],
 labels:['Egoera'],
 hideHover: true,
 stacked:true,
 pointSize:0
});

</script>