<?php defined('__CC__') or die('Restricted access'); ?>
  <a class="btn btn-purple" href="#">Complete PHP Info</a> <a class="btn btn-crystal" href="#">Linfo</a> <a class="btn btn-orange" href="#">Download Manager</a>
  </p>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="statisticsh">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#statistics" aria-expanded="true" aria-controls="statistics">
          <?php echo $lang["statistics"];?>
        </a>
      </h4>
    </div>
    <div id="statistics" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="<?php echo $lang["statistics"];?>">
      <div class="panel-body">
        Todo: Uptime, created date, user and network amount, server name/gateway?, uploaded/downloaded bytes, unique clients maybe, logins, logouts, failed logins, banned ips for login etc etc.
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="systeminfoh">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#systeminfo" aria-expanded="false" aria-controls="systeminfo">
          <?php echo $lang["system_info"];?>
        </a>
      </h4>
    </div>
    <div id="systeminfo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="<?php echo $lang["system_info"];?>">
      <div class="panel-body">
        <b>Lavender <?php echo $version; ?></b>
        <br><br>
        <p>Your IP: <?php echo $_SERVER['REMOTE_ADDR'];?></p>
        <p>Software: <?php echo $_SERVER['SERVER_SOFTWARE'];?></p>
        <p>Server Adress: <?php echo $_SERVER['SERVER_ADDR'];?></p>
        <p>Cookies: <?php echo $_SERVER['HTTP_COOKIE'];?></p>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="phpinfoh">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#phpinfo" aria-expanded="false" aria-controls="phpinfo">
          <?php echo $lang["php_info"];?>
        </a>
      </h4>
    </div>
    <div id="phpinfo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="<?php echo $lang["php_info   "];?>">
      <div class="panel-body">
        <style type="text/css">
		table {
			width: 100% !important;
		}
		td.e {
			width: 20% !important;
		}
        </style>
        <?php
        //http://www.mainelydesign.com/blog/view/displaying-phpinfo-without-css-styles
        ob_start();
        phpinfo();
        $pinfo = ob_get_contents();
        ob_end_clean();
         
        $pinfo = preg_replace( '%^.*<body>(.*)</body>.*$%ms','$1',$pinfo);
        echo $pinfo;
        ?>
      </div>
    </div>
  </div>
</div>