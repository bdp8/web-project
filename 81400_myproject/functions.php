<?php
require 'db.php';

$con = getdb();
if(isset($_POST["Import"]))
 {
	$name = $_POST["testname"];
	$author = $_POST["author"];
	$genre = $_POST["group"];
	$password = $_POST["password"];
	session_start();
	$author_id = $_SESSION['id'];
	
	$insertTest = "INSERT into test (name,genre,author,author_id, password) 
			   values ('$name','$genre','$author','$author_id','$password')";
	$con->exec($insertTest);
	
	$select = "SELECT id FROM test WHERE name = '$name' AND author = '$author'";
	$id = $con->query($select)->fetch()['id'];

	
	$filename=$_FILES["file"]["tmp_name"];		
	$row = 1;
	
	if($_FILES["file"]["size"] > 0)
	 {
		$file = fopen($filename, "r");
		while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
		{
			if($row == 1){ $row++; continue; }

			$sql = "INSERT into question (test_id,fn,seq_num,motive,name,answer1,answer2,answer3,answer4,correctAnswer,difficulty,ifCorrect,ifNotCorrect,note,type) 
			   values ('$id','".$getData[1]."','".$getData[2]."','".$getData[3]."','"
							   .$getData[4]."','".$getData[5]."','".$getData[6]."','".$getData[7]."','"
							   .$getData[8]."','".$getData[9]."','".$getData[10]."','".$getData[11]."','"
							   .$getData[12]."','".$getData[13]."','".$getData[14]."')";
	
			$result = $con->exec($sql);
			
			if(!isset($result))
			{
				echo "<script type=\"text/javascript\">
						alert(\"Invalid File:Please Upload CSV File.\");
						window.location = \"home.php\"
					  </script>";		
			}
			else {
				  echo "<script type=\"text/javascript\">
					alert(\"CSV File has been successfully Imported.\");
					window.location = \"home.php\"
				</script>";
			}
			
			$row = $row + 1;
		 }
		
		 fclose($file);	
	 }
		 
} elseif (isset($_POST['exportbtn'])) {
    $ID = $_POST['exportbtn'];
    header('Content-Type: text/csv; charset=utf-8');  
    header('Content-Disposition: attachment; filename=data.csv');  
    $output = fopen("php://output", "w");  
    fputcsv($output, array('Timestamp', 'Факултетен номер', 'Номер на въпроса', 'Цел на въпроса', 'Въпрос', 'Опция 1', 'Опция 2', 'Опция 3', 'Опция 4', 'Верен отговор', 'Ниво на трудност', 'Обратна връзка при верен отговор', 'Обратна връзка при грешен отговор', 'Забележка', 'Тип на въпроса'));  
    $query = "SELECT id,fn,seq_num,motive,name,answer1,answer2,answer3,answer4,correctAnswer,difficulty,ifCorrect,ifNotCorrect,note,type from question WHERE test_id='$ID'";  
    $result = $con->query($query);  
    while($row = $result->fetch())  
    {  
         fputcsv($output, $row);  
    }  
    fclose($output);  

} elseif (isset($_POST['starttestbtn'])) {
	$ID = $_POST['starttestbtn'];
	generate_test($ID);
	
}  elseif (isset($_POST['submittest'])) {

	$ID = $_POST['submittest'];
	$studen_name = $_POST["studentname"];
	$student_fn = $_POST["fn"];
	$student_school = $_POST["school"];
	$student_plan = $_POST["plan"];
	$student_kurs = $_POST["kurs"];
	$student_group = $_POST["group"];
	
	$query_questions = "SELECT * FROM question WHERE test_id='$ID'";
	$result_questions = $con->query($query_questions);
	$totalCorrect = 0;
	$totalQuestions = 0;
	$questions = 1;	
	while($row = $result_questions->fetch()) 
	{
		$nameq = "id" . $row["id"];
		if($_POST[$nameq] === $row["answer" . $row["correctAnswer"]])
		{
			$totalCorrect = $totalCorrect + 1;
		}
		$totalQuestions = $totalQuestions + 1;
	}
	
	$query_insert = "INSERT INTO records (fn,name,school,plan,kurs,adm_group,taken_test,grade) values ('$student_fn','$studen_name','$student_school','$student_plan','$student_kurs','$student_group','$ID','$totalCorrect')";
	$con->exec($query_insert);
	
	echo "<script type=\"text/javascript\">
						alert(\" Брой верни " . $totalCorrect . " от общо " . $totalQuestions . " въпроса.\");
						window.location = \"home.php\"
					  </script>";		
}

	
function show_tests($type) {
	$con = getdb();
	$Sql = "SELECT id, name, author, password FROM test WHERE genre='$type'";
	$result = $con->query($Sql);  

	$msg = "<div class='table-responsive'><table id='myTable' class='table table-striped table-bordered'>
			 <thead><tr><th>Идентификационен номер</th>
						<th>Име на тест</th>
						<th>Автор</th>
						<th>Парола</th>
						<th>Линк за споделяне</th>
						</tr></thead><tbody>";

	 while($row = $result->fetch()) {
		
	 $msg = $msg .   "<tr><td>" . $row["id"]."</td>
							<td>" . $row['name']."</td>
							<td>" . $row['author']."</td>
							<td>" . $row['password']."</td>
							<td><a href='localhost:8080/81400_myproject/form.php?id=". $row["id"] . "'>localhost:8080/81400_myproject/form.php?id=". $row["id"] . "</a></td>
							<td><button type='submit' name='exportbtn' value='" . $row["id"] . "'>Изтегляне като .csv файл.</button></td>
							<td><button type='submit' name='starttestbtn' value='" . $row["id"] . "'>Започнете да решавате теста.</button></td>
				  	</tr>";       
	 }
	 
	$msg = $msg . "</tbody></table></div>";				
	echo $msg;	
}


function show_all_tests() {
	$con = getdb();
	$Sql = "SELECT id, name, author, password FROM test";
	$result = $con->query($Sql);  

	$msg = "<div class='table-responsive'><table id='myTable' class='table table-striped table-bordered'>
			 <thead><tr><th>Идентификационен номер</th>
						<th>Име на тест</th>
						<th>Автор</th>
						<th>Парола</th>
						<th>Линк за споделяне</th>
						</tr></thead><tbody>";

	 while($row = $result->fetch()) {

		 $msg = $msg .   "<tr><td>" . $row["id"]."</td>
							<td>" . $row['name']."</td>
							<td>" . $row['author']."</td>
							<td>" . $row['password']."</td>
							<td><a href='localhost:8080/81400_myproject/form.php?id=". $row["id"] . "'>localhost:8080/81400_myproject/form.php?id=". $row["id"] . "</a></td>
							<td><button type='submit' name='exportbtn' value='" . $row["id"] . "'>Изтегляне като .csv файл.</button></td>
							<td><button type='submit' name='starttestbtn' value='" . $row["id"] . "'>Започнете да решавате теста.</button></td>
				  	</tr>";        
	 }
	 
	$msg = $msg . "</tbody></table></div>";				
	echo $msg;	
}

function generate_test($ID)
{
	$con = getdb();
	$query_test = "SELECT * FROM test WHERE id='$ID'";	
	$query_questions = "SELECT * FROM question WHERE test_id='$ID'";
	$result_test = $con->query($query_test)->fetch();
	$result_questions = $con->query($query_questions);
	  
	$msg = "<!DOCTYPE html>
				<html>
					<head>
						<link rel='stylesheet' href='style.css'><meta charset='utf-8' />
						<title>Генериране на тест</title>
					</head>
					<body>
						<div class='header'>
							<h2>Име на тест: " . $result_test["name"] . "</h2>
							<h2>Автор на тест: " . $result_test["author"] . "</h2>
						</div>
					<form class='modal-content animate' action='http://localhost:8080/81400_myproject/functions.php' method='POST' name='export_excel' enctype='multipart/form-data'>
					<b>Информация за студента</b><br></br>
					<label for='studentname'><b>Попълнете вашето име тук: </b></label>
					<input id='studentname' name='studentname' type='text' required/>
					<label for='fn'><b>Попълнете вашият факултетен номер тук: </b></label>
					<input id='fn' name='fn' type='text' required/>
					<label for='school'><b>Факултет: </b></label>
					<input id='school' name='school' type='text'/>
					<label for='plan'><b>Учебен план: </b></label>
					<input id='plan' name='plan' type='text'/>
					<label for='kurs'><b>Курс: </b></label>
					<input id='kurs' name='kurs' type='text'/>
					<label for='group'><b>Група: </b></label>
					<input id='group' name='group' type='text'/>
					<br></br><b>Тестът</b><br></br>";
				
	$num = 1;
	while($row = $result_questions->fetch()) 
	{

		$msg = $msg . "<h>Въпрос " . $num . "</h><br><h>" . $row["name"] . "</h><br>";      
		$arr = array();
		//array_push($arr, $row["correctAnswer"]);
		
		for ($i = 1; $i <= 4; $i++) {
			if ( $row["answer". $i] != '')
			{
				array_push($arr, $row["answer" . $i]);
			}
		}
		shuffle($arr);
		
		foreach ($arr as $value) {
			$msg = $msg . "<input type='radio' id='$value' name='id" . $row["id"] . "' value='$value' />
					   <label for='$value'>$value</label><br>";
		}
		
		$num = $num + 1;
		$msg = $msg . "<br>";
	}
	 	 
	$msg = $msg . "<button type='submit' name='submittest' value='" . $ID . "'>Приключване на опита</button></form></body></html>";
	echo $msg;
}

 ?>