<div>
    <label for="type">Allow Inline Editing:</label>
    <span>
        <label><?php echo form_radio(array('name'  => 'settings[inline_editing]', 'value' => '1', 'checked' => set_radio('settings[inline_editing]', '1', ( ! isset($Field->settings['inline_editing']) || $Field->settings['inline_editing']) ? TRUE : FALSE))); ?>Yes</label>
        <label><?php echo form_radio(array('name'  => 'settings[inline_editing]', 'value' => '0', 'checked' => set_radio('settings[inline_editing]', '0', (isset($Field->settings['inline_editing']) && ! $Field->settings['inline_editing']) ? TRUE : FALSE))); ?>No</label>
    </span>
</div>

<div>
    <label for="type">Output Type:</label>
    <?php echo form_dropdown(
        'settings[output]', 
        array('image'  => 'Image', 'text_field' => 'Text Field',), 
        set_value('settings[output]', 
        ( ! empty($Field->settings['output'])) ? $Field->settings['output'] : ''), 
        'id="output_type"'
    ); ?>
</div>

<div class="grid_setting">
    <label for="type">Max Rows:</label>
    <?php echo form_input(array(
        'name'  => 'settings[max_rows]', 
        'style' => 'width: 50px',
        'value' => set_value('settings[max_rows]', ( ! empty($Field->settings['max_rows'])) ? $Field->settings['max_rows'] : '')
    )); ?>
</div>

<script type="text/javascript">
    $(document).ready( function() {
        $('#output_type').change( function() {
            if ($(this).val() == 'image') {
                $('.grid_setting').show();
            } else {
                $('.grid_setting').hide();
            }
        });

        $('#output_type').trigger('change');
    });
</script>