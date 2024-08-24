<?php
error_reporting(E_ALL);
ini_set('display_errors','On');
//$connect = mysqli_connect("localhost", "root", "bollox", "coderszine_demos");
   require_once 'config1.php';
?>
<html>
<head>
  <script src="https://www.gstatic.com/charts/loader.js"></script>

<script>
  google.charts.load("current", {packages:["timeline"]});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {
    var container = document.getElementById('example5.4');
    var chart = new google.visualization.Timeline(container);
    var dataTable = new google.visualization.DataTable();
    dataTable.addColumn({ type: 'string', id: 'Room' });
    dataTable.addColumn({ type: 'string', id: 'Name' });
    dataTable.addColumn({ type: 'date', id: 'Start' });
    dataTable.addColumn({ type: 'date', id: 'End' });
    dataTable.addRows([
      <?php 
           
     
$query10 = "select t1.*, t2.username from crud_emp t1 inner join users2 t2 on t1.user_id=t2.id WHERE t1.start_date > DATE_ADD(CURDATE(), INTERVAL - 2 MONTH) ";
//$query10 = "select p.id,p.name,p.start_date,p.end_date,u.name from crud_emp p,users2 u where p.user_id='ba750f12-d1fb-11ec-b58b-e8039a343812'";
  
$result10=mysqli_query($link,$query10);
   $number = mysqli_num_rows($result10);

  $i = 1;
  while($row = mysqli_fetch_array($result10))
   {
     
      $start=new DateTime($row['start_date']);
      $end=new DateTime($row['end_date']);
      $interval=$start->diff($end);
      $percent=100;
      //$owner="u.name";
      $deps=null;
       
      if ($i < $number){
       echo "['".$row["username"]."','".$row["name"]."',new Date('".$row['start_date']."'),new Date('".$row['end_date']."')],";
      }
       else { 
       echo "['".$row["username"]."','".$row["name"]."',new Date('".$row['start_date']."'),new Date('".$row['end_date']."')]";
      }
 $i++;
    
   }
   
  ?>   ]);

    var options = {
      timeline: { colorByRowLabel: true, title:"hello" },
      alternatingRowStyle: true
    };

    chart.draw(dataTable, options);
  }
</script>


</head>
<body><center>TIMELINE chart<br>
<div id="example5.4" style="height: 450px;width:80%;margin-left:10px;background-color: #EBEBEB;"></div>
</center>      
</body>
</html>

