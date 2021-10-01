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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE carbooking SET car_idfk=%s, customernamefk=%s, bookFROM=%s, to_=%s, number_Day=%s, adressemail=%s WHERE bookingcar_id=%s",
                       GetSQLValueString($_POST['car_idfk'], "int"),
                       GetSQLValueString($_POST['customernamefk'], "text"),
                       GetSQLValueString($_POST['bookFROM'], "date"),
                       GetSQLValueString($_POST['to_'], "date"),
                       GetSQLValueString($_POST['number_Day'], "int"),
                       GetSQLValueString($_POST['adressemail'], "text"),
                       GetSQLValueString($_POST['bookingcar_id'], "int"));

  mysql_select_db($database_tourisme, $tourisme);
  $Result1 = mysql_query($updateSQL, $tourisme) or die(mysql_error());

  $updateGoTo = "editcarbookin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_carupdate = "-1";
if (isset($_GET['bookingcar_id'])) {
  $colname_carupdate = $_GET['bookingcar_id'];
}
mysql_select_db($database_tourisme, $tourisme);
$query_carupdate = sprintf("SELECT * FROM carbooking WHERE bookingcar_id = %s", GetSQLValueString($colname_carupdate, "int"));
$carupdate = mysql_query($query_carupdate, $tourisme) or die(mysql_error());
$row_carupdate = mysql_fetch_assoc($carupdate);
$totalRows_carupdate = mysql_num_rows($carupdate);

mysql_select_db($database_tourisme, $tourisme);
$query_Recordset1 = "SELECT * FROM carbooking";
$Recordset1 = mysql_query($query_Recordset1, $tourisme) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

$query_Recordset1 = "SELECT * FROM carbooking";
$Recordset1 = mysql_query($query_Recordset1, $tourisme) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

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
<title>update Booking</title>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet"   href="footer.css" type="text/css" />
<link rel="stylesheet" href="styles.css">
</head>

<body>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div align="center">
  <h1>AVELON TRIP ADVISOR</h1>
  <p>&nbsp;</p>
</div>
<p align="center"><img src="images/86690725-belle-chute-d-eau-sala-près-de-labe-avec-des-arbres-piscine-verte-et-beaucoup-d-écoulement-de-l-39.jpg" onmouseover="this.src='images/1200x630_100_300_000000x30x0.jpg'  " width="1161" height="410" /></p>
<ul id="MenuBar1" class="MenuBarHorizontal">
  <li><a href="customerview.php">Home page</a></li>
  <li><a href="customercarbooking.php">Booking Car</a></li>
  <li><a href="custgallerycar.php">Gallery</a>  </li>
  <li><a href="editcarbookin.php">Edit booking</a></li>
  <li><a href="<?php echo $logoutAction ?>">log out</a></li>
</ul>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div align="center" id="body">
<p align="center">&nbsp;</p>
<h1 align="center">UPDATE BOOKING</h1>
<p align="center">&nbsp;</p>
<form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Bookingcar_id:</td>
      <td><?php echo $row_carupdate['bookingcar_id']; ?></td>
    </tr>
    <tr valign="baseline">
      <td height="31" align="right" nowrap="nowrap">Car_id:</td>
      <td><input type="text" name="car_idfk" value="<?php echo htmlentities($row_carupdate['car_idfk'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td height="40" align="right" nowrap="nowrap">Customername:</td>
      <td><input type="text" name="customernamefk" value="<?php echo htmlentities($row_carupdate['customernamefk'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td height="30" align="right" nowrap="nowrap">BookFROM:</td>
      <td><input type="text" name="bookFROM" value="<?php echo htmlentities($row_carupdate['bookFROM'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td height="32" align="right" nowrap="nowrap">To_:</td>
      <td><input type="text" name="to_" value="<?php echo htmlentities($row_carupdate['to_'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td height="27" align="right" nowrap="nowrap">Number_Day:</td>
      <td><input type="text" name="number_Day" value="<?php echo htmlentities($row_carupdate['number_Day'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td height="27" align="right" nowrap="nowrap">Adressemail:</td>
      <td><input type="text" name="adressemail" value="<?php echo htmlentities($row_carupdate['adressemail'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Update record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form2" />
  <input type="hidden" name="bookingcar_id" value="<?php echo $row_carupdate['bookingcar_id']; ?>" />
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p align="center"></p>

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
mysql_free_result($carupdate);
?>
