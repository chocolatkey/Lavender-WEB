<?php defined('__CC__') or die('Restricted access');

$ip = cleanstring($_SERVER['REMOTE_ADDR']);
$time = time();
$id = cleanstring($_POST['id']);
$iv = cleanstring($_POST['iv']);

//$admin = cleanstring($_POST['admin']);
//$os = cleanstring($_POST['os']);

function pbkdf2( $p, $s, $c, $kl, $a = 'sha1' ) {
    $hl = strlen(hash($a, null, true)); # Hash length
    $kb = ceil($kl / $hl);              # Key blocks to compute
    $dk = '';                           # Derived key
    # Create key
    for ( $block = 1; $block <= $kb; $block ++ ) {
        # Initial hash for this block
        $ib = $b = hash_hmac($a, $s . pack('N', $block), $p, true);
        # Perform block iterations
        for ( $i = 1; $i < $c; $i ++ )
            # XOR each iterate
            $ib ^= ($b = hash_hmac($a, $b, $p, true));
        $dk .= $ib; # Append iterated block
    }
    # Return derived key of correct length
    return substr($dk, 0, $kl);
}


$key = pbkdf2("hinki","lavender", 1000, 32);

echo rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, base64_decode($id), MCRYPT_MODE_CBC, $iv));

?>
