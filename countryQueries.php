<?php

require_once 'includes/dbh.php';


$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$components = parse_url($url);
parse_str($components['query'], $parameters);

if ($parameters["method"] == "display")
{
	#determine if user can edits
	if($parameters["type"] == "country"){
		getCountry($connection, $parameters);
	}
	if($parameters["type"] == "stateList"){
		getStateList($connection, $parameters);
	}
	if($parameters["type"] == "state"){
		getState($connection, $parameters);
	}

}

else if ($parameters["method"] == "delete")
{
    deleteCountry($connection,$parameters);

}
else if ($parameters["method"] == "deleteS")
{
    deleteState($connection,$parameters);

}

else if ($parameters["method"] == "edit")
{
    editCountry($connection,$parameters);

}
else if ($parameters["method"] == "editS")
{
    editState($connection,$parameters);

}

else if ($parameters["method"] == "create")
{
    createCountry($connection,$parameters);

}

function createCountry($connection,$parameters){
 	$input = file_get_contents('php://input');
	$object = json_decode($input);
	$sql = "INSERT INTO Countries (cName,govAgID,rID) VALUES(\"". $object->cName . "\",\"".$object->govAgID. "\",\"".$object->cID."\")";
	$connection->query($sql);
	
	$sql = "SELECT cID FROM Countries where cName=\"" .$object->cName ."\"";
	$result=$connection->query($sql);
	$row = $result->fetch_assoc();
	
	if($object->state!=""){
		$array = explode(',', $object->state);
		for ($x = 0; $x <count($array); $x++) {
	  		$sql = "INSERT INTO ProStaTe (pstName,cID) VALUES(\"". $array[$x] . "\",\"".$row["cID"]. "\")";
			$connection->query($sql);
		}	
	}
}
function editCountry($connection,$parameters){
	$input = file_get_contents('php://input');
	$object = json_decode($input);
	$sql = "UPDATE Countries SET cName=\"". $object->cName . "\",govAgID=\"".$object->govAgID."\" WHERE cID=\"" . $parameters["id"] . "\"";
	$connection->query($sql);
	
	if($object->state!=""){
		$array = explode(',', $object->state);
		for ($x = 0; $x <count($array); $x++) {
	  		$sql = "INSERT INTO ProStaTe (pstName,cID) VALUES(\"". $array[$x] . "\",\"".$object->cID. "\")";
			$connection->query($sql);
		}	
	}
}

function editState($connection,$parameters){
	$input = file_get_contents('php://input');
	$object = json_decode($input);
	$sql = "UPDATE ProStaTe SET pstName=\"". $object->pstName . "\",cID=\"".$object->cID."\" WHERE pstID=\"" . $parameters["id"] . "\"";
	$connection->query($sql);
}

function deleteCountry($connection,$parameters){
	$sql = "DELETE FROM Countries WHERE cID=\"" . $parameters["id"] . "\"";
	$connection->query($sql);
	
	$sql = "DELETE FROM ProStaTe WHERE cID=\"" . $parameters["id"] . "\"";
	$connection->query($sql);
	echo "success";
	
}

function deleteState($connection,$parameters){	
	$sql = "DELETE FROM ProStaTe WHERE pstID=\"" . $parameters["id"] . "\"";
	$connection->query($sql);
	echo "success";
	
}

function getCountry($connection, $parameters){
	$sql = "SELECT * FROM Countries where cID='" . $parameters["id"] . "'";
	$result = mysqli_query($connection, $sql);
	$json = mysqli_fetch_all ($result, MYSQLI_ASSOC);
	echo json_encode($json);
}

function getState($connection, $parameters){
	$sql = "SELECT * FROM ProStaTe where pstID='" . $parameters["id"] . "'";
	$result = mysqli_query($connection, $sql);
	$json = mysqli_fetch_all ($result, MYSQLI_ASSOC);
	echo json_encode($json);
}

function getStateList($connection, $parameters){
	$sql = "SELECT pstName FROM ProStaTe where cID='" . $parameters["id"] . "'";
	$stateList="";
	$result=$connection->query($sql);
	if ($result->num_rows > 0){
    	while ($row_States = $result->fetch_assoc()){
			$stateList=$stateList.$row_States["pstName"].",";
		}
	}
	echo substr($stateList, 0, -1);
}
?>