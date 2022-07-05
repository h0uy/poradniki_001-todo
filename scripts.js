$(document).ready(function() {

	//Przełącznik priorytetu w formularzu
	$("#formTaskPriority").change(function(){
		if(this.checked == true){
			$("#formTaskPriority").val("1");
		}else{
			$("#formTaskPriority").val("0");       
		}
	});
	

	//Działanie przycisku dodania wpisu w formularzu
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
									
					}else if(dataResult.statusCode==201){
						alert("Wystąpił błąd.");
					}
				}
			});
		}else{
			console.log("Wypełnij wszystkie pola!");
			$("#formSubmit").removeAttr("disabled");
		}
	});


	//Działanie przycisku zakończenia zadania
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
				}else if(dataResult.statusCode==201){
					alert("Wystąpił błąd.");
				}
			}							
		});

	});

	//Działanie przycisku niezakończenia zadania
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
				}else if(dataResult.statusCode==201){
					alert("Wystąpił błąd.");
				}
			}							
		});

	});


	//Działanie przycisku priorytezacji zadania
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
				}else if(dataResult.statusCode==201){
					alert("Wystąpił błąd.");
				}
			}							
		});

	});

	//Działanie przycisku depriorytezacji zadania
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
				}else if(dataResult.statusCode==201){
					alert("Wystąpił błąd.");
				}
			}							
		});

	});


	//Działanie przycisku usunięcia pojedyńczego wpisu
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
				}else if(dataResult.statusCode==201){
					alert("Wystąpił błąd.");
				}
			}							
		});

	});

	//Działanie przycisku usunięcia wszystkich wpisów
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
					}else if(dataResult.statusCode==201){
						alert("Wystąpił błąd.");
				}
			}							
		});

	});

});