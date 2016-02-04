<?php
defined('__CC__') or die('Restricted access');
?>
<nav class="navbar navbar-inverse noselect">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only"><?php echo $lang["tooggle_navigation"]; ?></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">
		<img alt="Lavender" src="./img/logo.png" style="max-height: 25px; width: auto;">
	  </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="index.php#dashboard"><i class="fa fa-tachometer"></i> <?php echo $lang["dashboard"]; ?></a></li>
        <li><a href="index.php?q=clients"><i class="fa fa-users"></i> <?php echo $lang["clients"]; ?></a></li>
        <li><a href="index.php?q=tasks"><i class="fa fa-clock-o"></i> <?php echo $lang["tasks"];?></a></li>
        <li><a href="index.php?q=files"><i class="fa fa-folder-open"></i> <?php echo $lang["files"];?></a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cogs"></i> System<span class="caret"></span></a>
          <ul class="dropdown-menu">
          <li><a href="index.php?q=power"><i class="fa fa-power-off"></i> <?php echo $lang["power"];?></a></li>
            <?php if ($username==$admin){ //show more if admin ?><li role="separator" class="divider"></li>
            <li><a href="index.php?q=settings"><i class="fa fa-globe"></i> <?php echo $lang["global_settings"];?></a></li>
            <li><a href="index.php?q=networks"><i class="fa fa-cloud"></i> <?php echo $lang["manage_networks"];?></a></li>
            <li><a href="index.php?q=info"><i class="fa fa-hdd-o"></i> <?php echo $lang["server_info"];?></a></li>
            <?php } ?>
            <li role="separator" class="divider"></li>
            <li><a href="index.php?q=about"><i class="fa fa-info-circle"></i> <?php echo $lang["about"];?></a></li>
            <li><a href="index.php?q=help"><i class="fa fa-question-circle"></i> <?php echo $lang["help"];?></a></li>
          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
		<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-home"></i> <?php echo($username); ?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a data-toggle="modal" href="#myaccount" data-target="#myaccount"><i class="fa fa-user"></i> <?php echo $lang["my_account"];?></a></li>
            <?php if ($username==$admin){ //manage if admin, delete if not ?><li><a href="index.php?q=accounts"><i class="fa fa-pencil-square-o"></i> <?php echo $lang["manage_accounts"];?></a></li><?php }else{ ?><li ><a ac="del" onClick="del()" ><i class="fa fa-user-times"></i> <?php echo $lang["delete_my_account"];?></a></li><?php } ?>
            <li role="separator" class="divider"></li>
            <li><a onClick="form('refresh');" href="#"><i class="fa fa-refresh"></i> <?php echo $lang["refresh_page"];?></a></li>
            <li><a onClick="form('logout')" href="#"><i class="fa fa-sign-out"></i> <?php echo $lang["logout"];?></a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<!--User edit form-->
<div aria-hidden="true" aria-labelledby="<?php echo $lang["my_account"];?>" class="modal fade" id="myaccount" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo $lang["close"];?>"><span aria-hidden="true">&times;</span></button>
    <h3 id="modal-title" class="noselect"><?php echo $lang["my_account"];?></h3>
  </div>
  <form method="POST">
    <input type="hidden" name="action" value="chpass">
    <div class="modal-body noselect" style="text-align:left">
        <h4><?php echo $lang["networks"];?></h4>
        <?php if ($username==$admin){ ?>
        <ul class="list-group">
            <li class="list-group-item"><b>*</b></li>
        </ul>
        <?php }else{ ?>
        <ul class="list-group">
            <li class="list-group-item">Todo: Query list all neworks user had permission to access and make multilingual and make password form</li>
        </ul>
        <?php } ?>
        <h4><?php echo $lang["change_password"];?></h4>
        <input type="password" name="opwd" placeholder="<?php echo $lang["old_password"];?>" class="input-large form-control" required>
        <br>
        <input type="password" name="npwd" id="pass" placeholder="<?php echo $lang["new_password"];?>" class="input-large form-control" required>
        <br>
        <input type="password" name="cpwd" id="confirmpass" style="margin-top: 10px;" placeholder="<?php echo $lang["new_password_confirm"];?>" class="input-large form-control" required>
      </div>
    <div class="modal-footer noselect">
      <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang["close"];?></button>
      <button class="btn btn-primary" id="updatepass" type="submit"><?php echo $lang["update_password"];?></button>
    </div>
  </form>
</div>
</div>
</div>
<!--Styles and scripts for account modal(s)-->
<style>
#myaccount .progress, #createuser .progress {
    margin-bottom: 0px;
    margin-top: 2px;
}
</style>
<script>
    $(document).ready(function(){
        "use strict";
        var options = {};
        options.ui = {
            verdicts: [
                "<?php echo $lang["weak"];?>",
                "<?php echo $lang["fair"];?>",
                "<?php echo $lang["medium"];?>",
                "<?php echo $lang["strong"];?>",
                "<?php echo $lang["very_strong"];?>"
            ]
        };
        options.rules = {
            activated: {
                wordTwoCharacterClasses: true,
                wordRepetitions: true
            }
        };
        $('#pass, #npass').pwstrength(options);
        $('#confirmpass, #pass').on('keyup', function () {
            if ($(this).val() == $('#pass').val() && $(this).val() == $('#confirmpass').val() && $(this).val().length > 0) {
                $("#updatepass").prop("disabled",false);
                $('#confirmpass, #pass').css('border-color', 'green');
            } else{
                $("#updatepass").prop("disabled",true);
                $('#confirmpass, #pass').css('border-color', 'red');
            }
        });
    });
<?php if ($username!=$admin){ //create if admin, delete if not ?>
//Delete account
function del(){
    if (confirm("<?php echo $lang["confirm_deleted_myaccount"];?>")){
        document.getElementById('delete').submit();
    }
}<?php } ?>
</script>

