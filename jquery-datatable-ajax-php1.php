<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>JQuery Datatable Example</title>

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
		    $('#jquery-datatable-ajax-php').DataTable({
		      	//'processing': true,
		      	//'serverSide': true,
		      	//'serverMethod': 'post',
		      	'ajax': {
		          	url:'datatable.php'
                                
		      	},
                        type:'json',
                                method:'post',
                                success: function(data){
        alert(data);
      },
      error: function (xhr,status,error) {
                       alert(xhr.responseText);
                   },
		      	'columns': [
                                { aaData: 'id' },         	
                                { aaData: 'email' },
		         	{ aaData: 'first_name' },
		         	{ aaData: 'last_name' },
		         	{ aaData: 'address' },
                                { aaData: 'phone' },
                                { aaData: 'user_id' }
		      	]
		   });

		} );
	</script>
</head>
<body>

	<div class="container mt-5">
		<h2 style="margin-bottom: 30px;">jQuery Datatable Ajax PHP Example</h2>
		<table id="jquery-datatable-ajax-php" class="display" style="width:100%">
	        <thead>
	            <tr>
	                <th>Id</th>
                        <th>Email</th>
	                <th>Firstname</th>
	                <th>Lastname</th>
	                <th>Address</th>
                        <th>Phone</th>
                        <th>User</th>
	            </tr>
	        </thead>
	    </table>
	</div>
    

</body>
</html>