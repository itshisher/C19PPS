<?php

require_once 'includes/dbh.php';


$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$components = parse_url($url);
parse_str($components['query'], $parameters);

if ($parameters["method"] == "display")
{
	#determine if user can edits
    getArticle($connection, $parameters);

}

else if ($parameters["method"] == "delete")
{
    deleteArticle($connection,$parameters);

}

else if ($parameters["method"] == "edit")
{
    editArticle($connection,$parameters);

}

else if ($parameters["method"] == "create")
{
    createArticles($connection,$parameters);

}

function createArticles($connection,$parameters){
 	$input = file_get_contents('php://input');
	$object = json_decode($input);
	$sql = "INSERT INTO Articles (author,pubDate,majorTopic,minorTopic,summary,article) VALUES(\"". $object->author . "\",\"".$object->pubDate. "\",\"".$object->maTopic. "\",\"".$object->miTopic. "\",\"".$object->summary. "\",\"" .$object->article."\")";
	$connection->query($sql);
}
function editArticle($connection,$parameters){
	$input = file_get_contents('php://input');
	$object = json_decode($input);
	$sql = "UPDATE Articles SET author=\"". $object->author . "\",pubDate=\"".$object->pubDate. "\",majorTopic=\"".$object->maTopic. "\",minorTopic=\"".$object->miTopic. "\",summary=\"".$object->summary. "\",article=\"".$object->article."\" WHERE aID=\"" . $parameters["id"] . "\"";
	$connection->query($sql);
}

function deleteArticle($connection,$parameters){
	$sql = "DELETE FROM Articles WHERE aID=\"" . $parameters["id"] . "\"";
    if ($connection->query($sql) === true)
    {
        echo "Record deleted successfully";
    }
    else
    {
        echo "Error deleting record: " . $connection->error;
    }
}

function getAuthors($connection){
	$sql = "select concat(firstName,\" \", lastName) as oName from UserResearchers ur inner join users u on ur.uID=u.uID
			union
			select oName from UserOrgDelegate uo inner join organizations o on uo.orgID=o.oID";
    $authors_result = $connection->query($sql);
}

function getArticle($connection, $parameters){
	$sql = "SELECT * FROM Articles where aID='" . $parameters["id"] . "'";
	$result = mysqli_query($connection, $sql);
	$json = mysqli_fetch_all ($result, MYSQLI_ASSOC);
	echo json_encode($json);
}

?>