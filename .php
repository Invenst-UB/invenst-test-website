<!DOCTYPE html>
<html lang="en">
<head>
  <title>Invenst</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href='https://fonts.googleapis.com/css?family=Roboto+Slab' rel='stylesheet' type='text/css'>
 <link href='https://fonts.googleapis.com/css?family=Courgette' rel='stylesheet' type='text/css'>
 <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
 <link href='https://fonts.googleapis.com/css?family=Nothing+You+Could+Do' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="teststyle.css">
</head>
<body>
<div class="banner">The Idea Bank</div>
  <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for ideas..">
  <input type="image" id="imageTag" src="Idea Bank Icons\Alexa Icon.png" width="40px;" height="40px;">
  <input type="image" id="imageTag" src="Idea Bank Icons\Chrome Icon.png" width="40px;" height="40px;">
  <input type="image" id="imageTag" src="Idea Bank Icons\Financial Icon.png" width="40px;" height="40px;">
  <input type="image" id="imageTag" src="Idea Bank Icons\Hardware Icon.png" width="40px;" height="40px;">
  <input type="image" id="imageTag" src="Idea Bank Icons\Health Icon.png" width="40px;" height="40px;">
  <input type="image" id="imageTag" src="Idea Bank Icons\Internet of Things Icon.png" width="40px;" height="40px;">
  <input type="image" id="imageTag" src="Idea Bank Icons\Mobile Icon.png" width="40px;" height="40px;">
  <input type="image" id="imageTag" src="Idea Bank Icons\University Icon.png" width="40px;" height="40px;">
  <input type="image" id="imageTag" src="Idea Bank Icons\Wearable Icon.png" width="40px;" height="40px;">
  <input type="image" id="imageTag" src="Idea Bank Icons\Web Icon.png" width="40px;" height="40px;">
 <table id="myTable" align="right">
   <tr class="header">
     <th class="headerName" style="width:20%;">Idea</th>
     <th class="headerName" style="width:10%;">Type</th>
     <!-- <th class="headerName" style="width:40%;">People Working</th> -->
   </tr>
<?php
function IsNullOrEmpty($question){
    return (!isset($question) || trim($question)==='');
}
ini_set('display_errors', 1); error_reporting(-1);

$configfile = "connect.cfg";

$myfile = fopen($configfile, "r") or die("Unable to open file!");
$line = trim(fgets($myfile));
parse_str($line, $config);
fclose($myfile);

$servername = $config['servername'];
$username = $config['username'];
$password = $config['password'];
$dbname = $config['dbname'];
$conn = null;
// Create connection
try{
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e){
  echo "connection error";
}

$sql = "SELECT * FROM idea_bank where idea_status = 'APPROVED'";
$result = $conn->query($sql);


foreach($result as $row ) {

?> 
 <?php

$resources = "";
$team = "";
if (!IsNullOrEmpty($row["idea_resources"])){
  $resources = "<p><em>What might the team need to succeed?</em><br>".$row["idea_resources"]."</p>";
}
if (!IsNullOrEmpty($row["idea_team"])){
 $team = "<p><em>What sort of team will it take?</em><br>".$row["idea_team"]."</p>";
}
echo "<tr><td><div class=\"container\"><button class=\"view\"><img src=\"invenst3.PNG\" class=\"circlecrop\" style=\"float:left;display:inline-block;\" width=\"50px;\" height=\"50px;\"><i class=\"fa fa-fw fa-chevron-down\" style=\"float:right;display:inline-block;\" width=\"50px;\" height=\"50px;\"></i><h2>".$row["idea_name"]."<h2></button> <div class=\"fold\">
<p>".$row["idea_description"]."</p>".$resources.$team."<a class=\"getstarted\" href=\"https://docs.google.com/forms/d/e/1FAIpQLSdiT9sDnfxA61PEsG4-HcMIieiIj5tpLn-ThlE41pGrbOSD9Q/viewform?entry.972833926=".$row["idea_name"]."\"> I'm Interested!</a></div></div></td>";

}
?>

<?php
    $taglist = array();
    if (!IsNullOrEmpty($row["tag_list"])){
    $taglist = str_getcsv($row["tag_list"]);
      foreach ($taglist as $tag){
          echo "<td><img src=".$tag.".png id=\"web\" width=\"30px;\" height=\"30px;\"></td></tr>";
      }
    }else{
      echo "</tr>"
    }

 $conn = null;
?>
</div>
</body>
<script src="testscript.js"></script>
</html>