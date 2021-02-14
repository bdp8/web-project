<?php
require 'db.php';

$con = getdb();
if(isset($_POST["Import"]))
{
	$name = $_POST["testname"];
	$author = $_POST["author"];
	$genre = $_POST["group"];
	$fn = $_POST["fn"];
	
	session_start();
	$id = $_SESSION['id'];
	
	$insertTest = "INSERT into test (name,genre,author,author_id) 
			   values ('$name','$genre','$author','$id')";
	
	$result = $con->exec($insertTest);

	if(!isset($result))
	{
		echo "<script type=\"text/javascript\">
				alert(\"Качването на теста беше неуспешно\");
				window.location = \"home.php\"
			  </script>";		
	}

	$selectTest = "SELECT id FROM test WHERE name = '$name' AND author = '$author'";
	$test_id = $con->query($selectTest)->fetch()['id'];

	$i = 0;
	foreach ($_POST['question'] as $question) {
		$motive = $_POST["motive"][$i];
		$question = $_POST['question'][$i];
		$answer1 = $_POST['answer1'][$i];
		$answer2 = $_POST['answer2'][$i];
		$answer3 = $_POST['answer3'][$i];
		$answer4 = $_POST['answer4'][$i];
		$correctAnswer = $_POST['correct'][$i];
		$difficulty = $_POST['difficulty'][$i];
		$ifCorrect = $_POST['ifCorrect'][$i];
		$ifNotCorrect = $_POST['ifNotCorrect'][$i];
		$note = $_POST['note'][$i];
		$type = $_POST['type'][$i];
			
		$insertQuestion = "INSERT into question (test_id,fn,seq_num,motive,name,answer1,answer2,answer3,answer4,correctAnswer,difficulty,ifCorrect,ifNotCorrect,note,type) 
			   values ('$test_id','$fn','$i','$motive','$question','$answer1','$answer2','$answer3','$answer4','$correctAnswer','$difficulty','$ifCorrect','$ifNotCorrect','$note','$type')";
		
		$result = $con->exec($insertQuestion);
		if(!isset($result))
		{
			echo "<script type=\"text/javascript\">
					alert(\"Качването на теста беше неуспешно\");
					window.location = \"home.php\"
				  </script>";		
		}
		
		$i = $i + 1;
	}
	
	echo "<script type=\"text/javascript\">
		alert(\"CSV File has been successfully Imported.\");
		window.location = \"home.php\"
		</script>";
						
}

?>