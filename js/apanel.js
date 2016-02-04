//When ready add checkbox listener
$(document).ready(function(){
    $("#ntable").contents().find("input:checkbox[name='selectall']").bind('change', function(){//Binding for select all checkbox
        var val = this.checked;
        var boxes = $("#ntable").contents().find("input:checkbox[name!='selectall']");
        for (var i = 0; i < boxes.length; i++) {
            boxes[i].checked = val;
        }
        if($("#ntable").contents().find("input:checkbox:checked").length == 0){
                $( ".panel-body.selected,.panel-title.selected" ).hide();
                $( ".panel-body.default" ).show();
                $( ".panel-title.default" ).addClass("fadeInUp").show();
        }
    })
    $("#ntable").contents().find("input:checkbox").bind('change', function(){
        var val = this.checked;
        var nchecked = $("#ntable").contents().find("input:checkbox:checked").length;
        $("#aselectedcount").text($("#ntable").contents().find("input:checkbox:checked[name!='selectall']").length);
        if(val){//1+ checked, show action panel
            if($("#ntable").contents().find("input:checkbox:checked").length >= $("#ntable").contents().find("input:checkbox[name!='selectall']").length){
                $("#ntable").contents().find("input:checkbox[name='selectall']")[0].checked = val;
            }
            $( ".panel-body.selected,.panel-title.selected" ).show();
            $( ".panel-body.default,.panel-title.default" ).hide();
        }else if($("#ntable").contents().find("input:checkbox:checked").length == 0){//0 checked, hide action panel
            $( ".panel-body.selected,.panel-title.selected" ).hide();
            $( ".panel-body.default" ).show();
            $( ".panel-title.default" ).addClass("fadeInUp").show();
        } else{//uncheck select all
            $("#ntable").contents().find("input:checkbox[name='selectall']").prop('checked', val);
            if($("#ntable").contents().find("input:checkbox:checked").length == 0){
                $( ".panel-body.selected,.panel-title.selected" ).hide();
                $( ".panel-body.default" ).show(); 
                $( ".panel-title.default" ).addClass("fadeInUp").show();
            }
        }
    })
});

//https://jsfiddle.net/terryyounghk/kpegu/
function exportTableToCSV($table, filename) {

    var $rows = $table.find('tr:has(input:checkbox:checked)'),

        // Temporary delimiter characters unlikely to be typed by keyboard
        // This is to avoid accidentally splitting the actual contents
        tmpColDelim = String.fromCharCode(11), // vertical tab character
        tmpRowDelim = String.fromCharCode(0), // null character

        // actual delimiter characters for CSV format
        colDelim = '","',
        rowDelim = '"\r\n"',

        // Grab text from table into CSV formatted string
        csv = '"' + $rows.map(function (i, row) {
            var $row = $(row),
                $cols = $row.find('td');

            return $cols.map(function (j, col) {
                var $col = $(col),
                    text = $col.text();
                return text.replace(/"/g, '""'); // escape double quotes
            }).get().join(tmpColDelim);

        }).get().join(tmpRowDelim)
            .split(tmpRowDelim).join(rowDelim)
            .split(tmpColDelim).join(colDelim) + '"',

        // Data URI
        csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv.replace(/"",/g, '').replace(/""/g, '').replace(/(\r\n|\n|\r)/m,""));//get rid of useless stuff

    $(this)
        .attr({
        'download': filename,
            'href': csvData,
            'target': '_blank'
    });
}