<?php
include_once("verifica.php");
?>
<?php include_once("conecta.php"); ?>

<html>
  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(

		  <?php
  
$get_custo  = 'SELECT data,year(data) as year1,month(data) as month1,grupo,format(avg(preco/kilos),2) as preco2 FROM `mercado` INNER JOIN `mercado_aux` ON mercado_aux.item=mercado.item WHERE  mercado="zsul" and year(data) >="2014" and trab=1 group by data,grupo order by  data ASC';
$result_custo=mysqli_query($conecta,$get_custo) or die ('Erro ao consultar');
unset($data);
unset($grupao);
unset($datao);
$grupao=array();
$datao=array();
$data[0][0]='Grupos';
$r=1;
$f=1;
while($row=mysqli_fetch_array($result_custo))
{
if(array_search(utf8_encode($row[grupo]),$grupao)>0){echo "";}else{
$grupao[$r]=utf8_encode($row[grupo]);
$r++;}

if(array_search($row[data],$datao)>0){echo "";}else{
$datao[$f]=$row[data];
$f++;}

}

for($t=1;$t<$r;$t++){
$data[0][$t]=$grupao[$t];

for($m=1;$m<=$f;$m++){
$data[$m][0]=$datao[$m];
$data[$m][$t]=NULL;
}}

$result_custo2=mysqli_query($conecta,$get_custo) or die ('Erro ao consultar');

while($row2=mysqli_fetch_array($result_custo2))
{
$y=array_search(utf8_encode($row2[grupo]),$grupao);
$z=array_search($row2[data],$datao);
$data[$z][0]=$row2[data];
$data[$z][$y]=$row2[preco2]*1;
}




 

echo json_encode($data);

 echo ");";
?> 

 
        var options = {
          title: 'Precos do Zsul', 
		  interpolateNulls: true
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
  
  
<?php include("cabeca.php"); ?>


    <div id="chart_div" style="width: 1100px; height: 500px;"></div>
  </body>
</html>
