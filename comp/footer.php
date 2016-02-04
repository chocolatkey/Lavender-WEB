<?php defined('__CC__') or die('Restricted access');
$page =  $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
$footer_networks = $database->select("networks", [
	"name",
    "accounts"
]);
?>
<!--Delete account, refresh page, logout forms/actions-->
<form method="POST" id="delete"><input type="hidden" name="action" value="delete"></form>
<form method="POST" id="refresh"><input type="hidden" name="action" value="refresh"></form>
<form method="POST" id="logout"><input type="hidden" name="action" value="logout"></form>
<!-- Footer -->
<div class="footer noselect"> <span style="padding-top: 7px; color: #db7fdb;" class="pull-left">&copy; <?php echo $mconfig["branding"]; ?></span>
  <?php if (!$_SERVER['HTTPS']){?>
  <a class="btn btn-danger btn-sm pull-right" id="loadbutton" href="https://<?php echo $page; ?>"><i class="fa fa-exclamation-triangle" id="loadicon"></i> <?php echo $lang["insecure"];?></a>
  <style>
  #loadbutton {
    -webkit-animation: shade 3s;
    -webkit-animation-iteration-count: infinite;
    -moz-animation: shade 3s;
    -moz-animation-iteration-count: infinite;
    -o-animation: shade 3s;
    -o-animation-iteration-count: infinite;
  }
  </style>
  <?php }else{?>
  <a class="btn btn-success btn-sm pull-right" id="loadbutton" href="http://<?php echo $page; ?>"><i class="fa fa-lock" id="loadicon"></i> SSL</a>
  <?php }?>
  <form method="POST" id="network">
    <select class="form-control pull-right" name="nsel" id="nsel" style="margin-right: 5px; width: auto; height: 30px;">
      <?php
foreach($footer_networks as $network){//TODO: set selected and form submit
    echo'<option value="'.$network['name'].'">'.$network['name'].'</option>';
}?>

    </select>
  </form>
  <span class="pull-right hidden-xs" style="margin-right: 10px; margin-top: 7px;"><?php echo $lang["network"];?>:</span>
</div>
<script>
//Submit form
function form(form){document.getElementById(form).submit();}

//Security button load spinner
$('#loadbutton').click(function() {
    $('#loadicon').removeClass();
    $('#loadicon').addClass("fa fa-spinner fa-spin");
    setTimeout(function(){
        $('#loadicon').removeClass();
        $('#loadicon').addClass("fa fa-exclamation-circle");
    },10000);
});

//When ready
$( document ).ready(function() {
    //Add "active" class and screen reader text to menu item with correspnding current url ending
    $('a[href$="<?php echo $q; ?>"]:first').append("<span class=\"sr-only\"> (current)</span>").parent().addClass("active");
    //Submit network form on select change
    $('#nsel').on('change', function() {
     form('network');
  });
});
</script>