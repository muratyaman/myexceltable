/**
 * JavaScript file for index.php
 */


;(function ($, window, document, undefined){
    
    var disableEntry = function() {
        //console.log('disableEntry');
        $('input#fx_cell').attr('disabled', 'disabled');//disable it
        $('button#btn_ok').attr('disabled', 'disabled');//disable it
        $('button#btn_cancel').attr('disabled', 'disabled');//disable it
    };
    
    var enableEntry = function() {
        //console.log('enableEntry');
        $('input#fx_cell').removeAttr('disabled');//enable it
        $('button#btn_ok').removeAttr('disabled');//enable it
        $('button#btn_cancel').removeAttr('disabled');//enable it
    };
    
    $('input.mycell').click(function(ev) {
        //console.log('input.mycell.click');
        
        var r = $(this).data('row');
        $('input#current_row').val(r);
        
        var c = $(this).data('column');
        $('input#current_column').val(c);
        
        var formula_id = '#formula_' + r + '_' + c;
        var formula = $(formula_id).val();
        $('input#fx_cell').val(formula);
        
        $currentCell = $('input.mycell.current');
        if ($currentCell && $currentCell.data('row') != r && $currentCell.data('column') != c) {//clicked on a different cell
            $currentCell.removeClass('current');
            $(this).addClass('current');
        }
        
        enableEntry();//important before focusing on it
        
        $('input#fx_cell').focus();
        
        //we can also do it natively
        //document.frmTable.fx_cell.focus();
        
    });
    
    $('input#fx_cell').keyup(function(ev) {
        //console.log('input#fx_cell.keyup');
        var code = ev.which; // recommended to use e.which, it's normalized across browsers
        if (code == 13) {//enter key
            ev.preventDefault();
            $(this).blur();
            $('button#btn_ok').click();
        }
    });
    
    $('#frmTable').submit(function(ev) {
        //console.log('#frmTable.submit');
        $('div#mymessages').html('Calculating..');
        
        //stop the browser from actually submitting the form
        ev.preventDefault();
        
        var url = $('#frmTable').attr('action');
        
        //serialize the form data.
        var formData = $('#frmTable').serialize();
        
        $.post(url, formData, function(response){
            //console.log('reply', response);
            $('div#mymessages').html('Ready');
            
            if ( response.error === '' ) {
                //console.log('success');
                var data = response.data;
                //var formulae = response.formulae;
                var r, c, row, val, data_id;
                for (r in data) {
                    //console.log('row:' + r);
                    row = data[r];
                    for (c in row) {
                        //console.log('cell('+r+','+c+'): ' + row[c]);
                        val = row[c];
                        data_id = '#data_' + r + '_' + c;
                        $(data_id).val(val);
                    }
                }
            } else {
                $('div#mymessages').html(response.error);
            }
        }, 'json');

    });
    
    var reset = function (){
        //console.log('reset');
        $('input.mycell.current').removeClass('current');
        $('input#current_row').val('');
        $('input#current_column').val('');
        $('#fx_cell').val('');
    };
    
    $('button#btn_ok').click(function(ev){
        //console.log('btn_ok.click');
        
        var formula = $('#fx_cell').val();
        
        var r = $('input#current_row').val();
        var c = $('input#current_column').val();
        //var data_id = '#data_' + r + '_' + c;
        var formula_id = '#formula_' + r + '_' + c;
        
        $(formula_id).val(formula);
        
        $('#frmTable').submit();
        
        reset();
        disableEntry();
    });
    
    $('button#btn_cancel').click(function(ev){
        //console.log('btn_cancel.click');
        
        reset();
        disableEntry();
        
    });
    
    disableEntry();//wait until user clicks on a cell
    
})(jQuery, window, document);