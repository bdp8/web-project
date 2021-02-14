<?php
require 'functions.php';

$connection = getdb();

if($_POST["start"])
{	
	parse_str($_SERVER["QUERY_STRING"]);
	
	$password = $_POST["password"];

	try{
		if ( !isset($password) ) 
				{
					exit('Моля попълнете паролата!');
				}	
				$select = "SELECT password FROM test WHERE id = '$id'";
				$stmt = $connection->query($select)->fetch()['password'];
				if ($stmt === $password) 
				{
					generate_test($id);
				}				
				else {
					echo 'Невалиднa парола!';
				}

			} catch (PDOException $e) {
					error_log($e->getMessage());
					
					echo $e->getMessage();

			}
}
else {

$msg = "<!DOCTYPE html><html><head>
		<script>document.forms[0].onsubmit = function(event){
		  createCard(event);
		}
		 
		function createCard(event){      
		  event.target.style.display = 'none';
		}</script>
		</head><body>
		<form class='modal-content animate'  action='http://localhost:8080/81400_myproject/form.php?" . $_SERVER["QUERY_STRING"] . "' method='POST'>			
		<div class='container'>
		   <h1>Въведете парола, за да започнете изпълнението на теста:</h1>
			<label for='password'><b>Парола</b></label>
			<input id='password' required name='password' type='password'/>
			<br></br>
			<button type='submit' value='start'  name='start'>Старт</button>	
		</div>
	</form>
	</body>
	
</html>"; 

echo $msg;
}

?>