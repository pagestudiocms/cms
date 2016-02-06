<div class="grid_settings" style="">
    <div class="grid_col_item js_grid_col_item">
        <div>
            <label for="type">Field Type</label>
            <?php echo form_dropdown(
                'grid_cols[field_1][content_field_type_id]', 
                array('' => '', 'dropdown' => 'Dropdown', 'image'  => 'Image', 'rich_text' => 'Rich Text', 'text_field' => 'Text Field', 'textarea' => 'Textarea',), 
                set_value('grid_cols[field_1][content_field_type_id]', 
                    ( ! empty($Field->grid_cols['content_field_type_id'])) ? $Field->grid_cols['content_field_type_id'] : ''
                ), 
                'id="grid_col_type"'
            ); ?>
        </div>

        <div>
            <label for="grid_col_label"><span class="required">*</span> Field Label </label>
            <?php echo form_input(array(
                'name'=>'grid_cols[field_1][label]', 'id'=>'grid_col_label', 'class'=>'js_grid_col_label',
                'value'=>set_value('grid_cols[field_1][label]', '')
            )); ?>
        </div>

        <div>
            <label for="grid_col_tag"><span class="required">*</span> Short Tag</label>
            <?php echo form_input(array(
                'name'=>'grid_cols[field_1][grid_col_tag]', 'id'=>'grid_col_tag', 'class'=>'js_grid_col_tag', 
                'value'=>set_value('grid_cols[field_1][grid_col_tag]', '')
            )); ?>
        </div>
        
        <div>
            <label for="type">Required? </label>
            <span>
                <label><?php echo form_radio(array('name'  => 'grid_cols[field_1][required]', 'value' => '1', 'checked' => set_radio('grid_cols[field_1][required]', '1', FALSE))); ?>Yes</label>
                <label><?php echo form_radio(array('name'  => 'grid_cols[field_1][required]', 'value' => '0', 'checked' => set_radio('grid_cols[field_1][required]', '0', TRUE))); ?>No</label>
            </span>
        </div>
        
        <div>
            <label for="type">Allow Search? </label>
            <span>
                <label><?php echo form_radio(array('name'  => 'grid_cols[field_1][is_searchable]', 'value' => '1', 'checked' => set_radio('grid_cols[field_1][is_searchable]', '1', FALSE))); ?>Yes</label>
                <label><?php echo form_radio(array('name'  => 'grid_cols[field_1][is_searchable]', 'value' => '0', 'checked' => set_radio('grid_cols[field_1][is_searchable]', '0', TRUE))); ?>No</label>
            </span>
        </div>
        
        <div class="actions">
            <a class="matrix-btn matrix-add clone" title="Add row"></a>
            <a class="matrix-btn matrix-remove remove" title="Remove row"></a>
        </div>
        
    </div>
    
    <div class="js_dynamic_fields_placeholder" style="border:none;margin:0;padding:0;"></div>
    
</div>


<script type="text/javascript">
    $(document).ready( function() {
        // Auto Generate Url Title
        $(this).on('keyup', '.js_grid_col_label', function(e){
            $(this).closest('div').next('div').find('input:text').val(
                $(this).val().toLowerCase().replace(/\s+/g, '_').replace(/[^a-z0-9\-_]/g, '')
            );
        });
        
        // Hide and show field options
        $('#content_field_type').change( function() {
            if ($(this).val() == 'image') {
                $('.grid_image_setting').show();
            } else {
                $('.grid_image_setting').hide();
            }
        });
        $('#content_field_type').trigger('change');
        
        // ------------------------------------------------------
        // Clone grid fields 
        // ------------------------------------------------------
        var regex = /^(.+?)(\d+)$/i;
        var cloneIndex = $(".js_grid_col_item").length;
        cloneIndex = cloneIndex + 1;

        function clone(){
            $(this).parents(".js_grid_col_item").clone()
                .appendTo(".js_dynamic_fields_placeholder")
                .attr("id", "js_grid_col_item" +  cloneIndex)
                .find("*")
                .each(function() {
                    var id = this.id || "";
                    var match = id.match(regex) || [];
                    if (match.length == 3) {
                        this.id = match[1] + (cloneIndex);
                    }
                })
                .find('select').each(function(){
                    this.name = this.name.replace(/\[field_(\d+)\]/,
                        function(str, p1){
                            return '[field_' + (parseInt(p1,10)+1) + ']'
                        }
                    );
                })
                .end()
                .find('input').each(function(){
                    this.name = this.name.replace(/\[field_(\d+)\]/,
                        function(str, p1){
                            return '[field_' + (parseInt(p1,10)+1) + ']'
                        }
                    );
                })
                .end()
                .on('click', 'a.clone', clone)
                .on('click', 'a.remove', remove);
            cloneIndex++;
        }
        function remove(){
            $(this).parents(".js_grid_col_item").remove();
        }
        $("a.clone").on("click", clone);
        $("a.remove").on("click", remove);
    });
</script>