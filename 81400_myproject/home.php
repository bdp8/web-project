<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}
?>

<!DOCTYPE html>

<html>	
	<head>
		<style>
			#id03, #id05, #math, #hist, #geo, #other, #all
			{
				  display: none; /* Hidden by default */
			}
		</style>
		<script>
		var room = 1;
		function add_fields() {
			room++;
			var objTo = document.getElementById('fields')
			var divtest = document.createElement("div");
			divtest.innerHTML = '<br></br><b>Въпрос ' + room +':</b><br></br><label for="motive"><b>Цел на въпроса: </b></label><input id="motive" name="motive[]" type="text"/><label for="question"><b>Съдържание на въпроса: </b></label><input id="question" name="question[]" type="text"/><label for="answer1"><b>Отговор 1:</b></label><input id="answer1" name="answer1[]" type="text"/><label for="answer2"><b>Отговор 2:</b></label><input id="answer2" name="answer2[]" type="text"/><label for="answer3"><b>Отговор 3:</b></label><input id="answer3" name="answer3[]" type="text"/><label for="answer4"><b>Отговор 4:</b></label><input id="answer4" name="answer4[]" type="text"/><label for="correct"><b>Верен отговор:</b></label><input id="correct" name="correct[]" type="text"/>	<label for="difficulty"><b>Ниво на трудност:</b></label><input id="difficulty" name="difficulty[]" type="text" placeholder="Число от 1 до 5"/><label for="ifCorrect"><b>Обратна връзка при верен отговор:</b></label><input id="ifCorrect" name="ifCorrect[]" type="text"/><label for="ifNotCorrect"><b>Обратна връзка при грешен отговор:</b></label><input id="ifNotCorrect" name="ifNotCorrect[]" type="text"/><label for="note"><b>Забележка:</b></label><input id="note" name="note[]" type="text"/><label for="type"><b>Тип на въпроса:</b></label><input id="type" name="type[]" type="text" placeholder="Число от 1 до 3"/>';
			objTo.appendChild(divtest)
				
		}

		function toggle_visibility(id) {
		   var e = document.getElementById(id);
		   if(e.style.display === "block")
			  e.style.display = "none";
		   else
			  e.style.display = "block";
		}

		</script>

		<link rel="stylesheet" href="style.css">
		<meta charset="utf-8" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>
		<title>Проект по УЕБ</title>
	</head>
	<body class="loggedin">
			
			<div class="header">
			  <h1>Система за провеждане и създаване на тестове</h1>
			</div>
		
			<div class="navbar">
			  <a onclick="document.getElementById('id01').style.display='block'">Качи тест</a>
			  <a onclick="toggle_visibility('id05');">Създай тест</a>
			  <a onclick="toggle_visibility('id03');">Търси тест</a>
			  <a onclick="document.getElementById('id02').style.display='block'">Моят профил</a>
  			  <a onclick="document.getElementById('id04').style.display='block'">Излизане от профила</a>
			</div>
			
			<div id="id02" class="modal">
				<form class="modal-content animate"  action="http://localhost:8080/81400_myproject/delete_test.php" method="POST">
					<div class="imgcontainer">
						<span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
					</div>
					<div class="container">
					  	<div class="content">
							<h2>Вашият профил</h2>
							<div>
								<table>
									<tr>
										<td>Вашето потребителско име:</td>
										<td><?=$_SESSION['name']?></td>
									</tr>
									<tr>
										<td>Вашият идентификационен номер:</td>
										<td><?=$_SESSION['id']?></td>
									</tr>
										<td>Вашите тестове:</td>
										<?=require 'delete_test.php'; show_tests_by_user($_SESSION['id']); ?>
								</table>
							</div>
						</div>
					</div>
				</form>
			</div>
			
			<div id="id04" class="modal">
				<form class="modal-content animate"  action="http://localhost:8080/81400_myproject/logout.php" method="POST" name="upload_excel" enctype="multipart/form-data">
					<div class="imgcontainer">
						<span onclick="document.getElementById('id04').style.display='none'" class="close" title="Close Modal">&times;</span>
					</div>
					<div class="container">
                        <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Излизане</button>				
					</div>
				</form>
			</div>
			
			<div id="id01" class="modal">
				<form class="modal-content animate"  action="http://localhost:8080/81400_myproject/functions.php" method="POST" name="upload_excel" enctype="multipart/form-data">
					<div class="imgcontainer">
						<span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
					</div>
					<div class="container">
					  	<label for="testname"><b>Име на тест</b></label>
						<input id="testname" name="testname" type="text"/>
						<br></br>
					  	<label for="author"><b>Автор</b></label>
						<input id="author" name="author" type="text"/>
						<br></br>
					  	<label for="area"><b>Област на теста: </b></label>
						<select id="group" name="group">
										<option value="Математика">Математика</option>
										<option value="История">История</option>
										<option value="География">География</option>
										<option value="Други">Други</option>
						</select> 
						<br></br>
						<label for="password"><b>Парола за теста</b></label>
						<input id="password" required name="password" type="password"/>
						<br></br>
						<label class="col-md-4 control-label" for="filebutton">Изберете файл..</label>
                        <input type="file" name="file" id="file" class="input-large">
						<br></br>
                        <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Качи тест</button>
						<span>
						 <?php if(isset($_GET['msg']))
						  echo $_GET['msg'];
						  ?>
						</span> 
					</div>
				</form>
			</div>

			<div id="id03">
				<form class="modal-content animate"  action="http://localhost:8080/81400_myproject/functions.php" method="POST" name="export_excel" enctype="multipart/form-data">
				<div class="imgcontainer">
					<span onclick="document.getElementById('id03').style.display='none'" class="close" title="Close Modal">&times;</span>
				</div>
				<div class="container">
					<div class="navbar">
					  <a onclick="toggle_visibility('all');">Всички</a>
					  <a onclick="toggle_visibility('math');">Математика</a>
					  <a onclick="toggle_visibility('hist');">История</a>
					  <a onclick="toggle_visibility('geo');">География</a>
					  <a onclick="toggle_visibility('other');">Други</a>
					</div>
						<div id="all">
							<?php
								show_all_tests();
							 ?>
						 </div>
						<div id="math">
							<?php
								show_tests("Математика");
							 ?>
						 </div>
						 <div id="hist">
							<?php
								show_tests("История");
							 ?>
						 </div>
						 <div id="geo">
							<?php
								show_tests("География");
							 ?>
						 </div>
						 <div id="other">
							<?php
								show_tests("Други");
							 ?>
						 </div>
				 </div>
				 </form>
			</div>
			
			
			<div id="id05" class="box">
				<form class="modal-content animate" action="http://localhost:8080/81400_myproject/add_test.php" method="POST" name="upload_test" enctype="multipart/form-data">
					<div class="imgcontainer">
						<span onclick="document.getElementById('id05').style.display='none'" class="close" title="Close Modal">&times;</span>
					</div>
					<div class="container">
					  	<label for="testname"><b>Име на тест</b></label>
						<input id="testname" name="testname" type="text"/>
						<br></br>
					  	<label for="author"><b>Автор</b></label>
						<input id="author" name="author" type="text"/>
						<br></br>
						<label for="fn"><b>Факултетен номер</b></label>
						<input id="fn" name="fn" type="text"/>
						<br></br>
					  	<label for="area"><b>Област на теста: </b></label>
						<select id="group" name="group">
										<option value="Математика">Математика</option>
										<option value="История">История</option>
										<option value="География">География</option>
										<option value="Други">Други</option>
						</select> 
						<br></br>
						
						<div id="fields">
						<div>
						<br></br>
						<b>Въпрос 1</b>
						<br></br>
						<label for="motive"><b>Цел на въпроса: </b></label>
						<input id="motive" name="motive[]" type="text"/>
						<label for="question"><b>Съдържание на въпроса: </b></label>
						<input id="question" name="question[]" type="text"/>
				
						<label for="answer1"><b>Отговор 1:</b></label>
						<input id="answer1" name="answer1[]" type="text"/>
						
						<label for="answer2"><b>Отговор 2:</b></label>
						<input id="answer2" name="answer2[]" type="text"/>
						
						<label for="answer3"><b>Отговор 3:</b></label>
						<input id="answer3" name="answer3[]" type="text"/>
						
						<label for="answer4"><b>Отговор 4:</b></label>
						<input id="answer4" name="answer4[]" type="text"/>
						
						<label for="correct"><b>Верен отговор:</b></label>
						<input id="correct" name="correct[]" type="text" placeholder="Число от 1 до 4"/>
						
						<label for="difficulty"><b>Ниво на трудност:</b></label>
						<input id="difficulty" name="difficulty[]" type="text" placeholder="Число от 1 до 5"/>
						
						<label for="ifCorrect"><b>Обратна връзка при верен отговор:</b></label>
						<input id="ifCorrect" name="ifCorrect[]" type="text"/>
						
						<label for="ifNotCorrect"><b>Обратна връзка при грешен отговор:</b></label>
						<input id="ifNotCorrect" name="ifNotCorrect[]" type="text"/>
						
						<label for="note"><b>Забележка:</b></label>
						<input id="note" name="note[]" type="text"/>
						
						<label for="type"><b>Тип на въпроса:</b></label>
						<input id="type" name="type[]" type="text" placeholder="Число от 1 до 3"/>
				
						</div>
						</div>
						<input type="button" id="more_fields" onclick="add_fields()" value="Добавете въпрос" />
									
						<br></br>
                        <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Качи тест</button>
					</div>
				</form>
			</div>
	</body>
	
</html>

