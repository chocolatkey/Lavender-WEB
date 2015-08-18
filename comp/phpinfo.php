    <h1 class="title noselect">Phpinfo()</h1><br>
	<div class="content fadein center">
	<style type="text/css">
		table {
			width: 100% !important;
		}
		td.e {
			min-width: 10px !important;
		}
	</style>
	<a class="btn btn-primary" href="<?php echo $_SERVER['PHP_SELF']; ?>">Return to Sho<a><br><br>
	<?php
	/*
	Colorful random PHPinfo
	ob_start();
	phpinfo();
	$phpinfo = ob_get_contents();
	ob_end_clean();

	preg_match_all('/#[0-9a-fA-F]{6}/', $phpinfo, $rawmatches);
	for ($i = 0; $i < count($rawmatches[0]); $i++)
	$matches[] = $rawmatches[0][$i];
	$matches = array_unique($matches);

	$hexvalue = '0123456789abcdef';

	$j = 0;
	foreach ($matches as $match)
	{

		$r = '#';
		$searches[$j] = $match;
		for ($i = 0; $i < 6; $i++)
		$r .= substr($hexvalue, mt_rand(0, 15), 1);
		$replacements[$j++] = $r;
		unset($r);
	}

	for ($i = 0; $i < count($searches); $i++)
		$phpinfo = str_replace($searches, $replacements, $phpinfo);
	echo $phpinfo;
	
	*/
	//http://www.mainelydesign.com/blog/view/displaying-phpinfo-without-css-styles
	ob_start();
	phpinfo();
	$pinfo = ob_get_contents();
	ob_end_clean();
	 
	$pinfo = preg_replace( '%^.*<body>(.*)</body>.*$%ms','$1',$pinfo);
	echo $pinfo;
	?>
	</div>
	<?php require(dirname(__FILE__)."/footer.php"); ?>
	