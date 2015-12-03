/**
 * Builds additional rows rynamically
 *
 * @source      http://stackoverflow.com/questions/16200104/jquery-add-and-remove-table-rows
 * @author      Cosmo Mathieu <cosmo@cosmointeractive.co>
 */
$(document).ready(function(){
    var counter = 2;
    
    $('#field_id_30 table.matrix tbody').sortable({
        axis: 'y',
        placeholder: "ui-state-highlight",
        update: function (event, ui) {
            var data = $(this).sortable('serialize');
            // POST to server using $.post or $.ajax
            // $.ajax({
                // data: data,
                // type: 'POST',
                // url: '/your/url/here'
            // });
        }
    });

    $("#addrow").on("click", function(){

        // counter    = $('#field_id_30 table.matrix tr').length - 2;
        var newRow = $("<tr class=\"matrix\" id=\"tbl_row_"+ counter +"\">");
        var cols   = "";
        
        cols += 
        '<th class="matrix matrix-first matrix-tr-header">' +
        '    <div>' +
        '        <span>'+ counter +'</span><a class="delRow" style="display: inline; opacity: 1;" title="Options"></a>' +
        '    </div>' +
        '    <input name="field_id_30[row_order][]" value="row_new_1" type="hidden">' +
        '</th>' +
        '<td style="width: auto;" class="matrix matrix-firstcell">' +
        '    <select name="field_id_30[row_new_1][col_id_33]">' +
        '        <option value="icon-location-1">Location</option>' +
        '    </select>' +
        '</td>' +
        '<td style="width: auto;" class="matrix matrix-text">' +
        '    <textarea style="overflow: hidden; height: 14px;" class="matrix-textarea" name="field_id_30[row_new_1][col_id_34]" rows="1" dir="ltr"></textarea>' +
        '    <div class="matrix-charsleft-container"><div class="matrix-charsleft">140</div></div>' +
        '</td>' +
        '<td style="width: auto;" class="matrix matrix-last matrix-text">' +
        '    <textarea style="overflow: hidden; height: 14px;" class="matrix-textarea" name="field_id_30[row_new_1][col_id_35]" rows="1" dir="ltr"></textarea>' +
        '</td>';
        newRow.append(cols);
        
        if (counter === 4) {
            $('#addrow').click(function(e){
                e.preventDefault();
            });
            $('#addrow').removeAttr('href');
            $('#addrow').hide();
        }
        $("table.order-list").append(newRow);
        
        counter++;
    });

    $("table.order-list").on("click", ".delRow", function(event){
        if (confirm('Are you sure you want to delete this?')) {
            $(this).closest("tr").remove();
            counter -= 1
            $('#addrow').attr('disabled', false).prop('value', "Add Row");
        }
    });

});
