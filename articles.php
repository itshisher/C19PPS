<?php
require_once 'includes/dbh.php';
include_once 'header.php';
?>


<title>Articles</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

 <div class="w3-black" id="articles">
    <div class="w3-container w3-content w3-padding-64" style="max-width:800px">
      <h2 class="w3-wide w3-center">Articles</h2>
      <p class="w3-opacity w3-center"><i>Articles by researchers and organizations</i></p><br>
	  <button class="w3-button w3-green" style="display: flex;" type="submit" onclick="createArticle()">Create</button> 
	  <div class="w3-row-padding w3-padding-32" style="margin:0 -16px">

<?php
$sql = "SELECT * FROM Articles";
$result = $connection->query($sql);

if ($result->num_rows > 0)
{
    while ($row = $result->fetch_assoc())
    {
        echo "<div class='w3-third w3-margin-bottom' id=\""  . $row["aID"] .  "\">
					<div class='w3-container w3-white'>
					<p><b>". substr($row["author"], 0, 10) ."</b></p><p class='w3-opacity'>". $row["pubDate"] ."</p><p class='w3-opacity'>". $row["majorTopic"] ."</p><p>". substr($row["summary"], 0, 10) ."</p>
					<button class='w3-button w3-black w3-margin-bottom'   onclick=\"showArticle(" . $row["aID"] . ")\">View More</button>
					</div></div>";
    }
}
?>  




      </div>
    </div>
  </div>
</div>
</body>


<div id="articleModal" class='w3-modal'>
  <div class="w3-modal-content w3-animate-top w3-card-4">
    <div class='w3-container'>
      <header class="w3-container w3-center w3-padding-32">
        <span onclick="document.getElementById('articleModal').style.display='none'" class="w3-button w3-xlarge w3-display-topright">×</span>
      </header>
      <form>
        <div class="w3-input" style="display: flex;align-items: center;">Publisher: <select name='author' id="author" class="w3-input w3-border">
		<?php
		$sql = "select concat(firstName,\" \", lastName) as oName from UserResearchers ur inner join Users u on ur.uID=u.uID
			union
			select oName from UserOrgDelegate uo inner join Organizations o on uo.orgID=o.oID";
		$authors_result = $connection->query($sql);
		while ($author_row = $authors_result->fetch_assoc()){
			echo "<option value=\"" . $author_row["oName"] . "\">" . $author_row["oName"] . "</option>";
		}
		?>
		</select>
        </div>
        <div class="w3-input" style="display: flex;align-items: center;">Date Published: <input  id="pubDate" class="w3-input w3-border" type="date" value="" required name="pubDate">
        </div>
        <div class="w3-input" style="display: flex;align-items: center;">Major Topic: <input class="w3-input w3-border" id="maTopic" type="text" value="" required name="majorTopic">
        </div>
        <div class="w3-input" style="display: flex;align-items: center;" >Minor Topic: <input id="miTopic"class="w3-input w3-border" type="text" value="" required name="minorTopic">
        </div>
        <div class="w3-input" style="display: flex;align-items: center;" >Summary: <input id="summary" class="w3-input w3-border" type="text" value="" required name="summary">
        </div>
        <div class="w3-input" style="display: flex;align-items: center;">
          <textarea class="w3-input w3-border" rows='5' type="text" required name="article" id="article"></textarea>
        </div>
      </form>
	  <button class="w3-button w3-blue w3-section" id='edit' onclick="editArticle()">Submit</button>
      <button class="w3-button w3-red w3-section" id='delete' onclick="deleteArticle()">Delete</button>
	  <p class="w3-section" id="aID"></p>
    </div>
  </div>
</div>



<script>
function showArticle(id) {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
		const article=JSON.parse(this.responseText);
		document.getElementById('author').value=article[0].author;
		document.getElementById("pubDate").value=article[0].pubDate;
		document.getElementById("maTopic").value=article[0].majorTopic;
		document.getElementById("miTopic").value=article[0].minorTopic;
		document.getElementById("summary").value=article[0].summary;
		document.getElementById("article").value=article[0].article;
		document.getElementById("aID").innerHTML=article[0].aID;
		document.getElementById("aID").style.display='none';
		document.getElementById("delete").style.display='inline-block';
		document.getElementById("articleModal").style.display='block';
	};
    xhttp.open("GET", "articleQueries.php?id=" + id + "&method=display", true);
    xhttp.send();
}

function deleteArticle(){
	const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
		var aID=document.getElementById("aID").innerHTML;
		document.getElementById(aID).remove();
		console.log(this.responseText);
	}
	xhttp.open("GET", "articleQueries.php?id=" + aID.innerHTML+"&method=delete", true);
    xhttp.send();
	document.getElementById("articleModal").style.display='none';
}

function createArticle(){
	document.getElementById('author').value="";
	document.getElementById("pubDate").value="";
	document.getElementById("maTopic").value="";
	document.getElementById("miTopic").value="";
	document.getElementById("summary").value="";
	document.getElementById("article").value="";
	document.getElementById("aID").innerHTML="";
	document.getElementById("delete").style.display='none';
	document.getElementById("aID").style.display='none';
	document.getElementById("articleModal").style.display='block';
}

function editArticle(){

	let article = {
	author: document.getElementById('author').value, 
	pubDate:document.getElementById("pubDate").value, 
	maTopic:document.getElementById("maTopic").value, 
	miTopic:document.getElementById("miTopic").value,
	summary:document.getElementById("summary").value,
	article:document.getElementById("article").value};
	
	var url = "articleQueries.php?";
	const aID =document.getElementById("aID").innerHTML;
	if(aID==""){
		url=url.concat("method=create");
	}
	else{
		article.aID=document.getElementById("aID").innerHTML;
		url=url.concat("id=",aID,"&method=edit");
	}
	
	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader('Content-Type', 'application/json');
	xhr.send(JSON.stringify(article));
	document.getElementById("articleModal").style.display='none';
}


</script>