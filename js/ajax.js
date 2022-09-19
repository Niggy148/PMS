/* global taskRecords */

//session_start();
$(document).ready(function(){	
	var empRecords = $('#empList').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"process.php",
			type:"POST",
			data:{action:'listEmp'},
			dataType:"json"
		},
		"columnDefs":[
			{
				//"targets":[0, 6, 7],
				"orderable":false
			}
		],
		"pageLength": 5
	});	
        
        
        
        
	$('#addEmp').click(function(){
		$('#empModal').modal('show');
		$('#empForm')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add Employee");
		$('#action').val('addEmp');
		$('#save').val('Add');
	});		
	$("#empList").on('click', '.update', function(){
		var empId = $(this).attr("id");
		var action = 'getEmp';
		$.ajax({
			url:'process.php',
			method:"POST",
			data:{empId:empId, action:action},
			dataType:"json",
			success:function(data){
				$('#empModal').modal('show');
				$('#empId').val(data.id);
				$('#empName').val(data.name);
				$('#empAge').val(data.age);
				$('#empSkills').val(data.skills);				
				$('#address').val(data.address);
				$('#designation').val(data.designation);
                                $('#user_id').val(data.user_id);
                                $('.modal-title').html("<i class='fa fa-plus'></i> Edit Employee");
				$('#action').val('updateEmp');
				$('#save').val('Save');
			}
		});
	});
	$("#empModal").on('submit','#empForm', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"process.php",
			method:"POST",
			data:formData,
			success:function(data){	
                            alert(JSON.stringify(formData));
				$('#empForm')[0].reset();
				$('#empModal').modal('hide');				
				$('#save').attr('disabled', false);
				empRecords.ajax.reload();
			}
		});
	});		
	$("#empList").on('click', '.delete', function(){
		var empId = $(this).attr("id");		
		var action = "deleteEmp";
		if(confirm("Are you sure you want to delete this employee?")) {
			$.ajax({
				url:"process.php",
				method:"POST",
				data:{empId:empId, action:action},
				success:function(data) {					
					empRecords.ajax.reload();
				}
			});
		} else {
			return false;
		}
	});
       
  $("#empList").on('click', '.view', function(){
		var empId = $(this).attr("id");		
		var action = "viewEmps";
		
			$.ajax({
				url:"process.php",
				method:"POST",
                                dataType:"json",
				data:{empId:empId, action:action},
                                
				success:function(data) {
                                    $('#empId').val(data.id);
                                    //alert(data.id);
					taskRecords.ajax.reload();
                                        
                                         $(".three").show();
                                   
				}
			});
		
	});
        
        $("#empList").on('click', '.publish', function(){
		var empId = $(this).attr("id");		
		var action = "publishEmps";
		//alert("into it");
			$.ajax({
                           	url:"process2.php",
				method:"POST",
                                dataType:"json",
				data:{empId:empId, action:action},
                                 success:function(data) {
                                    //$('#noId').val(data.id);
                                    
					//taskRecords.ajax.reload();
                                        
                                         //$(".three").show();
                                   alert(data);
                                   
			window.location.assign(window.location.href+"../../../CHEW/test.php");
				
                                   
				}
			});
		
	});
        
     //$(document).ready(function(){	
$("#listTask").on('click', '.view', function(){
		var taskId = $(this).attr("id");		
		var action = "viewReqs";
		
			$.ajax({
				url:"process.php",
				method:"POST",
                                dataType:"json",
				data:{taskId:taskId, action:action},
                                
				success:function(data) {
                                    $(".four").show();
                                    $('#taskId').val(data.id);
                                    alert(data.id);
					reqRecords.ajax.reload();
				}
			});
		
	});	
        
  $("#listTask").on('click', '.update', function(){
		var taskId = $(this).attr("id");
		var action = 'getTask';
		$.ajax({
			url:'process.php',
			method:"POST",
			data:{taskId:taskId, action:action},
			dataType:"json",
			success:function(data){
				$('#taskModal').modal('show');
				$('#taskId').val(data.id);
				$('#taskName').val(data.name);
				$('#taskDescription').val(data.description);
                                $('#project_id').val(data.project_id);
                                $('.modal-title').html("<i class='fa fa-plus'></i> Edit Task");
				$('#action').val('updateTask');
				$('#save').val('Save');
			}
		});
	});
        
$("#taskModal").on('submit','#taskForm', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
		var request=$.ajax({
			url:"process.php",
			method:"POST",
			data:formData,
                        //processData:false,
                        //encode: true,
                        //contentType:"application/json;charset=utf-8",
                       // contentType:'application/x-www-form-urlencoded;charset=utf-8',
			success:function(data){	
                            	$('#taskForm')[0].reset();
				$('#taskModal').modal('hide');				
				$('#save').attr('disabled', false);
                                alert(JSON.stringify(formData));
			
				taskRecords.ajax.reload();
			}
		});
                request.done(function(msg){
                    alert("success2 "+msg);
                });
                request.fail(function(jqXHR,textStatus,errorThrown){
                    alert(jqXHR.responseStart+" "+textStatus+" "+errorThrown);
                });
	});	
       
    
        
    var taskRecords = $('#listTask').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,
		"order":[],
                searching:false,
		"ajax":{
			url:"process.php",
			type:"POST",
			data:{action:'listTasks'},
			dataType:"json"
                      //  dataSrc:"data"
                        
		},
		"columnDefs":[
			{
				//"targets":[0, 3, 4],
				"orderable":false
			}
		],
		"pageLength": 8
	});	
        
 $('#addReq').click(function(){
           	$('#reqModal').modal('show');
		$('#reqForm')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add Req");
		$('.reqact').val('addReqs');
		$('.req').val('Add');
	
                //reqRecords.ajax.reload();
                //alert("<?php echo $_SESSION['task_id'];?>");
	});	      
        
        
        
        var reqRecords = $('#listReq').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,
		"order":[],
                fixedColumns: true,
                
		"ajax":{
			url:"process.php",
			type:"POST",
			data:{action:'listReqs'},
			dataType:"json"
                      //  dataSrc:"data"
                        
		},
		"columnDefs":[
			{
				//"targets":[0, 3, 4],
				"orderable":false
			}
		],
		"pageLength": 4
	});
        
$("#reqModal").on('submit','#reqForm', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
		var request=$.ajax({
			url:"process.php",
			method:"POST",
			data:formData,
                        //processData:false,
                        //encode: true,
                        //contentType:"application/json;charset=utf-8",
                       // contentType:'application/x-www-form-urlencoded;charset=utf-8',
			success:function(data){	
                            	$('#reqForm')[0].reset();
				$('#reqModal').modal('hide');				
				$('#save').attr('disabled', false);
                                //alert(JSON.stringify(formData));
			
				reqRecords.ajax.reload();
			}
		});
                
	});	
       
    $("#listReq").on('click', '.update', function(){
		var reqId = $(this).attr("id");
		var action = 'getReq';
		$.ajax({
			url:'process.php',
			method:"POST",
			data:{reqId:reqId, action:action},
			dataType:"json",
			success:function(data){
				$('#reqModal').modal('show');
				$('#reqId').val(data.id);
				$('#req').val(data.req);
				$('#spec').val(data.spec);
                                $('#task_id').val(data.task_id);
                                $('.modal-title').html("<i class='fa fa-plus'></i> Edit Req");
				$('.reqact').val('updateReq');
				$('#save').val('Save');
			}
		});
	});
$("#listReq").on('click', '.delete', function(){
		var reqId = $(this).attr("id");		
		var action = "deleteReq";
		if(confirm("Are you sure you want to delete this requirement?")) {
			$.ajax({
				url:"process.php",
				method:"POST",
				data:{reqId:reqId, action:action},
				success:function(data) {					
					reqRecords.ajax.reload();
				}
			});
		} else {
			return false;
		}
	});
});

  