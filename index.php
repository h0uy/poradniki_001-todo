<?php

include('functions.php');

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Aplikacja TODO</title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="../_szablony/global.css">

	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</head>
<body>

	<div class="col-lg-8 mx-auto p-3 py-md-5">

		<header class="d-flex align-items-center pb-3 mb-2">
		    <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
		      	<svg xmlns="http://www.w3.org/2000/svg" width="40" height="32" fill="currentColor" class="bi bi-window-sidebar me-2" viewBox="0 0 16 16">
				  <path d="M2.5 4a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1zm2-.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm1 .5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
				  <path d="M2 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v2H1V3a1 1 0 0 1 1-1h12zM1 13V6h4v8H2a1 1 0 0 1-1-1zm5 1V6h9v7a1 1 0 0 1-1 1H6z"/>
				</svg>
		      	<span class="fs-4">Aplikacja TODO</span>
		    </a>
		</header>

		<main class="app-container p-5">

			<div class="container" id="container">
				<div id="todo_header" class="row">
					<div class="col-md-12">
						<h1 class="text-center fw-bold">LISTA ZADAŃ</h1>
					</div>
				</div>

				<div id="todo_form" class="row mt-4 align-items-center justify-content center">
					<form id="insert_form" name="insert_form" method="POST">
						<div class="col-md-12">
							<div class="alert alert-success alert-dismissible" id="success" style="display:none;">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
							</div>
							<div class="input-group">
								<input 
								type="text" 
								name="formTaskValue" 
								id="formTaskValue"
								class="form-control" 
								placeholder="Wpisz treść nowego zadania..."
								autocomplete="off">

								<button 
								type="button" 
								name="formSubmit" 
								id="formSubmit"
								class="fw-bold btn btn-primary" 
								>+</button>
							</div>
						</div>
						<div class="col-md-12 mt-2  d-flex justify-content-between align-items-center">
							<div class="form-check form-switch">
							  <input 
							  class="form-check-input" 
							  type="checkbox" 
							  role="switch" 
							  id="formTaskPriority"
							  value="0">

							  <label class="form-check-label" for="flexSwitchCheckDefault"><i class="bi bi-star"></i> Zadanie priorytetowe</label>
							</div>
						</div>
					</form>
				</div>

				<div id="todo">
					<div id="todo_list" class="row mt-3">
					
						<div class="col-md-12">
							<ul class="list-group list-group-numbered">
								
							  	<?php getTodoTasks($db); ?>

							</ul>
						</div>

						<div class="col-md-12 mt-2 d-flex justify-content-between align-items-center">
							<p>Łączna liczba wpisów: <?= $taskCount; ?></p>
							<?php if($taskCount == "0"){}else{ ?>
							<p><button class="deleteAllBtn btn btn-danger btn-sm" id="deleteAllBtn">Usuń wszystkie zadania</button></p>
							<?php } ?>
						</div>

					</div>
				</div>

			</div>

			<script>
			$(document).ready(function() {

				$("#formTaskPriority").change(function(){
				    if(this.checked == true)
				    {
				        $("#formTaskPriority").val("1");
				    }
				    else
				    {
				        $("#formTaskPriority").val("0");       
				    }
				});

				$('#formSubmit').on('click', function() {
					$("#formSubmit").attr("disabled", "disabled");
					var formTaskPriority = $('#formTaskPriority').val();
					var formTaskValue = $('#formTaskValue').val();
					if(formTaskValue!=""){
						$.ajax({
							url: "functions.php",
							type: "POST",
							data: {
								action: "insert",
								formTaskPriority: formTaskPriority,
								formTaskValue: formTaskValue,			
							},
							cache: false,
							success: function(dataResult){
								var dataResult = JSON.parse(dataResult);
								if(dataResult.statusCode==200){
									$("#formSubmit").removeAttr("disabled");
									$('#formTaskValue').val('');
									$('#formTaskPriority').prop('checked', false).change();
									$("#formTaskPriority").val("0");

									$('#todo_list').remove();
									$("#todo").load(" #todo_list");
									
								}
								else if(dataResult.statusCode==201){
									alert("Wystąpił błąd.");
								}
							}
						});
						}
						else{
							console.log("Wypełnij wszystkie pola!");
							$("#formSubmit").removeAttr("disabled");
						}
				});

				$(document).on('click', '.finishBtn', function(e) {
						e.preventDefault();
						var taskID = $(this).attr('data-id');
						
						$.ajax({
							url: "functions.php",
							type: "POST",
							data: {
								action: "finish",
								taskID: taskID		
							},
							cache: false,
							success: function(dataResult){
								var dataResult = JSON.parse(dataResult);
								if(dataResult.statusCode==200){
									$('#todo_list').remove();
									$("#todo").load(" #todo_list");
								}
								else if(dataResult.statusCode==201){
									alert("Wystąpił błąd.");
								}
							}							
						});

				});

				$(document).on('click', '.unfinishBtn', function(e) {
						e.preventDefault();
						var taskID = $(this).attr('data-id');
						
						$.ajax({
							url: "functions.php",
							type: "POST",
							data: {
								action: "unfinish",
								taskID: taskID		
							},
							cache: false,
							success: function(dataResult){
								var dataResult = JSON.parse(dataResult);
								if(dataResult.statusCode==200){
									$('#todo_list').remove();
									$("#todo").load(" #todo_list");
								}
								else if(dataResult.statusCode==201){
									alert("Wystąpił błąd.");
								}
							}							
						});

				});

				$(document).on('click', '.deleteBtn', function(e) {
						e.preventDefault();
						var taskID = $(this).attr('data-id');
						
						$.ajax({
							url: "functions.php",
							type: "POST",
							data: {
								action: "delete",
								taskID: taskID		
							},
							cache: false,
							success: function(dataResult){
								var dataResult = JSON.parse(dataResult);
								if(dataResult.statusCode==200){
									$('#todo_list').remove();
									$("#todo").load(" #todo_list");
								}
								else if(dataResult.statusCode==201){
									alert("Wystąpił błąd.");
								}
							}							
						});

				});

				$(document).on('click', '.deleteAllBtn', function(e) {
						e.preventDefault();
						
						$.ajax({
							url: "functions.php",
							type: "POST",
							data: {
								action: "delete_all"	
							},
							cache: false,
							success: function(dataResult){
								var dataResult = JSON.parse(dataResult);
								if(dataResult.statusCode==200){
									$('#todo_list').remove();
									$("#todo").load(" #todo_list");
								}
								else if(dataResult.statusCode==201){
									alert("Wystąpił błąd.");
								}
							}							
						});

				});

				$(document).on('click', '.priorityBtn', function(e) {
						e.preventDefault();
						var taskID = $(this).attr('data-id');
						
						$.ajax({
							url: "functions.php",
							type: "POST",
							data: {
								action: "priority",
								taskID: taskID		
							},
							cache: false,
							success: function(dataResult){
								var dataResult = JSON.parse(dataResult);
								if(dataResult.statusCode==200){
									$('#todo_list').remove();
									$("#todo").load(" #todo_list");
								}
								else if(dataResult.statusCode==201){
									alert("Wystąpił błąd.");
								}
							}							
						});

				});

				$(document).on('click', '.unpriorityBtn', function(e) {
						e.preventDefault();
						var taskID = $(this).attr('data-id');
						
						$.ajax({
							url: "functions.php",
							type: "POST",
							data: {
								action: "unpriority",
								taskID: taskID		
							},
							cache: false,
							success: function(dataResult){
								var dataResult = JSON.parse(dataResult);
								if(dataResult.statusCode==200){
									$('#todo_list').remove();
									$("#todo").load(" #todo_list");
								}
								else if(dataResult.statusCode==201){
									alert("Wystąpił błąd.");
								}
							}							
						});

				});
			});
			</script>

		</main>

		<footer class="pt-2 my-3 text-muted">

	    	Created by <a href="https://www.youtube.com/channel/UCKRcgrckREjUCPi-otgtmig" class="text-decoration-none">h0uy</a> &middot; &copy; 2022	
		</footer>

	</div>

</body>
</html>