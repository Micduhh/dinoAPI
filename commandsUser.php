<?php

//Micah Netz
/*
Note: cruds.php is the file in which I do my PDO prepared statement querying,
	  and connectDB.php is used for creating a PDO connection
*/

header('Content-type: application/json');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header('Access-Control-Allow-Headers: Authorization, Content-Type');
header('Access-Control-Allow-Origin: *');
require 'cruds.php';

//Clean data function
function scrub($input) {
	$input = trim($input);
	$input = stripslashes($input);
	$input = htmlspecialchars($input);
	return $input;
}

if(($_SERVER["REQUEST_METHOD"] == "GET")){
	try{
			$command = new CrudCommands();
			if(isset($_GET['keyword']) || isset($_GET['name']) || isset($_GET['order']) || isset($_GET['suborder']) || isset($_GET['when']) || isset($_GET['where']) || isset($_GET['food'])){
				
				$keyword = scrub($_GET['keyword']);
				
				if($keyword == "Name"){
					$name = scrub($_GET['name']);
					$rows = $command->SearchCommand($name, $keyword);
				}
				elseif($keyword == "Order"){
					$order = scrub($_GET['order']);
					$rows = $command->SearchCommand($order, $keyword);
				}
				elseif($keyword == "Suborder"){
					$suborder = scrub($_GET['suborder']);
					$rows = $command->SearchCommand($suborder, $keyword);
				}
				elseif($keyword == "When"){
					$when = scrub($_GET['when']);
					$rows = $command->SearchCommand($when, $keyword);
				}
				elseif($keyword == "Where"){
					$where = scrub($_GET['where']);
					$rows = $command->SearchCommand($where, $keyword);
				}
				elseif($keyword == "Food"){
					$food = scrub($_GET['food']);
					$rows = $command->SearchCommand($food, $keyword);
				}
				else{
					$rows = $command->ReadCommand();
				}
			}
			else{
				$rows = $command->ReadCommand();
			}
			$json = json_encode($rows);
			echo $json;
		}catch(Exception $e){
				http_response_code(500);
				echo "Name not found error" . $e; //<--This will need to be removed when publishing live, but helpful for testing
				die("Data Entry Error");
		}
	
}

if(($_SERVER["REQUEST_METHOD"] == "OPTIONS")) {
	//Do options stuff (Display options)
	$arr = array(
        "GET" => "Search data based on specified input parameters",
		"OPTIONS" =>"Display the available options"
    );
	echo json_encode($arr);
}
else{
	echo "Incorrect request method received.";
	http_response_code(500);
}
?>