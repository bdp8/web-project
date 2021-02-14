<?php  
	require 'db.php'; 
	$connection = getdb();
	if($_POST['Register']) 
	{
		$username = isset($_POST["username"]) ? testInput($_POST["username"]) : "";
		$password = isset($_POST["password"]) ? testInput($_POST["password"]) : "";

		try{
				if ( !isset($username, $password) ) 
				{
					exit('Моля попълнете потребителското си име и паролата!');
				}	
				$select = "SELECT id, password FROM users WHERE username = '$username'";
				$stmt = $connection->query($select)->fetch()['password'];
				$id = $connection->query($select)->fetch()['id'];
				if ($stmt === $password) 
				{
					session_regenerate_id();
					session_start();
					$_SESSION['loggedin'] = TRUE;
					$_SESSION['name'] = $_POST['username'];
					$_SESSION['id'] = $id;
					
					
					header('Location: home.php');
				}
				else {
					echo 'Невалидно потребителско име и/или парола!';
				}

			} catch (PDOException $e) {
					error_log($e->getMessage());
					
					echo $e->getMessage();

			}
		
	
	}
	
	
	function testInput($input){
		$input = trim($input);
		//$input = htmlspecialchars($input);
		//$input = stripslashes($input);
		return $input;
	}

	
	function validate($data):bool
	{
		$valid_string_expr = '/(*UTF8)[^а-яА-Я]/';
		
		if(empty($data[0]) || filter_var($data[0], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"$valid_string_expr"))))
		{
			echo "Празен низ или полето за име на предмет не е на кирилица.\n";
			return FALSE;
		}
		if(empty($data[1]) || filter_var($data[1], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"$valid_string_expr"))))
		{
			echo "Празен низ или полето за преподавател не е на кирилица.\n";
			return FALSE;
		}
		if(empty($data[2]) || filter_var($data[2], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"$valid_string_expr"))))
		{
			echo "Празен низ или полето за описание не е на кирилица.\n";
			return FALSE;
		}
		
		return TRUE;
	}
	
	
?>