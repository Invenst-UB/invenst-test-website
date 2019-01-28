<!DOCTYPE html>
<html lang="en">
<head>
  <title>Invenst</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href='https://fonts.googleapis.com/css?family=Roboto+Slab' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Courgette' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Nothing+You+Could+Do' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="invenst.css">

</head>
<body>



  <div class="row">
    <h1 style="padding:20px;color:black;text-align:left;">The Project Place</h1>
<?php

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

$sql = "SELECT * FROM idea_bank where idea_status = 'IN_PROGRESS'";
$result = $conn->query($sql);


foreach($result as $row ) {

?>

  <div class="col-4 col-md-6 col-sm-12">
    <div class="ideawrapper">
    <div class="ideacard">

    <div class="ideaicon"><img src="invenst3.PNG" class="circlecrop" style="float:left;display:inline-block;" width="50px;" height="50px;"></div>
    <div class="ideabody">
    <h2>The Idea</h2><p>

<?php    echo $row["idea_description"]."</p></div></div></div></div>";


}


  $conn = null;
?>
</div>
</body>
</html>
