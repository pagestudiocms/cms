$(document).ready( function() {
    var grid_ckeditor_config = { 
        toolbar : [
            { name: 'basicstyles', items : [ 'Undo','Redo'] },
            { name: 'styles', items : [ 'Format' ] },
            { name: 'paragraph', items : [ 'Bold','Italic','Underline','Strike','NumberedList','BulletedList','-','Blockquote','- ','JustifyLeft','JustifyCenter','JustifyRight' ] },
            // '/',
            { name: 'links', items : [ 'Link','Unlink','Anchor', 'imagebrowser' ] },
            { name: 'insert', items : [ 'HorizontalRule', 'ShowBlocks', '-', 'Source', '-', 'Maximize' ] }
        ],
        entities : true,
        // height : '150px',
        resize_enabled : false,
        removePlugins : 'elementspath'
    };

    $('textarea.ckeditor_grid_textarea').each(function(index) {
        grid_ckeditor_config.height = $(this).attr('height');                
        var textarea_id = $(this).attr('id');
        if( ! CKEDITOR.instances[textarea_id]) {
            CKEDITOR.replace(textarea_id, grid_ckeditor_config);
        }
    });
});