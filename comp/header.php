<!doctype html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php if(!$mconfig["conceal"]){ echo $mconfig["branding"];?> - <?php } echo $pname;?></title>
<?php if(!$mconfig["conceal"]){ ?><link rel="icon" href="/favicon.ico" type="image/ico"/><?php } ?>
<link rel="stylesheet" href="./css/bootstrap.min.css">
<link href="./css/font-awesome.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="./js/jquery.min.js"></script>
<script type="text/javascript" src="./js/bootstrap.min.js"></script>
<?php if (isAppLoggedIn()){ //Scripts for backend & not necessary for login ?>
<script type="text/javascript" src="./js/pwstrength-bootstrap-1.2.9.min.js"></script>
<?php } ?>
<link href="./css/sho.css" rel="stylesheet" type="text/css">
<link href="./css/animate.min.css" rel="stylesheet" type="text/css">
<script>
$(document).ready(function(){
    /*Check to prevent javascript error because err() is not included if no error*/
    if (typeof err !== 'undefined' && $.isFunction(err)) {
        err();
    }
    setTimeout(function(){
        $('#alert').addClass('animated fadeOut twos');
    }, 5000);
    setTimeout(function(){
    	$('#alert').css({"display":"none"});
    }, 6000);
});
</script>
</head>
<body class="background">