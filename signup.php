<?php require_once('Connections/tourisme.php'); ?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO customer (customername, adress_email, telephone, password, usertype) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['txtname'], "text"),
                       GetSQLValueString($_POST['txtadress'], "text"),
                       GetSQLValueString($_POST['txtelephone'], "int"),
                       GetSQLValueString($_POST['txtpassword'], "text"),
                       GetSQLValueString($_POST['txttype'], "text"));

  mysql_select_db($database_tourisme, $tourisme);
  $Result1 = mysql_query($insertSQL, $tourisme) or die(mysql_error());

  $insertGoTo = "edituseradmin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>sing up</title>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet"   href="footer.css" type="text/css" />
<link rel="stylesheet" href="styles.css">
</head>

<body>
<div align="center">
  <h1>AVELON TRIP ADVISOR</h1>
  <p>&nbsp;</p>
</div>
<p align="center"><img src="images/86690725-belle-chute-d-eau-sala-près-de-labe-avec-des-arbres-piscine-verte-et-beaucoup-d-écoulement-de-l-39.jpg" onmouseover="this.src='images/1200x630_100_300_000000x30x0.jpg'  " width="1161" height="450" /></p>
<div id ="t" align="center">
<ul id="MenuBar1" class="MenuBarHorizontal">
  <li><a href="login.php">hotel boking</a>  </li>
  <li><a href="login.php">car booking</a></li>
  <li><a href="login.php">product </a></li>
  <li><a href="login.php">login</a></li>
  <li><a href="#">sign up</a></li>
</ul>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p align="center">&nbsp;</p>
<div align="center" id="body">
  <h1 align="center">PLEASE ENTER YOUR INFORMATION</h1>
<p>&nbsp;</p>
<div align="center">
  <form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
    <table width="200" border="0">
      <tr>
        <td height="31"><p>Name</p></td>
        <td><label for="txtname"></label>
        <input type="text" name="txtname" id="txtname" placeholder= "full name" required="required" /></td>
      </tr>
      <tr>
        <td height="35"><p>Password</p></td>
        <td><label for="txtpassword"></label>
        <input type="password" name="txtpassword" id="txtpassword"  placeholder="***********" required="required" /></td>
      </tr>
      <tr>
        <td height="41"><p>User type</p></td>
        <td><label for="txttype"></label>
        <input name="txttype" type="text" id="txttype"  placeholder= "customer" required="required" /></td>
      </tr>
      <tr>
        <td height="28"><p>Email </p></td>
        <td><label for="txtadress"></label>
        <input type="email" name="txtadress" id="txtadress" placeholder= "name@gmail.com" required="required" /></td>
      </tr>
      <tr>
        <td height="33"><p>Telephone </p></td>
        <td><label for="txtelephone"></label>
        <input type="tel" name="txtelephone" id="txtelephone" placeholder= "0197922058" required="required"/></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><div align="center">
          <input type="submit" name="txtbutom" id="txtbutom" value="ADD" />
        </div></td>
      </tr>
    </table>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <input type="hidden" name="MM_insert" value="form1" />
  </form>
  </div >
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
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
</html>