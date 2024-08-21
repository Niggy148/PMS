<?php
error_reporting(E_ALL);
ini_set('display_errors','On');
//$connect = mysqli_connect("localhost", "root", "bollox", "coderszine_demos");
   require_once 'config1.php';
?>
<html>
<head>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {'packages':['gantt']});
    google.charts.setOnLoadCallback(drawChart);

    function daysToMilliseconds(days) {
      return days * 24 * 60 * 60 * 1000;
  }

    function drawChart() {

      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Task ID');
      data.addColumn('string', 'Task Name');
      data.addColumn('date', 'Start Date');
      data.addColumn('date', 'End Date');
      data.addColumn('number', 'Duration');
      data.addColumn('number', 'Percent Complete');
      data.addColumn('string', 'Dependencies');

      data.addRows([
          <?php 
           
     
$query10 = "select t1.*, t2.username from crud_emp t1 inner join users2 t2 on t1.user_id=t2.id";
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
       echo "['".$row["id"]."','".$row["name"]."',new Date('".$row['start_date']."'),new Date('".$row['end_date']."'),daysToMilliseconds(".$interval->d."),".$percent.",'".$deps."'],";
      }
       else { 
       echo "['".$row["id"]."','".$row["name"]."',new Date('".$row['start_date']."'),new Date('".$row['end_date']."'),daysToMilliseconds(".$interval->d."),".$percent.",'".$deps."']";
     }
 $i++;
    
   }
   
  ?>   
          
          ]);
        
      
  
      var options = {array (title:'Project Management - Overview',
        height: 400)
      };

      var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

      chart.draw(data, options);
    }
  </script>
</head>
<body>
<center><div id="chart_div" style="width:80%;margin-left:10px; text-align: center;"></div></center>
       
</body>
</html>

