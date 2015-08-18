    <h1 class="title noselect">Chocolatkey Download Manager <i>2014</i></h1><br>
	<div class="content fadein center">
<?php
/*
*
* Create Download Link
* Jaocb Wyke
* jacob@frozensheep.com
* Heavily modified by Henry Stark@chocolatkey
*
*/

//connect to the DB
$resDB = mysql_connect("192.168.4.4", "dl", "d0wnl3ad");
mysql_select_db("dl", $resDB);

function createKey(){
	//create a random key
	$strKey = md5(microtime());
	//error_log("yo", 0);
	//check to make sure this key isnt already in use
	$resCheck = mysql_query("SELECT count(*) FROM downloads WHERE downloadkey = '{$strKey}' LIMIT 1");
	$arrCheck = mysql_fetch_assoc($resCheck);
	if($arrCheck['count(*)']){
		//key already in use
		return createKey();
	}else{
		//key is OK
		return $strKey;
	}
}

//get a unique download key
$strKey = createKey();
//GET file value from url
$file=$_GET['f'];
//GET multipledownloads from url
$multiple=$_GET['m'];
if ($multiple == 1 OR $multiple == 'true'){//if multiple variable has been supplied and is 1 or true (?f=app.exe&m=true) or something like that
	$multiple = 1;
	$dltext = "Unlimited downloads allowed";
} else {//if not supplied or something else than above then it's only a one time download
	$multiple = 0;
	$dltext = "Download a single time within the next 7 days";
}

if($file == ""){
?>
        <span class="text-danger" id="error">File name needed.</span> Example: <span class="text-info" id="info">....../sho?dl=true&?f=program.exe</span> and for unlimited downloads add <span class="text-info" id="info">&multiple=1</span>. <b>Always put the file at the end!</b>
<?php
} else{
//insert the download record into the database                                     INSERT FILE STRING ↓          ONE WEEK ↓↓↓↓↓
mysql_query("INSERT INTO downloads (downloadkey, file, expires, multiple) VALUES ('{$strKey}', '{$file }', '".(time()+(60*60*24*7))."', '{$multiple }')");
?>
        <p>Your unique download URL is:</p><strong><a class="btn btn-large btn-success" href="/download?key=<?=$strKey;?>"><!--download.php?key=<?=$strKey;?>-->Here</a></strong>
		<br>
        <p><?php echo $dltext; ?></p>
<?php
}
//URL
$query = $_GET;
// replace parameter(s)
$query['dl'] = 'false';
// rebuild url
$query_result = http_build_query($query);
//new URL below
?>
		<br><br>
		<!--<a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $query_result; ?>">Link</a>-->
		<a class="btn btn-primary" href="<?php echo $_SERVER['PHP_SELF']; ?>">Return to Sho<a>
    </div>
	<?php require(dirname(__FILE__)."/footer.php"); ?>