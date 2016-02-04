<?php
define('__CC__', 1);// Security

$version = "Pre-Alpha";

if(file_exists(dirname(__FILE__)."/config.php")) {
    require_once(dirname(__FILE__)."/config.php"); //Master configuration file
} else {
    require_once(dirname(__FILE__)."/comp/install.php"); //Installation
    die();
}

//Lanuage file
require_once(dirname(__FILE__)."/lang/".$mconfig["lang"].".php");

//Functions
require(dirname(__FILE__)."/comp/functions.php");

//Post from client
$header = cleanstring($_SERVER['HTTP_USER_AGENT']); //TODO: Not sure if 100% injection-proof
if($header == "0x1" | $header == "1x0" | $header == "1x1") {
	require(dirname(__FILE__)."/comp/post.php");
    die();// Nothing more
}

$admin = $mconfig["cc_admin"];//admin user

require dirname(__FILE__).'/comp/geoip2.phar';//phar formatted maxmind geoip lib
use GeoIp2\Database\Reader;

// This is the one and only public include file for uLogin.
// Include it once on every authentication and for every protected page.
require_once(dirname(__FILE__).'/ulogin/config/all.inc.php');
require_once(dirname(__FILE__).'/ulogin/main.inc.php');

// Start a secure session if none is running
if (!sses_running())
	sses_start();

// We define some functions to log in and log out,
// as well as to determine if the user is logged in.
// This is needed because uLogin does not handle access control
// itself.

function isAppLoggedIn(){
	return isset($_SESSION['uid']) && isset($_SESSION['username']) && isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn']===true);
}

function appLogin($uid, $username, $ulogin){
	$_SESSION['uid'] = $uid;
	$_SESSION['username'] = $username;
	$_SESSION['loggedIn'] = true;

	if (isset($_SESSION['appRememberMeRequested']) && ($_SESSION['appRememberMeRequested'] === true))
	{
		// Enable remember me
		if ( !$ulogin->SetAutologin($username, true))
			echo "cannot enable autologin<br>";

		unset($_SESSION['appRememberMeRequested']);
	}
	else
	{
		// Disable remember-me
		if ( !$ulogin->SetAutologin($username, false))
			echo 'cannot disable autologin<br>';
	}
}

function appLoginFail($uid, $username, $ulogin){
	// Note, in case of a failed login, $uid, $username or both
	// might not be set (might be NULL).
    
	echo "<script>
		function err(){
		document.getElementById('errmsg').innerHTML = \"".$GLOBALS["lang"]["login_error"]."\";
		document.getElementById('errdiv').style.display = 'block';};
		</script>";/*<div class='footer noselect'><button type='button' class='close' data-dismiss='alert'>&times;</button>Login failed!</div>*/
	/*$emsg = "<script>var err = document.getElementById('errmsg');err.innerHTML = msg;err.style.display = 'block';</script>";*/
}

function appLogout(){
  // When a user explicitly logs out you'll definetely want to disable
  // autologin for the same user. For demonstration purposes,
  // we don't do that here so that the autologin function remains
  // easy to test.
  $ulogin = new uLogin('appLogin', 'appLoginFail');
   $ulogin->SetAutologin($_SESSION['username'], false);

	unset($_SESSION['uid']);
	unset($_SESSION['username']);
	unset($_SESSION['loggedIn']);
    
    //remove all variables for a clean url
    $page = strtok($_SERVER['REQUEST_URI'], '?');
    header("LOCATION: ".$page);
}

// Store the messages in a variable to prevent interfering with headers manipulation.
$msg = "";


// This is the action requested by the user
$action = @$_POST['action'];

// This is the first uLogin-specific line in this file.
// We construct an instance and pass a function handle to our
// callback functions (we have just defined 'appLogin' and
// 'appLoginFail' a few lines above).
$ulogin = new uLogin('appLogin', 'appLoginFail');


// First we handle application logic. We make two cases,
// one for logged in users and one for anonymous users.
// We will handle presentation after our logic because what we present is
// also based on the logon state, but the application logic might change whether
// we are logged in or not.

if (isAppLoggedIn()){
	if ($action=='delete'){	// Delete the account
        if ($_SESSION['username']==$admin) { //only if admin
            $msg = "<div class='alert alert-danger animated pulse' id='alert'><button type='button' class='close' data-dismiss='alert'>&times;</button>".$GLOBALS["lang"]["admin_nodelete"]."</div>";
        } else {
            // Delete account
            if ( !$ulogin->DeleteUser( $_SESSION['uid'] ) ) {
                $msg = "<div class='alert alert-danger animated pulse' id='alert'><button type='button' class='close' data-dismiss='alert'>&times;</button>".$GLOBALS["lang"]["account_delete_error"]."</div>";
            } else {
                $msg = "<div class='alert alert-success animated pulse' id='alert'><button type='button' class='close' data-dismiss='alert'>&times;</button>".$GLOBALS["lang"]["account_delete_success"]."</div>";
            }
            // Logout
            appLogout();
        }
	} else if ($action == 'logout'){ // Log Out
		// Logout
		appLogout();        
		$msg = "<div class='alert alert-info animated pulse' id='alert'><button type='button' class='close' data-dismiss='alert'>&times;</button>".$GLOBALS["lang"]["logged_out"]."</div>";
	} else if ($action=='create') {	// Create a new acount.
        if ($_SESSION['username']==$admin) { //only if admin
            // create new account
            if ( !$ulogin->CreateUser( $_POST['user'],  $_POST['pwd']) ) {
                $msg = "<div class='alert alert-danger animated pulse' id='alert'><button type='button' class='close' data-dismiss='alert'>&times;</button>".$GLOBALS["lang"]["account_create_error"]."</div>";
            } else {
                $msg = "<div class='alert alert-success animated pulse' id='alert'><button type='button' class='close' data-dismiss='alert'>&times;</button>".$GLOBALS["lang"]["account_create_success"]."</div>";
            }
        }
	} else if ($action=='chpass') {	// Change user password
        if (($_SESSION['uid'] == $ulogin->Authenticate3($_SESSION['uid'], $_POST['opwd']))) {// If old pass is right
            if ( !$ulogin->SetPassword($_SESSION['uid'], $_POST['npwd']) ) {
                $msg = "<div class='alert alert-danger animated pulse' id='alert'><button type='button' class='close' data-dismiss='alert'>&times;</button>".$GLOBALS["lang"]["password_change_error"]."<   /div>";
            } else {
                $msg = "<div class='alert alert-success animated pulse' id='alert'><button type='button' class='close' data-dismiss='alert'>&times;</button>".$GLOBALS["lang"]["password_change_success"]."</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger animated pulse' id='alert'><button type='button' class='close' data-dismiss='alert'>&times;</button>".$GLOBALS["lang"]["password_change_error_oldpass"]."</div>";
        }
    }
} else {
    if ($action=='login') { //Log In
		// Here we verify the nonce, so that only users can try to log in
		// to whom we've actually shown a login page. The first parameter
		// of Nonce::Verify needs to correspond to the parameter that we
		// used to create the nonce, but otherwise it can be anything
		// as long as they match.
		if (isset($_POST['nonce']) && ulNonce::Verify('login', $_POST['nonce'])){
			// We store it in the session if the user wants to be remembered. This is because
			// some auth backends redirect the user and we will need it after the user
			// arrives back.
            if (isset($_POST['autologin'])){
                $_SESSION['appRememberMeRequested'] = true;
            } else {
                unset($_SESSION['appRememberMeRequested']);
            }
            // This is the line where we actually try to authenticate against some kind
            // of user database. Note that depending on the auth backend, this function might
            // redirect the user to a different page, in which case it does not return.
            $ulogin->Authenticate($_POST['user'],  $_POST['pwd']);
            if ($ulogin->IsAuthSuccess()){
                // Since we have specified callback functions to uLogin,
                // we don't have to do anything here.
            }
        } else {
            $msg = "<div class='alert alert-warning animated pulse' id='alert'><button type='button' class='close' data-dismiss='alert'>&times;</button>".$GLOBALS["lang"]["invalid_nounce"]."</div>";
        }
    } else /*if ($action=='autologin')*/{	// We were requested to use the remember-me function for logging in.
		// Note, there is no username or password for autologin ('remember me')
		$ulogin->Autologin();
		if (!$ulogin->IsAuthSuccess()){
			//$msg = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button>Autologin failure</div>";
		} else {
			//$msg = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>&times;</button>Autologon ok</div>";
        }
	}
}


// Now we handle the presentation, based on whether we are logged in or not.
// Nothing fancy, except where we create the 'login'-nonce towards the end
// while generating the login form.

header('Content-Type: text/html; charset=UTF-8'); 

// This inserts a few lines of javascript so that we can debug session problems.
// This will be very usefull if you experience sudden session drops, but you'll
// want to avoid using this on a live website.
//--ulLog::ShowDebugConsole();

//TODO: query database for network IDs and...

//Main Page content
if(isset($_GET['q'])) {
	$q=cleanstring($_GET['q']);
}
if (isAppLoggedIn()){
	if(!isset($_GET['q'])) {
	  $q = "dashboard";
    }
    require_once(dirname(__FILE__)."/comp/pages.php");
    if(!isset($pages[$q])){
        $username = $_SESSION['username'];
        $pname = $lang["404"];
        require_once(dirname(__FILE__)."/comp/header.php");
        require_once(dirname(__FILE__)."/comp/nav.php");//navigation menu
        echo("<h1 class='title noselect'>".$lang["404"]."</h1>");
    } else {
        $pname = $pages[$q];//set page title
        require(dirname(__FILE__)."/comp/main.php");
    }
} else {
    $waslegit = false;
    $networks = $database->select("networks", [
        "id",
        "plugin"
    ]);
    print_r($networks);
    foreach($networks as $network) {
        if(isset($_GET[$network["id"]])){
            require_once(dirname(__FILE__)."/comp/plugins/".$network["plugin"].".php"); //PLUGIN
            if(xplugin()) {
                die(0);
            }
        }
    }
    //print_r($_GET);
    if(!$waslegit){//Login page
        $pname = $lang['login'];//set page title
        require_once(dirname(__FILE__)."/comp/header.php");
?>
<script>
	$(document).ready(function(){
		$('.hasTooltip').tooltip({});
        $("input").each(function( index ) {
            if ($(this).is(":empty")) {
                $(this).focus();
                return false;
            }
        });
	});
</script>
<style type="text/css">
	table, th, td {
		border: none !important;
		/*vertical-align: middle;*/
	}
	select, textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"], .uneditable-input {
		height: inherit !important;
		margin-bottom: 0px;
	}
    .checkbox label::after {
        padding-left: 2px;
        padding-top: 1px;
        font-size: 14px;
    }
</style>
<center>
<div class="content sbox noselect animated bounceInDown">
  <?php if(!$mconfig["conceal"]){ ?><img src="./img/logo.png" alt="Lavender Logo" style="margin-bottom: 20px; height: 50px; width: auto;"><?php } ?>
  <?php echo ($msg);?>
  <div class="alert alert-danger animated tada" id="errdiv" style="display:none"><span id="errmsg"></span>
    <button type='button' class='close' data-dismiss='alert'>&times;</button>
  </div>
  <form action="" method="POST">
    <div class="input-group"><span class="input-group-addon"><i class="fa fa-user"></i></span>
      <input type="text" name="user" placeholder="<?php echo $lang["username"];?>" autocapitalize="off" class="input form-control" required>
    </div>
    <br>
    <div class="input-group"><span class="input-group-addon"><i class="fa fa-key"></i></span>
      <input type="password" name="pwd" placeholder="<?php echo $lang["password"];?>" class="input form-control" required>
    </div>
    <br>
    <div class="checkbox" style="margin-top: 0px;">
        <input type="checkbox" name="autologin" id="al" value="1">
        <label for="al"><?php echo $lang["remember_me_30_days"];?></label>
    </div>
    <select name="action" style="display:none">
        <option>login</option>
    </select>
    <input type="text" style="display:none" id="nonce" name="nonce" value="<?php echo ulNonce::Create('login');?>" required>
    <br>
    <input type="submit" class="btn btn-gray btn-large" value="<?php echo $lang["login"];?>" style="width:150px;">
  </form>
</div>
<?php if(!$mconfig["conceal"]){ ?><div class="bottom noselect"><a style="float: left;" href="/">&copy; <?php echo $mconfig["branding"]; ?></a><a style="float: right; cursor: pointer;" href="https://github.com/chocolatkey/Lavender-WEB">Lavender Web</a></div><?php } ?>
<?php }} ?>
</body>
</html>