<?php 

session_start();

   // Database Connection
   require_once 'config1.php';
   /*
   $draw-filter_input(INPUT_POST, 'draw');
   $row=filter_input(INPUT_POST, 'start');
   $rowperpage=filter_input(INPUT_POST, 'length');
   $columnIndex=filter_input(INPUT_POST, ['order'][0]['column']);
   $columnName=filter_input(INPUT_POST, 'columns');
   $columnSortOrder=filter_input(INPUT_POST, 'order');
   $searchValue=filter_input(INPUT_POST, 'search');
    
    */
if (filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING)) {
   // Reading value
    
   $draw = trim($_POST['draw']);
   $row = $_POST['start'];
   $rowperpage = $_POST['length']; // Rows display per page
   $columnIndex = $_POST['order'][0]['column']; // Column index
   $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
   $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
   $searchValue = $_POST['search']['value']; // Search value
     
     
}
   $searchArray = array();

   // Search
   $searchQuery = " ";
   if($searchValue != ''){
      $searchQuery = " AND (id LIKE :id OR email LIKE :email OR 
           first_name LIKE :first_name OR
           last_name LIKE :last_name OR 
           address LIKE :address  OR
           phone LIKE :phone OR 
           user_id LIKE :user_id)";
      
      $searchArray = array( 
          'id'=>"%$searchValue%",
           'email'=>"%$searchValue%",
           'first_name'=>"%$searchValue%",
           'last_name'=>"%$searchValue%",
           'address'=>"%$searchValue%",
          'phone'=>"%$searchValue%",
          'user_id'=>"%$searchValue%"
      );
        
       
   }

   // Total number of records without filtering
   $sql="SELECT COUNT(*) AS allcount FROM contacts WHERE user_id='".$_SESSION['user_id']."'";
   $stmt=mysqli_prepare($link,$sql);
   mysqli_stmt_execute($stmt);
   $records1 = mysqli_stmt_fetch($stmt);
   $totalRecords = $records1['allcount'];

   // Total number of records with filtering
   $sql = "SELECT COUNT(*) AS allcount FROM contacts WHERE user_id='".$_SESSION['user_id']."'".$searchQuery;
    $stmt=mysqli_prepare($link,$sql);
   mysqli_stmt_execute($stmt);
   // mysqli_stmt_execute($searchArray);
   $records = mysqli_stmt_fetch($stmt);
   $totalRecordwithFilter = $records['allcount'];
   //$sql = "SELECT * FROM contacts WHERE 1 AND user_id='".$_SESSION['user_id']."' ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset";
   $sql="select id, email, first_name, last_name, address, phone, user_id from contacts LIMIT 0,30";
   
   
   $stmt = mysqli_prepare($link, $sql);
   //echo var_dump($searchArray);
   //$stmt=$link->prepare("select UUID()");
   // Bind values
   foreach ($searchArray as $key=>$search) {
      mysqli_stmt_bind_param($stmt,':'.$key, $search);
   }
// mysqli_stmt_bind_param($stmt, ":limit", (int)$row);
 //mysqli_stmt_bind_param($stmt, ":offset", (int)$rowperpage);
   //$stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
   //$stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
mysqli_stmt_execute($stmt);   
//$stmt->execute();
   $_SESSION['sesh']= $stmt;
  // echo $_SESSION['sesh'];
$empRecords=mysqli_stmt_fetch($stmt);   
//$empRecords = $stmt->fetchAll();
   $data = array();

   foreach ($empRecords as $row) {
      $data[] = array(
          "id"=>$row['id'],
          "email"=>$row['email'],
         "first_name"=>$row['first_name'],
         "last_name"=>$row['last_name'],
         "address"=>$row['address'],
         "phone"=>$row['phone'],
           "user_id"=>$row['user_id']
      );
   }
   
   // Response
   $response = array(
      "draw" => intval($draw),
      "iTotalRecords" => $totalRecords,
      "iTotalDisplayRecords" => $totalRecordwithFilter,
      "aaData" => $data
   );
 mysql_stmt_close($stmt);
 // Close connection
    mysqli_close($link);
//console.log($stmt->fullQuery()); 
//echo var_dump($data);

echo json_encode($response);

