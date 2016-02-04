<?php defined('__CC__') or die('Restricted access');
if ($username != $admin){//only admin can manage accounts
    die('Access denied');
}

$accounts = $database->select("ul_logins", [
    "id",
	"username",
	"date_created",
    "last_login"
]);

if (!empty($_POST["accounts"])) {
    $ms = "";
    print_r($_POST);//TODO: remove
    $ac = $_POST['accounts'];
    $sl = $_POST['selected'];
    if($ac == "delete"){
        $i = 0;
        foreach($sl as $id) {
            $de = $database->get("ul_logins", [
                "id",
                "username"
            ], ["id" => $id]); //Get entry where ==id
            if($de["username"] != $admin) {
                $database->delete("ul_logins", ["id" => $id]);
                $i++;
            } else {
                //TODO: Notify attempt to delete admin account
            }
        }
        $msg = "<div class='alert alert-info animated pulse' id='alert'><button type='button' class='close' data-dismiss='alert'>&times;</button>".$i." ".$lang["x_accounts_deleted"]."</div>";
    }
    echo $msg;
    $accounts = $database->select("ul_logins", [
    "id",
	"username",
	"date_created",
    "last_login"
    ]);
}
?>
<style>
.checkbox, .radio {
    margin-top: 0px;
    margin-bottom: 0px;
}
.checkbox label {
    padding-left: 0px;
}
.panel-title.animated {
    animation-duration: 0.2s;
}
</style>
<form action="index.php?q=accounts" method="POST" id="nform">
    <!-- Action Panel -->
    <div class="panel panel-primary noselect" id="apanel">
      <div class="panel-heading">
        <h3 class="panel-title default animated"><?php echo $lang["accounts"];?></h3>
        <h3 class="panel-title selected animated fadeInDown" style="display: none;"><?php echo $lang["actions_selected"];?></h3>
      </div>
      <div class="panel-body default">
        <a data-toggle="modal" href="#createuser" data-target="#createuser" class="btn btn-success"><i class="fa fa-user-plus"></i> <?php echo $lang["create_account"];?></a>
        <span class="pull-right" style="padding: 8px 12px;"><?php echo count($accounts).' '.$lang["rows"];?></span>
      </div>
      <div class="panel-body selected" style="display: none;">
        <button class="btn btn-primary" type="submit" name="accounts" value="chpass" disabled="disabled"><i class="fa fa-pencil"></i> <?php echo $lang["change_password"];?></button>
        <button class="btn btn-danger" id="adelete" type="submit" name="accounts" value="delete"><i class="fa fa-trash"></i> <?php echo $lang["delete"];?></button>
        <a class="btn btn-info" id="acsv"><i class="fa fa-table"></i> <?php echo $lang["export_csv"];?></a>
        <span class="pull-right" style="padding: 8px 12px;"><span id="aselectedcount"></span>/<?php echo (count($accounts)-1).' '.$lang["rows_selected"];?></span>
      </div>
      <div class="table-responsive yesselect">
        <table class="table table-bordered" id="ntable">
            <thead>
              <tr>
                <th style="width: 25px;"><?php if(count($accounts) > 1){ ?><div class="checkbox"><input type="checkbox" name="selectall" id="sta"/><label></label></div><?php } ?></th>
                <th>ID</th>
                <th><?php echo $lang["username"];?></th>
                <th style="width: 200px;"><?php echo $lang["date_created"]; ?></th>
                <th style="width: 200px;"><?php echo $lang["last_login"];?></th>
              </tr>
            </thead>
            <tbody><?php
        foreach($accounts as $account){
            $ecolor = '';
            $echeckbox = '';
            if($account['username'] == 'admin'){
                $ecolor = ' style="background: lightgray;"' ;
            } else {
                $echeckbox = '<div class="checkbox"><input type="checkbox" name="selected[]" value="'.$account['id'].'" /><label></label></div>';
            }
            echo'
              <tr'.$ecolor.'>
                <td>'.$echeckbox.'</td>
                <td style="width: 50px;">'.$account['id'].'</td>
                <td>'.$account['username'].'</td>
                <td>'.date('Y/m/d H:i:s', strtotime($account['date_created'])).'</td>
                <td>'.date('Y/m/d H:i:s', strtotime($account['last_login'])).'</td>
              </tr>';
        }?>
            </tbody>
        </table>
    </div>
    </div>
</form>

<!--User creation form-->
<div aria-hidden="true" aria-labelledby="<?php echo $lang["create_user"];?>" class="modal fade" id="createuser" role="dialog" tabindex="-1">
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
        <input type="password" id="npass" name="pwd" placeholder="<?php echo $lang["password"];?>" class="input-large form-control" required>
    </div>
    <div class="modal-footer noselect">
      <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang["cancel"];?></button>
      <button class="btn btn-primary" type="submit"><?php echo $lang["create_user"];?></button>
    </div>
  </form>
</div>
</div>
</div>

<script src="./js/apanel.js"></script>
<script>
// CSV export
$("#acsv").on('click', function (event) {
    // CSV
    exportTableToCSV.apply(this, [$('#ntable'), '<?php echo $mconfig["branding"].'_'.$lang["accounts"].'_'.date("Y-m-d") ?>.csv']);
    // IF CSV, don't do event.preventDefault() or return false
    // We actually need this to be a typical hyperlink
});

$("#adelete").on('click', function (event) {
    return confirm("<?php echo $lang["confirm_deleted_selected"]; ?>");
});
</script>