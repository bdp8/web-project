<?php 

require 'functions.php';

$connection = getdb();
if($_POST)
	{
		$id = $_POST['deletebtn'];
		$question = "DELETE FROM question WHERE test_id=" . $id;
		$sql = "DELETE FROM test WHERE id=" . $id;
		
		try{
			$res1 = $connection->exec($question);
			$res2 = $connection->exec($sql);
			if(!isset($res1) and !isset($res2))
			{
				echo "<script type=\"text/javascript\">
						alert(\"Тестът не беше успешно изтрит.\");
						window.location = \"home.php\"
					  </script>";		
			}
			else {
				  echo "<script type=\"text/javascript\">
					alert(\"Тестът успешно беше изтрит.\");
					window.location = \"home.php\"
				</script>";
			}
			} catch (PDOException $e) {
					error_log($e->getMessage());
					
					echo $e->getMessage();

			}
	}
	
	
function show_tests_by_user($id)
{
	$connection = getdb();
	$Sql = "SELECT id, name, author, password FROM test WHERE author_id='$id'";
	$result = $connection->query($Sql);  

	$msg = "<div class='table-responsive'><table id='myTable' class='table table-striped table-bordered'>
	<thead><tr><th>Идентификационен номер</th>
		<th>Име на тест</th>
		<th>Автор</th>
		<th>Парола</th>
		</tr></thead><tbody>";

	 while($row = $result->fetch()) {

		
		 $msg = $msg .   "<tr><td>" . $row["id"]."</td>
							<td>" . $row['name']."</td>
							<td>" . $row['author']."</td>
							<td>" . $row['password']."</td>
							<td><button type='submit' name='deletebtn' value='" . $row["id"] . "'>Изтриване на тест.</button></td>
						</tr>";       
	}

	$msg = $msg . "</tbody></table></div>";	

	echo $msg;
				
}

?>