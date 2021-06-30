<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
<title>Visualization</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/A.style.css.pagespeed.cf.1tIFcJt0BJ.css">
<link rel="icon" type="image/png" sizes="16x16" href="../img/logo.ico">
</head>
<body>
<?php
define("PATH_TO_SQLITE_FILE", $_SESSION['path_to_already_existing_ichnion_db']);
$pdo = new PDO('sqlite:' . PATH_TO_SQLITE_FILE);
$choice = "activity_details";
if (isset($_POST['table_selected']))
{
    $choice = $_POST['table_selected'];
}
$statement = $pdo->query("SELECT * FROM $choice");
$countquery = $pdo->query("SELECT COUNT(*) FROM $choice");
$resultcount = $countquery->fetch();
$count = $resultcount[0];
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);
$tables_names = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' ORDER BY name");
$tables_names_array = $tables_names->fetchAll(PDO::FETCH_COLUMN);
?>
<div class="center">
    <h1>Here is your data !</h1> 
    <div>
        <form id=category method="POST">
            <select name="table_selected" id="table_selected">
                <?php
for ($j = 0;$j < count($tables_names_array);$j++)
{
    echo "<option> $tables_names_array[$j] </option>";
}
?>
            </select>
            <input id ="button" type="submit" name="show" value="Show category" />
        </form>
    </div>
    <?php
if ($choice == "facebook_location_history" || $choice == "google_location_history")
{
    echo '
    <form id="maps" method="POST" action="/php/map.php" target="_blank">
    <input id ="button" type="submit" name="showMap" value="Show Map" />
    </form>';
}
?>
    <?php echo "<p>Data shown : $choice <p>";
$colnames = array();

$stmt = $pdo->prepare("SELECT sql FROM sqlite_master WHERE tbl_name = '$choice'");
$stmt->execute();
$row = $stmt->fetch();
$sql = $row[0];
$r = preg_match("/\(\s*(\S+)[^,)]*/", $sql, $m, PREG_OFFSET_CAPTURE);
while ($r)
{
    array_push($colnames, $m[1][0]);
    $r = preg_match("/,\s*(\S+)[^,)]*/", $sql, $m, PREG_OFFSET_CAPTURE, $m[0][1] + strlen($m[0][0]));
}
?>
    <table>
    <?php
$lines = "";
echo "<tr>";
if ($choice == "activity_details" || $choice == "activity_location_info" || $choice == "google_location_history" || $choice == "activity_product" || $choice == "sub_title" || $choice == "google_my_activity" || $choice == "google_saved_places")
{
    for ($k = 0;$k < count($colnames) - 1;$k++)
    {
        echo "<td>$colnames[$k]</td>";
    }
}
else
{
    for ($k = 0;$k < count($colnames);$k++)
    {
        echo "<td>$colnames[$k]</td>";
    }
}
echo "<tr>";
if ($choice != "facebook_location_history" && $choice != "google_location_history")
{
    for ($i = 0;$i < $count;$i++)
    {
        for ($k2 = 0;$k2 < count($colnames) - 1;$k2++)
        {
            $lines .= '<td>' . $rows[$i][$colnames[$k2]] . '</td>';
        }
        echo "<tr>" . $lines . "</tr>";
        $lines = "";
    }
}
if ($choice == "facebook_location_history")
{
    for ($i = 0;$i < $count;$i++)
    {
        for ($k2 = 0;$k2 < count($colnames);$k2++)
        {
            if ($colnames[$k2] == "time")
            {
                $timestamp = intval($rows[$i][$colnames[$k2]]);
                $lines .= '<td>' . gmdate("Y-m-d\TH:i:s\Z", $timestamp) . '</td>';
            }
            else
            {
                $lines .= '<td>' . $rows[$i][$colnames[$k2]] . '</td>';
            }
        }
        echo "<tr>" . $lines . "</tr>";
        $lines = "";
        $_SESSION['latitude'][] = $rows[$i]['latitude'];
        $_SESSION['longitude'][] = $rows[$i]['longitude'];
        $_SESSION['time'][] = $rows[$i]['time'];
        $_SESSION['name'][] = $rows[$i]['name'];
    }
}
if ($choice == "google_location_history")
{
    for ($i = 0;$i < $count;$i++)
    {
        for ($k2 = 0;$k2 < count($colnames) - 1;$k2++)
        {
            if ($colnames[$k2] == "timestamp_msec")
            {
                $timestamp = intval($rows[$i][$colnames[$k2]] / 1000);
                $lines .= '<td>' . gmdate("Y-m-d TH: i:s ", $timestamp) . '</td>';
            }
            else
            {
                $lines .= '<td>' . $rows[$i][$colnames[$k2]] . '</td>';
            }
        }
        echo "<tr>" . $lines . "</tr>";
        $lines = "";
        $_SESSION['latitude'][] = $rows[$i]['lat'];
        $_SESSION['longitude'][] = $rows[$i]['lng'];
        $_SESSION['time'][] = $rows[$i]['timestamp_msec'] / 1000;
        $_SESSION['name'][] = "";
    }
}
?>
        </table>
</div>
</body>
<style>
    @import url("https://fonts.googleapis.com/css2?family=Sansita+Swashed:wght@600&display=swap");
table {
        border-spacing: 50px 8px;
}

body {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  display: flex;
  justify-content: center;
  align-items: center;
  background: linear-gradient(45deg, greenyellow, dodgerblue);
  font-family: "Sansita Swashed", cursive;
  margin-left: 10px;
}
.center {
  position: relative;
  padding: 50px 50px;
  background: #fff;
  border-radius: 10px;
  width: 100%;
}
.center h1 {
  font-size: 2em;
  border-left: 5px solid dodgerblue;
  padding: 10px;
  color: #000;
  letter-spacing: 5px;
  margin-bottom: 60px;
  font-weight: bold;
  padding-left: 10px;
}


    </style>
</html>
