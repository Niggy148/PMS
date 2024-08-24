<?php 
session_start();

//include('inc/header.php');
?>
<title>coderszine.com : Live Datatables CRUD with Ajax, PHP & MySQL</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>		
<link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
<script src="js/ajax.js"></script>
<div style = "text-align:right;"><a href="logout.php">Logout</a></div>
<script src="js/ajax2.js"></script>
<div class="container contact">	
    <a href="https://docs.google.com/document/d/1qw09q-LCASq31GWgsL2_JrECjph1Gux7WetW3vAe32g/edit?usp=drivesdk">Business Plan</a> 
	<h2>Projects</h2>	
	<div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">   		
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-10">
					<h3 class="panel-title"></h3>
				</div>
				<div class="col-md-2" align="right">
					<button type="button" name="add" id="addEmp" class="btn btn-success">Add Project</button>
				</div>
			</div>
		</div>
		<table id="empList" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Emp ID</th>
					<th>Name</th>
					<th>Address</th>
					<th>Designation</th>					
					<th></th>
					<th></th>
                                        <th>Task</th>
                                        <th>Cloud</th>
				</tr>
			</thead>
		</table>
	</div>
	<div id="empModal" class="modal fade">
    	<div class="modal-dialog">
    		<form method="post" id="empForm">
    			<div class="modal-content">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Edit User</h4>
    				</div>
    				<div class="modal-body">
						<div class="form-group">
							<label for="name" class="control-label">Name</label>
							<input type="text" class="form-control" id="empName" name="empName" placeholder="Name" required>			
						</div>
						<div class="form-group">
							<label for="address" class="control-label">Address</label>							
							<textarea class="form-control" rows="5" id="address" name="address"></textarea>							
						</div>
						<div class="form-group">
							<label for="lastname" class="control-label">Designation</label>							
							<input type="text" class="form-control" id="designation" name="designation" placeholder="Designation">			
						</div>
                                    <div class="form-group">
							<label for="lastname" class="control-label">Start</label>							
							<input type="date" class="form-control" id="start_date" name="start_date">			
						</div>
                                    <div class="form-group">
							<label for="lastname" class="control-label">End</label>							
							<input type="date" class="form-control" id="end_date" name="end_date">			
						</div>
    				</div>
    				<div class="modal-footer">
    					<input type="hidden" name="empId" id="empId" />
    					<input type="hidden" name="action" id="action" value="empList" />
    					<input type="submit" name="save" id="save" class="btn btn-info" value="Save" />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
            <?php include('inc/footer.php');?>
    </div>
	



        <div class="container contact three">	
            
            <h2>Tasks</h2>	
		
		<div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">   	
		<table id="listTask" style="width:100%" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Task ID</th>
					<th>Name</th>
					<th>Description</th>					
					
					<th></th>
                                        <th>Req</th>
				</tr>
			</thead>
		</table>
                </div>
	<div id="taskModal" class="modal fade">
    	<div class="modal-dialog">
    		<form method="post" id="taskForm">
    			<div class="modal-content">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Edit User</h4>
    				</div>
    				<div class="modal-body">
						<div class="form-group">
							<label for="name" class="control-label">Name</label>
							<input type="text" class="form-control" id="taskName" name="taskName" placeholder="Name" required>			
						</div>
						
						<div class="form-group">
							<label for="lastname" class="control-label">Description</label>							
							<input type="text" class="form-control" id="taskDescription" name="taskDescription" placeholder="Description">			
						</div>						
    				</div>
    				<div class="modal-footer">
    					<input type="hidden" name="taskId" id="taskId" value=""/>
    					<input type="hidden" name="action" id="action" value="updateTask" />
    					<input type="submit" name="save" id="save" class="btn btn-info" value="Save" />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
            <?php include('inc/footer.php');?>

        </div>
	<div class="four">
        <div class="container contact">	
            
            <h2>Requirements</h2>	
	<div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">   		
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-10">
					<h3 class="panel-title"></h3>
				</div>
				<div class="col-md-2" align="right">
					<button type="button" name="add" id="addReq" class="btn btn-success">Add Req</button>
				</div>
			</div>
		</div>
		<table id="listReq" style="width:100%" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Req ID</th>
					<th>Requirement</th>
					<th>Specification</th>					
					<th></th>
					<th></th>
                                      
				</tr>
			</thead>
		</table>
	</div>
	<div id="reqModal" class="modal fade">
    	<div class="modal-dialog">
    		<form method="post" id="reqForm">
    			<div class="modal-content">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus req"></i> Edit Requirement</h4>
    				</div>
    				<div class="modal-body">
						
						<div class="form-group">
							<label for="address" class="control-label">Requirement</label>							
							<textarea class="form-control" rows="5" id="req" name="req"></textarea>							
						</div>
						<div class="form-group">
							<label for="address" class="control-label">Specification</label>							
							<textarea class="form-control" rows="5" id="spec" name="spec"></textarea>							
						</div>					
    				</div>
    				<div class="modal-footer">
    					<input type="hidden" name="reqId" id="reqId" />
    					<input type="hidden" name="action" id="action" class="reqact" value="" />
    					<input type="submit" name="save" id="save" class="btn btn-info req" value="Save" />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
        </div></div></div>
            <?php include('inc/footer.php');?>
        </div>

 

