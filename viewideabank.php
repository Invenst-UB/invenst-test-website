<!DOCTYPE html>
<html lang="en">
<head>
  <title>Invenst Idea Bank</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet" type="text/css">
 <link href="https://fonts.googleapis.com/css?family=Courgette" rel="stylesheet" type="text/css">
 <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
 <link href="https://fonts.googleapis.com/css?family=Nothing+You+Could+Do" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="Invenst-Idea-Bank\Invenststyle.css">
</head>
<body>
<div class="banner">The Idea Bank</div>
  <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for ideas..">
  <div class="tagsDiv">

  <?
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
$tags=array();

foreach($result as $row ) {
  $tagarrayLength=0;
  $taglist = array();
  if (!IsNullOrEmpty($row["tag_list"])){
    $taglist = str_getcsv($row["tag_list"]);
    $tagarrayLength=count($taglist);
    for($j=0;$j<$tagarrayLength;$j++){
      $tagName=trim($taglist[$j]);
      if(!in_array($tagName,$tags)){
        array_push($tags,$tagName);
      }
    }
  }
}

$CurrentTags=array("Alexa","Chrome","Financial","Hardware","Health","IOT","Mobile","University","Wearable","Web");

for($j=0;$j<count($tags);$j++){
  $tagName=trim($tags[$j]);
  $fileloc="Invenst-Idea-Bank/Idea Bank Icons/".$tagName.".png";
  if(file_exists($fileloc)){
  echo "<input type=\"image\" id=\"$tagName\" src=\"$fileloc\" width=\"40px;\" height=\"40px;\" onclick=\"filter(this.id)\" title=\"$tagName\" hspace=\"2\">";
  }else{
    $words=str_word_count($tagName,1);
    $rowTagName=$tagName[0];
    $size=count($words);
    if($size>1){
      $rowTagName="";
      foreach($words as $val){
        $rowTagName.=$val[0];
      }
    }
    else if(strlen($tagName)==2){
      $rowTagName=$tagName;
    }
    echo "<input type=\"button\" class=\"tableTag\" id=\"$tagName\" title=\"$tagName\" value=\"$rowTagName\" onclick=\"filter(this.id)\" hspace=\"2\">";
    // echo "<div class=\"noImageTag\" margin-right=\"5\" float:left><span>".$tagName."</span></div>";    
  }
}

for($k=0;$k<count($CurrentTags);$k++){
  $loc="Invenst-Idea-Bank/Idea Bank Icons/".$CurrentTags[$k].".png";
  if(!in_array($CurrentTags[$k],$tags)){
  echo "<input type=\"image\" id=\"$CurrentTags[$k]\" src=\"$loc\" width=\"40px;\" height=\"40px;\" onclick=\"filter(this.id)\" title=\"$CurrentTags[$k]\" hspace=\"2\">";
  }
}

?>

</div>
 <table id="myTable" align="right">
   <tr class="header">
     <th class="headerName" style="width:20%;">Idea</th>
     <th class="headerName" style="width:10%;">Type</th>
     <!-- <th class="headerName" style="width:40%;">People Working</th> -->
   </tr>

<?php
$sql = "SELECT * FROM idea_bank where idea_status = 'APPROVED'";
$result = $conn->query($sql);
foreach($result as $row ) {

$resources = "";
$team = "";
$noTag=FALSE;
$tagarrayLength=0;
$taglist = array();

if (!IsNullOrEmpty($row["tag_list"])){
$taglist = str_getcsv($row["tag_list"]);
$tagarrayLength=count($taglist);
}else{
  $noTag=TRUE;
}

if (!IsNullOrEmpty($row["idea_resources"])){
  $resources = "<p><em>What might the team need to succeed?</em><br>".$row["idea_resources"]."</p>";
}
if (!IsNullOrEmpty($row["idea_team"])){
 $team = "<p><em>What sort of team will it take?</em><br>".$row["idea_team"]."</p>";
}
echo "<tr><td><div class=\"container\"><button class=\"view\"><img src=\"Invenst-Idea-Bank\invenst3.PNG\" class=\"circlecrop\" style=\"float:left;display:inline-block;\" width=\"50px;\" height=\"50px;\"><i class=\"fa fa-fw fa-chevron-down\" style=\"float:right;display:inline-block;\" width=\"50px;\" height=\"50px;\"></i><h2>".$row["idea_name"]."</h2></button> <div class=\"fold\">
<p>".$row["idea_description"]."</p>".$resources.$team."<a class=\"getstarted\" href=\"https://docs.google.com/forms/d/e/1FAIpQLSdiT9sDnfxA61PEsG4-HcMIieiIj5tpLn-ThlE41pGrbOSD9Q/viewform?entry.972833926=".$row["idea_name"]."\"> I'm Interested!</a></div></div></td><td>";

echo "<div class=\"tableTagsContainer\">";
      for($i=0; $i<$tagarrayLength; $i++){
        $rowTagExt="Invenst-Idea-Bank/Idea Bank Icons/".trim($taglist[$i]).".png";
        $rowTag=trim($taglist[$i]);
        if($i==$tagarrayLength-1){
          if(file_exists($rowTagExt)){
            echo "<img src=\"$rowTagExt\" id=\"rowTag\" width=\"42px;\" height=\"42px;\" title=\"$rowTag\"></td></tr>";
          }
          else{
            $words=str_word_count($rowTag,1);
            $rowTagName=$rowTag[0];
            $size=count($words);
            if($size>1){
              $rowTagName="";
              foreach($words as $val){
                $rowTagName.=$val[0];
              }
            }
            else if(strlen($rowTag)==2){
              $rowTagName=$rowTag;
            }
            echo "<div class=\"noImageTag\" title=\"$rowTag\"><span>".$rowTagName."</span></div></td></tr>";
          }
        // echo "<div>".$rowTagExt."</div></td></tr>";
        }else{
          if(file_exists($rowTagExt)){
            echo "<img src=\"$rowTagExt\" id=\"rowTag\" width=\"42px;\" height=\"42px;\" title=\"$rowTag\" margin-right=\"10\">";
          }
          else{
            $words=str_word_count($rowTag,1);
            $rowTagName=$rowTag[0];
            $size=count($words);
            if($size>1){
              $rowTagName="";
              foreach($words as $val){
                $rowTagName.=$val[0];
              }
            }
            else if(strlen($rowTag)==2){
              $rowTagName=$rowTag;
            }
            echo "<div class=\"noImageTag\" title=\"$rowTag\"><span>".$rowTagName."</span></div>";
          }
          // echo "<div>".$rowTagExt."</div>";
        }
      }
      if($noTag){
        echo "No Tags";
      }
    echo "</div></td></tr>";
}

?>
</table>
</body>
<script src="Invenst-Idea-Bank\ideaBankScript.js"></script>
</html>