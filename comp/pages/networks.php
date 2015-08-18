<?php defined('__CC__') or die('Restricted access');
if ($username!=$admin){//only admin can manage networks
    die('Access denied');
}

$networks = $database->select("networks", [
	"name",
	"disabled",
    "accounts"
]);
?>

<!--TODO: Add form element-->
<!-- Action Panel -->
<div class="panel panel-primary noselect animated" style="display:none;" id="apanel">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo $lang["actions_selected"];?></h3>
  </div>
  <div class="panel-body">
    <button class="btn btn-info" type="submit" name="action" value="details"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i> <?php echo $lang["edit"];?></button>
    <div class="btn-group" role="group" aria-label="<?php echo $lang["enable_disable"];?>">
      <button class="btn btn-success" type="submit" name="action" value="enable"><i class="glyphicon glyphicon-ok-circle" aria-hidden="true"></i> <?php echo $lang["enable"];?></button>
      <button class="btn btn-warning" type="submit" name="action" value="disable"><i class="glyphicon glyphicon-remove-circle" aria-hidden="true"></i> <?php echo $lang["disable"];?></button>
    </div>
    <button class="btn btn-danger" type="submit" name="action" value="delete"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i> <?php echo $lang["delete"];?></button>
  </div>
</div>

<table class="table table-bordered table-responsive" id="ntable">
    <thead>
      <tr>
        <th style="width: 25px; text-align: center;"><input type="checkbox" name="selectall"/></th>
        <th>Name</th>
        <th>Status</th>
        <th>Accounts</th>
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
        <td><input type="checkbox" name="scb" value="'.$network['name'].'" /></td>
        <td>'.$network['name'].'</td>
        <td><img src="/img/icons/'.$pic.'.png" alt="'.$alt.'"/></td>
        <td>'.$network['accounts'].'</td>
      </tr>';
}?>

    </tbody>
  </table>
  
<script>
//When ready add checkbox listener
$(document).ready(function(){
    $("#ntable").contents().find("input:checkbox[name='selectall']").bind('change', function(){//Binding for select all checkbox
        var val = this.checked;
        var boxes = $("#ntable").contents().find("input:checkbox[name='scb']");
        for (var i = 0; i < boxes.length; i++) {
            boxes[i].checked = val;
        }
    })
    $("#ntable").contents().find("input:checkbox").bind('change', function(){
        var val = this.checked;
        if(val){//1+ checked, show action panel
            $( "#apanel" ).removeClass( "zoomOutUp" );
            $( "#apanel" ).slideDown('fast');
        }else if($("#ntable").contents().find('input:checkbox:checked').length == 0){//0 checked, hide action panel
            $( "#apanel" ).removeClass( "zoomInUp" ).addClass( "zoomOutUp" );
            $( "#apanel" ).slideUp('fast');
        } else{//uncheck select all
            $("#ntable").contents().find("input:checkbox[name='selectall']").prop('checked', val);
        }
    })
});
</script>