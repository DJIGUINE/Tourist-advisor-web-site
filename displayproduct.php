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

mysql_select_db($database_tourisme, $tourisme);
$query_Recordpro = "SELECT * FROM purchaseproduct";
$Recordpro = mysql_query($query_Recordpro, $tourisme) or die(mysql_error());
$row_Recordpro = mysql_fetch_assoc($Recordpro);
$totalRows_Recordpro = mysql_num_rows($Recordpro);$colname_Recordpro = "-1";
if (isset($_POST['name'])) {
  $colname_Recordpro = $_POST['name'];
}
mysql_select_db($database_tourisme, $tourisme);
$query_Recordpro = sprintf("SELECT * FROM purchaseproduct WHERE customernameidfk = %s", GetSQLValueString($colname_Recordpro, "text"));
$Recordpro = mysql_query($query_Recordpro, $tourisme) or die(mysql_error());
$row_Recordpro = mysql_fetch_assoc($Recordpro);
$totalRows_Recordpro = mysql_num_rows($Recordpro);

$colname_Recordset1 = "-1";
if (isset($_POST['customernamefk'])) {
  $colname_Recordset1 = $_POST['customernamefk'];
}
mysql_select_db($database_tourisme, $tourisme);
$query_Recordset1 = sprintf("SELECT bookingcar_id, car_idfk, customernamefk, bookFROM, to_, number_Day, adressemail FROM carbooking WHERE customernamefk = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $tourisme) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

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
<title>display</title>
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
  <li><a href="customerpurshace.php">Buy</a></li>
  <li><a href="editpurshase.php">Edit </a>  </li>
  <li><a href="custgalleryproduct.php">Gallery  </a></li>
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
<p>&nbsp;</p>
<?php if ($totalRows_Recordpro > 0) { // Show if recordset not empty ?>
  <p align="center">
  <div align="center">
    <h1>Search Booking</h1>
    <h1>Please write your full name </h1>
  </div>
  <form id="form1" name="form1" method="post" action="displayproduct.php">
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
  </form>
  </p>
  <p align="center">
  <div align="center">
    <h1> Booking View</h1>
  </div>
  <div align="center">
    <table width="718" border="1">
      <tr>
        <td width="73" height="30"><div align="center">ID BOOKING</div></td>
        <td width="73"><div align="center">product id</div></td>
        <td width="73"><div align="center">Name</div></td>
        <td width="76"><div align="center">Date</div></td>
        <td width="120"><div align="center">Quantity</div></td>
        <td width="120"><div align="center">Email</div></td>
        <td colspan="2"><div align="center"></div></td>
      </tr>
      <tr>
        <td><?php echo $row_Recordpro['purchase_id']; ?></td>
        <td><?php echo $row_Recordpro['product_idfk']; ?></td>
        <td><?php echo $row_Recordpro['customernameidfk']; ?></td>
        <td><?php echo $row_Recordpro['purchasedate']; ?></td>
        <td><?php echo $row_Recordpro['Quantity']; ?></td>
        <td><?php echo $row_Recordpro['adress_email']; ?></td>
        <td width="67"><a href="custupdateprodu.php?purchase_id=<?php echo $row_Recordpro['purchase_id']; ?>">Update</a></a></a></td>
        <td width="64"><a href="deleteproduct.php?purchase_id=<?php echo $row_Recordpro['purchase_id']; ?>">Delete</a></td>
      </tr>
    </table>
    <p>&nbsp;</p>
  </div>
  <?php } // Show if recordset not empty ?>
<h1 align="center">&nbsp;</h1>
<div align="center" id="body2">
<?php if ($totalRows_Recordpro == 0) { // Show if recordset empty ?>
  <h1 align="center">please enter good information</h1>
  <?php } // Show if recordset empty ?>
  </div>
  </div>
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
mysql_free_result($Recordpro);
?>
