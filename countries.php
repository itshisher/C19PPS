<?php
require_once 'includes/dbh.php';
include_once 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<style>
ul, #myUL {
  list-style-type: none;
}

/* Remove margins and padding from the parent ul */
#myUL {
  margin: 0;
  padding: 0;
}

/* Style the caret/arrow */
.caret {
  cursor: pointer;
  user-select: none; /* Prevent text selection */
}

/* Create the caret/arrow with a unicode, and style it */
.caret::before {
  content: "\25B6";
  color: black;
  display: inline-block;
  margin-right: 6px;
}
/* Rotate the caret/arrow icon when clicked on (using JavaScript) */
.caret-down::before {
  transform: rotate(90deg);
}

/* Hide the nested list */
.nested {
  display: none;
}
.event {
  cursor: pointer;
  user-select: none; /* Prevent text selection */
}

.state {
  cursor: pointer;
  user-select: none; /* Prevent text selection */
}
/* Show the nested list when the user clicks on the caret/arrow (with JavaScript) */
.active {
  display: block;
}
td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}

</style>
<title>Articles</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="w3-white">
<div class="w3-container w3-content w3-padding-64">
<h2 class="w3-wide w3-center">Regions</h2>
<p class="w3-opacity w3-center"><i>View Regions, Countries, and States/Provinces</i></p><br>


<ul id="myUL">
  <?php
$sql = "SELECT * FROM Regions";
$result_Regions = $connection->query($sql);
$htmlDisplay="";

if ($result_Regions->num_rows > 0)
{
    while ($row_Regions = $result_Regions->fetch_assoc())
    {
		$sql = "SELECT * FROM Countries where rID=\"" . $row_Regions["rID"]. "\"";
		$result_Countries = $connection->query($sql);
		$htmlDisplay=$htmlDisplay. "<li><span class=\"caret\">". $row_Regions["rName"]. "</span> <button class=\"w3-black\" type=\"submit\" onclick=\"createCountry(" . $row_Regions["rID"]. ")\">Add Country</button> <ul class=\"nested w3-ul w3-border w3-white w3-text-grey\">";
    	
		if ($result_Countries->num_rows > 0)
		{
    		while ($row_Countries = $result_Countries->fetch_assoc()){
				$htmlDisplay=$htmlDisplay."<li class=\"w3-padding\"><span class=\"caret\">".$row_Countries["cName"]." <button id= \"" .$row_Countries["cID"].  "\" class=\"w3-black event\">View</button></span><ul class=\"nested w3-ul w3-border w3-white w3-text-grey\">";
				$sql = "SELECT * FROM ProStaTe where cID=\"" . $row_Countries["cID"]. "\"";
				$result_States = $connection->query($sql);
				if ($result_States->num_rows > 0){
    				while ($row_States = $result_States->fetch_assoc()){
						$htmlDisplay=$htmlDisplay."<li>".$row_States["pstName"]." <button id= \"s" .$row_States["pstID"].  "\" class=\"w3-black state\">View</button></li>";
					}
				}
				$htmlDisplay=$htmlDisplay."</ul></li>";
			}
		}
		$htmlDisplay=$htmlDisplay."</ul></li>";
	}
}
echo $htmlDisplay;
?> 
</ul>
</div>



<div id="countryModal" class='w3-modal'>
  <div class="w3-modal-content w3-animate-top w3-card-4">
    <div class='w3-container'>
      <header class="w3-container w3-center w3-padding-32">
        <span onclick="document.getElementById('countryModal').style.display='none'" class="w3-button w3-xlarge w3-display-topright">×</span>
      </header>
      <form>
        <div class="w3-input" style="display: flex;align-items: center;">Government Agency: <select name="government" id="government" class="w3-input w3-border">
		<?php
		$sql = "Select distinct oName,o.countryID as govAgID from Countries c right join Organizations o on c.govAgID=o.countryID  right join OrgGovAgencies og on o.oID= og.oID";
		$government_result = $connection->query($sql);
		while ($government_row = $government_result->fetch_assoc()){
			echo "<option value=\"" . $government_row["govAgID"] . "\">" . $government_row["oName"] . "</option>";
		}
		?>
		</select>
        </div>
        <div class="w3-input" style="display: flex;align-items: center;">Country: <input  id="cname" class="w3-input w3-border" type="text" value="" required name="cname">
        </div>
        <div class="w3-input" style="display: flex;align-items: center;">Province in comma separated list
			<input  id="state" class="w3-input w3-border" type="text" placeholder="Quebec,Ontario" required name="state">
        </div>
      </form>
	  <button class="w3-button w3-blue w3-section" id='edit' onclick="editCountry()">Submit</button>
      <button class="w3-button w3-red w3-section" id='delete' onclick="deleteCountry()">Delete</button>
	  <p class="w3-section" id="cID" style="display:none;"></p>
	   <p class="w3-section" id="operation" style="display:none;"></p>
    </div>
  </div>
</div>



<div id="stateModal" class='w3-modal'>
  <div class="w3-modal-content w3-animate-top w3-card-4">
    <div class='w3-container'>
      <header class="w3-container w3-center w3-padding-32">
        <span onclick="document.getElementById('stateModal').style.display='none'" class="w3-button w3-xlarge w3-display-topright">×</span>
      </header>
      <form>
	    <div class="w3-input" style="display: flex;align-items: center;">State/Province: <input  id="sname" class="w3-input w3-border" type="text" value="" required name="sname">
        </div>
        <div class="w3-input" style="display: flex;align-items: center;">Country: <select name="country" id="country" class="w3-input w3-border">
		<?php
		$sql = "Select * from Countries";
		$result = $connection->query($sql);
		while ($row = $result->fetch_assoc()){
			echo "<option value=\"" . $row["cID"] . "\">" . $row["cName"] . "</option>";
		}
		?>
		</select>
        </div>
      </form>
	  <button class="w3-button w3-blue w3-section" id='editS' onclick="editState()">Submit</button>
      <button class="w3-button w3-red w3-section" id='deleteS' onclick="deleteState()">Delete</button>
	  <p class="w3-section" id="pstID" style="display:none;"></p>
    </div>
  </div>
</div>
 

 <script>
 //edit country
 const collection = document.getElementsByClassName("event");
 for (var i = 0; i < collection.length; i++) {
    collection[i].addEventListener("click", function(event) {
	document.getElementById("delete").style.display='inline-block';
	document.getElementById("operation").innerHTML="edit";
	const button = event.target; 
	
	const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
		const country=JSON.parse(this.responseText);
		document.getElementById("cname").value=country[0]["cName"];
		document.getElementById("government").value=country[0]["govAgID"];
		document.getElementById("cID").innerHTML=country[0]["cID"];
		const xhttp = new XMLHttpRequest();
    	xhttp.onload = function() {
			document.getElementById("state").placeholder=this.responseText;
		}
		xhttp.open("GET", "countryQueries.php?id=" + button.id +"&method=display&type=stateList", true);
    	xhttp.send();
	}
	xhttp.open("GET", "countryQueries.php?id=" + button.id +"&method=display&type=country", true);
    xhttp.send();
	
    document.getElementById("countryModal").style.display='block';
  });
}

//edit province
const collectionState = document.getElementsByClassName("state");
 for (var i = 0; i < collectionState.length; i++) {
    collectionState[i].addEventListener("click", function(event) {
	document.getElementById("deleteS").style.display='inline-block';
	const button2 = (event.target.id).substring(1); 
	
	const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
		const state=JSON.parse(this.responseText);
		
		document.getElementById("sname").value=state[0]["pstName"];
		document.getElementById("country").value=state[0]["cID"];
		document.getElementById("pstID").innerHTML=state[0]["pstID"];

	}
	xhttp.open("GET", "countryQueries.php?id=" + button2 +"&method=display&type=state", true);
    xhttp.send();
	
    document.getElementById("stateModal").style.display='block';
  });
}


function editState(){
	let editstate = {
	pstID: document.getElementById('pstID').innerHTML, 
	pstName:document.getElementById("sname").value, 
	cID:document.getElementById("country").value};
	
	var url = "countryQueries.php?";
	url=url.concat("id=",editstate.pstID,"&method=editS");
	
	
	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader('Content-Type', 'application/json');
	xhr.send(JSON.stringify(editstate));
	document.getElementById("stateModal").style.display='none';
}
 
function editCountry(){
	let editcountry = {
	cID: document.getElementById('cID').innerHTML, 
	cName:document.getElementById("cname").value, 
	govAgID:document.getElementById("government").value, 
	state:document.getElementById("state").value};
	
	var url = "countryQueries.php?";
	if(document.getElementById('operation').innerHTML=="edit"){
		url=url.concat("id=",editcountry.cID,"&method=edit");
	}
	else{
		url=url.concat("id=",editcountry.cID,"&method=create");
	}
	
	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader('Content-Type', 'application/json');
	xhr.send(JSON.stringify(editcountry));
	document.getElementById("countryModal").style.display='none';
}
 
 
 function createCountry(rID){
	document.getElementById("countryModal").style.display='block';
	document.getElementById("government").value="";
	document.getElementById('cID').innerHTML=rID;
	document.getElementById("cname").value="";
	document.getElementById("government").value="";
	document.getElementById("state").value="";
	document.getElementById("delete").style.display='none';	
	document.getElementById("operation").innerHTML="create";
}


function deleteCountry(){
	const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
		console.log(this.responseText);
	}
	var cID=document.getElementById("cID").innerHTML;
	xhttp.open("GET", "countryQueries.php?id=" + cID+"&method=delete", true);
    xhttp.send();
	document.getElementById("countryModal").style.display='none';
}

function deleteState(){
	const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
		console.log(this.responseText);
	}
	var pstID=document.getElementById("pstID").innerHTML;
	xhttp.open("GET", "countryQueries.php?id=" + pstID+"&method=deleteS", true);
    xhttp.send();
	document.getElementById("stateModal").style.display='none';
}
 
 var toggler = document.getElementsByClassName("caret");
var i;

for (i = 0; i < toggler.length; i++) {
  toggler[i].addEventListener("click", function() {
    this.parentElement.querySelector(".nested").classList.toggle("active");
    this.classList.toggle("caret-down");
  });
}
 </script>

</body>
</html>