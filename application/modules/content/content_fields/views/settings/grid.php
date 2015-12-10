<div>
    <label for="type">Allow Inline Editing:</label>
    <span>
        <label><?php echo form_radio(array('name'  => 'settings[inline_editing]', 'value' => '1', 'checked' => set_radio('settings[inline_editing]', '1', ( ! isset($Field->settings['inline_editing']) || $Field->settings['inline_editing']) ? TRUE : FALSE))); ?>Yes</label>
        <label><?php echo form_radio(array('name'  => 'settings[inline_editing]', 'value' => '0', 'checked' => set_radio('settings[inline_editing]', '0', (isset($Field->settings['inline_editing']) && ! $Field->settings['inline_editing']) ? TRUE : FALSE))); ?>No</label>
    </span>
</div>

<div>
    <label for="type">Max Rows:</label>
    <?php echo form_input(array(
        'name'  => 'settings[max_rows]', 
        'style' => 'width: 50px',
        'value' => set_value('settings[max_rows]', ( ! empty($Field->settings['max_rows'])) ? $Field->settings['max_rows'] : '')
    )); ?>
</div>