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

	<style type="text/css">
		body{
			background-color: #F4F8F9;
		}
	</style>

	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</head>

<body>

	<div class="col-lg-8 mx-auto p-3 py-md-5">

		<main>

			<div class="container-fluid" id="container">
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
								<input type="text" name="formTaskValue" id="formTaskValue" class="form-control" placeholder="Wpisz treść nowego zadania..." autocomplete="off">

								<button type="button" name="formSubmit" id="formSubmit" class="fw-bold btn btn-primary">+</button>
							</div>
						</div>
						<div class="col-md-12 mt-2  d-flex justify-content-between align-items-center">
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" role="switch" id="formTaskPriority" value="0">

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
							<?php if ($taskCount == "0") {
							} else { ?>
								<p><button class="deleteAllBtn btn btn-danger btn-sm" id="deleteAllBtn">Usuń wszystkie zadania</button></p>
							<?php } ?>
						</div>

					</div>
				</div>

			</div>

			<!-- Działanie przycisków w aplikacji -->
			<script src="scripts.js" type="text/javascript"></script>

		</main>
		
	</div>


</body>

</html>