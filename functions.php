<?php

require('db.php');

//Pobierz wszystkie zadania

function getTodoTasks($db){

	$query = "
	SELECT taskID, taskFinished, taskPriority, taskValue, taskDatetime 
	FROM tasks
	ORDER BY taskPriority 
	DESC
	";
	$result = mysqli_query($db, $query);

	if (mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_assoc($result)){

			$taskID = $row['taskID'];
			$taskFinished = $row['taskFinished'];
			$taskPriority = $row['taskPriority'];
			$taskValue = $row['taskValue'];
			$taskDatetime = $row['taskDatetime'];

			global $taskCount;
			$taskCount = mysqli_num_rows($result);

			if($taskFinished == "1"){
				$taskFinishedStyle = ' style="text-decoration: line-through;"';

				$finishBtn = '
				<button class="unfinishBtn p-0 btn btn-link text-dark" id="unfinishBtn" data-id="'.$taskID.'">
					<i class="bi bi-x-lg"></i>
				</button>
				';

			}else{
				$taskFinishedStyle = "";

				$finishBtn = '
				<button class="finishBtn p-0 btn btn-link text-dark" id="finishBtn" data-id="'.$taskID.'">
					<i class="bi bi-check-lg"></i>
				</button>
				';
			}

			if($taskPriority == "1"){
				$taskPriorityClass = " list-group-item-warning";
				
				$priorityBtn = '
				<button class="unpriorityBtn p-0 mx-1 btn btn-link text-dark" id="unpriorityBtn"  data-id="'.$taskID.'">
					<i class="bi bi-star-fill"></i>
				</button>
				';
			}else{
				$taskPriorityClass = "";
				
				$priorityBtn = '
				<button class="priorityBtn p-0 mx-1 btn btn-link text-dark" id="priorityBtn"  data-id="'.$taskID.'">
					<i class="bi bi-star"></i>
				</button>
				';
			}

	    
			echo '
			<li class="p-3 list-group-item'.$taskPriorityClass.'" id="'.$taskID.'" '.$taskFinishedStyle.'>
				'.$taskValue.'
				<div class="float-end">
					'.$finishBtn.$priorityBtn.'
					<button class="deleteBtn p-0 mx-1 btn btn-link text-dark" id="deleteBtn" data-id="'.$taskID.'">
						<i class="bi bi-trash3"></i>
					</button>
				</div>
			</li>
			';

	  	}
	}else{
		global $taskCount;
	  	$taskCount = "0";
	  	echo '
	  	<div class="alert alert-primary alert-dismissible" id="primary">
			Lista jest pusta. Dodaj pierwsze zadanie przy pomocy formularza powyżej.
		</div>
	  	';
	}

}

//Akcje przycisków

if(isset($_POST["action"]) && $_POST["action"] == "insert"){
	insertTodoTask($db);
}else if(isset($_POST["action"]) && $_POST["action"] == "finish"){
	finishTodoTask($db);
}else if(isset($_POST["action"]) && $_POST["action"] == "unfinish"){
	unfinishTodoTask($db);
}else if(isset($_POST["action"]) && $_POST["action"] == "priority"){
	priorityTodoTask($db);
}else if(isset($_POST["action"]) && $_POST["action"] == "unpriority"){
	unpriorityTodoTask($db);
}else if(isset($_POST["action"]) && $_POST["action"] == "delete"){
	deleteTodoTask($db);
}else if(isset($_POST["action"]) && $_POST["action"] == "delete_all"){
	deleteAllTodoTask($db);
}

function insertTodoTask($db){

	$query = "
	INSERT INTO tasks (taskPriority, taskValue, taskDatetime) 
	VALUES (?, ?, ?)
	";
	 
	if($stmt = mysqli_prepare($db, $query)){
	    mysqli_stmt_bind_param($stmt, "sss", $taskPriority, $taskValue, $taskDatetime);
	    
	    $taskPriority = $_REQUEST['formTaskPriority'];
	    $taskValue = $_REQUEST['formTaskValue'];
	    $taskDatetime = date('Y-m-d H:i:s');
	    
	    if(mysqli_stmt_execute($stmt)){
	        echo json_encode(array("statusCode"=>200));
	    } else{
	        echo json_encode(array("statusCode"=>201));
	    }
	} else{
	    echo json_encode(array("statusCode"=>201));
	}
	 
	mysqli_stmt_close($stmt);

}


function finishTodoTask($db){

	$query = "
	UPDATE tasks
	SET taskFinished = ?
	WHERE taskID = ?
	";

	if($stmt = mysqli_prepare($db, $query)){
	    mysqli_stmt_bind_param($stmt, "ss", $taskFinished, $taskID);
	    
	    $taskFinished = "1";
	    $taskID = $_REQUEST['taskID'];
	    
	    if(mysqli_stmt_execute($stmt)){
	        echo json_encode(array("statusCode"=>200));
	    } else{
	        echo json_encode(array("statusCode"=>201));
	    }
	} else{
	    echo json_encode(array("statusCode"=>201));
	}
	 
	mysqli_stmt_close($stmt);

}

function unfinishTodoTask($db){

	$query = "
	UPDATE tasks
	SET taskFinished = ?
	WHERE taskID = ?
	";

	if($stmt = mysqli_prepare($db, $query)){
	    mysqli_stmt_bind_param($stmt, "ss", $taskFinished, $taskID);
	    
	    $taskFinished = "0";
	    $taskID = $_REQUEST['taskID'];
	    
	    if(mysqli_stmt_execute($stmt)){
	        echo json_encode(array("statusCode"=>200));
	    } else{
	        echo json_encode(array("statusCode"=>201));
	    }
	} else{
	    echo json_encode(array("statusCode"=>201));
	}
	 
	mysqli_stmt_close($stmt);

}


function priorityTodoTask($db){

	$query = "
	UPDATE tasks
	SET taskPriority = ?
	WHERE taskID = ?
	";

	if($stmt = mysqli_prepare($db, $query)){
	    mysqli_stmt_bind_param($stmt, "ss", $taskPriority, $taskID);
	    
	    $taskPriority = "1";
	    $taskID = $_REQUEST['taskID'];
	    
	    if(mysqli_stmt_execute($stmt)){
	        echo json_encode(array("statusCode"=>200));
	    } else{
	        echo json_encode(array("statusCode"=>201));
	    }
	} else{
	    echo json_encode(array("statusCode"=>201));
	}
	 
	mysqli_stmt_close($stmt);

}

function unpriorityTodoTask($db){

	$query = "
	UPDATE tasks
	SET taskPriority = ?
	WHERE taskID = ?
	";

	if($stmt = mysqli_prepare($db, $query)){
	    mysqli_stmt_bind_param($stmt, "ss", $taskPriority, $taskID);
	    
	    $taskPriority = "0";
	    $taskID = $_REQUEST['taskID'];
	    
	    if(mysqli_stmt_execute($stmt)){
	        echo json_encode(array("statusCode"=>200));
	    } else{
	        echo json_encode(array("statusCode"=>201));
	    }
	} else{
	    echo json_encode(array("statusCode"=>201));
	}
	 
	mysqli_stmt_close($stmt);

}


function deleteTodoTask($db){

	$query = "
	DELETE 
	FROM tasks
	WHERE taskID = ?
	";

	if($stmt = mysqli_prepare($db, $query)){
	    mysqli_stmt_bind_param($stmt, "s", $taskID);
	    
	    $taskID = $_REQUEST['taskID'];
	    
	    if(mysqli_stmt_execute($stmt)){
	        echo json_encode(array("statusCode"=>200));
	    } else{
	        echo json_encode(array("statusCode"=>201));
	    }
	} else{
	    echo json_encode(array("statusCode"=>201));
	}
	 
	mysqli_stmt_close($stmt);

}

function deleteAllTodoTask($db){

	$query = "
	DELETE
	FROM tasks
	";

	if (mysqli_query($db, $query)){
  		echo json_encode(array("statusCode"=>200));
	}else{
  		echo json_encode(array("statusCode"=>201));
	}

}

?>