<?php
defined('__CC__') or die('Restricted access');
$username = $_SESSION['username'];
require_once(dirname(__FILE__)."/header.php");

error_reporting(E_ALL ^ E_NOTICE);
?>
<script>
function hideie() {
	document.getElementById('ie').style.display = 'none';
}
</script>
<!--[if lt IE 9]>
<div id="ie">You probably can't see this webpage properly because you are using an old version of Internet Explorer! <a href="//chrome.google.com" style="color:#0CF; text-decoration:underline">Upgrade to a newer browser</a><a onclick="hideie();" class="xhide" title="Close">X</a></div>
<![endif]-->
<?php require_once(dirname(__FILE__)."/nav.php");//navigation menu ?>
<center>
  <h1 class="title noselect"><?php echo($pname); ?></h1>
</center>
<div class="content left">
<?php if($q == 'dashboard'){ ?>
  <div class="alert alert-success animated bounceIn" id="alert">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Welcome!</strong> You are logged in, <?php echo($username); ?>. </div>
  <?php
}
require(dirname(__FILE__)."/functions.php");//Functions
echo ($msg);//Any messages
require(dirname(__FILE__)."/pages/".$q.".php");//Get content based on page
?>
<?php require(dirname(__FILE__)."/footer.php"); ?>