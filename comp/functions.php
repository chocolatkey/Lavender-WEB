<?php
// Credits to Orgy from HF for his nice and clean functions
function nice_escape($unescapedString)
{
    if (get_magic_quotes_gpc())
    {
        $unescapedString = stripslashes($unescapedString);
    }
    $semiEscapedString = mysql_real_escape_string($unescapedString);
    $escapedString = addcslashes($semiEscapedString, "%_");

    return $escapedString;
} 

function nice_output($escapedString)
{
    $patterns = array();
    $patterns[0] = '/\\\%/';
    $patterns[1] = '/\\\_/';
    $replacements = array();
    $replacements[0] = '%';
    $replacements[1] = '_';
    $output = preg_replace($patterns, $replacements, $escapedString);
    
    return $output;
} 

function cleanstring($string)
{
	$done = nice_output(nice_escape($string));
	
	return $done;
}

//database
require(dirname(__FILE__)."/medoo.min.php");

$database = new medoo([
	// required
	'database_type' => 'mysql',
	'database_name' => $mconfig["db_name"],
	'server' => $mconfig["db_host"],
	'username' => $mconfig["db_user"],
	'password' => $mconfig["db_pass"],
	'charset' => 'utf8',
 
	// optional
	'port' => 3306,
	// driver_option for connection, read more from http://www.php.net/manual/en/pdo.setattribute.php
	'option' => [
		PDO::ATTR_CASE => PDO::CASE_NATURAL
	]
]);

//todo ip to country add
?>