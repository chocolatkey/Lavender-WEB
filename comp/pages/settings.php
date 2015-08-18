<?php defined('__CC__') or die('Restricted access');
if ($username!=$admin){//only admin can change global settings
    die('Access denied');
}
/*Change to get language files
$curdir=dirname(__FILE__);
$handle=opendir($curdir);
$projects = '';
$domainsDir=dirname(session_save_path())."/conf/domains.d";
while ($file = readdir($handle)) {
    if ($file!='..' && $file!='.')
        if (is_dir("$curdir/$file") && !in_array($file,$projectsListIgnore)) {				
            $localVirtual=file_exists("$domainsDir/$file.conf");
            //die("$domainsDir/$file.conf =".$localVirtual);
            if ($localVirtual) $projects .= "<li><a class=\"local\" href=\"http://".sanitizeDomainName($file).".local\">$file</a></li>";
            else $projects .= '<li><a href="/'.$file.'">'.$file.'</a></li>';
        }
}
closedir($handle);
if (empty($projects)) $projects = "No Projects!";*/
?>
<table class="table table-bordered table-responsive" id="ntable">
    <thead>
      <tr>
        <th>Setting</th>
        <th>Value</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td></td>
        <td></td>
      </tr>
    </tbody>
  </table>