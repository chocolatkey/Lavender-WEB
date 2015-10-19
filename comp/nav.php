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
        <li><a href="index.php#dashboard"><i class="glyphicon glyphicon-dashboard" aria-hidden="true"></i> <?php echo $lang["dashboard"]; ?></a></li>
        <li><a href="index.php?q=clients"><i class=" glyphicon glyphicon-knight" aria-hidden="true"></i> <?php echo $lang["clients"]; ?></a></li>
        <li><a href="index.php?q=tasks"><i class="glyphicon glyphicon-time" aria-hidden="true"></i> <?php echo $lang["tasks"];?></a></li>
        <li><a href="index.php?q=files"><i class="glyphicon glyphicon-folder-open" aria-hidden="true"></i> <?php echo $lang["files"];?></a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon glyphicon-cog" aria-hidden="true"></i> System<span class="caret"></span></a>
          <ul class="dropdown-menu">
          <li><a href="index.php?q=power"><i class="glyphicon glyphicon-off" aria-hidden="true"></i> <?php echo $lang["power"];?></a></li>
            <?php if ($username==$admin){ //show more if admin ?><li role="separator" class="divider"></li>
            <li><a href="index.php?q=settings"><i class="glyphicon glyphicon-globe" aria-hidden="true"></i> <?php echo $lang["global_settings"];?></a></li>
            <li><a href="index.php?q=networks"><i class="glyphicon glyphicon-cloud" aria-hidden="true"></i> <?php echo $lang["manage_networks"];?></a></li>
            <li><a href="index.php?q=info"><i class="glyphicon glyphicon-hdd" aria-hidden="true"></i> <?php echo $lang["server_info"];?></a></li>
            <li role="separator" class="divider"></li><?php } ?>
            <li><a href="index.php?q=about"><i class="glyphicon glyphicon-info-sign" aria-hidden="true"></i> <?php echo $lang["about"];?></a></li>
            <li><a href="index.php?q=help"><i class="glyphicon glyphicon-question-sign" aria-hidden="true"></i> <?php echo $lang["help"];?></a></li>
          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
		<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon glyphicon-home" aria-hidden="true"></i> <?php echo($username); ?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a data-toggle="modal" href="#myaccount" data-target="#myaccount"><i class="glyphicon glyphicon-user" aria-hidden="true"></i> <?php echo $lang["my_account"];?></a></li>
            <?php if ($username==$admin){ //create if admin, delete if not ?><li style="cursor="pointer";"><a data-toggle="modal" href="#createuser" data-target="#createuser"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> <?php echo $lang["create_account"];?></a></li><?php }else{ ?><li ><a ac="del" onClick="del()" ><i class="glyphicon glyphicon-trash" aria-hidden="true"></i> <?php echo $lang["delete_account"];?></a></li><?php } ?>
            <li><a href="index.php?q=accounts"><i class="glyphicon glyphicon-list-alt" aria-hidden="true"></i> <?php echo $lang["manage_accounts"];?></a></li>
            <li role="separator" class="divider"></li>
            <li><a onClick="form('refresh');" href="#"><i class="glyphicon glyphicon-repeat" aria-hidden="true"></i> <?php echo $lang["refresh_page"];?></a></li>
            <li><a onClick="form('logout')" href="#"><i class="glyphicon glyphicon-log-out" aria-hidden="true"></i> <?php echo $lang["logout"];?></a></li>
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
        <input type="password" name="cpwd" id="confirmpass" placeholder="<?php echo $lang["new_password_confirm"];?>" class="input-large form-control" required>
        
        <script>
        $('#confirmpass, #pass').on('keyup', function () {
            if ($(this).val() == $('#pass').val() && $(this).val() == $('#confirmpass').val()) {
                $("#updatepass").prop("disabled",false);
                $('#confirmpass').removeClass('has-error');
            } else{
                $("#updatepass").prop("disabled",true);
                $('#confirmpass').addClass('has-error');
            }
        });
        </script>
      </div>
    <div class="modal-footer noselect">
      <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang["close"];?></button>
      <button class="btn btn-primary" id="updatepass" type="submit"><?php echo $lang["update_password"];?></button>
    </div>
  </form>
</div>
</div>
</div>
<?php if ($username==$admin){ ?>
<!--User creation form-->
<div aria-hidden="true" aria-labelledby="Create new User" class="modal fade" id="createuser" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo $lang["close"];?>"><span aria-hidden="true">&times;</span></button>
    <h3 id="modal-title" class="noselect"><?php echo $lang["create_account"];?></h3>
  </div>
  <form method="POST">
    <input type="hidden" name="action" value="create">
    <div class="modal-body noselect" style="text-align:left">
        <input type="text" name="user" placeholder="<?php echo $lang["username"];?>" class="input-large form-control" required>
        <br>
        <input type="password" name="pwd" placeholder="<?php echo $lang["password"];?>" class="input-large form-control" required>
    </div>
    <div class="modal-footer noselect">
      <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang["cancel"];?></button>
      <button class="btn btn-primary" type="submit"><?php echo $lang["create_user"];?></button>
    </div>
  </form>
</div>
</div>
</div>
<?php } ?>