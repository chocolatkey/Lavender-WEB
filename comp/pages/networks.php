<?php defined('__CC__') or die('Restricted access');
if ($username!=$admin){//only admin can manage networks
    die('Access denied');
}

$networks = $database->select("networks", [
    "id",
	"name",
	"disabled",
    "accounts"
]);

if (!empty($_POST["networks"])) {
    print_r($_POST);
    $ac = $_POST['networks'];
    if($ac == "delete"){
        
    }
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

<form  action="index.php?q=networks" method="POST">
    <!-- Action Panel -->
    <div class="panel panel-primary noselect" id="apanel">
      <div class="panel-heading">
        <h3 class="panel-title default animated"><?php echo $lang["networks"];?></h3>
        <h3 class="panel-title selected animated fadeInDown" style="display: none;"><?php echo $lang["actions_selected"];?></h3>
      </div>
        <div class="panel-body default">
            <a data-toggle="modal" href="#createnetwork" data-target="#createnetwork" class="btn btn-success"><i class="fa fa-plus-circle"></i> <?php echo $lang["create_network"];?></a>
            <span class="pull-right" style="padding: 8px 12px;"><?php echo count($networks).' '.$lang["rows"];?></span>
        </div>
        <div class="panel-body selected" style="display: none;">
            <button class="btn btn-primary" type="submit" name="networks" value="permissions"><i class="fa fa-pencil"></i> <?php echo $lang["edit_permissions"];?></button>
            <div class="btn-group" role="group" aria-label="<?php echo $lang["enable_disable"];?>">
              <button class="btn btn-success" type="submit" name="networks" value="enable"><i class="fa fa-check-circle-o"></i> <?php echo $lang["enable"];?></button>
              <button class="btn btn-warning" type="submit" name="networks" value="disable"><i class="fa fa-times-circle-o"></i> <?php echo $lang["disable"];?></button>
            </div>
            <button class="btn btn-danger" type="submit" name="networks" value="delete"><i class="fa fa-trash"></i> <?php echo $lang["delete"];?></button>
            <a class="btn btn-info" id="csv"><i class="fa fa-table"></i> <?php echo $lang["export_csv"];?></a>
            <span class="pull-right" style="padding: 8px 12px;"><span id="aselectedcount"></span>/<?php echo count($networks).' '.$lang["rows_selected"];?></span>
        </div>
        <div class="table-responsive yesselect">
            <table class="table table-bordered" id="ntable">
                <thead>
                  <tr>
                    <th style="width: 25px;"><div class="checkbox"><input type="checkbox" name="selectall" id="sta"/><label></label></div></th>
                    <th style="width: 50px;">ID</th>
                    <th><?php echo $lang["name"];?></th>
                    <th style="width: 100px;"><?php echo $lang["status"];?></th>
                    <th><?php echo $lang["associated_accounts"];?></th>
                  </tr>
                </thead>
                <tbody><?php
            foreach($networks as $network){
                
                if($network['disabled'] == 0){
                    $pic = 'tick';
                    $alt = $lang["enabled"];
                } else{
                    $pic = 'cross';
                    $alt = $lang["disabled"];
                }
                echo'
                  <tr>
                    <td><div class="checkbox"><input type="checkbox" name="selected[]" value="'.$network['name'].'" /><label></label></div></td>
                    <td>'.$network['id'].'</td>
                    <td>'.$network['name'].'</td>
                    <td><img src="/img/icons/'.$pic.'.png" alt="'.$alt.'"/><span style="display: none;">'.$alt.'</span></td>
                    <td>'.$network['accounts'].'</td>
                  </tr>';
            }?>

                </tbody>
            </table>
        </div>
    </div>
    
    <!--Add network form-->
    <div aria-hidden="true" aria-labelledby="<?php echo $lang["create_network"];?>" class="modal fade" id="createnetwork" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo $lang["close"];?>"><span aria-hidden="true">&times;</span></button>
        <h3 id="modal-title" class="noselect"><?php echo $lang["create_network"];?></h3>
      </div>
      <form method="POST">
        <input type="hidden" name="networks" value="create">
        <div class="modal-body noselect" style="text-align:left">
            <input type="text" name="name" placeholder="<?php echo $lang["network_name"];?>" class="input-large form-control" required>
            <br>
            <input type="password" name="pwd" placeholder="<?php echo $lang["password"];?>" class="input-large form-control" required>
        </div>
        <div class="modal-footer noselect">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang["cancel"];?></button>
          <button class="btn btn-primary" type="submit"><?php echo $lang["create_network"];?></button>
        </div>
      </form>
    </div>
    </div>
    </div>
</form>

<script type="text/javascript" src="./js/apanel.js"></script>
<script>
// CSV export
$("#csv").on('click', function (event) {
    // CSV
    exportTableToCSV.apply(this, [$('#ntable'), '<?php echo $mconfig["branding"].'_'.$lang["networks"].'_'.date("Y-m-d") ?>.csv']);
    // IF CSV, don't do event.preventDefault() or return false
    // We actually need this to be a typical hyperlink
});
</script>