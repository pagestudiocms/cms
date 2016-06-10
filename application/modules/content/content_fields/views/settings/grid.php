<div class="grid_settings" style="">
    <?php
    if( ! empty($Field->child_fields)){
        $field_count = 1;
        // Print child fields 
        foreach($Field->child_fields as $key => $field) { 
        ?>
            <div class="grid_col_item js_grid_col_item">
                <div class="grid-heading">
                    Child Field
                </div>
                <div style="display:none;">
                    <?php echo form_input(['name' => 'grid_cols[field_'.$field_count.'][id]', 'value' => $field->id]); ?>
                </div>
                <div>
                    <label for="type">Field Type</label>
                    <?php echo form_dropdown(
                        'grid_cols[field_'.$field_count.'][content_field_type_id]', 
                        array('' => '', '4' => 'Dropdown', '9'  => 'File', '8'  => 'Image', '1' => 'Rich Text', '3' => 'Text Field', '6' => 'Textarea',), 
                        set_value('grid_cols[field_'.$field_count.'][content_field_type_id]', 
                            ( ! empty($field->content_field_type_id)) ? $field->content_field_type_id : ''
                        ), 
                        'id="grid_col_type"'
                    ); ?>
                </div>

                <div>
                    <label for="grid_col_label"><span class="required">*</span> Field Label </label>
                    <?php echo form_input(array(
                        'name'=>'grid_cols[field_'.$field_count.'][label]', 'id'=>'grid_col_label', 'class'=>'js_grid_col_label',
                        'value'=>set_value('grid_cols[field_'.$field_count.'][label]', ( ! empty($field->label)) ? $field->label : '')
                    )); ?>
                </div>

                <div>
                    <label for="short_tag"><span class="required">*</span> Short Tag</label>
                    <?php echo form_input(array(
                        'name'=>'grid_cols[field_'.$field_count.'][short_tag]', 'id'=>'short_tag', 'class'=>'js_short_tag', 
                        'value'=>set_value('grid_cols[field_'.$field_count.'][short_tag]', ( ! empty($field->short_tag)) ? $field->short_tag : '')
                    )); ?>
                </div>
                
                <div>
                    <label for="type">Required? </label>
                    <span>
                        <label><?php echo form_radio(array('name'  => 'grid_cols[field_'.$field_count.'][required]', 'value' => '1', 'checked' => ($field->required) ? TRUE : FALSE)); ?>Yes</label>
                        <label><?php echo form_radio(array('name'  => 'grid_cols[field_'.$field_count.'][required]', 'value' => '0', 'checked' => ( ! $field->required) ? TRUE : FALSE)); ?>No</label>
                    </span>
                </div>
                
                <div>
                    <label for="type">Allow Search? </label>
                    <span>
                        <label><?php echo form_radio(array('name'  => 'grid_cols[field_'.$field_count.'][is_searchable]', 'value' => 'y', 'checked' => ($field->is_searchable && $field->is_searchable === 'y') ? TRUE : FALSE)); ?>Yes</label>
                        <label><?php echo form_radio(array('name'  => 'grid_cols[field_'.$field_count.'][is_searchable]', 'value' => 'n', 'checked' => ($field->is_searchable && $field->is_searchable === 'n') ? TRUE : FALSE)); ?>No</label>
                    </span>
                </div>
                
                 <div>
                    <label for="type">Options</label>
                    <span>
                        <?php 
                        echo form_textarea(array(
                            'name' => 'grid_cols[field_'.$field_count.'][options]', 
                            'value'=>set_value('grid_cols[field_'.$field_count.'][options]', unserialize($field->options)),
                            'rows' => 5,
                        )); 
                        ?>
                    </span>
                </div>
                
                <div class="action">
                    <a class="matrix-btn matrix-add clone" title="Add row"></a>
                    <a class="matrix-btn matrix-remove remove" title="Remove row"></a>
                </div>
            </div>
    <?php 
        $field_count++;
        }
    } else { ?>
    <div class="grid_col_item js_grid_col_item">
        <div>
            <label for="type">Field Type</label>
            <?php echo form_dropdown(
                'grid_cols[field_1][content_field_type_id]', 
                array('' => '', '4' => 'Dropdown', '9'  => 'File', '8'  => 'Image', '1' => 'Rich Text', '3' => 'Text Field', '6' => 'Textarea',), 
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
            <label for="short_tag"><span class="required">*</span> Short Tag</label>
            <?php echo form_input(array(
                'name'=>'grid_cols[field_1][short_tag]', 'id'=>'short_tag', 'class'=>'js_short_tag', 
                'value'=>set_value('grid_cols[field_1][short_tag]', '')
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
                <label><?php echo form_radio(array('name'  => 'grid_cols[field_1][is_searchable]', 'value' => 'y', 'checked' => set_radio('grid_cols[field_1][is_searchable]', 'y', FALSE))); ?>Yes</label>
                <label><?php echo form_radio(array('name'  => 'grid_cols[field_1][is_searchable]', 'value' => 'n', 'checked' => set_radio('grid_cols[field_1][is_searchable]', 'n', TRUE))); ?>No</label>
            </span>
        </div>
        
        <div>
            <label for="type">Options</label>
            <span>
                <?php 
                echo form_textarea(array(
                    'name' => 'grid_cols[field_1][options]', 
                    'rows' => 5,
                )); 
                ?>
            </span>
        </div>
        
        <div class="action">
            <a class="matrix-btn matrix-add clone" title="Add row"></a>
            <a class="matrix-btn matrix-remove remove" title="Remove row"></a>
        </div>
    </div>
    <?php 
    }
    ?>
    
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
                .attr("id", "js_grid_col_item" + cloneIndex)
                .find("*").each(function() {
                    var id = this.id || "";
                    var match = id.match(regex) || [];
                    if (match.length == 3) {
                        this.id = match[1] + (cloneIndex);
                    }
                })
                .find('input, select, textarea').each(function(i){
                    this.name = this.name.replace(/\[field_(\d+)\]/,
                        function(str, p1){
                            return '[field_' + (parseInt(p1,10)+1) + ']'
                        }
                    );
                    if(i == 0){
                        this.value = "";
                    }
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