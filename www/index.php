<?php
session_start();
if (!isset($_SESSION['excavator_path_v5']))
{
    $_SESSION['excavator_path_v5'] = rtrim(shell_exec('dir c:\users\excavator.exe /w/o/s/p/b'));
}
if (isset($_POST["submit3"]))
{
    $_SESSION['path_to_already_existing_ichnion_db'] = $_POST['path_to_already_existing_database'] . "/ichnion.db";
}
?>
<!doctype html>
<html lang="en">
<head>
<title>Ichnion App</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/A.style.css.pagespeed.cf.1tIFcJt0BJ.css">
<link rel="icon" type="image/png" sizes="16x16" href="img/logo.ico">
</head>
<body>
    <?php
set_time_limit(3600);
$value_path_extracted_file = null;
$errs = array();
$errs_existing_db = array();
if (isset($_POST["submit"]))
{
    $value_path_extracted_file = $_POST["extracted_file"];
    $variable3 = $_POST["path_to_ichnion"];
    if (!file_exists($_POST["extracted_file"]))
    {
        $errs["extracted_file"][] = "Your path to your data is invalid";
    }
    if (!file_exists($_POST["path_to_ichnion"]))
    {
        $errs["extracted_file"][] = "Invalid path to store data";
    }
    if (count($errs) == 0 && file_exists($_POST['extracted_file']) && file_exists($_POST['path_to_ichnion']))
    {
        $_SESSION['database_path'] = $_POST['path_to_ichnion'] . '/ichnion.db';
        chdir("$variable3");
        $variable = '"' . $_SESSION['excavator_path_v5'] . '"' . " read " . $_POST["extracted_file"];
        $variable2 = "cmd /c " . " " . $variable;
        $oui = exec("$variable2");
    }
}
if (isset($_POST['submit3']) && !file_exists($_POST['path_to_already_existing_database'] . "/ichnion.db"))
{
    $errs_existing_db["path_to_already_existing_database"] = "This file doesn't exist";
}
if (isset($_POST['submit5']))
{
    exec("cmd /c cargo install --git https://github.com/ichnion/excavator --branch develop");
}
?>

<div class="left">
  <h1>Extract</h1>
  <form method="POST" action ="#" id="form1">
    <div class="inputbox">
      <input type="text" name ="extracted_file" id="extracted">
      <span>Path to your data</span>
    </div>
    <div class="inputbox">
      <input type="text" name ="path_to_ichnion" id="path_to_ichnion">
      <span>Path where data will be stored</span>
    </div>
    <div class="inputbox">
      <input id ="button" type="submit" name="submit" value="Excavate" />   
    </div>
    </form>
    <?php
if (count($errs) != 0)
{
    echo "<div id='divError'>";
    foreach ($errs as $fieldError)
    {
        foreach ($fieldError as $error)
        {
            echo "<li>$error</br></li>";
        }
        echo "</div>";
    }
}
else if (isset($_POST["extracted_file"]))
{
    echo '<form method="POST" action="/php/visualize.php" target="_blank" id="form2">
    <div class="inputbox">
      <input id ="button" type="submit" name="submit2" value="Visualize" /> 
    </div>
  </form>';
}
?>
</div>
<div class="top-right">
  <h1>Install or update Excavator</h1>
  <form method="POST" action ="#" id="form5">
    <div class="inputbox">
      <input id ="button" type="submit" name="submit5" value="Install or update" />   
    </div>
    </form>
</div>
<div class="right">
  <h1>Already-existing database</h1>
  <form method="POST" action =# id="form3">
    <div class="inputbox">
      <input type="text" name ="path_to_already_existing_database" id="path_to_already_existing_database">
      <span>Path to your database</span>
    </div>
    <div class="inputbox">
      <input id ="button" type="submit" name="submit3" value="Upload" />   
    </div>
    </form>
      <?php if (count($errs_existing_db) != 0)
{
    echo "<div id='divError'>";
    foreach ($errs_existing_db as $fieldError)
    {
        echo "<li>$fieldError</br></li>";
    }
    echo "</div>";
} ?>
    <?php
if (isset($_POST["submit3"]) && file_exists($_POST['path_to_already_existing_database']))
{
    echo '<form method="POST" action="/php/visualize_existing_database.php" target="_blank" id="form4">
    <div class="inputbox">
      <input id ="button" type="submit" name="submit4" value="Visualize" /> 
    </div> 
  </form>';
}
?>
</div>
</body>

<style>
    @import url("https://fonts.googleapis.com/css2?family=Sansita+Swashed:wght@600&display=swap");
body {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background: linear-gradient(45deg, greenyellow, dodgerblue);
  font-family: "Sansita Swashed", cursive;
}
.left {
  position: relative;
  padding: 50px 50px;
  background: #fff;
  border-radius: 10px;
  margin-right: 200px;
}
.left h1 {
  font-size: 2em;
  border-left: 5px solid dodgerblue;
  padding: 10px;
  color: #000;
  letter-spacing: 5px;
  margin-bottom: 60px;
  font-weight: bold;
  padding-left: 10px;
}
.left .inputbox {
  position: relative;
  width: 300px;
  height: 50px;
  margin-bottom: 50px;
}
.left .inputbox input {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  border: 2px solid #000;
  outline: none;
  background: none;
  padding: 10px;
  border-radius: 10px;
  font-size: 1.2em;
}
.left .inputbox:last-child {
  margin-bottom: 0;
}
.left .inputbox span {
  position: absolute;
  top: 14px;
  left: 20px;
  font-size: 1em;
  transition: 0.6s;
  font-family: sans-serif;
}
.left .inputbox input:focus ~ span,
.left .inputbox input:valid ~ span {
  transform: translateX(-13px) translateY(-35px);
  font-size: 1em;
}
.left .inputbox [type="button"] {
  width: 50%;
  background: dodgerblue;
  color: #fff;
  border: #fff;
}
.left .inputbox:hover [type="button"] {
  background: linear-gradient(45deg, greenyellow, dodgerblue);
}
#divError {
    color: red;
    } 
    
.right {
  position: absolute;
  padding: 50px 50px;
  background: #fff;
  border-radius: 10px;
  margin-top: 150px;
  margin-left: 290px;
}
.right h1 {
  font-size: 2em;
  border-left: 5px solid dodgerblue;
  padding: 10px;
  color: #000;
  letter-spacing: 5px;
  margin-bottom: 60px;
  font-weight: bold;
  padding-left: 10px;
}
.right .inputbox {
  position: relative;
  width: 300px;
  height: 50px;
  margin-bottom: 50px;
}   
.right .inputbox input {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  border: 2px solid #000;
  outline: none;
  background: none;
  padding: 10px;
  border-radius: 10px;
  font-size: 1.2em;
}
.right .inputbox:last-child {
  margin-bottom: 0;
}
.right .inputbox span {
  position: absolute;
  top: 14px;
  left: 20px;
  font-size: 1em;
  transition: 0.6s;
  font-family: sans-serif;
}
.right .inputbox input:focus ~ span,
.right .inputbox input:valid ~ span {
  transform: translateX(-13px) translateY(-35px);
  font-size: 1em;
}
.right .inputbox [type="button"] {
  width: 50%;
  background: dodgerblue;
  color: #fff;
  border: #fff;
}
.right .inputbox:hover [type="button"] {
  background: linear-gradient(45deg, greenyellow, dodgerblue);
}

.top-right {
  position: relative;
  padding: 50px 50px;
  background: #fff;
  border-radius: 10px;
  margin-right: 0px;
  margin-top: -490px;
}
.top-right h1 {
  font-size: 2em;
  border-left: 5px solid dodgerblue;
  padding: 10px;
  color: #000;
  letter-spacing: 5px;
  margin-bottom: 60px;
  font-weight: bold;
  padding-left: 10px;
}
.top-right .inputbox {
  position: relative;
  width: 300px;
  height: 50px;
  margin-bottom: 50px;
}
.top-right .inputbox input {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  border: 2px solid #000;
  outline: none;
  background: none;
  padding: 10px;
  border-radius: 10px;
  font-size: 1.2em;
}
.top-right .inputbox:last-child {
  margin-bottom: 0;
}
.top-right .inputbox span {
  position: absolute;
  top: 14px;
  left: 20px;
  font-size: 1em;
  transition: 0.6s;
  font-family: sans-serif;
}
.top-right .inputbox input:focus ~ span,
.top-right .inputbox input:valid ~ span {
  transform: translateX(-13px) translateY(-35px);
  font-size: 1em;
}
.top-right .inputbox [type="button"] {
  width: 50%;
  background: dodgerblue;
  color: #fff;
  border: #fff;
}
.top-right .inputbox:hover [type="button"] {
  background: linear-gradient(45deg, greenyellow, dodgerblue);
}
</style>
</html>