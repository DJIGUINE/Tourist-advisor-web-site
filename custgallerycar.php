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
$query_Recordset1 = "SELECT * FROM hotelbooking";
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
<title>Gallery car</title>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet"   href="footer.css" type="text/css" />
<link rel="stylesheet" href="styles.css">
<script src="SpryAssets/SpryEffects.js" type="text/javascript"></script>
<script type="text/javascript">
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
function MM_effectAppearFade(targetElement, duration, from, to, toggle)
{
	Spry.Effect.DoFade(targetElement, {duration: duration, from: from, to: to, toggle: toggle});
}
function MM_effectShake(targetElement)
{
	Spry.Effect.DoShake(targetElement);
}
</script>

</head>

<body onload="MM_preloadImages('images/images/img_5dbab51ef234a.png','mages/calendrier-peugeot-18-06.jpg','images/001.jpg','images/Mitsubishi-asx-model-experience-technology-best-turning-radius.jpg')">
<div align="center">
  <h1>AVELON TRIP ADVISOR</h1>
  <p>&nbsp;</p>
</div>
<p align="center"><img src="images/86690725-belle-chute-d-eau-sala-près-de-labe-avec-des-arbres-piscine-verte-et-beaucoup-d-écoulement-de-l-39.jpg" onmouseover="this.src='images/1200x630_100_300_000000x30x0.jpg'  " width="1161" height="450" /></p>
<ul id="MenuBar1" class="MenuBarHorizontal">
  <li><a href="customerview.php">Home page</a></li>
  <li><a href="customercarbooking.php">Booking </a></li>
  <li><a href="editcarbookin.php">Edit booking</a>  </li>
  <li><a href="custgallerycar.php">Gallery  </a></li>
  <li><a href="<?php echo $logoutAction ?>">log out</a></li>
</ul>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div align="center" id="body">
<div align="center">




  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
    <table width="200" border="0">
    <tr>
      <td colspan="4"><div align="center"><img src='images/New-Nissan-Juke-1-e1567559892409.jpg'  width="915" height="526" id="man_pic" onclick="MM_effectAppearFade(this, 1000, 0, 100, false)" /></div></td>
        
    </tr>
    <tr>
<td><p><a href="customercarbooking.php"><img src="images/New-Nissan-Juke-1-e1567559892409.jpg" name="t1" width="299" height="141" id="t1" onmouseover="MM_swapImage('man_pic','','images/New-Nissan-Juke-1-e1567559892409.jpg',1)" /></a></p>
  <p>&nbsp;</p>
  <h1 align="center"><a href="images">ID:1</a></h1>
  <h1 align="center"><a href="customercarbooking.php">NISSAN:100$</a></h1></td>
      
<td><a href="customercarbooking.php"><img src="images/calendrier-peugeot-18-06.jpg" name="t2" width="299" height="141" id="t2" onmouseover="MM_swapImage('man_pic','','images/calendrier-peugeot-18-06.jpg',1)" /></a>
<p>&nbsp;</p>
  <h1 align="center"><a href="customercarbooking.php">ID:4</a></h1>
  <h1 align="center"><a href="customercarbooking.php">PEGEOT:50$</a></h1></td>
     
      <td><a href="customercarbooking.php"><img src="images/001.jpg" name="t3" width="299" height="141" id="t3" onmouseover="MM_swapImage('man_pic','','images/001.jpg',1)" /></a>
      <p>&nbsp;</p>
  <h1 align="center"><a href="customercarbooking.php">ID: 5</a></h1>
  <h1 align="center"><a href="customercarbooking.php">TOYOTA:90$</a></h1></td>
      
         <td><a href="customercarbooking.php"><img src="images/Mitsubishi-asx-model-experience-technology-best-turning-radius.jpg" name="t4" width="299" height="141" id="t4" onmouseover="MM_swapImage('man_pic','','images/Mitsubishi-asx-model-experience-technology-best-turning-radius.jpg',1)" /></a>
         <p>&nbsp;</p>
  <h1 align="center"><a href="customercarbooking.php">ID:3</a></h1>
  <h1 align="center"><a href="customercarbooking.php">MISTIBISHI:200$</a></h1></td>
    </tr>
  </table>
</div>
<div align="center">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p align="center">&nbsp;</p>
</div >
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
mysql_free_result($Recordset1);
?>
