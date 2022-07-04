<?php

require('db.php');

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

if(isset($_POST["action"]) && $_POST["action"] == "insert"){
	insertTodoTask($db);
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

if(isset($_POST["action"]) && $_POST["action"] == "finish"){
	finishTodoTask($db);
}

function finishTodoTask($db){

	$taskID = $_POST['taskID'];

	$query = "
	UPDATE tasks
	SET taskFinished = '1'
	WHERE taskID = '$taskID'
	";

	if (mysqli_query($db, $query)){
  		echo json_encode(array("statusCode"=>200));
	}else{
  		echo json_encode(array("statusCode"=>201));
	}

}

if(isset($_POST["action"]) && $_POST["action"] == "unfinish"){
	unfinishTodoTask($db);
}

function unfinishTodoTask($db){

	$taskID = $_POST['taskID'];

	$query = "
	UPDATE tasks
	SET taskFinished = '0'
	WHERE taskID = '$taskID'
	";

	if (mysqli_query($db, $query)){
  		echo json_encode(array("statusCode"=>200));
	}else{
  		echo json_encode(array("statusCode"=>201));
	}

}

if(isset($_POST["action"]) && $_POST["action"] == "delete"){
	deleteTodoTask($db);
}

function deleteTodoTask($db){

	$taskID = $_POST['taskID'];

	$query = "
	DELETE 
	FROM tasks
	WHERE taskID = '$taskID'
	";

	if (mysqli_query($db, $query)){
  		echo json_encode(array("statusCode"=>200));
	}else{
  		echo json_encode(array("statusCode"=>201));
	}

}

if(isset($_POST["action"]) && $_POST["action"] == "delete_all"){
	deleteAllTodoTask($db);
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

if(isset($_POST["action"]) && $_POST["action"] == "priority"){
	priorityTodoTask($db);
}

function priorityTodoTask($db){

	$taskID = $_POST['taskID'];

	$query = "
	UPDATE tasks
	SET taskPriority = '1'
	WHERE taskID = '$taskID'
	";

	if (mysqli_query($db, $query)){
  		echo json_encode(array("statusCode"=>200));
	}else{
  		echo json_encode(array("statusCode"=>201));
	}

}

if(isset($_POST["action"]) && $_POST["action"] == "unpriority"){
	unpriorityTodoTask($db);
}

function unpriorityTodoTask($db){

	$taskID = $_POST['taskID'];

	$query = "
	UPDATE tasks
	SET taskPriority = '0'
	WHERE taskID = '$taskID'
	";

	if (mysqli_query($db, $query)){
  		echo json_encode(array("statusCode"=>200));
	}else{
  		echo json_encode(array("statusCode"=>201));
	}

}

?>