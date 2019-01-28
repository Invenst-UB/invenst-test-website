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
  <div class="form">
    <h1 class="panel-heading" style="color:black;text-align:left">Thank you!</h1>
    <p>Your deposit to the idea bank will be reviewed, and we'll contact you with any additional questions.  Head on back to the <a href="index.html">Inve[n|s]tUB home page</p>

  </div>
</body>
</html>

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


// read the values from the request

  $name = $_REQUEST['name'];
  $email = $_REQUEST['email'];
  $relationship = $_REQUEST['relationship'];
  $idea = $_REQUEST['idea'];
  $succeed = $_REQUEST['succeed'];
  $team = $_REQUEST['team'];


  // only do the insert if they are non empty
  if (!empty($name)){
    $sql = "INSERT INTO idea_bank (submitter_name, submitter_email, submitter_relationship, idea_description, idea_resources, idea_team) VALUES (?,?,?,?,?,?);";
    $statement = $conn->prepare($sql);
    $statement->execute([$name, $email, $relationship, $idea, $succeed, $team]);
  }

$conn = null;
?>
