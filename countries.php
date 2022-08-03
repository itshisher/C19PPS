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
		<table style="padding-top: 10px" id="historicalCountry"></table>
		<button onclick="newCData()">+</button>
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
		<table style="padding-top: 10px" id="historicalState"></table>
		
      </form>
	  <button onclick="newSData()">+</button>
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
        document.getElementById("delete").style.display = 'inline-block';
        document.getElementById("operation").innerHTML = "edit";
        const button = event.target;

        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            const country = JSON.parse(this.responseText);
            document.getElementById("cname").value = country[0]["cName"];
            document.getElementById("government").value = country[0]["govAgID"];
            document.getElementById("cID").innerHTML = country[0]["cID"];
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                document.getElementById("state").placeholder = this.responseText;
            }
            xhttp.open("GET", "countryQueries.php?id=" + button.id + "&method=display&type=stateList", true);
            xhttp.send();
        }
        xhttp.open("GET", "countryQueries.php?id=" + button.id + "&method=display&type=country", true);
        xhttp.send();


        const xhttp2 = new XMLHttpRequest();
        xhttp2.onload = function() {
            var table = document.getElementById("historicalCountry");
            while (table.firstChild) {
                table.removeChild(table.lastChild);
            }
            var tr = document.createElement('tr');
            var th = document.createElement('th');
            th.innerHTML = "Population";
            tr.append(th);
            th = document.createElement('th');
            th.innerHTML = "Deaths";
            tr.append(th);
            th = document.createElement('th');
            th.innerHTML = "Updated Date";
            tr.append(th);
            th = document.createElement('th');
            tr.append(th);
            table.append(tr);
            const countryHistorical = JSON.parse(this.responseText);
            for (var i = 0; i < countryHistorical.length; i++) {
                tr = document.createElement('tr');
                var td = document.createElement('td');
                var input = document.createElement('input');
                input.value = countryHistorical[i]["population"];
                td.append(input)
                tr.append(td);
                td = document.createElement('td');
                input = document.createElement('input');
                input.value = countryHistorical[i]["nDeaths"];
                td.append(input)
                tr.append(td);
                td = document.createElement('td');
                input = document.createElement('input');
                input.value = countryHistorical[i]["updatedDate"];
                input.disabled = true;
                td.append(input)
                tr.append(td);
                var button = document.createElement('button');
                button.innerHTML = "Delete";
                button.className = "w3-red w3-button";
                button.id = document.getElementById("cID").innerHTML + "," + countryHistorical[i]["updatedDate"];
                button.addEventListener("click", function(event) {
                    const button = event.target.id;

                    const xhttp = new XMLHttpRequest();
                    xhttp.onload = function() {}
                    const array = button.split(",");
                    xhttp.open("GET", "countryQueries.php?id=" + array[0] + "&updatedDate=\"" + array[1] + "\" &method=deleteR", true);
                    xhttp.send();

                });
                td = document.createElement('td');
                td.append(button)
                tr.append(td);
                table.append(tr);
            }

        }
        xhttp2.open("GET", "countryQueries.php?id=" + button.id + "&method=display&type=countryHistorical", true);
        xhttp2.send();

        document.getElementById("countryModal").style.display = 'block';
    });
}

//edit province
const collectionState = document.getElementsByClassName("state");
for (var i = 0; i < collectionState.length; i++) {
    collectionState[i].addEventListener("click", function(event) {
        document.getElementById("deleteS").style.display = 'inline-block';
        const button2 = (event.target.id).substring(1);

        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {


            var table = document.getElementById("historicalState");
            while (table.firstChild) {
                table.removeChild(table.lastChild);
            }
            var tr = document.createElement('tr');
            var th = document.createElement('th');


            th.innerHTML = "Vaccine";
            tr.append(th);
            th = document.createElement('th');
            th.innerHTML = "Injections";
            tr.append(th);
            th = document.createElement('th');
            th.innerHTML = "Infections";
            tr.append(th);
            th = document.createElement('th');
            th.innerHTML = "Deaths";
            tr.append(th);
            th = document.createElement('th');
            th.innerHTML = "Updated Date";
            tr.append(th);
            th = document.createElement('th');
            th.innerHTML = "";
            tr.append(th);
            table.append(tr);

            const state = JSON.parse(this.responseText);

            document.getElementById("sname").value = state[0]["pstName"];
            document.getElementById("country").value = state[0]["cID"];
            document.getElementById("pstID").innerHTML = state[0]["pstID"];




            const xhttp3 = new XMLHttpRequest();
            xhttp3.onload = function() {
                const stateHistorical = JSON.parse(this.responseText);
                table = document.getElementById("historicalState");
                for (var i = 0; i < stateHistorical.length; i++) {
                    tr = document.createElement('tr');
                    var td = document.createElement('td');
                    var input = document.createElement('select');
                    var option = document.createElement('option');
                    option.value = 1;
                    option.innerHTML = "Pfizer";
                    input.append(option);

                    option = document.createElement('option');
                    option.value = 2;
                    option.innerHTML = "Moderna";
                    input.append(option);


                    option = document.createElement('option');
                    option.value = 3;
                    option.innerHTML = "AstraZeneca";
                    input.append(option);

                    option = document.createElement('option');
                    option.value = 4;
                    option.innerHTML = "Johnson & Johnson";
                    input.append(option);

                    input.value = stateHistorical[i]["vID"];
                    input.disabled = true;
                    td.append(input)
                    tr.append(td);

                    td = document.createElement('td');
                    input = document.createElement('input');
                    input.size = "3";
                    input.value = stateHistorical[i]["nInjections"];
                    td.append(input)
                    tr.append(td);

                    td = document.createElement('td');
                    input = document.createElement('input');
                    input.value = stateHistorical[i]["nInfections"];
                    input.size = "3";
                    td.append(input)
                    tr.append(td);

                    td = document.createElement('td');
                    input = document.createElement('input');
                    input.value = stateHistorical[i]["nDeaths"];
                    input.size = "3";
                    td.append(input)
                    tr.append(td);

                    td = document.createElement('td');
                    input = document.createElement('input');
                    input.value = stateHistorical[i]["updatedDate"];
                    input.size = "10";
                    input.disabled = true;
                    td.append(input)
                    tr.append(td);
                    table.append(tr);
                }


            }
            xhttp3.open("GET", "countryQueries.php?id=" + button2 + "&method=display&type=stateHistorical", true);
            xhttp3.send();

        }
        xhttp.open("GET", "countryQueries.php?id=" + button2 + "&method=display&type=state", true);
        xhttp.send();

        document.getElementById("stateModal").style.display = 'block';
    });
}

function newCData() {
    var table = document.getElementById('historicalCountry');
    var tr = document.createElement('tr');
    var td = document.createElement('td');
    var input = document.createElement('input');
    td.append(input)
    tr.append(td);
    td = document.createElement('td');
    input = document.createElement('input');
    td.append(input)
    tr.append(td);
    td = document.createElement('td');
    tr.append(td);

    input = document.createElement('input');
    input.disabled = true;
    td.append(input)
    tr.append(td);


    table.append(tr);
}

function newSData() {
    var table = document.getElementById('historicalState');
    var tr = document.createElement('tr');
    var td = document.createElement('td');
    var input = document.createElement('select');
    var option = document.createElement('option');
    option.value = 1;
    option.innerHTML = "Pfizer";
    input.append(option);

    option = document.createElement('option');
    option.value = 2;
    option.innerHTML = "Moderna";
    input.append(option);


    option = document.createElement('option');
    option.value = 3;
    option.innerHTML = "AstraZeneca";
    input.append(option);

    option = document.createElement('option');
    option.value = 4;
    option.innerHTML = "Johnson & Johnson";
    input.append(option);

    input.value = 1;
    td.append(input)
    tr.append(td);

    td = document.createElement('td');
    input = document.createElement('input');
    input.size = "3";
    input.value = "";
    td.append(input)
    tr.append(td);

    td = document.createElement('td');
    input = document.createElement('input');
    input.value = "";
    input.size = "3";
    td.append(input)
    tr.append(td);

    td = document.createElement('td');
    input = document.createElement('input');
    input.value = "";
    input.size = "3";
    td.append(input)
    tr.append(td);

    td = document.createElement('td');
    input = document.createElement('input');
    input.value = "";
    input.size = "10";
    input.disabled = true;
    td.append(input)
    tr.append(td);
    table.append(tr);
}

function editState() {
    var table = document.getElementById("historicalState");
    var selects = table.getElementsByTagName("select");
    var inputs = table.getElementsByTagName("input");
    var i = 0;
    var j = 0
    var k = 0
    const data = [];
    while (i < inputs.length) {
        temp = {
            vID: selects[k].value
        };
        k++;

        temp.nInjections = inputs[i].value;
        i++;

        temp.nInfections = inputs[i].value;
        i++;
        temp.nDeaths = inputs[i].value;
        i++;

        temp.updatedDate = inputs[i].value;
        i++;
        data[j] = temp;
        j++;
    }

    let editstate = {
        pstID: document.getElementById('pstID').innerHTML,
        pstName: document.getElementById("sname").value,
        cID: document.getElementById("country").value,
        data: data
    };

    console.log(editstate);

    var url = "countryQueries.php?";
    url = url.concat("id=", editstate.pstID, "&method=editS");


    var xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.send(JSON.stringify(editstate));
    document.getElementById("stateModal").style.display = 'none';
}

function editCountry() {
    var table = document.getElementById("historicalCountry");
    var inputs = table.getElementsByTagName("input");
    var i = 0;
    var j = 0
    const data = [];
    while (i < inputs.length) {
        if (inputs[i].value == "") {
            continue;
        }
        temp = {
            population: inputs[i].value
        };
        i++;
        if (inputs[i].value == "") {
            continue;
        }
        temp.nDeaths = inputs[i].value;
        i++;
        temp.updatedDate = inputs[i].value;
        i++;
        data[j] = temp;
        j++;
    }


    let editcountry = {
        cID: document.getElementById('cID').innerHTML,
        cName: document.getElementById("cname").value,
        govAgID: document.getElementById("government").value,
        state: document.getElementById("state").value,
        data: data
    };

    var url = "countryQueries.php?";
    if (document.getElementById('operation').innerHTML == "edit") {
        url = url.concat("id=", editcountry.cID, "&method=edit");
    } else {
        url = url.concat("id=", editcountry.cID, "&method=create");
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.send(JSON.stringify(editcountry));
    document.getElementById("countryModal").style.display = 'none';
}


function createCountry(rID) {
    var table = document.getElementById("historicalCountry");
    while (table.firstChild) {
        table.removeChild(table.lastChild);
    }
    var tr = document.createElement('tr');
    var th = document.createElement('th');
    th.innerHTML = "Population";
    tr.append(th);
    th = document.createElement('th');
    th.innerHTML = "Deaths";
    tr.append(th);
    th = document.createElement('th');
    th.innerHTML = "Updated Date";
    tr.append(th);
    th = document.createElement('th');
    tr.append(th);
    table.append(tr);

    document.getElementById("countryModal").style.display = 'block';
    document.getElementById("government").value = "";
    document.getElementById('cID').innerHTML = rID;
    document.getElementById("cname").value = "";
    document.getElementById("government").value = "";
    document.getElementById("state").value = "";
    document.getElementById("delete").style.display = 'none';
    document.getElementById("operation").innerHTML = "create";
}


function deleteCountry() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        console.log(this.responseText);
    }
    var cID = document.getElementById("cID").innerHTML;
    xhttp.open("GET", "countryQueries.php?id=" + cID + "&method=delete", true);
    xhttp.send();
    document.getElementById("countryModal").style.display = 'none';
}

function deleteState() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        console.log(this.responseText);
    }
    var pstID = document.getElementById("pstID").innerHTML;
    xhttp.open("GET", "countryQueries.php?id=" + pstID + "&method=deleteS", true);
    xhttp.send();
    document.getElementById("stateModal").style.display = 'none';
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