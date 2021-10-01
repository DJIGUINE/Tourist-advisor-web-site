<?php require_once('Connections/tourisme.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "homepage.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "customer";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_Rerecord = "-1";
if (isset($_POST['name'])) {
  $colname_Rerecord = $_POST['name'];
}
mysql_select_db($database_tourisme, $tourisme);
$query_Rerecord = sprintf("SELECT * FROM hotelbooking WHERE customernamefk = %s", GetSQLValueString($colname_Rerecord, "text"));
$Rerecord = mysql_query($query_Rerecord, $tourisme) or die(mysql_error());
$row_Rerecord = mysql_fetch_assoc($Rerecord);
$totalRows_Rerecord = mysql_num_rows($Rerecord);

$colname_Rerecord = "-1";
if (isset($_POST['name'])) {
  $colname_Rerecord = $_POST['name'];
}
mysql_select_db($database_tourisme, $tourisme);
$query_Rerecord = sprintf("SELECT * FROM hotelbooking WHERE customernamefk = %s", GetSQLValueString($colname_Rerecord, "text"));
$Rerecord = mysql_query($query_Rerecord, $tourisme) or die(mysql_error());
$row_Rerecord = mysql_fetch_assoc($Rerecord);

$colname_Ruser = "-1";
if (isset($_GET['customername'])) {
  $colname_Ruser = $_GET['customername'];
}
mysql_select_db($database_tourisme, $tourisme);
$query_Ruser = sprintf("SELECT * FROM customer WHERE customername LIKE %s ORDER BY customer_id ASC", GetSQLValueString("%" . $colname_Ruser . "%", "text"));
$Ruser = mysql_query($query_Ruser, $tourisme) or die(mysql_error());
$row_Ruser = mysql_fetch_assoc($Ruser);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>display booking</title>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet"   href="footer.css" type="text/css" />
<link rel="stylesheet" href="styles.css">
<style type="text/css">
.SORRY {
	color: #F00;
}
</style>
</head>

<body>
<div align="center">
  <h1>AVELON TRIP ADVISOR</h1>
  <p>&nbsp;</p>
</div>
<p align="center"><img src="images/86690725-belle-chute-d-eau-sala-près-de-labe-avec-des-arbres-piscine-verte-et-beaucoup-d-écoulement-de-l-39.jpg" onmouseover="this.src='images/1200x630_100_300_000000x30x0.jpg'  " width="1161" height="450" /></p>
<ul id="MenuBar1" class="MenuBarHorizontal">
  <li><a href="customerview.php">Home page</a></li>
  <li><a href="customerhotelbooking.php">Booking Hotel</a></li>
  <li><a href="custedithotelbooking.php">Edit booking</a>  </li>
  <li><a href="custgalleryhotel.php">Gallery hotel </a></li>
  <li><a href="<?php echo $logoutAction ?>">log out</a></li>
</ul>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div align="center" id="body">
<p align="center">
  <?php if ($totalRows_Rerecord > 0) { // Show if recordset not empty ?>
<div align="center">
  <h1>Search Booking</h1>
  <h1>Please write your full name </h1>
</div>
<form id="form1" name="form1" method="post" action="displayhotelreshearbooking.php">
  <div align="center">
    <table width="200" border="0">
      <tr>
        <td>search</td>
        <td><label for="name"></label>
          <input type="text" name="name" id="name" /></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td><div align="center">
          <input type="submit" name="btnsearch" id="btnsearch" value="search" />
          </div></td>
        </tr>
      </table>
    <p>&nbsp;</p>
    </div>
</form></p> 
<p align="center">
  
<div align="center">
  <h1> Booking View</h1>
</div>
<div align="center">
  <table width="923" border="1">
    <tr>
      <td width="73">ID BOOKING</td>
      <td width="73">Room id</td>
      <td width="73">Name</td>
      <td width="76">Book_From</td>
      <td width="73">UP_To__</td>
      <td width="120">Number of day</td>
      <td width="120">Number  Room</td>
      <td width="120">Email</td>
      <td colspan="2">&nbsp;</td>
      </tr>
    <tr>
      <td><?php echo $row_Rerecord['booking_id']; ?></td>
      <td><?php echo $row_Rerecord['room_id_fk']; ?></td>
      <td><?php echo $row_Rerecord['customernamefk']; ?></td>
      <td><?php echo $row_Rerecord['bookFROM']; ?></td>
      <td><?php echo $row_Rerecord['to_']; ?></td>
      <td><?php echo $row_Rerecord['number_day']; ?></td>
      <td><?php echo $row_Rerecord['numberrome']; ?></td>
      <td><?php echo $row_Rerecord['adress_emailfk']; ?></td>
      <td width="67"><a href="customerupdatehotelboking.php?booking_id=<?php echo $row_Rerecord['booking_id']; ?>">Update</a></a></a></td>
      <td width="64"><a href="deletehotelbooking.php?booking_id=<?php echo $row_Rerecord['booking_id']; ?>">Delete</a></td>
      </tr>
    </table>
  <p>&nbsp;</p>
</div>
<?php } // Show if recordset not empty ?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div align="center" id="body2">
<?php if ($totalRows_Rerecord == 0) { // Show if recordset empty ?>
  <h1>please enter good information</h1>
  <?php } // Show if recordset empty ?>
  </div>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>

<div align="center" id="footer">
  <h1>&nbsp;</h1>
  <h1>&nbsp;</h1>
  <h1>LET'S GET SOCIALL</h1>
  <h3>FOLOW US ON YOUTUBE ON INSTAGRAME OR BECOME OUR FRIEND ON FACBOOK   </h3>
  <p>&nbsp;</p>
  <table width="200" border="0">
    <tr>
      <td height="267"><p><a href="https://www.youtube.com/channel/UCAd-iarQzJ2jZ7qghS7TD-Q"><img src="images/index.png" width="99" height="100" alt="facebook" /></a></p></td>
      <td><a href="https://www.instagram.com/ansdjiguine/"><img src="images/QVxuHzpM_400x4001.png" width="100" height="100" alt="ins" /></a></td>
      <td><a href="https://www.facebook.com/ansoumane.djiguine"><img src="images/facebook-icon-white-logo-png-transparent.png" width="96" height="100" alt="t" /></a></td>
    </tr>
  </table>
  
</div>
<?php echo $row_Ruser['']; ?>

<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
</html>
<?php
mysql_free_result($Rerecord);
?>
